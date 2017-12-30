@extends('template.theme')

@section('title')
    Ajouter une recette
@stop

@section('mainPage')
    Recette
@stop

@section('linkToMain')
    /
@stop

@section('content')
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header">
                <h4>Ajouter une recette</h4>
            </div>
            {{ Form::open(array('route' =>'recipes.add', 'files' => true)) }}
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-10 col-md-12">
                        {{ HTML::input('name', 'Nom de la recette', 'Nom', $errors, Input::old('name')) }}
                        {{ HTML::textarea('desc', 'Description de la recette', 'Description', $errors, Input::old('desc')) }}

                        <div class="form-group {{ $errors->has('img') ? 'has-error' : ''}}">
                            <label for="img">Images</label>
                            <input type="file" name="img[]" multiple>
                            <span id="file" class="help-block">Un ou plusieurs fichiers, 2Mo max, JPEG, PNG</span>
                            @if($errors->has('img')) <span class="help-block">{{ $errors->first('img') }}</span> @endif

                        </div>
                        <div class="form-group">
                            <label for="category">Catégorie</label>
                            <select class="form-control select2 select2-hidden-accessible" name="category"
                                    style="width: 100%;" tabindex="-1" aria-hidden="true">
                                @foreach($categories as $category)
                                    <option value="{{ $category }}"> {{ $category }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group {{ $errors->has('ingredients') ? 'has-error' : ''}}">
                            <label for="ingredients">Ingredients</label>
                            <select class="form-control select2 select2-hidden-accessible" name="ingredients[]"
                                    multiple="true" data-placeholder="Ingrédients" style="width: 100%;" tabindex="-1"
                                    aria-hidden="true">
                                @foreach($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}" @if((Input::old('ingredients') !== null) && in_array($ingredient->id,Input::old('ingredients'))) selected @endif> {{ ucfirst($ingredient->name) }} </option>
                                @endforeach
                            </select>
                            @if($errors->has('ingredients')) <span
                                    class="help-block">{{ $errors->first('ingredients') }}</span> @endif
                            <span id="descIngredients" class="">Les quantités seront saisies apres</span>
                            <span id="descIngredients" class="help-block"><a data-toggle="modal"
                                                                             data-target="#modal-add">L'ingrédients que vous cherchez n'est pas référencé ? Ajoutez le ici</a> </span>
                        </div>
                        <div class="form-group">
                            <label for="desc">Difficultée</label>
                            <select class="form-control select2 select2-hidden-accessible" name="difficulty"
                                    style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="1" @if(Input::old('difficulty') == 1) selected @endif> Facile</option>
                                <option value="2" @if(Input::old('difficulty') == 2) selected @endif> Moyen</option>
                                <option value="3" @if(Input::old('difficulty') == 3) selected @endif> Difficile</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="desc">Nombre de personnes</label>
                            <select class="form-control select2 select2-hidden-accessible" name="persons"
                                    style="width: 100%;" tabindex="-1" aria-hidden="true">
                                @foreach(Config::get('params.persons') as $persons)
                                    <option value="{{ $persons }}"
                                            @if(Input::old('persons') == $persons) selected @endif> {{ $persons }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="desc">Prix <span id="priceLabel"></span>€</label>
                            <input id="price" class="slider" type="text" name="price" data-slider-min="1"
                                   data-slider-max="100"
                                   data-slider-step="1" data-slider-value="10" data-slider-id="red"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <a href="{{ route('recipes.my') }}" class="btn btn-danger">Retour</a>
                <button type="submit" name="submitButton" class="btn btn-success pull-right">Ajouter</button>
                <button type="reset" class="btn btn-warning pull-right margin-r-5">Vider</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <!-- Colonne de droite, aide à la saisie -->
    <div class="col-md-6">
        <div class="callout callout-info">
            <h4><i class="fa fa-warning"></i> Formulaire d'ajout de Recette</h4>

            <p>Attention aux informations saisies, la vérification de champs empêche une saisie incorecte.</p>
            <dl class="dl-horizontal">
                <dt>Nom de la recette</dt>
                <dd>Au moins 2 caractéres.</dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>Description de la recette</dt>
                <dd>Au moins 20 caractéres.</dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>Images</dt>
                <dd>Au moins 1 image.</dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>Ingrédients</dt>
                <dd>Au moins 1 ingrédient.</dd>
            </dl>
        </div>
    </div>

    <!-- Modal d'ajout d'ingredients -->
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Ajouter un ingredient</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('route' =>'ingredients.add')) }}

                    <div class="row">
                        <div class="col-lg-10 col-md-12">
                            <div class="form-group">
                                <label for="ingredientName">Nom de l'ingredient</label>
                                <input type="text" class="form-control" name="ingredientName"
                                       placeholder="Nom de l'ingredient">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal">Retour</button>
                    <button type="submit" class="btn btn-success pull-right btn-flat">Ajouter</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('bootstrap-slider/bootstrap-slider.js') }}"></script>
    <script>
        $(function () {
            $('.select2').select2();
            $('.slider').slider();

            $('#price').on('slide', function () {
                $('#priceLabel').html($('#price').val());
            });

            $('#price').on('change', function () {
                $('#priceLabel').html($('#price').val());
            });
        })
    </script>
@stop