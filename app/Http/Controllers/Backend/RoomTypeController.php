<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Room;

class RoomTypeController extends Controller
{

    public function RoomTypeList()
    {
        $allData = RoomType::orderBy('id', 'desc')->get();
        return view('backend.allroom.roomtype.roomtype', compact('allData'));
    }

    public function AddRoomType()
    {
        return view('backend.allroom.roomtype.addroomtype');
    }
    public function RoomTypeStore(Request $request)
    {

        $roomtype_id = RoomType::insertGetId([
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Room::insert([
            'roomtype_id' => $roomtype_id,
        ]);

        $notification = array(
            'message' => 'Room type inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('room.type.list')->with($notification);
    }
}
