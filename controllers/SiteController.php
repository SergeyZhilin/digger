<?php

namespace app\controllers;

use app\models\PaymentsForm;
use app\models\ProfileForm;
use app\models\User;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\PasswordForm;
use yii\web\UploadedFile;

class SiteController extends MainController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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
        return $this->render('index');
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
            return $this->redirect('office');
        }
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

    /**
     * Display signup page.
     *
     * @return string
     */
    public function actionSignup(){
        if (!Yii::$app->user->isGuest) {
            return $this->render('office');
        }
        $model = new SignupForm();

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $user = new User();
            $user->username = $model->username;
            $user->email = $model->email;
            $user->password = \Yii::$app->security->generatePasswordHash($model->password);

            if($user->save()){
                return $this->render('office');
            }
        }

        return $this->render('signup', compact('model'));
    }

    /**
     * ChangePassword
     */
    public function actionChangepass(){
        $model = new PasswordForm;
        $modeluser = User::find()->where([
            'id'=>Yii::$app->user->identity->id
        ])->one();
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                try{
                    $modeluser->password = \Yii::$app->security->generatePasswordHash($_POST['PasswordForm']['newpass']);
                    if($modeluser->save()){
                        Yii::$app->getSession()->setFlash(
                            'success','Password changed'
                        );
                        return $this->redirect(['changepass']);
                    }else{
                        Yii::$app->getSession()->setFlash(
                            'error','Password not changed'
                        );
                        return $this->redirect(['changepass']);
                    }
                }catch(Exception $e){
                    Yii::$app->getSession()->setFlash(
                        'error',"{$e->getMessage()}"
                    );
                    return $this->render('changepass',[
                        'model'=>$model
                    ]);
                }
            }else{
                return $this->render('changepass',[
                    'model'=>$model
                ]);
            }
        }else{
            return $this->render('changepass',[
                'model'=>$model
            ]);
        }
    }

    /**
     * Display office page.
     *
     * @return string
     */
    public function actionOffice()
    {
        return$this->render('office');
    }

    /**
     * Display deposits page.
     *
     * @return string
     */
    public function actionDeposits()
    {
        return$this->render('deposits');
    }

    /**
     * Display operations page.
     *
     * @return string
     */
    public function actionOperations()
    {
        return$this->render('operations');
    }

    /**
     * Display payin page.
     *
     * @return string
     */
    public function actionPayin()
    {
        return$this->render('payin');
    }

    /**
     * Display payout page.
     *
     * @return string
     */
    public function actionPayout()
    {
        return$this->render('payout');
    }

    /**
     * Display profile page.
     *
     * @return string
     */
    public function actionProfile()
    {
        $model = new ProfileForm();
        $modeluser = User::find()->where([
            'id'=>Yii::$app->user->identity->id
        ])->one();

        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            $model->image = UploadedFile::getInstance($model, 'image');

            if ($model->upload()) {
                $modeluser->image = $model->image->name;
            }

            if ($model->save()) {
                $modeluser->name = $model->name;
                $modeluser->surname = $model->surname;
                $modeluser->username = $model->username;
                $modeluser->email = $model->email;
            }

            if($modeluser->save()){
                return $this->render('profile', ['model'=>$model]);
            }
        }
        return$this->render('profile', ['model'=>$model]);
    }

    /**
     * Display refsys page.
     *
     * @return string
     */
    public function actionRefsys()
    {
        return$this->render('refsys');
    }

    /**
     * Display account page.
     *
     * @return string
     */
    public function actionAccount()
    {
        return$this->render('account');
    }


    /**
     * Display payments page.
     *
     * @return string
     */
    public function actionPayments()
    {
        $model = new PaymentsForm();
        $modeluser = User::find()->where([
            'id'=>Yii::$app->user->identity->id
        ])->one();

        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            if ($model->save()){
                $modeluser->perfectmoney = $model->perfectmoney;
                $modeluser->advancedcash = $model->advancedcash;
                $modeluser->bitcoin = $model->bitcoin;
                $modeluser->default_pay = $model->default_pay;
            };

            if($modeluser->save()){
                return $this->render('payments', ['model'=>$model]);
            }
        }
        return$this->render('payments', ['model'=>$model]);
    }

    /**
     * Display pin page.
     *
     * @return string
     */
    public function actionPin()
    {
        return$this->render('pin');
    }

}
