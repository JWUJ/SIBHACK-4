<?php
use portal\modules\Menu;
use portal\modules\Auth;
use portal\modules\Pages;
use portal\modules\Session;

$local['auth'] = Auth::getInstance();
$local['menu'] = Menu::getInstance();
$local['page'] = Pages::getInstance()->current;
$local['session'] = Session::getInstance();
?>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><? echo($local['page']['page']); ?></title>
		<link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.2/dist/full.css" rel="stylesheet" type="text/css" />
		<script src="https://cdn.tailwindcss.com"></script>
	</head>
	<div class="navbar bg-base-100">
		<div class="navbar-start">
			<div class="dropdown">
				<label tabindex="0" class="btn btn-ghost lg:hidden">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
				</label>
				<ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
				<?php 

					$items = json_decode($local['menu']->getMenuById(1)['items'], true);
					foreach (array_keys($items) as $item){
						if (!is_array($items[$item])){
							echo ('<li><a href="' . $items[$item] . '">' . $item . '</a></li>');
						}else{
							echo ('<ul class="p-2">');
							foreach (array_keys($items[$item]) as $subitem){
								echo ('<li><a href="' . $items[$item][$subitem] . '">' . $subitem . '</a></li>');
							}
							echo ('</ul>');
						}

					}

				?>
				</ul>
			</div>
			<a class="btn btn-ghost normal-case text-xl" href="/">ХИИК</a>
		</div>
		<div class="navbar-center hidden lg:flex">
			<ul class="menu menu-horizontal px-1">
				<?php 

					$items = json_decode($local['menu']->getMenuById(1)['items'], true);
					foreach (array_keys($items) as $item){
						if (!is_array($items[$item])){
							echo ('<li><a href="' . $items[$item] . '">' . $item . '</a></li>');
						}else{
							echo ('<li tabindex="0"><details><summary>' . $item . '</summary><ul class="p-2">');
							foreach (array_keys($items[$item]) as $subitem){
								echo ('<li><a href="' . $items[$item][$subitem] . '">' . $subitem . '</a></li>');
							}
							echo ('</ul></details></li>');
						}

					}
				?>
			</ul>
		</div>
		<?php 
		if ($local['auth']->checkAuth() == True){
			echo('
			
		<div class="navbar-end">
			<div class="dropdown dropdown-end">
				<label tabindex="0" class="btn btn-ghost btn-circle avatar">
					<div class="w-10 rounded-full">
						<img src="/images/stock/photo-1534528741775-53994a69daeb.jpg" />
					</div>
				</label>
				<ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
				');
				if ($local['session']->get('role') == 1) {
					echo ('<li><a href="/admin">Панель администратора</a></li>');
				}
				$items = json_decode($local['menu']->getMenuById(2)['items'], true);
				foreach (array_keys($items) as $item){
					if (!is_array($items[$item])){
						echo ('<li><a href="' . $items[$item] . '">' . $item . '</a></li>');
					}else{
						foreach (array_keys($items[$item]) as $subitem){
							echo ('<li><a href="' . $items[$item][$subitem] . '">' . $subitem . '</a></li>');
						}
					}
				} 
			echo('
				</ul>
			</div>
		</div>
			
			');
		}else{
			echo('
			
		<div class="navbar-end">
			<a href="/auth" class="btn">Вход</a>
		</div>
			
			');
		}
	?>


	</div>
</html>
