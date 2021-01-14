<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Apply Middleware Verified in All Function
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * Menampilkan Detail User
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *   path="/api/user/me",
     *   tags={"User"},
     *   summary="Show User Detail",
     *   security={{"passport":{}}},
     *
     *   @OA\Response(
     *      response="200",
     *      description="OK"
     *   )
     * )
     */
    public function me(Request $request)
    {
        // get user login detail
        $user = $request->user();

        // array response
        $response = [
            'code'      => 200,
            'success'   => true,
            'data'      => $user
        ];

        // return json response
        return response()->json($response, $response['code']);
    }
}
