<div class="get-average-age">
    <a href="<?= app()->route->getUrl('/getAverageAge') ?>">Подсчитать средний возраст сотрудников</a>
    <span><?= $age ?? 'Подсчитайте средний возраст!' ?></span>  
</div>


<a class='get-staff' href="<?= app()->route->getUrl('/getDivisionStaff') ?>">Показать список сотрудников по подразделению</a> <br>
<a class='get-staff' href="<?= app()->route->getUrl('/getStateStaff') ?>">Показать список сотрудников по штату</a>

<?php 
$isAdmin = true;

if ($isAdmin) { ?>
    <hr>
    <h2>Действия администратора</h2>
    <div class="admin-actions">
        <a class="add-new" href="<?= app()->route->getUrl('/createNewUser') ?>">Создать нового пользователя</a>
        <a class="add-new" href="<?= app()->route->getUrl('/createNewState') ?>">Создать новый штат</a>
        <a class="add-new" href="<?= app()->route->getUrl('/createNewDivision') ?>">Создать новое подразделение</a> 
    </div> <?php
} ?>