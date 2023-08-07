<?php
namespace app\models;

use yii\db\ActiveRecord;

class Products extends ActiveRecord{
    // private $product_name;
    // private $product_desc;
    // private $product_price;
    // private $product_image;
    public function rules()
    {
        return[
            [['product_name','product_desc','product_price'],'required'],
        ];
    }
   
}



?>