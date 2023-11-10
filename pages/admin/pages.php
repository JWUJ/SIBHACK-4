<?php
use portal\modules\Themes;

require_once Themes::getInstance()->current()['path'] . "/admin_header.php";
?>

<link href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<table id="users" class="table" style="width:100%">
    <thead>
        <tr>
            <th>№</th>
            <th>Название</th>
            <th>Ссылка</th>
            <th>Путь к файлу</th>
            <th>Роли</th>
            <th>Тип</th>
            <th>Действия</th>
        </tr>
    </thead>
</table>


<script>	
$('#users').DataTable( {
    ajax: '/api/pages?function=get&count=table'
} );
</script>

<?php
require_once Themes::getInstance()->current()['path'] . "/admin_footer.php";
?>