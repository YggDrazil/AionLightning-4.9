<?PHP
// ----------------------------------------------------------------------------
// Klasse :  ItemTemplatesClass
// Version:  1.01, Mariella, 11/2015
// Zweck  :  Verarbeitung der Item-Templates
// ----------------------------------------------------------------------------
// Nutzung:  $<var> = new ItemTemplateClass(<tab>,<log>)
//
//            <tab>  = die Tabelle mit den Item-Templates
//            <log>  = J = Logging der Klasse einschalten
//                     N = Logging der Klasse ausschalten (default)
//                     Log-Datei = log_DropTemplateClass.txt
// ----------------------------------------------------------------------------
Class ItemTemplateClass
{
    var $tabItemTemplates  = "";            // übergebene Item-Tabelle
    
    // ------------------------------------------------------------------------
    // Constructor
    // ------------------------------------------------------------------------
    function ItemTemplateClass($tabItemTemplates)
    {
        $this->tabItemTemplates  = $tabItemTemplates;
    }
    // ------------------------------------------------------------------------
    // Rückgabe Anzahl der Zeilen in der Tabelle
    // ------------------------------------------------------------------------
    function getCountRows()
    {
        return count($this->tabItemTemplates);
    }
    // ------------------------------------------------------------------------
    // prüfen, ob das angegebene Item vorhanden ist
    //
    // Return: true = vorhanden, false = nicht vorhanden
    // ------------------------------------------------------------------------
    function checkItemInTemplate($itemId)
    {
        $key = "'".$itemId."'";
        
        if (isset($this->tabItemTemplates[$key]))
            return true;
        
        return false;
    }
    // ------------------------------------------------------------------------
    // Liefert den Key für ein Item zurück
    // ------------------------------------------------------------------------
    function getItemTableKey($itemId)
    {        
        reset($this->tabItemTemplates);
        
        while (list($key,) = each($this->tabItemTemplates))
        {
            if ($this->tabItemTemplates[$key]['id'] == $itemId)
                return $key;
        }
        return "";
    }
    // ------------------------------------------------------------------------
    // Liefert den Namen für das  Item zurück
    // ------------------------------------------------------------------------
    function getItemName($itemId)
    {        
        $key = "'".$itemId."'";
        
        if (isset($this->tabItemTemplates[$key]))
            return $this->tabItemTemplates[$key]['name'];
        
        return "";
    }
    // ------------------------------------------------------------------------
    // Liefert die Gruppe für das  Item zurück
    // ------------------------------------------------------------------------
    function getItemGroup($itemId)
    {        
        $key = "'".$itemId."'";
        
        if (isset($this->tabItemTemplates[$key]))
            return $this->tabItemTemplates[$key]['group'];
        
        return "";
    }
    // ------------------------------------------------------------------------
    // Liefert eine Tabelle zu dem vorgegebenen Item zurück
    // ------------------------------------------------------------------------
    function getItemInfoToItemId($itemId)
    {
        $retTab   = array();
        
        $key  = "'".$itemId."'";
        
        if (isset($this->tabItemTemplates[$key]))
        {
            $retTab['id']        = $this->tabItemTemplates[$key]['id'];
            $retTab['name']      = $this->tabItemTemplates[$key]['name'];
            $retTab['level']     = $this->tabItemTemplates[$key]['level'];
            $retTab['category']  = $this->tabItemTemplates[$key]['category'];
            $retTab['quality']   = $this->tabItemTemplates[$key]['quality'];
            $retTab['group']     = $this->tabItemTemplates[$key]['group'];
        }
        else
        {
            $retTab['id']        = $itemId;
            $retTab['name']      = "NOTFOUND";
            $retTab['level']     = "0";
            $retTab['category']  = "NOTFOUND";
            $retTab['quality']   = "NOTFOUND";
            $retTab['group']     = "NOTFOUND";
        }
        
        return $retTab;
    }
    // ------------------------------------------------------------------------
    // Liefert eine Tabelle zu den vorgegebenen Items zurück
    // 
    // Die Parameter-Tabelle enthält die gewünschten ItemIds
    // ------------------------------------------------------------------------
    function getItemInfoToItemTab($tabItems)
    {
        $retTab   = array();
        $cnt      = 0;
        
        for ($i=0;$i<count($tabItems);$i++)
        {
            $key  = "'".$tabItem[0]."'";
            
            if (isset($tabItemTemplate[$key]))
            {
                $retTab[$cnt]['id']        = $this->tabItemTemplates[$key]['id'];
                $retTab[$cnt]['name']      = $this->tabItemTemplates[$key]['name'];
                $retTab[$cnt]['level']     = $this->tabItemTemplates[$key]['level'];
                $retTab[$cnt]['category']  = $this->tabItemTemplates[$key]['category'];
                $retTab[$cnt]['quality']   = $this->tabItemTemplates[$key]['quality'];
                $retTab[$cnt]['group']     = $this->tabItemTemplates[$key]['group'];
            }
            else
            {
                $retTab[$cnt]['id']        = $tabItems[$i];
                $retTab[$cnt]['name']      = "NOTFOUND";
                $retTab[$cnt]['level']     = "0";
                $retTab[$cnt]['category']  = "NOTFOUND";
                $retTab[$cnt]['quality']   = "NOTFOUND";
                $retTab[$cnt]['group']     = "NOTFOUND";
            }
            $cnt++;
        }
        sort ($retTab);
        
        return $retTab;
    }
    // ------------------------------------------------------------------------
    // Liefert eine Tabelle zu den vorgegebenen Items zurück
    //
    // Entsprechend den übergebenen Such-Kriterien werden alle gefundenen
    // Items in einer Tabelle zurückgegeben. Die ItemId wird in die Suche nur
    // dann einbezogen, wenn sie nicht 9-stellig ist
    // ------------------------------------------------------------------------
    function getItemInfoToSearch($item="",$level="*",$categ="*",$quali="*",$group="*")
    {
        $retTab   = array();
        $cnt      = 0;
        $lang     = strlen($item);
        $lang     = $lang == 9 ? 0 : $lang;
        
        reset($this->tabItemTemplates);
        
        while (list($key,) = each($this->tabItemTemplates))
        {                           
            if ( ($lang   > 0   && substr($this->tabItemTemplates[$key]['id'],0,$lang) == $item)
            ||   ($level != ""  && ($level == "*" || $level == $this->tabItemTemplates[$key]['level']))
            ||   ($categ != ""  && ($categ == "*" || $categ == $this->tabItemTemplates[$key]['category']))
            ||   ($quali != ""  && ($quali == "*" || $quali == $this->tabItemTemplates[$key]['quality']))
            ||   ($group != ""  && ($group == "*" || $group == $this->tabItemTemplates[$key]['group'])) )
            {
                $retTab[$cnt]['id']        = $this->tabItemTemplates[$key]['id'];
                $retTab[$cnt]['name']      = $this->tabItemTemplates[$key]['name'];
                $retTab[$cnt]['level']     = $this->tabItemTemplates[$key]['level'];
                $retTab[$cnt]['category']  = $this->tabItemTemplates[$key]['category'];
                $retTab[$cnt]['quality']   = $this->tabItemTemplates[$key]['quality'];
                $retTab[$cnt]['group']     = $this->tabItemTemplates[$key]['group'];
                
                $cnt++;
            }
        }
        
        sort($retTab);

        return $retTab;
    }
}
?>