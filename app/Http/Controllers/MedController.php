<?php

namespace App\Http\Controllers;

use App\Globals\FileHandler;
use App\Models\Comp;
use App\Models\Med;
use App\Models\Pharm;
use App\Models\PrescContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $meds = Med::all();
        $res = [];
        foreach ($meds as $med) {
            $image = FileHandler::getFile($med->img_path, env('image_base_path'));
            $pharm = $med->pharm()->get()->first();
            $comp = $med->comp()->get()->first();
            $cat = $pharm->category()->get()->first();
            array_push($res, ['med' => $med, 'pharm' => $pharm, 'company' => $comp, 'category' => $cat, 'image' => $image]);
        }
        return response()->json([
            'status' => true,
            'message' => [],
            'result' => $res
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
            'pharm_id' => 'required|integer',
            'inv' => 'required|integer',
            'exp_date' => 'date',
            'price' => 'required|integer',
            'add_info' => 'required',
            'comp_id' => 'required|integer',
        ]);

        if (!$val->fails()) {
            $pharm = Pharm::find($request['pharm_id']);
            if ($pharm == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['pharm not found'],
                    'result' => []
                ]);
            }
            $comp = Comp::find($request['comp_id']);
            if ($comp == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['company not found'],
                    'result' => []
                ]);
            }
            $imgPath = null;
            if ($request['image'] != null) {
                $imgPath = FileHandler::uploadFile($request['image'], 'med', env('image_base_path'));
            }
            $med = new Med();
            $med->fill([
                'pharm_id' => $request['pharm_id'],
                'inv' => $request['inv'],
                'exp_date' => $request['exp_date'],
                'price' => $request['price'],
                'add_info' => $request['add_info'],
                'comp_id' => $request['comp_id'],
                'img_path' => $imgPath
            ]);
            $med->save();
            $image = FileHandler::getFile($med->img_path, env('image_base_path'));
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => ['med' => $med, 'image' => $image]
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
    public function show($id)
    {
        $val = validator(['id' => $id], [
            'id' => 'required|integer',
        ]);
        if (!$val->fails()) {
            $med = Med::find($id);
            if ($med == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['medicine not found'],
                    'result' => []
                ]);
            }
            $image = FileHandler::getFile($med->img_path, env('image_base_path'));
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => ['med' => $med, 'image' => $image]
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
            'id' => 'integer',
            'pharm_id' => 'required|integer',
            'inv' => 'required|integer',
            'exp_date' => 'date',
            'price' => 'required|integer',
            'add_info' => 'required',
            'comp_id' => 'required|integer',
        ]);
        if (!$val->fails()) {
            $med = Med::find($id);
            if ($med == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['medicine not found'],
                    'result' => []
                ]);
            }
            $imgPath = null;
            if ($request['image'] != null) {
                $imgPath = FileHandler::uploadFile($request['image'], 'med', env('image_base_path'));
            }
            $med->update([
                'pharm_id' => $request['pharm_id'],
                'inv' => $request['inv'],
                'exp_date' => $request['exp_date'],
                'price' => $request['price'],
                'add_info' => $request['add_info'],
                'comp_id' => $request['comp_id'],
                'img_path' => $imgPath
            ]);;
            $image = FileHandler::getFile($med->img_path, env('image_base_path'));

            return response()->json([
                'status' => true,
                'message' => [],
                'result' => ['med' => $med, 'image' => $image]
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
        if (!$val->fails()) {
            $res = Med::destroy($id);
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

    /**
     * Display all related information about a medicine
     *
     * @param $id
     * @return JsonResponse
     */
    public function showAllInfo($id)
    {
        $val = validator(['id' => $id], [
            'id' => 'required|integer',
        ]);
        if (!$val->fails()) {
            $med = Med::find($id);
            if ($med == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['medicine not found'],
                    'result' => []
                ]);
            }
            $pharm = $med->pharm()->get()->first();
            $comp = $med->comp()->get()->first();
            $cat = $pharm->category()->get()->first();
            $image = FileHandler::getFile($med->img_path, env('image_base_path'));
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => ['med' => $med, 'pharm' => $pharm, 'image' => $image, 'company' => $comp, 'category' => $cat]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => [$val->errors()],
                'result' => []
            ]);
        }
    }

    /*****  Other APIs  ****/

    public function search(Request $request)
    {
        $val = validator($request->all(), [
            'name' => 'required',
        ]);
        if (!$val->fails()) {
            $res = [];
            $pharms = Pharm::where('name', 'like', "%{$request['name']}%")->get();
            foreach ($pharms as $pharm) {
                $meds = $pharm->med()->get();
//                if ($meds->isEmpty()) array_push($res, ['med' => null, 'pharm' => $pharm, 'image' => null]);
                foreach ($meds as $med) {
                    $image = null;
                    if ($med != null) {
                        $image = FileHandler::getFile($med->img_path, env('image_base_path'));
                    }
                    array_push($res, ['med' => $med, 'pharm' => $pharm, 'image' => $image]);
                }
            }

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

    // top sellers that need doctor prescription
    public function topSellND()
    {
        $top = PrescContent::selectRaw("count(med_id) as sells , med_id")->groupBy('med_id')->orderByRaw('count(med_id) DESC')->get();
        $res = [];
        foreach ($top as $item) {
            $med = Med::find($item->med_id);
            $pharm = $med->pharm()->first();
            if ($pharm->need_dr) {
                $image = FileHandler::getFile($med->img_path, env('image_base_path'));
                array_push($res, ['med' => $med, 'pharm' => $pharm, 'image' => $image]);
            }
        }
        return response()->json([
            'status' => true,
            'message' => [],
            'result' => $res
        ]);
    }

    // top sellers that do not need doctor prescription
    public function topSellDND()
    {
        $top = PrescContent::selectRaw("count(med_id) as sells , med_id")->groupBy('med_id')->orderByRaw('count(med_id) DESC')->get();
        $res = [];
        foreach ($top as $item) {
            $med = Med::find($item->med_id);
            $pharm = $med->pharm()->first();
            if (!$pharm->need_dr) {
                $image = FileHandler::getFile($med->img_path, env('image_base_path'));
                array_push($res, ['med' => $med, 'pharm' => $pharm, 'image' => $image]);
            }
        }
        return response()->json([
            'status' => true,
            'message' => [],
            'result' => $res
        ]);
    }

}
