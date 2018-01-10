@extends('template.theme')

@section('title')
    Recherche
@stop

@section('mainPage')
    Recherche
@stop

@section('linkToMain')
    /
@stop

@section('content')
    <div class="col-md-12">
        <p class="lead"><strong class="text-green">{{ $count }}</strong> resultats pour <strong
                    class="text-green">{{ $keyword }}</strong></p>
        <div style="border-top: 1px solid black;"></div>
    </div>
    <style type="text/css">
        .carousel-inner > .item > img, .carousel-inner > .item > a > img {
            width: 100%;
            height: 200px;
        }
    </style>
    <div class="container-fluid">
        <h2>Recettes <span class="badge bg-green">{{ count($recipes) }}</span></h2>
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
        <h2>Ingrédients <span class="badge bg-green">{{ count($ingredients) }}</span></h2>
        <hr style="border-color: #00a65a;">
        <div class="row">
            @if(count($ingredients)>0)
                @foreach($ingredients as $recipe)
                    {{ HTML::recipe($recipe,asset('uploads/recipes/'),route('recipes.details',$recipe->id),route('search.ingredients',''),4) }}
                @endforeach
            @else
                <div class="text-center">
                    Pas de résultat d'ingrédients pour cette recherche
                </div>
            @endif
        </div>
        <h2>Catégories <span class="badge bg-green">{{ count($categories) }}</span></h2>
        <hr style="border-color: #00a65a;">
        <div class="row">
            @if(count($categories)>0)
                @foreach($categories as $recipe)
                    {{ HTML::recipe($recipe,asset('uploads/recipes/'),route('recipes.details',$recipe->id),route('search.ingredients',''),4) }}
                @endforeach
            @else
                <div class="text-center">
                    Pas de résultat de catégories pour cette recherche
                </div>
            @endif
        </div>
    </div>

@stop

@section('scripts')

@stop