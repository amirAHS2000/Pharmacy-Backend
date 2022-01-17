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
        $comps = Comp::all();
        return response()->json([
            'status' => true,
            'message' => [],
            'result' => $comps
        ]);
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
            'name' => 'required',
            'country' => 'required'
        ]);
        if(!$val->fails()) {
            $comp = new Comp();
            $comp->fill($request->all());
            $comp->save();
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => $comp
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => [$val->errors()],
                'result' => []
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $val = validator(['id' => $id], [
            'id' => 'required|integer',
        ]);
        if(!$val->fails()) {
            $comp = Comp::find($id);
            if ($comp == null){
                return response()->json([
                    'status' => false,
                    'message' => ['company not found'],
                    'result' => []
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => $comp
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => [$val->errors()],
                'result' => []
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $val = validator(array_merge($request->all(), ['id' => $id]), [
            'id' => 'required|integer',
            'name' => 'required',
            'country' => 'required'
        ]);
        if(!$val->fails()) {
            $comp = Comp::find($id);
            if ($comp == null){
                return response()->json([
                    'status' => false,
                    'message' => ['company not found'],
                    'result' => []
                ]);
            }
            $comp->update($request->all());
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => $comp
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => [$val->errors()],
                'result' => []
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $val = validator(['id' => $id], [
            'id' => 'required|integer',
        ]);
        if(!$val->fails()) {
            $res = Comp::destroy($id);
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => $res
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => [$val->errors()],
                'result' => []
            ]);
        }
    }
}
