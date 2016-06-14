<?php
// ----------------------------------------------------------------------------
// Script : dropgen_ps.php
// Version: 1.03, Mariella, 11/2015
// Zweck  : erzeugt aus der vom PacketSamurai erstellten NPC-Drop-Datei eine
//          für die Emu nutzbare Drop-Definitions-Datei
// ----------------------------------------------------------------------------
// Changes: 1.00   Erstellung Drop-Generator für ADB
//          1.01   Ergänzung für den PS-Drop-Generator
//          1.02   bessere Startseiten-Handhabung
//                 Integration von Drop-Template-Verarbeitung
//                 Erweiterung um Einbeziehung von vorhandener Drop-Datei (PS)
//          1.03   Erweiterung Scan der vorhandenen PS-Drop-Datei (Item-Name)
// ----------------------------------------------------------------------------
include("../includes/inc_globals.php");          // allgemeine Prozeduren
include("includes/drop_template_inc.php");       // Tabelle mit Drop-Templates
include("includes/item_template_inc.php");       // Tabelle mit Item-Templates
include("classes/drop_template_class.php");      // Klasse DropTemplateClass
include("classes/item_template_class.php");      // Klasse ItemTemplateClass
 
$selfname = basename(__FILE__);
$infoname = "PS-Drop-Definitionen umformatieren";

$dropTpl  = new DropTemplateClass($tabDropTemplates, false);  // ohne LOG
$itemTpl  = new ItemTemplateClass($tabItemTemplates);

// ----------------------------------------------------------------------------
//                       F  U  N  K  T  I  O  N  E  N
// ----------------------------------------------------------------------------
// verschlüsselte interne Tabelle für das Prüfen von Npc/Item
// ----------------------------------------------------------------------------
function checkNpcItemInTable($npcid,$itemid)
{
    global $tabrefs;
    
    // Weitere Performance-Steigerung (reduziert die Anzahl Tabellenzeilen beim
    //                                 Aufbau der internen Tabelle, da bereits
    //                                 vorhandene Npcs/Items ignoriert werden.
    $key = "'".$npcid."-".$itemid."'";
    
    if (isset($tabrefs[$key]))
    {
        return true;
    }
    else
    {
        $tabrefs[$key] = $key;
        return false;
    }    
}
// ----------------------------------------------------------------------------
// interne Tabelle mit den Npcs/Items
// ----------------------------------------------------------------------------
function addItemToItemTab($npcid,$itemid,$proz,$amin,$amax,$name="")
{
    global $tabitems, $cntitems, $dropTpl, $itemTpl, $tabrefs;
    
    // wenn schon vorhanden, dann ignorieren (aber max_amount prüfen!)
    if (checkNpcItemInTable($npcid,$itemid))
    {    
        for ($i=0;$i<$cntitems;$i++)
        {
            // höheren max_amount übernehmen
            if ($tabitems[$i]['npcid'] == $npcid
            &&  $tabitems[$i]['item']  == $itemid)
            {
                if ($tabitems[$i]['amax'] < $amax)
                    $tabitems[$i]['amax'] = $amax;
            }
        }
        
        return "IGN";
    }
        
    $ret   = "";
    $group = $dropTpl->checkItemInTemplate($itemid);
      
    if ($group != "")
    {
        $tabgroup = $dropTpl->getAllGroupItemsAsTab($group);
        $domax    = count($tabgroup);
        
        for ($i=0;$i<$domax;$i++)
        {
            checkNpcItemInTable($npcid,$tabgroup[$i]['item']);
            
            $tabitems[$cntitems]['sort']  = $npcid.$tabgroup[$i]['sort'];
            $tabitems[$cntitems]['npcid'] = $npcid;
            $tabitems[$cntitems]['group'] = $tabgroup[$i]['group'];
            $tabitems[$cntitems]['templ'] = "J";
            $tabitems[$cntitems]['item']  = $tabgroup[$i]['item'];
            $tabitems[$cntitems]['proz']  = $tabgroup[$i]['proz']; 
            $tabitems[$cntitems]['name']  = $itemTpl->getItemName($tabgroup[$i]['item']);
            $tabitems[$cntitems]['amin']  = $amin;
            $tabitems[$cntitems]['amax']  = $amax;
            $tabitems[$cntitems]['doit']  = "J";

            $cntitems++; 
        }
        $ret = "TPL";
    }
    else
    {
        if ($itemid == "182400001")
        {            
            if ($amax == "1")
            {
                $amin = "200";
                $amax = "900";
            }
        }
        
        $group    = $itemTpl->getItemGroup($itemid);
                
        $tabitems[$cntitems]['sort']  = $npcid.substr($itemid,0,3).$group;    
        $tabitems[$cntitems]['npcid'] = $npcid;
        $tabitems[$cntitems]['group'] = $group;
        $tabitems[$cntitems]['templ'] = "N";
        $tabitems[$cntitems]['item']  = $itemid;
        $tabitems[$cntitems]['proz']  = $proz; 
        $tabitems[$cntitems]['name']  = $itemTpl->getItemName($itemid);
        $tabitems[$cntitems]['amin']  = $amin;
        $tabitems[$cntitems]['amax']  = $amax;
        $tabitems[$cntitems]['doit']  = "J";

        $cntitems++; 
        $ret = "INS";
    }   
    return $ret;    
}
// ----------------------------------------------------------------------------
// Drops aus der neuen PS-Drop-Datei ermitteln
// ----------------------------------------------------------------------------
function scanNewPsDrops()
{
    global $ifile, $tabitems;
        
    $lines  = file($ifile);
    $anznpc = 0;
    $anzles = 0;
    $anzitm = 0;
    $anzins = 0;
    $anztpl = 0;
    $anzign = 0;
    $anzdop = 0;
    $oldcnt = 0;
        
    logHead("Scanne die neue Datei");
    logLine("Anzahl Zeilen neue Datei",count($lines));
    
    $npcid   = "";
    $itemid  = "";
    $amin    = 1;
    
    flush();
    $domax = count($lines);
    
    // in interne Tabelle übernehmen
    for ($l=0;$l<$domax;$l++)
    {
        $anzles++;
        $line = $lines[$l];
        
        if (stripos($line,"_drops npcid=") !== false)
        {
            $npcid = substr($line,stripos($line,"_drops npcid=") + 14);
            $npcid = trim(substr($npcid,0,stripos($npcid,'"')));
            $anznpc++;            
            $itemid = "";            
        }
        else
        {
            if (stripos($line,"<drop ") !== false)
            {
                $itemid = substr($line,stripos($line,"item_id=") + 9);
                $itemid = trim(substr($itemid,0,stripos($itemid,'"')));
                $amax   = substr($line,stripos($line,"quantity=") + 10);
                $amax   = trim(substr($amax,0,stripos($amax,'"')));
                
                if ($amax == "" || $amax == "0")
                    $amax = "1";
                    
                $anzitm++;
            
                if ($itemid != "0" && trim($itemid) != "")
                {
                    $oldcnt = count($tabitems);
                    
                    $ret = addItemToItemTab($npcid,$itemid,"10.00",$amin,$amax,"");
                    
                    $oldcnt = count($tabitems) - $oldcnt - 1;
                    
                    switch ($ret)
                    {
                        case "TPL": $anztpl += $oldcnt; 
                                    $anzins++; 
                                    break;
                        case "INS": $anzins++; break;
                        case "IGN": $anzdop++; break;
                        default   : break;                    
                    }
                }
                else
                    $anzign++;
            } 
        }            
    }
    
    logLine("Anzahl Zeilen gelesen",$anzles,"(aus der PS-Drop-Datei)");
    logLine("Anzahl NPCs gefunden",$anznpc,"(Zeile mit npcid=...)");
    logLine("Anzahl Items gefunden ",$anzitm,"(Zeile mit item_id=...)");
    logLine("- davon ignoriert","");
    logLine("&nbsp; - doppelte Angaben",$anzdop,"(Duplikate zu NpcId/ItemId)");
    logLine("&nbsp; - fehlerhaftes Item",$anzign,"(ItemId=0 oder leer)");
    logLine("- davon verarbeitet",$anzins,"(g&uuml;ltige Item-Zeilen)");
    logLine("Items zus. aus Drop-Template",$anztpl,"(siehe Drop-Template-Tabelle)");
}
// ----------------------------------------------------------------------------
// bestehende Drops einmischen (vorgesehen für die nächste Version (=1.03)
// ----------------------------------------------------------------------------
function scanOldPsDrops()
{
    global $oldfile, $domix, $tabitems;
    
    if (!file_exists($oldfile) || $domix == "N")
        return;
        
    $lines   =  file($oldfile);
    $anznpc  = 0;
    $anzles  = 0;
    $anzitm  = 0;
    $anzins  = 0;
    $anztpl  = 0;
    $anzign  = 0;
    $anzdop  = 0;
    $oldcnt  = 0;
    
    logHead("Scanne die bestehende Datei");
    logLine("Anzahl Zeilen bestehende Datei",count($lines));
    
    $npcid   = "";
    $group   = "";
    $itemid  = "";
    $proz    = "";
    $amin    = "";
    $amax    = "";
    
    flush();
    $domax = count($lines);
    
    for ($l=0;$l<$domax;$l++)
    {
        // ToDo: Scannen
        $line = $lines[$l];
        $anzles++;
        
        // Npcid suchen
        if (stripos($line,"npc_id=") !== false)
        {
            $npcid = substr($line,stripos($line,"npc_id=") + 8);
            $npcid = trim(substr($npcid,0,stripos($npcid,'"'))); 
            $anznpc++;
            $itemid = "";            
        }
        // Gruppe suchen
        if (stripos($line,"drop_group ") !== false)
        {
            $group = substr($line,stripos($line," name=") + 7);
            $group = trim(substr($group,0,stripos($group,'"'))); 
            $itemid = "";            
        }
        // Item suchen in Zeile:
        // <drop item_id="182400001" chance="10.00" min_amount="1" max_amount="1" no_reduce="false" eachmember="false" />        
        if (stripos($line,"<drop ") !== false)
        {
            $item = substr($line,stripos($line,"item_id=") + 9);
            $item = trim(substr($item,0,stripos($item,'"')));
            $proz = substr($line,stripos($line,"chance=") + 8);
            $proz = trim(substr($proz,0,stripos($proz,'"')));
            $amin = substr($line,stripos($line,"min_amount=") + 12);
            $amin = trim(substr($amin,0,stripos($amin,'"')));
            $amax = substr($line,stripos($line,"max_amount=") + 12);
            $amax = trim(substr($amax,0,stripos($amax,'"')));
            
            $anzitm++;
            $oldcnt = count($tabitems);
            
            // die Gruppe momentan ignorieren, um evtl. neue Drop-Templates zu berücksichtigen
            $ret = addItemToItemTab($npcid,$item,$proz,$amin,$amax);
            
            $oldcnt = count($tabitems) - $oldcnt - 1;
            
            switch ($ret)
            {
                case "TPL": $anztpl += $oldcnt; 
                            $anzins++; 
                            break;
                case "INS": $anzins++; break;
                case "IGN": $anzdop++; break;
                default   : break;                    
            }
        }   
    }
    logLine("Anzahl Zeilen gelesen",$anzles,"(aus der PS-Drop-Datei)");
    logLine("Anzahl NPCs gefunden",$anznpc,"(unterschiedliche NPCs)");
    logLine("Anzahl Items gefunden ",$anzitm,"(Zeile mit item_id=...)");
    logLine("- davon verarbeitet",$anzins,"(g&uuml;ltige Item-Zeilen)");
    logLine("- davon ignoriert",$anzdop,"(Duplikate zu NpcId/ItemId)");
    logLine("- Items zus. aus Drop-Template",$anztpl,"(siehe Drop-Template-Tabelle)");
}
// ----------------------------------------------------------------------------
// formatierte Drop-Definitionen ausgeben
// ----------------------------------------------------------------------------
function formatPsDropFile()
{
    global $tabitems, $oldfile, $npctx, $ifile;
    
    $anzles  = 0;
    $anzout  = 0;
    $anznpc  = 0;
    $anzitm  = 0;
    $anzdup  = 0;
    
    scanNewPsDrops();
    scanOldPsDrops();
    
    logHead("formatierte Drop-Definitionen erzeugen");
    
    sort($tabitems);
    
    flush();
    
    $hdlout  = openOutputFile($oldfile);
    
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
    fwrite($hdlout,"<!-- generiert am/um ".date("d.m.Y H:i")." aus PS-Drop-Datei: ".basename($ifile)." -->\n");
    fwrite($hdlout,'<npc_drops xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="npc_drops.xsd">'."\n");
    
    $anzout  += 3;
    $oldnpcid = "";
    $olditgrp = "";
    $deftext  = '" chance="10.00" min_amount="1" max_amount="1" no_reduce="false" eachmember="false" />';
    $lastitem = "";
    $domax    = count($tabitems);
    
    for ($i=0;$i<$domax;$i++)
    {
        $newitem = $tabitems[$i]['sort'].$tabitems[$i]['item'];
        $anzles++;
        
        if ($lastitem != $newitem)
        {         
            // neuer NPC?
            if ($oldnpcid != $tabitems[$i]['npcid']) 
            {
                if ($oldnpcid != "")
                {
                    // alten NPC abschliessen
                    fwrite($hdlout,"        </drop_group>"."\n");
                    fwrite($hdlout,"    </npc_drop>"."\n");
                    
                    $anzout += 2;
                }
                $anznpc++;
                $oldnpcid = $tabitems[$i]['npcid'];
                $olditgrp = "";
                
                // neuen NPC starten
                if ($npctx == "J")
                {
                    fwrite($hdlout,'    <!-- NPC '.$oldnpcid.' -->'."\n");
                    $anzout++;
                }
                    
                fwrite($hdlout,'    <npc_drop npc_id="'.$oldnpcid.'">'."\n");
                
                $anzout++;
            }
                
            // neue Drop_group?
            if ($olditgrp != $tabitems[$i]['group'])
            {
                if ($olditgrp != "")
                {
                    fwrite($hdlout,'        </drop_group>'."\n");
                    
                    $anzout++;
                }
                    
                $olditgrp = $tabitems[$i]['group'];
                
                fwrite($hdlout,'        <drop_group name="'.$olditgrp.'" use_category="true" race="PC_ALL">'."\n");
                
                $anzout++;
            }
            
            // Drop ausgeben
            $anzitm++;      
            
            $deftext  = '" chance="'.$tabitems[$i]['proz'].'" min_amount="'.$tabitems[$i]['amin'].'" max_amount="'.
                        $tabitems[$i]['amax'].'" no_reduce="false" eachmember="false" name="'.$tabitems[$i]['name'].'" />';
                
            fwrite($hdlout,'            <drop item_id="'.$tabitems[$i]['item'].$deftext."\n");
            
            $anzout++;
        }
        else
        {
            $anzdup++;
        }
        $lastitem = $newitem;
    }
    fwrite($hdlout,"        </drop_group>"."\n");
    fwrite($hdlout,"    </npc_drop>"."\n");
    fwrite($hdlout,"</npc_drops>");
    
    $anzout += 3;
    
    logLine("Anzahl Zeilen gelesen",$anzles,"(aus der internen Tabelle)");
    logLine("- davon Duplikate ignoriert",$anzdup,"(NpcId / ItemId identisch)");
    logLine("Anzahl NPCs",$anznpc,"(unterschiedliche NPCs)");
    logLine("Anzahl Items",$anzitm,"(Items in der Datei)");
    logLine("Anzahl Drop-Zeilen neu",$anzout,"(Gesamt Neuformatierung)");
}
// ----------------------------------------------------------------------------
//
//                                 M  A  I  N
//
// ----------------------------------------------------------------------------
// Übergabe-Parameter (GET) aufbereiten
// ----------------------------------------------------------------------------
$ifile =  isset($_GET['ifile']) ? $_GET['ifile'] : "";
$ofile =  isset($_GET['ofile']) ? $_GET['ofile'] : "";
$npctx =  isset($_GET['npctx']) ? "J" : "N";
$domix =  isset($_GET['domix']) ? "J" : "N";
// ----------------------------------------------------------------------------
// globale Definitionen
// ----------------------------------------------------------------------------

putHtmlHead("$selfname - $infoname","PS-Drop-Definitionen umformatieren");

// ToDO:  Instanzen haben eine Instanz-ID	 @InstanceID(300460000)
// ----------------------------------------------------------------------------
// Start der Verarbeitung
// ----------------------------------------------------------------------------
logStart();

$starttime = microtime(true);

$oldfile   = formFileName("../outputs/drop_output_ps/".$ofile);
$tabitems  = array();
$cntitems  = 0;
$tabrefs   = array();

// Fehler bei der Initialiserung?
if ($dropTpl->isError())
    echo $dropTpl->getErrorText();
    
if ($ifile == "" || $ofile == "")
   echo "Ohne die notwendigen Drop-Vorgaben kann nichts generiert werden";
else
{   
    // Pfad/Datei merken
    $hdlout = openOutputFile("saved_data/dropPsLastPath.txt");
    fwrite($hdlout,substr($ifile,0,strripos($ifile,"\\"))."\n");
    fwrite($hdlout,$ofile);
    fclose($hdlout);
    
    $oldExist = file_exists($oldfile) ? ( ($domix == "J") ? "vorhandene Datei einmischen" : "vorhandene Datei &uuml;berschreiben") : "keine Datei vorhanden";
    
    logHead("Vorgaben");
    logLine("Eingabedatei",$ifile);
    logLine("Ausgabedatei",$ofile);
    logLine("Alt/Neu Mischen",$domix," (".$oldExist.")");
    logLine("NpcId als Kommentar",$npctx);
    
    if ($ifile == $ofile)
        echo "<br><br>Aufgrund identischer Eingabe-/Ausgabedatei-Namen wurde die Verarbeitung abgebrochen";
    else
        formatPsDropFile();
}
			
logSubHead("<br><br><br><center><a href='javascript:history.back()'>zur&uuml;ck</a></center>");

logStop($starttime,true);
	
putHtmlFoot();
?>