<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterRequest $request)
    {
        try {
            $req = $request->all();
            $req['password'] = bcrypt($request->password);
            User::create($req);
            return response()->json([
                'message' => "You're Registered"
            ]);
        } catch (Exception $e) {
            return $e;
        }
    }
}
