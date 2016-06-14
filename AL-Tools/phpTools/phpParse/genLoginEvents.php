<html>
<head>
  <title>
    LoginEvents - Erzeugen login_events.xml"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
include("../includes/inc_globals.php");

getConfData();

if (!file_exists("../outputs/parse_output/events_config"))
    mkdir("../outputs/parse_output/events_config");

$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen LoginEvents-Datei</div>
  <div class="hinweis" id="hinw">
    Erzeugen der login_events.xml-Datei.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genLoginEvents.php" target="_self">
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
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// LoginEvents-Datei ausgeben
// ----------------------------------------------------------------------------
function generLoginEventsFile()
{
    global $pathdata;
    
    $fileu16 = formFileName($pathdata."\\Items\\client_login_event.xml");
    $fileout = "../outputs/parse_output/events_config/login_events.xml";
    
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
    fwrite($hdlout,'<login_events xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="login_events.xsd">'."\n");
    $cntout += 2;
    
    $lines = file($fileext);
    $domax = count($lines);
        
    $id = $name = $activ = $Start = $end = $type = $anum = $item = $inum = $iexp = "";
    
    for ($l=0;$l<$domax;$l++)
    {
        $line = rtrim($lines[$l]);
        $cntles++;
        
        if (stripos($line,"<?xml") === false
        &&  stripos($line,"client_ride_data") === false)
        {  
            // Start LoginEvents
            if     (stripos($line,"<id>")                      !== false) $id    = getXmlValue("id",$line);
            elseif (stripos($line,"<name>")                    !== false) $name  = getXmlValue("name",$line);
            elseif (stripos($line,"<active>")                  !== false) $activ = getXmlValue("active",$line);
            elseif (stripos($line,"<period_start>")            !== false) $start = getXmlValue("period_start",$line);
            elseif (stripos($line,"<period_end>")              !== false) $end   = getXmlValue("period_end",$line);
            elseif (stripos($line,"<attend_type>")             !== false) $type  = getXmlValue("attend_type",$line);
            elseif (stripos($line,"<attend_num>")              !== false) $anum  = getXmlValue("attend_num",$line);
            elseif (stripos($line,"<reward_item>")             !== false) $item  = getXmlValue("reward_item",$line);
            elseif (stripos($line,"<reward_item_num>")         !== false) $inum  = getXmlValue("reward_item_num",$line);
            elseif (stripos($line,"<reward_item_expire_time>") !== false) $iexp  = getXmlValue("reward_item_expire_time",$line);
            elseif (stripos($line,"</client_login_event>") !== false)
            {
                $itemid = getClientItemId($item);
                
                //die koreanische Angabe für "JAHRESTAG" (= ec a3 bc eb 85 84) in "??" umsetzen 
                if (stripos($name,"\xEC") !== false)
                {
                    $pos  = stripos($name,"\xEC");
                    $name = substr($name,0,$pos)."??".substr($name,$pos + 6);
                    
                    logLine("<font color=red>Korea-Text JAHRESTAG","in 'name' zu ID=$id durch '??' ersetzt");
                }
                // $tart/$end:  Blank in "T" umsetzen
                $start = str_replace(" ","T",$start);
                $end   = str_replace(" ","T",$end);
                // kein Expire, dann "0"
                $iexp  = $iexp == "" ? "0" : $iexp;
                
                fwrite($hdlout,'    <login_event id="'.$id.'" name="'.$name.'" active="'.$activ.'" period_start="'.$start.'"'."\n");
                fwrite($hdlout,'                 period_end="'.$end.'" attend_type="'.strtoupper($type).'" attend_num="'.$anum.
                               '" reward_item="'.$itemid.'"'."\n");
                fwrite($hdlout,'                 reward_item_num="'.$inum.'" reward_item_expire="'.$iexp.'"/>'."\n");
                $cntout += 3;
                
                $id = $name = $activ = $start = $end = $type = $anum = $item = $inum = $iexp = "";
            }
        }
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</login_events>");
    $cntout++;
    
    fclose($hdlout);
    
    logLine("Zeilen Eingabedatei",$domax);
    logLine("Zeilen verarbeitet ",$cntles);
    logLine("Zeilen ausgegeben  ",$cntout);
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------

include("includes/auto_inc_item_infos.php");
include("includes/inc_getautonameids.php");

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
        generLoginEventsFile();
        
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