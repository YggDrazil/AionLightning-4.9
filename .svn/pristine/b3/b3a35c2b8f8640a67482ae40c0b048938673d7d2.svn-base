<?PHP

include("../includes/inc_globals.php");
include("includes/item_template_inc.php");
include("classes/item_template_class.php");

$selfname = basename(__FILE__);
$infoname = "Erzeugen PHP-Include für DropTemplate";

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
// DROP-Templates
// ----------------------------------------------------------------------------
function scanInfoDropTemplate()
{
	global $filesvn,$cntLes,$cntItm,$tabDrop,$group,$tabItemTemplates;
	
	$tabFields = array("item_id","chance");
				  	
	logHead("Scanne die Eingabedatei");
	    
	if (!$hdlsvn = openInputFile($filesvn))
	{
		echo "<br>Datei $filename kann nicht ge&ouml;ffnet werden";
		return;
	}
    
    flush();
    
    $cnt = 0;
    $itemTpl   = new ItemTemplateClass($tabItemTemplates); 
    
	while (!feof($hdlsvn))
	{	
		$line = trim(fgets($hdlsvn));
		$cntLes++;
		
		// Drop-Group-Zeile?
		if (stripos($line,"<drop_group ") !== false)
		{
            $group = substr($line,stripos($line," name=") + 7);
            $group = substr($group,0,stripos($group,'"')); 
        }
        elseif (stripos($line,"<drop ") !== false)
        {    
            // Item-Drop-Zeile?        
			$tabItem = getTabFields($tabFields,$line,false);
		
			// in Tabelle Speichern
			
            $tabDrop[$cnt]['id']   = $tabItem[0]['value'];
            $tabDrop[$cnt]['proz'] = $tabItem[1]['value'];
            $tabDrop[$cnt]['name'] = $itemTpl->getItemName($tabItem[0]['value']);
            
            $cnt++;
		}
	}	    
    
    sort($tabDrop);
    $cntItm = count($tabDrop);
    
    unset($itemTpl);
    
	logLine("Anzahl gelesener Zeilen",$cntLes);
    logLine("Anzahl gefundene Items" ,$cntItm);
}
// ----------------------------------------------------------------------------
function generDropTemplate()
{
    global $group, $tabDrop,$filesvn;
    
    logHead("Generierung");
    
    flush();
    
    $sortid = substr($tabDrop[0]['id'],0,3);
    $fileout   = "../outputs/drop_output_gener/g".$sortid."_".strtolower(substr(basename($filesvn),0,-4)).".php";
    
    $starttime = microtime(true);
    $leer      = str_pad("",24," ");
    $strich    = str_pad("",80,"-"); 
    
    $hdlout    = openOutputFile($fileout);
    
    fwrite($hdlout,$strich."\n");
    fwrite($hdlout,"// generiert am/um ".date("d.m.Y H.i")." aus der Drop-Generator-Oberfläche\n");
    fwrite($hdlout,"// Bitte die nachfolgenden Zeilen in das PHP-Include für die Drop-Templates einfügen\n");
    fwrite($hdlout,"// Bitte NICHT VERGESSEN, die notwendigen Anpassungen für die Gruppe vorzunehmen\n");
    fwrite($hdlout,$strich."\n\n");

    
    $max = count($tabDrop) - 1;
    
    fwrite($hdlout,$leer."//\n");
    fwrite($hdlout,$leer."//         ".substr($sortid,0,1)."  ".substr($sortid,1,1)."  ".substr($sortid,2,1)."\n");
    fwrite($hdlout,$leer."//\n");
    fwrite($hdlout,$leer."// generiert aus ".basename($filesvn)."\n");
    fwrite($hdlout,$leer.'array("'.$sortid.'","'.$group.'","'.$group.'",'."\n");
    fwrite($hdlout,$leer."  array (\n");
    
    for ($i=0;$i<($max);$i++)
    {
        fwrite($hdlout,$leer.'    array("'.$tabDrop[$i]['id'].'","'.$tabDrop[$i]['proz'].'","'.$tabDrop[$i]['name'].'"),'."\n"); 
    }
    
    $i = $max;
    
    fwrite($hdlout,$leer.'    array("'.$tabDrop[$i]['id'].'","'.$tabDrop[$i]['proz'].'","'.$tabDrop[$i]['name'].'")'."\n"); 
               
    fwrite($hdlout,$leer."  )\n");
    fwrite($hdlout,$leer."),");
    fclose($hdlout);
    
    logLine("Anzahl Verarbeitete Items",$max + 1);
    logLine("Drop-Gruppe",$group);
    logLine("Ausgabedatei Drop-Include",$fileout);
}
// ----------------------------------------------------------------------------
//
//                                 M  A  I  N
//
// ----------------------------------------------------------------------------
// Übergabe-Parameter (GET) aufbereiten
// ----------------------------------------------------------------------------

$filesvn  = isset($_GET['ifile'])   ? $_GET['ifile']   : "";

// ----------------------------------------------------------------------------
// globale Definitionen
// ----------------------------------------------------------------------------

$cntLes   = 0;
$cntItm   = 0;
$group    = "";
$tabDrop  = array();

$lastline = "";        // für verzögertes Schreiben
				    
putHtmlHead("$selfname - $infoname","Drop-Template parsen und PHP-Include erzeugen");

// ----------------------------------------------------------------------------
// Start der Verarbeitung
// ----------------------------------------------------------------------------
logStart("Script: ".$selfname."<br>".$infoname);
	
logHead("Vorgaben");
logLine("Eingabedatei",$filesvn);

if ($filesvn != ""  &&  file_exists($filesvn))
{
    $starttime = microtime(true);
        
    scanInfoDropTemplate();
    generDropTemplate();
    
    logStop($starttime,true);

    echo "    <br><br><a href='index_gen_drop.php' target='_self'><input type='button' value='zur&uuml;ck'></a><br><br>";
}
else
{
    $starttime = microtime(true);
    logStop($starttime,false);
    
    if ($pathsvn == "")
        echo "<br><br><span style='font-size:14px;color:red'>Es muss der korrekte Root-Pfad zum SVN angegeben werden</span><br>";
    else
        echo "<br><br><span style='font-size:14px;color:red'>in dem angegebenen Pfad kann Datei nicht gefunden werden</span><br>";
        
    echo "          <br><br><a href='index_gen_drop.php' target='_self'><input type='button' value='zur&uuml;ck'></a><br><br>";
}
putHtmlFoot();
?>