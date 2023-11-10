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
    case 'get':

        switch ($_GET['count'])
        {
            case 'all':
                $query = "SELECT * FROM subjects";

                try
                {
                    exit(json_encode($local['db']->query($query)));
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

                $query = "SELECT * FROM subjects WHERE id = '" . $_GET['id'] . "'";

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