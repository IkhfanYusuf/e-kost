<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $users = User::all();
        $rooms = Room::all();


        if ($request->input('search')) {
            $users = User::where('name', 'LIKE', '%' . $request->input('search') . '%')->get();
        }

        return Inertia::render('Pengguna/index', ['users' => $users, 'rooms' => $rooms]);
    }

    public function indexKostActive(Request $request)
    {
        $user = null;
        $users = User::where('role', 'anak-kost')->get();
        $users->load(['room' => function ($query) {
            $query->withTrashed()->get();
        }]);

        if ($request->input('search')) {
            $users = User::where([['role', 'anak-kost'], ['name', 'LIKE', '%' . $request->input('search') . '%']])->get();
        } else if ($request->input('show')) {
            $user = User::find($request->input('show'));
            // dd($user);
        }

        return Inertia::render('AnakKost/index', ['users' => $users, 'showUser' => $user]);
    }

    public function indexKostHistory()
    {

        $users = User::onlyTrashed()->where('role', 'anak-kost')->get();
        $users->load('room');

        return Inertia::render('RiwayatAnakKost/index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //content
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Gate::allows('admin')) {
            abort(403);
        }

        $file = $request->file('id_card_img');

        $request->validate([
            'name' => ['required', 'max:50'],
            'username' => ['required', 'max:20'],
            'phone' => ['required', 'max:15'],
            'role' => ['required', 'max:50'],
            'password' => ['required', 'max:50'],
            'gender' => ['required', 'max:50'],
        ], [
            'name.required' => 'Kolom nama tidak boleh kosong.',
            'username.required' => 'Kolom username tidak boleh kosong.',
            'phone.required' => 'Kolom no telpon tidak boleh kosong.',
            'role.required' => 'Kolom jabatan tidak boleh kosong.',
            'gender.required' => 'Kolom jenis kelamin tidak boleh kosong.',
            'password.required' => 'Kolom password tidak boleh kosong.',
            'name.max' => 'Kolom nama maksimal 50 karakter.',
            'username.max' => 'Kolom username maksimal 20 karakter.',
            'phone.max' => 'Kolom no telpon maksimal 15 angka.',
            'password.max' => 'Kolom password maksimal 50 karakter.',
        ]);

        if ($request->input('role') === 'anak-kost') {

            $request->validate([

                'room' => ['required'],
                'entry' => ['required'],
                'id_card' => ['required'],
                'id_card_img' => ['required'],

            ], [

                'room.required' => 'Kolom no kamar tidak boleh kosong.',
                'entry.required' => 'Kolom tanggal masuk tidak boleh kosong.',
                'id_card.required' => 'Nomor ktp tidak boleh kosong',
                'id_card_img.required' => 'Upload gambar ktp',

            ]);
        }


        if ($request->input('role') === 'anak-kost') {

            $fileName = Carbon::now()->timestamp;
            $file->storeAs('id-card-images', $fileName . '.' . $file->extension());

            User::create([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'role' => $request->input('role'),
                'entry_date' => $request->input('entry'),
                'room_id' => $request->input('room'),
                'phone' => $request->input('phone'),
                'gender' => $request->input('gender'),
                'id_card' => $request->input('id_card'),
                'id_card_img' => $fileName . '.' . $file->extension(),
                'status' => 'active',
                'password' => Hash::make($request->input('password'))
            ]);

            Room::where('id', $request->input('room'))->delete();
        } else {
            User::create([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'role' => $request->input('role'),
                'phone' => $request->input('phone'),
                'gender' => $request->input('gender'),
                'status' => 'active',
                'password' => Hash::make($request->input('password'))
            ]);
        }

        return Redirect::route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $user = User::find($id);

        // return Inertia::render('AnakKost/index', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if ($user->role !== 'anak-kost') {
            abort(403);
        }
        User::where('id', $id)->update(['status' => 'active']);
        return Redirect::route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();
        Room::withTrashed()->where('id', $user->room_id)->restore();
        // Room::where()
        return Redirect::route('users.index');
    }

    public function forceDestroy($id)
    {
        $user = User::find($id);

        if ($user->id_card_img) {
            $exist = Storage::exists('id-card-images/' . $user->id_card_img);
            if ($exist) {
                Storage::delete('id-card-images/' . $user->id_card_img);
            }
            Room::withTrashed()->where('id', $user->room_id)->restore();
        }

        $user->forceDelete();

        return Redirect::route('users.index');
    }
}
