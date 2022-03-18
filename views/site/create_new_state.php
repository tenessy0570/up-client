<form method="post">
   <div class="form">
      <h1>Добавление нового штата</h1>
      <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
      <input type="text" name="name" placeholder="Название" required>

      <select name="division" id="" required>
         <option value="fake">Подразделение</option>
         
         <?php
         foreach ($divisions as $division) { ?>
            <option value="<?= $division->id ?>"><?= $division->name ?></option> <?php
         } ?>
      </select>

      <button>Создать</button>
      <?= $error ?? '' ?>
   </div>
</form>