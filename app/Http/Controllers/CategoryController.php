<?php

namespace App\Http\Controllers;

use App\Globals\FileHandler;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $cats = Category::all();
        $res = [];
        foreach ($cats as $cat) {
            $image = FileHandler::getFile($cat->img_path, env('image_base_path'));
            array_push($res, ['category' => $cat, 'image' => $image]);
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
            'name' => 'required',
        ]);
        if (!$val->fails()) {
            $imgPath = null;
            if ($request['image'] != null) {
                $imgPath = FileHandler::uploadFile($request['image'], 'cat', env('image_base_path'));
            }
            $cat = new Category();
            $cat->fill([
                'name' => $request['name'],
                'img_path' => $imgPath
            ]);
            $cat->save();
            $image = FileHandler::getFile($cat->img_path, env('image_base_path'));
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => [
                    'category' => $cat,
                    'image' => $image
                ]
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
            $cat = Category::find($id);
            if ($cat == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['category not found'],
                    'result' => []
                ]);
            }
            $image = FileHandler::getFile($cat->img_path, env('image_base_path'));
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => ['category' => $cat, 'image' => $image]
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
            'name' => 'required'
        ]);
        if (!$val->fails()) {
            $cat = Category::find($id);
            if ($cat == null) {
                return response()->json([
                    'status' => false,
                    'message' => ['category not found'],
                    'result' => []
                ]);
            }
            $imgPath = null;
            if ($request['image'] != null) {
                $imgPath = FileHandler::uploadFile($request['image'], 'cat', env('image_base_path'));
            }

            $cat->update([
                'name' => $request['name'],
                'img_path' => $imgPath
            ]);

            $image = FileHandler::getFile($cat->img_path, env('image_base_path'));
            return response()->json([
                'status' => true,
                'message' => [],
                'result' => ['category' => $cat, 'image' => $image]
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
            $res = Category::destroy($id);
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
