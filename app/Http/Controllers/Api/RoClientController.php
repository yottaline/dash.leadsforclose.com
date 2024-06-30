<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ro_client;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoClientController extends Controller
{
    function register(Request $request)
    {
        $email = $request->email;
        $phone = $request->phone;

        $params = [
            'ro_code'      => uniqidReal(8),
            'ro_fullName'  => $request->name,
            'ro_email'     => $email,
            'ro_phone'     => $phone,
            'ro_created'   => Carbon::now()
        ];

        $result = Ro_client::submit(null, $params);

        echo json_encode(['status' => boolval($result)]);
    }
}