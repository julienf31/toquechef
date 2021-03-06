<?php

/**
 * Profile Controller
 *
 * Method for profile management
 *
 * @copyright  2018 Toque Chef
 */
class ProfileController extends Controller
{

    /**
     *
     * Edit Credentials
     * Auth Required, user()->id must match with profile->id
     *
     * @param       integer $id Profile id
     * @return      Redirect
     *
     */
    public function editCredentials($id)
    {
        $profile = Profile::find($id);
        if ($profile->id != Auth::user()->id) {
            Session::flash('danger-notif', "Perission non accordée");
            return Redirect::route('profile', $id);
        }

        $rules = array(
            'newPassword' => 'required|min:5',
            'confirmPassword' => 'required|min:5|same:newPassword'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            $data['credentialsErrors'] = true;
            return Redirect::route('profile', $id)->withErrors($validator)->with('credentialsErrors', 'true');
        }


        $inputs = Input::all();

        if (Auth::validate(array('email' => Auth::user()->email, 'password' => $inputs['oldPassword']))) {
            if ($inputs['newPassword'] == $inputs['confirmPassword']) {
                $user = User::find($id);
                $user->password = Hash::make($inputs['confirmPassword']);
                $user->save();
                Session::flash('success-notif', "Le mot de passe à été actualisé");
                return Redirect::route('profile', $id);
            } else {
                Session::flash('warning-notif', "Les deux mots de passes ne correspondent pas");
                return Redirect::route('profile', $id);
            }
        } else {
            Session::flash('warning-notif', "L'ancien mot de passe n'est pas bon");
            return Redirect::route('profile', $id);
        }
    }

    /**
     *
     * Edit Infos
     * Auth Required, user()->id must match with profile->id
     *
     * @param       integer $id Profile id
     * @return      Redirect
     *
     */
    public function editInfos($id)
    {
        $profile = Profile::find($id);
        if ($profile->id != Auth::user()->id) {
            Session::flash('danger-notif', "Perission non accordée");
            return Redirect::route('profile', $id);
        }

        $file = false;
        //Upload file
        if (Input::file('profilePicture')) {
            $file = Input::file('profilePicture');
            $destinationPath = "uploads/users/$id/";
            $filename = 'avatar.' . $file->getClientOriginalExtension();
            $upload_success = $file->move($destinationPath, $filename); //move img to storage in uploads/users/...
            if (!$upload_success) {
                return Redirect::to('profile');
            }
            $file = true;
        }

        if ($file) {
            $profile->picture = $filename;
        }

        $profile->location = Input::get('location');
        $profile->birthdate = date('Y-d-m', strtotime(Input::get('birthdate')));
        $profile->description = Input::get('description');
        $profile->save();

        Session::flash('success-notif', 'Votre profil à été actualisé');
        return Redirect::route('profile', $id);
    }

    /**
     *
     * Edit Profile
     * Auth Required, user()->id must match with profile->id
     *
     * @param       integer $id Profile id
     * @return      Redirect
     *
     */
    public function editProfile($id)
    {
        $profile = Profile::find($id);
        if ($profile->id != Auth::user()->id) {
            Session::flash('danger-notif', "Perission non accordée");
            return Redirect::route('profile', $id);
        }

        $inputs = Input::all();

        $profile->firstname = $inputs['firstname'];
        $profile->lastname = $inputs['lastname'];
        $profile->save();

        Session::flash('success-notif', 'Votre profil à été actualisé');
        return Redirect::route('profile', $id);
    }
}