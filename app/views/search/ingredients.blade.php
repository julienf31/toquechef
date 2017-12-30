@extends('template.theme')

@section('title')
    Résultat de recettes avec l'ingrédient : {{ $keyword }}
@stop

@section('mainPage')
    Recherche
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
    <div class="container-fluid">
        <h2>Recettes <span class="badge bg-green">{{ count($recipes) }}</span> </h2>
        <hr style="border-color: #00a65a;">
        <div class="row">
            @if(count($recipes)>0)
                @foreach($recipes as $recipe)
                    {{ HTML::recipe($recipe,asset('uploads/recipes/'),route('recipes.details',$recipe->id),route('search.ingredients',''),4) }}
                @endforeach
            @else
                <div class="text-center">
                    Pas de résultat de recettes pour cette recherche
                </div>
            @endif
        </div>
    </div>
@stop

@section('scripts')

@stop