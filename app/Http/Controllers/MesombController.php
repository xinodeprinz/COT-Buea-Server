<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Malico\MeSomb\Payment;
use Malico\MeSomb\Deposit;

class MesombController extends Controller
{
    public function confirmOrder()
    {
        $request = new Payment('+237675874066', 110);

        $payment = $request->pay();

        if($payment->success){
            return response('Hello World', 201);
        } else {
            return response('Failed', 400);
        }
    }

    public function withdraw(){
        $request = new Deposit('+237675874066', 5);

        $payment = $request->pay();

        if($payment->success){
            return response(['Withdrawal Successful']);
        } else {
            return response('Withdrawal Failed', 400);
        }

        return 'Hello World';
    }
}
