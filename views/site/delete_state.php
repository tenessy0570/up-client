<div class="staff-wrapper">
<form method="POST">
    <select name="id" id="" required> 
        <option value="fake">Название штата</option> <?php

        foreach($states as $state) { ?>
            <option value="<?= $state->id ?>"><?= $state->name ?></option> <?php
        } ?>
        
    </select>
    <input type="submit" value="Удалить">
    <p><?= $message ?? '' ?></p>
</form>
    
</div>
