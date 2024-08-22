<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\BookArea;
use App\Models\Facility;
use App\Models\MultiImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class FrontendRoomController extends Controller
{
    public function AllFrontendRoomList()
    {

        $rooms = Room::latest()->get();
        return view('frontend.room.all_rooms', compact('rooms'));
    } // End Method 

    public function RoomDetailsPage($id)
    {
        $roomdetails = Room::find($id);
        $multiImage = MultiImage::where('rooms_id', $id)->get();
        $facility = Facility::where('rooms_id', $id)->get();
        $otherRooms = Room::where('id', '!=', $id)->orderBy('id', 'DESC')->limit(2)->get();
        return view('frontend.room.room_details', compact('roomdetails', 'multiImage', 'facility', 'otherRooms'));
    }
}
