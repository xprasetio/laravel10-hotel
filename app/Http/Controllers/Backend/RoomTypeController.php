<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomTypeController extends Controller
{

    public function RoomTypeList()
    {
        $allData = RoomType::orderBy('id', 'desc')->get();
        return view('backend.allroom.roomtype', compact('allData'));
    }

    public function AddRoomType()
    {
        return view('backend.allroom.addroomtype');
    }
    public function RoomTypeStore(Request $request)
    {

        RoomType::insert([
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Room type inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('room.type.list')->with($notification);
    }
}
