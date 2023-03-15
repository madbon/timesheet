<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
?>
<h1>SYSTEM SETTINGS</h1>

<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Roles/Permissions</h5>
                <p class="card-text">
                    <ul>
                        <li><?=  Html::a('Roles',['/auth-item/roles']); ?></li>
                        <li><?=  Html::a('Permissions',['/auth-item/permissions']); ?></li>
                        <li><?=  Html::a('Role Assignments',['/auth-item-child']); ?></li>
                    </ul>
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User Account Form Reference</h5>
                <p class="card-text">
                    <ul>
                        <li><?=  Html::a('Suffix',['/suffix']); ?></li>
                        <li><?=  Html::a('Student Year',['/student-year']); ?></li>
                        <li><?=  Html::a('Student Section',['/student-section']); ?></li>
                        <li><?=  Html::a('Program/Course',['/ref-program']); ?></li>
                        <li><?=  Html::a('Program/Course Majors',['/program-major']); ?></li>
                    </ul>
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Mapping/Tagging</h5>
                <p class="card-text">
                    <ul>
                        <li><?=  Html::a('Create Company',['/company/create']); ?></li>
                        <li><?=  Html::a('List of Companies',['/company/index']); ?></li>
                    </ul>
                </p>
            </div>
        </div>
    </div>
</div>
