<?php

namespace App\Http\Controllers;

use App\Models\Pharm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PharmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $pharm = Pharm::all();
        return response()->json(['pharm' => $pharm]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $pharm = new Pharm();
        $pharm->fill($request->all());
        $pharm->save();
        return response()->json(['pharm' => $pharm]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $pharm = Pharm::find($id);
        $med = $pharm->med()->get();
        $sim = $pharm->sim();
        return response()->json(['pharm' => $pharm, 'med' => $med, 'sim' => $sim]);
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
        $pharm = Pharm::find($id);
        $pharm->update($request->all());
        return response()->json(['pharm' => $pharm]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $res = Pharm::destroy($id);
        return response()->json(['result' => $res]);
    }
}
