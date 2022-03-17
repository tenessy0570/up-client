<div class="staff-wrapper">
<form method="POST">
    <select name="login" id="" required> 
        <option value="fake">Логин пользователя</option> <?php

        foreach($users as $user) { ?>
            <option value="<?= $user->id ?>"><?= $user->login ?></option> <?php
        } ?>
        
    </select>
    <input type="submit" value="Удалить">
</form>
    
</div>
