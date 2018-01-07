@extends('template.theme')

@section('title')
    Mes favoris
@stop

@section('mainPage')
    Recettes
@stop

@section('linkToMain')
    /
@stop

@section('content')
    <style type="text/css">
        .carousel-inner > .item > img, .carousel-inner > .item > a > img {
            width: 100%;
            height: 200px;
        }
    </style>
    @if(count($recipes) == 0)
        <div class="col-md-8 col-md-offset-2 text-center">
            Vous n'avez pas de favoris, ajoutez une recette à vos favoris en appuyant sur le bouton : <br> <a class="btn btn-danger btn-flat"><i class="fa fa-heart-o"></i> Favoris</a>
        </div>
    @endif
    @foreach($recipes as $recipe)
        {{ HTML::recipe($recipe->recipe,asset('uploads/recipes/'),route('recipes.details',$recipe->recipe->id),route('search.ingredients',''),4) }}
    @endforeach

@stop

@section('scripts')

@stop