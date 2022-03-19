<div class="staff-wrapper">
<form method="POST">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <select name="state" id="" required> 
        <option value="fake">Штат</option> <?php

        foreach($states as $state) { ?>
            <option value="<?= $state->id ?>"><?= $state->name ?></option> <?php
        } ?>
        
    </select>
    <input type="submit" value="Показать сотрудников">
    <table>
        <tr>
            <td>Имя</td>
            <td>Фамилия</td>
            <td>Должность</td>
        </tr> <?php
        if (isset($staff)) {
            foreach ($staff as $worker) { ?>
                <tr>
                    <td><?= $worker->first_name ?></td>
                    <td><?= $worker->last_name ?></td>
                    <td><?= $worker->post ?></td>
                </tr> <?php
            } 
        } ?>

    </table>
</form>
    
</div>
