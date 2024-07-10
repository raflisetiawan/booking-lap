<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    public function daftar(Request $request){
        $data=User::get();
        return $data;
    }

    public function detail(Request $request){
        $data = User::find($request->input('id'));

        if ($data === NULL) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found'
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'message' => $data
        ]);

    }


    public function add_sample(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'hp' => 'required|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        $obj = new User;
        $obj->name = $request->input('name');
        $obj->hp = $request->input('hp');
        $obj->save();

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
