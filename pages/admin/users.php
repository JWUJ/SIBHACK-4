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

<div class="relative h-16" style="width:100%">


<button class="btn btn-square absolute top-0 right-0 hover:bg-green-200 active:bg-green-500" onclick="my_modal_3.showModal()"><span style="font-size:25px; margin-bottom:7%">+</span></button>

<dialog id="my_modal_3" class="modal">
  <div class="modal-box">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>

    <h3 class="font-bold text-lg">Приветствуем!</h3>
    <p class="py-4">Введите данные нового пользователя!</p>

    <form id="AddUser">

       <input type="text" placeholder="Имя пользователя" class="input input-bordered w-full input-sm max-w-xs" id="user_username" name="user_username"/></p><br/>
        <input type="text" placeholder="Имя человека" class="input input-bordered w-full input-sm max-w-xs" id="user_name" name="user_name"/></p><br/>
       <input type="text" placeholder="Пароль" class="input input-bordered w-full input-sm max-w-xs" id="user_password" name="user_password"/></p><br/>
       <input type="text" placeholder="Роль пользователя" class="input input-bordered w-full input-sm max-w-xs" id="user_role" name="user_role"/></p><br/>
       <a class="btn" onclick="submitForm()">Отправить</a>      
        
    </form>


  </div>

</div>

<div>

<table id="users" class="table" style="width:100%">
    <thead>
        <tr>
            <th>id</th>
            <th>username</th>
            <th>name</th>
            <th>role</th>
            <th>func</th>
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

        fetch(`/api/users?function=add&username=${AddUser.user_username}&name=${AddUser.user_name}&password=${AddUser.user_password}&role=${AddUser.user_role}`)
        .then(response => response.json())
        .then(data => {
        });
        }

</script>

<?php
require_once Themes::getInstance()->current()['path'] . "/admin_footer.php";
?>