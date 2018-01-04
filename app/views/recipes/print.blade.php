@extends('template.print')

@section('content')
    <div class="box-header">
        <h3>ToqueChef - Fiche recette</h3>
        <hr style="border-color: #00a65a;">
        <p><b>Nom :</b> {{ $recipe->name }}</p>
        <p><b>Description :</b></p>
        <p>{{ $recipe->description }}</p>
        <p><b>Créée le :</b> <span class="text-light-blue">{{ $recipe->created_at }}</span></p>
        <p><b>Chef cuisto :</b> <a href="{{ route('profile', $recipe->owner->id) }}"><span
                        class="text-light-blue">{{ $recipe->owner->firstname.' '.$recipe->owner->lastname }}</span></a>
        </p>
        <p><b>Type :</b> <a href="{{ route('search.category', $recipe->category) }}"><span
                        class="text-light-blue">{{ $recipe->category }}</span></p></a>
        <p><b>Difficultée :</b> @for($i = 0; $i < $recipe->difficulty; $i++)
                <img src="{{asset('img/icons/chef.png')}}" style="width: 15px; display: inline-block;">
            @endfor</p>
        <p><b>Nombre de personnes :</b>&nbsp;{{ $recipe->persons }}</p>
        <p><b>Prix :</b>&nbsp;{{ $recipe->price }} €</p>
        <p><b>Prix/personnes :</b>&nbsp;{{ round($recipe->price/$recipe->persons, 2) }} €</p>
        <p><b>Nombre de likes:</b>&nbsp;{{ $recipe->likes }}</p>
    </div>
    <div class="box-body">
        <p><b>Photos :</b></p>
        @if(count($recipe->images)>1)
            @foreach($recipe->images as $key => $image)
                    <img style="max-width:50%;" src="{{ asset('uploads/recipes/'.$recipe->id.'/'.$image->name) }}">
            @endforeach
        @else
            <img style="max-width:50%;" src="{{ asset('uploads/recipes/'.$recipe->id.'/'.$recipe->images[0]->name) }}">
        @endif
    </div>
    <div class="box-body">
        <h3>Ingrédients</h3>
        <hr style="border-color: #00a65a;">
        @foreach($recipe->ingredients as $ingredient)
            <span class="text-green color-palette">{{ ucfirst($ingredient->name) }}</span>
            <span class="">{{ $ingredient->pivot->quantity.' '.$ingredient->pivot->unit}}</span>
            <br>
        @endforeach
        <h3>Etapes</h3>
        <hr style="border-color: #00a65a;">
        @if(count($recipe->steps) == 0)
            <p class="text-center">Il n'y à pas encore d'étapes pour cette recette</p>
        @else
            @foreach($recipe->steps as $key => $step)
                <span class="text-green text-bold">{{ $key+1 }}</span>
                {{ $step->order }}
                <br>
            @endforeach
        @endif
    </div>
@stop