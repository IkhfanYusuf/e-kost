<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['payment_id', 'payment_amount', 'payment_status', 'payment_receipt', 'user_id', 'payment_for'];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->isoFormat('dddd, D MMMM Y'),
        );
    }

    // protected function paymentFor(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => Carbon::parse($value)->isoFormat('dddd, D MMMM Y'),
    //     );
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
