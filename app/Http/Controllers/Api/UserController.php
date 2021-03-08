<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     *
     * @OA\Post(
     *   path="/api/user",
     *   tags={"User"},
     *   summary="Update Foto atau TTD",
     *   security={{"passport":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Update Foto atau TTD",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="upload_profile",
     *                     description="Upload Gambar Profile. Ekstensi: JPG/JPEG/PNG",
     *                     type="file",
     *                     example="profile.png"
     *                 ),
     *                 @OA\Property(
     *                     property="upload_sign",
     *                     description="Upload TTD/Paraf. Ekstensi: JPG/JPEG/PNG",
     *                     type="file",
     *                     example="paraf.png"
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
    public function signature(Request $request)
    {
        // validate input
        $request->validate([
            'upload_profile'    => 'nullable|mimes:jpg,jpeg,png',
            'upload_sign'       => 'nullable|mimes:jpg,jpeg,png'
        ]);

        // get user login
        $user = $request->user();

        // find by id and update
        $query = User::findOrFail($user->id);

        // upload file profile picture to s3
        if($request->file('upload_profile')) {
            $query->media_url = upload_to_s3($request->file('upload_profile'));
        }

        // upload file ttd/paraf to s3
        if($request->file('upload_sign')) {
            $query->media_url_sign_user = upload_to_s3($request->file('upload_sign'));
        }

        // update data
        $query->update();

        // update response
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $query,
        ]);
    }
}
