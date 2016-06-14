<html>
<head>
  <title>
    Ride - Erzeugen ride.xml"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
include("../includes/inc_globals.php");

getConfData();

if (!file_exists("../outputs/parse_output/ride"))
    mkdir("../outputs/parse_output/ride");

$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen Ride-Datei</div>
  <div class="hinweis" id="hinw">
    Erzeugen der ride.xml-Datei.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genRide.php" target="_self">
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
function rndX($wert,$scale)
{
    $ret = round($wert,$scale);
    
    if (stripos($ret,".") === false) $ret .= ".".str_pad("0",$scale);
    
    return trim($ret);
}
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Ride-Datei ausgeben
// ----------------------------------------------------------------------------
function generRideFile()
{
    global $pathdata;
    
    $fileu16 = formFileName($pathdata."\\rides\\rides.xml");  
    $fileext = convFileToUtf8($fileu16);
    $fileout = "../outputs/parse_output/ride/ride.xml";  
    
    logHead("Generierung der Datei");
    logLine("Eingabedatei UTF16",$fileu16);
    logLine("Eingabedatei UTF8",$fileext);
    logLine("Ausgabedatei",$fileout);
    
    $cntles = 0;
    $cntout = 0;
    
    $hdlout = openOutputFile($fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
    fwrite($hdlout,"<rides>\n");
    $cntout += 2;
    
    $lines = file($fileext);
    $domax = count($lines);
    
    $id = $type = $move = $fly = $canspr = $sprint = $start = $cost = $front = $side = $upper = $alti = "";
    
    for ($l=0;$l<$domax;$l++)
    {
        $line = rtrim($lines[$l]);
        $cntles++;
              
        if (stripos($line,"<?xml") === false
        &&  stripos($line,"<client_ride_data>") === false)
        {            
            // Start Ride
            if     (stripos($line,"<id>")                !== false) $id     = getXmlValue("id",$line);
            elseif (stripos($line,"<ride_type>")         !== false) $type   = getXmlValue("ride_type",$line);
            elseif (stripos($line,"<move_speed>")        !== false) $move   = getXmlValue("move_speed",$line);
            elseif (stripos($line,"<fly_speed>")         !== false) $fly    = getXmlValue("fly_speed",$line);
            elseif (stripos($line,"<can_sprint>")        !== false) $canspr = getXmlValue("can_sprint",$line);
            elseif (stripos($line,"<sprint_speed>")      !== false) $sprint = getXmlValue("sprint_speed",$line);
            elseif (stripos($line,"<start_fp>")          !== false) $start  = getXmlValue("start_fp",$line);
            elseif (stripos($line,"<cost_fp>")           !== false) $cost   = getXmlValue("cost_fp",$line);
            elseif (stripos($line,"<front>")             !== false) $front  = getXmlValue("front",$line);
            elseif (stripos($line,"<side>")              !== false) $side   = getXmlValue("side",$line);
            elseif (stripos($line,"<upper>")             !== false) $upper  = getXmlValue("upper",$line);
            elseif (stripos($line,"<altitude>")          !== false) $alti   = getXmlValue("altitude",$line);
            elseif (stripos($line,"</client_ride_data>") !== false) 
            {
                if ($canspr != "1")
                    $outspr = "";
                else
                    $outspr = ' sprint_speed="'.rndX($sprint,1).'"';
                    
                fwrite($hdlout,'    <ride_info id="'.$id.'" type="'.$type.'" move_speed="'.rndX($move,1).
                               '" fly_speed="'.rndX($fly,1).'"'.$outspr.' start_fp="'.
                               $start.'" cost_fp="'.$cost.'">'."\n");
                fwrite($hdlout,'        <bounds front="'.rndX($front,3).'" side="'.rndX($side,3).'" upper="'.
                               rndX($upper,3).'" altitude="'.rndX($alti,6).'"/>'."\n");
                fwrite($hdlout,'    </ride_info>'."\n");
                $cntout += 3;
    
                $id = $type = $move = $fly = $canspr = $sprint = $start = $cost = $front = $side = $upper = $alti = "";
            }
        }
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</rides>");
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
        generRideFile();
        
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