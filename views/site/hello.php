<div class="get-average-age">
    <a href="<?= app()->route->getUrl('/getAverageAge') ?>">Подсчитать средний возраст сотрудников</a>
    <span><?= $age ?? 'Подсчитайте средний возраст!' ?></span>  
</div>


<a class='get-division-staff' href="<?= app()->route->getUrl('/getDivisionStaff') ?>">Показать список сотрудников по подразделению</a>