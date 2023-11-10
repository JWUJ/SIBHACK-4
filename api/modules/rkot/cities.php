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

            $query = "INSERT INTO rkot_cities (id) 
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

            $query = "DELETE FROM rkot_cities WHERE id = '" . $_GET['id'] . "'";

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
            if (!isset($_GET['id'], $_GET['name']))
            {
                exit('{"error": "ERROR: Not all parameters are passed"}');
            }

            $query = "UPDATE rkot_cities 
            SET name = '" . $_GET['name'] . "' WHERE id = '" . $_GET['id'] . "'";

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
                        $query = $local['db']->query("SELECT count(id) FROM rkot_cities");
                        $totalRecords = $query[0];

                        $sql = "SELECT id, name FROM rkot_cities";
                         
                        $query = $local['db']->query($sql);

                        $result = [];

                        foreach($query as $row) {
                            $result[] = [
                                $row['id'],
                                $row['name'],
                                "Тут чтото)"
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

                    $query = "SELECT * FROM rkot_cities WHERE id = '" . $_GET['id'] . "'";

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
