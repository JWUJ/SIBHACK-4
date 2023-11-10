<?php 
use portal\modules\Auth;
use portal\modules\Themes;

$auth = Auth::getInstance();

if($auth->checkAuth() == True){header('Location: /');}
require_once Themes::getInstance()->current()['path'] . "/header.php";

if(isset($_GET['login']) and isset($_GET['password'])){
    if ($auth->login($_GET['login'], $_GET['password']) == false){
        echo ('
        <div class="alert alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span>Ошибка! Пароль или логин неверный(</span>
        </div>
        ');
        
    }else{
        echo('
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>Вы успешно вошли! Автоматический переход через 7 секунд</span>
            <a class="btn" href="/admin">Перейти в управление</a>
        </div>
        ');
        echo("<script type='text/javascript'>
                setTimeout(`window.location='/admin'`,7000);
              </script>
            ");
    }
}
?>
<div class="hero min-h-screen bg-base-200">
  <div class="hero-content flex-col lg:flex-row-reverse">
    <div class="text-center lg:text-left">
      <h1 class="text-5xl font-bold">Вход</h1>
      <p class="py-6">После входа все функции будут доступны!</p>
    </div>
    <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
      <form method="get" action="/auth" class="card-body">
        <div class="form-control">
          <label class="label">
            <span class="label-text">Логин</span>
          </label>
          <input name="login" type="login" placeholder="Логин" class="input input-bordered" required />
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Пароль</span>
          </label>
          <input name="password" type="password" placeholder="Пароль" class="input input-bordered" required />
          <label class="label">
            <a class="label-text-alt link link-hover">Забыли пароль? Обратитесь к администратору</a>
          </label>
        </div>
        <div class="form-control mt-6">
          <button type="submit" class="btn btn-primary">Войти</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
require_once Themes::getInstance()->current()['path'] . "/footer.php";
?>