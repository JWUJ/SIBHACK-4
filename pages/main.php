<?php
use portal\modules\Themes;

require_once Themes::getInstance()->current()['path'] . "/header.php";
?>

<div class="hero min-h-screen bg-base-200">
  <div class="hero-content text-center">
    <div class="max-w-md">
      <h1 class="text-5xl font-bold">СПО РКОТ</h1>
      <p class="py-6">Специальное программное обеспечение 
конвертации результатов измерений радиоконтрольного 
оборудования тестирования (мониторинга) параметров 
услуг подвижной радиотелефонной связи</p>
      <a href="/auth" class="btn btn-primary">Войти в аккаунт</a>
    </div>
  </div>
</div>

<?php
require_once Themes::getInstance()->current()['path'] . "/footer.php";
?>