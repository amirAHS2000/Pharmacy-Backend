<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $pat = Patient::all();
        return response()->json(['patient' => $pat]);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'nat_num' => 'required',
            'phone' => 'required',
            'ins_num' => 'numeric|nullable',
            'ins_id' => 'numeric|nullable',
        ]);
        if (!$val->fails()) {
            $pat = new Patient();
            $pat->fill($request->all());
            $pat->save();
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => ['patient' => $pat]
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
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $val = validator($id, [
            'id' => 'required|numeric'
        ]);
        if (!$val->fails()) {
            $pat = Patient::find($id);
            $ins = $pat->ins()->get();
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => ['patient' => $pat, 'ins' => $ins]
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
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $pat = Patient::find($id);
        $pat->update($request->all());
        return response()->json(['patient' => $pat]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $res = Patient::destroy($id);
        return response()->json(['result' => $res]);
    }
}
