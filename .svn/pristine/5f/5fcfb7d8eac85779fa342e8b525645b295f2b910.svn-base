<html>
<head>
  <title>
    FlyPath - Erzeugen flypath_template.xml"
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
  <div class="aktion">Erzeugen FlyPath-Template-Datei</div>
  <div class="hinweis" id="hinw">
  Erzeugen der flypath_template.xml-Datei.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genFlyPath.php" target="_self">
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
// FlyPath-Datei ausgeben
// ----------------------------------------------------------------------------
function generFlyPathFile()
{
    global $pathdata;
    
    $fileu16 = formFileName($pathdata."\\FlightPath\\fly_path.xml");
    $fileout = "../outputs/parse_output/flypath_template.xml";
    
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
    fwrite($hdlout,'<flypath_template xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="flypath_template.xsd">'."\n");
    $cntout += 2;
    
    $lines = file($fileext);
    $domax = count($lines);
        
    $id  = $time = $typ = "";
    $pos = array();
    
    for ($l=0;$l<$domax;$l++)
    {
        $line = rtrim($lines[$l]);
        $cntles++;
        
        if (stripos($line,"<?xml") === false
        &&  stripos($line,"<path_group>") === false)
        {     
            // Start FlyPath
            if     (stripos($line,"<group_id>") !== false) $id   = getXmlValue("group_id",$line);
            elseif (stripos($line,"<start>")    !== false) $typ  = 0;
            elseif (stripos($line,"<end>")      !== false) $typ  = 1;
            elseif (stripos($line,"<x>")        !== false) $pos[$typ]['x'] = getXmlValue("x",$line);
            elseif (stripos($line,"<y>")        !== false) $pos[$typ]['y'] = getXmlValue("y",$line);
            elseif (stripos($line,"<z>")        !== false) $pos[$typ]['z'] = getXmlValue("z",$line);
            elseif (stripos($line,"<world>")    !== false) $pos[$typ]['w'] = getXmlValue("world",$line);
            elseif (stripos($line,"<fly_time>") !== false) $time = getXmlValue("fly_time",$line);
            elseif (stripos($line,"</path_group>") !== false)
            {
                $pos[0]['wid'] = getWorldNameId($pos[0]['w']);
                $pos[1]['wid'] = getWorldNameId($pos[1]['w']);
                
                fwrite($hdlout,'    <flypath_location id="'.$id.'" '.
                               'sx="'.$pos[0]['x'].'" sy="'.$pos[0]['y'].'" sz="'.$pos[0]['z'].'" sworld="'.$pos[0]['wid'].'" '.
                               'ex="'.$pos[1]['x'].'" ey="'.$pos[1]['y'].'" ez="'.$pos[1]['z'].'" eworld="'.$pos[1]['wid'].'" '.
                               'time="'.$time.'"/>'."\n");
                $cntout++;
                
                $id  = $time = $typ = "";
                $pos = array();
            }
        }
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</flypath_template>");
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
        generFlyPathFile();
        
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