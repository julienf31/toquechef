@extends('template.theme')

@section('title')
    {{ ($add) ? 'Ajouter une étape':'Editer une étape' }}
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
                <h4>{{ ($add) ? 'Ajouter une étape à':'Editer une étape de' }} la recette : {{ $recipe->name }}</h4>
            </div>
            {{ Form::open(array('route' => ($add) ? array('recipes.step.add', $recipe->id): array('recipes.step.edit', $step->id))) }}
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-10 col-md-12">
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        <div class="form-group {{ $errors->has('order') ? 'has-error' : ''}}">
                            <label for="order">Description de l'étape</label>
                            <textarea class="form-control" name="order" placeholder="Description de l'étape ..."
                                      rows="5" style="resize: none;">{{ ($add) ? Input::old('order'):$step->order }} </textarea>
                            @if($errors->has('desc')) <span
                                    class="help-block">{{ $errors->first('order') }}</span> @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <a href="{{ route('recipes.details', $recipe->id) }}" class="btn btn-danger btn-flat">Retour</a>
                <button type="submit" name="submitButton" class="btn btn-success pull-right btn-flat">{{ ($add) ? 'Ajouter' : 'Editer' }}</button>
                <button type="reset" class="btn btn-warning pull-right margin-r-5 btn-flat">Vider</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="callout callout-info">
            <h4><i class="fa fa-warning"></i> Formulaire d'ajout d'étape</h4>

            <p>Attention aux informations saisies, la vérification de champs empêche une saisie incorecte.</p>
            <dl class="dl-horizontal">
                <dt>Description de l'étape</dt>
                <dd>Obligatoire</dd>
            </dl>
        </div>
    </div>
@stop

@section('scripts')

@stop