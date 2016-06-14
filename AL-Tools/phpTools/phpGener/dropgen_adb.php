<?php
// ----------------------------------------------------------------------------
// Script : dropgen_adb.php
// Version: 1.02, Mariella, 11/2015
// Zweck  : erzeugt aus den Vorgaben (Cut&Paste) von der aiondatabase.net-Seite
//          eine Drop-Definition für die Emu
// ----------------------------------------------------------------------------
include("../includes/inc_globals.php");          // allgemeine Prozeduren
include("includes/drop_template_inc.php");       // Tabelle mit Drop-Templates
include("includes/item_template_inc.php");       // Tabelle mit Item-Templates
include("classes/drop_template_class.php");      // Klasse DropTemplateClass
include("classes/item_template_class.php");      // Klasse ItemTemplatesClass

$selfname = basename(__FILE__);
$infoname = "Drop-Definitionen generieren";

$dropTpl  = new DropTemplateClass($tabDropTemplates, false);  // ohne LOG
$itemTpl  = new ItemTemplateClass($tabItemTemplates);
// ----------------------------------------------------------------------------
//                       F  U  N  K  T  I  O  N  E  N
// ----------------------------------------------------------------------------
// einzelnes Item in die Item-Drop-Tabelle übernehmen un d prüfen, ob es in
// einer Drop-Template-Gruppe definiert ist
// ----------------------------------------------------------------------------
function addItemToItemTab($line)
{
    global $tabitems, $cntitems, $dropTpl, $itemTpl;
        
    $aktdrop = explode("\t",$line."\t\t\t\t");
    
    // kein Prozentsatz vorhanden, dann ignorieren
    if (trim($aktdrop[4]) == "")
        return;
            
    $found = false;
    $group = $dropTpl->checkItemInTemplate($aktdrop[0]);
    $domax = count($tabitems);
    
    for ($i=0;$i<$domax;$i++)
    {
        // wenn Item oder Gruppe vorhanden, dann ignorieren
        if ($aktdrop[0] == $tabitems[$i]['item'] || $group == $tabitems[$i]['group'])
        {
            $found = true;
            $i     = $domax;
        }
    }
    
    // wenn Item noch nicht vorhanden, dann einfügen
    if ($found == false)
    {        
        if ($group != "")
        {
            $tabgroup = $dropTpl->getAllGroupItemsAsTab($group);
            $domax    = count($tabgroup);
            
            for ($i=0;$i<$domax;$i++)
            {
                $tabitems[$cntitems]['sort']  = $tabgroup[$i]['sort'].$group;
                $tabitems[$cntitems]['group'] = $group;
                $tabitems[$cntitems]['templ'] = "J";
                $tabitems[$cntitems]['item']  = $tabgroup[$i]['item'];
                $tabitems[$cntitems]['proz']  = $tabgroup[$i]['proz']; 
                $tabitems[$cntitems]['name']  = $tabgroup[$i]['name'];
                $tabitems[$cntitems]['amin']  = "1";
                $tabitems[$cntitems]['amax']  = "1";
                $tabitems[$cntitems]['doit']  = "J";

                $cntitems++;    
            }
        }
        else
        {
        /*  abgelöst durch die TtemTemplates
            if ($aktdrop[0] == "182400001")
            {
                $group = "KINAH";
                $tabitems[$cntitems]['amin']  = "200";
                $tabitems[$cntitems]['amax']  = "900";
            }
            else
            {            
                switch (substr($aktdrop[0],0,3))
                {
                    case "152": $group = "FLUX_COMMON";      break;
                    case "167": $group = "MANASTONE_COMMON"; break;
                    case "169": $group = "POWER_SHARDS";     break;
                    case "182": $group = "OTHER";            break;
                    default   : $group = "GROUP_".substr($aktdrop[0],0,3);  break;
                }
                
                $tabitems[$cntitems]['amin']  = 1;
                $tabitems[$cntitems]['amax']  = 1;
            }
        */        
            $group    = $itemTpl->getItemGroup($aktdrop[0]);
            
            $tabitems[$cntitems]['sort']  = substr($aktdrop[0],0,3).$group;
            $tabitems[$cntitems]['group'] = $group;
            $tabitems[$cntitems]['templ'] = "N";
            $tabitems[$cntitems]['item']  = $aktdrop[0];
            $tabitems[$cntitems]['proz']  = $aktdrop[4]; 
            $tabitems[$cntitems]['name']  = $itemTpl->getItemName($aktdrop[0]);
            $tabitems[$cntitems]['amin']  = "1";
            $tabitems[$cntitems]['amax']  = "1";
            $tabitems[$cntitems]['doit']  = "J";

            $cntitems++;    
        }        
    }
}
// ----------------------------------------------------------------------------
//
//                                 M  A  I  N
//
// ----------------------------------------------------------------------------
// Übergabe-Parameter (GET) aufbereiten
// ----------------------------------------------------------------------------
$drops =  isset($_GET['drops']) ? $_GET['drops'] : "";
$npcid =  isset($_GET['npcid']) ? $_GET['npcid'] : "000000";
$npctx =  isset($_GET['npctx']) ? $_GET['npctx'] : "???";
$itext =  isset($_GET['itext']) ? $_GET['itext'] : "N";
// ----------------------------------------------------------------------------
// globale Definitionen
// ----------------------------------------------------------------------------

putHtmlHead("$selfname - $infoname","Drop-Definitionen generieren");

// ----------------------------------------------------------------------------
// Start der Verarbeitung
// ----------------------------------------------------------------------------
logStart();
$starttime = microtime(true);

// Fehler bei der Initialiserung?
if ($dropTpl->isError())
    echo $dropTpl->getErrorText();
    
if ($drops == "")
   echo "Ohne die notwendigen Drop-Vorgaben kann nichts generiert werden";
else
{   		    
    // sicherheitshalber manuelles Splitten der Eingaben, da die Seite teilweise 
    // Zeilenende beim Cut/Paste mitliefert, wo es nicht hin gehört
    $tabdrops  = array();
    $tabitems  = array();
    $cntitems  = 0;    
    
    $temp = $drops."\n";
    $cnt  = 0;
    
    while (stripos($temp,"\n") !== false)
    {            
        $text = trim(substr($temp,0,stripos($temp,"\n")));
        $temp = substr($temp,stripos($temp,"\n") + 1);
        
        if (!is_numeric(substr($text,0,9)))
        {
            $tabdrops[$cnt - 1] .= "\t".$text;
        }
        else
        {
            $tabdrops[$cnt]  = trim($text);
            $cnt++;
        }
    }
    
    sort($tabdrops);
    $domax = count($tabdrops);
    
    for ($i=0;$i<$domax;$i++)
    {
        addItemToItemTab($tabdrops[$i]);
    }
    
    sort($tabitems);
    
    $filename  = formFileName("../outputs/drop_output_adb/tempout_drop_$npcid.xml");
    $hdlout    = openOutputFile($filename);
    
    echo "<span style='color:orange;font-size:16px;'>Definitionen (f&uuml;r ".count($tabitems)." Items) befinden sich in der Datei: <a href='$filename' target='_blank'>$filename</a><br><br>";
    echo "Aus der nachfolgenden Text-Box (anklicken) kann aber auch mit STRG-A und STRG-C der Inhalt kopiert werden!</span><br><br>";
    
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
    fwrite($hdlout,'<npc_drops xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="npc_drops.xsd">'."\n");
    fwrite($hdlout,'    <!-- '.$npctx.' -->'."\n");
    fwrite($hdlout,'    <npc_drop npc_id="'.$npcid.'">'."\n");
    
    $oldgroup   = "";
    $amounts    = "";
    $domax      = count($tabitems); 
    flush();
     
    for ($i=0;$i<$domax;$i++)
    {    
        if ($tabitems[$i]['doit'] == "J")
        {        
            if ($oldgroup != $tabitems[$i]['group'] || $tabitems[$i]['item'] == "182400001")
            {
                if ($oldgroup != "")
                    fwrite($hdlout,'        </drop_group>'."\n");
                
                $oldgroup = $tabitems[$i]['group'];
                
                fwrite($hdlout,'        <drop_group name="'.$dropTpl->getGroupName($oldgroup).'" use_category="true" race="PC_ALL">'."\n");
            }
            
            if ($itext != "N")
                $komm = ' name="'.trim($tabitems[$i]['name']).'" />';
            else
                $komm = " />";
                      
            $item    = '            <drop item_id="'.trim($tabitems[$i]['item']).'" chance="'.trim($tabitems[$i]['proz'].'"');
            $amounts = ' min_amount="'.$tabitems[$i]['amin'].'" max_amount="'.$tabitems[$i]['amax'].'" no_reduce="false" eachmember="false"';  
            fwrite($hdlout,$item.str_pad("",52 - strlen($item)," ").$amounts.$komm."\n");
        }
        else
            echo "\n<br>ignoriere wegen doit=J Item: ".$tabitems[$i]['item'];
    } 
    if ($oldgroup != "")
        fwrite($hdlout,'        </drop_group>'."\n");
    else
        fwrite($hdlout,"        <!--  es wurden alle Items ignoriert (vermutlich ohne %-Angabe!  -->\n");
        
    fwrite($hdlout,'    </npc_drop>'."\n");
    fwrite($hdlout,'</npc_drops>');
    fclose($hdlout);
    
    $gentext = file_get_contents($filename);
    echo "\n<br><textarea name='text' rows='20' cols='96'>$gentext</textarea><br><br>";    
}			
logSubHead("<center><a href='javascript:history.back()'>zur&uuml;ck</a></center>");

logStop($starttime,true);
	
putHtmlFoot();
?>