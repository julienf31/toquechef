@extends('template.theme')

@section('title')
    404 - not found
@stop

@section('mainPage')
    Erreur
@stop

@section('linkToMain')
    /
@stop

@section('content')
    <div class="col-md-offset-2 col-md-8">
        <div class="text-center font-weight-bold text-green">
            <h1>4o4</h1>
        </div>
        <div class="text-center text-uppercase">
            <h3>La page recherchée n'existe pas</h3>
        </div>
        <div class="text-center">
            <p>Veuillez vérifier votre recherche et recommencer</p>
            <p><a href="{{ route('home') }}" class="btn btn-flat btn-success"><i class="fa fa-arrow-left"></i> Retour à l'acceuil</a></p>
        </div>
    </div>
@stop

@section('scripts')

@stop