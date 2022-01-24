<?php

namespace App\Http\Controllers;

use App\Globals\FileHandler;
use App\Models\Med;
use App\Models\Presc;
use App\Models\PrescContent;
use Illuminate\Http\Request;

class PrescContentController extends Controller
{
    public function show($id)
    {
        $val = validator(['id' => $id], [
            'id' => 'required|integer',
        ]);
        if (!$val->fails()) {
            $res = [];
            $content = PrescContent::all()->where('presc_id', '=', $id);
            foreach ($content as $item) {
                $med = $item->med()->first();
                $pharm = $med->pharm()->get();
                $image = FileHandler::getFile($med->img_path, env('image_base_path'));
                array_push($res, ['content' => $item, 'med' => $med, 'pharm' => $pharm, 'image' => $image]);
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

    public function store(Request $request)
    {
        $val = validator($request->all(), [
            'presc_id' => 'required|integer',
            'med_id' => 'required|integer',
            'ins_buy' => 'required|boolean',
        ]);
        if (!$val->fails()) {
            $presc = Presc::find($request['presc_id']);
            if ($presc == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['prescription not found'],
                    'result' => []
                ]);
            }
            $med = Med::find($request['med_id']);
            if ($med == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['medicine not found'],
                    'result' => []
                ]);
            }
            $price = $med->price;
            $content = new PrescContent();
            $content->fill([
                'presc_id' => $request['presc_id'],
                'ins_buy' => $request['ins_buy'],
                'med_id' => $request['med_id'],
                'price' => $price
            ]);
            $content->save();
            $presc->updateTotalPrice();
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => ['content' => $content, 'med' => $med]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => [$val->errors()],
                'result' => []
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $val = validator(array_merge($request->all(), ['id' => $id]), [
            'id' => 'required',
            'presc_id' => 'required|integer',
            'med_id' => 'required|integer',
            'ins_buy' => 'required|boolean',
        ]);
        if (!$val->fails()) {
            $presc = Presc::find($request['presc_id']);
            if ($presc == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['prescription not found'],
                    'result' => []
                ]);
            }
            $med = Med::find($request['med_id']);
            if ($med == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['medicine not found'],
                    'result' => []
                ]);
            }
            $price = $med->price;
            $content = PrescContent::find($id);
            $content->update([
                'presc_id' => $request['presc_id'],
                'ins_buy' => $request['ins_buy'],
                'med_id' => $request['med_id'],
                'price' => $price
            ]);
            $presc->updateTotalPrice();
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => ['content' => $content, 'med' => $med]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => [$val->errors()],
                'result' => []
            ]);
        }
    }

    public function destroy($id)
    {
        $val = validator(['id' => $id], [
            'id' => 'required|integer',
        ]);
        if (!$val->fails()) {
            $content = PrescContent::find($id);
            if ($content == null){
                return response()->json([
                    'status' => false,
                    'message' => ['Content not found'],
                    'result' => []
                ]);
            }
            $presc = $content->presc();
            $res = $content->destroy($id);
            $presc->updateTotalPrice();
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
