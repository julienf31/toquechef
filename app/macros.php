<?php

HTML::macro('recipe', function ($recipe, $asset, $linkToRecipe, $linkToIngredients, $size) {
    ob_start();
    ?>
    <div class="col-md-<?= $size ?>">
        <div class="box box-success">
            <div class="box-header">
                <?= $recipe->name ?>
            </div>
            <div class="box-body no-padding bg-black">
                <?php if (count($recipe->images) > 1): ?>
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php foreach ($recipe->images as $key => $image): ?>
                                <li data-target="#carousel-example-generic" data-slide-to="<?= $key ?>"
                                    class="<?php if ($key == 0) {
                                        echo 'active';
                                    } ?>"></li>
                            <?php endforeach; ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php foreach ($recipe->images as $key => $image): ?>
                                <div class="item <?php if ($key == 0) {
                                    echo 'active';
                                } ?>">
                                    <img src="<?= $asset . '/' . $recipe->id . '/' . $image->name ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="<?= $asset . '/' . $recipe->id . '/' . $recipe->images[0]->name ?>">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="box-body">
                <?php foreach ($recipe->ingredients as $ingredient): ?>
                    <a href="<?= $linkToIngredients . '/' . $ingredient->id ?>">
                        <small class="label bg-blue"><?= $ingredient->name ?></small>
                    </a>&nbsp;
                <?php endforeach; ?>
            </div>
            <div class="box-footer">
                <i class="fa fa-thumbs-up text-blue"></i> <?= $recipe->likes ?> like<?php if ($recipe->likes > 1) {
                    echo 's';
                } ?>
                <a href="<?= $linkToRecipe ?>" class="btn btn-flat btn-success pull-right"><i
                            class="fa fa-arrow-right"></i> Voir la recette</a>
            </div>
        </div>
    </div>
    <?php

    return ob_get_clean();
});

HTML::macro('linkProfile', function ($user) {
    ob_start();
    ?>
        <a href=""><?= ucfirst($user->firstname).' '.strtoupper($user->lastname) ?></a>
    <?php
    return ob_get_clean();
});

HTML::macro('input', function($name, $label, $place, $errors, $old = null){
   ob_start();
   ?>

    <div class="form-group <?= $errors->has($name) ? 'has-error' : '' ?>">
        <label for="<?= $name ?>"><?= $label ?></label>
        <input type="text" class="form-control" name="<?= $name ?>" placeholder="<?= $place ?>"
               value="<?= $old ?>">
        <?php if($errors->has($name)): ?>
        <span class="help-block"><?= $errors->first($name) ?></span>
        <?php endif; ?>
    </div>

    <?php
    return ob_get_clean();
});


HTML::macro('textarea', function($name, $label, $place, $errors, $old = null){
    ob_start();
    ?>

    <div class="form-group <?= $errors->has($name) ? 'has-error' : '' ?>">
        <label for="<?= $name ?>"><?= $label ?></label>
        <textarea class="form-control" name="<?= $name ?>" placeholder="<?= $place ?>"
                  rows="5" style="resize: none;"><?= $old ?></textarea>
        <?php if($errors->has($name)): ?>
            <span class="help-block"><?= $errors->first($name) ?></span>
        <?php endif; ?>
    </div>

    <?php
    return ob_get_clean();
});

HTML::macro('horizontal_input', function($name, $label, $place, $errors, $old = null, $type = null){
    ob_start();
    ?>

    <div class="form-group <?= ($errors->has($name)) ? 'has-error':''  ?>">
        <label for="<?= $name ?>" class="col-sm-2 control-label"><?= $label ?></label>
        <div class="col-sm-10">
            <input type="<?= $type ?>" class="form-control" name="<?= $name ?>"
                   value="<?= $old ?>">
        </div>
        <?php if($errors->has($name)): ?>
        <span class="help-block"><?= $errors->first($name) ?></span>
        <?php endif; ?>
    </div>

    <?php
    return ob_get_clean();
});
