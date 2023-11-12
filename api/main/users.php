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
            if (!isset($_GET['username'], $_GET['name'], $_GET['password']))
            {
                exit('{"error": "ERROR: Not all parameters are passed"}');
            }

            $query = "INSERT INTO users (username, name, password, role) 
            VALUES ('" . $_GET['username'] . "', '" . $_GET['name'] . "',  '" . password_hash($_GET['password'], PASSWORD_DEFAULT) . "', '2')";

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

            $query = "DELETE FROM users WHERE user_id = '" . $_GET['id'] . "'";

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
                        $query = $local['db']->query("SELECT count(user_id) FROM users");
                        $totalRecords = $query[0];

                        $sql = "SELECT user_id, username, name, role FROM users";
                         
                        $query = $local['db']->query($sql);

                        $result = [];

                        foreach($query as $row) {
                            $result[] = [
                                $row['user_id'],
                                $row['username'],
                                $row['name'],
                                $row['role'],
                                '<button onClick="showConfirmationModal(this)" entryid="' . $row['user_id'] . '" class="btn btn-xs btn-error">Удалить</button>'
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

                    $query = "SELECT * FROM users WHERE user_id = '" . $_GET['id'] . "'";

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
