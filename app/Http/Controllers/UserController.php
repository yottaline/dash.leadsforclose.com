<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('contents.user.index');
    }

    function load(Request $request)
    {
        $param  = $request->q ? ['q' => $request->q] : [];
        $limit  = $request->limit;
        $lastId = $request->last_id;

        echo json_encode(User::fetch(0, $param, $limit, $lastId));
    }

    function submit(Request $request)
    {
        $id = $request->id;
        $param = [
            'user_name'    => $request->name,
            'user_email'   => $request->email,
            'user_password' => Hash::make($request->password)
        ];

        if (!$id) {
            $param['user_code'] = uniqidReal(8);
            $param['user_created'] = Carbon::now();
        } else {
            $param['user_modified'] = Carbon::now();
            $param['user_modified_by'] = auth()->user()->id;
        }

        $result = User::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? User::fetch($result) : [],
        ]);
    }
}
