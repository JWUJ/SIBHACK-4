<?php
$inputFileName = '1.xlsx';

/** Create a new Xls Reader  **/
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
//    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
//    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xml();
//    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Ods();
//    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Slk();
//    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Gnumeric();
//    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
/** Load $inputFileName to a Spreadsheet Object  **/
$spreadsheet = $reader->load($inputFileName);

$worksheet = $spreadsheet->getActiveSheet();

$data = [];

foreach ($worksheet->getRowIterator() as $row) {
    $cellIterator = $row->getCellIterator();
    $rowData = [];

    foreach ($cellIterator as $cell) {
        $cellValue = $cell->getValue();

        // Проверка типа значения ячейки
        if ($cellValue instanceof \PhpOffice\PhpSpreadsheet\RichText\RichText) {
            $richTextElements = $cellValue->getRichTextElements();
            $text = '';

            // Извлечение текста из RichText элементов
            foreach ($richTextElements as $element) {
                if ($element instanceof \PhpOffice\PhpSpreadsheet\RichText\TextElement) {
                    $text .= $element->getText();
                }
            }

            $rowData[] = $text;
        } else {
            $rowData[] = $cellValue;
        }
    }

    $data[] = $rowData;

    // Прекращаем обработку после 16 строк
    if (count($data) >= 16) {
        break;
    }
}

// Удаление пустых массивов
            function array_filter_recursive($input) 
            { 
              foreach ($input as &$value) 
              { 
                if (is_array($value)) 
                { 
                  $value = array_filter_recursive($value); 
                } 
              } 
            
              return array_filter($input); 
            } 
            
            $data = array_filter_recursive($data);

// Обработка данных
if (preg_match('/Место проведения контроля: (.+)/u', $data[13][0], $matches)) {
    $ddata['city'] = $matches[1];
}
if (preg_match('/В\s(.*?)$/u', $data[7][0], $matches)) {
    $ddata['depot'] = $matches[1];
}
if (preg_match_all('/(\d{2}\.\d{2}\.\d{4})/', $data[12][0], $matches)) {
    $dates = $matches[0];
    if (count($dates) >= 2) {
        $ddata['date_start'] = $dates[0];
        $ddata['date_end'] = $dates[1];
    }
}
if (preg_match('/№ (\d+) от «(\d+)» ([а-яА-Я\s]+) (\d+) г\./u', $data[9][0], $matches)) {
    $protocolNumber = $matches[1]; // Номер протокола
    $day = $matches[2]; // День
    $month = $matches[3]; // Месяц
    $year = $matches[4]; // Год

    $ddata['name'] = '№' . $protocolNumber . ' от ' . $day . ' ' . $month . ' ' . $year;
} else {
    echo 'Совпадений не найдено.';
}


// Вывод данных для отладки
echo '<pre>';
print_r($ddata);
echo '</pre>';
?>