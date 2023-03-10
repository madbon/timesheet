<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
    <style>
        body
        {
            background:#f5f6ff;
        }
        h1
        {
            font-size:25px;
        }
        .navbar
        {
            background:maroon;
            
        }

        .navbar
        {
            padding-bottom: 0;
        }

        .navbar .navbar-nav .nav-link
        {
            color:white;
        }

        .navbar .navbar-nav .dropdown-item.active
        {
            color:#ae0505;
            border-radius: 0px;
            background:#ffdbdb;
        }
        
        @media (max-width: 767px) {
            .navbar .navbar-nav .active
            {
                color:#ae0505;
                background:#f5f6ff;
                padding-left:5px;
                border-radius: 5px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .navbar .navbar-nav .active
            {
                color:#ae0505;
                background:#f5f6ff;
                border-radius: 15px 15px 0px 0px;
            }
        }

        @media (min-width: 992px) and (max-width: 1199px) {
            .navbar .navbar-nav .active
            {
                color:#ae0505;
                background:#f5f6ff;
                border-radius: 15px 15px 0px 0px;
            }
        }

        @media (min-width: 1200px) {
            .navbar .navbar-nav .active
            {
                color:#ae0505;
                background:#f5f6ff;
                border-radius: 15px 15px 0px 0px;
            }
        }

        .help-block
        {
            color: #ae0505;
        }
        
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => false,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md fixed-top navbar-inverse',
            'style' => Yii::$app->user->isGuest ? 'display:none;' : 'background:#ae0505;',
        ],
    ]);
    
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => false];
    }
    else
    {
        $menuItems = [
            ['label' => 'User Management', 'url' => ['/user-management'], 'active' => Yii::$app->controller->id == "user-management" ? true : false],
            [
                'label' => 'Settings',
                'items' => [
                    // ['label' => 'Role', 'url' => ['/cms-role'],
                    //     'active' => Yii::$app->controller->id == "cms-role" ? true : false,
                    // ],
                    // ['label' => 'Role Assignments', 'url' => ['/cms-role-assignment']],
                    // ['label' => 'Actions', 'url' => ['/cms-role-actions']],
                    ['label' => 'Roles', 'url' => ['/auth-item/roles'],
                        'active' => Yii::$app->controller->action->id == "roles" ? true : false,
                    ],
                    ['label' => 'Permissions', 'url' => ['/auth-item/permissions'],
                        'active' => Yii::$app->controller->action->id == "permissions" ? true : false,
                    ],
                ],
                'active' => in_array(Yii::$app->controller->id,['auth-item','auth-item-child']) ? true : false
            ],
        ];

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
            'items' => $menuItems,
        ]);
    }

    
    if (Yii::$app->user->isGuest) {
        // echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
    } else {
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();
    }
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?php 
            if (!Yii::$app->user->isGuest) {
                echo Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
            }
        ?>
        <?= Alert::widget() ?>

        <?= $content ?>
        
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
