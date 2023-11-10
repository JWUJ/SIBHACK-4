<?php
use portal\modules\Menu;
use portal\modules\Auth;
use portal\modules\Pages;
use portal\modules\Users;
use portal\modules\Session;

$local['auth'] = Auth::getInstance();
$local['menu'] = Menu::getInstance();
$local['users'] = Users::getInstance();
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
<div class="flex flex-wrap bg-gray-100 w-full h-screen">
    <div class="w-3/12 bg-base-200 rounded p-3">
        <div class="flex items-center space-x-4 p-2 mb-5">
            <a class="btn btn-ghost normal-case text-xl" href="/">ХИИК</a>
            <div>
                <h4 class="font-semibold text-lg text-gray-700 capitalize font-poppins tracking-wide"><?php echo($local['users']->user($local['session']->get('user_id'))['name']);?></h4>
            </div>
        </div>
        <ul class="menu rounded-box">
    <?php 

					$items = json_decode($local['menu']->getMenuById(3)['items'], true);
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

    <div class="w-9/12 bg-base-100">
        <div class="p-4 text-gray-500">
