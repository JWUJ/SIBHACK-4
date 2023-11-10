<?php
use portal\modules\Themes;

require_once Themes::getInstance()->current()['path'] . "/admin_header.php";
?>
 <!-- 
<head>
<link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.2/dist/full.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.tailwindcss.com"></script>
</head>-->

<dialog id="suretest" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Вы уверены?</h3>
    <p class="py-4">Это приведёт к удалению занятия!</p>
    <div class="modal-action">
    <button id="confirmDelete" class="btn">Да</button>
      <form method="dialog">
        <!-- if there is a button in form, it will close the modal -->
        <button class="btn">Нет</button>
      </form>
    </div>
  </div>
</dialog>

<dialog id="add_activity" class="modal">
    <div class="modal-box">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
        <h3 class="font-bold text-lg">Добавить занятие!</h3>

                <form class="card-body space-y-4">
<div class="form-control">
    <div class="relative">
        <input id="search_subj" class="input input-bordered w-full max-w-xs" type="text" placeholder="Поиск Предмета" />
    </div>
</div>
<div class="form-control">
    <select id="subj_list" class="select select-bordered w-full max-w-xs">
        <option disabled selected>Предмет</option>
    </select>
</div>
<div class="form-control">
    <div class="relative">
        <input id="search" class="input input-bordered w-full max-w-xs" type="text" placeholder="Поиск преподавателя" />
    </div>
</div>
<div class="form-control">
    <select id="teachers_list" class="select select-bordered w-full max-w-xs">
        <option disabled selected>Преподаватель</option>
    </select>
</div>
<div class="form-control">
                        <select id="type_lesson" class="select select-bordered w-full max-w-xs">
                            <option disabled selected>Тип занятия</option>
                            <option value="Лабз">Лабораторное занятие</option>
                            <option value="Пз">Практическое занятие</option>
                            <option value="Л">Лекция</option>
                        </select>
                    </div>
                    <div class="form-control">
                        <select id="dayofweek" class="select select-bordered w-full max-w-xs">
                            <option disabled selected>День недели</option>
                            <option value="1">Понедельник</option>
                            <option value="2">Вторник</option>
                            <option value="3">Среда</option>
                            <option value="4">Четверг</option>
                            <option value="5">Пятница</option>
                            <option value="6">Суббота</option>
                        </select>
                    </div>
                    <div class="form-control">
                        <select id="numberofless" class="select select-bordered w-full max-w-xs">
                            <option disabled selected>№ занятия</option>
                            <option value="1">1</option>
                            <option value="3">2</option>
                            <option value="5">3</option>
                            <option value="7">4</option>
                            <option value="9">5</option>
                            <option value="11">6</option>
                            <option value="13">7</option>
                        </select>
                    </div>
                    <div class="form-control">
                        <select id="fraction" class="select select-bordered w-full max-w-xs">
                            <option disabled selected>Числитель, знаменатель, неважно</option>
                            <option value="1">Числитель</option>
                            <option value="0">Знаменатель</option>
                            <option value="2">Неважно</option>
                        </select>
                    </div>
                    <div class="form-control">
                        <input id="office" type="text" placeholder="Кабинет" class="input input-bordered w-full max-w-xs" />
                    </div>
                    <div class="form-control">
                        <button type="button" onclick="addScheduleItem()" class="btn btn-primary  w-full max-w-xs">Добавить</button>
                    </div>
                </form>
    </div>
</dialog>

<div class="flex h-full flex-col">
  <header class="flex flex-none items-center justify-between border-b border-gray-200 px-6 py-4">
    <h1 class="text-base font-semibold leading-6">Расписание занятий</h1>
    <div class="flex items-center">
      <div class="relative flex items-center rounded-md bg-white shadow-sm md:items-stretch">

      </div>
      <div class="ml-4 hidden items-center md:flex">
	  	<select onchange='educationSelect(this)' id="edutype" class="select w-full max-w-xs ml-6">
			<option disabled selected>Выберете тип образования</option>
		</select>
		<select onchange="groupSelect(this)" id="sgroup" class="hidden select w-full max-w-xs ml-6">
			<option disabled selected>Выберете группу</option>
		</select>
        <button onclick="add_activity.showModal()" id="add" type="button" class="hidden ml-6 rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500s">Добавить занятие</button>
        <div id="drpmenu" class="hidden dropdown dropdown-left ml-6">
  <button tabindex="0" class="btn m-1 btn-xs">
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
          </svg>
  </button>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a id="exportButton" onclick="exportSchedule()">Экспорт CSV</a></li>
                    <li><input type="file" id="importInput" accept=".csv" style="display:none"></input></li>
                    <li><a id="importButton" onclick="importSchedule()">Импорт CSV</a></li>
                    <!---<li><a id="exportButton" disabled onclick="exportToWord(scheduleData)">Экспорт WORD</a></li>--->
                    <li><input type="file" id="importInputs" accept=".docx" style="display:none"></input></li>
                </ul>
        </div>
      </div>
      <div class="relative ml-6 md:hidden">
<div class="dropdown dropdown-left">
  <button tabindex="0" class="btn m-1">
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
          </svg>
  </button>
  <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
    <li onclick="add_activity.showModal()" ><a>Добавить занятие</a></li>
    <li>
		<a>Файл</a>
		<ul>
			<li><a>Импорт CSV</a></li>
			<li><a>Экспорт CSV</a></li>
		</ul>
	</li>
  </ul>
</div>
      </div>
    </div>
  </header>
  <div class="isolate flex flex-auto flex-col overflow-auto ">
    <div style="width: 165%" class="flex max-w-full flex-none flex-col sm:max-w-none md:max-w-full">
      <div class="sticky top-0 z-30 flex-none  shadow ring-1 ring-black ring-opacity-5 sm:pr-8">
  <div class="grid grid-cols-6 text-sm leading-6 sm:hidden bg-base-100">
    <button type="button" class="day-button flex flex-col items-center pb-3 pt-2" data-day="1"><span class="spdofweek mt-1 flex h-8 w-8 items-center justify-center ">Пн</span></button>
    <button type="button" class="day-button flex flex-col items-center pb-3 pt-2" data-day="2"><span class="spdofweek mt-1 flex h-8 w-8 items-center justify-center ">Вт</span></button>
    <button type="button" class="day-button flex flex-col items-center pb-3 pt-2" data-day="3"><span class="spdofweek mt-1 flex h-8 w-8 items-center justify-center ">Ср</span></button>
    <button type="button" class="day-button flex flex-col items-center pb-3 pt-2" data-day="4"><span class="spdofweek mt-1 flex h-8 w-8 items-center justify-center ">Чт</span></button>
    <button type="button" class="day-button flex flex-col items-center pb-3 pt-2" data-day="5"><span class="spdofweek mt-1 flex h-8 w-8 items-center justify-center ">Пт</span></button>
    <button type="button" class="day-button flex flex-col items-center pb-3 pt-2" data-day="6"><span class="spdofweek mt-1 flex h-8 w-8 items-center justify-center ">Сб</span></button>
  </div>

        <div class="-mr-px hidden grid-cols-6 divide-x divide-gray-100 text-sm leading-6 sm:grid bg-base-100">
          <div class="col-end-1 w-14"></div>
          <div class="flex items-center justify-center py-3">
            <span class="items-center justify-center day-of-week"><a class="mr-2 ml-2">Понедельник</a></span>
          </div>
          <div class="flex items-center justify-center py-3">
            <span class="items-center justify-center day-of-week"><a class="mr-2 ml-2">Вторник</a></span>
          </div>
          <div class="flex items-center justify-center py-3">
            <span class="ml-1.5 flex items-center justify-center rounded-full bg-blue-600 font-semibold text-white day-of-week"><a class="mr-2 ml-2">Среда</a></span>
          </div>
          <div class="flex items-center justify-center py-3">
            <span class="items-center justify-center day-of-week"><a class="mr-2 ml-2">Четверг</a></span>
          </div>
          <div class="flex items-center justify-center py-3">
            <span class="items-center justify-center day-of-week"><a class="mr-2 ml-2">Пятница</a></span>
          </div>
          <div class="flex items-center justify-center py-3">
            <span class="items-center justify-center day-of-week"><a class="mr-2 ml-2">Субота</a></span>
          </div>
        </div>
      </div>
      <div class="flex flex-auto">
        <div class="sticky left-0 z-10 w-14 flex-none ring-1 ring-gray-100"></div>
        <div class="grid flex-auto grid-cols-1 grid-rows-1">
          <!-- Horizontal lines -->
          <div id="dynamic-div" class="col-start-1 col-end-2 row-start-1 grid divide-y divide-gray-100" style="grid-template-rows: repeat(14, minmax(2.5rem, 5rem))">
            <div class="row-end-1 h-7 fixed-row"></div>
            <div>
              <div class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400">1</div>
            </div>
            <div></div>
            <div>
              <div class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400">2</div>
            </div>
            <div></div>
            <div>
              <div class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400">3</div>
            </div>
            <div></div>
            <div>
              <div class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400">4</div>
            </div>
            <div></div>
            <div>
              <div class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400">5</div>
            </div>
            <div></div>
            <div>
              <div class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400">6</div>
            </div>
            <div></div>
            <div>
              <div class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400">7</div>
            </div>
            <div></div>
          </div>

          <!-- Vertical lines -->
          <div class="col-start-1 col-end-2 row-start-1 hidden grid-cols-6 grid-rows-1 divide-x divide-gray-100 sm:grid sm:grid-cols-6">
            <div class="col-start-1 row-span-full"></div>
            <div class="col-start-2 row-span-full"></div>
            <div class="col-start-3 row-span-full"></div>
            <div class="col-start-4 row-span-full"></div>
            <div class="col-start-5 row-span-full"></div>
            <div class="col-start-6 row-span-full"></div>
            <div class="col-start-7 row-span-full w-8"></div>
          </div>

          <!-- Events -->
          <ol id="schedule" class="col-start-1 col-end-2 row-start-1 grid grid-cols-1 sm:grid-cols-6 sm:pr-7 auto-cols-max" style="grid-template-rows: 1.75rem repeat(14, minmax(0, 5rem))">
          </ol>
        </div>
      </div>
    </div>
  </div> 
  <div class="toast toast-end">
        <div class="alert alert-error" style="display: none;" id="errorToast">
            <span>Error.</span>
        </div>
        <div class="alert alert-success" style="display: none;" id="successToast">
            <span>Success.</span>
        </div>
    </div>
</div>

<script>
        class Toast {
            constructor(errorToast, successToast) {
                this.errorToast = errorToast;
                this.successToast = successToast;
            }

            showError(message) {
                this.errorToast.querySelector('span').textContent = message;
                this.errorToast.style.display = 'block';
                setTimeout(() => this.errorToast.classList.add('show'), 0);
                setTimeout(() => this.hideError(), 3000);
            }

            hideError() {
                this.errorToast.classList.remove('show');
                setTimeout(() => this.errorToast.style.display = 'none', 1000);
            }

            showSuccess(message) {
                this.successToast.querySelector('span').textContent = message;
                this.successToast.style.display = 'block';
                setTimeout(() => this.successToast.classList.add('show'), 0);
                setTimeout(() => this.hideSuccess(), 3000);
            }

            hideSuccess() {
                this.successToast.classList.remove('show');
                setTimeout(() => this.successToast.style.display = 'none', 1000);
            }
        }
</script>
<script>
const dayButtons = document.querySelectorAll(".day-button");
const olElement = document.getElementById("schedule");

dayButtons.forEach((button) => {
  button.addEventListener("click", () => {
    const selectedDay = button.getAttribute("data-day");

    // Удаляем классы у всех кнопок
    dayButtons.forEach((btn) => {
      btn.getElementsByClassName("spdofweek")[0].classList.remove("rounded-full", "bg-blue-600", "text-white");
    });

    // Добавляем классы к выбранной кнопке
    button.getElementsByClassName("spdofweek")[0].classList.add("rounded-full", "bg-blue-600", "text-white");

    // Скрываем все элементы <li> в списке событий
    const liElements = olElement.querySelectorAll("li");
    liElements.forEach((li) => {
      const liDay = li.classList.contains(`sm:col-start-${selectedDay}`);
      if (liDay) {
        li.classList.remove("sm:flex", "hidden");
		li.classList.add("flex");
      } else {
        li.classList.add("sm:flex", "hidden");
		li.classList.remove("flex");
      }
    });
  });
});
</script>
<script>
        const errorToast = document.getElementById('errorToast');
        const successToast = document.getElementById('successToast');

        const toast = new Toast(errorToast, successToast);

// Определяем текущий день недели
const currentDate = new Date();
const currentDay = currentDate.getDay(); // 0 - воскресенье, 1 - понедельник, и так далее

// Получаем все элементы дней недели
const dayOfWeekElements = document.querySelectorAll(".day-of-week");
const dayOfWeekElementsmobile = document.querySelectorAll(".day-button");

// Удаляем класс выделения у всех элементов
dayOfWeekElements.forEach((element) => {
  element.classList.remove("ml-1.5", "flex", "items-center", "justify-center", "rounded-full", "bg-blue-600", "font-semibold", "text-white", "day-of-week");
});

// Добавляем класс выделения к текущему дню недели
dayOfWeekElements[currentDay - 1].classList.remove("items-center", "justify-center", "font-semibold", "text-gray-900", "day-of-week");
dayOfWeekElements[currentDay - 1].classList.add("ml-1.5", "flex", "items-center", "justify-center", "rounded-full", "bg-blue-600", "font-semibold", "text-white", "day-of-week");
dayOfWeekElementsmobile[currentDay - 1].click();
</script>
<script>
let scheduleData = [];

// Функция для загрузки и отображения расписания для выбранной группы
function loadSchedule(id) {
    // Отправляем AJAX запрос на сервер для получения расписания
    fetch('/api/dean/schedule?function=get&group_id=' + id)
        .then(response => response.json()) // Преобразуем ответ в формате JSON
        .then(data => {
            // Перебираем полученные данные и добавляем их в массив scheduleData
            data.forEach(item => {
                scheduleData.push(item);
                const table = document.getElementById('schedule');
                if (table) {
                    // Создаем карточку расписания и добавляем её в таблицу
                    const card = createScheduleCard(item);
                    table.appendChild(card);
                }
            });
        });
}

// Функция для получения информации о преподавателе по его идентификатору
function getTeacherById(id, callback) {
    fetch('/api/dean/teachers?function=get&count=one&id=' + id)
        .then(response => response.json())
        .then(data => {
            // Перебираем полученные данные
            if (data && data.length > 0) {
                const teacher = data[0];
                callback(teacher);
            }
        });
}

// Функция для получения информации о преподавателе по его идентификатору
function getSubjectsById(id, callback) {
    fetch('/api/dean/subjects?function=get&count=one&id=' + id)
        .then(response => response.json())
        .then(data => {
            // Перебираем полученные данные
            if (data && data.length > 0) {
                const teacher = data[0];
                callback(teacher);
            }
        });
}

// Функция для добавления записи в расписание
function addScheduleItem() {
    // Получаем значения из формы
    const sgroup = document.getElementById('sgroup').value;
    const teachers_list = document.getElementById('teachers_list').value;
    const dayofweek = document.getElementById('dayofweek').value;
    let numberofless = parseInt(document.getElementById('numberofless').value);
    const subject = document.getElementById('subj_list').value;
    let fraction = parseInt(document.getElementById('fraction').value);
    const office = document.getElementById('office').value;
    const type_lesson = document.getElementById('type_lesson').value;

    // Проверяем и корректируем fraction и numberofless, если fraction равен 0
    if (fraction === 0) {
        fraction = 1;
        numberofless += 1;
    }

    // Отправляем запрос для добавления записи в расписание
    fetch(`/api/dean/schedule?function=add&group_id=${sgroup}&teacher_id=${teachers_list}&day_of_week=${dayofweek}&time=${numberofless}&subject=${subject}&fraction=${fraction}&office=${office}&type_d=${type_lesson}`)
        .then(response => response.json())
        .then(data => {
            clearSchedule(); // Очищаем текущее расписание
            loadSchedule(sgroup); // Загружаем обновленное расписание
        });
}

// Функция для добавления записи в расписание
function editScheduleItem() {
    // Получаем значения из формы
    const sgroup = document.getElementById('sgroup').value;
    const teachers_list = document.getElementById('teachers_list').value;
    const dayofweek = document.getElementById('dayofweek').value;
    let numberofless = parseInt(document.getElementById('numberofless').value);
    const subject = document.getElementById('subj_list').value;
    let fraction = parseInt(document.getElementById('fraction').value);
    const office = document.getElementById('office').value;
    const type_lesson = document.getElementById('type_lesson').value;

    // Проверяем и корректируем fraction и numberofless, если fraction равен 0
    if (fraction === 0) {
        fraction = 1;
        numberofless += 1;
    }

    // Отправляем запрос для добавления записи в расписание
    fetch(`/api/dean/schedule?function=add&group_id=${sgroup}&teacher_id=${teachers_list}&day_of_week=${dayofweek}&time=${numberofless}&subject=${subject}&fraction=${fraction}&office=${office}&type_d=${type_lesson}`)
        .then(response => response.json())
        .then(data => {
            clearSchedule(); // Очищаем текущее расписание
            loadSchedule(sgroup); // Загружаем обновленное расписание
        });
}

// Функция для создания карточки с информацией о расписании
function createScheduleCard(scheduleItem) {
    const card = document.createElement('li');
    card.className = `relative mt-px flex sm:col-start-${scheduleItem.day_of_week}`;

    let gridRowValue = parseInt(scheduleItem.time) + 1;

    card.style.cssText = `grid-row: ${gridRowValue} / span ${scheduleItem.fraction}`;

// Проверяем, является ли gridRowValue четным числом
const isEven = gridRowValue % 2 === 0;

// Устанавливаем colorbd в зависимости от результата проверки
const colorbd = isEven ? "bg-blue-50 hover:bg-blue-100" : "bg-green-50 hover:bg-green-100";
const colortx = isEven ? "text-blue-500 group-hover:text-blue-700" : "text-green-500 group-hover:text-green-700";
const colortxb = isEven ? "text-blue-700" : "text-green-700";
const colortxs = isEven ? "bg-blue-50 text-blue-700 ring-blue-700/10" : "bg-green-50 text-green-700 ring-green-700/10";

    getTeacherById(scheduleItem.teacher_id, function (teacher) {
      getSubjectsById(scheduleItem.subject_id, function (subject) {
        const teacherName = teacher && teacher.name ? teacher.name : 'Неизвестный учитель';
        const subjectName = subject && subject.name ? subject.name : 'Неизвестный учитель';
        card.innerHTML = `
            <a onclick="add_activity.showModal()" class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg p-2 text-xs leading-5 ${colorbd}">
              <div class="order-1 join">
                <p class="font-semibold ${colortx}">${subjectName}</p>
                <p class="${colortxb}">, ${scheduleItem.type}</p>
              </div>
              <div class="order-2 join">
                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ${colortxs} ring-1 ring-inset">${scheduleItem.office}</span>
                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ${colortxs} ring-1 ring-inset ml-4">${teacherName}</span>
              </div>
            </a>
			    <button onclick="showConfirmationModal(this)" ifscd="${scheduleItem.id}" class="absolute top-2 right-2 btn btn-xs bg-blue-50">✕</button>
        `;
      });
    });

    return card;
}

function showConfirmationModal(button) {
  // Получите значение атрибута ifscd с помощью метода getAttribute
  const ifscdValue = button.getAttribute('ifscd');

  // Вызов модального окна или других действий, если необходимо
  suretest.showModal();

  const confirmDeleteButton = document.getElementById('confirmDelete');
  confirmDeleteButton.addEventListener('click', function () {
    // Получите ID элемента, который вы хотите удалить (например, из какого-то data-атрибута)
    const itemId = // ваш способ получения ID;
    
    // Вызовите функцию удаления элемента
    deleteSchedule(ifscdValue);
    
    // Закройте модальное окно (если необходимо)
    const modal = document.getElementById('suretest');
    modal.close();
  });
}

// Функция для удаления записи из расписания
function deleteSchedule(id) {
    // Отправляем запрос на сервер для удаления записи по идентификатору
    fetch('/api/dean/schedule?function=delete&id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
              setTimeout(() => {
                toast.showError('Ошибка!');
                }, 1000);
                console.error(data.error);
            } else {
                // Если удаление прошло успешно, обновляем расписание
                clearSchedule(); // Очищаем текущее расписание

                setTimeout(() => {
                  toast.showSuccess('Успешно удалено!');
                }, 1000);

                loadSchedule(document.getElementById('sgroup').value); // Загружаем обновленное расписание
            }
        });
}

// Функция для загрузки групп в зависимости от выбранного типа образования
function loadGroups(eduType) {
    // Создаем URL для запроса, учитывая выбранный тип образования
    const url = `/api/dean/groups?function=get&count=all&edu_type=${eduType}`;

    // Выполняем AJAX запрос с использованием Fetch API
    fetch(url)
        .then(response => response.json()) // Разбираем JSON-ответ
        .then(data => {
            // Перебираем полученные данные
            data.forEach(item => {
                const select = document.getElementById('sgroup');
                if (select) {
                    // Создаем новый элемент в выпадающем списке с названием группы и её идентификатором
                    const newOption = new Option(item.group_name, item.group_id);
                    select.append(newOption); // Добавляем элемент в список
                }
            });
        });
}

// Функция для загрузки типов образования
function loadEduTypes() {
    // Создаем URL для запроса типов образования
    const url = '/api/dean/edutype?function=get';

    // Выполняем AJAX запрос с использованием Fetch API
    fetch(url)
        .then(response => response.json()) // Разбираем JSON-ответ
        .then(data => {
            // Перебираем полученные данные
            data.forEach(item => {
                const select = document.getElementById('edutype');
                if (select) {
                    // Создаем новый элемент в выпадающем списке с названием типа образования и его идентификатором
                    const newOption = new Option(item.name, item.id);
                    select.append(newOption); // Добавляем элемент в список
                }
            });
        });
}

// Функция для загрузки списка преподавателей
function loadTeachers() {
    const select = document.getElementById('teachers_list');
    const search = document.getElementById('search');

    // Создаем URL для запроса списка преподавателей
    const url = '/api/dean/teachers?function=get&count=all';

    // Переменная для хранения всех доступных преподавателей
    let allTeachers = [];

    // Выполняем AJAX запрос с использованием Fetch API
    fetch(url)
        .then(response => response.json()) // Разбираем JSON-ответ
        .then(data => {
            // Сохраняем список всех преподавателей
            allTeachers = data;

            // Первоначально добавляем все преподавателей в список
            allTeachers.forEach(item => {
                const newOption = new Option(item.name, item.user_id);
                select.append(newOption);
            });

            // Обработчик события при вводе в поле поиска
            search.addEventListener('input', () => {
                const query = search.value.toLowerCase();

                // Очищаем список перед добавлением результатов поиска
                select.innerHTML = '<option disabled selected>Преподаватель</option>';

                // Фильтруем преподавателей на основе введенного запроса
                const filteredTeachers = allTeachers.filter(item =>
                    item.name.toLowerCase().includes(query)
                );subj_list

                // Добавляем отфильтрованных преподавателей в список
                filteredTeachers.forEach(item => {
                    const newOption = new Option(item.name, item.user_id);
                    select.append(newOption);
                });
            });
        });
}

// Функция для загрузки списка предметов
function loadSubjects() {
    const select = document.getElementById('subj_list');
    const search = document.getElementById('search_subj');

    // Создаем URL для запроса
    const url = '/api/dean/subjects?function=get&count=all';

    // Переменная для хранения всех доступных предметов
    let allSubjects = [];

    // Выполняем AJAX запрос с использованием Fetch API
    fetch(url)
        .then(response => response.json()) // Разбираем JSON-ответ
        .then(data => {
            // Сохраняем список всех преподавателей
            allSubjects = data;

            // Первоначально добавляем все преподавателей в список
            allSubjects.forEach(item => {
                const newOption = new Option(item.name, item.id);
                console.log(item);
                select.append(newOption);
            });

            // Обработчик события при вводе в поле поиска
            search.addEventListener('input', () => {
                const query = search.value.toLowerCase();

                // Очищаем список перед добавлением результатов поиска
                select.innerHTML = '<option disabled selected>Предмет</option>';

                // Фильтруем преподавателей на основе введенного запроса
                const filteredTeachers = allSubjects.filter(item =>
                    item.name.toLowerCase().includes(query)
                );

                // Добавляем отфильтрованных преподавателей в список
                filteredTeachers.forEach(item => {
                    const newOption = new Option(item.name, item.id);
                    select.append(newOption);
                });
            });
        });
}

// Функция для очистки расписания
function clearSchedule() {
    // Находим таблицу расписания по ее идентификатору 'schedule'
    const table = document.getElementById('schedule');
    // Устанавливаем содержимое таблицы пустым, тем самым очищая расписание
    table.innerHTML = "";
}

// Функция для очистки списка групп
function clearGroupSelect() {
    // Находим выпадающий список групп по его идентификатору 'sgroup'
    const select = document.getElementById('sgroup');
    // Устанавливаем содержимое списка, включая заглушку для выбора группы
    select.innerHTML = "<option disabled selected>Выберите группу</option>";
}

// Функция, вызываемая при выборе типа образования
function educationSelect(select) {
    // Изменяем класс выпадающего списка групп и скрываем кнопку 'add'
    document.getElementById('sgroup').className = "select w-full max-w-xs ml-6";
    document.getElementById('add').className = "hidden";
    document.getElementById('drpmenu').className = "hidden";
    // Очищаем список групп
    clearGroupSelect();
    // Загружаем группы в зависимости от выбранного типа образования
    loadGroups(select.value);
}

// Функция, вызываемая при выборе группы
function groupSelect(select) {
    // Показываем кнопку 'add' и очищаем расписание
    document.getElementById('add').className = "ml-6 rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500s";
    document.getElementById('drpmenu').className = "ml-6 dropdown dropdown-left";
    clearSchedule();
    // Загружаем расписание для выбранной группы
    loadSchedule(select.value);
}

// Функция для экспорта расписания в CSV формат
function exportSchedule() {
    // Создаем строку для CSV файла
    let csvContent = 'День недели,№ занятия,Предмет,Преподаватель,Кабинет,Тип занятия\n';

    // Перебираем данные из scheduleData и добавляем информацию в CSV строку
    scheduleData.forEach(item => {
        const dayOfWeek = item.day_of_week;
        const lessonNumber = item.time;
        const subject = item.subject;
        const teacher = item.teacher_id;
        const office = item.office;
        const lessonType = item.type;

        csvContent += `${dayOfWeek},${lessonNumber},${subject},${teacher},${office},${lessonType}\n`;
    });

    // Создаем Blob (бинарные данные) для скачивания
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);

    // Создаем ссылку для скачивания
    const a = document.createElement('a');
    a.href = url;
    a.download = 'schedule.csv';

    // Автоматически кликаем по ссылке для скачивания
    a.click();
    URL.revokeObjectURL(url);
}

// Функция для импорта расписания из CSV файла
function importSchedule() {
    // Очищаем scheduleData перед импортом
    scheduleData = [];

    const importInput = document.getElementById('importInput');

    // Добавляем обработчик события на выбор файла
    importInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = (e) => {
            const csvContent = e.target.result;
            // Разбираем CSV файл и добавляем расписание
            parseCSVAndAddSchedule(csvContent);
        };

        // Читаем выбранный файл как текст
        reader.readAsText(file);
    });

    // Открываем диалог выбора файла
    importInput.click();
}

// Функция для разбора CSV данных и добавления расписания
function parseCSVAndAddSchedule(csvContent) {
    // Разбираем CSV строку на строки
    const lines = csvContent.split('\n');

    // Пропускаем первую строку (заголовок)
    for (let i = 1; i < lines.length; i++) {
        const line = lines[i].trim();
        if (line.length === 0) continue;

        // Разбираем CSV строку на значения
        const values = line.split(',');

        const dayOfWeek = values[0];
        const lessonNumber = values[1];
        const subject = values[2];
        const teacher = values[3];
        const office = values[4];
        const lessonType = values[5];

        // Создаем объект с данными
        const scheduleItem = {
            day_of_week: dayOfWeek,
            time: lessonNumber,
            subject: subject,
            teacher: teacher_id,
            office: office,
            type: lessonType,
        };

        // Создаем карточку расписания и добавляем её в таблицу
        const table = document.getElementById('schedule');
        if (table) {
            const card = createScheduleCard(scheduleItem);
            table.appendChild(card);
        }
    }
}

function exportToWord(scheduleData) {
  fetch('http://portal.hiik.ru//admin/api/getfile?file=shablon.docx') // Загрузите ваш шаблон Word-документа
    .then(response => response.arrayBuffer())
    .then(templateData => {
      const zip = new PizZip(templateData);
      const doc = new window.docxtemplater().loadZip(zip);

      // Создайте массив данных для плейсхолдеров
      const placeholders = scheduleData.map(item => ({
        dayOfWeek: item.day_of_week,
        lessonNumber: item.time,
        subject: item.subject,
        teacher: item.teacher,
        office: item.office,
        lessonType: item.type,
      }));

      // Заполните шаблон данными
      doc.setData({ schedule: placeholders });

      try {
        // Рендерим шаблон
        doc.render();
      } catch (error) {
        console.error('Ошибка при рендеринге шаблона:', error);
        return;
      }

      // Получите отрендеренный документ
      const renderedBlob = doc.getZip().generate({
        type: 'blob',
        mimeType: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      });

      // Создайте ссылку для скачивания документа
      const link = document.createElement('a');
      link.href = URL.createObjectURL(renderedBlob);
      link.download = 'расписание.docx';

      // Добавьте ссылку на страницу и нажмите на неё, чтобы скачать документ
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    })
    .catch(error => {
      console.error('Ошибка при загрузке шаблона:', error);
    });
}



// Вызываем функции для загрузки данных при загрузке страницы
loadEduTypes(); // Загрузка типов образования
loadTeachers();  // Загрузка преподавателей
loadSubjects();

</script>
<?php
require_once Themes::getInstance()->current()['path'] . "/admin_footer.php";
?>