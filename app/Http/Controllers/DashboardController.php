<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = Auth()->user()->id;
        $payments = Payment::where('user_id', $id)->get();
        $user = User::where('id', $id)->with(['room' => function($query){$query->withTrashed();} ] )->first();

        if (!(Route::has('login'))) return Inertia::render('Auth.Login');

        if (!Gate::allows('anak-kost')) {
            $users = User::where('role', 'anak-kost')->get();
            if ($request->input('search')) {
                $users = User::where([['name', 'LIKE', '%' . $request->input('search') . '%'], ['role', 'anak-kost']])->get();
            }
            $users->load(['payment' => function ($query) {
                $query->whereMonth('created_at', Carbon::now()->month);
            }]);

            $usersUnpaid = [];
            foreach ($users as $key => $item) {
                $item->entry_date = Carbon::parse($item->entry_date)->isoFormat('dddd, D MMMM');
            }


            return Inertia::render('Dashboard', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'users' => $users,
            ]);
        }

        //get last user payment
        $last_payment = Payment::where('user_id', Auth()->user()->id)->orderBy('id', 'DESC')->first();

        // dd($last_payment);
        //new user
        if (!$last_payment) {
            $unpaid = Carbon::parse(Auth()->user()->entry_date);
        } else {
            $unpaid = Carbon::parse($last_payment->payment_for)->addMonth();
        }

        $now = Carbon::today();
        $difference = $unpaid->diffInDays($now);

        if ($unpaid < $now) {
            $type = "late";
            if ($difference > 29) {
                $msg = "Pembayaran tagihan kostmu terlambat " . $unpaid->diffInMonths($now) . " bulan.";
            } else {
                $msg = "Pembayaran tagihan kostmu terlambat " . $difference . " hari.";
            }
        } else if ($unpaid > $now && $difference <= 7) {
            $type = "warning";
            $msg = "Waktu pembayaran kostmu bulan ini jatuh tempo " . $difference . " hari lagi.";
        } else if ($difference === 0) {
            $type = "due";
            $msg = "Hari ini jatuh tempo waktu pembayaran kostmu.";
        } else {
            $type = "paid";
            $msg = 'Belum ada tagihan untuk kamu.';
        }

        return Inertia::render('AnakKost/Dashboard', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'notif' => [
                "msg" => $msg,
                "type" => $type
            ],
            'payments' => $payments,
            'user' => $user

        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
