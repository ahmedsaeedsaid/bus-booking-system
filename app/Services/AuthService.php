<?php

namespace App\Services;

use App\Exceptions\InvalidEmailOrPasswordException;
use App\Exceptions\SeatUnAvailableException;
use App\Models\Reservation;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AuthService
{

    /**
     * @param string $email
     * @param string $password
     * @return User create reservation.
     *
     * create reservation.
     * @throws InvalidEmailOrPasswordException
     */

    public function login(string $email, string $password): User
    {
        if(!Auth::attempt(['email' => $email, "password" => $password])){
            throw new InvalidEmailOrPasswordException();
        }

        return User::where('email', $email)->first();
    }

}