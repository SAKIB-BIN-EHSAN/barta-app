<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileEditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getProfileView()
    {
        return view('profile');
    }

    public function getEditProfileFormView()
    {
        $user = Auth::user();
        $fullName = explode(" ", $user->full_name);
        $nameWordLength = count($fullName);
        if ($nameWordLength != 1) {
            $lastName = $fullName[$nameWordLength-1];
            $firstName = "";
    
            for ($i=0; $i<$nameWordLength-1; $i++) {
                $firstName .= $fullName[$i];
    
                if($i != ($nameWordLength-2)) {
                    $firstName .= " ";
                }
            }
        }
        else {
            $firstName = $fullName[$nameWordLength-1];
            $lastName = "";
        }
        
        return view('edit_profile', compact('user', 'firstName', 'lastName'));
    }

    public function editProfile(ProfileEditRequest $profileEditRequest)
    {
        $user = Auth::user();
        $data = $profileEditRequest->validated();

        $lastName = $data['last_name'] ?? null;
        if ($lastName != null) {
            $data['full_name'] = $data['first_name'] . " " . $lastName;
        }
        else {
            $data['full_name'] = $data['first_name'];
        }
        
        $data['password'] = Hash::make($profileEditRequest->password);

        unset($data['first_name']);
        unset($data['last_name']);

        $result = DB::table('users')->where('id', $user->id)->update($data);
        if ($result) {
            return redirect('/profile');
        }
        return redirect('/edit-profile');
    }
}
