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
        if (!isset($_GET['group_id'], $_GET['teacher_id'], $_GET['day_of_week'], $_GET['time'], $_GET['subject'], $_GET['fraction'], $_GET['office'], $_GET['type_d']))
        {
            exit('{"error": "ERROR: Not all parameters are passed"}');
        }

        $query = "INSERT INTO schedules (group_id, teacher_id, day_of_week, time, subject_id, fraction, office, type) 
        VALUES ('" . $_GET['group_id'] . "', '" . $_GET['teacher_id'] . "', '" . $_GET['day_of_week'] . "', '" . $_GET['time'] . "', '" . $_GET['subject'] . "', '" . $_GET['fraction'] . "', '" . $_GET['office'] . "', '" . $_GET['type_d'] . "')";

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

        $query = "DELETE FROM schedules WHERE id = '" . $_GET['id'] . "'";

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
        if (!isset($_GET['group_id'], $_GET['teacher_id'], $_GET['day_of_week'], $_GET['time'], $_GET['subject']))
        {
            exit('{"error": "ERROR: Not all parameters are passed"}');
        }

        $query = "UPDATE schedules 
        SET group_id = '" . $_GET['group_id'] . "', teacher_id = '" . $_GET['teacher_id'] . "', day_of_week = '" . $_GET['day_of_week'] . "', time = '" . $_GET['time'] . "', subject = " . $_GET['subject'] . " WHERE id = '" . $_GET['group_id'] . "'";

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
        if (!isset($_GET['group_id']))
        {
            exit('{"error": "ERROR: Not all parameters are passed"}');
        }

        $query = "SELECT * FROM schedules WHERE group_id = '" . $_GET['group_id'] . "'";

        try
        {
            exit(json_encode($local['db']->query($query)));
        }
        catch(Exception $e)
        {
            exit('{"error": "ERROR: ' . $e . '"}');
        }
    break;

    case 'getbyteacher':
        if (!isset($_GET['teacher_id']))
        {
            exit('{"error": "ERROR: Not all parameters are passed"}');
        }

        $query = "SELECT * FROM schedules WHERE teacher_id = '" . $_GET['teacher_id'] . "'";

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