<?PHP
// ----------------------------------------------------------------------------
// Modul   : checkGather.php
// Version : 1.00, Mariella, 01/2016
// Zweck   : überprüft Gather-Spawns in der bestehenden Gather-Datei und fügt
//           fehlende Angaben ggfs. hinzu
// ----------------------------------------------------------------------------
include("../includes/inc_globals.php");
 
$selfname = basename(__FILE__);
$infoname = "Checken PS-Gather-Dateien";

// ----------------------------------------------------------------------------
// zur angegebenen ID den Namen des NPC ermitteln
// ----------------------------------------------------------------------------
function getGatherName($id)
{
    global $tabgather;
    
    if (isset($tabgather[$id]))
        return $tabgather[$id];
    else
        return $id;
}
// ----------------------------------------------------------------------------
// Gather-Npc-Name-Id ermitteln
// ----------------------------------------------------------------------------
function scanGatherNpcNames()
{
    global $pathsvn;
            
    $fileincl = "check_temp/inc_tabgather.php";
    $tabnames = array();
    $cnt      = 0;
   
    logHead("Erzeugen Include $fileincl");
    
    if (file_exists($fileincl))
    {
        logLine("Datei vorhanden","Wird nicht neu erzeugt");
        
        return;
    }
    
    $filename = formFileName($pathsvn."\\trunk\\AL-Game\\data\\static_data\\gatherables\\gatherable_templates.xml");
            
    $anzles   = 0;
    $anzids   = 0;
    
    logLine("- Scanne XML-Datei",$filename);
    logFileSize("- ",$filename);
    
    flush();
    
    $hdlstr = openInputFile($filename);
    $npcid = "";
    $nname = "";
    
    while (!feof($hdlstr))
    {
        $line = trim(fgets($hdlstr));
        $anzles++;
        
        if (stripos($line,"<gatherable_template ") !== false)
        {        
            $npcid = getKeyValue("id"  ,$line);
            $nname = getKeyValue("name",$line);
            
            $tabnames[$cnt]['id']   = $npcid;
            $tabnames[$cnt]['name'] = $nname;
            $anzids++;
            $cnt++;
                
            $npcid = $nname = "";
        }
    }
    fclose($hdlstr);
    
    logLine("- gelesene Zeilen",$anzles);
    logLine("- erkannte NPCs  ",$anzids);     
    
    sort($tabnames);
    
    if ($hdlout = openOutputFile($fileincl))
    {        
        $lastline = "";
        $leer     = "                   ";
        $anzids   = 0;
        
        logSubHead("Erzeuge Include $fileincl");

        fwrite($hdlout,"<?PHP\n");
        fwrite($hdlout,"\$tabgather = array(\n");
        
        $max     = count($tabnames);
        for ($i=0;$i<$max;$i++)
        {
            $anzids++;
            
            if ($lastline != "")
                fwrite($hdlout,$lastline."\n");
                
            $lastline = $leer.'"'.$tabnames[$i]['id'].'" => "'.$tabnames[$i]['name'].'",';
        }
        fwrite($hdlout,$lastline."\n");
        fwrite($hdlout,"                  );\n");
        fwrite($hdlout,"?>");
        
        fclose($hdlout);
        
        logLine("ausgegebene NpcIds",$anzids);
    }
}
// ----------------------------------------------------------------------------
// NPC in die interne Tabelle übernehmen
// ----------------------------------------------------------------------------
function addNpcToTab($mapid,$npcid,$posx,$posy,$posz)
{
    global $tabnpcs,$cntnpcs;
    
    if ($npcid >= "400000"  &&  $npcid <= "410000")
    {
        $tabnpcs[$cntnpcs]['sort']  = $mapid."_".$npcid."_".getSortNumValue(round((float)$posx,2))."_".getSortNumValue(round((float)$posy,2));
        $tabnpcs[$cntnpcs]['mapid'] = $mapid;
        $tabnpcs[$cntnpcs]['npcid'] = $npcid;
        $tabnpcs[$cntnpcs]['posx']  = $posx;
        $tabnpcs[$cntnpcs]['posy']  = $posy;
        $tabnpcs[$cntnpcs]['posz']  = $posz;
        
        $cntnpcs++;
        
        return 1;
    }
    return 0;
}
// ----------------------------------------------------------------------------
// Map in die interne Tabelle übernehmen (in der Regel nur 1 Map !!!)
// ----------------------------------------------------------------------------
function addMapToTab($mapid)
{
    global $tabmapid, $cntmapid;
    
    $fnd = false;
    $max = count($tabmapid);
    
    for ($m=0;$m<$max;$m++)
    {
        if ($tabmapid[$m]['mapid'] == $mapid)
            $fnd = true;
    }
    
    if ($fnd == false)
    {
        $tabmapid[$cntmapid]['mapid'] = $mapid;
        $tabmapid[$cntmapid]['mfile'] = "";
        $cntmapid++;
    }
}
// ----------------------------------------------------------------------------
// Gather-Datei einlesen
// ----------------------------------------------------------------------------
function getGatherInfos($filename)
{ 
    global $tabmapid;
    
    logLine("- Eingabedatei",$filename);
    logFileSize("- ",$filename);
    
    // <spawns>
    //  <spawn_map map_id="210010000">
    //    <spawn npc_id="400601" respawn_time="295">
    //      <spot x="1138.4298" y="1011.0849" z="131.4075"/>
    
    $anzles = 0;
    $anznpc = 0;
    $anzpos = 0;
    
    $mapid  = "";
    $maptx  = "";
    $npcid  = "";
    $posx   = "";
    $posy   = "";
    $posz   = "";
    
    if ($hdlin = openInputFile($filename))
    {
        while (!feof($hdlin))
        {
            $line = fgets($hdlin);
            $anzles++;
            
            if     (stripos($line," map_id") !== false)
            {
                $mapid  = getKeyValue("map_id",$line);
                $anzpos = 0;
            }
            elseif (stripos($line,"</spawn_map") !== false)
            {
                if ($anzpos > 0)
                {
                    addMapToTab( $mapid );
                    $maptx .= $mapid." ";
                }    
            }
            elseif (stripos($line," npc_id") !== false)
            {
                $npcid = getKeyValue("npc_id",$line); 
                $anznpc++;
            }
            elseif (stripos($line,"<spot") !== false)
            {
                $posx = getKeyValue("x",$line);
                $posy = getKeyValue("y",$line);
                $posz = getKeyValue("z",$line);
                
                $anzpos += addNpcToTab($mapid,$npcid,$posx,$posy,$posz);
            }            
        }
    }
    fclose($hdlin);
    
    logLine("gefundene MapId",$maptx);
    logLine("Zeilen eingelesen",$anzles);
    logLine("Gather-NPCs gefunden",$anznpc);
}
// ----------------------------------------------------------------------------
// PS-Gather-Datei einlesen
// ----------------------------------------------------------------------------
function getGatherInfosFromPs()
{
    global $psfile, $tabmapid;
        
    logHead("Scannen PS-Gather-File");
    
    getGatherInfos($psfile);
    
    sort( $tabmapid );
}
// ----------------------------------------------------------------------------
// SVN-Gather-Datei einlesen
// ----------------------------------------------------------------------------
function getGatherInfosFromSvn()
{
    global $pathsvn,$tabmapid;
    
    $svnpath = formFileName($pathsvn."\\trunk\\AL-Game\\data\\static_data\\spawns\\Gather");
    $files   = scandir($svnpath);
    $max     = count($files);
    $maxmap  = count($tabmapid);
    
    for ($f=0;$f<$max;$f++)
    {
        for ($m=0;$m<$maxmap;$m++)
        {
            if (substr($files[$f],0,9) == $tabmapid[$m]['mapid'])
            {
                $tabmapid[$m]['mfile'] = formFileName($svnpath."\\".$files[$f]);
                $m = $maxmap;
            }
        }
    }
    
    for ($m=0;$m<$maxmap;$m++)
    {
        logHead("Scannen SVN-Gather-File zur MapID ".$tabmapid[$m]['mapid']);
        
        if (file_exists($tabmapid[$m]['mfile']))
            getGatherInfos($tabmapid[$m]['mfile']);
        else
            logLine("Eingabedatei","Zu dieser MapId ist keine Datei vorhanden");
    }
}
// ----------------------------------------------------------------------------
// neue SVN-Gather-Datei ausgeben
// ----------------------------------------------------------------------------
function putNewGatherFile()
{
    global $tabnpcs,$tabgather,$tabmapid;
    
    $maxmap  = count($tabmapid);
    $outfile = "";
    
    sort( $tabnpcs );
    
    for ($m=0;$m<$maxmap;$m++)
    {
        if ($tabmapid[$m]['mfile'] != "")
            $outfile = formFileName("..\\outputs\\check_output\\".basename($tabmapid[$m]['mfile']));
        else
            $outfile = formFileName("..\\outputs\\check_output\\".$tabmapid[$m]['mapid']."_Gather.xml");
            
        logHead("Erzeuge neue Gather-Datei zu MapId ".$tabmapid[$m]['mapid']);
        logLine("- Ausgabedatei",$outfile);
        
        $anzout = 0;
        $anzdup = 0;
        $anznpc = 0;
        
        if ($hdlout = openOutputFile($outfile))
        {
            // Vorspann ausgeben
            fwrite($hdlout,"<?xml version='1.0' encoding='UTF-8'?>\n");
            fwrite($hdlout,"<spawns>\n");
            fwrite($hdlout,'    <spawn_map map_id="'.$tabmapid[$m]['mapid'].'">'."\n");
            
            $anzout += 3;
            $oldnpc = "";
            $oldgrp = "";
            $maxnpc = count($tabnpcs);
            
            // Gather-Spawns ausgeben
            for ($i=0;$i<$maxnpc;$i++)
            {
                if ($tabnpcs[$i]['mapid'] == $tabmapid[$m]['mapid'])
                {
                    if ($oldgrp != $tabnpcs[$i]['sort'])
                    {
                        if ($oldnpc != $tabnpcs[$i]['npcid'])
                        {
                            if ($oldnpc != "")
                            {
                                fwrite($hdlout,"        </spawn>\n");
                                $anzout++;
                            }
                            
                            $oldnpc = $tabnpcs[$i]['npcid'];
                            $anznpc++;
                            
                            fwrite($hdlout,"        <!-- ".getGatherName($oldnpc)." -->\n");
                            fwrite($hdlout,'        <spawn npc_id="'.$oldnpc.'" respawn_time="105">'."\n");
                            $anzout += 2;
                        }
                        fwrite($hdlout,'            <spot x="'.$tabnpcs[$i]['posx'].'" y="'.
                                       $tabnpcs[$i]['posy'].'" z="'.$tabnpcs[$i]['posz'].'"/>'."\n");
                        $anzout++;
                        
                        $oldgrp = $tabnpcs[$i]['sort'];
                    }
                    else
                        $anzdup++;
                }
            }
            // Nachspann ausgeben
            fwrite($hdlout,"        </spawn>\n");
            fwrite($hdlout,"    </spawn_map>\n");
            fwrite($hdlout,"</spawns>");
            $anzout += 3;
            fclose($hdlout);
        }
        
        logLine("Zeilen geschrieben",$anzout);
        logLine("NPCs ausgegeben",$anznpc);
        logLine("Duplikate ignoriert",$anzdup);
    }
}
// ----------------------------------------------------------------------------
// Include für die gescannten Infos ausgeben
// ----------------------------------------------------------------------------
function putNpcInclude($act)
{
    global $tabnpcs;
    
    $tabkeys  = array("id","name","desc","npc_title","dir","npc_function_type","ui_type",
                      "ui_race_type","head","torso","leg","foot","shoulder","glove","main",
                      "sub","front","side","upper","scale","move_speed_normal_walk",
                      "move_speed_normal_run","move_speed_combat_run","cursor_type",
                      "talking_distance","hpgauge_level","attack_delay","ai_name","tribe",
                      "race_type","sensory_range","attack_range","attack_rate","npc_type",
                      "ment","float_corpse","abyss_npc_type",     
    // Tabelle mit fehlenden Schlüsselbegriffen im Client
                      "level","maxhp","maxxp","nameid","rank","rating","main_hand_attack",
                      "main_hand_accuracy","pdef","mresist","power","evasion","accuracy",
                      "race","type","on_mist","ai","state","npcname",
                      "titleid","func_dialogs","csvende");
    
    $fileincl = "parse_temp/inc_tabnpcs_$act.csv";
    
    if ($hdlout = openOutputFile($fileincl))
    {
        $lastline = "";
        $leer     = "                 ";
        $anzitm   = 0;
                
        $max      = count($tabnpcs);
        
        fwrite($hdlout,implode(";",$tabkeys)."\n");
        
        for ($i=0;$i<$max;$i++)
        {
            fwrite($hdlout,implode(";",$tabnpcs[$i])."\n");
        }
        
        fclose($hdlout);
    }
}
// ----------------------------------------------------------------------------
// Vorgaben in Sicherungs-Datei schreiben
// ----------------------------------------------------------------------------
function writeSavedData()
{
    global $psfile;
    
    $hdlout = openOutputFile("saved_data/lastcheckgather.txt");
    fwrite($hdlout,$psfile);
    fclose($hdlout);
}
// ----------------------------------------------------------------------------
//
//                                  M A I N
//
// ----------------------------------------------------------------------------
putHtmlHead("$selfname - $infoname","Checken PS-Gather-Infos");

logStart();

$starttime  = microtime(true);
$tabnpcs    = array();
$cntnpcs    = 0;
$tabmapid   = array();
$cntmapid   = 0;

$psfile     = isset($_GET['ifile']) ? $_GET['ifile'] : "";

writeSavedData();

if (getConfData())
{
    scanGatherNpcNames();
    
    include("check_temp/inc_tabgather.php");
    
    getGatherInfosFromPS();
    getGatherInfosFromSvn();
    
    putNewGatherFile();
    
    echo "   
  <tr><td colspan=3>
  <br><br><center><a href='index.php' target='_self'><input type='button' value='Hauptmenue'></a></center></td></tr>";
}
else
    logLine("Programm-Abbruch","Fehler in der Konfigurations-Datei");

logStop($starttime,true);
	
putHtmlFoot();
?>