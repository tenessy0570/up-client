<form method="post">
   <div class="form">
      <h1>Добавление нового подразделения</h1>
      <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
      <input type="text" name="name" placeholder="Название" required>
      <input type="text" name="type" placeholder="Тип" required>

      <select name="company" id="" required>
         <option value="fake">Компания</option>
         
         <?php
         foreach ($companies as $company) { ?>
            <option value="<?= $company->id ?>"><?= $company->name ?></option> <?php
         } ?>
      </select>

      <button>Создать</button>
      <?= $error ?? '' ?>
   </div>
</form>