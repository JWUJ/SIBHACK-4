<?php
use portal\modules\Themes;

require_once Themes::getInstance()->current()['path'] . "/admin_header.php";
?>

<link href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<div class="relative h-16" style="width:100%">
<button class="btn btn-square absolute top-0 right-0 hover:bg-green-200 active:bg-green-500"><span style="font-size:25px; margin-bottom:7%">+</span></button>
</div>

<table id="mobile_op" class="table" style="width:100%">
    <thead>
        <tr>
            <th>№</th>
            <th>Оператор</th>
            <th>Действия</th>
        </tr>
    </thead>
</table>


<script>	
$('#mobile_op').DataTable( {
    ajax: '/api/rkot/mobile_operators?function=get&count=table'
} );
</script>

<?php
require_once Themes::getInstance()->current()['path'] . "/admin_footer.php";
?>