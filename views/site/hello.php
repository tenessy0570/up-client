<div class="get-average-age">
    <a href="<?= app()->route->getUrl('/getAverageAge') ?>">Подсчитать средний возраст сотрудников</a>
    <span><?= $age ?? 'Подсчитайте средний возраст!' ?></span>
</div>


<a class='get-staff' href="<?= app()->route->getUrl('/getDivisionStaff') ?>">Показать список сотрудников по подразделению</a> <br>
<a class='get-staff' href="<?= app()->route->getUrl('/getStateStaff') ?>">Показать список сотрудников по штату</a>

<?php
$isAdmin = $isAdmin ?? false;

if ($isAdmin) { ?>
    <hr>
    <h2>Действия администратора</h2>
    <div class="admin-actions-wrapper">
        <div class="admin-actions">
            <a class="add-new" href="<?= app()->route->getUrl('/createNewUser') ?>">Создать нового пользователя</a>
            <a class="add-new" href="<?= app()->route->getUrl('/createNewState') ?>">Создать новый штат</a>
            <a class="add-new" href="<?= app()->route->getUrl('/createNewDivision') ?>">Создать новое подразделение</a>
        </div>
        <div class="admin-actions">
            <a href="<?= app()->route->getUrl('/deleteUser') ?>" class="add-new">Удалить пользователя</a>
            <a href="<?= app()->route->getUrl('/deleteState') ?>" class="add-new">Удалить штат</a>
            <a href="<?= app()->route->getUrl('/deleteDivision') ?>" class="add-new">Удалить подразделение</a>
        </div>
    </div>

<?php
} ?>