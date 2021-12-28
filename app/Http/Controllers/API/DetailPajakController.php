<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\DetailPajak;
use App\Http\Resources\DetailPajakResource;

class DetailPajakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = DetailPajak::latest()->get();
        // return response()->json([DetailPajakResource::collection($data), 'DetailPajaks fetched.']);
        $detailpajak = DetailPajak::with('item','pajak')->get();
        return response()->json($detailpajak,200);
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
            'idpajak' => 'required',
            'iditem' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $detailpajak = DetailPajak::create([
            'idpajak' => $request->idpajak,
            'iditem' => $request->iditem
         ]);
        
        return response()->json(['DetailPajak created successfully.', new DetailPajakResource($detailpajak)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detailpajak = DetailPajak::find($id);
        if (is_null($detailpajak)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new DetailPajakResource($detailpajak)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailPajak $detailpajak)
    {
        $validator = Validator::make($request->all(),[
            'idpajak' => 'required',
            'iditem' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $detailpajak->idpajak = $request->idpajak;
        $detailpajak->iditem = $request->iditem;
        $detailpajak->save();
        
        return response()->json(['DetailPajak updated successfully.', new DetailPajakResource($detailpajak)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailPajak $detailpajak)
    {
        $detailpajak->delete();

        return response()->json('DetailPajak deleted successfully');
    }

}