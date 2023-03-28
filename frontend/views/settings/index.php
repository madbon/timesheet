<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
?>
<style>
ul li a
{
    text-decoration: none;
}
ul li a:hover
{
    text-decoration: underline;
}
</style>

<h1>SYSTEM SETTINGS</h1>

<div class="row">
    <?php if(Yii::$app->user->can('settings-roles-permission-container')){ ?>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Roles/Permissions</h5>
                <p class="card-text">
                    <ul>
                        <?= Yii::$app->user->can('settings-roles') ?  "<li>".Html::a('Roles',['/auth-item/roles'])."</li>" : "" ?>
                        <?= Yii::$app->user->can('settings-permissions') ?  "<li>".Html::a('Permissions',['/auth-item/permissions'])."</li>" : ""  ?>

                        <?= Yii::$app->user->can('settings-role-assignments') ?  "<li>".Html::a('Role Assignments',['/auth-item-child'])."</li>" : ""   ?>
                    </ul>
                </p>
            </div>
        </div>
    </div>
    <?php } ?>

    <?php if(Yii::$app->user->can('settings-user-accounts-form-reference-container')){ ?>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User Account Form Reference</h5>
                <p class="card-text">
                    <ul>
                        <?= Yii::$app->user->can('settings-list-suffix') ?  "<li>".Html::a('List of Suffix',['/suffix']) ."</li>" : "" ?>
                        <?=  Yii::$app->user->can('settings-list-student-year') ?  "<li>".Html::a('List of Student Year',['/student-year']) ."</li>" : ""  ?>
                        <?=  Yii::$app->user->can('settings-list-student-section') ?  "<li>".Html::a('List of Student Section',['/student-section']) ."</li>" : ""  ?>
                        <?=  Yii::$app->user->can('settings-list-program-course') ?  "<li>".Html::a('List of Program/Course & Total Required Hours',['/ref-program']) ."</li>" : ""  ?>
                        <?=  Yii::$app->user->can('settings-list-majors') ?  "<li>".Html::a('List of Program/Course Majors',['/program-major']) ."</li>" : ""  ?>
                        <?=  Yii::$app->user->can('settings-list-positions') ?  "<li>".Html::a('List of Positions',['/position']) ."</li>" : ""  ?>
                        <?=  Yii::$app->user->can('settings-list-departments') ?  "<li>".Html::a('List of Departments',['/department']) ."</li>" : ""  ?>
                        <?=  Yii::$app->user->can('settings-list-document-type') ?  "<li>".Html::a('List of Document Types',['/document-type']) ."</li>" : ""  ?>
                        <?=  Yii::$app->user->can('settings-list-document-type') ?  "<li>".Html::a('List of Document Assignments',['/document-assignment']) ."</li>" : ""  ?>
                    </ul>
                </p>
            </div>
        </div>
    </div>
    <?php  } ?>

    <?php  if(Yii::$app->user->can('settings-mapping-tagging-container')){ ?>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Mapping/Tagging</h5>
                <p class="card-text">
                    <ul>
                        <?=  Yii::$app->user->can('settings-list-companies') ?  "<li>".  Html::a('List of Companies',['/company/index'])."</li>" : "" ?>
                    </ul>
                </p>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
