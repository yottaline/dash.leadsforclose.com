<?php

namespace App\Http\Controllers;

use App\Models\R_attachment;
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

    function GetAttachment(Request $request)
    {
        echo json_encode(R_attachment::fetch(0, [['attach_reClient', $request->id]]));
    }
}