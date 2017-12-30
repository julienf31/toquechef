@extends('template.theme')

@section('title')
    {{ $title }}
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
    @if(count($recipes)>0)
        @foreach($recipes as $recipe)
            {{ HTML::recipe($recipe,asset('uploads/recipes/'),route('recipes.details',$recipe->id),route('search.ingredients',''),4) }}
        @endforeach
    @endif
@stop

@section('scripts')

@stop