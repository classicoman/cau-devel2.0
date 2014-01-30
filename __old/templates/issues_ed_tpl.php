<link rel="stylesheet" type="text/css" href="css/added.css"/>  <!-- S'ha de posar al head de main - xtoni -->

<div id="header_added">
    <div id="rotul"><?php echo $dic[$title][0] ?></div>
    <div id="btnBack"><a id="btnBack"><img src="images/back.png"/></a></div>
</div>

<div id="all">
      <div><?php echo $dic['titleissue'][0].":" ?></div>
      <div><strong><?php echo $name ?></strong></div>
      <div><?php echo $dic['description'][0].":" ?></div>
      <div> <strong><?php echo $row['descripcio'] ?></strong></div>
      <div class="fila">
          Data Inici:<strong><?php echo " ".toMyDate($date_start)."  " ?></strong>
<?php if ($location!="")  {  ?>
          Ubicació:<?php echo "<strong> $location</strong>" ?>
<?php } ?>
      </div>
</div>
<div id="issues_comments_box">
<?php  include 'templates/issues_comments.php';   ?>
</div>


<!-- Put the JQuery always at the bottom or it won't work! -->
<script type="text/javascript">    
    //Per a canviar el color de la icona quan és espitjada o s'hi passa per sobre
    $('a#btnBack img')
        .mouseover(function() { 
            var src = "images/back-b.png";
            $(this).attr("src", src);
        })
        .mouseout(function() {
            var src = "images/back.png";
            $(this).attr("src", src);
        });
        
    //En espitjar sobre fletxa de BACK
    $('a#btnBack').click ( function() { 
        window.location ='index.php?pg=issues';
    });
</script>