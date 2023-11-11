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
<?

                        $sql = "SELECT data FROM rkot_reports_data WHERE id_report = '" . $_GET['id'] . "'";
                         
                        $query = $local['db']->query($sql);

                        $data = json_decode($query[0]['data'], true);

                    foreach ($data as $id => $table) {

                        $title = $table[0][0];

                        echo('<a class="my-8 text-xl font-medium leading-tight">' . $title . '</a>');
                        echo('
<table id="' . $id . '" class="table" style="width:100%">
    <thead>
        <tr>
            <th>Параметры качества</th>
            <th></th>
            <th>Beeline</th>
            <th>MegaFon RUS</th>
            <th>MTS-RUS</th>
            <th>TELE2</th>
        </tr>
    </thead>
</table>


<script>	
$("#' . $id . '").DataTable( {
    searching: false, 
    paging: false, 
    info: false,
    ordering: false,
    language: {
        url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/ru.json",
    },
    ajax: "/api/rkot/reports/data?function=get&count=table&id=1&table_id=' . $id . '"
} );
</script>
                        ');
                    }
?>
</div>
<?php
require_once Themes::getInstance()->current()['path'] . "/admin_footer.php";
?>