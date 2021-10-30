<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Interfaces\TripayInterface;
use App\Models\Post;

class TripayController extends Controller
{

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
        return $this->successResponse($arr_data, 'Show All Payment Channel');
    }

    public function store(Request $request)
    {
        $result = $this->tripay->requestTransaction($request);
        dd($result);
        return $result;
    }

    public function transaction()
    {
        //
    }
}
