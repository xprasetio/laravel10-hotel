<?php

namespace App\Http\Controllers\Backend;

use App\Models\Team;
use App\Models\BookArea;
use Illuminate\Http\Request;
// use Intervention\Image\Image;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class TeamController extends Controller
{
    public function AllTeam()
    {
        $team = Team::latest()->get();
        return view('backend.team.all_team', compact('team'));
    }
    public function AddTeam()
    {
        return view('backend.team.add_team');
    }
    public function EditTeam($id)
    {
        $team = Team::findOrFail($id);
        return view('backend.team.edit_team', compact('team'));
    }

    public function DeleteTeam($id)
    {
        $item = Team::findOrFail($id);
        $img = $item->image;
        unlink($img);
        Team::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Team Member Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function TeamUpdate(Request $request)
    {
        $team_id = $request->id;
        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $upload_location = 'upload/team/';
            $image->move($upload_location, $name_gen);
            $save_url = 'upload/team/' . $name_gen;
            Team::findOrFail($team_id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'facebook' => $request->facebook,
                'image' => $save_url,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Team Member Updated With Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.team')->with($notification);
        } else {
            Team::findOrFail($team_id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'facebook' => $request->facebook,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Team Member Updated Without Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.team')->with($notification);
        }
    }

    public function TeamStore(Request $request)
    {
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $upload_location = 'upload/team/';
        $image->move($upload_location, $name_gen);
        $save_url = 'upload/team/' . $name_gen;
        Team::insert([
            'name' => $request->name,
            'position' => $request->position,
            'facebook' => $request->facebook,
            'image' => $save_url,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Team Member Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.team')->with($notification);
    }

    //================= BOOK AREA ALL METHODS =========
    public function BookArea()
    {
        $book = BookArea::find(1);
        return view('backend.bookarea.book_area', compact('book'));
    }

    public function BookAreaUpdate(Request $request)
    {
        $book_id = $request->id;
        if ($request->file('image')) {
            $image = $request->file('image');
            // $image->resize(1000,1000);
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $upload_location = 'upload/bookarea/';
            $image->move($upload_location, $name_gen);
            $save_url = 'upload/bookarea/' . $name_gen;
            BookArea::findOrFail($book_id)->update([
                'short_title' => $request->short_title,
                'main_title' => $request->main_title,
                'short_description' => $request->short_description,
                'link_url' => $request->link_url,
                'image' => $save_url,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Book Area Updated With Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            BookArea::findOrFail($book_id)->update([
                'short_title' => $request->short_title,
                'main_title' => $request->main_title,
                'short_description' => $request->short_description,
                'link_url' => $request->link_url,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Book Area Updated Without Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }
}
