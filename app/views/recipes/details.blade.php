@extends('template.theme')

@section('title')
    {{ $recipe->name }}
@stop

@section('mainPage')
    Recettes
@stop

@section('linkToMain')
    /top
@stop

@section('content')
    <style type="text/css" xmlns="http://www.w3.org/1999/html">
        .carousel-inner > .item > img, .carousel-inner > .item > a > img {
            text-align: center;
            max-width: 100%;
            height: 300px;
        }

        @media print {
            a[href]:after {
                content: none !important;
            }
        }
    </style>
    <div class="col-md-8">
        <div class="box box-success">
            <div class="box-header">
                <h3>Fiche recette</h3>
            </div>
            <div class="box-header">
                <p><b>Description :</b></p>{{ $recipe->description }}
            </div>
            <div class="box-body">
                <p><b>Photos :</b></p>
                @if(count($recipe->images)>1)
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach($recipe->images as $key => $image)
                                <li data-target="#carousel-example-generic" data-slide-to="{{ $key }}"
                                    class="{{ ($key == 0) ? 'active':'' }}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach($recipe->images as $key => $image)
                                <div class="item {{ ($key == 0) ? 'active':'' }}">
                                    <img src="{{ asset('uploads/recipes/'.$recipe->id.'/'.$image->name) }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="{{ asset('uploads/recipes/'.$recipe->id.'/'.$recipe->images[0]->name) }}">
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        @if(Auth::user())
                            <a href="{{ route('recipes.favorite.add',$recipe->id) }}"
                               class="btn btn-danger btn-flat pull-left {{ ($favorite) ? 'active':'' }}"><i
                                        class="fa fa-heart{{ ($favorite) ? '':'-o' }}"></i> Favoris</a>
                            <a href="{{ route('recipes.like',$recipe->id) }}"
                               class="btn btn-facebook btn-flat pull-right {{ ($like) ? 'active':'' }}"><i
                                        class="fa fa-thumbs{{ ($like) ? '-up':'-o-up' }}"></i> J'aime
                                ( {{ $recipe->likes }}
                                )</a>
                        @else
                            <span class="pull-right"> <i class="fa fa-thumbs-up text-blue"></i> <?= $recipe->likes ?>
                                like<?php if ($recipe->likes > 1) {
                                    echo 's';
                                } ?></span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="box-body">
                @if(Auth::user() && (Auth::user()->id == $recipe->owner->id))
                    <a href="{{ route('recipes.step.add', $recipe->id) }}" class="btn btn-success btn-flat pull-right">Ajouter
                        une étape</a>
                @endif
                <h3>Etapes</h3>
                <hr style="border-color: #00a65a;">
                @if(count($recipe->steps) == 0)
                    <p class="text-center">Il n'y à pas encore d'étapes pour cette recette</p>
                @else
                    @foreach($recipe->steps as $key => $step)
                        <div class="col-xs-2">
                            @if(Auth::user() && (Auth::user()->id == $recipe->owner->id))
                                <a href="{{ route('recipes.step.edit', $step->id) }}"><i
                                            class="fa fa-pencil text-orange"></i></a>&nbsp;
                                <a href="{{ route('recipes.step.delete',$step->id) }}"><i
                                            class="fa fa-trash text-red"></i></a>&nbsp;&nbsp;
                            @endif
                            <span class="text-green text-bold">{{ $key+1 }}</span>
                        </div>
                        <div class="col-xs-10">{{ $step->order }}</div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="box box-success">
            <div class="box-header">
                <h3>Commentaires
                    <small class="badge bg-blue">{{ count($recipe->comments) }}</small>
                </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                @foreach($recipe->comments as $comment)
                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm"
                                 src="{{ asset('uploads/users/'.$comment->profile_id.'/'.$comment->profile->picture) }}"
                                 alt="user image">
                            <span class="username">
                                <a href="{{ route('profile', $comment->profile->id) }}">{{ ucfirst($comment->profile->firstname).' '.strtoupper($comment->profile->lastname) }}</a>
                                @if(Auth::user() && ($comment->profile_id == Auth::user()->id))
                                    <a href="{{ route('comments.delete', $comment->id) }}"
                                       class="pull-right btn-box-tool"><i class="fa fa-trash text-red"></i></a>
                                @endif
                            </span>
                            <span class="description">{{ $comment->created_at }}</span>
                        </div>
                        <p>
                            @if(preg_match("~(http.*\.)(jpe?g|png|[tg]iff?|svg)~i", $comment->comment, $img))
                                {{ $comment->comment }}

                                <img class="img-fluid" src="{{ $img[0] }}" style="max-width:100%">
                                @else
                            {{ $comment->comment }}
                                @endif
                        </p>
                    </div>
                @endforeach
                @if(Auth::user())
                    <hr>
                    {{ Form::open(array('route' => array('comments.add', $recipe->id))) }}
                    <label>Ajouter un commentaire</label>
                    <div class="form-group margin-bottom-none">
                        <div class="col-sm-9">
                            <input class="form-control input-sm" name="comment" placeholder="Commentaire ...">
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-danger pull-right btn-block btn-sm btn-flat">Envoyer
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
                @endif
            </div>
        </div>
    </div>
    @if(Auth::user() && (Auth::user()->id == $recipe->owner->id))
        <div class="col-md-4">
            <div class="box box-solid box-warning">
                <div class="box-header">
                    Gestion
                </div>
                <div class="box-body">
                    <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-warning btn-flat"><i
                                class="fa fa-gear"></i> Editer</a>
                    <button class="btn btn-danger pull-right btn-flat" data-toggle="modal" data-target="#modal-delete">
                        <i class="fa fa-trash"></i> Supprimer
                    </button>
                </div>
                <div class="box-footer">

                </div>
            </div>
        </div>
    @endif
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                Informations
            </div>
            <div class="box-body">
                <p><b>Créée le :</b> <span class="text-light-blue">{{ $recipe->created_at }}</span></p>
                <p><b>Chef cuisto :</b> <a href="{{ route('profile', $recipe->owner->id) }}"><span
                                class="text-light-blue">{{ $recipe->owner->firstname.' '.$recipe->owner->lastname }}</span></a>
                </p>
                <p><b>Type :</b> <a href="{{ route('search.category', $recipe->category) }}"><span
                                class="text-light-blue">{{ $recipe->category }}</span></p></a>
                <p><b style="display: inline-block">Difficultée :</b> @for($i = 0; $i < $recipe->difficulty; $i++) <img
                            src="{{asset('img/icons/chef.png')}}" style="width: 15px;"> @endfor</p>
                <p><b>Nombre de personnes :</b>&nbsp;{{ $recipe->persons }}</p>
                <p><b>Prix :</b>&nbsp;{{ $recipe->price }} €</p>
                <p><b>Prix/personnes :</b>&nbsp;{{ round($recipe->price/$recipe->persons, 2) }} €</p>
                <a href="{{ route('recipes.print',$recipe->id) }}" class="btn btn-success btn-flat"><i
                            class="fa fa-download"></i> Télécharger</a>
                <span class="btn btn-success btn-flat pull-right" onclick="window.print()"><i class="fa fa-print"></i> Imprimer</span>
            </div>
            <div class="box-footer">

            </div>
        </div>
        <div class="box box-info">
            <div class="box-header">
                Ingredients
                @if(Auth::user() && (Auth::user()->id == $recipe->owner->id))
                    <a href="{{ route('recipes.ingredients.manage', $recipe->id) }}"
                       class="btn btn-success btn-flat pull-right">Gestion des quantités</a>
                @endif
            </div>
            <div class="box-body">
                @foreach($recipe->ingredients as $ingredient)
                    <div class="row">
                        <div class="col-xs-6 col-xs-offset-1 bg-green color-palette">{{ ucfirst($ingredient->name) }}</div>
                        <div class="col-xs-3 bg-warning color-palette">{{ $ingredient->pivot->quantity.' '.$ingredient->pivot->unit}}</div>
                    </div><br>
                @endforeach

            </div>
            <div class="box-footer">

            </div>
        </div>
    </div>
    @if(Auth::user() && (Auth::user()->id == $recipe->owner->id))
        <div class="modal modal-danger fade" id="modal-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Confirmation</h4>
                    </div>
                    <div class="modal-body">
                        <p>Vous êtes sur le point de supprimer la recette : {{ $recipe->name }} publiée
                            le {{ $recipe->created_date }}</p>
                        <p>Voulez vous continuer ?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('recipes.delete', $recipe->id) }}" method="post">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-outline">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop

@section('scripts')

@stop