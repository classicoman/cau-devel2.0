<?php
require_once '../_basic.php';
require_once '../model/Tables.php';

$tables = new Tables();

switch($_GET['op']) 
{
    //Create a New comment attached to $issue
    case "NEW":
        $name = htmlspecialchars($_GET['name'], ENT_QUOTES);
        $issue = $_GET['issue'];
        $member = $_GET['member'];
        $hour = date('Y-m-d H:i:s');
        $sql =  "INSERT INTO comments(hour,fkey_issue,description,bool_checked,fkey_member) ";
        $sql .= " VALUES('$hour', '$issue', '$name', 0, $member)";
        $y = $tables->executaQuery($sql);
        
        /* Send an Email to the user*/        
        //Obté la informació de la Issue
        $rowIssue = $tables->getIssue($issue);
        if ($member!=3) // Si el comentari l'ha escrit un professor, el correu se li ha d'enviar a admin
            $direccio = $tables->getMemberEmail(3); 
        else {          // Si el comentari l'ha escrit l'administrd, el correu se li ha d'enviar a qui la va obrir
            $direccio = $tables->getMemberEmail( $rowIssue['fkey_member'] );
        }

        $subject = "Comentari nou en la incidència: ".$rowIssue['name'];
        $message = "<html><body>"
                    ."<h2>Comentari nou en la incidència: ".$rowIssue['name']."</h2>"
                    ."<p>".$name."</p>"
                    . "</body></html>";
        $headers =  "From:norespongueu@easdib.com\r\n"
                    . "MIME-Version: 1.0\r\n"
                    ."Content-Type: text/html; charset=ISO-8859-1\r\n";
        //Send the email
        mail($direccio, $subject, $message,$headers);

        // Render ajax Template
        include '../templates/issues_comments_sub.php'; 
        
        break;
    //Detach $cat from this $issue
    case "DEL":
        $comment = $_GET['comment'];
        $sql = "DELETE FROM comments WHERE id= :id";
    	$result = $tables->executaQuery($sql, array('id'),array($comment));
        break;
}
?>