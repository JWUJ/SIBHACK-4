<?php
use portal\modules\Themes;

require_once Themes::getInstance()->current()['path'] . "/header.php";
?>
<div class="hero not-prose min-h-screen">
  <div class="hero-content text-center">
    <div class="max-w-md">
      <h1 class="mb-5 text-5xl font-bold opacity-10 lg:text-7xl xl:text-9xl">Ошибка</h1>
      <p class="mb-5">Страница не найдена</p>
      <a class="btn" href="/">На главную</a>
    </div>
  </div>
</div>
<?php
require_once Themes::getInstance()->current()['path'] . "/footer.php";
?>