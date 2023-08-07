<?php
use yii\helpers\html;
use yii\bootstrap5\LinkPager;
/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="jumbotron text-center bg-transparent mt-3 mb-5">
        <h2 style="color: #337ab7;">Welcome to Unlock Live Ltd !</h2>
        <h6 style="color: #337ab7;">CRUD Operation for Task ---- Unlock Live Ltd.</h6>
    </div>
    <?php if(yii::$app->session->hasFlash('message')): ?>
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong><?php echo yii::$app->session->getFlash('message') ?></strong>
        </div>
    <?php endif;?>
    <div class="row">
      <span><?= Html::a('Create',['/site/create'],['class'=>'btn btn-primary mb-2']) ?></span>
    </div>   
    <div class="body-content">
        <div class="row">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr class="text-center">
                        <th scope="col">SL.</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Description</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Product Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($models)>0):?>
                        <?php foreach($models as $sl=>$model): ?>
                    <tr>
                        <td><?php echo $sl+1 ?></td>
                        <td><?php echo $model->product_name ?></td>
                        <td><?php echo $model->product_desc ?></td>
                        <td><strong>৳ </strong><?php echo $model->product_price ?></td>
                        <td class="text-center"><img src="uploads/<?php echo $model->product_image ?>"></td>
                        <td class="d-flex">
                        <span><?= Html::a('Edit',['edit','id'=>$model->id],['class'=>'mx-2 badge bg-primary text-decoration-none '],) ?></span> 
                        <span><?= Html::a('Delete',['delete','id'=>$model->id],['class'=>'badge bg-danger text-decoration-none']) ?></span> 
                        </td>
                    </tr>
                    <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td>Data Not Found !</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php
            echo LinkPager::widget(['pagination' => $pages]);
        
            ?>
              
        </div>
        
    </div>
</div>
