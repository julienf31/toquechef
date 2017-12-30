<?php

class ProfileController extends Controller
{

    public function editProfile($id)
    {
        $profile = Profile::find($id);
        if ($profile->id != Auth::user()->id) {
            Session::flash('danger-notif',"Perission non accordée");
            return Redirect::route('profile', $id);
        }

        $inputs = Input::all();

        $profile->firstname = $inputs['firstname'];
        $profile->lastname = $inputs['lastname'];
        $profile->save();

        Session::flash('success-notif','Votre profil à été actualisé');
        return Redirect::route('profile', $id);
    }

    public function editCredentials($id)
    {
        $profile = Profile::find($id);
        if ($profile->id != Auth::user()->id) {
            Session::flash('danger-notif',"Perission non accordée");
            return Redirect::route('profile', $id);
        }

        $rules = array(
            'newPassword'    => 'required|min:5',
            'confirmPassword' => 'required|min:5|same:newPassword'
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()){
            $data['credentialsErrors'] = true;
            return Redirect::to('profile')->withErrors($validator)->with('credentialsErrors', 'true');
        }


        $inputs = Input::all();

        if (Auth::validate(array('email' => Auth::user()->email, 'password' => $inputs['oldPassword']))) {
            if($inputs['newPassword'] == $inputs['confirmPassword']){

            }
            else{
                Session::flash('warning-notif',"Les deux mots de passes ne correspondent pas");
                return Redirect::route('profile', $id);
            }
        }
        else{
            Session::flash('warning-notif',"L'ancien mot de passe n'est pas bon");
            return Redirect::route('profile', $id);
        }
    }

    public function editInfos($id){
        $profile = Profile::find($id);
        if ($profile->id != Auth::user()->id) {
            Session::flash('danger-notif',"Perission non accordée");
            return Redirect::route('profile', $id);
        }

        $profile->location = Input::get('location');
        $profile->birthdate = Input::get('birthdate');
        $profile->description = Input::get('description');

        $profile->save();

        Session::flash('success-notif','Votre profil à été actualisé');
        return Redirect::route('profile', $id);
    }
}