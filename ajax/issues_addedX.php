<?php
require_once'../_basic.php';
require_once '../model/Tables.php';

$tables = new Tables();

/* Get the fields of the table */
$fields = explode("-", $_GET['fields']);

switch($_GET['op']) {
    case "UPDATE":
        //Updating the table..	
        $sql= "UPDATE issues SET fkey_state='1',"; /* In case it was a Draft */
        /* Get the fields */
        $i=0;
        foreach($fields as $field) {
            //Si hi ha un valor en la casella del camp.
            if (isset($_GET[$field])) {
                if ($i++>0) $sql .= ",";
                switch(substr($field,0,5)) {
                //is field a date?
                    case "date_":
                        $sql .= "$field='".fromMyDate ($_GET[$field])."'";
                        break;
                //is field a fkey?
                    case "fkey_":
                        //Set NULL in case of an empty value
                        if ($_GET[$field]=="")
                            $sql .= "$field=NULL";
                        else
                            $sql .= "$field='".$_GET[$field]."'";
                        break;
                    case "descr": /* The input field is a <textarea>, need to escape quotes, etc.. */
                        $sql .= "$field='".htmlspecialchars($_GET[$field], ENT_QUOTES)."'";
                        break;
                    default:      /* The input field is a <textarea>, need to escape quotes, etc.. */
                        $sql .= "$field='".htmlspecialchars($_GET[$field], ENT_QUOTES)."'";
                        break;
                }
            }
        }
       $sql .= " WHERE id= :id";
       //The Statement is prepared to avoid SQL Injection
       $result = $tables->executaQuery($sql, array('id'), array($_GET['id']));
//       $result = $tables->executaQuery($sql." WHERE id='".$_GET['id']."'");
       break;
   
   case "CLOSE":
       //Closes the Issue.
       $sql = "UPDATE issues SET fkey_state='".$_GET['state']."' WHERE id= :id";
       $result = $tables->executaQuery($sql, array('id'), array($_GET['id']));
       break;
}
?>