<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ApiResponser;

    public function respondWithToken($token)
    {
        return $this->successResponse([
            'token' => $token,
            'token_type' => 'Bearer ',
            'expires_in' => null
        ], 'Authorized');
    }
}
