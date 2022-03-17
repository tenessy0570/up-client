<form method="post">
   <div class="form">
      <h1>Добавление нового пользователя</h1>
      <input type="text" name="login" placeholder="Логин" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <input type="text" name="first_name" placeholder="Имя" required>
      <input type="text" name="last_name" placeholder="Фамилия" required>
      <input type="text" name="middle_name" placeholder="Отчество" required>

      <select name="gender" id="" required>
         <option value="fake">Пол</option>
         <option value="Мужской">Мужской</option>
         <option value="Женский">Женский</option>
      </select>

      <input type="text" name="post" placeholder="Должность" required>
      <input type="text" name="home_address" placeholder="Адрес прописки" required>
      <label for="birth_date">Дата рождения</label>
      <input type="date" name="birth_date" placeholder="Дата рождения" id="birth_date" required>

      <select name="state" id="" required>
         <option value="fake" selected>Штат</option>
         <?php

         foreach ($states as $state) { ?>
            <option value=<?= $state->id ?>><?= $state->name ?></option> <?php
         } ?>
         
      </select>

      <button>Создать</button>
      <?= $error ?? '' ?>
   </div>
</form>