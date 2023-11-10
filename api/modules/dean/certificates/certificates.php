<?php
use FFI\Exception;
use portal\modules\DataBase;
use portal\modules\Auth;

$auth = Auth::getInstance();

if (!isset($_GET))
{
    exit('{"error": "ERROR: Function not passed"}');
}
if ($auth->checkAuth() !== True){
    exit('{"error": "NotAuthored"}');
}

$local['db'] = DataBase::getInstance();

        switch ($_GET['function'])
        {
            case 'add':
                if (!isset($_GET['student_id'], $_GET['employer']))
                {
                    exit('{"error": "ERROR: Not all parameters are passed"}');
                }
                $querytry = "WHERE student_id = '" . $_GET['student_id'] . "'and status = 'Processing'";
                $query = "INSERT INTO certificates (student_id, request_date, status, employer) VALUES ('" . $_GET['student_id'] . "', '" . date('Y-m-d H:i:s') . "', 'Processing', '" . $_GET['employer'] . "')";
                try
                {
                    $result = $local['db']->getRow('certificates', $querytry);
                    if ($result == false){
                        exit(json_encode($local['db']->query($query)));
                    }else{
                        exit('{"error": "ERROR: Certificate has already send"}');
                    }
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

                $query = "DELETE FROM certificates WHERE id = '" . $_GET['id'] . "'";

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
                if (!isset($_GET['type']))
                {
                    exit('{"error": "ERROR: Not all parameters are passed"}');
                }
                switch ($_GET['type']) {
                    case 'status':
                        if (!isset($_GET['id'], $_GET['status']))
                        {
                            exit('{"error": "ERROR: Not all parameters are passed"}');
                        }
    
                        $query = "UPDATE certificates 
                        SET status = '" . $_GET['status'] . "' WHERE id = '" . $_GET['id'] . "'";
    
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
                        if (!isset($_GET['id'], $_GET['employer'], $_GET['status']))
                        {
                            exit('{"error": "ERROR: Not all parameters are passed"}');
                        }
    
                        $query = "UPDATE certificates 
                        SET status = '" . $_GET['status'] . "', employer = '" . $_GET['employer'] . "' WHERE id = '" . $_GET['id'] . "'";
    
                        try
                        {
                            exit(json_encode($local['db']->query($query)));
                        }
                        catch(Exception $e)
                        {
                            exit('{"error": "ERROR: ' . $e . '"}');
                        }
                        break;
                }

            break;

            case 'get':

                switch ($_GET['count'])
                {
                    case 'table':
                        try
                        {
                            $query = $local['db']->query("SELECT count(id) FROM certificates");
                            $totalRecords = $query[0];

                            $sql = "SELECT id, student_id, request_date, status, employer FROM certificates";
                             
                            $query = $local['db']->query($sql);
                            
                            $result = [];

                            foreach($query as $row) {

                                $query = "SELECT * FROM users WHERE user_id = '" . $row['student_id'] . "'";

                                $result[] = [
                                    $row['id'],
                                    $local['db']->query($query)[0]['name'] . " | " . $row['student_id'],
                                    $row['request_date'],
                                    $row['employer'],
                                    '<select onchange="changeStatus(this)" entryid="' . $row['id'] . '" class="select max-w-xs ml-6">
                                        <option disabled selected>' . $row['status'] . '</option>
                                        <option>Processing</option>
                                        <option>Done</option>
                                    </select>',
                                    '<button class="btn btn-xs btn-success btn-disabled">Изменить</button> <button onClick="showConfirmationModal(this)" entryid="' . $row['id'] . '" class="btn btn-xs btn-error">Удалить</button> <button onClick="printExternal(`/api/dean/certificates?function=print`)" class="btn btn-xs">Печать</button>'
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

                    default:
                        exit('{"error": "ERROR: Function not passed"}');
                    break;
                }

            break;

            case 'print':
                $text = file_get_contents(__DIR__ . '/certificates_template/certificate_call.templ');
                
                $text = str_replace('%kod_spec%','KOD SPECASDHNJJKASFN', $text);

                exit($text);

                break;

            default:
                exit('{"error": "ERROR: Function not passed"}');
            break;
        }
        