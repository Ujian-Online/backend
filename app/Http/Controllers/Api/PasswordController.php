<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\PasswordReset;
use App\User;
use Illuminate\Http\Request;
use Mail;

class PasswordController extends Controller
{
    /**
     * Reset Password Function
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/password/reset",
     *     tags={"Authentication"},
     *     summary="Reset Password",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request Reset Password",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     description="account email",
     *                     type="string",
     *                     example="johndoe@example.com"
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     )
     * )
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // get email input
        $email = $request->input('email');

        // search email asesi
        $user = User::where('email', $email)
                    ->where('type', 'asessi')
                    ->firstOrFail();

        // Generate User Token
        $token = $user->createToken('Api')->accessToken;

        // kalau user di temukan, kirim email reset password
        Mail::to($user->email)->send(new PasswordReset($token, $user));

        // return response success

        // array response
        $response = [
            'code'      => 200,
            'success'   => true,
        ];

        // return json response
        return response()->json($response, $response['code']);
    }
}
