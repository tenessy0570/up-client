<div class="staff-wrapper">
<form method="POST">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <select name="id" id="" required> 
        <option value="fake">Название подразделения</option> <?php

        foreach($divisions as $division) { ?>
            <option value="<?= $division->id ?>"><?= $division->name ?></option> <?php
        } ?>
        
    </select>
    <input type="submit" value="Удалить">
    <p><?= $message ?? '' ?></p>
</form>
    
</div>
