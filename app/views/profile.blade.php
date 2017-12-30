@extends('template.theme')

@section('title')
    Profil de {{ ucfirst($profile->firstname)." ".strtoupper($profile->lastname) }}
@stop

@section('content')

    <div class="col-md-4">

        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle"
                     src="{{ asset('uploads/users/'.$profile->id.'/'.$profile->picture) }}" alt="">

                <h3 class="profile-username text-center">{{ ucfirst($profile->firstname)." ".strtoupper($profile->lastname) }}</h3>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Inscription</b> <a
                                class="pull-right">{{ date_format(new DateTime($profile->user->created_at), "d/m/Y") }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Date de naissance</b> <a
                                class="pull-right">{{ date_format(new DateTime($profile->birthdate), "d/m/Y") }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>E-Mail</b> <a class="pull-right">{{ $profile->user->email }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">À Propos</h3>
            </div>
            <div class="box-body">
                <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

                <p class="text-muted"></p>

                <hr>

            </div>
        </div>
    </div>

    @if(Auth::user() && (Auth::user()->id == $profile->user->id))
        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li @if(!Session::has('credentialsErrors')) class="active" @endif><a href="#settings"
                                                                                         data-toggle="tab"
                                                                                         aria-expanded="true"><i
                                    class="fa fa-gears" aria-hidden="true"></i> &nbsp;Paramétres</a></li>
                    <li @if(Session::has('credentialsErrors')) class="active" @endif><a href="#credentials"
                                                                                        data-toggle="tab"
                                                                                        aria-expanded="true"><i
                                    class="fa fa-lock" aria-hidden="true"></i> &nbsp;Sécurité</a></li>
                    <li><a href="#profile" data-toggle="tab" aria-expanded="true"><i class="fa fa-info-circle"
                                                                                     aria-hidden="true"></i> &nbsp;Informations</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane  @if(!Session::has('credentialsErrors')) active @endif" id="settings">
                        {{ Form::open(array('route' => array('profile.edit',Auth::user()->id ), 'class' => 'form-horizontal')) }}
                            {{ HTML::horizontal_input('firstname','Prénom', 'Entrez votre prénom', $errors, $profile->firstname) }}
                            {{ HTML::horizontal_input('lastname','Nom', 'Entrez votre nom', $errors, $profile->lastname) }}
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}"
                                       disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success">Envoyer</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <div class="tab-pane  @if(Session::has('credentialsErrors')) active @endif" id="credentials">
                        {{ Form::open(array('route' => array('profile.edit.credentials', Auth::user()->id ), 'class' => 'form-horizontal')) }}
                            {{ HTML::horizontal_input('oldPassword','Ancien mot de passe', 'Tapez votre ancien mot de passe', $errors, '', 'password') }}
                            {{ HTML::horizontal_input('newPassword','Nouveau mot de passe', 'Tapez votre ancien mot de passe', $errors, '', 'password') }}
                            {{ HTML::horizontal_input('confirmPassword','Répetez', 'Tapez votre ancien mot de passe', $errors, '', 'password') }}
                            <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success">Envoyer</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <div class="tab-pane" id="profile">

                        {{ Form::open(array('route' => array('profile.edit.infos', Auth::user()->id ), 'class' => 'form-horizontal','files' => true)) }}
                        <div class="form-group">
                            <label for="location" class="col-sm-3 control-label">Localisation</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <input type="text" class="form-control" name="localisation"
                                           value="{{ Auth::user()->location }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birthdate" class="col-sm-3 control-label">Date de naissance</label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" id="datemask" class="form-control" name="birthdate"
                                           data-inputmask="'alias': 'dd/mm/yyyy'" data-mask=""
                                           value="{{ date('d-m-Y', strtotime($profile->birthdate)) }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="profilePicture" class="col-sm-3 control-label">Photo de profil</label>

                            <div class="col-sm-9">
                                <input type="file" id="profilePicture" name="profilePicture">
                                <p class="help-block">Formats : JPG, PNG Max : 5Mb</p>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="location" class="col-sm-3 control-label">Compétences</label>
                            <div class="col-sm-9">
                                <select class="form-control select2 select2-hidden-accessible" name="skills[]"
                                        multiple="true" data-placeholder="Compétences" style="width: 100%;"
                                        tabindex="-1" aria-hidden="true">

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc" class="col-sm-3 control-label">Description</label>

                            <div class="col-sm-9">
                                <textarea class="form-control" rows="5" placeholder="Entrez une description ..."
                                          style="resize: none;" name="desc">{{ Auth::user()->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-10">
                                <button type="submit" class="btn btn-success">Envoyer</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop

@section('scripts')
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select2').select2();
            $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});

        })
    </script>
@stop