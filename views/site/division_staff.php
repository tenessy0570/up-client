<div class="division-staff-wrapper">
<form method="POST">
    <select name="division" id="" required> 
        <option value="fake">Подразделение</option> <?php

        foreach($divisions as $division) { ?>
            <option value="<?= $division->id ?>"><?= $division->name ?></option> <?php
        } ?>
        
    </select>
    <input type="submit" value="Показать сотрудников">
    <table>
        <tr>
            <td>Имя</td>
            <td>Фамилия</td>
            <td>Штат</td>
            <td>Должность</td>
        </tr> <?php
        if (isset($staff)) {
            foreach ($staff as $worker) { ?>
                <tr>
                    <td><?= $worker->first_name ?></td>
                    <td><?= $worker->last_name ?></td>
                    <td><?= $worker->state_name ?></td>
                    <td><?= $worker->post ?></td>
                </tr> <?php
            } 
        } ?>

    </table>
</form>
    
</div>
