<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Pajak;
use App\Http\Resources\PajakResource;

class PajakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Pajak::latest()->get();
        return response()->json([PajakResource::collection($data), 'Pajak fetched.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required|string|max:255',
            'rate' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $pajak = Pajak::create([
            'nama' => $request->nama,
            'rate' => $request->rate
         ]);
        
        return response()->json(['Pajak created successfully.', new PajakResource($pajak)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pajak = Pajak::find($id);
        if (is_null($pajak)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new PajakResource($pajak)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pajak $pajak)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required|string|max:255',
            'rate' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $pajak->nama = $request->nama;
        $pajak->rate = $request->rate;
        $pajak->save();
        
        return response()->json(['Pajak updated successfully.', new PajakResource($pajak)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pajak $pajak)
    {
        $pajak->delete();

        return response()->json('Pajak deleted successfully');
    }
}