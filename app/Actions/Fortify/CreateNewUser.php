<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Carbon\Carbon;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $file = $input['id_card_img'];
        
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'unique:users', 'alpha_dash'],
            'phone' => ['required', 'string', 'max:15'],
            'gender' => ['required', 'string'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ], [
            'name.required' => 'Kolom nama tidak boleh kosong.',
            'username.required' => 'Kolom username tidak boleh kosong.',
            'username.unique' => 'username sudah terdaftar.',
            'username.alpha_dash' => 'username hanya boleh teridiri dari huruf, amgka, - atau _.',
            'phone.required' => 'Kolom nomor telpon tidak boleh kosong.',
            'phone.max' => 'Kolom nomor telpon maksimal 15 angka.',
            'gender.required' => 'Kolom jenis kelamin tidak boleh kosong.',
            'password.required' => 'Kolom password tidak boleh kosong.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',

        ])->validate();

        
        $fileName = Carbon::now()->timestamp;
        $file->storeAs('id-card-images', $fileName . '.' . $file->extension());

        $user = User::create([
            'name' => $input['name'],
            'username' => $input['username'],
            'phone' => $input['phone'],
            'gender' => $input['gender'],
            'password' => Hash::make($input['password']),
            'entry_date' => $input['entry'],
            'room_id' => $input['room'],
            'id_card' => $input['id_card'],
            'id_card_img' => $fileName . '.' . $file->extension(),
        ]);

        Room::where('id', $input['room'])->delete();

        return $user;
    }

    
}
