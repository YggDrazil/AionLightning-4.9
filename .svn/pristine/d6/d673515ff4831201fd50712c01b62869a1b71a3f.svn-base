<html>
<head>
  <title>
    WeatherTable - Erzeugen weather_table.xml"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
include("../includes/inc_globals.php");

getConfData();

if (!file_exists("../outputs/parse_output"))
    mkdir("../outputs/parse_output");

$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen Weather-Table-Datei</div>
  <div class="hinweis" id="hinw">
    Erzeugen der weather_table.xml-Datei.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genWeatherTable.php" target="_self">
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
// einen Eintrag in die Wetter-Tabelle hinzufügen
//
// Tabellen-Index-Aufbau:
// [world]                  WordlId
// [world]['cset']          Counter für die Wetterangaben
// [world]['czone']         Counter für die Zonenangaben
// {world]['set'][weather]  Angaben zum Wettereintrag
// [world]['szone'][zone]   Angaben zur Wetter-Zone
// [world]['zone'][zone]    Angaben zur Zone
// ----------------------------------------------------------------------------
function addWeatherToTab($world,$typ,$text)
{
    global $tabweather;
    
    if (!isset($tabweather[$world]))
    {
        $tabweather[$world]['cset']  = 0;
        $tabweather[$world]['czone'] = 0;
    }
    
    switch($typ)
    {
        case "set":
            $xzone = strtolower(getKeyValue("weather_zone_name",$text));
            $xname = strtoupper(getKeyValue("name",$text));
            $xrank = strtoupper(getKeyValue("att_ranking",$text));
            
            $tabweather[$world]['cset']++;
            
            $tabweather[$world]['set'][$xname]['zone'] = $xzone;
            $tabweather[$world]['set'][$xname]['rank'] = $xrank;             
            $tabweather[$world]['set'][$xname]['w_id'] = $tabweather[$world]['cset'];
            
            $tabweather[$world]['szone'][$xzone] = 1;
            break;
        case "zone":
            $xzone = strtolower(getKeyValue("name",$text));
            
            $tabweather[$world]['czone']++;
            
            $tabweather[$world]['zone'][$xzone] = $tabweather[$world]['czone'];
            
            // wenn kein Zoneneintrag beim Wetter hierzu vorliegt, dann einen
            // Dummy-Eintrag für die Wetterangaben zur Zone erzeugen
            if (!isset($tabweather[$world]['szone'][$xzone]))
            {
                $tabweather[$world]['set']['DFLT']['zone'] = $xzone;
                $tabweather[$world]['set']['DFLT']['rank'] = -1;
                $tabweather[$world]['set']['DFLT']['w_id'] = 0;
            }
            break;
    }
}
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// einzelne Mission-Datei scannen
// ----------------------------------------------------------------------------
function scanMissionFile($fileext,$world,$wname)
{    
    if (!file_exists($fileext))
    {
        // logLine("- kein MissionFile vorhanden",$fileext);
        return 0;
    }
    
    $hdlext = openInputFile($fileext);
        
    if (!$hdlext)
    {
        logLine("Fehler OpenInputFile",$fileext);
        return 0;
    }
        
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        
        if     (stripos($line,"<WeatherSetTable ") !== false) 
            addWeatherToTab($world,"set",$line);
        elseif (stripos($line,"<weather_zone ") !== false)
            addWeatherToTab($world,"zone",$line);
    }
    fclose($hdlext);
    
    return 1;
}
// ----------------------------------------------------------------------------
// Scannen der Client-Quest-/-Ui-Strings aus PacketSamurai
// ----------------------------------------------------------------------------
function scanAllMissionFiles()
{
    global $pathlevels, $tabweather, $tabWorldmaps;
    
    logHead("Scanne die Wetter-Angaben aus den Client-Mission-Dateien");
    logSubHead("Liste aller gefundenen Wetterangaben in den Mission-Dateien");
    
    $cntmiss = 0;
        
    flush();
    
    while (list($world,$val) = each($tabWorldmaps))
    {
        $wname   = $tabWorldmaps[$world]['offiname']; 
        $fileext = formFileName($pathlevels."\\".$wname."\\mission_mission0.xml");
        
        $cntmiss += scanMissionFile($fileext,$world,$wname);
    
        if (isset($tabweather[$world]))    
            logLine("- Wetterangaben gefunden",$world." ( $wname )");
    }    
    
    logSubHead("Ergebnis des Scans");
    logLine("- Anzahl Mission-Dateien",$cntmiss);
    logLine("- Anzahl Wetter-Angaben",count($tabweather));
}
// ----------------------------------------------------------------------------
// WeatherTable-Datei ausgeben
// ----------------------------------------------------------------------------
function generWeatherTableFile()
{
    global $pathdata, $tabweather;
    
    $fileout = "../outputs/parse_output/weather_table.xml";  
    
    logHead("Generierung der Datei");
    logLine("Ausgabedatei",$fileout);
        
    flush();
    
    reset($tabweather);
    
    $cntout = 0;
    $hdlout = openOutputFile($fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
    fwrite($hdlout,'<weather>'."\n");
    $cntout += 2;
    
    // für alle Welten
    while (list($wkey,$wval) = each($tabweather))
    {
        $cset  = $tabweather[$wkey]['cset'];
        $czone = $tabweather[$wkey]['czone'];
        $iset  = 0;
        $izone = 0;
        $ozone = "";
        
        // Angaben vorhanden?
        if ($cset > 0)
        {        
            fwrite($hdlout,'    <map id="'.$wkey.'" zone_count="'.$czone.'" weather_count="'.$cset.'">'."\n");
            $cntout++;
            
            // für alle Wetterangaben der aktuellen Welt
            while (list($skey,$sval) = each($tabweather[$wkey]['set']))
            {           
                // wenn die Zone nicht vorgegeben wurde, dann als Dummy (= 0) ausgeben
                if (!isset($tabweather[$wkey]['zone']))
                    $zone = 0;
                else
                    $zone = $tabweather[$wkey]['zone'][ $tabweather[$wkey]['set'][$skey]['zone'] ];
                    
                $rank = $tabweather[$wkey]['set'][$skey]['rank'];
                $w_id = $tabweather[$wkey]['set'][$skey]['w_id'];
                
                if ($skey == "DFLT")
                {
                    fwrite($hdlout,'        <table zone_id="'.$zone.'" rank="'.$rank.'" code="'.$w_id.'"/>'."\n");
                    $cntout++;
                }
                else
                {                        
                    $xtext = $skey;
                    $before = "";
                    $after  = "";
                    
                    if (stripos($xtext,"_BEFOREAFTER") !== false)
                    {
                        // es werden 2 Zeilen ausgegeben (einmal before, einmal after) !!!
                        $before = ' before="true"';
                        $after  = ' after="true"';
                        $xtext  = str_replace("_BEFOREAFTER","",$xtext);
                        
                        // Before-Zeile direkt hier ausgeben!
                        fwrite($hdlout,'        <table zone_id="'.$zone.'" rank="'.$rank.'" code="'.$w_id.'" name="'.$xtext.'"'.$before.'/>'."\n");
                        $cntout++;
                        
                        $before = "";
                        $rank   = 0;
                    }
                    // prüfen auf BEFORE-Angabe
                    elseif (stripos($xtext,"_BEFORE") !== false)
                    {
                        $before = ' before="true"';
                        $xtext  = str_replace("_BEFORE","",$xtext);
                    }
                    elseif (stripos($xtext,"BEFORE") !== false)
                    {
                        $before = ' before="true"';
                        $xtext  = str_replace("BEFORE","",$xtext);
                    }
                    // prüfen auf AFTER-Angabe
                    elseif (stripos($xtext,"_AFTER") !== false)
                    {
                        $before = ' after="true"';
                        $xtext  = str_replace("_AFTER","",$xtext);
                    }
                    elseif (stripos($xtext,"AFTER") !== false)
                    {
                        $before = ' after="true"';
                        $xtext  = str_replace("AFTER","",$xtext);
                    }
                    
                    fwrite($hdlout,'        <table zone_id="'.$zone.'" rank="'.$rank.'" code="'.$w_id.'" name="'.$xtext.'"'.$before.$after.'/>'."\n");
                    $cntout++;
                }
            }
            fwrite($hdlout,'    </map>'."\n");
            $cntout++;
        }
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</weather>");
    $cntout++;
    
    fclose($hdlout);
    
    logLine("Zeilen ausgegeben  ",$cntout);
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------
include("includes/inc_worldmaps.php");

$tabweather = array();
$starttime  = microtime(true);

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
    if ($pathlevels == "")
    {
        logLine("ACHTUNG","die Pfade sind anzugeben");
    }
    else
    {
        scanAllMissionFiles();
        generWeatherTableFile();
        
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