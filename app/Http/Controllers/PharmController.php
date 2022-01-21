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
        $pharms = Pharm::all();
        return response()->json([
            'status' => true,
            'message' => [],
            'result' => $pharms
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
            'guide' => 'required',
            'usage' => 'required',
            'keeping' => 'required',
            'need_dr' => 'required|boolean',
            'cat_id' => 'integer|required',
        ]);
        if (!$val->fails()) {
            $pharm = new Pharm();
            $pharm->fill($request->all());
            $pharm->save();
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => $pharm
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
        if (!$val->fails()) {
            $pharm = Pharm::find($id);
            if ($pharm == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['pharm not found'],
                    'result' => []
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => $pharm
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
            'guide' => 'required',
            'usage' => 'required',
            'keeping' => 'required',
            'need_dr' => 'required|boolean',
            'cat_id' => 'integer|required',
        ]);
        if(!$val->fails()) {
            $pharm = Pharm::find($id);
            if ($pharm == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['pharm not found'],
                    'result' => []
                ]);
            }

            $pharm->update($request->all());
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => $pharm
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
            $res = Pharm::destroy($id);
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => [$res]
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
