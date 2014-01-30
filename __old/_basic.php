<?php
/* Is the result of the Query Null? */
function dbIsQueryResultNull($result) {
    foreach($result as $r) {
        //If there's a valid row, returns false.
        return false;
    }
    //There's no valid row -> returns true.
    return true;
}



/* Gets the difference, in days, between one date and today */
function compareDates($date) {
    //Return the number of days
    $current = time();
    
    $days_between = ceil(abs(strtotime($time) - strtotime($date)) / 86400);
//    return round( (strtotime(time()) - strtotime($date) ) / (3600*24) );
    return $days_between;
}
/* PAY ATTENTION: No white spaces before <?php or ?> because header() is involved */


/* Get from table _tables_fields how to filter the fields of $tb table */
function getFieldsFilter($tb)
{
//Get the filtered fields inside $chbvalues.
    $tables = new Tables();
    $row = $tables->getFirstRow("SELECT fields FROM _tables_fields WHERE table_name='$tb'");
    if ($row['fields']==NULL)
        $chbvalues = "1111111111111111111111111";
    else
        $chbvalues = $row['fields'];
    
    return $chbvalues;
}

function getSignUpError($error)  {
// Get and echo the error
    switch($error) {
        case 1:  return "El text de la CAPTCHA &eacute;s incorrecte";  break;
        case 2:  return "La contrasenya ha de tenir m&iacutenim 8 caracters";  break;
        case 3:  return "El nom d'usuari no pot ser buid";  break;
        case 4:  return "Llinatges no pot ser buid";  break;
        case 5:  return "Nom no pot ser buid";  break;
        case 6:  return "El nom d'usuari ha estat donat d'alta pr&egrave;viament";  break;
        case 7:  return "El nom d'usuari no correspon a cap professor";  break;
        default: return "";
    }
}

/* Funció per a determinar si l'identificador passat correspon al de l'administrador */
function isUserAdmin($userId) {
    if ($userId==3)
        return true;
    else
        return false;
}

/* This function detects, using $_SERVER data, if the user machine is mobile phone or desktop PC/laptop*/
/* MOBILE DEVICES DETECTION. 
 * Src: http://mobiforge.com/developing/story/lightweight-device-detection-php
 */
function isUserAMobileDevice() {
    $mobile_browser = '0';

    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $mobile_browser++;
    }

    if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'apps/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
        $mobile_browser++;
    }    

    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
        'wapr','webc','winw','winw','xda ','xda-');

    if (in_array($mobile_ua,$mobile_agents)) {
        $mobile_browser++;
    }
     /* xtoni
    if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini') > 0) {
        $mobile_browser++;
    }*/

    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) {
        $mobile_browser = 0;
    }
    return /*$mobile_browser*/1;  //xtoni Mode Proves.
}

/* Print a LISTBOX of a table derived from a FK field, with a certain value */
function printListBox($f, $tb, $v) 
{
    $tables = new Tables();
    $result = $tables->executaQuery("SELECT id,name FROM $tb ORDER BY name");
    $selectTag = "<select class=\"selectLB\" id=\"$f\" name=\"$f\" id=\"$f\">
                     <option value=\"\" class=\"optionField\">select $tb</option>";
        
    foreach ($result as $query2) 
    {
        $row2 = $query2;
        $selectTag.="   <option class=\"optionField\" value=\"".$row2['id']."\"   ";
        if ($v == $row2['id'])  //If this is the value selected
            $selectTag.=    " selected=\"selected\" ";
        $selectTag.= ">".$row2['name']."</option>";
    }
    $selectTag.="</select>";
    return $selectTag;
}

/**
 *  Used for displaying dates from  YEAR/MH/DY  to  DY/MH/YEAR 
 */
function toMyDate($data) 
{    
    if ($data!="") {
        $year   = substr($data,0,4);
        $month  = substr($data,5,2);
        $day    = substr($data,8,2);
        if ( ($day != "00") && ($month != "00") && ($year != "0000"))
            return $day . "-" . $month . "-" . $year;
        else
            return "";
    } else
        return "";
}
/**
 *  Used for storing dates from  DY/MH/YEAR to YEAR-MH-DY   
 */
function fromMyDate($data) 
{    
    $day    = substr($data,0,2);
    $month  = substr($data,3,2);
    $year   = substr($data,6,4);     
    return $year . "-" . $month . "-" . $day;
}


/*Converteix una data de tipus 2013-12-31 a text en català 
 * No escriu l'any a no ser que sigui diferent de l'actual.
 */
function toWrittenDate($data) {
    if (substr($data,0,1)=="0")
        return "";
    $year   = substr($data,0,4);
    $month  = substr($data,5,2);
    $day    = substr($data,8,2);
    
    //Dia (sense zero al davant)
    $result = intval($day)." ";
    
    //Mes
    $mesos=array("Gen","Feb","Març","Abr","Maig","Juny","Jul","Ago","Set","Oct","Nov","Des");
    $result .= $mesos[$month-1];
    
    $currentYear = substr(date("Y-m-d"),0,4);
    if ($currentYear!=$year)
            $result .=  " $year";
            
    return $result;
}

function getInputTextType($field) {
	switch($field) {
		case "description":
			return ;
		break;
		default:
			return ;  
		break;		               
	}
}



/* Is the user using a mobile device Browser? */
function isMobileBrowser() 
{
    global $mobile_browser;
    $set=false;
    if ($mobile_browser>0)
        $set=true;
    return $set;
}



function loadConfigFile($filename) {
    if ( file_exists($filename) ) {
        $xml = simplexml_load_file($filename); 
    } else {
        if ( file_exists("../".$filename) ) 
        {  //In case i'm opening the file after an AJAX call in generic_list_rows.php..
            $xml = simplexml_load_file("../".$filename); 
        } else 
        {
            $str = "Failed to open file $filename";
            exit($str); 
        }
    }
    return $xml;
}


/* Funcions per a obtenir l'hora i el dia en els formats indicats */
// format de sortida:    HH:MM
function getMyHour($datetime) {  return substr($datetime,11,5);  }
// Format de Sortida:  DD-MM-YYYY
function getMyDate($datetime) {  return toMyDate(substr($datetime,0,10));  }


/* DICCIONARI - DICTIONARY */
$dic = array("issues" => array('Incidències', 'Issues'), "menu" => array('Menú', 'Menu'),
    "signout" => array('Sortir', 'Sign Out'), "addissue" => array('Afegir Incidència', 'Add Issue'),
    "editissue" => array('Editar Incidència', 'Edit Issue'), "priority" => array('Prioritat', 'Priority'),
    "titleissue" => array('Títol', 'Title of the Issue'), "description" => array('Descripció', 'Description'),
    "datestart" => array('Data Inici', 'Date Start'), "save" => array('Guardar', 'Save Data'),
    "close" => array('Tancar', 'Close Issue'), "comments" => array('Comentaris','Comments'));
?>