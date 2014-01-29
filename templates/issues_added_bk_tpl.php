<link rel="stylesheet" type="text/css" href="css/added.css"/>  <!-- S'ha de posar al head de main - xtoni -->

<input id="js_changed" name="js_changed" type="hidden"/>

<div id="reg_saved" name="reg_saved">
    <div id="updating"><p>Guardant...</p></div>
</div>    
<div id="header_added">
    <div id="rotul"><?php echo $dic[$title][0] ?></div>
    <div id="btnBack"><a id="btnBack"><img src="images/back.png"/></a></div>
</div>

<div id="all">
    <div><?php echo $dic['titleissue'][0] ?></div>
    <div> <input id="name" type="text" autofocus="autofocus" value="<?php echo $name ?>"/> </div>
    <div><?php echo $dic['description'][0] ?></div>
    <div class="fila">
        <textarea id="descripcio" class="desc"><?php echo $description ?></textarea>
    </div>
    <div class="fila">
<?php   echo printListBox("fkey_prioritat", "prioritats", $priority); //Default Priority = Normal  ?>
             <input id="date_start" type="text" name="date_start"
                    placeholder="Data Inici" value="<?php echo toMyDate($date_start) ?>"/>
    </div>
    <div class="fila">Aula:
<?php   echo printListBox("fkey_location", "locations", $fkey_location); //Default Priority = Normal  ?> 
    </div>

    <div id="buttons">
        <button type="button" id="btnUpdate" onclick="onClickSave()"><?php echo $dic['save'][0] ?>
        </button>                 
        <button type="button" id="btnClose" onclick="onClickClose()"><?php echo $dic['close'][0] ?>
        </button>                 
    </div>
</div>

<div id="issues_comments_box">
<?php   include 'templates/issues_comments.php';   ?>
</div>


<script type="text/javascript">
    
//DatePicker
    $(function() {
        $( "#date_start" ).datepicker({ dateFormat: 'dd-mm-yy' }).val(); 
    });

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
    
//Activation of 'SAVE' mode
    $('#name, #descripcio, #date_start, #fkey_prioritat, #fkey_location').change ( function(e) {
        document.getElementById('js_changed').value = 'SAVE';
    });
    
//Save Data
    function onClickSave() {
        //Hi ha hagut algun canvi?
        if (document.getElementById('js_changed').value=='SAVE') {
            loadXMLUpdateSyncOrNot(<?php echo "'reg_saved','ajax/issues_addedX.php?id=$id&op=UPDATE','$fields_s'" ?>,false);
        }
        //Torna a l'estat inicial
        document.getElementById('js_changed').value = '';
        $('#updating').hide();
    }

//Close Issue
    function onClickClose() {
        if (confirm('Segur que voleu tancar la Incidència?')) 
            loadXMLUpdateSyncOrNot(<?php echo "'reg_saved','ajax/issues_addedX.php?id=$id&op=CLOSE&state=$state'" ?>);
    }


//En espitjar sobre fletxa de BACK
    $('#btnBack').click ( function(e) { 
        if (document.getElementById('js_changed').value == 'SAVE')
            threebuttonsdialog('Si', 'No', 'Cancel·lar', $(this));
        else
            window.location ='index.php?pg=issues';
    });

/* coderefx: http://jsfiddle.net/CdwB9/3/ */
//Three buttons Dialog that is prompted after closing an issue without saving
function threebuttonsdialog(button1, button2, button3, element){
        var btns = {};
        btns[button1] = function(){
            //1.Yes -> Save data with SYNC
            loadXMLUpdateSyncOrNot(<?php echo "'reg_saved','ajax/issues_addedX.php?id=$id&op=UPDATE','$fields_s'" ?>,false);
            /* I need this code to: save first or it won't save, and to save before going to index.php */
            window.location ='index.php?pg=issues';
            $(this).dialog("close");
        };
        btns[button2] = function(){ 
            //2.No -> Jump.
            window.location ='index.php?pg=issues';
                $(this).dialog("close");
        };
        btns[button3] = function(){ 
            //3.Cancel -> Do nothing.
            $(this).dialog("close");
        };
        //Obre un diàlog amb tants botons com haguem definit
        //No sé per què utilitza <div></div>...  xxxtoni
        $("<div></div>").dialog({
            autoOpen: true,
            resizeable: false,
            title: 'Voleu guardar els canvis en la incidència?',
            modal:true,   //Modal: en mode syncrònic, espera el clic de l'user.
            buttons:btns  //Botons
        });
    }
</script>