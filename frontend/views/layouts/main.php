<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use common\models\SubmissionThread;
use common\models\DocumentAssignment;

AppAsset::register($this);

$this->title = "BPSU OJT Timesheet Monitoring System for CICT Trainees";
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" crossorigin="anonymous"></script>
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

        ul.pagination
        {
            margin-top:10px;
        }

        ul.pagination li a
        {
            text-decoration: none;
            color:#af4343;
            font-size:12px;
            font-weight: bold;
        }

        ul.pagination li.active
        {
            background: #ffdbdb;
        }

        ul.pagination li
        {
            padding:10px;
            background:white;
            border:1px solid #ffdbdb;
        }

        .btn-outline-success,.btn-outline-primary,.btn-outline-danger,.btn-outline-secondary
        {
            background:white;
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
            border:1px solid #ffdbdb;
            border-bottom: none;
            color:#af4343;
            font-size:12px;
            background:white;
        }

        a.active-tab
        {
            padding:10px;
            text-decoration: none;
            border:1px solid #ffdbdb;
            border-bottom: none;
            background-color: #ffdbdb;
            color:#af4343;
            font-weight: bold;
            font-size:12px;

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

        /* GRID STYLE */
        
        table.table.table-striped thead tr th
        {
            font-size:11px;
            font-weight: normal;
            text-transform: uppercase;
            /* background:#af4343; */
            background: #ffdbdb;
            color:#af4343;
            text-align: center;
        }

        table.table.table-striped thead tr td select option,table.table.table-striped thead tr td select, table.table.table-striped thead tr td input
        {
            font-size: 11px;
        }

        table.table.table-striped thead tr th a
        {
            font-size:11px;
            text-decoration: none;
            font-weight: normal;
            color:#af4343;
        }

        table.table.table-striped tbody tr td
        {
            font-size:11px;
        }

        table.table.table-striped tbody tr td a
        {
            font-size:11px;
        }
        
        table.table.table-striped
        {
            background-color: white;
            padding-bottom: 0;
            margin-bottom: 0;
        }

        /* GRID STYLE _END */

        /* MENU ASSIGNMENT */
        ul.navbar-nav li.role-name
        {
            font-size:11px;
        }

        ul.navbar-nav li.role-name span#role-name-container
        {
            background:#ffdbdb;
            border-radius: 25px;
            padding:5px;
            color:#ae0505;
        }
        /* MENU ASSIGNMENT _END */
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
        $assignedProgram = Yii::$app->getModule('admin')->AssignedProgramTitle();
        $assignedCompany = Yii::$app->getModule('admin')->AssignedCompany();
        $assignedDepartment = Yii::$app->getModule('admin')->AssignedDepartment();

        $firstName = !empty(Yii::$app->user->identity->fname) ? "(".Yii::$app->user->identity->fname.")" : "";

        // if(Yii::$app->user->can("Administrator"))
        // {
        //     $roleName = "Administrator";
            
        // }
        // else if(Yii::$app->user->can("OjtCoordinator"))
        // {
        //     $roleName = "<span id='role-name-container'> OJT Coordinator  </span> of ".$assignedProgram." ".$firstName;
        // }
        // else if(Yii::$app->user->can("CompanySupervisor"))
        // {
        //     $roleName = "<span id='role-name-container'>Supervisor</span> at ".$assignedCompany.($assignedDepartment == "NOTHING" ? "" : ", ".$assignedDepartment)." ".$firstName;
        // }
        // else if(Yii::$app->user->can("Trainee"))
        // {
        //     $roleName = "<span id='role-name-container'>Trainee</span> at ".$assignedCompany.($assignedDepartment == "NOTHING" ? "" : ", ".$assignedDepartment)." ".$firstName;
        // }

        if(Yii::$app->user->can("Administrator"))
        {
            $roleName = "Administrator (".$firstName.")";
            
        }
        else if(Yii::$app->user->can("OjtCoordinator"))
        {
            $roleName = "<span id='role-name-container'> OJT Coordinator  ".$firstName."</span> ";
        }
        else if(Yii::$app->user->can("CompanySupervisor"))
        {
            $roleName = "<span id='role-name-container'>Supervisor ".$firstName."</span> ";
        }
        else if(Yii::$app->user->can("Trainee"))
        {
            $roleName = "<span id='role-name-container'>Trainee ".$firstName." </span> ";
        }

        // echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
        //     . Html::submitButton(
        //         'Logout ('.$roleName.')',
        //         ['class' => 'btn btn-link logout text-decoration-none']
        //     )
        //     . Html::endForm();
        
        $countTask = Yii::$app->getModule('admin')->submissionThreadSeen();

        $menuItemsLeft = [
            [
                'label' => 'Timesheet', 'url' => ['/user-timesheet'], 'active' => Yii::$app->controller->id == "user-timesheet" ? true : false,
                'visible' => Yii::$app->user->can('menu-timesheet'),
            ],
            [
                'label' => 'User Management', 'url' => ['/user-management','UserDataSearch[item_name]' => 'Trainee'], 'active' => Yii::$app->controller->id == "user-management" ? true : false,
                'visible' => Yii::$app->user->can('menu-user-management'),
            ],
            [
                'label' => 'Map Markers', 'url' => ['/user-company/google-map'], 'active' => Yii::$app->controller->action->id == "google-map" ? true : false,
                'visible' => Yii::$app->user->can('menu-map-markers'),
            ],
            [
                'label' => 'Tasks ('.$countTask.')', 'url' => ['/submission-thread/index'], 'active' => Yii::$app->controller->id == "submission-thread" ? true : false,
                'visible' => Yii::$app->user->can('menu-tasks'),
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
                'document-type',
                'document-assignment',
                'coordinator-programs',
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
                'options' => ['class' => 'nav-item dropdown role-name'],
                'linkOptions' => ['class' => 'nav-link dropdown-toggle', 'data-bs-toggle' => 'dropdown', 'role' => 'button', 'aria-expanded' => 'false'],
            ],
        ];
        
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
            'items' => $menuItemsLeft,
            'encodeLabels' => false,
        ]);
        
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-md-0'],
            'items' => $menuItemsRight,
            'encodeLabels' => false,
        ]);
        
    }

    

    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container-fluid">
        <?php 
            if (!Yii::$app->user->isGuest) { ?>

        <?php
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
        <p class="float-end"><?php // Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
