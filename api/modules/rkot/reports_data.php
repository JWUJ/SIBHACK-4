<?php
use FFI\Exception;
use portal\modules\DataBase;

if (!isset($_GET))
{
    exit('{"error": "ERROR: Function not passed"}');
}

$local['db'] = DataBase::getInstance();

    switch ($_GET['function'])
    {
        case 'add':
            if (!isset($_FILES))
            {
                exit('{"error": "ERROR: Not all parameters are passed"}');
            }

            $inputFileName = $_FILES['file']['name'];
            
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
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
            
            $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            
            $data = [];

            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $rowData = [];
            
                foreach ($cellIterator as $cell) {
                    $cellValue = $cell->getValue();
            
                    if ($cellValue instanceof \PhpOffice\PhpSpreadsheet\RichText\RichText) {
                        $richTextElements = $cellValue->getRichTextElements();
                        $text = '';
            
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
                $ddata['name'] = '№' . $matches[1] . ' от ' . $matches[2] . ' ' . $matches[3] . ' ' . $matches[4];
            }

            $query_main = "INSERT INTO rkot_reports (name, date_start, date_end, city, district, user_id) 
            VALUES ('" . $ddata['name'] . "', '" . $ddata['date_start'] . "','" . $ddata['date_end'] . "','" . $ddata['city'] . "','" . $ddata['depot'] . "','" . $_SESSION['user_id'] . "') RETURNING id";
            $id = $local['db']->query($query_main)[0]['id'];

            $query = "INSERT INTO rkot_reports_data (id_report, data) 
            VALUES ('" . $id . "', '" . $jsonData . "')";

            try
            {
                exit(json_encode($local['db']->query($query)));
            }
            catch(Exception $e)
            {
                exit('{"error": "ERROR: ' . $e . '"}');
            }
        break;

        case 'delete':
            if (!isset($_GET['id']))
            {
                exit('{"error": "ERROR: Not all parameters are passed"}');
            }

            $query = "DELETE FROM rkot_reports WHERE id = '" . $_GET['id'] . "'";

            try
            {
                exit(json_encode($local['db']->query($query)));
            }
            catch(Exception $e)
            {
                exit('{"error": "ERROR: ' . $e . '"}');
            }
        break;

        case 'edit':
            if (!isset($_GET['id'], $_GET['name'], $_GET['date_start'], $_GET['date_end'], $_GET['city_id']))
            {
                exit('{"error": "ERROR: Not all parameters are passed"}');
            }

            $query = "UPDATE rkot_reports 
            SET name = '" . $_GET['name'] . "', date_start = '" . $_GET['date_start'] . "', date_end = '" . $_GET['date_end'] . "', city_id = '" . $_GET['city_id'] . "' WHERE id = '" . $_GET['id'] . "'";

            try
            {
                exit(json_encode($local['db']->query($query)));
            }
            catch(Exception $e)
            {
                exit('{"error": "ERROR: ' . $e . '"}');
            }
        break;

        case 'get':

            switch ($_GET['count'])
            {
                case 'table':
                    if (!isset($_GET['id'], $_GET['table_id']))
                    {
                        exit('{"error": "ERROR: Not all parameters are passed"}');
                    }
                    try
                    {
                        $sql = "SELECT data FROM rkot_reports_data WHERE id_report = '" . $_GET['id'] . "'";
                         
                        $query = $local['db']->query($sql);

                        $data = json_decode($query[0]['data'], true);
                        $data = $data[$_GET['table_id']];

                        $result = [];
                        $isFirst = true;
                        $title = $data[0][0];
                        //echo '<pre>', print_r($data, true), '</pre>';
                        foreach($data as $arr) {
                            if ($isFirst){$isFirst = false;continue;}
                            $temp = [];
                            $istwoel = true;
                            foreach ($arr as $el => $value) {
                                if (is_numeric($value)) {
                                    $value = round($value, 2);
                                }
                                array_push($temp, $value);
                                if (!isset($arr[1]) and $istwoel){$istwoel = false;array_push($temp, '');}
                            }
                            $result[] = $temp;
                        }
                        
                        exit( json_encode([
                            'draw' => 10,
                            'recordsTotal' => count($result),
                            'recordsFiltered' => count($result),
                            'data' => $result,
                            'total_tables'=> count(json_decode($query[0]['data'], true)),
                            'title'=> $title,
                        ]));

                    }
                    catch(Exception $e)
                    {
                        exit('{"error": "ERROR: ' . $e . '"}');
                    }
                break;

                case 'one':
                    if (!isset($_GET['id']))
                    {
                        exit('{"error": "ERROR: Not all parameters are passed"}');
                    }

                    $query = "SELECT * FROM rkot_reports WHERE id = '" . $_GET['id'] . "'";

                    try
                    {
                        exit(json_encode($local['db']->query($query)));
                    }
                    catch(Exception $e)
                    {
                        exit('{"error": "ERROR: ' . $e . '"}');
                    }
                break;

                default:
                    exit('{"error": "ERROR: Function not passed"}');
                break;
            }

        break;

        default:
            exit('{"error": "ERROR: Function not passed"}');
        break;
    }
