<?php

namespace App\Http\Controllers;

use App\Globals\FileHandler;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $emps = Employee::all()->where('role', '=', 'employee');
        $res = [];
        foreach ($emps as $emp){
            $image = FileHandler::getFile($emp->profile_img_path, env('image_base_path'));
            array_push($res, ['employee' => $emp, 'profile_image' => $image]);
        }
        return response()->json([
            'status' => true,
            'message' => [],
            'result' => [$res]
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'nat_num' => 'required',
            'birthday' => 'required|date',
            'degree' => 'required',
            'job' => 'required',
            'address' => 'required',
        ]);
        if (!$val->fails()) {
            $imgPath = null;
            if ($request['image'] != null) {
                $imgPath = FileHandler::uploadFile($request['image'], 'emp', env('image_base_path'));
            }
            $emp = new Employee();
            $emp->fill([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'phone' => $request['phone'],
                'nat_num' => $request['nat_num'],
                'gender' => $request['gender'],
                'birthday' => $request['birthday'],
                'degree' => $request['degree'],
                'job' => $request['job'],
                'address' => $request['address'],
                'role' => 'employee',
                'profile_img_path' => $imgPath
            ]);
            $emp->save();
            $image = FileHandler::getFile($emp->profile_img_path, env('image_base_path'));
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => ['emp' => $emp, 'image' => $image]
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
            $emp = Employee::find($id);
            if ($emp == null || $emp->role != 'employee') {
                return response()->json([
                    'status' => false,
                    'message' => ['Employee not found'],
                    'result' => []
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => $emp
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'nat_num' => 'required',
            'birthday' => 'required|date',
            'degree' => 'required',
            'job' => 'required',
            'address' => 'required',
        ]);
        if(!$val->fails()) {
            $emp = Employee::find($id);
            if ($emp == null || $emp->role != 'employee') {
                return response()->json([
                    'status' => false,
                    'message' => ['Employee not found'],
                    'result' => []
                ]);
            }
            $imgPath = null;
            if ($request['image'] != null) {
                $imgPath = FileHandler::uploadFile($request['image'], 'emp', env('image_base_path'));
            }
            $emp->update([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'phone' => $request['phone'],
                'nat_num' => $request['nat_num'],
                'gender' => $request['gender'],
                'birthday' => $request['birthday'],
                'degree' => $request['degree'],
                'job' => $request['job'],
                'address' => $request['address'],
                'role' => 'employee',
                'profile_img_path' => $imgPath
            ]);
            $image = FileHandler::getFile($emp->profile_img_path, env('image_base_path'));
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => ['emp' => $emp, 'image' => $image]
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
        $val = validator(['id'=>$id], [
            'id' => 'required|integer',
        ]);
        if(!$val->fails()) {
            $res = Employee::destroy($id);
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
