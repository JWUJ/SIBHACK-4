<?php
use portal\modules\Themes;

require_once Themes::getInstance()->current()['path'] . "/header.php";
?>

<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<div class="flex flex-col items-center justify-center min-h-screen">
  <!-- dark theme -->
  <div class="container  m-4">
    <div class="max-w-3xl w-full mx-auto grid gap-4 grid-cols-1">
      <!-- profile card -->
      <div class="flex flex-col sticky top-0 z-10">
        <div class="card shadow-lg bg-base-100 rounded-2xl p-4">
          <div class="flex-none sm:flex">
            <div class=" relative h-32 w-32   sm:mb-0 mb-3">
<div class="avatar">
  <div class="w-32 rounded-xl">
    <img src="https://sun9-3.userapi.com/impf/c849036/v849036406/1de4a6/-jPAcDtnUlM.jpg?size=1620x2160&quality=96&sign=9862661b5cb95998a8d69cd2c3a86a36&type=album" />
  </div>
</div>
            </div>
            <div class="flex-auto sm:ml-5 justify-evenly">
              <div class="flex items-center justify-between sm:mt-2">
                <div class="flex items-center">
                  <div class="flex flex-col">
                    <div class="w-full flex-none text-lg font-bold leading-none">Стововой Алексей</div>
                    <div class="flex-auto text-gray-400 my-1">
                      <span class="mr-3 ">Студент</span><span class="mr-3 border-r border-gray-600  max-h-0"></span><span>Группа: ПОВТ-21Д</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!---stats-->
      <div class="stats stats-vertical lg:stats-horizontal shadow shadow-lg bg-base-100 rounded-2xl p-4">
  
  <div class="stat">
    <div class="stat-title">Академические задолженности</div>
    <div class="stat-value text-error">2</div>
    <div class="stat-desc">Хмм, поскорее бы закрыть)</div>
  </div>
  
  <div class="stat">
    <div class="stat-title">New Users</div>
    <div class="stat-value">4,200</div>
    <div class="stat-desc">↗︎ 400 (22%)</div>
  </div>
  
  <div class="stat">
    <div class="stat-title">New Registers</div>
    <div class="stat-value">1,200</div>
    <div class="stat-desc">↘︎ 90 (14%)</div>
  </div>
  
</div>
      <div class="grid gap-4 grid-cols-1 md:grid-cols-2">

        <!--elements-->
        <div class="flex flex-col space-y-4">
          <!-- elements 1 -->
          <div class="card shadow-lg bg-base-100 rounded-2xl p-4">

            <div class="flex items-center justify-between">
              <div class="flex items-center mr-auto">

                <div class="flex flex-col ml-3">
                  <div class="font-medium leading-none">Портфолио</div>
                  <p class="text-sm text-gray-500 leading-none mt-1">Учёт ваших достижений)</p>
                </div>
              </div>
              <button class="btn">Заполнить</button>
            </div>
          </div>
          <!--elements 2-->
          <div class="card shadow-lg bg-base-100 rounded-2xl p-4">

            <div class="flex items-center justify-between">
              <div class="flex items-center mr-auto">

                <div class="flex flex-col ml-3 min-w-0">
                  <div class="font-medium leading-none">Справки</div>
                  <p class="text-sm text-gray-500 leading-none mt-1 truncate">Всякие)))</p>
                </div>
              </div>
              <button class="btn">Заказать</button>
            </div>
          </div>
          <!--elements 2-->
          <div class="card shadow-lg bg-base-100 rounded-2xl p-4">
            <div class="flex items-center justify-between">
              <div class="flex items-center mr-auto">
              <div class="inline-flex w-12 h-12"><img src="https://cdn.discordapp.com/embed/avatars/0.png?size=128" class=" relative p-1 w-12 h-12 object-cover rounded-2xl"><span class="absolute w-12 h-12 inline-flex border-2 rounded-2xl border-gray-600 opacity-75"></span>
                  <span></span>
                </div>
                <div class="flex flex-col ml-3 min-w-0">
                  <div class="font-medium leading-none">Discord Сервер</div>
                  <p class="text-sm text-gray-500 leading-none mt-1 truncate">Для дистанционного обучения)</p>
                </div>
              </div>
              <div class="flex flex-col ml-3 min-w-0">
                <button class="btn" href="https://discord.gg/Fjf8CQw2F9">Войти</button>
              </div>
            </div>
          </div>
      </div>
    </div>
   
  </div>
</div>

<?php
require_once Themes::getInstance()->current()['path'] . "/footer.php";
?>