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
            if (!isset($_GET['id']))
            {
                exit('{"error": "ERROR: Not all parameters are passed"}');
            }

            $query = "INSERT INTO rkot_reports (id) 
            VALUES ('" . $_GET['id'] . "')";

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
