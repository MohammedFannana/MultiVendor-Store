<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = Auth::user();
        return view('dashboard.profile.edit', [
            'user' => $user,

            // getName('en' or 'ar'=arabic)
            'countries' => Countries::getNames(),
            'locales' => Languages::getNames(),

        ]);
    }


    public function update(Request $request)
    {

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'birthday'   => ['nullable', 'date', 'before:today'],
            'gender'     => ['in:male,female'],
            'country'    => ['required', 'string', 'size:2'],
        ]);

        $user = $request->user();   // == $user = Auth::user()

        //************ */
        // use fill() if the profile not found work create 
        //if profile found work update 
        // fill()->save() use to crate and update 
        // fill()->save() بدل ما اعمل شرط اذا في داتا اعمل تحديث اذا ما في اعمل انشاء بنستخدم   

        $user->profile->fill($request->all())->save();
        return redirect()->route('dashboard.profile.edit')
            ->with('success', 'Profile Update!');
    }
}
