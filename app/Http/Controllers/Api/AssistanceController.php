<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssistanceResource;
use App\Models\Assistance;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AssistanceController extends Controller
{
    public function getStaffDayAttendance($personalId)
    {
        $personal = Personal::find($personalId);

        if (empty($personal)) {
            return response()->json(['erros' => 'Personal no encontrado', 'status' => false], 404);
        }

        $assistance = Assistance::whereDate('date', now()->toDateString())
            ->where('personal_id', $personal->id)
            ->first();

        return AssistanceResource::make($assistance);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function markStartTime(Request $request, $personalId)
    {
        $personal = Personal::find($personalId);

        if (empty($personal)) {
            return response()->json(['erros' => 'Personal no encontrado', 'status' => false], 404);
        }

        $count = Assistance::whereDate('date', now()->toDateString())
            ->where('personal_id', $personal->id)
            ->whereNotNull('start_time')
            ->count();

        if ($count > 0) {
            return response()->json(['errors' => null, 'status' => false, 'message' => "El personal {$personal->name} {$personal->last_name} ya registro su entrada del día"]);
        }

        $assistance = Assistance::create([
            'date' => now()->toDateString(),
            'start_time' => now()->toDateTimeString(),
            'time_of' => null,
            'personal_id' => $personal->id,
        ]);

        return response()->json([
            'data' => AssistanceResource::make($assistance),
            'message' => 'Entrada guardada',
            'status' => true
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assistance  $assistance
     * @return \Illuminate\Http\Response
     */
    public function markTimeOf(Request $request, $personalId)
    {
        $personal = Personal::find($personalId);

        if (empty($personal)) {
            return response()->json(['erros' => 'Personal no encontrado', 'status' => false], 404);
        }

        $assistance = Assistance::whereDate('date', now()->toDateString())
            ->where('personal_id', $personal->id)
            ->whereNotNull('start_time')
            ->first();

        if (empty($assistance)) {
            return response()->json(['errors' => null, 'status' => false, 'message' => "El personal {$personal->name} {$personal->last_name} no ha registro su entrada del día"]);
        }

        $assistance->time_of = now()->toDateTimeString();
        
        if($assistance->save()){
            return response()->json([
                'data' => AssistanceResource::make($assistance),
                'message' => 'Salida guardada',
                'status' => true
            ]);
        }

        return response()->json([
            'errors' => null,
            'message' => 'La Salida no se guardo',
            'status' => false
        ]);
    }
}
