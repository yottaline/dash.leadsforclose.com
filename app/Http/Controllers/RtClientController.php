<?php

namespace App\Http\Controllers;

use App\Models\Rt_client;
use Illuminate\Http\Request;

class RtClientController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('contents.request-two-client.index');
    }

    function load(Request $request)
    {
        $param  = $request->q ? ['q' => $request->q] : [];
        $limit  = $request->limit;
        $lastId = $request->last_id;
        if($request->code) $param[] = ['rt_code', $request->code];

        echo json_encode(Rt_client::fetch(0, $param, $limit, $lastId));
    }

    function changeStatus(Request $request)
    {
        $i = 1;
        if($request->status == 1) $i = 0;
        $result = Rt_client::submit($request->id,  ['rt_status' => $i], null);
        echo json_encode([
            'status' => boolval($result),
            'data'   => $result ? Rt_client::fetch($request->id) : []
        ]);
    }
}