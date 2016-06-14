<html>
<head>
  <title>
    Robot - Erzeugen robot.xml"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
include("../includes/inc_globals.php");

getConfData();

if (!file_exists("../outputs/parse_output/robot"))
    mkdir("../outputs/parse_output/robot");

$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen Robot-Datei</div>
  <div class="hinweis" id="hinw">
    Erzeugen der robot.xml-Datei.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genRobot.php" target="_self">
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
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Robot-Datei ausgeben
// ----------------------------------------------------------------------------
function generRobotFile()
{
    global $pathdata;
    
    $fileu16 = formFileName($pathdata."\\robot\\robot.xml");
    $fileout = "../outputs/parse_output/robot/robot.xml";
    
    $fileext = convFileToUtf8($fileu16);
    logHead("Generierung der Datei");
    logLine("Eingabedatei UTF16",$fileu16);
    logLine("Eingabedatei UTF8",$fileext);
    logLine("Ausgabedatei",$fileout);
    
    $cntles = 0;
    $cntout = 0;
    
    $hdlout = openOutputFile($fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
    fwrite($hdlout,'<robots xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="robot.xsd">'."\n");
    $cntout += 2;
    
    $lines = file($fileext);
    $domax = count($lines);
        
    $id = $name = $front = $side = $upper = "";
    
    for ($l=0;$l<$domax;$l++)
    {
        $line = rtrim($lines[$l]);
        $cntles++;
        
        if (stripos($line,"<?xml") === false
        &&  stripos($line,"client_ride_data") === false)
        {     
            // Start Robot
            if     (stripos($line,"<id>")     !== false) $id    = getXmlValue("id",$line);
            elseif (stripos($line,"<name>")   !== false) $name  = getXmlValue("name",$line);
            elseif (stripos($line,"<front>")  !== false) $front = getXmlValue("front",$line);
            elseif (stripos($line,"<side>")   !== false) $side  = getXmlValue("side",$line);
            elseif (stripos($line,"<upper>")  !== false) $upper = getXmlValue("upper",$line);
            elseif (stripos($line,"</robot>") !== false)
            {
                fwrite($hdlout,'    <robot_info id="'.$id.'" name="'.$name.'">'."\n");
                fwrite($hdlout,'        <bound front="'.rnd3($front).'" side="'.rnd3($side).'" upper="'.rnd3($upper).'"/>'."\n");
                fwrite($hdlout,'    </robot_info>'."\n");
                $cntout += 3;
                
                $id = $name = $front = $side = $upper = "";
            }
        }
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</robots>");
    $cntout++;
    
    fclose($hdlout);
    
    logLine("Zeilen Eingabedatei",$domax);
    logLine("Zeilen verarbeitet ",$cntles);
    logLine("Zeilen ausgegeben  ",$cntout);
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------

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
        generRobotFile();
        
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