<?php

class LoginController extends Controller {

    public function login()
    {
        $rules = array(
            'email'    => 'required|email',
            'password' => 'required|alphaNum|min:3'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            Session::flash('danger-notif',"Une erreur est survenue lors de l\'inscription, veuillez vérifier les champs");
            return Redirect::to('login')->withErrors($validator)->withInput(Input::except('password'));
        } else {

            $userdata = array(
                'email' 	=> Input::get('email'),
                'password' 	=> Input::get('password')
            );

            if (Auth::attempt($userdata)) {
                return Redirect::route('home');
            } else {
                Session::flash('danger-notif',"Mauvais identifiant / mot de passe");
                return Redirect::route('login')
                    ->withInput(Input::except('password'));
            }
        }
    }

    public function logout() {
        Auth::logout();
        return Redirect::route('home');
    }

    public function register(){
        $inputs = Input::only('firstname','lastname','email','password','passwordRepeat');

        $rules = array(
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'passwordRepeat' => 'required|min:6|same:password',
        );

        $validator = Validator::make($inputs,$rules);

        if ($validator->fails())
        {
            Session::flash('danger-notif',"Une erreur est survenue lors de l\'inscription, veuillez vérifier les champs");
            return Redirect::to('register')->withErrors($validator)->withInput(Input::all());
        }

        $user = new User();
        $user->email = $inputs['email'];
        $user->password =  Hash::make($inputs['password']);
        $user->save();

        $profile = new Profile();
        $profile->firstname = $inputs['firstname'];
        $profile->lastname = $inputs['lastname'];
        $profile->picture = 'avatar.png';

        File::makeDirectory("uploads/users/$user->id");
        File::copy('img/avatar.png',"uploads/users/$user->id/avatar.png");

        $profile = $user->profile()->save($profile);

        Session::flash('success-notif','Votre inscription à été validée, vous pouvez vous connecter');
        return Redirect::to('login');
    }
}