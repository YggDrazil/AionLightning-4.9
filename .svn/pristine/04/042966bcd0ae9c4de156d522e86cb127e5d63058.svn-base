<?PHP

include("../includes/inc_globals.php");

$selfname = basename(__FILE__);
$infoname = "Erzeugen PHP-Includes für Item-Templates";

// ----------------------------------------------------------------------------
//
//                         D R O P - G R U P P E N
//
// ----------------------------------------------------------------------------
// Drop-Gruppe merken
// ----------------------------------------------------------------------------
function putDropGroupToTable($group)
{
    global $tabDGrp;
    
    if (isset($tabDGrp[$group]))
        $tabDGrp[$group]['ianz']++;
    else
    {
        $tabDGrp[$group]['name'] = $group;
        $tabDGrp[$group]['ianz'] = 1;
    }        
}
// ----------------------------------------------------------------------------
// die bei der Generierung erzeugten Drop-Gruppen als Include ausgeben
// ----------------------------------------------------------------------------
function writeDropGroupFile()
{
    global $tabDGrp, $filegrp, $leer, $cntGrp;
    
    ksort($tabDGrp);
    
    $hdlout = openOutputFile($filegrp);
    
    // Ausgabedatei: Vorspann ausgeben
    fwrite($hdlout,"<?PHP\n");
    
    fwrite($hdlout,"// ----------------------------------------------------------------------------\n");
    fwrite($hdlout,"// Tabelle mit den generierten Drop-Gruppen\n");
    fwrite($hdlout,"//\n");
    fwrite($hdlout,"// Generiert von genItemTab.php am/um ".date("d.m.Y H:i")."\n");
    fwrite($hdlout,"// ----------------------------------------------------------------------------\n");
    fwrite($hdlout,"\n\$tabItemDropGroups = array(\n");
    
    $lastline = "";
    $anzGrp   = 0;
    
    while (list($key,) = each($tabDGrp))
    {
        $cntGrp++;
        
        if ($lastline != "")
            fwrite($hdlout,$lastline.",\n");
            
        $lastline = $leer.'"'.$key.'" => array( "name" => "'.$tabDGrp[$key]['name'].'", "cntitems" => "'.$tabDGrp[$key]['ianz'].'")';
    }
    fwrite($hdlout,$lastline."\n");
    fwrite($hdlout,$leer.");");
    
    fclose($hdlout);
}
// ----------------------------------------------------------------------------
// zusätzliche Levelangabe erweitern
// ----------------------------------------------------------------------------
function getLevelZusatz($level)
{
    $zusatz = "";
    $ilevel = (int)$level;
    
    if ($ilevel < 10)
        $zusatz = "";
    elseif ($ilevel >  9  && $ilevel < 20) 
        $zusatz = "_LVL10";
    elseif ($ilevel > 19  && $ilevel < 30)
        $zusatz = "_LVL20";
    elseif ($ilevel > 29  && $ilevel < 40)
        $zusatz = "_LVL30";
    elseif ($ilevel > 39  && $ilevel < 50)
        $zusatz = "_LVL40";
    elseif ($ilevel > 49  && $ilevel < 60)
        $zusatz = "_LVL50";
    elseif ($ilevel > 59  && $ilevel <= 64)
        $zusatz = "_LVL60";
    elseif ($ilevel > 64  && $ilevel <= 65)
        $zusatz = "_LVL65";
    elseif ($ilevel > 65)
        $zusatz = "_LVL".$level;
        
    return $zusatz;
}
// ----------------------------------------------------------------------------
// Ermitteln Gruppenname aus: itemId
// ----------------------------------------------------------------------------
function getGroupFromItemId($tabItem)
{	    
    global $cntName0;
    
    $group ="";
    
    if     ($tabItem[0]['value']             == "182400001")  $group = "KINAH";
    elseif (substr($tabItem[0]['value'],0,3) == "170")        $group = "HOUSING";
    
    if ($group != "")
        $cntName0++;
        
    return $group;
}
// ----------------------------------------------------------------------------
// Ermitteln Gruppenname aus: equipment_type
// ----------------------------------------------------------------------------
function getGroupFromEquipType($tabItem)
{	    
    global $cntName1;
    
    $group ="";
  
    if ($tabItem[5]['value'] !== "")
    {
        // Unterscheidung nach armor_type
        if ($tabItem[6]['value'] != "")
        {
            switch ($tabItem[6]['value'])
            {
                case "CHAIN":
                case "CLOTHES":
                case "HELMET":
                case "JACKET":
                case "LEATHER":
                case "PLATE":
                case "ROBE":
                        $group = "ARMOR";
                        break;
                case "NECKLACE":
                        $group = "ACCESSORY";
                        break;
                case "SHIELD":
                case "SWORD":
                        $group = "WEAPON";
                        break;
                default:
                        $group = $tabItem[6]['value'];
            }
        }
        else
        {
            $group = $tabItem[5]['value'];
        }
        
        // Besonderheiten berücksichtigen bei category
        if ($tabItem[2]['value'] == "RINGS" 
        ||  $tabItem[2]['value'] == "NECKLACE" 
        ||  $tabItem[2]['value'] == "BELT")
            $group = "ACCESSORY";
        
        if ($tabItem[2]['value'] == "SHARD")
            $group = "POWER_SHARD";
        
        // Besonderheiten prüfen/setzen
        if     (stripos($tabItem[1]['value'],"Test") !== false) $group = "SYSTEM_TEST_".$group;
        elseif (stripos($tabItem[1]['value'],"NPC")  !== false) $group = "SYSTEM_NPC_".$group;
            
        if ($tabItem[5]['value'] == $group)
            $cntName1++;
    }
        
    return $group;
}
// ----------------------------------------------------------------------------
// Ermitteln Gruppenname aus: category
// ----------------------------------------------------------------------------
function getGroupFromCategory($tabItem)
{	    
    global $cntName2;
    
    $group = "";
        
    if ($tabItem[2]['value'] !== "NONE"  && $tabItem[2]['value'] !== "")
    {
        
        $group = $tabItem[2]['value'];
        
        // Besonderheiten berücksichtigen von category
        switch ($group)
        {
            // WEAPON
            case "BOW":
            case "CHAIN":
            case "SHIELD":
            case "SWORD":
                    $group = "WEAPON";
                    break;
            // ARMOR
            case "CLOTHES":
            case "JACKET":
            case "GLOVES":
            case "SHOULDERS":
            case "PANTS":
            case "SHOES":
            case "HELMET":
            case "LEATHER":
            case "PLATE":
            case "ROBE":
                    $group = "ARMOR";
                    break;
            // ACCESSORY
            case "EARRINGS":
            case "NECKLACE":
            case "RINGS":
                    $group = "ACCESSORY";
                    break;
            case "BALIC_EMOTION":
            case "BALIC_MATERIAL":
                    $group = "BALIC_MATERIAL";
                    break;
            case "RAWHIDE":
                    $group = "FLUX";
                    break;
            case "DROP_MATERIAL":
                    $group = "JUNK";
                    break;
            case "STENCHANTMENT":
                    $group = "SYSTEM_TEST_ENCHANTMENT";
                    break;
            case "SHARD":
                    $group = "POWER_SHARD";
                    break;
            default:
                    break;
        }
    }
    
    if ($group != "")
        $cntName2++;
        
    return $group;
}
// ----------------------------------------------------------------------------
// Ermitteln Gruppenname aus: name (mit besonderen Inhalten)
// ----------------------------------------------------------------------------
function getGroupFromNamePart($tabItem)
{	    
    global $cntName3, $cntOther;
    
    $group = "";
    
    if     (stripos($tabItem[1]['value'],"Test")     !== false)      $group = "SYSTEM_TEST";
    elseif (stripos($tabItem[1]['value'],"Design:")  !== false)      $group = "DESIGN";
    elseif (stripos($tabItem[1]['value'],"Recipe:")  !== false)      $group = "RECIPE";
    elseif (stripos($tabItem[1]['value'],"Potion")   !== false)      $group = "POTION";
    elseif (stripos($tabItem[1]['value'],"Elixier")  !== false)      $group = "ELIXIER";
    elseif (stripos($tabItem[1]['value'],"Teleport") !== false)      $group = "TELEPORT_SCROLL";
    elseif (stripos($tabItem[1]['value'],"Summoning")!== false)      $group = "SUMMONING_SCROLL";
    elseif (stripos($tabItem[1]['value'],"Scroll")   !== false)      $group = "RETURN_SCROLL";
    elseif (stripos($tabItem[1]['value'],"ing Stone")!== false)      $group = "SUMMONING_STONE";
    elseif (stripos($tabItem[1]['value'],"Enhancement Stone") !== false) $group = "ENHANCEMENT_STONE";
    elseif (stripos($tabItem[1]['value'],"Stone")    !== false)      $group = "STONE";
    elseif (stripos($tabItem[1]['value'],"Card")     !== false)      $group = "CARD";
    elseif (stripos($tabItem[1]['value'],"Ticket")   !== false)      $group = "TICKET";    
    elseif (stripos($tabItem[1]['value'],"Boost")    !== false)      $group = "BOOST";
    elseif (stripos($tabItem[1]['value'],"Title")    !== false)      $group = "TITLE_CARD";    
    elseif (stripos($tabItem[1]['value'],"Amulet")   !== false)      $group = "AMULET";    
    elseif (stripos($tabItem[1]['value'],"Luck")     !== false)      $group = "PRESENT";
    elseif (stripos($tabItem[1]['value'],"Letter")   !== false)      $group = "LETTER";
    elseif (stripos($tabItem[1]['value'],"Tool")     !== false)      $group = "Tool";
    
    elseif (stripos($tabItem[1]['value'],"Juice")    !== false)      $group = "FOOD";
    elseif (stripos($tabItem[1]['value'],"Fillet")   !== false)      $group = "FOOD";
    elseif (stripos($tabItem[1]['value'],"Cocktail") !== false)      $group = "FOOD";
    elseif (stripos($tabItem[1]['value'],"Ale")      !== false)      $group = "FOOD";
    elseif (stripos($tabItem[1]['value'],"Candy")    !== false)      $group = "FOOD";
    elseif (stripos($tabItem[1]['value'],"Crab")     !== false)      $group = "FOOD";
    elseif (stripos($tabItem[1]['value'],"Snack")    !== false)      $group = "FOOD";
    elseif (stripos($tabItem[1]['value'],"Jelly")    !== false)      $group = "FOOD";
    elseif (stripos($tabItem[1]['value'],"Tart")     !== false)      $group = "FOOD";
    elseif (stripos($tabItem[1]['value'],"Cookie")   !== false)      $group = "FOOD";
    elseif (stripos($tabItem[1]['value'],"Snack")    !== false)      $group = "FOOD";
    elseif (stripos($tabItem[1]['value'],"Food")     !== false)      $group = "FOOD";
    elseif (stripos($tabItem[1]['value'],"Cracker")  !== false)      $group = "FOOD";
    elseif (stripos($tabItem[1]['value'],"Dumpling") !== false)      $group = "FOOD";
    
    elseif (stripos($tabItem[1]['value'],"Arrow")    !== false)      $group = "JUNK";
    elseif (stripos($tabItem[1]['value'],"Spear")    !== false)      $group = "JUNK";
    
    
    elseif (stripos($tabItem[1]['value'],"Dye")      !== false)      $group = "DYE";
    elseif (stripos($tabItem[1]['value'],"Paint")    !== false)      $group = "DYE";
        
    else   
    {
        $group = "OTHER";
        $cntOther++;
    }
    
    if ($group != "" && $group != "OTHER")
        $cntName3++;
        
    return $group;
}
// ----------------------------------------------------------------------------
// Drop-Gruppenname ermitteln
// ----------------------------------------------------------------------------
function getDropGroupName($tabItem)
{
    $group = "";
        
    for ($g=0;$g<4;$g++)
    {
        // Solange kein Gruppenname gefunden ist
        if ($group == "")
        {
            switch ($g)
            {
                case 0:  $group = getGroupFromItemId($tabItem);     break;
                case 1:  $group = getGroupFromEquipType($tabItem);  break;
                case 2:  $group = getGroupFromCategory($tabItem);   break;
                default: $group = getGroupFromNamePart($tabItem);   break;
            }
        }
        if ($group != "")  $g = 6;  // Schleifenende setzen
    }
    
    // quality ergänzen, aber nicht bei:
    // - KINAH
    // - SYSTEM_NPC
    // - SYSTEM_TEST
    if ($group != "KINAH"
    &&  stripos($group,"SYSTEM_") === false)
        $group .= "_".$tabItem[3]['value'];            // quality anhängen  
        
    // level ergänzen, aber nicht bei:
    // - KINAH
    // - SYSTEM
    // - ENCHANTMENT 
    if ($group != "KINAH"
    &&  stripos($group,"SYSTEM_")     === false
    &&  stripos($group,"ENCHANTMENT") === false)
    {   
        $group .= getLevelZusatz($tabItem[4]['value']);// evtl. Level-Angabe erweitern
    }
    
    $group  = strtoupper(str_replace(" ","_",$group)); // Blanks = Unterstrich und Grossbuchstaben
    $group  = str_replace("__","_",$group);            // doppelte Unterstriche eliminieren  
    $group  = str_replace("'","",$group);  
    $group  = ltrim($group,"_");
    
    return $group;
}
// ----------------------------------------------------------------------------
// Zeile in Tabelle einfügen
// ----------------------------------------------------------------------------
function makePhpArrayLine($tabItem,$tabFields)
{
	global $hdlout,$lastline,$leer;
    
    // Indexe TabItem: 0=id,1=name,2=category,3=quality 4=level,5=equipment_type,6=armor_type
    if (!$tabItem)
        return;
        
    if ($lastline != "")
    {
        fwrite($hdlout,$lastline.",\n");
        $lastline = "";
    }
    
    $arkey  = "'".$tabItem[0]['value']."'";
    $oline  = $leer.'"'.$arkey.'" => array(';
    
	for ($f=0;$f<5;$f++)  // 5 + 6 auslassen
	{
        $oline  .= '"'.$tabItem[$f]['fname'].'" => "'.$tabItem[$f]['value'].'"';
        
        if ($f <= 4)
            $oline .= ", ";            
	}
    
    $group = getDropGroupName($tabItem);
    
    $oline .= '"group" => "'.$group.'")';
    
    putDropGroupToTable($group);
    
	unset($tabItem);
    
    $lastline    = $oline;
}
// ----------------------------------------------------------------------------
//
//             S C A N - S U B - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Selektion der in $tabFields angegebenen Felder aus der Zeile $line
// ----------------------------------------------------------------------------
function getTabFields($tabFields,$line)
{
	$tabRet   = array();
    $cntRet   = 0;	
	
	$rest     = str_replace("<item_template","",$line);
	$domax    = count($tabFields);
    
	for ($f=0;$f<$domax;$f++)
	{
		$tabRet[$cntRet]['fname'] = $tabFields[$f];
		
		if (stripos($rest," ".$tabFields[$f]."=") !== false)
		{            
            // Feld und Wert aus Zeile herausnehmen
		    $vonpos = stripos($rest," ".$tabFields[$f]."=");
			$temp   = substr($rest,$vonpos + (3 + strlen($tabFields[$f])));
            $temp   = substr($temp,0,stripos($temp,'"'));
	
			$tabRet[$cntRet]['value'] = trim($temp);
		}
		else
			$tabRet[$cntRet]['value'] = "";
		
		// $tabRet[$cntRet]['value'] = str_replace("'","\'",$tabRet[$cntRet]['value']);		
		$cntRet++;
	}

	return ( $tabRet );		
}
// ----------------------------------------------------------------------------
//
//             I N F O - S C A N
// 
// ----------------------------------------------------------------------------
// ITEM-Templates
// ----------------------------------------------------------------------------
function scanInfoItemTemplates()
{
	global $filesvn,$fileout,$hdlout,$lastline,$cntLes,$cntItm,$cntGrp,$tabDGrp;
	global $cntName0,$cntName1,$cntName2,$cntName3,$cntOther;
	
	$tabFields = array("id","name","category","quality","level","equipment_type","armor_type");
				  	
	logHead("Scanne die Eingabedatei");
	    
	if (!$hdlsvn = openInputFile($filesvn))
	{
		echo "<br>Datei $filename kann nicht ge&ouml;ffnet werden";
		return;
	}
	
	if (!$hdlout = openOutputFile($fileout))
	{
		echo "<br>Datei $filename kann nicht ge&ouml;ffnet werden";
		return;
	}
	
    flush();
    
    // Ausgabedatei: Vorspann ausgeben
    fwrite($hdlout,"<?PHP\n");
    
    fwrite($hdlout,"// ----------------------------------------------------------------------------\n");
    fwrite($hdlout,"// Tabelle mit einigen Item-Template-Informationen\n");
    fwrite($hdlout,"//\n");
    fwrite($hdlout,"// Generiert von genItemTab.php am/um ".date("d.m.Y H:i")."\n");
    fwrite($hdlout,"// ----------------------------------------------------------------------------\n");
    fwrite($hdlout,"\n\$tabItemTemplates = array(\n");
    
	while (!feof($hdlsvn))
	{	
		$line = trim(fgets($hdlsvn));
		$cntLes++;
		
		// Item-Template-Zeile?
		if (stripos($line,"<item_template ") !== false)
		{
			$tabItem = getTabFields($tabFields,$line,false);
		
			// in Tabelle Speichern
			makePhpArrayLine($tabItem,$tabFields);
            
			$cntItm++;			
		}
	}	    
    
    // Ausgabedatei: Nachspann für ItemTemplateArray ausgeben
    fwrite($hdlout,$lastline."\n");
    fwrite($hdlout,"                   );");
    
    fclose($hdlsvn);
    fclose($hdlout);
	logLine("Anzahl Zeilen gelesen",$cntLes);
    logLine("Anzahl DropGroups erzeugt",count($tabDGrp));
    
    flush();
    
    // Ergänzen der generierten DropGroups
    writeDropGroupFile();
    
	logHead("Ergebnis");
	logLine("Anzahl generierter Item-Zeilen",$cntItm);
    logLine("Anzahl generierter DropGruppen",$cntGrp);
    
    logHead("Gruppenamen-Ermittlung");
    logLine("aus ItemId",$cntName0);
    logLine("aus equpiment_type",$cntName1);
    logLine("aus category",$cntName2);
    logLine("aus Item-Name-Teile",$cntName3);
    logLine("auf OTHER gesetzt",$cntOther);
}
// ----------------------------------------------------------------------------
// alte Datei sichern
// ----------------------------------------------------------------------------
function doFileBackup($oldfile,$logtext)
{
    $ret = "";
    
    $backfile = "data_backups/"."bak_".date("Ymd_His")."_".basename($oldfile);
    
    if (file_exists($oldfile))
    {
        $ret = $backfile;
        
        copy($oldfile, $backfile);
        
        logLine("- ".$logtext, $backfile);
    }   
    else
        logLine($logtext, "noch nicht vorhanden"); 
}
function makeFileBackup()
{
    global $fileout,$filegrp;
    
    if (!file_exists("data_backups"))
        mkdir("data_backups");
    
    logSubHead("Backup-Dateien");
        
    doFileBackup($fileout,"PHP-Include ItemTemplates");
    doFileBackup($filegrp,"PHP-Include ItemDropGroups");       
}
// ----------------------------------------------------------------------------
//
//                                 M  A  I  N
//
// ----------------------------------------------------------------------------
// Übergabe-Parameter (GET) aufbereiten
// ----------------------------------------------------------------------------

$pathsvn  = isset($_GET['pathsvn']) ? $_GET['pathsvn'] : "";

// ----------------------------------------------------------------------------
// globale Definitionen
// ----------------------------------------------------------------------------
$pathsub  = "\\trunk\\AL-Game\\data\\static_data\\items\\";
$filesvn  = formFileName($pathsvn.$pathsub."item_templates.xml"); 
$fileout  = "includes/item_template_inc.php";
$filegrp  = "includes/item_dropgroup_inc.php";

$cntLes   = 0;
$cntItm   = 0;
$cntGrp   = 0;
$cntName0 = 0;         // itemid
$cntName1 = 0;         // equipment_type
$cntName2 = 0;         // category
$cntName3 = 0;         // name_part
$cntOther = 0;         // auf OTHER gesetzt

$lastline = "";        // für verzögertes Schreiben
$leer     = str_pad("",21," ");
$tabDGrp  = array();
				    
putHtmlHead("$selfname - $infoname","Item-Templates parsen und PHP-Includes erzeugen");

// ----------------------------------------------------------------------------
// Start der Verarbeitung
// ----------------------------------------------------------------------------
logStart("Script: ".$selfname."<br>".$infoname);
	
logHead("Vorgaben");
logLine("Pfad zum SVN-Root",$pathsvn);
logHead("Abgeleitete Vorgaben");
logLine("Eingabedatei",$filesvn);
logSubHead("Ausgabedateien");
logLine("- PHP-Include ItemTemplates",$fileout);
logLine("- PHP-Include ItemDropGroups",$filegrp);

if ($pathsvn != ""  &&  file_exists($filesvn))
{
   /*
    // Pfad/Datei merken
    $hdlout = openOutputFile("saved_data/generSvnPath.txt");
    fwrite($hdlout,$pathsvn);
    fclose($hdlout);
   */
    makeFileBackup();

    $starttime = microtime(true);
        
    scanInfoItemTemplates();
    
    logStop($starttime,true);

    echo "<br><br><a href='index_genitm_test.php' target='_self'><input type='button' value='Ergebnis testen'></a><br><br>";
}
else
{
    $starttime = microtime(true);
    logStop($starttime,false);
    
    if ($pathsvn == "")
        echo "<br><br><span style='font-size:14px;color:red'>Es muss der korrekte Root-Pfad zum SVN angegeben werden</span><br>";
    else
        echo "<br><br><span style='font-size:14px;color:red'>in dem angegebenen Pfad kann die item_templates.xml nicht gefunden werden</span><br>";
        
    echo "          <br><br><a href='index_genitm_tmpl.php' target='_self'><input type='button' value='zur&uuml;ck'></a><br><br>";
}
putHtmlFoot();
?>