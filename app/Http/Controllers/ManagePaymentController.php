<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ManagePaymentController extends Controller
{
    public function showPaymentList()
    {
        return view('ManagePayment.payment_list');
    }
}
