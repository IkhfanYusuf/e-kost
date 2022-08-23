<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Console\Input\Input;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->errorFormReturnData()['users'];
        $payments = $this->errorFormReturnData()['payments'];

        $search = $request->Input('search');

        if ($search) {
            $payments->with('user', 'user.room')->whereHas('user', function ($query) use ($search) {
                $query->where('name',  'LIKE', '%' . $search . '%');
            });
        } else {
            $payments->with(['user' => function ($query) {
                $query->withTrashed()->with(['room' => function ($q) {
                    $q->withTrashed();
                }]);
            }]);
        }

        return Inertia::render('Pembayaran/index', ['payments' => $payments->get(), 'users' => $users]);
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

    public function errorFormReturnData()
    {
        $now = Carbon::now();

        $users = User::where('role', 'anak-kost')->with(['room' => function ($query) {
            $query->withTrashed();
        }])->get();

        $payments = Payment::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->with(['user' => function ($query) {
                $query->withTrashed()->with(['room' => function ($q) {
                    $q->withTrashed();
                }]);
            }]);

        $data = [
            'users' => $users,
            'payments' => $payments,
        ];

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'payment_amount' => ['required'],
            'payment_for' => ['required'],
            'user_id' => ['required'],
        ], [
            'payment_amount.required' => 'Masukan jumlah pembayaran terlebih dahulu',
            'payment_for.required' => 'Pilih pembayaran untuk bulan ke-',
            'user_id.required' => 'Pilih penghuni kost terlebih dahulu',
        ]);

        $entry_date = $request->input('entry_date');
        $user_id = $request->input('user_id');
        $payment_for = $request->input('payment_for') . '-' . $entry_date;

        $user = User::find($user_id);
        $users = $this->errorFormReturnData()['users'];
        $payments = $this->errorFormReturnData()['payments'];

        $status = NULL;
        $file = NULL;
        $payment_receipt = 'verified-payment.png';
        if(Auth()->user()->role === 'anak-kost'){
            $file = $request->file('payment_receipt');
            $status = "Pending";

            $fileName = Carbon::now()->timestamp;
            $file->storeAs('receipt', 'receipt-'.$fileName . '.' . $file->extension());
            $payment_receipt = 'receipt-'.$fileName . '.' . $file->extension();
        }else{
            $status = "Lunas";
        }

        //verify if isn't yet a boarding tenant
        if (Carbon::parse($user->entry_date)->month > Carbon::parse($payment_for)->month) {
            if(Auth()->user()->role === 'anak-kost'){
                return Inertia::render('AnakKost/Dashboard', ['errors' => ['payment_verify_error' => 'Bulan ' . Carbon::parse($payment_for)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F Y') . ' ' . $user->name . ' belum menyewa kost.'], 'users' => $users, 'payments' => $payments->get()]);
            }
            return Inertia::render('Pembayaran/index', ['errors' => ['payment_verify_error' => 'Bulan ' . Carbon::parse($payment_for)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F Y') . ' ' . $user->name . ' belum menyewa kost.'], 'users' => $users, 'payments' => $payments->get()]);
        }

        //get last user payment
        $last_payment = Payment::where('user_id', $user->id)->orderBy('id', 'DESC')->first();
        if (!$last_payment) {
            $unpaid = Carbon::parse(Auth()->user()->entry_date);
        } else {
            $unpaid = Carbon::parse($last_payment->payment_for)->addMonth()->format('Y-m-d');
        }

        //verify unpaid payments
        if (Carbon::parse($payment_for)->month > Carbon::parse($unpaid)->month) {
            if(Auth()->user()->role === 'anak-kost'){
                return Inertia::render('AnakKost/Dashboard', ['errors' => ['payment_verify_error' => $user->name . ' belum membayar dari bulan ' . Carbon::parse($unpaid)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F Y') . ', silakan bayar tagihan ber-urutan.'], 'users' => $users, 'payments' => $payments->get()]);
            }
            return Inertia::render('Pembayaran/index', ['errors' => ['payment_verify_error' => $user->name . ' belum membayar dari bulan ' . Carbon::parse($unpaid)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F Y') . ', silakan bayar tagihan ber-urutan.'], 'users' => $users, 'payments' => $payments->get()]);
        }

        //verify if payment unpaid
        $paid = Payment::where([['payment_for', '=', $payment_for], ['user_id', $user_id]])->count();

        if ($paid > 0) {
            if(Auth()->user()->role === 'anak-kost'){
                return Inertia::render('AnakKost/Dashboard', ['errors' => ['payment_verify_error' => 'Tagihan sudah dibayar.'], 'users' => $users, 'payments' => $payments->get()]);
            }
            return Inertia::render('Pembayaran/index', ['errors' => ['payment_verify_error' => 'Tagihan sudah dibayar.'], 'users' => $users, 'payments' => $payments->get()]);
        }


        Payment::create([
            'payment_id' => Carbon::now()->timestamp,
            'payment_amount' => $request->input('payment_amount'),
            'payment_for' => $payment_for,
            'user_id' => $user_id,
            'payment_status' => $status,
            'payment_receipt' => $payment_receipt,
        ]);

        return Redirect::route('payments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        Payment::where('id', $payment->id)->update(['payment_status' => 'Lunas']);
        return Redirect::route('payments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
