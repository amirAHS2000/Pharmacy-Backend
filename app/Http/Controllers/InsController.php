<?php

namespace App\Http\Controllers;

use App\Models\Ins;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $ins = Ins::all();
        return response()->json(['ins' => $ins]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $ins = new Ins();
        $ins->fill($request->all());
        $ins->save();
        return response()->json(['' => $ins]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $ins = Ins::find($id);
        $pat = $ins->patients()->get();
        return response()->json(['ins' => $ins, 'patients' => $pat]);
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
        $ins = Ins::find($id);
        $ins->update($request->all());
        return response()->json(['ins' => $ins]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $res = Ins::destroy($id);
        return response()->json(['result' => $res]);
    }
}
