<?php

namespace App\Http\Controllers;

use App\Models\Ro_client;
use Illuminate\Http\Request;

class RoClientController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {

        return view('contents.request-one-client.index');
    }


    function load(Request $request)
    {
        $param  = $request->q ? ['q' => $request->q] : [];
        $limit  = $request->limit;
        $lastId = $request->last_id;
        if($request->code) $param[] = ['ro_code', $request->code];

        echo json_encode(Ro_client::fetch(0, $param, $limit, $lastId));
    }

    function changeStatus(Request $request)
    {
        $i = 1;
        if($request->status == 1) $i = 0;
        $result = Ro_client::submit($request->id,  ['ro_active' => $i]);
        echo json_encode([
            'status' => boolval($result),
            'data'   => $result ? Ro_client::fetch($request->id) : []
        ]);
    }
}