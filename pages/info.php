<?php
use FFI\Exception;
use portal\modules\DataBase;
use portal\modules\Themes;

$local['db'] = DataBase::getInstance();

if (!isset($_GET))
{
    exit('{"error": "ERROR: Function not passed"}');
}

require_once Themes::getInstance()->current()['path'] . "/admin_header.php";
?>

<link href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
<h1 class="text-xl text-black" data-line-start="0" data-line-end="1"><a id="__0"></a>СПО РКОТ</h1>
<h3 class="text-xl text-black" data-line-start="1" data-line-end="2"><a id="_______________1"></a>Специальное программное обеспечение конвертации результатов измерений радиоконтрольного оборудования тестирования (мониторинга) параметров услуг подвижной радиотелефонной связи</h3>
<p class="has-line-data text-black" data-line-start="4" data-line-end="6">СПО РКОТ предназначено для автоматизации процесса конвертации<br>
итоговых результатов измерений РКОТ из XLS-файла в формат БД.</p>
<h2 class="text-xl" data-line-start="7" data-line-end="8"><a id="_7"></a>Преимущества</h2>
<ul>
<li class="has-line-data text-black" data-line-start="9" data-line-end="10">Модульная структура</li>
<li class="has-line-data text-black" data-line-start="10" data-line-end="12">Отдельный API</li>
</ul>
<h2 class="code-line text-black" data-line-start="12" data-line-end="13"><a id="__12"></a>Используемые ресурсы</h2>
<p class="has-line-data text-black" data-line-start="14" data-line-end="15">Для работы проекта необходимы:</p>
<ul>
<li class="has-line-data text-black" data-line-start="16" data-line-end="17">PHP 8.2</li>
<li class="has-line-data text-black" data-line-start="17" data-line-end="18">MariaDB 10.8</li>
<li class="has-line-data text-black" data-line-start="18" data-line-end="19">DataTables</li>
<li class="has-line-data text-black" data-line-start="19" data-line-end="20">daisyUI, Tailwind CSS Framework</li>
<li class="has-line-data text-black" data-line-start="20" data-line-end="21">PhpSpreadsheet</li>
</ul>
<h2 class="text-xl text-black" data-line-start="23" data-line-end="24"><a id="_23"></a>Установка</h2>
<p class="has-line-data text-black" data-line-start="24" data-line-end="27">Устанавливаем необходимое окружение ввиде PHP 8.1 NGINX или Apache, MariaDB.<br>
В БД импортируем database.sql.<br>
Настраеваем подключение к бд и название сайта в config.json.</p>
</div>
<?php
require_once Themes::getInstance()->current()['path'] . "/admin_footer.php";
?>