<?php

namespace App\Http\Controllers;

use App\Helpers\PhoneHelper;
use App\Models\Customer;

class HomeController extends Controller
{
    public function index()
    {
        $phones = Customer::pluck('phone');
        $phoneHelper = new PhoneHelper($phones);
        $phones = $phoneHelper->getParsedPhones();
        return inertia('index', [
            'phones' => $phones
        ]);
    }
}
