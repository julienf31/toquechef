@extends('template.theme')

@section('title')
    Accueil
@stop

@section('content')
    <div class="col-md-offset-2 col-md-8 text-center ">
        <h3>Bienvenue sur ToqueChef</h3>
        <b>ToqueChef</b> est un site communautaire de partage de recettes de cuisines. Vous pouvez consulter les
        recettes de nos utilisateurs sans créer de compte, ou créer un compte pour partager vos recettes, commenter les
        recettes des autres utilisateurs, ou ajouter des recettes à votre portefeuille de recettes.
        <div class="row margin">
            @if(!Auth::user())
                <a href="{{ route('login') }}" class="btn btn-flat btn-success">Connectez-vous</a>
                <a href="{{ route('register') }}" class="btn btn-flat btn-warning">Inscrivez-vous</a>
            @endif
        </div>
    </div>
    <br/>
    <div class="col-md-12 text-center bg-green margin">
        <h3 class="text-white">Rechercher une recette :</h3>
        <form action="{{ route('search') }}" method="post" class="">
            <div class="input-group col-md-6 col-md-offset-3">
                <input type="text" name="search" class="form-control no-border no-shadow" placeholder="Recherche ...">
                <span class="input-group-btn">
                <button type="submit" name="launchSearch" id="search-btn" class="btn btn-flat btn-warning"><i
                            class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <p class="margin">Saisissez un mot clef, un nom de recette, ou même un ingrédient, nous nous occupons de trouver
            la recette quil vous faut</p>
        <p class="margin">Pour faire une recherche multiple, séparez les mots clef par un espace</p>
    </div>
    <div class="col-md-12 no-padding">
        <h3 class="text-center">Quelques chiffres</h3><br>
        <div class="row margin">
            {{HTML::stats_home('glyphicon glyphicon-apple', "Recettes", $recipes)}}
            {{HTML::stats_home('glyphicon glyphicon-grain', "Ingrédients", $ingredients)}}
            {{HTML::stats_home('glyphicon glyphicon-user', "Utilisateurs", $users)}}
            {{HTML::stats_home('glyphicon glyphicon-comment', "Commentaires", $comments)}}
        </div>
    </div>
@stop