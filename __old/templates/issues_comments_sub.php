<?php
$sql = "SELECT t1.description, t1.hour, t2.username FROM comments AS t1 INNER JOIN members AS t2";
$sql .= " WHERE t1.fkey_issue=$issue AND t1.fkey_member=t2.id";
$sql .= " ORDER BY t1.hour DESC";

$rows = $tables->executaQuery($sql);

//variable que utilitzo per guardar la data a imprimir
$currentDate = "";
$date = "";
foreach($rows as $row)
{
    $date = getMyDate($row['hour']);
    $hour = getMyHour($row['hour']);
    $username = $row['username'];
    if ($date != $currentDate) {  
        //Primera iteracio: no poso cap data
        if ($currentDate=="")  
            $currentDate = $date;
        else {
            
        //He d'imprimir la data
?>       
    <div class="comments_date"><?php echo $currentDate ?></div>
<?php
           $currentDate = $date; 
        }
    }
?>

<div class="<?php echo ($username=="admin") ? "row_admin" : "row_user"; ?>">  
    <div class="header">
        <div class="username"><?php echo $row['username'] ?></div>
        <div class="hour"><?php echo $hour ?></div>
    </div>
    <div class="text"><?php  echo $row['description'] ?></div>
</div>
<?php
}
    if ($date !="") {
?>
    <div class="comments_date"><span><?php echo $currentDate ?></span></div>
<?php
    }
?>