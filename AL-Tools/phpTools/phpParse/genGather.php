<html>
<head>
  <title>
    SpawnGenerator - Erzeugen Gebiets-Spawns f&uuml;r Gather"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
// ----------------------------------------------------------------------------
// ToDo:  - erweitern der Spawns um die jeweiligen Walker-Ids
//        - generieren der jeweiligen Walker-Routen aus den Client-Dateien
//        - erzeugen der beiden Includes (worldMaps/Npc_infos) überarbeiten
//
// Hint:  - eventuell die Z-Angabe aus den bestehenden Spawn-Files übernehmen
// ----------------------------------------------------------------------------
include("../includes/inc_globals.php");
include("includes/inc_worldmaps.php");

getConfData();

if (!file_exists("../outputs/spawn_output"))
    mkdir("../outputs/spawn_output");
if (!file_exists("../outputs/spawn_output/Gather"))
    mkdir("../outputs/spawn_output/Gather");
  
$welt     = isset($_GET['welt'])     ? $_GET['welt']     : "";
$scan     = isset($_GET['scan'])     ? $_GET['scan']     : "*";
$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen Gather-Spawn-Dateien</div>
  <div class="hinweis" id="hinw">
    Erzeugen Gather-Spawn-Dateien f&uuml;r das unten ausgew&auml;hlte Gebiet.<br><br>
    ACHTUNG: die Pfade werden der aktuellen Konfigurations-Datei entnommen.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte notwendige Informationen einf&uuml;gen</h1>
<form name="edit" method="GET" action="genGather.php" target="_self">
 <br>
 <table width="700px">
   <colgroup>
     <col style="width:200px">
     <col style="width:500px">
   </colgroup>
   <tr><td colspan=2>&nbsp;</td></tr>
   <tr>
     <td colspan="2">
       <center>
       <span style="font-size:14px;color:cyan;padding-right:49px;">Gebietsauswahl</span>
       <select name="welt" id="idwelt" style="width:385;"> 
<?PHP

while (list($key,$val) = each($tabWorldmaps))
{
    if ($tabWorldmaps[$key]['mapid'] == $welt)
        $selected = " selected";
    else
        $selected = "";
        
    $opt = "         <option value='".$tabWorldmaps[$key]['mapid']."'$selected>".$tabWorldmaps[$key]['mapid'].
           " - ".$tabWorldmaps[$key]['name']." (".
           $tabWorldmaps[$key]['offiname'].")</option>";
    echo "\n$opt";
}

echo ' 
       </select>
     </td>
   </tr>';
   
/*   Dateiauswahl macht hier keinen Sinn   
   <tr>
     <td colspan="2">
       <center>
       <span style="font-size:14px;color:cyan;padding-right:15px;">zu scannende Dateien</span>
       <select name="scan" id="idscan" style="width:385;">';    
   
$tabscan  = array( 
                  array("*","alle Dateien"),
                  array("M","nur Mission-Datei"),
                  array("S","nur SourceSphere-Datei"),
                  array("C","nur client_world-Datei")
                 );
$max      = count($tabscan);
$selected = "";

for ($s=0;$s<$max;$s++)
{
    if ($scan == $tabscan[$s][0])
        $selected = " selected";
    else
        $selected = "";
        
    echo '
         <option value="'.$tabscan[$s][0].'"'.$selected.'>'.$tabscan[$s][1].'</option>';
}
echo '
       </select>
     </td>
   </tr>';    
*/  
// ----------------------------------------------------------------------------
//
//                       H I L F S F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// NpcId aus der internen Tabelle ermitteln
// ----------------------------------------------------------------------------
function getNpcid($nameid)
{
    global $tabGatherInfos;
    
    $key = strtoupper($nameid);
    
    if (isset($tabGatherInfos[$key]))
        return $tabGatherInfos[$key]['npc_id'];
    else
    {
        if (substr($key,0,4) == "NPC_" && substr($key,strlen($key)-3,3) == "_SP")
        {
            $key = substr($key,4,stripos($key,"_SP") - 4);
            
            if (isset($tabGatherInfos[$key]))
                return $tabGatherInfos[$key]['npc_id'];
            else
                return "000000";
        }
        else
            return "000000";
    }
        return "000000";
}
// ----------------------------------------------------------------------------
// Npc-Name aus der internen Tabelle ermitteln
// ----------------------------------------------------------------------------
function getNpcName($nameid)
{
    global $tabGatherInfos;
    
    $key = strtoupper($nameid);
    
    if (isset($tabGatherInfos[$key]))
        return $tabGatherInfos[$key]['name'];
    else
    {
        if (substr($key,0,4) == "NPC_" && substr($key,strlen($key)-3,3) == "_SP")
        {
            $key = substr($key,4,stripos($key,"_SP") - 4);
            
            if (isset($tabGatherInfos[$key]))
                return $tabGatherInfos[$key]['name'];
            else
                return "";
        }
        else
            return "";
    }
}
// ----------------------------------------------------------------------------
//                                  T o D o
//
// muss von meiner MySql-Umgebung umgestellt werden auf die eigenständige
// Ermittlung der Informationen aus den Client-Dateien
// ----------------------------------------------------------------------------
/*
// ----------------------------------------------------------------------------
// erzeugen Include mit den WorldMap-Informationen
// ----------------------------------------------------------------------------
function checkWorldmapInclude()
{
    if (file_exists("includes/worldmaps_inc.php"))
        return;
        
    // ACHTUNG: NUR in meiner MySql-Umgebung möglich!
    $sql = new ClassMysql();
    $out = openOutputFile("includes/worldmaps_inc.php");
    
    if (!$linkid = $sql->connect("localhost","web","w3b100","al_server_info"))
    {
        logLine("ERROR MySql","Verbindung nicht erfolgreich");
        $err = true;
    }
    
    $leer = str_pad("",18," ");
    fwrite($out,"<?PHP\n");
    fwrite($out,"// ----------------------------------------------------------------------------\n");
    fwrite($out,"// Tabelle mit einigen World-Map-Informationen \n");
    fwrite($out,"// ----------------------------------------------------------------------------\n");
    fwrite($out,"\$tabWorldmaps = array(\n");
    
    $lastline = "";
    $bef      = "SELECT * FROM worldmaps WHERE versid=480 ORDER BY mapid";
    $res      = $sql->query($bef);
    $cntMap   = 0;
    
    while ($row = $sql->fetch_assoc($res))
    {
        $cntMap++;
        
        if ($lastline != "")
            fwrite($out,$leer.$lastline.",\n");
            
        $lastline = '"'."".$row['mapid']."".'" => array( "mapid" => "'.$row['mapid'].'", "name" => "'.$row['showname'].'", "offiname" => "'.$row['clientname'].'")';
    }
    
    fwrite($out,$leer.$lastline."\n");
    fwrite($out,str_pad("",16," ").");\n");
    fwrite($out,"?>");
    
    fclose($out);
    
    $sql->free_result($res);
    
    unset($sql);
    unset($res);
    
    logLine("Anzahl WorldMaps gefunden",$cntMap);
}
// ----------------------------------------------------------------------------
// erzeugen Include mit den Npc-Informationen
// ----------------------------------------------------------------------------
function checkNpcInfoInclude()
{
    if (file_exists("includes/npc_infos_inc.php"))
        return;
        
    // ACHTUNG: NUR in meiner MySql-Umgebung möglich!
    $sql = new ClassMysql();
    $out = openOutputFile("includes/npc_infos_inc.php");
    
    if (!$linkid = $sql->connect("localhost","web","w3b100","al_server_info"))
    {
        logLine("ERROR MySql","Verbindung nicht erfolgreich");
        $err = true;
    }
    
    $leer = str_pad("",17," ");
    fwrite($out,"<?PHP\n");
    fwrite($out,"// ----------------------------------------------------------------------------\n");
    fwrite($out,"// Tabelle mit einigen Npc-Informationen \n");
    fwrite($out,"// ----------------------------------------------------------------------------\n");
    fwrite($out,"\$tabGatherInfos = array(\n");
    
    $lastline = "";
    $bef      = "SELECT npc_id,name,name_desc FROM npc_templates WHERE vers=480 ORDER BY 1";
    $res      = $sql->query($bef);
    $cntNpc   = 0;
    
    while ($row = $sql->fetch_assoc($res))
    {
        $cntNpc++;
        
        if ($lastline != "")
            fwrite($out,$leer.$lastline.",\n");
            
        $lastline = '"'."".strtoupper($row['name_desc'])."".'" => array( "npc_id" => "'.$row['npc_id'].'", "name" => "'.$row['name'].'", "offiname" => "'.$row['name_desc'].'")';
    }
    
    fwrite($out,$leer.$lastline."\n");
    fwrite($out,str_pad("",15," ").");\n");
    fwrite($out,"?>");
    
    fclose($out);
    
    $sql->free_result($res);
    
    unset($sql);
    unset($res);
    
    logLine("Anzahl NpcInfos gefunden",$cntNpc);
}
*/
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// neuen NPC in die Spawn-Tabelle übernehmen
// ----------------------------------------------------------------------------
function addNpcToSpawnTable($npcid,$xpos,$ypos,$zpos,$name,$offi)
{   
    global $tabSpawn, $cntSpawn, $tabKeys;
    
    $key = $offi.intval($xpos);
    
    if (!isset($tabKeys[$key]))
    {
        $tabKeys[$key] = $key;
        
        $tabSpawn[$cntSpawn]['sort']  = $offi;
        $tabSpawn[$cntSpawn]['offi']  = $offi;
        $tabSpawn[$cntSpawn]['npcid'] = $npcid;
        $tabSpawn[$cntSpawn]['xpos']  = $xpos;
        $tabSpawn[$cntSpawn]['ypos']  = $ypos;
        $tabSpawn[$cntSpawn]['zpos']  = $zpos;
        $tabSpawn[$cntSpawn]['name']  = $name;
        
        $cntSpawn++;
        
        return 1;
    }
    
    return 0;
}
// ----------------------------------------------------------------------------
// Spawns aus den Extrakten /levels/mapname/mission_mission0.xml ermitteln
// ----------------------------------------------------------------------------
function getSpawnsFromMission0File()
{
    global $pathlevels, $welt, $tabWorldmaps;
        
    $filemission = formFileName($pathlevels."\\".$tabWorldmaps[$welt]['offiname']."\\mission_mission0.xml");
    
    logHead("Ermitteln Spawns aus Datei: mission_mission0.xml");
    logLine("Welt-Offi-Name",$tabWorldmaps[$welt]['offiname']);
    logLine("Eingabedatei",$filemission);
    
    flush();
    
    $anznpcs = 0;
    
    if (!file_exists($filemission))
    {
        logLine("","nicht gefunden");
        return;
    }
    
    $hdlin = openInputFile($filemission);
    
    while (!feof($hdlin))
    {
        // Suche:  <Object ... npc="Vatonia" Pos="2006.902,1511.1031,582.93817" ... />
        $line = trim(fgets($hdlin));
        if (stripos($line,"<object") !== false  
        &&  stripos($line,"npc=")    !== false
        &&  stripos($line,"Pos=")    !== false)
        {
            $offi  = substr($line,stripos($line," Name=") + 7);
            $offi  = substr($offi,0,stripos($offi,'"'));
            $name  = substr($line,stripos($line," npc=") + 6);
            $name  = substr($name,0,stripos($name,'"'));
            $pos   = substr($line,stripos($line," Pos=") + 6);
            $pos   = substr($pos,0,stripos($pos,'"'));
            $type  = substr($line,stripos($line," Type=") + 7);
            $type  = substr($type,0,stripos($type,'"'));
        
            $tpos  = split(",",$pos);

            if ($name != ""  &&  strtoupper($name) != "P1"  &&  
               ($type == "HSP"  ||  stripos($name,"source") !== false))
            {
                $anznpcs += addNpcToSpawnTable("000000",$tpos[0],$tpos[1],$tpos[2],$name,$offi);  
            }            
        }
    }
    fclose($hdlin);
    
    logLine("gefundene NPCs/Spawns",$anznpcs);
}
// ----------------------------------------------------------------------------
// Spawns aus der extrahierten Datei sourceshpere.csv ermitteln
// ----------------------------------------------------------------------------
function getSpawnsFromSourceSphere()
{
    global $pathdata, $welt, $tabWorldmaps;
    
    $filesphere = formFileName($pathdata."/World/source_sphere.csv");
    $anznpcs    = 0;
    $suchmap    = $tabWorldmaps[$welt]['offiname'];
    
    logHead("Ermitteln Spawns aus Datei: source_sphere.csv");
    logLine("Welt-Offi-Name",$tabWorldmaps[$welt]['offiname']);
    logLine("Eingabedatei",$filesphere);
    
    flush();
    
    if (!file_exists($filesphere))
    {
        logLine("","nicht gefunden");
        return;
    }
    
    $hdlin = openInputFile($filesphere);
    
    while (!feof($hdlin))
    {
        //        0            1   2   3 4      5      6      7   
        // Suche: 0c_bat_29_an,npc,lf2,0,403.65,220.86,285.00,67.13,,0,0,-1,1
        $line  = trim(fgets($hdlin));
        $tab   = split(",",$line);

        if (count($tab) > 7 /*&& $tab[1] == "npc"*/  && strtoupper($tab[2]) == $suchmap) // alle Infos enthalten
        {
            if (stripos($tab[0],"itemusearea") === false)
            {
                $anznpcs += addNpcToSpawnTable("000000",$tab[4],$tab[5],$tab[6],"",$tab[0]);
            }
        }
    }
    fclose($hdlin);
    
    logLine("gefundene NPCs/Spawns",$anznpcs);
}
// ----------------------------------------------------------------------------
// Spawns aus der extrahierten Datei client_world_x.xml ermitteln
// ----------------------------------------------------------------------------
function getSpawnsFromClientWorld()
{
    global $pathdata, $welt, $tabWorldmaps, $tabGatherInfos;
        
    $fileworld = formFileName($pathdata."\\World\\client_world_".$tabWorldmaps[$welt]['offiname'].".xml");
    $fileworld = convFileToUtf8($fileworld);
    $tabinfos  = array();
    
    logHead("Ermitteln Spawns aus Datei: ".basename($fileworld));
    logLine("Welt-Offi-Name",$tabWorldmaps[$welt]['offiname']);
    logLine("Eingabedatei",$fileworld);
    
    flush();
    
    // für eine schnellere Ermittlung von Name/Offiname interne Key-Tabelle aufbauen
    while (list($key,$val) = each($tabGatherInfos))
    {
        $tabinfos[$tabGatherInfos[$key]['npc_id']] = $key;
    }
    $anznpcs = 0;
    
    if (!file_exists($fileworld))
    {
        logLine("","nicht gefunden");
        return;
    }
    
    $hdlin = openInputFile($fileworld);
    $donpc = false;
    
    while (!feof($hdlin))
    {
        // Suche  <npc_info>
        //          <nameid>700207</nameid>
        //          <pos>
        //            <x>509.555664</x>
        //            <y>2653.232666</y>
        //            <z>130.000000</z>
        //          </pos>
        //        </npc_info>
        $line = trim(fgets($hdlin));
        
        if     (stripos($line,"<npc_info") !== false)
            $donpc = true;
        elseif (stripos($line,"</npc_info") !== false)
        {
            $donpc = false;
        
            if ($npcid != ""  &&  isset($tabGatherInfos[$npcid]))
            {
                $npckey   = $tabinfos[$npcid];
                $name     = $tabGatherInfos[$npckey]['name'];
                $offi     = $tabGatherInfos[$npckey]['offiname'];
                $anznpcs += addNpcToSpawnTable($npcid,$posx,$posy,$posz,$name,$offi); 
            }
            $npcid = $posx = $posy = $posz = "";
        }
        
        if ($donpc)
        {
            if     (stripos($line,"<nameid>") !== false)  
            {
                $npcid = substr($line,stripos($line,"<nameid>") + 8);
                $npcid = substr($npcid,0,stripos($npcid,"<"));
            }
            if     (stripos($line,"<x>") !== false)  
            {
                $posx = substr($line,stripos($line,"<x>") + 3);
                $posx = substr($posx,0,stripos($posx,"<"));
            }
            if     (stripos($line,"<y>") !== false)  
            {
                $posy = substr($line,stripos($line,"<y>") + 3);
                $posy = substr($posy,0,stripos($posy,"<"));
            }
            if     (stripos($line,"<z>") !== false)  
            {
                $posz = substr($line,stripos($line,"<z>") + 3);
                $posz = substr($posz,0,stripos($posz,"<"));
            }
        }
    }
    fclose($hdlin);
    
    logLine("gefundene NPCs/Spawns",$anznpcs);
}
// ----------------------------------------------------------------------------
// die Referenzschlüssel zum NPC ermitteln (npcid, name)
// ----------------------------------------------------------------------------
function getNpcInfosForSpawns()
{
    global $tabSpawn;
    
    logHead("Erweitern der NPC-Infos um Id und Name");
    
    flush();
    
    sort($tabSpawn);
    
    $oldnpcid = "";
    $oldnname = "";
    $oldgroup = "";
    $anznpcs  = 0;
    $anznull  = 0;
    $domax    = count($tabSpawn);
    
    for ($s=0;$s<$domax;$s++)
    {
        if ($oldgroup != $tabSpawn[$s]['offi'])
        {
            $oldgroup = $tabSpawn[$s]['offi'];
            $oldnpcid = getNpcId($oldgroup);
            $oldnname = getNpcName($oldgroup);
            
            if ($oldnpcid == "000000")
            {
                $oldnpcid = getNpcId($tabSpawn[$s]['name']);
                
                if ($oldnpcid != "000000")
                {
                    $oldnname = getNpcName($tabSpawn[$s]['name']);
                }
                else
                {
                    $anznull++;
                }
            }
        }
        $anznpcs++;
        $tabSpawn[$s]['sort']   = $oldnpcid."_".getSortNumValue(intval($tabSpawn[$s]['xpos']));
        $tabSpawn[$s]['npcid']  = $oldnpcid;
        $tabSpawn[$s]['name']   = $oldnname;       
    }
    
    sort($tabSpawn);
    
    logLine("Anzahl NPCs erweitert",$anznpcs);
    logLine("Anzahl nicht gefunden",$anznull);
}
// ----------------------------------------------------------------------------
// Spawn-Datei ausgeben
// ----------------------------------------------------------------------------
function generSpawnFile()
{
    global $tabSpawn, $welt, $tabWorldmaps;
    
    $outfile = formFileName("../outputs/spawn_output/Gather/".$welt."_".$tabWorldmaps[$welt]['name'].".xml");
    $anznpcs = 0;
    $anzdopp = 0;
    $anznull = 0;
    $anzpos  = 0;
    
    logHead("Erzeuge Spawn-Datei");
    logLine("Ausgabedatei",$outfile);
    
    flush();
    
    sort($tabSpawn);
    
    $hdlout  = openOutputFile($outfile);
    $oldnpc  = "";
    $oldgrp  = "";
    $oldpos  = 0;
    $domax   = count($tabSpawn);
    
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
    fwrite($hdlout,'<spawns>'."\n");
	fwrite($hdlout,'    <spawn_map map_id="'.$welt.'">'."\n");
    
    for ($s=0;$s<$domax;$s++)
    {
        if ($tabSpawn[$s]['npcid'] != "000000")
        {/*
            // neue Gruppe (npcid+xpos)
            if ($oldgrp != $tabSpawn[$s]['sort'])
            {*/
                // neuer Npc?
                if ($oldnpc != $tabSpawn[$s]['npcid'])
                {
                    if ($oldnpc != "")
                        fwrite($hdlout,"        </spawn>\n");
                      
                    $oldgrp  = $tabSpawn[$s]['sort'];                  
                    $oldnpc  = $tabSpawn[$s]['npcid'];
                    $oldpos  = 0;                    
                    $npcname = $tabSpawn[$s]['name'];
                                        
                    fwrite($hdlout,"        <!-- ".$npcname." -->\n");
                    fwrite($hdlout,'        <spawn npc_id="'.$oldnpc.'" respawn_time="295">'."\n");
                    $anznpcs++;
                }
                /*
                // gleicher NPC, anderer Spawn-Punkt Abweichung +- 1 wird ignoriert!
                $vonpos = intval($tabSpawn[$s]['xpos']);
                $bispos = intval($tabSpawn[$s]['xpos']);
                
                if ($vonpos <= $oldpos && $bispos >= $oldpos)
                {
                    $anzdopp++;
                }
                else
                {
                */
                    fwrite($hdlout,'			<spot x="'.$tabSpawn[$s]['xpos'].'" y="'.$tabSpawn[$s]['ypos'].'" z="'.$tabSpawn[$s]['zpos'].'"/>'."\n");
                    $anzpos++;
                //}
                
                $oldgrp = $tabSpawn[$s]['sort'];
                $oldpos = $tabSpawn[$s]['xpos'];
            /*
            }
            else
                $anzdopp++;
            */
        }
        else
        {
            $anznull++;
        }
    }	
    if($oldnpc != "")
        fwrite($hdlout,"        </spawn>\n");
        
	fwrite($hdlout,'    </spawn_map>'."\n");
    fwrite($hdlout,'</spawns>');
    
    fclose($hdlout);
    
    logLine("ignorierte NPCs/Spawns",$anznull);
    logLine("doppelte NPCs/Spawns",$anzdopp);
    logLine("ausgegebene Spawns",$anzpos);
    logLine("ausgegebene NPCs",$anznpcs);
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------

$buttStyle = ' style="width:153px;padding:0px;" ';
$buttHome  = ' style="width:153px;padding:0px;background-color:dodgerblue;" ';
$tabKeys   = array();
$tabSpawn  = array();
$cntSpawn  = 0;
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

if (!file_exists("includes/auto_inc_gather_infos.php"))
{
    include("includes/inc_inc_scan.php");
    makeIncludeGatherInfos();
}   
include("includes/auto_inc_gather_infos.php"); 

if ($submit == "J")
{   
    if ($pathlevels == "" || $pathdata == "")
    {
        logLine("ACHTUNG","die Pfade sind anzugeben");
    }
    else
    {
        logHead("Generierung erfolgt zur Map: $welt");
        
        /* entfällt, da keine Dateiauswahl
        switch ($scan)
        {
            case "*":    // alle Dateien
                getSpawnsFromMission0File();
                getSpawnsFromSourceSphere();
                getSpawnsFromClientWorld();
                break;
            case "M":    // nur Mission
                getSpawnsFromMission0File();
                break;
            case "S":    // nur Sphere
                getSpawnsFromSourceSphere();
                break;
            case "C":    // nur client_world
                getSpawnsFromClientWorld();
                break;
            default:
                break;
        }
        */
        getSpawnsFromMission0File();
        getNpcInfosForSpawns();        
        generSpawnFile();
        
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