<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\R_attachment;
use App\Models\Rt_client;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RtClientController extends Controller
{
    function create(Request $request)
    {
        $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            'phone'  => 'required|numeric|unique:rt_clients,rt_phone',
            'email'  => 'required|email|unique:rt_clients,rt_email',
            'file.*' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $params = [
            'rt_code'       => uniqidReal(8),
            'rt_firstName'  => $request->f_name,
            'rt_lastName'   => $request->l_name,
            'rt_email'      => $request->email,
            'rt_phone'      => $request->phone,
            'rt_umberSeats' => $request->um_seats,
            'rt_state'      => $request->seats,
            'rt_created'    => Carbon::now(),
        ];


        $result = Rt_client::create($params);

        if ($request->file('file')) {
            foreach ($request->file('file') as $file) {
                $fileName = uniqidReal(4) . '.' . $file->getClientOriginalExtension();
                $file->move('attachments/' . $fileName);
                R_attachment::create([
                    'attach_reClient'  => $result->id,
                    'attach_file'      =>  $fileName,
                    'attach_created'   => Carbon::now(),
                ]);
            }
        }
        echo json_encode(['status' => boolval($result)]);
    }
}
