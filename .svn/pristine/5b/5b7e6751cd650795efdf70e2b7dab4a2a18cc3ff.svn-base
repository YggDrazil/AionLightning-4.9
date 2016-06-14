<?PHP
// ----------------------------------------------------------------------------
// Klasse :  ItemDropGroupClass
// Version:  1.01, Mariella, 11/2015
// Zweck  :  Verarbeitung der Item-Drop-Groups
// ----------------------------------------------------------------------------
// Nutzung:  $<var> = new ItemDropGroupClass(<tab>,<log>)
//
//            <tab>  = die Tabelle mit den Item-DropGroups
// ----------------------------------------------------------------------------
Class ItemDropGroupClass
{
    var $tabItemDropGroups = "";            // übergebene DropGroup-Tabelle
    
    // ------------------------------------------------------------------------
    // Constructor
    // ------------------------------------------------------------------------
    function ItemDropGroupClass($tabItemDropGroups)
    {
        $this->tabItemDropGroups = $tabItemDropGroups;
    }
    // ------------------------------------------------------------------------
    // Rückgabe Anzahl der Zeilen in der Tabelle
    // ------------------------------------------------------------------------
    function getCountRows()
    {
        return count($this->tabItemDropGroups);
    }
    // ------------------------------------------------------------------------
    // prüfen, ob die angegebene Gruppe vorhanden ist
    //
    // Return: true = vorhanden, false = nicht vorhanden
    // ------------------------------------------------------------------------
    function checkGroupInDropGroup($group)
    {        
        if (isset($this->tabItemDropGroups[$group]))
            return true;
        
        return false;
    }
    // ------------------------------------------------------------------------
    // Liefert den Namen für die Gruppe zurück
    // ------------------------------------------------------------------------
    function getGroupName($group)
    {                
        if (isset($this->tabItemDropGroups[$group]))
            return $this->tabItemDropGroups[$key]['group'];
        
        return "";
    }
    // ------------------------------------------------------------------------
    // Liefert die Anzahl Items mit dieser Gruppe zurück
    // ------------------------------------------------------------------------
    function getGroupItemCount($group)
    {                
        if (isset($this->tabItemDropGroups[$key]))
            return $this->tabItemDropGroups[$key]['cntitems'];
        
        return "";
    }
    // ------------------------------------------------------------------------
    // Liefert eine Tabelle zu der vorgegebenen Suche zurück
    //
    // Entsprechend dem übergebenen Such-Kriterium werden alle gefundenen
    // Drop-Gruppen in einer Tabelle zurückgegeben
    // mittels dem Zusatzparameter isnot (true/false) kann das Ergebnis
    // umgekehrt werden
    // ------------------------------------------------------------------------
    function getGroupInfoToSearch($such="*",$isnot=false)
    {
        $retTab   = array();
        $cnt      = 0;
    
        reset($this->tabItemDropGroups);
            
        while (list($key,) = each($this->tabItemDropGroups))
        {            
            if ($such == "*" || stripos($this->tabItemDropGroups[$key]['name'],$such) !== false)
            {
                // Bedingung erfüllt, aber evtl. umkehren
                if (!$isnot)
                {
                    $retTab[$cnt]['name']      = $this->tabItemDropGroups[$key]['name'];
                    $retTab[$cnt]['cntitems']  = $this->tabItemDropGroups[$key]['cntitems'];
                    
                    $cnt++;
                }
            }
            else
            {
                // Bedingung NICHT erfüllt, aber evtl. umkehren
                if ($isnot)
                {
                    $retTab[$cnt]['name']      = $this->tabItemDropGroups[$key]['name'];
                    $retTab[$cnt]['cntitems']  = $this->tabItemDropGroups[$key]['cntitems'];
                    
                    $cnt++;
                }
            }
        }
        
        sort($retTab);
        
        return $retTab;
    }
}
?>