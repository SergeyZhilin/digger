<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;

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
            return $this->goBack();
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
            return $this->goHome();
        }
        $model = new SignupForm();

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $user = new User();
            $user->username = $model->username;
            $user->email = $model->email;
            $user->password = \Yii::$app->security->generatePasswordHash($model->password);
            if($user->save()){
                return $this->render('login');
            }
        }

        return $this->render('signup', compact('model'));
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
        return$this->render('profile');
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
     * Display changepass page.
     *
     * @return string
     */
    public function actionChangepass()
    {
        return$this->render('changepass');
    }

    /**
     * Display payments page.
     *
     * @return string
     */
    public function actionPayments()
    {
        return$this->render('payments');
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
