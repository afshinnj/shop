<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\HelloWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\Shop\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$script = <<< JS
    $(document).ready(function() {
            
        $('#shopID').change(function(){
             var shopID = $('#shopID').val();
             $('#categoryID').html('');
             $('#item').html('');
            $.post( "ajax",{ shop_id: shopID}, function( data ) {
                $('#categoryID').html( data );
       
              });
        
        });
        
        $('#categoryID').change(function(){
                 var categoryID = $('#categoryID').val(); 
                $.post( "ajax",{ category_id: categoryID}, function( data ) {
                    $('#item').html( data );
                  });
        });
        

    });

JS;
$this->registerJs($script);
?>


<?= HelloWidget::widget(['message' => '']) ?>
<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'shop_id')->dropDownList(\app\modules\Shop\models\Shop::Dropdown(), ['id' => 'shopID']) ?>

    <?= $form->field($model, 'category_id')->dropDownList([], ['id' => 'categoryID']) ?>

    <?= $form->field($model, 'item_id')->dropDownList([], ['id' => 'item']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
