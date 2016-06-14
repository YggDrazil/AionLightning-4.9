<html>
<head>
  <title>
    HotspotTeleporter - Erzeugen hotspot_teleporter.xml"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
include("../includes/inc_globals.php");

getConfData();

$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen Hotspot-Teleporter-Datei</div>
  <div class="hinweis" id="hinw">
  Erzeugen der hotspot_teleporter.xml-Datei.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genHotspotTeleporter.php" target="_self">
 <br>
 <table width="700px">
   <colgroup>
     <col style="width:200px">
     <col style="width:500px">
   </colgroup>
   <tr><td colspan=2>&nbsp;</td></tr>
<?php   
// ----------------------------------------------------------------------------
//
//                       H I L F S F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Ausgabezeile formatieren
// ----------------------------------------------------------------------------
function rnd3($wert)
{
    return round($wert,3);
}

function getWorldNameId($name)
{
    global $tabWorlds;

    $key = strtoupper($name);
    
    if (isset($tabWorlds[$key]))
        return $tabWorlds[$key];
    else
        return "???";
}        
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// ermitteln der Client-World-Namen-Ids
// ----------------------------------------------------------------------------
function scanClientWorldNameIds()
{
	global $pathdata, $tabWorlds;
    	
    $fileext = formFileName($pathdata."\\World\WorldId.xml");
    $fileext = convFileToUtf8($fileext);
    
	logHead("Scanne die WorldIds aus dem Client-Extrakt");
    $cntles   = 0;
    $cntworld = 0;
        
    logLine("Eingabedatei",$fileext);
    
    $hdlext = openInputFile($fileext);
    $id     = "";
    $name   = "";  
    
    while (!feof($hdlext))
    {	
        $line = trim(fgets($hdlext));
        $cntles++; 
                
        if (stripos($line,"<data") !== false)
        {
            $id   = getKeyValue("id",$line); 
            $name = substr($line,stripos($line,">") + 1);
            $name = strtoupper(substr($name,0,stripos($name,"<")));
            $cntworld++;
            
            $tabWorlds[$name] = $id;
        }
    }	
    fclose($hdlext);      
    unlink($fileext);
    
	logLine("Anzahl Zeilen gelesen",$cntles);
    logLine("Anzahl Worlds gefunden",$cntworld);
}
// ----------------------------------------------------------------------------
// HotspotTeleporter-Datei ausgeben
// ----------------------------------------------------------------------------
function generHotspotTeleporterFile()
{
    global $pathdata;
    
    $fileu16 = formFileName($pathdata."\\World\\client_zonemap_hotspot.xml");
    $fileout = "../outputs/parse_output/hotspot_teleporter.xml";
    
    $fileext = convFileToUtf8($fileu16);
    logHead("Generierung der Datei");
    logLine("Eingabedatei UTF16",$fileu16);
    logLine("Eingabedatei UTF8",$fileext);
    logLine("Ausgabedatei",$fileout);
    
    $cntles = 0;
    $cntout = 0;
    
    $hdlout = openOutputFile($fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
    fwrite($hdlout,'<hotspot_teleport xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="hotspot_teleporter.xsd">'."\n");
    $cntout += 2;
    
    $lines = file($fileext);
    $domax = count($lines);
        
    $id   = $name = $posw = $race = $levl = "";
    $posx = $posy = $posz = $posd = $base = $dist = 0;
    
    for ($l=0;$l<$domax;$l++)
    {
        $line = rtrim($lines[$l]);
        $cntles++;
        
        if (stripos($line,"<?xml") === false
        &&  stripos($line,"<path_group>") === false)
        {     
            // Start Hotspot
            if     (stripos($line,"<id>")       !== false) $id   = getXmlValue("id",$line);
            elseif (stripos($line,"<name>")     !== false) $name = getXmlValue("name",$line);
            elseif (stripos($line,"<x>")        !== false) $posx = getXmlValue("x",$line);
            elseif (stripos($line,"<y>")        !== false) $posy = getXmlValue("y",$line);
            elseif (stripos($line,"<z>")        !== false) $posz = getXmlValue("z",$line);
            elseif (stripos($line,"<dir>")      !== false) $posd = getXmlValue("dir",$line);
            elseif (stripos($line,"<world>")    !== false) $posw = getXmlValue("world",$line);
            elseif (stripos($line,"<race>")     !== false) $race = getXmlValue("race",$line);
            elseif (stripos($line,"<required_base_gold>")      !== false) $base = getXmlValue("required_base_gold",$line);
            elseif (stripos($line,"<required_distance_gold>")  !== false) $dist = getXmlValue("required_distance_gold",$line);
            elseif (stripos($line,"<recommend_level>")         !== false) $levl = getXmlValue("recommend_level",$line);
            elseif (stripos($line,"</client_zonemap_hotspot>") !== false)
            {
                $wid   = getWorldNameId($posw);
                $xrace = "PC_ALL";
                
                switch(strtoupper($race))
                {
                    case "LIGHT": $xrace = "ELYOS";     break;
                    case "DARK" : $xrace = "ASMODIANS"; break;
                    default     : $xrace = "PC_ALL";    break;
                }
                
                fwrite($hdlout,'    <hotspot_template id="'.$id.'" name="'.strtoupper($name).'" mapId="'.$wid.'" '.
                               'posX="'.$posx.'" posY="'.$posy.'" posZ="'.$posz.'" heading="'.$posd.'" '.
                               'race="'.$xrace.'" kinah="'.$base.'" kinah_dis="'.$dist.'" level="'.$levl.'"/>'."\n");
                $cntout++;
                
                $id   = $name = $posw = $race = $levl = "";
                $posx = $posy = $posz = $posd = $base = $dist = 0;
            }
        }
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</hotspot_teleport>");
    $cntout++;
    
    fclose($hdlout);
    
    logLine("Zeilen Eingabedatei",$domax);
    logLine("Zeilen verarbeitet ",$cntles);
    logLine("Zeilen ausgegeben  ",$cntout);
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------

$tabWorlds = array();
$starttime = microtime(true);

echo '
   <tr>
     <td colspan=2>
       <center>
       <br><br>
       <input type="submit" name="submit" value="Generierung starten">
       </center>
       <br>
     </td>
   </tr>
   <tr>
     <td colspan=2>';    

logStart();

if ($submit == "J")
{   
    if ($pathdata == "")
    {
        logLine("ACHTUNG","die Pfade sind anzugeben");
    }
    else
    {
        scanClientWorldNameIds();
        generHotspotTeleporterFile();
        
        cleanPathUtf8Files();
    }
}    
logStop($starttime,true,true);

echo '
      </td>
    </tr>
  </table>';
?>
</form>
</body>
</html>