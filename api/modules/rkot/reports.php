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
                    try
                    {
                        $query = $local['db']->query("SELECT count(id) FROM rkot_reports");
                        $totalRecords = $query[0];

                        $sql = "SELECT id, name, date_start, date_end, city, district FROM rkot_reports";
                         
                        $query = $local['db']->query($sql);

                        $result = [];

                        foreach($query as $row) {
                            $result[] = [
                                $row['id'],
                                $row['name'],
								'С ' . $row['date_start'] . ' по ' . $row['date_end'],
								$row['city'],
                                $row['district'],
                                '<a href="/admin/pages/rkot/report?id=' . $row['id'] . '" class="btn btn-xs">Открыть</a> <button class="btn btn-xs btn-success btn-disabled">Изменить</button> <button onClick="showConfirmationModal(this)" entryid="' . $row['id'] . '" class="btn btn-xs btn-error">Удалить</button>'
                            ];
                        }
                        
                        exit( json_encode([
                            'draw' => 10,
                            'recordsTotal' => $totalRecords,
                            'recordsFiltered' => $totalRecords,
                            'data' => $result,
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
