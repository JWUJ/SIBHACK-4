<?php
use portal\modules\Themes;

require_once Themes::getInstance()->current()['path'] . "/admin_header.php";
?>

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

<link href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
<h1 class="text-base font-semibold leading-6">Справки вызов</h1>
<table id="certificates" class="table" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Дата подачи</th>
            <th>Работадатель</th>
            <th>Готовность</th>
            <th></th>
        </tr>
    </thead>
</table>

</div>

<script>	
$('#certificates').DataTable( {
    ajax: '/api/dean/certificates?function=get&count=table'
} );


function showConfirmationModal(button) {
  // Получите значение атрибута entryid с помощью метода getAttribute
  const entryValue = button.getAttribute('entryid');

  // Вызов модального окна или других действий, если необходимо
  suretest.showModal();

  const confirmDeleteButton = document.getElementById('confirmDelete');
  confirmDeleteButton.addEventListener('click', function () {
    
    // Вызовите функцию удаления элемента
    deleteEntry(entryValue);
    
    // Закройте модальное окно
    suretest.close();
  });
}

function changeStatus(sellecct) {

  statusChange(sellecct.getAttribute('entryid'), sellecct.value);

}

// Функция для удаления записи из расписания
function statusChange(id, value) {
    // Отправляем запрос на сервер для удаления записи по идентификатору
    fetch(`/api/dean/certificates?function=edit&type=status&id=${id}&status=${value}`)
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
                    url: '/api/dean/certificates?function=get&count=table',
                }).done(function() {
                    $('#certificates').DataTable().ajax.reload();
                });
            }
        });
}

// Функция для удаления записи из расписания
function deleteEntry(id) {
    // Отправляем запрос на сервер для удаления записи по идентификатору
    fetch('/api/dean/certificates?function=delete&id=' + id)
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
                    url: '/api/dean/certificates?function=get&count=table',
                }).done(function() {
                    $('#certificates').DataTable().ajax.reload();
                });
            }
        });
}

function printExternal(url) {
    var printWindow = window.open( url, 'Print', 'left=200, top=200, width=1500, height=1000, toolbar=0, resizable=0');

    printWindow.addEventListener('load', function() {
        if (Boolean(printWindow.chrome)) {
            printWindow.print();
            setTimeout(function(){
                printWindow.close();
            }, 500);
        } else {
            printWindow.print();
            printWindow.close();
        }
    }, true);
}
</script>

<?php
require_once Themes::getInstance()->current()['path'] . "/admin_footer.php";
?>