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

        $query = "INSERT INTO groups (group_id) 
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

        $query = "DELETE FROM groups WHERE group_id = '" . $_GET['id'] . "'";

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
        if (!isset($_GET['group_id'], $_GET['group_name']))
        {
            exit('{"error": "ERROR: Not all parameters are passed"}');
        }

        $query = "UPDATE groups 
        SET group_name = '" . $_GET['group_name'] . "' WHERE id = '" . $_GET['group_id'] . "'";

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
            case 'all':
                if (!isset($_GET['edu_type']))
                {
                    exit('{"error": "ERROR: Not all parameters are passed"}');
                }

                $query = "SELECT * FROM groups WHERE education_type = '" . $_GET['edu_type'] . "'";

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
                if (!isset($_GET['group_id']))
                {
                    exit('{"error": "ERROR: Not all parameters are passed"}');
                }

                $query = "SELECT * FROM groups WHERE group_id = '" . $_GET['group_id'] . "'";

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