/*********************************   AJAX FUNCTIONS   *******************************/

// Very useful function to create a Generic XMLHTTP object for my AJAX functions.
function createXMLHttpObject() {
    var xmlthhp;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xmlhttp;
}

/* Funcio Ajax per eliminar un registre d'Issues */
function delIssue(id,f)
{    
    if (confirm('Are you sure you want to delete this row?')) 
    {
        var xmlhttp = createXMLHttpObject();
        xmlhttp.onreadystatechange = function()
        { if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                document.getElementById(id).innerHTML=xmlhttp.responseText;
            }
        }        
        //Send xml http
        xmlhttp.open("GET", f, true);
        xmlhttp.send();
    }
}

function getFieldsWithValues(fields) 
{
    arr = fields.split('-');
    var cadena = '';
    
    for(i in arr) 
    {
        field = document.getElementById(arr[i]);
        if (field) {  //Have to check if <input> fields exists or not (in short form)
            field_name = arr[i];
            // Boolean Field ?
            if (field_name.substring(0,5)=="bool_") 
            {
                if (field.checked)
                    cadena += "&"+field_name+"=1";
                else
                    cadena += "&"+field_name+"=0";
            }
            // Non boolean field ?
            else
                if (document.getElementById(arr[i]).value) {
                    //Hauria d'escapar el caracter '&' per evitar lios - xxxtoni
                    valor = document.getElementById(arr[i]).value;
                    cadena += "&"+field_name+"=" + valor;
                }
        }
    }    
    
    return cadena;
}

/* This function is activated when the user clicks the Update button On any table */
/* Gets all the fields (except the id and passes them via Ajax to a function */
function loadXMLUpdateSyncOrNot(id,f,fields,async)
{
    //Work with synchronic mode
    fields = typeof fields !== 'undefined' ? fields : '';
    async  = typeof async !== 'undefined'  ? async  : true;
    
    var xmlhttp = createXMLHttpObject();
    xmlhttp.onreadystatechange = function()
    { if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            if (async)  //This is the usual asynchronic behaviour.
                document.getElementById(id).innerHTML = xmlhttp.responseText;
        }
    }

/* Add the values of the fields for the Update of the Draft */
    if (f!=='')  f += getFieldsWithValues(fields);
  
    //Show the Updater loader image - Excepte en el cas especial Sincrònic
    if (async)   $('#updating').show();
    
    //Send the AJAX request, with parameter sync set to true or false, depending
    //of the type of response needed
    f += "&fields=" + fields;
    xmlhttp.open("GET",f, async);
    xmlhttp.send();
    if (!async)  //This is the UNusual Synchronic behaviour I need for my dialog.
        document.getElementById(id).innerHTML = xmlhttp.responseText;
}


/**
 *  This is the classic/Generic AJAX function.
 *  Parameters:
 *      div:      The div where the code is going to be placed.
 *      f:        Number of the Ajax File to be executed in asynchronic mode
 *      async:    it should be true, normaly. Set to false when need synchronization
 *                with another Javascript action or function  xxxtoni search coderef in
 *                notifyIssue application! 
 */
function loadXMLDoc(div,f,async)
{   
    async =  typeof async !== 'undefined' ? async : true;

    $.ajax({
        type: "GET",  url: f,  async: async,
        success : function(resultat) {
            //He de resoldre el problema de la sincronia expressat més avall
            $("#"+div).html(resultat);
        }
    });
}