<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardSettingController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function account()
    {
        $user = Auth::user();
        return view('pages.dashboard-account', [
            'user' => $user,
        ]);
    }

    public function update(AccountRequest $request, $redirect)
    {
        $data = $request->validated();

        $user = Auth::user();
        $user->update($data);

        // Jika ada pembaruan foto profil
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('profile-photos', 'public');
            $user->photo = $photoPath;
            $user->save();
        }

        return redirect()->route($redirect)->with('success', 'Profil berhasil diperbarui.');
    }
}
