<?php
$fields = "name,descripcio,date_start,fkey_prioritat";
$fields_s = "name-descripcio-date_start-fkey_prioritat-fkey_location";
//$id comes from main.php
if (!$id) 
{
    //Create a DRAFT into DB
    $today = date("Y-m-d");
    //Bit Checked: 0 si és creada per un Membre que no és administrador
    $bool_checked = ($username==="admin") ? 1 : 0;
    $sql =  "INSERT INTO issues(".$fields.",fkey_state,fkey_member,fkey_location, bool_checked) ";
    $sql .= "VALUES ('', '', '$today', 'B', 0, ".$rowmember['id'].",'','$bool_checked');";
    $result = $tables->executaQuery($sql);
    //Get the id from this issue.
    $result = $tables->executaQuery("SELECT MAX(id) FROM issues");
    // Get ID of the Draft
    foreach ($result as $query2) $id = $query2[0];
} 
else
{      //It's an EDIT
    $sql = "SELECT iss.name,iss.descripcio,iss.fkey_prioritat,iss.date_start,iss.bool_checked, "
           ."iss.fkey_location, lo.name AS location_name "
           ."FROM issues AS iss LEFT JOIN locations AS lo ON lo.id=iss.fkey_location "
           ."WHERE iss.id= :id";
    //Get the Row
    $row = $tables->getFirstRow($sql, array('id'), array($id));
    
    //Set the issue as Checked.
    if ($username=="admin")
        if ($row['bool_checked']==0) {
            $sql = "UPDATE issues SET bool_checked=1 WHERE id= :id";
            $void = $tables->executaQuery($sql, array('id'), array($id));
        }
}
if (!isset($row)) {
    $title       = "addissue";
    $name        = "";
    $description = "";
    $priority    = "B";  /* Prioritat Normal */
    $date_start  = $today;
    $location    = "";
} else {
    $title       = "editissue";
    $name        = $row['name'];
    $description = $row['descripcio'];
    $priority    = $row['fkey_prioritat'];
    $date_start  = $row['date_start'];
    $location    = $row['location_name'];
    $fkey_location=$row['fkey_location'];
}

//Valor de $state en cas de Tancar la Incidencia
$state = (isUserAdmin($rowmember['id'])) ?  2 /* usuari admin */ : 3 /* els altres */;

//Donar com a llegits (bool_checked <= 1) els Comments pendents

$sqlUsuari = " fkey_member". ( (isUserAdmin($rowmember['id'])) ? " <>3 " : "=3");  /** xtoni */
$sql = "UPDATE comments SET bool_checked=1 WHERE $sqlUsuari AND fkey_issue= :id";
$readComments = $tables->executaQuery($sql, array('id'), array($id));

$issue = $id;
?>