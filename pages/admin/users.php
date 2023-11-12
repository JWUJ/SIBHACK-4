<?php
use portal\modules\Themes;
use portal\modules\Users;
use portal\modules\Role;

$role = Role::getInstance();
$users = Users::getInstance();

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
    <p class="py-4">Введите данные нового пользователя!</p>

    <form id="AddUser">

       <input type="text" placeholder="Имя пользователя" class="input input-bordered w-full" id="user_username" name="user_username"/></p><br/>
        <input type="text" placeholder="ФИО" class="input input-bordered w-full input" id="user_name" name="user_name"/></p><br/>
       <input type="text" placeholder="Пароль" class="input input-bordered w-full" id="user_password" name="user_password"/></p><br/>
       <a class="btn" onclick="submitForm()">Отправить</a>      
        
    </form>


  </div>

</div>

<div>

<table id="users" class="table" style="width:100%">
    <thead>
        <tr>
            <th>№</th>
            <th>Логин</th>
            <th>ФИО</th>
            <th>Роль</th>
            <th>Действия</th>
        </tr>
    </thead>
</table>
</div>

<script>	
$('#users').DataTable( {
    ajax: '/api/users?function=get&count=table'
} );


function submitForm() {
            var form = document.getElementById("AddUser");
            var formData = new FormData(form);

            // Вывод данных в alert
            var AddUser = {};
            formData.forEach(function(value, key) {
                AddUser[key] = value;
            });

        fetch(`/api/users?function=add&username=${AddUser.user_username}&name=${AddUser.user_name}&password=${AddUser.user_password}`)
        .then(response => response.json())
        .then(data => {
          $('#users').DataTable().ajax.reload();
          suretest.hide();
        });
        }
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
  fetch('/api/users?function=delete&id=' + id)
      .then(response => response.json())
      .then(data => {
          if (data.error) {
              console.error(data.error);
          } else {
              $.ajax({
                  url: '/api/users?function=get&count=table',
              }).done(function() {
                  $('#users').DataTable().ajax.reload();
              });
          }
      });
}
</script>

<?php
require_once Themes::getInstance()->current()['path'] . "/admin_footer.php";
?>