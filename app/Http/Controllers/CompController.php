<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $comp = Comp::all();
        return response()->json(['com' => $comp]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $comp = new Comp();
        $comp->fill($request->all());
        $comp->save();
        return response()->json(['com' => $comp]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $comp = Comp::find($id);
        $med = $comp->med()->get();
        return response()->json(['com' => $comp, 'med' => $med]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $comp = Comp::find($id);
        $comp->update($request->all());
        return response()->json(['com' => $comp]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $res = Comp::destroy($id);
        return response()->json(['result' => $res]);
    }
}
