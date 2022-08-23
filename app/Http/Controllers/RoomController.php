<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::withTrashed()->get();
        return Inertia::render('Rooms/index', ['rooms' => $rooms]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Rooms/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return $request->file('room_image')->store('post-images');

        // ddd($request);


        $request->validate([
            'room_name' => ['required', 'unique:rooms'],
            'room_price' => ['required'],
            'room_facility' => ['required'],
            'room_image' => ['required'],
            'room_image.*' => ['image', 'file', 'max:4096'],

        ], [
            'room_name.required' => 'Nomor kamar harus diisi.',
            'room_name.unique' => 'Nama kamar tidak boleh sama.',
            'room_price.required' => 'Nomor harga per bulan harus diisi.',
            'room_facility.required' => 'Fasilitas kamar harus diisi.',
            'room_image.required' => 'Gambar utama harus diisi.',
            'room_image.*.image' => 'File yang diupload harus gambar.',
            'room_image.*.file' => 'Gambar yang boleh diupload maksimal 4mb.',
            'room_image.*.max' => 'Gambar yang boleh diupload maksimal 4mb.',

        ]);

        $files = $request->file('room_image');

        $room = Room::create([
            'room_name' => $request->input('room_name'),
            'room_price' => $request->input('room_price'),
            'room_facility' => $request->input('room_facility'),
        ]);

        foreach ($files as $key => $file) {
            $fileName = Carbon::now()->timestamp;
            $file->storeAs('post-images', $fileName . $key . '.' . $file->extension());

            $room->image()->save(
                new Image([
                    'room_image' => $fileName . $key  . '.' . $file->extension()
                ]),

            );
        }

        return Redirect::route('rooms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->forceDelete();
        return Redirect::route('rooms.index');
    }
}
