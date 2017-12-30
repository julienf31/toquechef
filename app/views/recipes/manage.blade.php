@extends('template.theme')

@section('title')
    {{ $recipe->name }} : Ingredients
@stop

@section('mainPage')
    Recettes
@stop

@section('linkToMain')
    /top
@stop

@section('content')
        <div class="col-md-8">
            <div class="box box-success">
                <form action="{{ route('recipes.ingredients.manage', $recipe->id) }}" method="post">
                <div class="box-header">
                    Liste des ingrédients
                </div>
                <div class="box-header">
                    <p><b>Gestion des quantités :</b></p>
                    @foreach($recipe->ingredients as $ingredient)
                        <p>{{ $ingredient->name }}</p>
                        <div class="input-group">
                        Quantité : <input class="input-group-sm" type="text" name="{{ $ingredient->id }}-qty" value="{{ $ingredient->pivot->quantity }}">
                        Unité :
                            <select name="{{ $ingredient->id }}-unit">
                                @foreach(Config::get('params.units') as $unit)
                                    <option value="{{ $unit }}" {{ ($ingredient->pivot->unit == $unit) ? 'selected':'' }}>{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                    @endforeach
                </div>
                <div class="box-footer">
                    <button class="btn btn-success btn-flat" type="submit">Enregistrer</button>
                </div>
                </form>
            </div>
        </div>
@stop

@section('scripts')

@stop