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

        if (count(Ro_client::where('ro_phone', $phone)->get())) {
            echo json_encode(['status' => false, 'message' => __('This phone number is already registered'),]);
            return;
        }

        if ($email &&  count(Ro_client::where('ro_email', $email)->get())) {
            echo json_encode(['status' => false, 'message' => __('This email address is already registered'),]);
            return;
        }

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