<?php

namespace App\Http\Controllers;

use App\Models\photo as ModelsPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Photo extends Controller
{
    //
    public function index()
    {
        $photo =   DB::table("photo")->get();
        return response()->json(["status" => 200, "data" => $photo, "msg" => ""]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "nullable|string|max:30|min:5",
            "description" => "nullable|max:255",
            "photo" => "required|mimes:jpeg,jpg,png",
        ]);
        if ($request->hasfile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/photo/', $filename);
        }
        DB::table("photo")->insert([
            "name" => $request->name,
            "description" => $request->description,
            "photo" => $filename
            
        ]);
        return response()->json(["status" => 201, "data" => [], "msg" => "photo inserted"]);
    }

    public function delete($id)
    {
        $photo =   DB::table("photo")->find($id);
        $destination = 'uploads/photo/'.$photo->photo;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
        DB::table("photo")->delete($id);
        return response()->json(["status" => 202, "data" => [], "msg" => "Photo deleted successfully"]);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            "name" => "nullable|string|max:30|min:5",
            "description" => "nullable|max:255",
            "photo" => "nullable|mimes:jpeg,jpg,png",
        ]);
        $photo =   DB::table("photo")->find($id);
        if ($request->hasfile('photo')) {

            $destination = 'uploads/photo/'.$photo->photo;
            if(File::exists($destination))
            {
                File::delete($destination);
            }

            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/photo/', $filename);
        }
        else{
            $filename = $photo->photo;
        }
        if($request->description == NULL)
        {
            $request->description = $photo->description;
        }
        if($request->name == NULL)
        {
            $request->name = $photo->name;
        }
        $respone =  DB::table("photo")->where("id", $id)->update([
            "name" => $request->name,
            "description" => $request->description,
            "photo" => $filename
        ]);
        if ($respone == 1) {
            return response()->json(["status" => 201, "data" => [], "msg" => "Photo updated successfully"]);
        }
        return response()->json(["status" => 404, "data" => [], "msg" => "photo not found"]);
    }

    public function get($id)
    {
        $photo =   DB::table("photo")->find($id);
        return response()->json(["status" => 200, "data" => $photo, "msg" => ""]);
    }
}
