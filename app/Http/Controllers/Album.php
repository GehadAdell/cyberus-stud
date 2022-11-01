<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Album extends Controller
{
    //
    public function index()
    {
        $album =   DB::table("album")->get();
        return response()->json(["status" => 200, "data" => $album, "msg" => ""]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "nullable|string|max:30|min:5",
            "description" => "nullable|max:255",
        ]);
        $images = $request->file('album');
        $imageName = '';
        foreach ($images as $image) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/images'), $new_name);
            $imageName = $imageName . $new_name . ",";
        }
        $imagedb = $imageName;
        DB::table("album")->insert([
            "name" => $request->name,
            "description" => $request->description,
            "album" => $imagedb
        ]);
        return response()->json(["status" => 201, "data" => [], "msg" => "album inserted"]);
    }

    public function delete($id)
    {
        DB::table("album")->delete($id);
        return response()->json(["status" => 202, "data" => [], "msg" => "album deleted successfully"]);
    }

    public function update(Request $request, $id)
    {
        $album =   DB::table("album")->find($id);
        $request->validate([
            "name" => "nullable|string|max:30|min:5",
            "description" => "nullable|max:255",
        ]);

        if ($request->hasfile('album')) {
            $images = $request->file('album');
            $imageName = '';
            foreach ($images as $image) {
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/uploads/images'), $new_name);
                $imageName = $imageName . $new_name . ",";
            }
            $imagedb = $imageName;
        } else {
            $imagedb = $album->album;
        }
        if ($request->description == NULL) {
            $request->description = $album->description;
        }
        if ($request->name == NULL) {
            $request->name = $album->name;
        }

        $respone =  DB::table("album")->where("id", $id)->update([
            "name" => $request->name,
            "description" => $request->description,
            "albem" => $imagedb
        ]);
        if ($respone == 1) {
            return response()->json(["status" => 201, "data" => [], "msg" => "album updated successfully"]);
        }
        return response()->json(["status" => 404, "data" => [], "msg" => "album not found"]);
    }

    public function get($id)
    {
        $album =   DB::table("album")->find($id);
        return response()->json(["status" => 200, "data" => $album, "msg" => ""]);
    }
}
