<link rel="stylesheet" type="text/css" href="css/issues.css"/>

<div id="header">
    <div id="logo">
        <img src="images/logo2.png" alt="Logo"/>
    </div>
    <div id="title">Incid&egrave;ncies ESD</div>
    <div id="username"><?php echo $username ?></div>
</div>
<div id="menubar">
    <div id="menu">
        <div class="dropdown">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              <?php echo $dic['menu'][0] ?>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="index.php?pg=issues&amp;class=0">Obertes</a></li>
                <li><a href="index.php?pg=issues&amp;class=1">Tancades</a></li>
                <li class="divider"></li>
                <li><a href="index.php?pg=logout"><?php echo $dic['signout'][0] ?></a></li>
          </ul>
        </div>
    </div>
    <div id="add">
        <a href="index.php?pg=added&amp;id=0"><img src="images/add.png"/></a>
    </div>
</div>

<div id="all">
    <div id="div_rows">
<?php  foreach ($rows as $row)  {   ?>	    
        <div class="fila" onclick="javascript:location.href='<?php echo "index.php?pg=added&maxrows=$maxRows&id=".$row['id'] ?>'">
            <div class="date">
                <?php echo (isUserAdmin($rowmember['id'])) ? $row['username'].", " : "" ?>
                <?php echo toWrittenDate($row['date_start']) ?>
            </div>
            <div class="<?php echo ($row['markIt']) ? 'name_new' : 'name' ?>">
                <?php echo $row["name"] ?>
            </div>
            <div class="<?php echo ($row['markIt']) ? 'desc_new' : 'desc' ?>">
                <?php echo (strlen($row["descripcio"])<80) ? $row["descripcio"] : substr($row["descripcio"],0,100)." [...]" ?>
            </div>
        </div>
<?php }  ?>  
    </div>
</div>


<script>
    //Per a canviar el color de la icona quan és espitjada o s'hi passa per sobre
    $('a#add img')
        .mouseover(function() { 
            var src = "images/add-b.png";
            $(this).attr("src", src);
        })
        .mouseout(function() {
            var src = "images/add.png";
            $(this).attr("src", src);
        });
</script>