<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['room_name', 'room_price', 'room_facility'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function image()
    {
        return $this->hasMany(Image::class);
    }
}
