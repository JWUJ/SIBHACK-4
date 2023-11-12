<?php
use portal\modules\Themes;

require_once Themes::getInstance()->current()['path'] . "/admin_header.php";
?>

<link href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<dialog id="suretest" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Вы уверены?</h3>
    <p class="py-4">Это приведёт к удалению записи!</p>
    <div class="modal-action">
    <button id="confirmDelete" class="btn">Да</button>
      <form method="dialog">
        <!-- if there is a button in form, it will close the modal -->
        <button class="btn">Нет</button>
      </form>
    </div>
  </div>
</dialog>

<div class="relative h-16" style="width:100%">

<button class="btn btn-square absolute top-0 right-0 hover:bg-green-200 active:bg-green-500" onclick="my_modal_3.showModal()"><span style="font-size:25px; margin-bottom:7%">+</span></button>

<dialog id="my_modal_3" class="modal">
  <div class="modal-box">

    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>

    <form>
      <input id="file" type="file" class="file-input file-input-bordered file-input-primary w-full max-w-xs mt-5" /> <br>
      <a class="btn mt-5" onclick="uploadFile()">Отправить</a> 
    </form>
    
  </div>

</dialog>

</div>


<table id="reports" class="table" style="width:100%">
    <thead>
        <tr>
            <th>№</th>
            <th>Название</th>
            <th>Даты проведения</th>
			<th>Город</th>
      <th>Округ</th>
			<th>Действия</th>
        </tr>
    </thead>
</table>


<script>	
$('#reports').DataTable( {
    ajax: '/api/rkot/reports?function=get&count=table'
} );


function showConfirmationModal(button) {

  const entryValue = button.getAttribute('entryid');

  suretest.showModal();

  const confirmDeleteButton = document.getElementById('confirmDelete');
  confirmDeleteButton.addEventListener('click', function () {
    
    deleteEntry(entryValue);
    suretest.close();
  });
}

function deleteEntry(id) {
    fetch('/api/rkot/reports?function=delete&id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
              setTimeout(() => {
                toast.showError('Ошибка!');
                }, 1000);
                console.error(data.error);
            } else {

                setTimeout(() => {
                  toast.showSuccess('Успешно удалено!');
                }, 1000);

                $.ajax({
                    url: '/api/rkot/reports?function=get&count=table',
                }).done(function() {
                    $('#reports').DataTable().ajax.reload();
                });
            }
        });
}

 function uploadFile() {
            var fileInput = document.getElementById("file");

            if (fileInput.files.length > 0) {
                var formData = new FormData();
                formData.append("file", fileInput.files[0]);

                $.ajax({
                    type: "POST",
                    url: "/api/rkot/reports/data?function=add",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert("Файл успешно отправлен!");
                        $('#reports').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        alert("Ошибка: " + error.statusText);
                        $('#reports').DataTable().ajax.reload();
                    }
                });
            } else {
                alert("Выберите файл для загрузки.");
            }
        }

</script>

<?php
require_once Themes::getInstance()->current()['path'] . "/admin_footer.php";
?>