<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonalResource;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personal = Personal::jsonPaginate();
        return PersonalResource::collection($personal);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'last_name' => 'required',
            'identification_number' => 'required|unique:personals',
            'code' => 'required|unique:personals',
            'date_of_birth' => 'required',
            'email' => 'required|unique:personals',
            'charge' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all(), 'status' => false, 'message' => 'Error de validacion']);
        }

        $personal =  Personal::create($input);

        return Response::json([
            'data' => $personal->toArray(), 
            'message' => 'Personal guardado', 
            'status' => true
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function show(Personal $personal)
    {   
        if(empty($personal)){
            return response()->json(['erros' => 'Personal no encontrado', 'status' => false], 404);
        }

        return PersonalResource::make($personal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Personal $personal)
    {
        $input = $request->all();

        if (empty($personal)) {
            return response()->json(['erros' => 'Personal no encontrado', 'status' => false], 404);
        }

        $validator = Validator::make($input, [
            'name' => 'required',
            'last_name' => 'required',
            'identification_number' => [
                'required',
                Rule::unique('personals')->ignore($personal->id),
            ],
            'code' => [
                'required',
                Rule::unique('personals')->ignore($personal->id),
            ],
            'date_of_birth' => 'required',
            'email' => [
                'required',
                Rule::unique('personals')->ignore($personal->id),
            ],
            'charge' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all(), 'status' => false, 'message' => 'Error de validacion']);
        }

        $personal->fill($input);
        $personal->save();

        return Response::json([
            'data' => PersonalResource::make($personal), 
            'message' => 'Personal modificado',
            'status' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personal $personal)
    {
        if (empty($personal)) {
            return response()->json(['erros' => 'Personal no encontrado', 'status' => false], 404);
        }

        if($personal->delete()){
            return Response::json([
                'message' => 'Personal eliminado',
                'status' => true
            ]);
        }

        return Response::json([
            'message' => 'Personal no se elimino',
            'status' => false
        ]);
    }
}
