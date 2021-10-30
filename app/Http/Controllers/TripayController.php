<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Interfaces\TripayInterface;
use App\Models\Post;

class TripayController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $tripay;

    public function __construct(TripayInterface $tripay)
    {
        $this->tripay = $tripay;
    }

    public function index()
    {
        $result = $this->tripay->getPaymentChannel();

        $arr_data = [];
        foreach ($result as $key => $val) {
            if ($val->active) {
                $arr_data[] = $val;
            }
        }
        return $arr_data;
    }

    public function store(Request $request)
    {
        $result = $this->tripay->requestTransaction($request);
        return $result;
    }
}
