<?php

namespace App\Http\Controllers;

use App\Models\Med;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $med = Med::all();
        return response()->json(['med' => $med]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $val = validator($request->all(), [
           'exp_date' => 'date'
        ]);

        if (!$val->fails()){
            $med = new Med();
            $med->fill($request->all());
            $med->save();
            return response()->json(['med' => $med]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $med = Med::find($id);
        $pharm = $med->pharm()->get();
        return response()->json(['med' => $med, 'pharm' => $pharm]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $med = Med::find($id);
        $med->update($request->all());
        return response()->json(['med' => $med]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $res = Med::destroy($id);
        return response()->json(['result' => $res]);
    }
}
