<?php
use FFI\Exception;
use portal\modules\DataBase;
use portal\modules\Themes;

$local['db'] = DataBase::getInstance();

if (!isset($_GET))
{
    exit('{"error": "ERROR: Function not passed"}');
}

require_once Themes::getInstance()->current()['path'] . "/header.php";
?>

<link href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">СПО РКОТ</h1>
        <p class="text-lg mb-4">Специальное программное обеспечение конвертации результатов измерений радиоконтрольного оборудования тестирования (мониторинга) параметров услуг подвижной радиотелефонной связи</p>
        <p class="mb-4">СПО РКОТ предназначено для автоматизации процесса конвертации итоговых результатов измерений РКОТ из XLS-файла в формат БД.</p>
        <h2 class="text-xl font-bold mt-4 mb-2">Преимущества</h2>
        <ul class="list-disc ml-6">
            <li class="mb-2">Модульная структура</li>
            <li class="mb-2">API</li>
        </ul>
        <h2 class="text-xl font-bold mt-4 mb-2">Используемые ресурсы</h2>
        <ul class="list-disc ml-6">
            <li class="mb-2">PHP 8.2</li>
            <li class="mb-2">MariaDB 10.8</li>
            <li class="mb-2">DataTables</li>
            <li class="mb-2">daisyUI, Tailwind CSS Framework</li>
            <li class="mb-2">PhpSpreadsheet</li>
        </ul>
        <h2 class="text-xl font-bold mt-4 mb-2">Установка</h2>
        <ol class="list-decimal ml-6">
            <li class="mb-2">Устанавливаем необходимое окружение в виде PHP 8.1 NGINX или Apache, MariaDB.</li>
            <li class="mb-2">В БД импортируем database.sql.</li>
            <li class="mb-2">Настроиваем подключение к БД и название сайта в config.json.</li>
        </ol>
        <h2 class="text-xl font-bold mt-4 mb-2">Вход</h2>
        <p class="mb-4">Логин: admin</p>
        <p class="mb-4">Пароль: adminpassword</p>
    </div>
<?php
require_once Themes::getInstance()->current()['path'] . "/footer.php";
?>