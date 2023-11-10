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

        $query = "INSERT INTO education_type (name) 
            VALUES ('" . $_GET['name'] . "')";

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

        $query = "DELETE FROM education_type WHERE id = '" . $_GET['id'] . "'";

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

        $query = "UPDATE education_type 
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

        $query = "SELECT * FROM education_type";

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