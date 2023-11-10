<?php
use portal\modules\Themes;

require_once Themes::getInstance()->current()['path'] . "/header.php";
?>

<div class="flex h-full flex-col">
  <header class="flex flex-none items-center justify-between border-b border-gray-200 px-6 py-4">
    <h1 class="text-base font-semibold leading-6">Расписание занятий</h1>
    <div class="flex items-center">
      <div class="relative flex items-center rounded-md bg-white shadow-sm md:items-stretch">

      </div>

      <div class="ml-4 hidden items-center md:flex">
    <select onchange='studteachSelect(this)' id="studteachtype" class="select w-full max-w-xs ml-6">
			<option disabled selected>Выберете тип расписания</option>
      <option value="0">Студент</option>
      <option value="1">Преподаватель</option>
		</select>
    <select id="teachers_list" onchange="teachSelect(this)" class="hidden select select-bordered w-full max-w-xs ml-6">
        <option disabled selected>Преподаватель</option>
    </select>
    <input id="search" class="hidden input input-bordered w-full max-w-xs ml-6" type="text" placeholder="Поиск преподавателя" />
	  <select onchange='educationSelect(this)' id="edutype" class="hidden select w-full max-w-xs ml-6">
			<option disabled selected>Выберете тип образования</option>
		</select>
		<select onchange="groupSelect(this)" id="sgroup" class="hidden select w-full max-w-xs ml-6">
			<option disabled selected>Выберете группу</option>
		</select>
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
</div>

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
function loadTeachSchedule(id) {
    // Отправляем AJAX запрос на сервер для получения расписания
    fetch('/api/dean/schedule?function=getbyteacher&teacher_id=' + id)
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
            <a class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg p-2 text-xs leading-5 ${colorbd}">
              <div class="order-1 join">
                <p class="font-semibold ${colortx}">${subjectName}</p>
                <p class="${colortxb}">, ${scheduleItem.type}</p>
              </div>
              <div class="order-2 join">
                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ${colortxs} ring-1 ring-inset">${scheduleItem.office}</span>
                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ${colortxs} ring-1 ring-inset ml-4">${teacherName}</span>
              </div>
            </a>
        `;
      });
    });

    return card;
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
            // Очищаем список перед добавлением результатов поиска
            select.innerHTML = '<option disabled selected>Преподаватель</option>';
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
                );

                // Добавляем отфильтрованных преподавателей в список
                filteredTeachers.forEach(item => {
                    const newOption = new Option(item.name, item.user_id);
                    select.append(newOption);
                });
            });
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
    // Очищаем список групп
    clearGroupSelect();
    // Загружаем группы в зависимости от выбранного типа образования
    loadGroups(select.value);
}

// Функция, вызываемая при выборе группы
function groupSelect(select) {
    clearSchedule();
    // Загружаем расписание для выбранной группы
    loadSchedule(select.value);
}

// Функция, вызываемая при выборе типа образования
function studteachSelect(select) {

    if (select.value === "0") {
      document.getElementById('edutype').className = "select w-full max-w-xs ml-6";
      document.getElementById('sgroup').className = "select w-full max-w-xs ml-6";

      document.getElementById('teachers_list').className = "hidden select w-full max-w-xs ml-6";
      document.getElementById('search').className = "hidden input input-bordered w-full max-w-xs ml-6";
    }
    if (select.value === "1") {
      document.getElementById('edutype').className = "hidden select w-full max-w-xs ml-6";
      document.getElementById('sgroup').className = "hidden select w-full max-w-xs ml-6";

      loadTeachers();
      document.getElementById('teachers_list').className = "select w-full max-w-xs ml-6";
      document.getElementById('search').className = "input input-bordered w-full max-w-xs ml-6";
    }
}

// Функция, вызываемая при выборе группы
function teachSelect(select) {
    clearSchedule();
    // Загружаем расписание для выбранной группы
    loadTeachSchedule(select.value);
}

// Вызываем функции для загрузки данных при загрузке страницы
loadEduTypes(); // Загрузка типов образования

</script>
<?php
require_once Themes::getInstance()->current()['path'] . "/footer.php";
?>