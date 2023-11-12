<?php
use FFI\Exception;
use portal\modules\DataBase;
use portal\modules\Themes;

$local['db'] = DataBase::getInstance();

require_once Themes::getInstance()->current()['path'] . "/admin_header.php";
?>

<link href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<style>
table /* give class of table*/
{
table-layout: fixed;
}

table td
{
word-wrap:break-word;
overflow: hidden;
overflow-wrap: break-word;
}
</style>

<?

                        $sql = "SELECT data FROM rkot_reports_data WHERE id_report = '" . $_GET['id'] . "'";
                         
                        $query = $local['db']->query($sql);

                        $data = json_decode($query[0]['data'], true);

                        $header = $data[0][0];

                    foreach ($data as $id => $table) {

                        $title = $table[0][0];

                        echo('<a class="my-8 text-xl font-medium leading-tight">' . $title . '</a>');
                        echo('
<div class="overflow-x-auto">
<table id="' . $id . '" class="table table-fixed" >
    <thead>
        <tr>
            <th>Параметры качества</th>
            <th></th>
            <th>"' . $header[2] . '"</th>
            <th>"' . $header[3] . '"</th>
            <th>"' . $header[4] . '"</th>
            <th>"' . $header[5] . '"</th>
        </tr>
    </thead>
</table>
</div>


<script>	
$("#' . $id . '").DataTable( {
    searching: false, 
    paging: false, 
    info: false,
    ordering: false,
    language: {
        url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/ru.json",
    },
    ajax: "/api/rkot/reports/data?function=get&count=table&id=' . $_GET['id'] . '&table_id=' . $id . '",
    "autoWidth": false,
    columns : [
        { width : "500px" },
        { width : "100px" },
        { width : "100px" },
        { width : "100px" },        
        { width : "100px" },
        { width : "100px" }        
    ] 
} );
</script>
                        ');
                    }
?>
<?php
require_once Themes::getInstance()->current()['path'] . "/admin_footer.php";
?>