<?php
include 'DB.php';

class Tables {
    //La base de dades
    var $base;
    protected $tb;
        
    function __construct($tb=null) {
        $this->base = new DB();
        $this->base->connecta();
        $this->tb = $tb;
    }
    
    
    function deleteById($id) {
        $this->base->executaQuery("DELETE FROM ".$this->tb." where id= :id",array('id'),array($id));
    }

    
    function deleteByIdIntoValues($values) {
        $this->base->executaQuery( "DELETE FROM ".$this->tb." WHERE id IN ($values)");
       
    }
    
    
    function executaQuery($queryString, $fields=null, $values=null) {
        return $this->base->executaQuery($queryString, $fields, $values);
    }
    
    
    /* Gets an associative array, where the index is the 'id' field and the contents the 'name' field */
    function getArrayOfValues() 
    {
            $result = $this->executaQuery("SELECT id,name FROM ".$this->tb);
            $arrValues = array();
            $i=0;
            foreach ($result as $row) {
                    $arrValues[$row['id']] = $row['name'];
                    $i++;
            }
            return $arrValues;
    }
    
    
    /*xtoni Codi a Optimitzar per a que només tregui una fila */
    function getFirstRow($queryString, $fields=null, $values=null)
    {
        try {
            $rows = $this->base->executaQuery($queryString, $fields, $values);
        } 
        catch (PDOException $err) {
            echo "<p>Error en executar Query, DB.php: <i>".$err."</i></p><p>".$queryString."</p>"; 
        }
        
        return $rows->fetch(PDO::FETCH_ASSOC);    
    }
    
    
    //xtoni - hauria d'anar a una classe anomenada Members.php
    function getMemberEmail($member) {
        $row = $this->getFirstRow("SELECT email FROM members WHERE id=$member");
        return $row['email'];
    }
    
    //xtoni - igual que la superior
    function getIssue($issue) {
        return $this->getFirstRow("SELECT * FROM issues WHERE id=$issue"); 
    }
    
    /* Print a LISTBOX of a table derived from a FK field, with a certain value */
    function getListBoxHTML($f, $tb, $v) 
    {
        $result =  $this->executaQuery("SELECT id,name FROM $tb ORDER BY name");
        $selectTag = "<select class=\"selectLB\" id=\"$f\" name=\"$f\">
                         <option value=\"\" class=\"optionField\">Selecciona ".printFieldLabel($tb)."</option>";     
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
    
    
    function getTableCols($separator) {
        $this->base->connecta();
        $sql = "SHOW COLUMNS FROM ".$this->tb."";
        $result =  $this->base->executaQuery($sql);

        $fields = "";
        $i=0;
        $autoIncrement = $this->isTableWithAutoInc();
        //Composite a string with the names of the fields separated by $sep
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            if ( !( $autoIncrement && (!$i++) ) )  //Jump first field 'id' because it is an AUTOINCREMENT
                $fields .= $row['Field'].$separator;
        }	  
        //Remove the last ","  
        return substr($fields,0,strlen($fields)-1);
    }
    
    
    
    
    /*
     * Function:   Executa una query genèrica damunt la taula $tb
     */
    function get() {
        
    }
    
    /*
     * Get a row from $this->tb identified by $id
     */
    function getRow($id)
    {
        return $this->getFirstRow("SELECT * FROM ".$this->tb." WHERE id='$id'");
    }
    
    
    /* If there is an AUTOINCREMENT id field, then on Import-Export-Add the treatment is different.*/
    function isTableWithAutoInc() 
    {
        switch ($this->tb) {
            case "issues":  return 1;  break;
            default:        return 0;  break;
        }
        return 0;
    }

    
    function showColumns() {
        $this->base->executaQuery("SHOW COLUMNS FROM ".$this->tb);
    }
    
    
    /*
     * Function: Updates the $fiels of a Table ($tb) setting the values 
     * Returns:  Should return a value depending of the result of the Query (success or failure)  xxxtoni
     */
    function update($tb,$fields,$id) {
            $sql = "UPDATE $tb SET ";
        
            $i=0;
            foreach($fields as $field)  
            {
                if (isset($_GET[$field]) && ($field != 'id')) {
                    if ($i++>0)
                        $sql .= ",";
                    //field date_
                    switch(substr($field,0,5)) {
                        case "date_":
                            $sql .= "$field='".fromMyDate ($_GET[$field])."'";
                            break;
                        case "fkey_":
                            //Set NULL in case of an empty value
                            if ($_GET[$field]=="")
                                    $sql .=  "$field=NULL";
                            else
                                $sql .=  "$field='".$_GET[$field]."'";
                            break;
                        case "name":
                        case "descr": /* The input field is a <textarea>, need to escape quotes, etc.. */
                            $sql .= "$field='".htmlspecialchars($_GET[$field], ENT_QUOTES)."'";
                            break;
                        default:
                            $sql .= "$field='".$_GET[$field]."'";
                            break;
                    }
                }
            }
        
            $sql .= " WHERE id='$id'";
        
            return $this->base->executaQuery($sql);
    }
    
        
    function updateFieldByIdIntoValues($field, $value, $values) {
        $this->base->executaQuery("UPDATE ".$this->tb." SET $field='$value' WHERE id IN ($values)");        
    }

}
?>