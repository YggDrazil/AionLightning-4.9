<html>
<head>
  <title>
    AbyssRaceBonus - Erzeugen abyss_race_bonus.xml"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
include("../includes/inc_globals.php");

getConfData();

if (!file_exists("../outputs/parse_output/abyss_race_bonus"))
    mkdir("../outputs/parse_output/abyss_race_bonus");

$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen Abyss-Race-Bonus-Datei</div>
  <div class="hinweis" id="hinw">
    Erzeugen der abyss_race_bonus.xml-Datei.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genAbyssRaceBonus.php" target="_self">
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
// ermitteln Name der Quest
// ----------------------------------------------------------------------------
function getName($desc)
{
    global $tabNames;
    
    $name = strtoupper( $desc );
    
    if (isset($tabNames[$name]))
        return $tabNames[$name]['body'];
    else
        return "???";
}
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Scannen der Client-Quest-/-Ui-Strings aus PacketSamurai
// ----------------------------------------------------------------------------
function scanClientNames()
{
    global $pathstring, $tabNames;
    
    LogHead("Scanne die Namen aus den PS-Client-Dateien");
        
    $tabfiles = array( "client_strings_quest.xml",
                       "client_strings_ui.xml"
                     );
    $maxfiles = count($tabfiles);

    for ($f=0;$f<$maxfiles;$f++)
    {  
        $filestr = formFileName($pathstring."\\".$tabfiles[$f]);
        $hdlstr  = openInputFile($filestr);
                
        if (!$hdlstr)
        {
            logLine("Fehler openInputFile",$filestr);
            return;
        }
        
        logSubHead("Scanne PS-Client-Strings");
        logLine("Eingabedatei",$filestr);
        $id     = "";
        $name   = "";
        $body   = "";
        $cntles = 0;
        $cntstr = 0;
        
        flush();
        
        while (!feof($hdlstr))
        {
            $line = rtrim(fgets($hdlstr));
            $cntles++;
            
            if     (stripos($line,"<id>")     !== false)
                $id   = getXmlValue("id",$line);
            elseif (stripos($line,"<name>")   !== false)
                $name = strtoupper(getXmlValue("name",$line));
            elseif ( stripos($line,"<body>")  !== false)
                $body = getXmlValue("body",$line);
            elseif (stripos($line,"</string") !== false)
            {   
                $tabNames[$name]['body'] = $body;
                $tabNames[$name]['id']   = $id;
                
                $id = $name = $body = "";
                $cntstr++;
            }
        }
        fclose($hdlstr);
        
        logLine("Anzahl Zeilen gelesen",$cntles);
        logLine("Anzahl Strings gefunden",$cntstr);
    }
}
// ----------------------------------------------------------------------------
// AbyssRaceBonus-Datei ausgeben
// ----------------------------------------------------------------------------
function generAbyssRaceBonusFile()
{
    global $pathdata;
    
    $fileu16 = formFileName($pathdata."\\PC\\abyss_race_bonuses.xml");  
    $fileext = convFileToUtf8($fileu16);
    $fileout = "../outputs/parse_output/abyss_race_bonus/abyss_race_bonus.xml";  
    
    logHead("Generierung der Datei");
    logLine("Eingabedatei UTF16",$fileu16);
    logLine("Eingabedatei UTF8",$fileext);
    logLine("Ausgabedatei",$fileout);
    
    $cntles = 0;
    $cntout = 0;
    
    $hdlout = openOutputFile($fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
    fwrite($hdlout,'<abyss_race_bonuses xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="abyss_race_bonus.xsd">'."\n");
    $cntout += 2;
    
    $lines = file($fileext);
    $domax = count($lines);
    
    $id = $desc = $race = $attr = $cond = $oname = $race = "";
    
    for ($l=0;$l<$domax;$l++)
    {
        $line = rtrim($lines[$l]);
        $cntles++;
              
        if (stripos($line,"<?xml") === false
        &&  stripos($line,"<client_ride_data>") === false)
        {            
            // Start AbyssRaceBonus
            if     (stripos($line,"<id>")                !== false) $id     = getXmlValue("id",$line);
            elseif (stripos($line,"<desc_name>")         !== false) $desc   = getXmlValue("desc_name",$line);
            elseif (stripos($line,"<race>")              !== false) $race   = getXmlValue("race",$line);
            elseif (stripos($line,"<bonus_attr>")        !== false) $attr   = getXmlValue("bonus_attr",$line);
            elseif (stripos($line,"<condition>")         !== false) $cond   = getXmlValue("condition",$line);
            elseif (stripos($line,"</client_abyss_race_bonus>") !== false) 
            {
                $orace = strtoupper($race);    
                
                if     ($orace == "LIGHT") $orace = "ELYOS";
                elseif ($orace == "DARK")  $orace = "ASMODIANS";
                else                       $orace = "PC_ALL";
                
                // Korrektur für Client-Vorgabe!
                if ($orace == "ASMODIANS" && stripos($desc,"_LIGHT_") !== false)
                    $desc = str_replace("_LIGHT_","_DARK_",strtoupper($desc));
                
                $oname = getName($desc);
                
                if (stripos($cond,"_") !== false)
                {
                    $val = substr($cond,-1,1);
                    $oname .= " ".$val;
                }
                
                if ($attr != "")
                {
                    $tab = explode(" ",$attr);
                    $tab[0] = getBonusAttrName($tab[0]);
                    $tab[1] = isset($tab[1]) ? ($tab[1] / 10) : 1;
                    
                    fwrite($hdlout,'    <abyss_race_bonus id="'.$id.'" name="'.$oname.'" race="'.$orace.'">'."\n");
                    fwrite($hdlout,'        <bonus stat="'.$tab[0].'" func="PERCENT" value="'.$tab[1].'"/>'."\n");
                    fwrite($hdlout,'    </abyss_race_bonus>'."\n");
                    $cntout += 3;
                }
                else
                {
                    fwrite($hdlout,'    <abyss_race_bonus id="'.$id.'" name="'.$oname.'" race="'.$orace.'"/>'."\n");
                    $cntout++;
                }
                
                $id = $desc = $race = $attr = $cond = $oname = $orace = "";
            }
        }
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</abyss_race_bonuses>");
    $cntout++;
    
    fclose($hdlout);
    
    logLine("Zeilen Eingabedatei",$domax);
    logLine("Zeilen verarbeitet ",$cntles);
    logLine("Zeilen ausgegeben  ",$cntout);
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------

include("includes/inc_bonusattrs.php");

$tabNames  = array();
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
        scanClientNames();
        generAbyssRaceBonusFile();
        
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