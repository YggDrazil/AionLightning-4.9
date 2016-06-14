<html>
<head>
  <title>
    SpawnGenerator - Erzeugen Gebiets-Spawns f&uuml;r NPCs"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
// ----------------------------------------------------------------------------
// ToDo:  - ERL. erweitern der Spawns um die jeweiligen Walker-Ids
//        - ERL. generieren der jeweiligen Walker-Routen aus den Client-Dateien
//        - ERL. ermitteln/zuordnen von static_id-Angaben
//        - TODO erzeugen Spawns für Bases
//        - TODO erzeugen Spawns für Rifts
//        - TODO erzeugen Spawns für Sieges 
//        - TODO erzeugen Include worldMaps (zurückgestellt!)
//        - ERL. erzeugen Include Npc_infos
//
// Hint:  - eventuell die Z-Angabe aus den bestehenden Spawn-Files übernehmen
// ----------------------------------------------------------------------------    
include("../includes/inc_globals.php");
include("includes/inc_worldmaps.php");
include("includes/inc_statics.php");
include("includes/inc_inc_scan.php");

getConfData();
        
// Ausgabe-Verzeichnisse prüfen    
if (!file_exists("../outputs/spawn_output"))
{
    mkdir("../outputs/spawn_output"); 
    mkdir("../outputs/spawn_output/Npcs"); 
    mkdir("../outputs/spawn_output/npc_walker");
    mkdir("../outputs/spawn_output/Beritra");
    mkdir("../outputs/spawn_output/Instances");
    mkdir("../outputs/spawn_output/Statics");
}
else
{        
    if (!file_exists("../outputs/spawn_output/npc_walker"))
        mkdir("../outputs/spawn_output/npc_walker");
        
    if (!file_exists("../outputs/spawn_output/Beritra"))
        mkdir("../outputs/spawn_output/Beritra");
        
    if (!file_exists("../outputs/spawn_output/Instances"))
        mkdir("../outputs/spawn_output/Instances");
                
    if (!file_exists("../outputs/spawn_output/Statics"))
        mkdir("../outputs/spawn_output/Statics");
    
    if (!file_exists("../outputs/spawn_output/Npcs"))
    {
        mkdir("../outputs/spawn_output/Npcs");

        // da neues Unterverzeichnis Npcs, alte Dateien hierhin verschieben
        $files = scandir("../outputs/spawn_output");
        $domax = count($files);

        for ($f=0;$f<$domax;$f++)
        {
            if (stripos($files[$f],".xml") !== false)
            {
                $von = "../outputs/spawn_output/".$files[$f];
                $out = "../outputs/spawn_output/Npcs/".$files[$f];
                
                rename($von,$out);
            }
        }    
    }
}

$welt     = isset($_GET['welt'])     ? $_GET['welt']     : "";
$scan     = isset($_GET['scan'])     ? $_GET['scan']     : "*";
$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen Npc-Spawn-Dateien</div>
  <div class="hinweis" id="hinw">
    Erzeugen Npc-Spawn- / Walker-Dateien f&uuml;r das unten ausgew&auml;hlte Gebiet.<br><br>
    ACHTUNG: die Pfade werden der aktuellen Konfigurations-Datei entnommen.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte notwendige Informationen einf&uuml;gen</h1>
<form name="edit" method="GET" action="genSpawns.php" target="_self">
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
        $selected = " selected ";
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
?>
   <tr>
     <td colspan="2">
       <center>
       <span style="font-size:14px;color:cyan;padding-right:15px;">zu scannende Dateien</span>
       <select name="scan" id="idscan" style="width:385;"> 
       
<?PHP
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
        $selected = " selected ";
    else
        $selected = "";
        
    echo '    
         <option value="'.$tabscan[$s][0].'" '.$selected.'>'.$tabscan[$s][1].'</option>';
}
echo '
       </select>
     </td>
   </tr>';    
  
// ----------------------------------------------------------------------------
//
//                       H I L F S F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// NpcId aus der internen Tabelle ermitteln
// ----------------------------------------------------------------------------
/*
function getNpcIdNameTab($nameid)
{
    global $tabNpcInfos;
    
    $key = strtoupper($nameid);
    $ret = array();
    $ret['npcid'] = "000000";
    $ret['nname'] = "";   
    
    if (isset($tabNpcInfos[$key]))
    {
        $ret['npcid'] = $tabNpcInfos[$key]['npc_id'];
        $ret['nname'] = $tabNpcInfos[$key]['name'];
        return $ret;
    }
    else
    {
        if (substr($key,0,4) == "NPC_" && substr($key,strlen($key)-3,3) == "_SP")
        {
            $key = substr($key,4,stripos($key,"_SP") - 4);
            
            if (isset($tabNpcInfos[$key]))
            {
                $ret['npcid'] = $tabNpcInfos[$key]['npc_id'];
                $ret['nname'] = $tabNpcInfos[$key]['name'];
                return $ret;
            }
        }
    }
    
    // erweiterte Suche starten
    $key = getNpcPartKey($nameid);
    
    if (isset($tabNpcInfos[$key]))
    {
        $ret['npcid'] = $tabNpcInfos[$key]['npc_id'];
        $ret['nname'] = $tabNpcInfos[$key]['name'];
        return $ret;
    }
    else
        return $ret;
}
*/
// ----------------------------------------------------------------------------
// prüfen, ob der Name teilweise vorhanden ist (Table-Scan)
// ----------------------------------------------------------------------------
/* wurde ins Include inc_getautonameids verschoben
function getNpcPartKey($nameid)
{
    global $tabNpcInfos, $tabWorldmaps, $welt;
    
    $such = strtoupper($nameid);
        
    // vorne abschneiden bis Welt-Id
    $weltid = $tabWorldmaps[$welt]['offiname'];
    if (stripos($such,$weltid) !== false) $such = substr($such,stripos($such,$weltid));
        
    if (isset($tabNpcInfos[$such]))
    {
        return $tabNpcInfos[$such]['offiname'];
    }
    
    // hinten den letzten Part nach Unterstrich abschneiden
    $parts = explode("_",$such);
    $domax = count($parts) - 1;     // letzten abschneiden
    $trenn = "";
    $such  = "";
    
    for ($p=0;$p<$domax;$p++)
    {
        $such .= $trenn.$parts[$p];
        $trenn = "_";
    }
    
    if (isset($tabNpcInfos[$such]))
    {
        return $tabNpcInfos[$such]['offiname'];
    }
    
    return "";
}
*/
// ----------------------------------------------------------------------------
// Position H (Blickrichtung) ermitteln
// ----------------------------------------------------------------------------
function getPosH($ang)
{
    $ret = 0;  

    $ret   = ($ang / 3) - 30;
    if ($ret <   0) $ret += 120;
    if ($ret > 120) $ret  = 120;
    
    return intval($ret);
}
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// neuen NPC in die Spawn-Tabelle übernehmen
// ----------------------------------------------------------------------------
function addNpcToSpawnTable($src,$npcid,$xpos,$ypos,$zpos,$hpos,$name,$offi,$walk)
{   
    global $tabSpawn, $cntSpawn, $tabKeys, $tabBeritra, $cntBeritra;
    
    $key = $offi.intval($xpos);
    
    if (!isset($tabKeys[$key]))
    {
        if (stripos(strtoupper($offi),"WORLDRAID") !== false)
        {    
            // BERITRA
            $tabKeys[$key] = $key;
            
            $tabBeritra[$cntBeritra]['sort']  = $offi;
            $tabBeritra[$cntBeritra]['src']   = $src;
            $tabBeritra[$cntBeritra]['offi']  = $offi;
            $tabBeritra[$cntBeritra]['npcid'] = $npcid;
            $tabBeritra[$cntBeritra]['xpos']  = $xpos;
            $tabBeritra[$cntBeritra]['ypos']  = $ypos;
            $tabBeritra[$cntBeritra]['zpos']  = $zpos;
            $tabBeritra[$cntBeritra]['hpos']  = $hpos;
            $tabBeritra[$cntBeritra]['name']  = $name;
            $tabBeritra[$cntBeritra]['walk']  = $walk;
            $tabBeritra[$cntBeritra]['spid']  = 0;
            $tabBeritra[$cntBeritra]['type']  = "P";
            $tabBeritra[$cntBeritra]['stat']  = "";
            
            $cntBeritra++;
            
            return 0;
        }
        else
        {    
            // ANDERE
            $tabKeys[$key] = $key;
            
            $tabSpawn[$cntSpawn]['sort']  = $offi;
            $tabSpawn[$cntSpawn]['src']   = $src;
            $tabSpawn[$cntSpawn]['offi']  = $offi;
            $tabSpawn[$cntSpawn]['npcid'] = $npcid;
            $tabSpawn[$cntSpawn]['xpos']  = $xpos;
            $tabSpawn[$cntSpawn]['ypos']  = $ypos;
            $tabSpawn[$cntSpawn]['zpos']  = $zpos;
            $tabSpawn[$cntSpawn]['hpos']  = $hpos;
            $tabSpawn[$cntSpawn]['name']  = $name;
            $tabSpawn[$cntSpawn]['walk']  = $walk;
            $tabSpawn[$cntSpawn]['stat']  = "";
            
            $cntSpawn++;
            
            return 1;
        }
    }
    return 0;
}
// ----------------------------------------------------------------------------
// Spawns aus den Extrakten /levels/mapname/mission_mission0.xml ermitteln
// ----------------------------------------------------------------------------
function getSpawnsFromMission0File()
{
    global $pathlevels, $welt, $tabWorldmaps, $tabEntity;
        
    $filemission = formFileName($pathlevels."\\".$tabWorldmaps[$welt]['offiname']."\\mission_mission0.xml");
        
    logHead("Ermitteln Spawns aus Datei: mission_mission0.xml");
    logLine("Welt-Offi-Name",$tabWorldmaps[$welt]['offiname']);
    logLine("Eingabedatei",$filemission);
    
    flush();
    
    $anznpcs = 0;
    $anzstat = 0;
    $cntstat = 0;
    $cntent  = 0;
    $esuche  = "PlaceableObject";   // Suchbegriff für die EntityClass
    
    if (!file_exists($filemission))
    {
        logLine("","nicht gefunden");
        return;
    }
    
    $hdlin = openInputFile($filemission);
    
    while (!feof($hdlin))
    {
        $line = trim(fgets($hdlin));
        
        if (stripos($line,"<object") !== false  
        &&  stripos($line,"npc=")    !== false
        &&  stripos($line,"Pos=")    !== false)
        {
            $offi  = getKeyValue("Name",$line);
            $name  = getKeyValue("npc", $line);
            $pos   = getKeyValue("Pos", $line);
            $type  = getKeyValue("Type",$line);
            $ang   = getKeyValue("Angles",$line);
            $tpos  = split(",",$pos);
            $tang  = split(",",$ang);
    
            if (count($tang) >= 2)
                $ang = getPosH($tang[2]);

            if ($name == "")
            {
                if (substr(strtoupper($offi),0,3) == "SP_")
                    $name = substr($offi,3);
                else
                    $name = $offi;
            }
            
            if ($name != ""  &&  strtoupper($name) != "P1"  &&  $type == "SP")
            {
                $anznpcs += addNpcToSpawnTable("0","000000",$tpos[0],$tpos[1],$tpos[2],$ang,$name,$offi,""); 
            }
        }
        else
        {
            // bei Entities die relevanten Angaben ermitteln/merken
            if (stripos($line,"<Entity") !== false && stripos($line,"EntityClass") != false)
            {
                $eclass = getKeyValue("EntityClass",$line);
                                    
                // Entity merken
                if ($eclass == $esuche)
                {
                    $etab = explode(",",getKeyValue("Pos",$line));
                    
                    $tabEntity[$cntent]['sort'] = intval($etab[0]);
                    $tabEntity[$cntent]['name'] = getKeyValue("Name",$line);
                    $tabEntity[$cntent]['id']   = getKeyValue("EntityId",$line);
                    $tabEntity[$cntent]['name'] = getKeyValue("Name",$line);
                    $tabEntity[$cntent]['xpos'] = $etab[0];
                    $tabEntity[$cntent]['ypos'] = $etab[1];
                    $tabEntity[$cntent]['done'] = 0;
                    
                    $cntent++;
                }
            }
        }
    }
    fclose($hdlin);
   
    logLine("gefundene NPCs/Spawns",$anznpcs);
    logLine("gefundene StaticIds",$anzstat);
    
    sort($tabEntity);
}
// ----------------------------------------------------------------------------
// Spawns aus der extrahierten Datei sourceshpere.csv ermitteln
// ----------------------------------------------------------------------------
function getSpawnsFromSourceSphere()
{
    global $pathdata, $welt, $tabWorldmaps;
    
    $filesphere = formFileName($pathdata."/World/source_sphere.csv");
    $anznpcs    = 0;
    $suchmap    = strtoupper($tabWorldmaps[$welt]['offiname']);
    
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
        //        0            1   2   3 4      5      6      7     8 9 10 11 12 
        // Suche: 0c_bat_29_an,npc,lf2,0,403.65,220.86,285.00,67.13, ,0, 0,-1,1
        $line  = trim(fgets($hdlin));
        $tab   = split(",",$line);

        if (count($tab) > 11                         // alle Infos vorhanden
        &&  strtoupper($tab[2]) == $suchmap)         // gesuchte MapId vorhanden
        {
            if (stripos($tab[0],"itemusearea") === false)
            {
                if (count($tab) > 8)
                    $anznpcs += addNpcToSpawnTable("2","000000",$tab[4],$tab[5],$tab[6],getPosH($tab[7]),"",$tab[0],$tab[8]);
                else
                    $anznpcs += addNpcToSpawnTable("2","000000",$tab[4],$tab[5],$tab[6],getPosH($tab[7]),"",$tab[0],"");
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
    global $pathdata, $welt, $tabWorldmaps, $tabNpcInfos;
        
    $fileworld = formFileName($pathdata."\\World\\client_world_".$tabWorldmaps[$welt]['offiname'].".xml");
    $fileworld = convFileToUtf8($fileworld);
    $tabinfos  = array();
    
    logHead("Ermitteln Spawns aus Datei: ".basename($fileworld));
    logLine("Welt-Offi-Name",$tabWorldmaps[$welt]['offiname']);
    logLine("Eingabedatei",$fileworld);
    
    flush();
    
    // für eine schnellere Ermittlung von Name/Offiname interne Key-Tabelle aufbauen
    while (list($key,$val) = each($tabNpcInfos))
    {
        $tabinfos[$tabNpcInfos[$key]['npc_id']] = $key;
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
        $line = trim(fgets($hdlin));
        
        if     (stripos($line,"<npc_info") !== false)
            $donpc = true;
        elseif (stripos($line,"</npc_info") !== false)
        {
            $donpc = false;
        
            if ($npcid != "")
            {
                $npckey   = $tabinfos[$npcid];
                $name     = $tabNpcInfos[$npckey]['name'];
                $offi     = $tabNpcInfos[$npckey]['offiname'];
                $anznpcs += addNpcToSpawnTable("1",$npcid,$posx,$posy,$posz,60,$name,$offi,"");               
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
            $tabinfo  = getNpcIdNameTab($oldgroup);
            
            if ($tabinfo['npcid'] == "000000")
                $tabinfo = getNpcIdNameTab($tabSpawn[$s]['name']);
                
            $oldnpcid = $tabinfo['npcid'];
            $oldnname = $tabinfo['nname'];            
            
            if ($oldnpcid == "000000")
            {
                $anznull++;
            }
        }
        $anznpcs++;
        
        if ($tabSpawn[$s]['walk'] == "")
            $walk = "_1_";
        else
            $walk = "_0_";
            
        $tabSpawn[$s]['sort']   = $oldnpcid."_".getSortNumValue(intval($tabSpawn[$s]['xpos']).$walk.$tabSpawn[$s]['src']);
        $tabSpawn[$s]['npcid']  = $oldnpcid;
        $tabSpawn[$s]['name']   = $oldnname;       
    }
    
    sort($tabSpawn);
    
    logLine("Anzahl NPCs erweitert",$anznpcs);
    logLine("Anzahl nicht gefunden",$anznull);
}
// ----------------------------------------------------------------------------
// Name des NPC seq. ermitteln
// ----------------------------------------------------------------------------
function getNameWithNpcId($npcid)
{
    global $tabNpcInfos;
    
    reset($tabNpcInfos);
    
    while (list($key,$val) = each($tabNpcInfos))
    {
        if ($npcid == $tabNpcInfos[$key]['npc_id'])
            return $tabNpcInfos[$key]['name'];
    }
    return "???";
}
// ----------------------------------------------------------------------------
// Z-Position prüfen (maximal +/- 10!
// ----------------------------------------------------------------------------
function isPosZInRange($znow,$zold)
{
    if ($zold >= ($znow - 10) && $zold <= ($znow + 10))
        return true;
    else
        return false;
}
// ----------------------------------------------------------------------------
// Informationen aus den alten SVN-Daten sammeln
// ----------------------------------------------------------------------------
function getNpcInfosFromOldFile()
{
    global $pathsvn, $tabSpawn, $welt, $tabWorldmaps;
    
    $tabolds = array();
    $tabname = array();
    
    $oldfile = formFileName($pathsvn."\\trunk\\AL-Game\\data\static_data\\spawns\\Npcs\\".$welt."_".$tabWorldmaps[$welt]['name'].".xml");
    
    if (!file_exists($oldfile))
    {
        logLine("SVN-Datei fehlt",$oldfile);
        return;
    }
    
    // interne Namenstabelle aufbauen
    $domax = count($tabSpawn);
    
    for ($s=0;$s<$domax;$s++)
    {
        if ($tabSpawn[$s]['npcid'] != "000000")
        {
            if (!isset($tabname[$tabSpawn[$s]['npcid']]))
                $tabname[$tabSpawn[$s]['npcid']] = $tabSpawn[$s]['name'];
        }
    }
        
    // Daten aus existierendem SVN-File lesen
    // es werden derzeit nur MOBs berücksichtigt!
    $hdlin = openInputFile($oldfile);
    $npcid = "";
    $donpc = false;
    
    while (!feof($hdlin))
    {
        $line = rtrim(fgets($hdlin));
        
        if (stripos($line,"npc_id") !== false)
        {
            $npcid = intval(getKeyValue("npc_id",$line));
            
            if (($npcid >= 208000  &&  $npcid <= 300000)
            ||   $npcid >= 855000)
            {
                // OK, übernehmen
                $donpc = true;
            }
            else
            {
                // kein Monster, also ignorieren
                $donpc = false;
            }
        }
        else
        {
            if ($donpc  &&  stripos($line,"<spot") !== false)
            {
                $xpos = getKeyValue("x",$line);
                $ypos = getKeyValue("y",$line);   
                $zpos = getKeyValue("z",$line);                
                $xkey = intval(round($xpos,0));
                $ykey = intval(round($ypos,0));  
               
                $tabolds[$xkey][$ykey]['npcid'] = $npcid;
                $tabolds[$xkey][$ykey]['zpos']  = intval($zpos);
                $tabolds[$xkey][$ykey]['done']  = "N";
            }
        }
    }
    logLine("ermittelte alte Positionen",count($tabolds));
        
    // zu den noch nicht identifizierten NPCs eine Id suchen. Gesucht wird über
    // die XYZ-Position 
    $anzold = 0;
    $domax  = count($tabSpawn);
    $walk   = "_1_";
    $diff   = 30;                                // max. Abweichung für X/Y
    
    echo "<hr>";
    
    for ($s=0;$s<$domax;$s++)
    {
        if ($tabSpawn[$s]['npcid'] == "000000")
        {
            $xpos = intval($tabSpawn[$s]['xpos']);
            $ypos = intval($tabSpawn[$s]['ypos']);
            $znow = intval($tabSpawn[$s]['zpos']);            
            $xkey = intval(round($xpos,0));
            $ykey = intval(round($ypos,0));
            
            // Suchen durch Annäherung (max. $diff, s.o.)
            for ($xd=0;$xd<=$diff;$xd++)
            {
                $xnow = $xkey + $xd;
                
                if (isset($tabolds[$xnow]))
                {
                    for ($yd=0;$yd<=$diff;$yd++)
                    {
                        $ynow = $ykey + $yd;
                        if (isset($tabolds[$xnow][$ynow]) && $tabolds[$xnow][$ynow]['done'] == "N")
                        {
                            if (isPosZInRange($znow,$tabolds[$xnow][$ynow]['zpos']))
                            {
                                $tabSpawn[$s]['npcid'] = $tabolds[$xnow][$ynow]['npcid'];
                                $tabolds[$xnow][$ynow]['done'] = "J";
                            }
                        }
                        else
                        {
                            $ynow = $ykey - $yd;
                            if (isset($tabolds[$xnow][$ynow]) && $tabolds[$xnow][$ynow]['done'] == "N")
                            {
                                if (isPosZInRange($znow,$tabolds[$xnow][$ynow]['zpos']))
                                {
                                    $tabSpawn[$s]['npcid'] = $tabolds[$xnow][$ynow]['npcid'];
                                    $tabolds[$xnow][$ynow]['done'] = "J";
                                }
                            }
                        }
                    }
                }
                else
                {
                    $xnow = $xkey - $xd;
                    if (isset($tabolds[$xnow]))
                    {
                        for ($yd=0;$yd<=$diff;$yd++)
                        {
                            $ynow = $ykey + $yd;
                            if (isset($tabolds[$xnow][$ynow]) && $tabolds[$xnow][$ynow]['done'] == "N")
                            {
                                if (isPosZInRange($znow,$tabolds[$xnow][$ynow]['zpos']))
                                {
                                    $tabSpawn[$s]['npcid'] = $tabolds[$xnow][$ynow]['npcid'];
                                    $tabolds[$xnow][$ynow]['done'] = "J";
                                }
                            }
                            else
                            {
                                $ynow = $ykey - $yd;
                                if (isset($tabolds[$xnow][$ynow]) && $tabolds[$xnow][$ynow]['done'] == "N")
                                {
                                    if (isPosZInRange($znow,$tabolds[$xnow][$ynow]['zpos']))
                                    {
                                        $tabSpawn[$s]['npcid'] = $tabolds[$xnow][$ynow]['npcid'];
                                        $tabolds[$xnow][$ynow]['done'] = "J";
                                    }
                                }
                            }
                        }                      
                    }
                }
                if ($tabSpawn[$s]['npcid'] != "000000")
                {
                    $anzold++;
                    $xd = $diff + 1;          // vorzeitiges Ende!
                    $tabSpawn[$s]['name']  = isset($tabname[$tabSpawn[$s]['npcid']]) ? $tabname[$tabSpawn[$s]['npcid']] : getNameWithNpcId($tabSpawn[$s]['npcid']);
                    $tabSpawn[$s]['sort']  = $tabSpawn[$s]['npcid']."_".getSortNumValue(intval($tabSpawn[$s]['xpos']).$walk.$tabSpawn[$s]['src']);
                }
            }
        }
    }
    logLine("zus. gefunden aus SVN-Datei",$anzold);
}
// ----------------------------------------------------------------------------
// prüfen, ob über die alten SVN-Daten die Z-Angabe korrigiert werden kann
//
// Annahme: in einem Bereich von +-n für x/y sollte Z annährend gleich sein
// ----------------------------------------------------------------------------
function getOldZForSpawns()
{
    global $pathsvn, $tabSpawn, $welt, $tabWorldmaps;
        
    $oldfile = formFileName($pathsvn."\\trunk\\AL-Game\\data\static_data\\spawns\\Npcs\\".$welt."_".$tabWorldmaps[$welt]['name'].".xml");
    $dolog = false;
    $anznew = 0;
    
    if ($dolog)
    {
        $hdllog = openOutputFile("sposlog.txt");
    }
    
    if (getPosTabFromOldFile($oldfile,"<spot"))
    {            
        // Suchen Z-Position durch Annäherung zu X-/Y-Position
        $domax  = count($tabSpawn);
        $anznew = 0;
        
        for ($s=0;$s<$domax;$s++)
        {            
            $znew = getOldZPosFromTab($tabSpawn[$s]['xpos'],$tabSpawn[$s]['ypos'],$tabSpawn[$s]['zpos']);
            
            if ($znew != $tabSpawn[$s]['zpos'])
            {                
                if ($dolog)
                {
                    fwrite($hdllog,"NewZfromOld: Npc=".$tabSpawn[$s]['npcid'].", x=".$tabSpawn[$s]['xpos'].", y=".
                                   $tabSpawn[$s]['ypos'].", z=".$tabSpawn[$s]['zpos'].", NewZ=".$znew."\n");
                }
                
                $anznew++;
                $tabSpawn[$s]['zpos'] = $znew;
            }
        }
    }
    logLine("angepasste Z-Positionen",$anznew); 

    if ($dolog)
        fclose($hdllog);
}
// ----------------------------------------------------------------------------
// prüfen, ob über die alten SVN-Daten die Z-Angabe korrigiert werden kann
//
// Annahme: in einem Bereich von +-n für x/y sollte Z annährend gleich sein
// ----------------------------------------------------------------------------
function getOldZForBeritra()
{
    global $pathsvn, $tabBeritra, $welt, $tabWorldmaps;
        
    $oldfile = formFileName($pathsvn."\\trunk\\AL-Game\\data\static_data\\spawns\\Beritra\\".$welt."_".$tabWorldmaps[$welt]['name'].".xml");
    
    if (getPosTabFromOldFile($oldfile,"<spot"))
    {            
        // Suchen Z-Position durch Annäherung zu X-/Y-Position
        $domax  = count($tabBeritra);
        $anznew = 0;
        
        for ($s=0;$s<$domax;$s++)
        {            
            $znew = getOldZPosFromTab($tabBeritra[$s]['xpos'],$tabBeritra[$s]['ypos'],$tabBeritra[$s]['zpos']);
            
            if ($znew != $tabBeritra[$s]['zpos'])
            {
                $anznew++;
                $tabBeritra[$s]['zpos'] = $znew;
            }
        }
    }
    logLine("Verarbeitete NPCs",$domax);
    logLine("angepasste Z-Positionen",$anznew);  
}
// ----------------------------------------------------------------------------
// die Referenzschlüssel zum NPC ermitteln (npcid, name)
// ----------------------------------------------------------------------------
function getNpcInfosForBeritra()
{
    global $tabBeritra;
    
    logHead("Erweitern der Beritra-NPC-Infos um Id und Name");
    
    flush();
    
    sort($tabBeritra);
    
    $oldnpcid = "";
    $oldnname = "";
    $oldgroup = "";
    $anznpcs  = 0;
    $anznull  = 0;
    $domax    = count($tabBeritra);
    
    for ($s=0;$s<$domax;$s++)
    {
        if ($oldgroup != $tabBeritra[$s]['offi'])
        {
            $oldgroup = $tabBeritra[$s]['offi'];
            $tabinfo  = getNpcIdNameTab($oldgroup);
            
            if ($tabinfo['npcid'] == "000000")
                $tabinfo = getNpcIdNameTab($tabBeritra[$s]['name']);
                
            $oldnpcid = $tabinfo['npcid'];
            $oldnname = $tabinfo['nname'];            
            
            if ($oldnpcid == "000000")
            {
                $anznull++;
            }
        }
        $anznpcs++;
        
        if ($tabBeritra[$s]['walk'] == "")
            $walk = "_1_";
        else
            $walk = "_0_";
            
        $tabBeritra[$s]['sort']   = getSortNumValue(intval($tabBeritra[$s]['xpos'])."_".$oldnpcid.$walk."_".$tabBeritra[$s]['src']);
        $tabBeritra[$s]['npcid']  = $oldnpcid;
        $tabBeritra[$s]['name']   = $oldnname;       
    }
    
    sort($tabBeritra);
    
    logLine("Anzahl NPCs erweitert",$anznpcs);
    logLine("Anzahl nicht gefunden",$anznull);
}
// ----------------------------------------------------------------------------
// alle relevanten NPCs gem. Vorgabe auf X-/Y-Pos prüfen für static_id
// ----------------------------------------------------------------------------
function checkForEntityId($ind,$diff)
{
    global $tabEntity, $tabSpawn;
        
    $domax = count($tabEntity);
    $xpos  = $tabSpawn[$ind]['xpos'];
    $ypos  = $tabSpawn[$ind]['ypos'];
    
    $xvon = $xpos - $diff;
    $xbis = $xpos + $diff;
    $yvon = $ypos - $diff;
    $ybis = $ypos + $diff;
        
    for ($e=0;$e<$domax;$e++)
    {
        if ($tabEntity[$e]['done'] == 0  &&  $tabEntity[$e]['xpos'] >= $xvon)
        {                
            if ($tabEntity[$e]['xpos'] >= $xvon && $tabEntity[$e]['xpos'] <= $xbis
            &&  $tabEntity[$e]['ypos'] >= $yvon && $tabEntity[$e]['ypos'] <= $ybis)
            {
                $tabEntity[$e]['done'] = $ind;
                
                return $tabEntity[$e]['id'];
            }
            // nach X sortiert, also kann hier beendet werden, wenn XBIS überschritten
            if ($tabEntity[$e]['xpos'] > $xbis)
                $e = $domax;
        }
    }
    
    return "";
}
// ----------------------------------------------------------------------------
// Versucht die static_ids zuzuordnen
// Reihenfolge: client_world, npcid>700000 zu mission, sourcesphere
// ----------------------------------------------------------------------------
function checkEntityIds()
{
    global $tabSpawn, $tabEntity;
    
    logHead("Versuche die static_id zuzuordnen");
    logLine("ermittelte EntityIDs",count($tabEntity));
        
    $tabsrcs = array(
                     array("1",0),        // client_world -> alle
                     array("0",700000),   // mission      -> nur > 700000
                     array("2",700000)    // sourcesphere -> nur > 700000
                    );
    $maxsrcs = count($tabsrcs);
    $dvon    = 0;    // prüfen ab Differenz 0
    $dmax    = 21;   // prüfen bis Differenz 21
    $dstep   = 0.5;  // Prüf-Schrittweite
    
    for ($src=0;$src<$maxsrcs;$src++)
    {
        $tabtemp = array();
        $cnttemp = 0;
        $domax   = count($tabSpawn);
        
        for ($s=0;$s<$domax;$s++)
        {
            if ($tabSpawn[$s]['stat']  == ""
            &&  $tabSpawn[$s]['src']   == $tabsrcs[$src][0] 
            &&  $tabSpawn[$s]['npcid'] >= $tabsrcs[$src][1])
            {
                $tabtemp[$cnttemp]['sort']  = $tabSpawn[$s]['xpos'];
                $tabtemp[$cnttemp]['npcid'] = $tabSpawn[$s]['npcid'];
                $tabtemp[$cnttemp]['index'] = $s;
                $tabtemp[$cnttemp]['entit'] = "";
                
                $cnttemp++;
            }
        }
        
        // nach X-Pos sortieren
        sort($tabtemp);
        $domax = count($tabtemp);
        
        for ($diff=$dvon;$diff<=$dmax;$diff += $dstep)
        {
            for ($s=0;$s<$domax;$s++)
            {
                if ($tabtemp[$s]['entit'] == "")
                    $tabtemp[$s]['entit'] = checkForEntityId($tabtemp[$s]['index'],$diff);
            }
        }
        for ($s=0;$s<$domax;$s++)
        {
            $tabSpawn[$tabtemp[$s]['index']]['stat'] = $tabtemp[$s]['entit'];
        }
    }
    $anzdo = 0;
    $anzno = 0;
    
    $domax = count($tabEntity);
    
    for ($e=0;$e<$domax;$e++)
    {
        if ($tabEntity[$e]['done'] == 0)
            $anzno++;
        else
            $anzdo++;
    }
    logLine("- davon zugeordnet",$anzdo);
    logLine("- davon nicht zugeordnet",$anzno);
}
// ----------------------------------------------------------------------------
// doppelte Spawns entfernen
// - wenn: npcid und xpos identisch zum Vorgänger
// - wenn: npcid und (xpos +- 2) und andere Quelle
// - wenn NpcId in Beritra-Tabelle vorhanden
// ----------------------------------------------------------------------------
function checkDuplicateSpawns()
{
    global $tabSpawn, $tabBeritra;
    
    $tabtemp  = $tabSpawn;
    $tabSpawn = array();
    $cntSpawn = 0;
    
    $oldgrp   = "";
    $oldnpc   = "";
    $oldsrc   = "";
    $oldposx  = 0;
    $oldposy  = 0;
    
    $difposx  = 0;
    $difposy  = 0;
    
    $anznull  = 0;
    $anzdopp  = 0;
    $anzberi  = 0;
    
    sort($tabtemp);
    
    // Beritra-Npcs in verschlüsselte Tabelle übernehmen
    $tabberi = array();
    $domax   = count($tabBeritra);
    
    for ($b=0;$b<$domax;$b++)
    {
        if (!isset($tabberi[$tabBeritra[$b]['npcid']]))
            $tabberi[$tabBeritra[$b]['npcid']] = $tabBeritra[$b]['npcid'];
    }
    
    logHead("doppelte Spawns entfernen");
    
    $domax    = count($tabtemp);
    
    for ($s=0;$s<$domax;$s++)
    {
        if ($tabtemp[$s]['npcid'] != "000000")
        {
            // wenn NPC in Beritra vorhanden, dann auch ignorieren
            if (!isset($tabberi[$tabtemp[$s]['npcid']]))
            {
                // neue Gruppe (npcid+xpos)
                if ($oldgrp != $tabtemp[$s]['sort'])
                {                                                
                    // neuer Npc?
                    if ($oldnpc != $tabtemp[$s]['npcid'])
                    {                      
                        $oldgrp  = $tabtemp[$s]['sort'];                  
                        $oldnpc  = $tabtemp[$s]['npcid'];
                        $oldposx = $tabtemp[$s]['xpos'];
                        $oldposy = $tabtemp[$s]['ypos'];
                        $oldsrc  = $tabtemp[$s]['src']; 
                        
                        // gleicher NPC, anderer Spawn-Punkt Abweichung +- $defdiff wird ignoriert!
                        if (($oldnpc >= 208000  &&  $oldnpc <= 300000)
                        ||   $oldnpc >= 855000)
                        {
                            // Monster sind durchaus mehrfach an ähnlichen Positionen
                            $difposx = 5;
                            $difposy = 5;
                        }
                        else
                        {
                            // NPCs sind mmeistens nicht doppelt bzw. an einer ähnlichen Stelle
                            $difposx = 40;
                            $difposy = 40;
                        }
                        
                        $tabSpawn[$cntSpawn] = $tabtemp[$s];
                        $tabSpawn[$cntSpawn]['sort'] = $tabSpawn[$cntSpawn]['npcid']."_".getSortNumValue($tabSpawn[$cntSpawn]['xpos']);
                        $cntSpawn++;                        
                    }
                    else
                    {      
                        $vonposx = intval($tabtemp[$s]['xpos']) - $difposx;
                        $bisposx = intval($tabtemp[$s]['xpos']) + $difposx;
                        $vonposy = intval($tabtemp[$s]['ypos']) - $difposy;
                        $bisposy = intval($tabtemp[$s]['ypos']) + $difposy;
                         
                        if ($oldposx >= $vonposx && $oldposx <= $bisposx
                        &&  $oldposy >= $vonposy && $oldposy <= $bisposy)
                        {
                            $anzdopp++;
                        }
                        else
                        {
                            $tabSpawn[$cntSpawn] = $tabtemp[$s];
                            $tabSpawn[$cntSpawn]['sort'] = $tabSpawn[$cntSpawn]['npcid']."_".getSortNumValue($tabSpawn[$cntSpawn]['xpos']);
                            $cntSpawn++;
                        }
                    }
                    $oldgrp  = $tabtemp[$s]['sort'];
                    $oldnpc  = $tabtemp[$s]['npcid'];
                    $oldposx = $tabtemp[$s]['xpos'];
                    $oldposy = $tabtemp[$s]['ypos'];
                    $oldsrc  = $tabtemp[$s]['src'];
                }
                else
                {
                    $anzdopp++;
                }
            }
            else
                $anzberi++;
        }
        else
        {
            $anznull++;
        }
    }
    
    logLine("Anzahl NPCs",$domax);
    logLine("- davon ignoriert (NpcId)",$anznull);
    logLine("- davon dopppelt ",$anzdopp);
    logLine("- davon verblieben",count($tabSpawn));
    logLine("- davon in Beritra",$anzberi);
}
// ----------------------------------------------------------------------------
// Spawn-Datei ausgeben
// ----------------------------------------------------------------------------
function generSpawnFile()
{
    global $tabSpawn, $welt, $tabWorldmaps, $tabWalker, $tabEntity;
        
    getNpcInfosForSpawns(); 
    getNpcInfosFromOldFile();
    checkDuplicateSpawns();
    
    sort($tabSpawn);
    
    checkEntityIds();
    getOldZForSpawns();
    
    $worldid = $tabWorldmaps[$welt]['offiname'];
    $wpath   = "Npcs";
    $respawn = ' respawn_time="295"';
    
    if (strtoupper(substr($worldid,0,2)) == "ID")
    {    
        $wpath = "Instances";
        $respawn = "";
    }
        
    $outfile = formFileName("../outputs/spawn_output/".$wpath."/".$welt."_".$tabWorldmaps[$welt]['name'].".xml");
    $anznpcs = 0;
    $anzdopp = 0;
    $anznull = 0;
    $anzpos  = 0;
    
    logHead("Erzeuge Spawn-Datei");
    logLine("Ausgabedatei",$outfile);
    
    flush();
    
    $hdlout  = openOutputFile($outfile);
    $oldnpc  = "";
    $oldgrp  = "";
    $domax   = count($tabSpawn);
    
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
    fwrite($hdlout,'<spawns>'."\n");
	fwrite($hdlout,'    <spawn_map map_id="'.$welt.'">'."\n");
        
    for ($s=0;$s<$domax;$s++)
{
        // neue Gruppe (npcid+xpos)
        if ($oldgrp != $tabSpawn[$s]['sort'])
        {
            // neuer Npc?
            if ($oldnpc != $tabSpawn[$s]['npcid'])
            {
                if ($oldnpc != "")
                    fwrite($hdlout,"        </spawn>\n");
                  
                $oldgrp  = $tabSpawn[$s]['sort'];                  
                $oldnpc  = $tabSpawn[$s]['npcid'];
                $npcname = $tabSpawn[$s]['name'];
                                                       
                fwrite($hdlout,"        <!-- ".$npcname." / ".$tabSpawn[$s]['offi']." -->\n");
                fwrite($hdlout,'        <spawn npc_id="'.$oldnpc.'"'.$respawn.'>'."\n");
                $anznpcs++;
            }
            
            if ($tabSpawn[$s]['walk'] != "")
            {
                $walker = ' walker_id="'.strtoupper($tabSpawn[$s]['walk']).'"';

                // Walker merken
                $wkey = strtoupper($tabSpawn[$s]['walk']);
                if (isset($tabWalker[$wkey]))
                {
                    $tabWalker[$wkey]['pool']++;
                    $tabWalker[$wkey]['npcs'] .= ", ".$oldnpc;
                }
                else
                {
                    $tabWalker[$wkey]['pool'] = 1;
                    $tabWalker[$wkey]['npcs'] = $oldnpc;
                }
            }
            else
                 $walker = "";
            
            $entity = "";
            if ($tabSpawn[$s]['stat'] != "")
                $entity = ' static_id="'.$tabSpawn[$s]['stat'].'"';
            
            if ($tabSpawn[$s]['hpos'] == "?") $tabSpawn[$s]['hpos'] = "60"; 
            
            fwrite($hdlout,'			<spot x="'.$tabSpawn[$s]['xpos'].'" y="'.$tabSpawn[$s]['ypos'].
                           '" z="'.$tabSpawn[$s]['zpos'].'" h="'.$tabSpawn[$s]['hpos'].'"'.$entity.$walker.'/>'."\n");
            $anzpos++;
            
            $oldgrp = $tabSpawn[$s]['sort'];
            $oldpos = $tabSpawn[$s]['xpos'];
        }
        else
        {
            $anzdopp++;
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
// Beritra-Spawn-Ids festlegen!
// - wird über die x-Positionen festgelegt
// ----------------------------------------------------------------------------
function checkBeritraSpawnId()
{
    global $tabBeritra;
    
    $tabxpos = array();
    $domax   = count($tabBeritra);
    getOldZForBeritra();
    
    for ($n=0;$n<$domax;$n++)
    {
        // führend ist die mission-Datei 
        if ($tabBeritra[$n]['npcid'] != "000000"
        &&  $tabBeritra[$n]['src']   == "0")
        {
            $key = intval($tabBeritra[$n]['xpos']);
            
            if (isset($tabxpos[$key]))
                $tabxpos[$key]++;
            else
                $tabxpos[$key] = 1;
        }
    }
    
    // alle vorhandenen X-Positionen bei den Beritras mit der spawnid versehen
    $spawnid = 0;
    
    while (list($key,$val) = each($tabxpos))
    {
        $spawnid++;
        
        for ($n=0;$n<$domax;$n++)
        {
            if (intval($tabBeritra[$n]['xpos']) == $key)
            {
                $tabBeritra[$n]['spid'] = $spawnid;
                
                $beritype = "I";
                if (stripos(strtoupper($tabBeritra[$n]['offi']),"OBJECT") !== false)
                    $beritype = "P";
                    
                $tabBeritra[$n]['sort'] = $spawnid."_".$beritype."_".$tabBeritra[$n]['sort'];
                $tabBeritra[$n]['type'] = $beritype;
            }
            else
            {
                $tabBeritra[$n]['sort'] = "0_X_".$tabBeritra[$n]['sort'];
                $tabBeritra[$n]['type'] = "X";
            }
        }
    }
}
// ----------------------------------------------------------------------------
// ausgeben der NPCs, die als Beritra erkannt wurden
// ----------------------------------------------------------------------------
function generBeritraFile()
{
    global $tabBeritra, $welt, $tabWorldmaps, $tabWalker;
    
    if (count($tabBeritra) == 0)
        return;
    
    getNpcInfosForBeritra(); 
        
    $outfile = formFileName("../outputs/spawn_output/Beritra/".$welt."_".$tabWorldmaps[$welt]['name'].".xml");
    $anznpcs = 0;
    $anzdopp = 0;
    $anznull = 0;
    $anzpos  = 0;
    
    logHead("Erzeuge Beritra-Datei");
    logLine("Ausgabedatei",$outfile);
    
    flush();
    
    checkBeritraSpawnId();
    
    sort($tabBeritra);
    
    $hdlout  = openOutputFile($outfile);
    $oldspid = 0;
    $oldtype = "";
    $oldnpc  = "";
    $oldgrp  = "";
    $oldpos  = 0;
    $domax   = count($tabBeritra);
    
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
    fwrite($hdlout,'<spawns>'."\n");
	fwrite($hdlout,'    <spawn_map map_id="'.$welt.'">'."\n");
    
    for ($s=0;$s<$domax;$s++)
    {
        if ($tabBeritra[$s]['npcid'] != "000000"  &&  $tabBeritra[$s]['spid'] != 0)
        {
            // neue Gruppe (spid+type+npcid)
            if ($oldgrp != $tabBeritra[$s]['sort'])
            {
                // neue ID ? 
                if ($oldspid != $tabBeritra[$s]['spid'])
                {
                    if ($oldspid != "")
                    {
                        fwrite($hdlout,"                </spawn>\n");
                        fwrite($hdlout,"            </beritra_type>\n");
                        fwrite($hdlout,"        </beritra_spawn>\n");
                    }
                    
                    fwrite($hdlout,'        <beritra_spawn id="'.$tabBeritra[$s]['spid'].'">'."\n");
                    $oldspid = $tabBeritra[$s]['spid'];
                    $oldtype = "";
                    $oldnpc  = "";
                }
                // neuer Typ
                if ($oldtype != $tabBeritra[$s]['type'])
                {
                    if ($oldtype != "")
                    {
                        fwrite($hdlout,"                </spawn>\n");
                        fwrite($hdlout,"            </beritra_type>\n");
                    }
                    
                    $typetext = $tabBeritra[$s]['type'] == "I" ? "INVASION" : "PEACE";
                    
                    fwrite($hdlout,'            <beritra_type bstate="'.$typetext.'">'."\n");
                    $oldtype = $tabBeritra[$s]['type'];
                    $oldnpc  = "";
                }
                // neuer Npc?
                if ($oldnpc != $tabBeritra[$s]['npcid'])
                {
                    if ($oldnpc != "")
                        fwrite($hdlout,"                </spawn>\n");
                      
                    $oldgrp  = $tabBeritra[$s]['sort'];                  
                    $oldnpc  = $tabBeritra[$s]['npcid'];
                    $oldpos  = 0;                    
                    $npcname = $tabBeritra[$s]['name'];
                    if ($npcname == "None")
                        $npcname = $tabBeritra[$s]['name']." (".$tabBeritra[$s]['offi'].")";
                        
                    fwrite($hdlout,"                <!-- ".$npcname." -->\n");
                    fwrite($hdlout,'                <spawn npc_id="'.$oldnpc.'">'."\n");
                    $anznpcs++;
                }
                
                // gleicher NPC, anderer Spawn-Punkt Abweichung +- 1 wird ignoriert!
                $vonpos = intval($tabBeritra[$s]['xpos']) - 2;
                $bispos = intval($tabBeritra[$s]['xpos']) + 2;
                
                if ($vonpos <= $oldpos && $bispos >= $oldpos)
                {
                    $anzdopp++;
                }
                else
                {
                    if ($tabBeritra[$s]['walk'] != "")
                    {
                        $walker = ' walker_id="'.$tabBeritra[$s]['walk'].'"';

                        // Walker merken
                        $wkey = strtoupper($tabBeritra[$s]['walk']);
                        if (isset($tabWalker[$wkey]))
                        {
                            $tabWalker[$wkey]['pool']++;
                            $tabWalker[$wkey]['npcs'] .= ", ".$oldnpc;
                        }
                        else
                        {
                            $tabWalker[$wkey]['pool'] = 1;
                            $tabWalker[$wkey]['npcs'] = $oldnpc;
                        }
                    }
                    else
                         $walker = "";
                    
                    if ($tabBeritra[$s]['hpos'] == "?") $tabBeritra[$s]['hpos'] = "60";      
                    fwrite($hdlout,'   		        	<spot x="'.$tabBeritra[$s]['xpos'].'" y="'.$tabBeritra[$s]['ypos'].
                                   '" z="'.$tabBeritra[$s]['zpos'].'" h="'.$tabBeritra[$s]['hpos'].'"'.$walker.'/>'."\n");
                    $anzpos++;
                }
                
                $oldgrp = $tabBeritra[$s]['sort'];
                $oldpos = $tabBeritra[$s]['xpos'];
            }
            else
                $anzdopp++;
        }
        else
            $anznull++;
    }	
    
    if($oldnpc != "")
    {
        fwrite($hdlout,"                </spawn>\n");
        fwrite($hdlout,"            </beritra_type>\n");
        fwrite($hdlout,"        </beritra_spawn>\n");
    }
    
	fwrite($hdlout,'    </spawn_map>'."\n");
    fwrite($hdlout,'</spawns>');
    
    fclose($hdlout);
    
    logLine("ignorierte NPCs/Spawns",$anznull);
    logLine("doppelte NPCs/Spawns",$anzdopp);
    logLine("ausgegebene Spawns",$anzpos);
    logLine("ausgegebene NPCs",$anznpcs);
}
// ----------------------------------------------------------------------------
// zu den ausgegebenen Walkern das Walker-File ausgeben
// ----------------------------------------------------------------------------
function generWalkerFile()
{
    global $pathdata, $pathsvn, $tabWalker, $welt, $tabWorldmaps;
        
    if (count($tabWalker) == 0)
        return;
        
    $outfile = formFileName("../outputs/spawn_output/npc_walker/walker_".$welt."_".$tabWorldmaps[$welt]['name'].".xml");
    $oldfile = $pathsvn."\\trunk\\AL-Game\\data\\static_data\\npc_walker\\".basename($outfile);
    $posOK   = false;
    
    if (getPosTabFromOldFile($oldfile,"<routestep"))
        $posOK = true;
    
    $csvfile = formFileName($pathdata."\\World\waypoint.csv");
    $hdlin   = openInputFile($csvfile);
    $hdlout  = openOutputFile($outfile);
    
    logHead("Erzeuge Walker-Datei");
    logLine("Ausgabedatei",$outfile);
    
    $anzwalk = 0;
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="utf-8"?>'."\n");
    fwrite($hdlout,'<npc_walker xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="npc_walker.xsd">'."\n");
    
    $line = fgets($hdlin);   // 1. Zeile überlesen, da Spaltennamen
    
    // Aufbau: name,num,x,y,z...
    //         0    1   2 3 4
    while (!feof($hdlin))
    {
        $line = rtrim(fgets($hdlin));
        $ltab = explode(",",$line);
        $lmax = count($ltab);
        
        if ($lmax > 3)
        {
            // wurde diese Route auch genutzt bei der Span-Generierung?
            $wkey = strtoupper($ltab[0]);
            
            if (isset($tabWalker[$wkey]))
            {
                $rows = "";
                $pool = intval($tabWalker[$wkey]['pool']);
                $anzwalk++;
                
                if ($pool > 1)
                {
                    $r1 = intval($pool / 2);
                    $r2 = $pool - $r1;
                    
                    $rows = ' formation="SQUARE" rows="'.$r1.','.$r2.'"';
                } 
                fwrite($hdlout,"    <!-- SHA-Tag: ".strtoupper(sha1(strtolower($wkey)))." -->\n");
                fwrite($hdlout,"    <!-- NPC-IDs: ".$tabWalker[$wkey]['npcs']." -->\n");                
                fwrite($hdlout,'    <walker_template route_id="'.$wkey.'" pool="'.$pool.'"'.$rows.'>'."\n");
                
                $step = 1;
                
                for ($p=2;$p<$lmax;$p+=3)
                {
                    if ($posOK)
                        $ltab[$p + 2] = getOldZPosFromTab($ltab[$p],$ltab[$p + 1],$ltab[$p + 2]);
                    fwrite($hdlout,'        <routestep step="'.$step.'" x="'.$ltab[$p].'" y="'.$ltab[$p + 1].'" z="'.$ltab[$p + 2].'"/>'."\n");
                    $step++;
                }
                fwrite($hdlout,'    </walker_template>'."\n");
            }
        }
    }
    // Nachspann ausgeben
    fwrite($hdlout,'</npc_walker>');
    
    fclose($hdlout);
    fclose($hdlin);
    
    logLine("ausgegebene Walker-Routen",$anzwalk);
}
// ----------------------------------------------------------------------------
// Static-Datei für die Hauptstädte / Housing-Gebiete erzeugen
// ----------------------------------------------------------------------------
function generStaticFile()
{
    global $pathlevels, $welt, $tabWorldmaps;

    if (!checkIsStaticMap($welt))
        return;
        
    $tabstats = array();
    $cntstats = 0; 
        
    $filemission = formFileName($pathlevels."\\".$tabWorldmaps[$welt]['offiname']."\\mission_mission0.xml");
    
    logHead("Ermitteln Statics aus Datei: mission_mission0.xml");
    logLine("Welt-Offi-Name",$tabWorldmaps[$welt]['offiname']);
    logLine("Eingabedatei",$filemission);
    
    flush();

    $hdlin = openInputFile($filemission);
    $inent = false;
    $eclass = "";
    $etype  = "";
    $epos   = "";
    $eid    = "";
    $anzitm = 0;
    
    while (!feof($hdlin))
    {
        $line = rtrim(fgets($hdlin));
        
        if (stripos($line,"</Entity>") !== false)
            $inent = false;
            
        if (stripos($line,"<Entity") !== false && stripos($line,"EntityClass") !== false)
        {
            $eclass = strtoupper(getKeyValue("EntityClass",$line));
            $inent  = checkIsStaticClass($eclass);
            
            if ($inent)
            {            
                $epos = getKeyValue("Pos",$line);
                $eid  = getKeyValue("EntityId",$line);
            }
        }
        else
        {
            if ($inent  &&  stripos($line,"<Properties") !== false)
            {
                $etype = strtoupper(getKeyValue("craftObjectType_CraftObjectType",$line));
                $eitem = getStaticItemData($eclass,$etype);
                
                if ($eitem['id'] != "")
                {
                    $etab = explode(",",$epos);
                    
                    $tabstats[$cntstats]['sort'] = $eitem['id']."_".getSortNumValue($etab[0]);
                    $tabstats[$cntstats]['item'] = $eitem['id'];
                    $tabstats[$cntstats]['xpos'] = $etab[0];
                    $tabstats[$cntstats]['ypos'] = $etab[1];
                    $tabstats[$cntstats]['zpos'] = $etab[2];
                    $tabstats[$cntstats]['id']   = $eid;
                    $tabstats[$cntstats]['name'] = $eitem['name'];
                    
                    $cntstats++;
                    $anzitm++;
                }
            }                    
        }            
    }
    fclose($hdlin);
    
    logLine("gefundene Statics",$anzitm);
    
    sort($tabstats);
            
    $outfile = formFileName("../outputs/spawn_output/Statics/".$welt."_".$tabWorldmaps[$welt]['name'].".xml");    
    $hdlout = openOutputFile($outfile);
    
    logHead("Erzeuge Statics-Datei");
    logLine("Ausgabedatei",$outfile);
    
    $domax  = count($tabstats);
    $oldgrp = "";
    $anzout = 0;
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
    fwrite($hdlout,'<spawns>'."\n");
    fwrite($hdlout,'    <spawn_map map_id="'.$welt.'">'."\n");
    
    for ($s=0;$s<$domax;$s++)
    {
        if ($oldgrp != $tabstats[$s]['item'])
        {   
            if ($oldgrp != "")
                fwrite($hdlout,'        </spawn>'."\n");
                
            fwrite($hdlout,'        <!-- '.$tabstats[$s]['name'].' -->'."\n");    
            fwrite($hdlout,'        <spawn npc_id="'.$tabstats[$s]['item'].'" handler="STATIC">'."\n");
            
            $oldgrp = $tabstats[$s]['item'];
        }
        $anzout++;
        // <spot x="1386.846" y="1750.614" z="101.566" static_id="1779"/>
        fwrite($hdlout,'            <spot '.
                       'x="'.$tabstats[$s]['xpos'].'" '.
                       'y="'.$tabstats[$s]['ypos'].'" '.
                       'z="'.$tabstats[$s]['zpos'].'" '.
                       'static_id="'.$tabstats[$s]['id'].'"/>'."\n");                       
    }
    
    fwrite($hdlout,"        </spawn>\n");
    fwrite($hdlout,"    </spawn_map>\n");
    fwrite($hdlout,"</spawns>");
    fclose($hdlout);
    
    logLine("ausgegebene Static-Spawns",$anzout);
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------

$buttStyle = ' style="width:153px;padding:0px;" ';
$buttHome  = ' style="width:153px;padding:0px;background-color:dodgerblue;" ';
$tabKeys   = array();
$tabSpawn  = array();
$tabWalker = array();
$tabBeritra= array();
$tabEntity = array();

$cntSpawn  = 0;
$cntBeritra= 0;

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

$starttime = microtime(true);
logStart();

if (!file_exists("includes/auto_inc_npc_infos.php"))
    makeIncludeNpcInfos();    

include("includes/auto_inc_npc_infos.php");

if (!$doneGenerInclude)
{
    if ($submit == "J" && $welt != "")
    {   
        if ($pathlevels == "" || $pathdata == "")
        {
            logLine("ACHTUNG","die Pfade sind anzugeben");
        }
        else
        {
            logHead("Generierung erfolgt zur Map: $welt");
            
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
            
            generBeritraFile();
            generSpawnFile();
            generWalkerFile();
            generStaticFile();
            
            cleanPathUtf8Files();
        }
    }    
}
else
{
    logSubHead("<br><br><div style='background-color:#000033;border:1px solid silver;padding:20px;text-align:center;'>".
               "WICHTIGER HINWEIS<br><br>".    
               "Die Vorarbeiten zum Erzeugen der Includes sind abgeschlossen.<br><br>".
               "Bitte die <font color=magenta>Generierung erneut starten</font>!<br><br><br>".                       
               "<a href='genSpawns.php' target='_self'><input type='button' name='doneu' value='Erneut starten'></a><br></div>");
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