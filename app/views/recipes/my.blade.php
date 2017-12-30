@extends('template.theme')

@section('title')
    Mes recettes
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
    @foreach($recipes as $recipe)
        {{ HTML::recipe($recipe,asset('uploads/recipes/'),route('recipes.details',$recipe->id),route('search.ingredients',''),4) }}
    @endforeach

@stop

@section('scripts')

@stop