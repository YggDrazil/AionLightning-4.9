<html>
<head>
  <title>
    Teleporter - Erzeugen npc_teleporter.xml"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
include("../includes/inc_globals.php");
include("includes/inc_getautonameids.php");
include("includes/auto_inc_npc_infos.php");

getConfData();

if (!file_exists("../outputs/parse_output"))
    mkdir("../outputs/parse_output");

$submit   = isset($_GET['submit'])   ? "J" : "N";
$withcom  = isset($_GET['withcom'])  ? "J" : "N";
?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen Npc-Teleporter-xml-Datei</div>
  <div class="hinweis" id="hinw">
    Erzeugen der npc_teleporter.xml-Datei.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genTeleporter.php" target="_self">
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
// alle relevanten Teleporter-NPCs selektieren
// ----------------------------------------------------------------------------
function makeTabNpcs()
{
    global $pathdata, $tabnpcs;
    
    $tabFiles = array( "client_npcs_npc.xml",
                       "client_npcs_monster.xml"
                     );
    $maxFiles = count($tabFiles);
    $cntnpc   = 0;
    
    logSubHead("Scannen der relevanten Teleporter-NPCs");
    
    for ($f=0;$f<$maxFiles;$f++)
    {
        $fileext = formFileName($pathdata."\\Npcs\\".$tabFiles[$f]);
        $fileext = convFileToUtf8($fileext);
        
        $hdlext  = openInputFile($fileext);
        
        if (!$hdlext)
        {
            logLine("Fehler openInputFile",$fileext);
            return;
        }
        
        logLine("- Eingabedatei",$fileext);
        
        $id     = "";
        $air    = "";
        $name   = "";
        
        flush();
        
        while (!feof($hdlext))
        {
            $line = rtrim(fgets($hdlext));
            
            if     (stripos($line,"<id>")            !== false)
                $id   = getXmlValue("id",$line);
            elseif (stripos($line,"<name>") !== false)
                $name = strtoupper(getXmlValue("name",$line));
            elseif (stripos($line,"<airlines_name>") !== false)
                $air  = strtoupper(getXmlValue("airlines_name",$line));
            elseif (stripos($line,"</npc_client>")   !== false)
            {    
                // ACHTUNG: der NPC 802461 ist im Client fehlerhaft definiert
                //          und wird daher ausgeschlossen!                
                if ($id != "" && $air != "")
                {                    
                    $ntab = getNpcIdNameTab($name);
                    
                    if (isset($ntab['nname']))
                        $xnam = $ntab['nname'];
                    else
                        $xnam = "?";
                        
                    if (isset($tabnpcs[$air]))
                    {
                        $tabnpcs[$air]['id']   .= " ".$id;
                        $tabnpcs[$air]['name'] .= ", $id = ".$xnam;
                    }
                    else
                    {
                        $tabnpcs[$air]['id']    = $id;
                        $tabnpcs[$air]['name']  = "$id = ".$xnam;
                    }    
                        
                    $cntnpc++;
                }
                $id = $air = $name = "";
            }
        }
        fclose($hdlext);
        
        unlink($fileext);
        
        // SONDERVERARBEITUNG
        //
        // einige Definitionen für Teleporter fehlen im Client und werden daher
        // über die nachfolgende Tabelle ergänzt
        $tabzus = array(
                    //     Client-Airline-Name         Client-NPC-Name
                    array("LC1_AIRPORT_ZONE_ENTRANCE","LC1_LC2_TELEPORT"),  // 730265
                    array("LC2_AIRPORT_ZONE_ENTRANCE","LC2_LC1_TELEPORT"),  // 730266
                    array("DC1_AIRPORT_ZONE_ENTRANCE","DC1_DC2_TELEPORT"),  // 730268
                    array("DC2_AIRPORT_ZONE_ENTRANCE","DC2_DC1_TELEPORT")   // 730269
                  );
        $maxzus = count($tabzus);
        
        for ($z=0;$z<$maxzus;$z++)
        {       
            $ntab = getNpcIdNameTab($tabzus[$z][1]);
            
            if (isset($ntab['nname']))
                $xnam = $ntab['nname'];
            else
                $xnam = "?";
                
            $tabnpcs[$tabzus[$z][0]]['id']   = $ntab['npcid'];
            $tabnpcs[$tabzus[$z][0]]['name'] = $xnam;
        }
    }
    
    logLine("- Anzahl Teleporter-NPCs",$cntnpc);
    logLine("- Anzahl Tele-Locations",count($tabnpcs));
    logLine("- Client-Fehler-Korrekturen",$maxzus);
}
// ----------------------------------------------------------------------------
// alle LocIDs aus der client_airports.xml selektieren
// ----------------------------------------------------------------------------
function makeTabAirs()
{
    global $pathdata, $tabairs;
    
    logSubHead("Scannen der Airports");
    
    $fileext = formFileName($pathdata."\\FlightPath\\client_airports.xml");
    $fileext = convFileToUtf8($fileext);
    $hdlext  = openInputFile($fileext);
    
    if (!$hdlext)
    {
        logLine("Fehler openInputFile",$fileext);
        return;
    }
    
    logLine("- Eingabedatei",$fileext);
    
    $id    = "";
    $desc  = "";
    
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        
        if     (stripos($line,"<id>")              !== false)
            $id   = getXmlValue("id",$line);
        elseif (stripos($line,"name")              !== false)
            $desc = strtoupper(getXmlValue("name",$line));
        elseif (stripos($line,"</client_airport>") !== false)
        {            
            if ($id  != "" && $desc != "")
                $tabairs[$desc] = $id;
            
            $id = $desc = "";
        }
    }
    fclose($hdlext);
    unlink($fileext);
    
    logLine("- Anzahl Airports gefunden",count($tabairs));
}
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// ----------------------------------------------------------------------------
// Teleporter-Datei ausgeben
//
// Es werden verschiedene Client-Dateien hierzu gescannt, die allerdings alle
// ähnlich aufgebaut sind, sodass diese innerhalb dieser einen Funktion abge-
// arbeitet werden können. Die Unterschiede werden in der Tabelle $tabclient
// vorgegeben!
// ----------------------------------------------------------------------------
function generTeleporterFile()
{
    global $pathdata, $tabnpcs, $tabairs, $withcom;
    
    
    logSubHead("Erzeugen der Ausgabedatei");
    
    $fileext = formFileName($pathdata."\\FlightPath\\client_airline.xml");
    $fileext = convFileToUtf8($fileext);
    $hdlext  = openInputFile($fileext);
    
    if (!$hdlext)
    {
        logLine("Fehler OpenInputFile",$fileext);
        return;
    }
    // vorsichtshalber die beiden Tabellen resetten
    reset($tabnpcs);
    reset($tabairs);
    
    $fileout = "../outputs/parse_output/npc_teleporter.xml";
    $hdlout  = openOutputFile($fileout);
    $cntout  = 0;
    $cntles  = 0;
    
    logLine("- Eingabedatei",$fileext);
    logLine("- Ausgabedatei",$fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="utf-8"?>'."\n");
    fwrite($hdlout,'<npc_teleporter xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">'."\n");
    fwrite($hdlout,'<!-- generated for AION 4.9 at '.date("d.m.Y H:i").' -->'."\n");
    $cntout += 3;
    
    flush();
    
    $doair = 0;
    
    $id = $name = $npcs = $aport = $fee = $pvfee = $quest = $group = "";
    
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        $cntles++;
        
        if     (stripos($line,"<id>") !== false)
        {
            $id = getXmlValue("id",$line);
        }
        elseif (stripos($line,"<name>") !== false)
        {
            $name = strtoupper(getXmlValue("name",$line));
            $doair= 1;
        }
        elseif (stripos($line,"<airport_name>") !== false)
            $aport = strtoupper(getXmlValue("airport_name",$line));
        elseif (stripos($line,"<fee>") !== false)
            $fee   = getXmlValue("fee",$line);
        elseif (stripos($line,"<pvpon_fee>") !== false)
            $pvfee = getXmlValue("pvpon_fee",$line);
        elseif (stripos($line,"<required_quest>") !== false)
            $quest = getXmlValue("required_quest",$line);
        elseif (stripos($line,"<flight_path_group_id>") !== false)
            $group = getXmlValue("flight_path_group_id",$line);
        elseif (stripos($line,"</data>") !== false)
        {
            // nur wenn zu diesem teleport auch ein NPC existiert, dann ausgeben!
            if (isset($tabnpcs[$name]))
            {
                if ($doair == 1)
                {
                    $npcs = (isset($tabnpcs[$name]['id'])) ? $tabnpcs[$name]['id'] : "? $name ?";
                    
                    if ($withcom == "J")
                    {
                        fwrite($hdlout,'    <!-- '.$tabnpcs[$name]['name'].' -->'."\n");
                        $cntout++;
                    }
                    fwrite($hdlout,'    <teleporter_template npc_ids="'.$npcs.'" teleportId="'.$id.'">'."\n");
                    fwrite($hdlout,'        <locations>'."\n");
                    $cntout += 2;
                    
                    $doair = 2;
                }
                
                $tpid  = "";
                $ttyp  = "REGULAR";
                
                if ($group != "0" && $group != "")
                {
                    $ttyp = "FLIGHT";
                    $tpid = ' teleportid="'.(($group * 1000) + 1).'"';
                }
                $locid = (isset($tabairs[$aport])) ? $tabairs[$aport] : "? $aport ?";
                $lout  = '            <telelocation loc_id="'.$locid.'"'.$tpid.' price="'.$fee.'" '.
                         'pricePvp="'.$pvfee.'"';
                         
                if ($quest != "" && $quest != "0")
                    $lout .= ' required_quest="'.$quest.'"';
                
                $lout .= ' type="'.$ttyp.'" />'; 
                    
                fwrite($hdlout,$lout."\n");
                $cntout++;
            }
            $aport = $fee = $pvfee = $quest = $group = "";
        }
        elseif (stripos($line,"</airline_list>") !== false)
        {
            if ($doair == 2)
            {
                fwrite($hdlout,'        </locations>'."\n");
                fwrite($hdlout,'    </teleporter_template>'."\n");
                $cntout += 2;
                $doair = 0;
            }
        }
    }
    
    fclose($hdlext);
    
    // Nachspann ausgeben
    fwrite($hdlout,'</npc_teleporter>');
    fclose($hdlout);
    $cntout++;
    
    logLine("- Anzahl Zeilen ausgegeben",$cntout);    
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------

$tabnpcs  = array();
$tabairs  = array();

$starttime = microtime(true);

echo '
   <tr>
     <td colspan=2>
       <center>
       <input type="checkbox" name="withcom" value="'.$withcom.'"> mit NPC-Namen als XML-Kommentar
       </center>
       <br><br>
     </td>
   </tr>
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
        logHead("Erzeugen der Datei npc_teleporter.xml");;
        
        makeTabNpcs();
        makeTabAirs();
        
        generTeleporterFile();
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