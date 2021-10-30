<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Interfaces\TripayInterface;
use App\Models\Post;
use App\Models\Transaction;

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
        $status = $this->tripay->checkStatus();
        if ($status) return $status;

        $result = $this->tripay->requestTransaction($request);

        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'price' => $result->amount,
            'reference' => $result->reference,
            'merchant_ref' => $result->merchant_ref,
            'status' => $result->status
        ]);

        return $this->successResponse($transaction, 'Add Payment Successfully');
    }

    public function transaction($reference)
    {
        $result = $this->tripay->detailTransaction($reference);
        return $this->successResponse($result, 'Detail Transactions Payment');
    }
}
