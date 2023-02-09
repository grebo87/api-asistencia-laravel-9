<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbsenceResoruce;
use App\Models\Absence;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AbsenceController extends Controller
{
    
    public function verifyAbsenceByPersonalId($personalId){
        $personal = Personal::find($personalId);

        if (empty($personal)) {
            return response()->json(['erros' => 'Personal no encontrado', 'status' => false], 404);
        }

        $absence = Absence::whereDate('date', now()->toDateString())
            ->where('personal_id', $personal->id)
            ->first();
        
        if(empty($absence)){
            return response()->json([ 
                'data' => [ 
                    'verify' => false 
                ], 
                'message' => 'El personal no tiene registrada una inasistencia para el día', 
                'status' => false
            ]);
        }

        return response()->json([ 
            'data' => [ 
                'verify' => true 
            ], 
            'message' => 'El personal ya tiene registrada una inasistencia para el día', 
            'status' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function getAbsenceByPersonalId($personalId) {
        $personal = Personal::find($personalId);

        if (empty($personal)) {
            return response()->json(['erros' => 'Personal no encontrado', 'status' => false], 404);
        }

        $absence = Absence::whereDate('date', now()->toDateString())
            ->where('personal_id', $personal->id)
            ->first();

        return AbsenceResoruce::make($absence);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($personalId, Request $request)
    {
        $personal = Personal::find($personalId);

        if (empty($personal)) {
            return response()->json(['erros' => 'Personal no encontrado', 'status' => false], 404);
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'type' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all(), 'status' => false, 'message' => 'Error de validacion']);
        }

        $absence = Absence::create([
            'date' => now()->toDateString(),
            'type' => $input['type'],
            'observation' => isset($input['observation']) ? $input['observation'] : null,
            'personal_id' => $personal->id
        ]);

        return response()->json([
            'data' => AbsenceResoruce::make($absence), 
            'message' => 'Inasistencia registrada',
            'status' => true
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function show(Absence $absence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function update($personalId, Request $request)
    {
        $personal = Personal::find($personalId);

        if (empty($personal)) {
            return response()->json(['erros' => 'Personal no encontrado', 'status' => false], 404);
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'type' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all(), 'status' => false, 'message' => 'Error de validacion']);
        }

        $absence = $personal->dayAbsence();

        $absence->fill($input);
        $absence->save();

        return response()->json([
            'data' => AbsenceResoruce::make($absence), 
            'message' => 'Inasistencia registrada',
            'status' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function destroy($personalId)
    {
        $personal = Personal::find($personalId);
        if (empty($personal)) {
            return response()->json(['erros' => 'Personal no encontrado', 'status' => false], 404);
        }

        $absence = $personal->dayAbsence();

        if(empty($absence)){
            return response()->json([
                'message' => 'El personal no posee inasistencia',
                'status' => false
            ]);
        }

        if($absence->delete()){
            return response()->json([
                'message' => 'Inasistencia eliminada',
                'status' => true
            ]);
        }

        return response()->json([
            'message' => 'La Inasistencia no se elimino',
            'status' => false
        ]);
    }
}
