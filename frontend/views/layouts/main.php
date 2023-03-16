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
        
        div.form-group
        {
            margin-top: 10px;
        }

        ul li.page-item.disabled
        {
            display: none;
        }

        a.custom-tab
        {
            padding:10px;
            text-decoration: none;
            border:1px solid #ddd;
            border-bottom: none;
            color:gray;
        }

        a.active-tab
        {
            padding:10px;
            text-decoration: none;
            border:3px solid #ddd;
            border-bottom: none;
            background-color: #ddd;
            color:gray;
            font-weight: bold;
        }

        button.link-logout
        {
            color:white !important;
            border-radius: 25px;
        }

        button.link-logout:hover
        {
            color: #ddd !important;
            border:1px solid #ddd !important;
            border-radius: 25px;
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
        $roleName = "";
        if(Yii::$app->user->can("Administrator"))
        {
            $roleName = "Administrator";
        }
        else if(Yii::$app->user->can("OjtCoordinator"))
        {
            $roleName = "OjtCoordinator";
        }
        else if(Yii::$app->user->can("CompanySupervisor"))
        {
            $roleName = "CompanySupervisor";
        }
        else if(Yii::$app->user->can("Trainee"))
        {
            $roleName = "Trainee";
        }

        // echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
        //     . Html::submitButton(
        //         'Logout ('.$roleName.')',
        //         ['class' => 'btn btn-link logout text-decoration-none']
        //     )
        //     . Html::endForm();

        $menuItemsLeft = [
            [
                'label' => 'User Management', 'url' => ['/user-management','UserDataSearch[item_name]' => 'Trainee'], 'active' => Yii::$app->controller->id == "user-management" ? true : false,
                'visible' => Yii::$app->user->can('menu-user-management'),
            ],
            [
                'label' => 'Map Markers', 'url' => ['/user-company/google-map'], 'active' => Yii::$app->controller->action->id == "google-map" ? true : false,
                'visible' => Yii::$app->user->can('menu-map-markers'),
            ],
            ['label' => 'Settings', 'url' => ['/settings'], 'active' => in_array(Yii::$app->controller->id,[
                'settings',
                'auth-item',
                'auth-item-child',
                'suffix',
                'student-year',
                'student-section',
                'ref-program',
                'program-major',
                'position',
                'department',
                'company',
                ]) ? true : false,
                'visible' => Yii::$app->user->can('menu-settings'),
            ],
        ];
        
        $menuItemsRight = [
            [
                'label' => $roleName,
                'items' => [
                    ['label' => 'My Account', 'url' => ['user-management/update-my-account','id' => Yii::$app->user->identity->id]],
                    [
                        'label' => 'My e-Signature', 'url' => ['user-management/upload-my-signature','id' => Yii::$app->user->identity->id],
                        'visible' => Yii::$app->user->can('upload-signature'),
                    ],
                    [
                        'label' => 'Logout',
                        'url' => \yii\helpers\Url::to(['site/logout']),
                        'linkOptions' => [
                            'class' => 'dropdown-item',
                            'data-method' => 'post',
                            'data-confirm' => 'Are you sure you want to logout?',
                            'href' => \yii\helpers\Url::to(['site/logout'])
                        ],
                    ],
                    
                    // Add more submenu items as needed
                ],
                'options' => ['class' => 'nav-item dropdown'],
                'linkOptions' => ['class' => 'nav-link dropdown-toggle', 'data-bs-toggle' => 'dropdown', 'role' => 'button', 'aria-expanded' => 'false'],
            ],
        ];
        
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
            'items' => $menuItemsLeft,
        ]);
        
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-md-0'],
            'items' => $menuItemsRight,
        ]);
        
    }

    

    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container-fluid">
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
