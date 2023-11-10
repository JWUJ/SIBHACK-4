<?php
use portal\modules\Themes;

require_once Themes::getInstance()->current()['path'] . "/header.php";
?>

<div class="hero min-h-screen bg-base-200">
  <div class="hero-content text-center">
    <div class="max-w-md">
      <h1 class="text-5xl font-bold">Учебный портал</h1>
      <p class="py-6">Скоро чтото будет))).</p>
      <button class="btn btn-primary">Хммм</button>
    </div>
  </div>
</div>

<?php
require_once Themes::getInstance()->current()['path'] . "/footer.php";
?>