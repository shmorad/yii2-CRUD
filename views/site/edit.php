<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="row">  
        <div class="col-md-8 m-auto">    
            <div class="card mt-5">
                <div class="card-header">
                    <h2 style="color: #337ab7;">Edit Product.</h2> 
                </div>
                <div class="card-body">
                        <?php $form=ActiveForm::begin() ?>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <?= $form->field($products,'product_name')->label('Product Name');?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <?= $form->field($products,'product_desc')->textarea(['row'=>'12'])->label('Product Description');?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <?= $form->field($products,'product_price')->input('number')->label('Product Price');?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                <?= $form->field($products,'product_image')->fileInput()->label('Product Image');?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <?= Html::submitButton('Upadte', ['class' => 'btn btn-primary']) ?>
                                    <a href="<?php echo yii::$app->homeUrl;?>" class="btn btn-secondary">Go Back</a>
                                </div>
                            </div>
                           <?php ActiveForm::end() ?>
                </div>
            </div>
        </div> 
    </div>
</div>
