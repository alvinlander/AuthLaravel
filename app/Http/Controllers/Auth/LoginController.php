<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Resources\UserResources;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request)
    {
        $data = $request->all();
        $user = User::whereEmail($data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user['password'])) {
            throw ValidationException::withMessages([
                "email" => "the credentials are incorrect"
            ]);
        }
        $user->tokens()->delete();
        $token = $user->createToken('web-token');
        // return response()->json([
        //     '_token' => $token->plainTextToken,
        //     'user' => $user
        // ]);
        return (new UserResources($user))->additional([
            "token" => $token->plainTextToken
        ]);
    }
}
