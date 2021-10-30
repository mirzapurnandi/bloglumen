<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

interface TripayInterface
{

    public function getPaymentChannel();

    public function requestTransaction(Request $request);

    public function detailTransaction($reference);

    public function checkStatus();
}
