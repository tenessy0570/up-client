<h3><?= app()->auth->user()->name ?? ''; ?></h3>
<?php
if (!app()->auth::check()) :
?>
    <form method="post">
        <div class="form">
            <h1>Вход</h1>
            <input type="text" name="login" required placeholder="Логин">
            <input type="password" name="password" required placeholder="Пароль">
            <button>Войти</button>
            <p><?= $message ?? ''; ?></p>

        </div>
    </form>
<?php endif;
