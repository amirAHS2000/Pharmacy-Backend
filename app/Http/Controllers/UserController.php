<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * @throws ValidationException
     */
    function loginPatient(Request $request): JsonResponse
    {
        $val = validator($request->all(), [
            'phone' => 'required',
            'password' => 'required',
        ]);

        if (!$val->fails()) {
            $user = User::where('phone', $request['phone'])->where('type', 'patient')->first();
            return $this->login($user, $request['password']);
        } else {
            return response()->json([
                'status' => false,
                'message' => ['Please Provide A Phone And A Password'],
                'result' => []
            ]);
        }
    }

    function loginEmployee(Request $request): JsonResponse
    {
        $val = validator($request->all(), [
            'phone' => 'required',
            'password' => 'required',
        ]);

        if (!$val->fails()) {
            $user = User::where('phone', $request['phone'])
//                ->where('type', 'manager')
                ->where(function ($query) {
                    $query->where('type', 'employee')->orWhere('type', 'manager');
                })
                ->first();
            return $this->login($user, $request['password']);
        } else {
            return response()->json([
                'status' => false,
                'message' => ['Please Provide A Phone And A Password'],
                'result' => []
            ]);
        }
    }

    /**
     * @param $user
     * @param $password
     * @return JsonResponse
     */
    private function login($user, $password): JsonResponse
    {
        if (!$user || !Hash::check($password, $user->password)) {;
            return response()->json([
                'status' => false,
                'message' => ['These credentials do not match our records.'],
                'result' => []
            ]);
        }

        $token = $user->createToken('pharmacy-token')->plainTextToken;

        $result = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json([
            'status' => true,
            'message' => [''],
            'result' => [$result]
        ]);
    }

    function register(Request $request)
    {
        $val = validator($request->all(), [
            'ref_id' => 'required',
            'phone' => 'required|numeric',
            'password' => 'required|min:8',
            'nat_num' => 'required',
            'type' => 'required|in:patient,employee'
        ]);

        if (!$val->fails()) {
            $user = User::where('phone', $request->phone)->where('type', $request->type)->first();
            if ($user != null) {
                return response()->json([
                    'status' => false,
                    'message' => ['this phone number is already exists'],
                    'result' => []
                ]);
            }
            if ($request['type'] == 'patient') {
                $patient = Patient::find($request['ref_id']);
                if ($patient == null) {
                    return response()->json([
                        'status' => false,
                        'message' => ['no patient with given info has been found'],
                        'result' => []
                    ]);
                } elseif ($patient->nat_num != $request['nat_num']) {
                    return response()->json([
                        'status' => false,
                        'message' => ['no patient with given national number has been found'],
                        'result' => []
                    ]);
                }
            } elseif ($request['type'] == 'employee') {
                $employee = Employee::find($request['ref_id']);
                if ($employee == null) {
                    return response()->json([
                        'status' => false,
                        'message' => ['no employee with given info has been found'],
                        'result' => []
                    ]);
                } elseif ($employee->nat_num != $request['nat_num']) {
                    return response()->json([
                        'status' => false,
                        'message' => ['no employee with given national number has been found'],
                        'result' => []
                    ]);
                }
            }
            $user = new User();
            $user->fill([
                'ref_id' => $request['ref_id'],
                'phone' => $request['phone'],
                'password' => Hash::make($request['password']),
                'type' => $request['type']
            ]);
            $user->save();
            $token = $user->createToken('pharmacy-token')->plainTextToken;
            $result = ['user' => $user, 'token' => $token];
            return response()->json([
                'status' => true,
                'message' => [''],
                'result' => [$result]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => [$val->errors()],
                'result' => []
            ]);
        }

    }

    function index()
    {
        if (auth()->user()->type == 'patient') return abort(403);
        $users = User::all();
        $result = ['users' => $users];
        return response()->json([
            'status' => true,
            'message' => [],
            'result' => [$result]
        ]);
    }

    function showPatient(Request $request)
    {
        $val = validator($request->all(), [
            'phone' => 'required',
        ]);
        if (!$val->fails()) {
            $users = User::where('phone', $request['phone'])->where('type', 'patient')->get();

            if ($users == null || $users->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => ['No User With Given Phone Has Been Found'],
                    'result' => []
                ]);
            } else
                return response()->json([
                    'status' => true,
                    'message' => [],
                    'result' => [$users]
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
