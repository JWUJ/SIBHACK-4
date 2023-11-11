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
$currentRow = null;

foreach ($worksheet->getRowIterator() as $row) {
    $cellIterator = $row->getCellIterator();
    $rowIndex = $row->getRowIndex();
    
    $rowData = [];

    foreach ($cellIterator as $cell) {
        $cellValue = $cell->getValue();
        $cellColor = $cell->getStyle()->getFill()->getStartColor()->getRGB();

        if ($rowIndex >= 17 && $cellColor == 'B0C4DE') {
            // Если цвет ячейки - красный и строка больше 17, начинаем новый подмассив
            if ($currentRow !== null) {
                $data[] = $currentRow;
            }
            $currentRow = [];
        }

        $rowData[] = $cellValue;
    }

    if ($currentRow !== null) {
        $currentRow[] = $rowData;
    }
}

if ($currentRow !== null) {
    $data[] = $currentRow;
}

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

$data = array_values(array_filter($data, function($subarray) {
    return !empty($subarray);
}));


//$data = array_filter_recursive($data);
$jsonData = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

file_put_contents('output.json', $jsonData);

echo 'Данные успешно преобразованы в JSON и сохранены в output.json.';

echo '<pre>', print_r($data, true), '</pre>';
?>