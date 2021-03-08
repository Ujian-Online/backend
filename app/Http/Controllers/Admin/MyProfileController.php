<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class MyProfileController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function show(Request $request)
    {
        // user detail
        $user = $request->user();

        // find user detail full
        $me = User::findOrFail($user->id);

        return view('my-profile', [
            'title'     => 'Detail Akun Saya',
            'action'    => '#',
            'isShow'    => route('admin.akun-saya.edit'),
            'query'     => $me,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function edit(Request $request)
    {
        // user detail
        $user = $request->user();

        // find user detail full
        $me = User::findOrFail($user->id);

        return view('my-profile', [
            'title'     => 'Ubah Detail Akun Saya',
            'action'    => route('admin.akun-saya.update'),
            'isEdit'    => true,
            'query'     => $me,
        ]);
    }

    // Update the specified resource in storage.
    public function update(Request $request)
    {
        // validate input
        $request->validate([
            'newpassword'       => 'nullable|min:6',
            'upload_profile'    => 'nullable|mimes:jpg,jpeg,png',
            'upload_sign'       => 'nullable|mimes:jpg,jpeg,png'
        ]);

        // get user login
        $user = $request->user();

        // get form data
        $dataInput = $request->only([
            'newpassword',
        ]);

        // find by id and update
        $query = User::findOrFail($user->id);

        // update password if new password field not empty
        if (isset($dataInput['newpassword']) and !empty($dataInput['newpassword'])) {
            $query->password = Hash::make($dataInput['newpassword']);
        }

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

        // redirect
        return redirect()
            ->route('admin.akun-saya.show');
    }
}
