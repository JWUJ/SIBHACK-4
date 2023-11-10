<?php
use portal\modules\DataBase;
use portal\modules\Themes;
use portal\modules\Session;

$local['session'] = Session::getInstance();
$local['db'] = DataBase::getInstance();

require_once Themes::getInstance()->current()['path'] . "/header.php";
?>

<dialog id="call" class="modal">
  <div class="modal-box space-y-4">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <h3 class="font-bold text-lg">Справка вызов</h3>
	<form class="space-y-4">
    <div class="form-control">
      <input id="employer" type="text" placeholder="Введите работадателя" class="input input-bordered" required/>
    </div>
    <div class="form-control">
      <button onclick="sendCert()" class="btn">Отправить</button>
    </div>
	</form>
  </div>
</dialog>

<body>
	<div class="grid grid-cols-1 gap-4 h-screen place-items-center">
			<div class="card w-96 bg-base-100 shadow-xl">
				<div class="card-body">
					<h2 class="card-title">Справка вызов</h2>
					<p>Требуется для отпуска на время сессии </p>
					<div class="card-actions justify-end">

						<?php 

										$querytry = "WHERE student_id = '" . $local['session']->get('user_id') . "'and status = 'Processing'";
										try
										{
											$result = $local['db']->getRow('certificates', $querytry);
											if ($result == false){
												echo('<button onclick="call.showModal()" class="btn btn-primary">Оформить</button>');
											}else{
												echo('<button class="btn btn-disabled">' . $result['status'] . '</button>');
											}
										}
										catch(Exception $e)
										{
											echo('{"error": "ERROR: ' . $e . '"}');
										}
						?>
					</div>
				</div>
			</div>
			<div class="card w-96 bg-base-100 shadow-xl">
				<div class="card-body">
					<h2 class="card-title">Бегунок</h2>
					<p>Требуется для сдачи долгов </p>
					<div class="card-actions justify-end">
						<button class="btn btn-disabled">Оформить</button>
					</div>
				</div>
			</div>
			<div class="card w-96 bg-base-100 shadow-xl">
				<div class="card-body">
					<h2 class="card-title">Справка об обучении</h2>
					<p> </p>
					<div class="card-actions justify-end">
						<button class="btn btn-disabled">Оформить</button>
					</div>
				</div>
			</div>
		</div>
  </body>

<script>
	// Функция для загрузки типов образования
function sendCert() {
	const employer = document.getElementById('employer');
    // Создаем URL для запроса типов образования
    const url = `/api/dean/certificates?function=add&employer=${employer.value}&student_id=<?php echo($local['session']->get('user_id')); ?>`;

    // Выполняем AJAX запрос с использованием Fetch API
    fetch(url)
}
</script>

<?php
require_once Themes::getInstance()->current()['path'] . "/footer.php";
?>