<?PHP
// ----------------------------------------------------------------------------
// Klasse :  DropTemplatesClass
// Version:  1.02, Mariella, 11/2015
// Zweck  :  Verarbeitung der Drop-Templates
// ----------------------------------------------------------------------------
// Nutzung:  $<var> = new DropTemplateClass(<tab>,<log>)
//
//            <tab>  = die Tabelle mit den Drop-Templates
//            <log>  = J = Logging der Klasse einschalten
//                     N = Logging der Klasse ausschalten (default)
//                     Log-Datei = log_DropTemplateClass.txt
// ----------------------------------------------------------------------------
Class DropTemplateClass
{
    var $logit            = false;               // LOG erzeugen J/N
    var $hdllog           = "";                  // Handle für LogOutput
    var $itemKeyArray     = array();             // optimierte Item-Tabelle 
    var $tabDropTemplates = array();             // übergebene Item-Tabelle
    var $strichzeile      = "";                  // Strichzeile für das LOG
    var $errInit          = false;               // Fehler bei Init vorhanden?
    var $errText          = "";                  // HTML-Error-Text
    
    // ------------------------------------------------------------------------
    // Constructor
    // ------------------------------------------------------------------------
    function DropTemplateClass($tabDropTemplates,$withlog=false)
    {
        $this->logit            = $withlog;
        $this->strichzeile      = "\n".str_pad("",80,"-");
        $this->tabDropTemplates = $tabDropTemplates;
        
        if ($this->logit)
        {
            $this->hdllog = fopen("log_DropTemplateClass.txt","w");
            fwrite($this->hdllog,"\n"."TabTemplate erhalten mit ".count($this->tabDropTemplates)." Gruppen");
        }
        
        $this->initItemKeyArray();
    }
    // ------------------------------------------------------------------------
    // Fehler vorhanden?
    // ------------------------------------------------------------------------
    function isError()
    {
        return $this->errInit;
    }
    // ------------------------------------------------------------------------
    // Fehlermeldungen der Instanzierung zurückgeben
    // ------------------------------------------------------------------------
    function getErrorText()
    {
        return "<font color='magenta'>".$this->errText."</font><br><br>";
    }
    // ------------------------------------------------------------------------
    // zur Performance-Optimierung das itemKeyArray initialisieren
    // ------------------------------------------------------------------------
    function initItemKeyArray()
    {
        // alle Gruppen durchlaufen
        // Index 0 = ItemSortId
        // Index 1 = GruppenId
        // Index 2 = Gruppenname
        // Index 3 = Item-Arrays
        
        if ($this->logit) 
        {
            fwrite($this->hdllog,"\n".$this->strichzeile);
            fwrite($this->hdllog,"\nStart InitItemKeyArray für ".count($this->tabDropTemplates)." Gruppen");
        }
        
        for ($g=0; $g<count($this->tabDropTemplates); $g++)    
        {
            if ($this->logit) fwrite($this->hdllog,"\n- InitItemKeyArray für Gruppe: ".$this->tabDropTemplates[$g][1]." mit ".count($this->tabDropTemplates[$g][3])." Items");
            
            // alle Items durchlaufen
            for ($i=0; $i<count($this->tabDropTemplates[$g][3]); $i++)
            {
                $key = "'".$this->tabDropTemplates[$g][3][$i][0]."'";
                
                if ($this->logit) fwrite($this->hdllog,"\n  - InitItemKeyArray für Item=".$key." mit Gruppe=".$this->tabDropTemplates[$g][1]);
                
                if (isset($this->itemKeyArray[$key]))
                {
                    $this->errInit = true;
                                            
                    $this->errText  .= "<br>Item: ".$this->tabDropTemplates[$g][3][$i][0].
                                       " in mehreren Gruppen definiert, muss eindeutig sein";
                    // $this->itemKeyArray[$key]['group'] .= ";".$this->tabDropTemplates[$g][1];
                }
                else
                    $this->itemKeyArray[$key]['group']  = $this->tabDropTemplates[$g][1];
            }
        }
        
        if ($this->logit)
        {
            fwrite($this->hdllog,$this->strichzeile);
            fwrite($this->hdllog,"\nSTART Verarbeitung: Warte auf Aufrufe");
            fwrite($this->hdllog,$this->strichzeile);
        }
    }
    // ------------------------------------------------------------------------
    // prüfen, ob ein Item in einer Drop-Gruppe definiert wurde
    //
    // Return: Gruppennamen oder die ersten 3 Stellen des Items
    // ------------------------------------------------------------------------
    function checkItemInTemplate($itemId)
    {
        $key = "'".$itemId."'";
        $ret = "";
        
        if (isset($this->itemKeyArray[$key]))
            $ret = $this->itemKeyArray[$key]['group'];
        
        if ($this->logit) fwrite($this->hdllog,"\n- checkItemInTemplate für ".$itemId." -> Gruppe = ".$ret);
        
        return $ret;
    }
    // ------------------------------------------------------------------------
    // Rückgabe des Langtextes zur Gruppe
    // ------------------------------------------------------------------------
    function getGroupName($group)
    {
        $ret = $group;
        $key = "'".$group."'";
    
        // Item-Drop-Zeilen
        for ($i=0; $i<count($this->tabDropTemplates); $i++)
        {
            if ($this->tabDropTemplates[$i][1] == $group)
            {
                $ret = $this->tabDropTemplates[$i][2];
                $i   = count($this->tabDropTemplates);
            }
        }
            
        if ($this->logit) fwrite($this->hdllog,"\n- getGroupName für ".$group." -> Gruppenname = ".$ret);
        
        return $ret;
    }
    // ------------------------------------------------------------------------
    // alle Items einer Gruppe als Tabelle zurückgeben
    // ------------------------------------------------------------------------
    function getAllGroupItemsAsTab($group)
    {
        $tabGroup = split(";",$group);
        $retTab   = array();
        $retCnt   = 0;
        
        if ($this->logit && count($tabGroup) > 1)
            fwrite($this->hdllog,"- ACHTUNG: Mehrere Gruppenzuordnungen!");
            
        for ($t=0; $t<count($tabGroup); $t++)
        {
            if ($this->logit) fwrite($this->hdllog,"\n- getAllGroupItemsAsTab für Gruppe: ".$tabGroup[$t]);
            
            for ($g=0; $g<count($this->tabDropTemplates); $g++)
            {
                // Gruppe suchen
                if ($this->tabDropTemplates[$g][1] == $tabGroup[$t])
                {
                    // Item-Drop-Zeilen
                    for ($i=0; $i<count($this->tabDropTemplates[$g][3]); $i++)
                    {
                        $retTab[$retCnt]['sort']  = $this->tabDropTemplates[$g][0].$this->tabDropTemplates[$g][1];
                        $retTab[$retCnt]['group'] = $this->tabDropTemplates[$g][2];
                        $retTab[$retCnt]['item']  = $this->tabDropTemplates[$g][3][$i][0];
                        $retTab[$retCnt]['proz']  = $this->tabDropTemplates[$g][3][$i][1];
                        $retTab[$retCnt]['name']  = $this->tabDropTemplates[$g][3][$i][2];
                        $retCnt++;                        
                    }
                    
                    if ($this->logit) fwrite($this->hdllog,"\n  - liefere Tabelle mit ".count($retTab)." Einträgen");
                }
            }
        }
        return $retTab;
    }
}
?>