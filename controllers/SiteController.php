<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Products;
use yii\data\Pagination;
use yii\web\UploadedFile;
use app\models\productsSearch;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // $query = Products::find()->where(['status' => 1])->orderBy($sort->orders);
        $query = Products::find()->orderBy(['id'=>SORT_DESC]);
        
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index',[
            'models' => $models,
            'pages' => $pages,
        ]);
    }


    public function actionCreate()
    {
        
        $product = new Products();
        $formData = yii::$app->request->post();
        if($product->load($formData)){
            $product->product_image = UploadedFile::getInstance($product,'product_image');
            $file_name = time().'.'.$product->product_image->extension;
            $product->product_image->saveAs('uploads/'.$file_name);
            $product->product_image =$file_name;
            if($product->save()){
                yii::$app->getSession()->setFlash('message','Product Successfully Inserted .!');
                return $this->goHome();
            }
        } else{
            yii::$app->getSession()->setFlash('message','Faild to Product .!');
        }
        return $this->render('create',['products'=>$product]);
    }
    public function actionEdit($id){
        
        $product =Products::findOne($id);
        if($product->load(yii::$app->request->post())){
            $product->product_image = UploadedFile::getInstance($product,'product_image');
            $file_name = time().'.'.$product->product_image->extension;
            $product->product_image->saveAs('uploads/'.$file_name);
            $product->product_image =$file_name;
            $product->save();
            yii::$app->getSession()->setFlash('message','Product Successfully Updated.!');
            return $this->goHome(['id'=>$product->id]);
        }else{
            return $this->render('edit',['products'=>$product]);
        }  
    }
    public function actionDelete($id)
    {
        $product = Products::findOne($id)->delete();
        if($product){
            yii::$app->getSession()->setFlash('message','Product Successfully Deleted.!');
            return $this->goHome();
        }
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionSearch()
    {
        $search = new productsSearch();
        $result  = $search->Searches(Yii::$app->request->queryParams);
        $query = Yii::$app->request->queryParams;
        return $this->render('search', [
            'searchModel'  => $search,
            'dataProvider' => $result,
            'query'        => $query['search'],
        ]);
    }
}
