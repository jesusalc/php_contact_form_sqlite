<?php
require_once('DBConnection.php');

class Actions extends DBConnection
{
    function __construct()
    {
        parent::__construct();
    }

    function __destruct()
    {
        parent::__destruct();
    }

    function save_message()
    {
        global $message;
        foreach ($_POST as $k => $v) {
            if (!is_numeric($k) && !is_numeric($v))
                $_POST[$k] = $this->escapeString($v);
        }
        if (empty($id)) {
            $_POST['date_created'] = date("Y m d H:i:s");
        }
        $_POST['date_updated'] = date("Y m d H:i:s");
        extract($_POST);
        $message = str_replace("\n", "<br>", $message);
        $data = "";
        // DEBUG var_dump($_POST);exit;
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id'))) {
                if (!empty($data)) $data .= ", ";
                if (!empty($id))
                    $data .= " `{$k}` = '{$v}' ";
                else {
                    $cols[] = $k;
                    $vals[] = $v;
                }
            }
        }
        if (isset($cols) && isset($vals)) {
            $data = " (`" . (implode('`, `', $cols)) . "`) VALUES ('" . (implode("','", $vals)) . "') ";
        }
        if (empty($id))
            $sql = "INSERT INTO `message_list` {$data}";
        else {
            $sql = "UPDATE `message_list` set {$data} where `message_id` = '{$id}' ";
        }
        @$save = $this->query($sql);
        if ($save) {
            $resp['status'] = "success";
            if (empty($id)) {
                $resp['msg'] = "Namen erfolgreich gesendet.";
            }
        } else {
            $resp['status'] = "failed";
            if (empty($id))
                $resp['msg'] = "Speichern von neuen Namen fehlgeschlagen.";
            else
                $resp['msg'] = "Aktualisierung der Namen fehlgeschlagen.";
            $resp['error'] = $this->lastErrorMsg();
            $resp['sql'] = $sql;
        }
        return json_encode($resp);
    }
}

$a = isset($_GET['a']) ? $_GET['a'] : '';
$action = new Actions();
switch ($a) {
    case 'save_message':
        echo $action->save_message();
        break;
    default:
        // default action here
        break;
}