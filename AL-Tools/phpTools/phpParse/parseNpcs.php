<?PHP
// ----------------------------------------------------------------------------
// Modul   : parseNpcs.php
// Version : 1.00, Mariella, 12/2015
// Zweck   : parsen der Client-Files zur Erzeugung der npc_templates.xml-Datei
// ----------------------------------------------------------------------------
// Ablauf  : 
// Schritt   Beschreibung                        erzeugt
// -------   ---------------------------------   ------------------------------
//     0     Start, Anzeige Hinweise             Hinweise
//     1     SVN-Npc-Templates scannen           parse_temp/inc_npcs_svn.php
//     2     Client-Npc-Infos scannen            parse_temp/inc_npc_scan.csv
//     3     Npc-Templates erzeugen              parse_output/npc_templates.php
// ----------------------------------------------------------------------------
include("../includes/inc_globals.php");
include("includes/auto_inc_npc_infos.php");
include("includes/auto_inc_title_names.php");
include("includes/inc_getautonameids.php");
 
$selfname = basename(__FILE__);
$infoname = "Erstellung der npc_templates.xml";

// durch Optimierungen zur 4.9-er Version fallen einige Dateien/Schritte weg
if (file_exists("parse_temp/inc_tabnames.php"))
    unlink("parse_temp/inc_tabnames.php");
if (file_exists("parse_temp/inc_tabitems.php"))
    unlink("parse_temp/inc_tabitems.php");
if (file_exists("parse_temp/inc_tabtemps.php"))
    unlink("parse_temp/inc_tabtemps.php");
    
if (!file_exists("../outputs/parse_output/npcs"))
    mkdir("../outputs/parse_output/npcs");
// ----------------------------------------------------------------------------
//
//                        H I L F S F U N K T I O N E N
//
// ----------------------------------------------------------------------------
//                        VERARBEITUNGS-ABLAUF-HANDLING
// ----------------------------------------------------------------------------
// Anzeigen Header zum aktuellen Verarbeitungsschritt
// ----------------------------------------------------------------------------
function showSchrittHead()
{
    global $schritt;
    
    $text = "<tr><td colspan=3><center><h1>Schritt $schritt - ";
    
    switch ($schritt)
    {
        case 8: $text  = "<tr><td colspan=3><center><h1>Hinweise - tempor&auml;re Dateien entfernt!"; break;
        case 9: $text  = "<tr><td colspan=3><center><h1>Hinweise - Npc-Parser-Dateien bereinigt!"; break;
        
        case 0: $text  = "<tr><td colspan=3><center><h1>Hinweise"; break;
        case 1: $text .= "SVN-Datei npc_templates.xml scannen"; break;
        case 2: $text .= "CSV-Datei mit Client-NPCs schreiben"; break;
        case 3: $text .= "Datei npc_templates.xml erzeugen"; break;
    }
    
    echo $text."</h1></center></td></tr>";
}
// ----------------------------------------------------------------------------
// Prüfen, welcher Schritt als nächstes möglich wäre
// ----------------------------------------------------------------------------
function getNextSchritt()
{
    global $outfiles, $tabsteps;
    
    $max = count($outfiles);
    
    $tabsteps[0] = "J"; // Hinweise
    $tabsteps[1] = "J"; // SVN-Npc-Templates scannen
    $tabsteps[2] = "N"; // Client-NPCs scannen
    $tabsteps[3] = "N"; // npc_templates.xml erzeugen
    
    for ($f=0;$f<$max;$f++)
    {
        if (file_exists($outfiles[$f][3]))
        {
            $tabsteps[$outfiles[$f][1]] = "J";
        }
    }    
}
// ----------------------------------------------------------------------------
//                   DATEN-UMSCHLÜSSELUNG/-ERMITTLUNG
// ----------------------------------------------------------------------------
// soll aus dem Text eine Bezeichnung für die "ai" erzeugen                
// ----------------------------------------------------------------------------
function getAiName($n)
{
    global $tabnpcs;
    
    $text = $tabnpcs[$n]['ai_name'];
    $ret  = strtolower($text);
    
    if (stripos($text,"_") !== false)
        $ret = strtolower(substr($text,0,stripos($text,"_")));
        
    $ret = str_replace("summon","",$ret);
    
    return $ret;
}
// ----------------------------------------------------------------------------
// Ermitteln Bezeichnung für die AI
// ----------------------------------------------------------------------------
function getAiText($n)
{
    global $tabnpcs;
    
    // ai aus tribe
    if (stripos($tabnpcs[$n]['tribe'],"AGGRESSIVE") !== false)
        return "agressive";
    
    // ai aus function_type    
    if ($tabnpcs[$n]['npc_function_type'] != "?" 
    &&  $tabnpcs[$n]['npc_function_type'] != "NONE")
    {
        switch(strtoupper($tabnpcs[$n]['npc_function_type']))
        {
            case "TELEPORT":
            case "MERCHANT":
            case "WAREHOUSE":
            case "VENDOR":
                return "general";
            case "BINDSTONE":
                return "resurrect";
            case "POSTBOX":
                return "postbox";
            default:
                break;
        }
    }
    
    // ai aus ai_name
    if ($tabnpcs[$n]['ai_name'] != "?")
    {
        $ai_name = strtolower($tabnpcs[$n]['ai_name']);
        
        if     (stripos($ai_name,"skillarea") !== false)
            return "skillarea";
        elseif (stripos($ai_name,"trap")      !== false)
            return "trap";
        elseif (stripos($ai_name,"merchant")  !== false)
            return "general";
        elseif (substr($ai_name,0,3) == "d2_"
        ||      substr($ai_name,0,4) == "nd2_")
            return "agressive";
        elseif ($ai_name == "summonhoming")
            return "homing";
        elseif ($ai_name == "summontotem")
            return "servant";
        elseif ($ai_name == "summoned")
            return "dummy";
        elseif ($ai_name == "groupgate")
            return "useitem";
    }
    
    // ai aus dir
    if ($tabnpcs[$n]['dir'] != "?")
    {
        if  (stripos($tabnpcs[$n]['dir'],"groupgate")  !== false)
            return "groupgate";
        elseif (stripos($tabnpcs[$n]['dir'],"monster") !== false)
            return "aggressive";
    }
    // Default: general
    return "general";
}
// ----------------------------------------------------------------------------
// Rasse für den NPC zurückgeben                                           
// ----------------------------------------------------------------------------
function getRaceText($n)
{
    global $tabnpcs;
    
    $text = $tabnpcs[$n]['race_type'];
    
    if ($text != "?")
    {
        if (stripos($text,"light") !== false) return "ELYOS";
        if (stripos($text,"dark")  !== false) return "ASMODIANS";
    }
    
    return "NONE";
}
// ----------------------------------------------------------------------------
// Typ für den NPC zurückgeben                                            
// ----------------------------------------------------------------------------
function getNpcType($n)
{
    global $tabnpcs;
    
    $curs = $tabnpcs[$n]['cursor_type'];
    $type = $tabnpcs[$n]['npc_type'];
    $name = $tabnpcs[$n]['desc'];
    
    $ret = "";
    
    if     (stripos($name,"TELEPORTER")    !== false
    ||      stripos($name,"GROUPGATE")     !== false
    ||      stripos($name,"DRAGONPORTAL")  !== false)
        $ret = "PORTAL";
    elseif (stripos($name,"_ARTIFACT_")    !== false)
        $ret = "ARTIFACT";
    elseif (stripos($name,"BINDING_STONE") !== false
    ||      stripos($name,"TEST_RESURRECT")!== false
    ||      stripos($type,"BINDSTONE")     !== false)
        $ret = "RESURRECT";
    elseif (stripos($type,"POSTBOX")       !== false)
        $ret = "POSTBOX"; 
    elseif (stripos($curs,"NONE")          !== false
    ||      stripos($curs,"TALK")          !== false
    ||      stripos($curs,"TRADE")         !== false)
        $ret = "NON_ATTACKABLE";
    elseif (stripos($curs,"ACTION")        !== false)
        $ret = "USEITEM";
    elseif (stripos($curs,"ATTACK")        !== false)
        $ret = "ATTACKABLE";
    else
        $ret = "NON_ATTACKABLE";
        
    return $ret;
}
// ----------------------------------------------------------------------------
// gibt, wenn Wert vorhanden (also != "?") den XML-String zurück
// Beispiel getOutText("id","10) => id="10"
// ----------------------------------------------------------------------------
function getOutText($key,$value)
{
    if ($value != "?"  &&  trim($value) != "")
        return ' '.$key.'="'.$value.'"';
    else
        return "";
}
// ----------------------------------------------------------------------------
// Erzeugt, wenn vorhanden, die Zeilen für das Equipment
// ----------------------------------------------------------------------------
function getEquipLines($n)
{
    global $tabnpcs;
    
    $ret = "";
    $fld = array("head","torso","leg","foot","shoulder","glove","main","sub");;
    $max = count($fld);
    
    for ($e=0;$e<$max;$e++)
    {
        if ($tabnpcs[$n][$fld[$e]] != "?")
        {
            $id   = getClientItemId($tabnpcs[$n][$fld[$e]]);
            
            if ($id != "000000000")
                $ret .= "            <item>".$id."</item>\n";
        }
    }
    if ($ret != "")
    {
        $ret = "        <equipment>\n".$ret."        </equipment>";
        return $ret;
    }
    else
        return "?";
}
// ----------------------------------------------------------------------------
// erzeugt, wenn vorhanden, die Zeile für die Speed-Angaben
// ----------------------------------------------------------------------------
function getSpeedLine($n)
{
    global $tabnpcs;
    
    // Speed-Zeile
    $speed = getOutText("walk",$tabnpcs[$n]['move_speed_normal_walk']).
             getOutText("run" ,$tabnpcs[$n]['move_speed_normal_run']).
             getOutText("run_fight",$tabnpcs[$n]['move_speed_combat_run']);
    
    if (trim($speed) != "")
        return $speed;
    else
        return "?";
}
// ----------------------------------------------------------------------------
// erzeugt, wenn vorhanden, die Zeile für die TalkInfo-Angaben
// ----------------------------------------------------------------------------
function getTalkLine($n)
{
    global $tabnpcs;
    
    $ret = "";
    $dist = $func = $dial = $delay = "";
    
    // Talk-Distanz
    if ($tabnpcs[$n]['talking_distance'] != "?"  
    &&  $tabnpcs[$n]['talking_distance'] != "0")
    { 
        $dist = getOutText("distance",$tabnpcs[$n]['talking_distance']);
    }
    
    $delay = getOutText("delay",$tabnpcs[$n]['talk_delay_time']);    
    
    // Funktions-Dialog ?
    $func = getOutText("func_dialogs",$tabnpcs[$n]['func_dialogs']);
    
    // IsDialog?
    if ($dist != "" || $delay != "" || $func != "")
    {
        // TEST für is_dialog
        $isdialog = "";
        
        if (($tabnpcs[$n]['cursor_type'] == "talk"
        ||   $tabnpcs[$n]['cursor_type'] == "trade"
        ||   $tabnpcs[$n]['cursor_type'] == "merchant"
        ||   $tabnpcs[$n]['cursor_type'] == "action")
        ||   $func != "")
            $dial = ' is_dialog="true"';
            
        $ret = '        <talk_info'.$dist.$delay.$dial.$func.'/>';
    } 
    else
        $ret = "?";
        
    return $ret;
}
// ----------------------------------------------------------------------------
// Fehlende Werte ersetzen, sofern in der alten npc_templates vorhanden
// ----------------------------------------------------------------------------
function getMissingValues($n)
{
    global $tabnpcs,$tabtemps;    
    
    $fields  = array("npc_id","level","desc","rank","rating","race","tribe","type","ai",
                     "floatcorpse","on_mist","state","maxhp","maxxp","main_hand_attack",
                     "main_hand_accuracy","pdef","mresist","power","evasion","accuracy",
                     "func_dialogs"
                     // nur TEST
                     // "move_speed_normal_walk","move_speed_normal_run","move_speed_combat_run"
                     );
                     
    $max     = count($fields);
    $key     = $tabnpcs[$n]['id'];
    
    // Neu in 4.9 (NPC-Name und NameId ermitteln
    $xtab    = getNpcIdNameTab($tabnpcs[$n]['name']);
    // NameId ermitteln
    if (isset($xtab['namid']))
        $tabnpcs[$n]['nameid']   = $xtab['namid']; //getNpcNameId($tabnpcs[$n]['desc']);
    // NPC-Name ermitteln
    if (isset($xtab['nname']))
        $tabnpcs[$n]['npcname']  = $xtab['nname']; 
    
    if (isset($tabtemps[$key]))
    {        
        for ($f=0;$f<$max;$f++)
        {
            $tabnpcs[$n][$fields[$f]] = $tabtemps[$key][$fields[$f]];
        }
    }
    else
    {
        // der NAME wird als NAME_DESC ausgegeben
        $tabnpcs[$n]['desc']          = $tabnpcs[$n]['name'];
    }
}
// ----------------------------------------------------------------------------
// Default-Values für Werte setzen, die nicht vom Client geliefert werden
// ----------------------------------------------------------------------------
function getDefaultValues($n)
{
    global $tabnpcs,$tabdefs,$flddefs;
    
    $max    = count($flddefs);
    
    for ($d=0;$d<$max;$d++)
    {
        if ($tabnpcs[$n][$flddefs[$d]] == "?") 
            $tabnpcs[$n][$flddefs[$d]]  = $tabdefs[$flddefs[$d]];
    }
}
// ----------------------------------------------------------------------------
// spezielle Werte ermitteln
// (hier wird versucht, aus diversen Feldern einen Wert zu ermitteln)
// ----------------------------------------------------------------------------
function getSpecialValues($n)
{
    global $tabnpcs;
    
    if ($tabnpcs[$n]['ai_name']   == "?")  $tabnpcs[$n]['ai_name']    = getAiName($n);
    if ($tabnpcs[$n]['ai']        == "?")  $tabnpcs[$n]['ai']         = getAiText($n);
    if ($tabnpcs[$n]['race']      == "?")  $tabnpcs[$n]['race']       = getRaceText($n);
    if ($tabnpcs[$n]['type']      == "?")  $tabnpcs[$n]['type']       = getNpcType($n);
}
// ----------------------------------------------------------------------------
// neuen NPC in der Tabelle vorinitialisieren (alle Felder = "?" setzen)
// ----------------------------------------------------------------------------
function initNpcInTab($keys,$none)
{
    global $tabnpcs,$cntnpcs;
    
    $max = count($keys);
    for ($f=0;$f<$max;$f++)
        $tabnpcs[$cntnpcs][$keys[$f]] = "?";
    
    $max = count($none);    
    for ($f=0;$f<$max;$f++)
        $tabnpcs[$cntnpcs][$none[$f]] = "?";
        
    $tabnpcs[$cntnpcs]['csvende'] = "~#~";
}
// ----------------------------------------------------------------------------
// Hinweise anzeigen
// ----------------------------------------------------------------------------
function showHinweise()
{   
    $thl = "th style='font-size:14px;text-align:left;color:orange;padding-left:10px'";
    $thr = "th style='font-size:14px;text-align:right;color:orange;'";
    $thc = "th style='font-size:14px;text-align:center;color:orange;'";
    $tdl = "td style='text-align:left;color:yellow;padding-left:10px'";
    $tdr = "td style='text-align:right;color:yellow'";
    $tdc = "td style='text-align:center;color:yellow'";
    $cli = "<font color='lime'>";
    $cle = "</font>";
    
    echo "
  <tr>
    <td colspan=3>
      <span style='font-size:14;line-height:17px;color:orange;'>
      Aufgrund dessen, dass diese Verarbeitung sowohl zeit- als auch speicherintensiv ist,
      l&auml;uft sie in mehreren Schritten ab. Nach jedem Schritt wird eine Schaltfl&auml;che 
      angezeigt, die durch Bet&auml;tigung den n&auml;chsten Schritt veranlasst (Zeitangaben sind
      nur Anhaltswerte):<br>
      <center><br>
      <table width=80%>
        <tr><$thc>Schritt</th><$thr>ca. Zeit</th><$thl>Aktion</th><$thl>erzeugt</th></tr>
        <tr><$tdc>1</td><$tdr>48 sec.</td><$tdl>Scannen alte npc_templates.xml</td><$tdl>parse_temp/inc_npcs_svn.php</td></tr>
        <tr><$tdc>2</td><$tdr>210 sec.</td><$tdl>Scannen Client-Npc/-Monster-XML-Dateien</td><$tdl>parse_temp/inc_tabnpcs_scan.csv</td></tr>
        <tr><$tdc>$cli 3$cle</td><$tdr>43 sec.</td><$tdl>$cli Erzeugen neue NPC-Templates.xml-Datei$cle</td><$tdl>$cli outputs/parse_output/npc_templates.xml$cle</td></tr>
        <tr><$tdc>Gesamt</td><$tdr>303 sec.</td><$tdl colspan=2>(also ca. 5 Minuten f&uuml;r alle Schritte)</td></tr>
      </table>
      </center>
      <br>
      Beim Start eines Schrittes (< 3) werden alle Zwischendateien der Folgeschritte entfernt. Unten werden
      die Schaltfl&auml;chen zu den aktuell m&ouml;glichen Schritten angezeigt. Es kann jeweils
      mit dem h&ouml;chsten Schritt fortgefahren werden. Sofern sich Anpassungen an der Datei
      npc_templates.xml im SVN ergeben haben, muss aber wieder mit Schritt 1 begonnen werden!
      <br><br>
      <center>
      <br>Mittels &nbsp;&nbsp;&nbsp;
      <a href='parseNpcs.php?schritt=9' target='_self'><input type='button' value='Bereinigen' style='width:100px;background-color:yellow'></a>
       &nbsp;&nbsp;&nbsp; werden alle bestehenden Zwischendateien entfernt, es wird also alles neu erzeugt!
      </span>
      </center>
    </td>
  </tr>";
}
// ----------------------------------------------------------------------------
//
//                              S C H R I T T   1
//
// ----------------------------------------------------------------------------
// die bestehende SVN-Datei npc_templates.xml scannen für nicht gelieferte Werte
// ----------------------------------------------------------------------------
function scanOldNpcTemplates()
{
    global $pathsvn;
        
    $fileincl = "parse_temp/inc_npcs_svn.php";
    $tabnames = array();
    $cnt      = 0;
    
    // get-Fields von npc_templates
    $gfields1  = array("npc_id","level","name","name_desc","rank","rating","race","tribe","type","ai","floatcorpse","on_mist","state");
    $gfields2  = array("maxhp","maxxp","main_hand_attack","main_hand_accuracy","pdef","mresist","power","evasion","accuracy");
    $gfields3  = array("func_dialogs");
    // put-Fields für Missing-Values
    $pfields1  = array("npc_id","level","name","desc","rank","rating","race","tribe","type","ai","floatcorpse","on_mist","state");
    $pfields2  = array("maxhp","maxxp","main_hand_attack","main_hand_accuracy","pdef","mresist","power","evasion","accuracy");
    $pfields3  = array("func_dialogs");
    
    $max1     = count($gfields1);
    $max2     = count($gfields2);
    $max3     = count($gfields3);
        
    $tabtemps = array();
    $cnttemps = 0;
    
    logHead("Erzeugen Include $fileincl");
    
    $filename = str_replace("\\\\","\\",$pathsvn."\\trunk\\AL-Game\\data\\static_data\\npcs\\npc_templates.xml");
                
    $anzles   = 0;
    $anznpc   = 0;
    
    logSubHead("Scanne Npc-Templates-Datei ".$filename);
    logFileSize("- ",$filename);
    
    flush();
    
    $hdlstr = openInputFile($filename);
    
    for ($f=0;$f<$max1;$f++) $tabtemps[$cnttemps][$pfields1[$f]] = "?";
    for ($f=0;$f<$max2;$f++) $tabtemps[$cnttemps][$pfields2[$f]] = "?";
    for ($f=0;$f<$max3;$f++) $tabtemps[$cnttemps][$pfields3[$f]] = "?";
    
    while (!feof($hdlstr))
    {
        $line = trim(fgets($hdlstr));
        $anzles++;
        
        // NPC abgeschlossen, Tabelle auf nächsten Index setzen
        if     (stripos($line,"</npc_template>") !== false)
            $cnttemps++;        
        elseif (stripos($line,"<npc_template ") !== false)
        {
            $anznpc++;
            
            // neuen NPC initialisieren
            for ($f=0;$f<$max1;$f++) $tabtemps[$cnttemps][$pfields1[$f]] = "?";
            for ($f=0;$f<$max2;$f++) $tabtemps[$cnttemps][$pfields2[$f]] = "?";
            for ($f=0;$f<$max3;$f++) $tabtemps[$cnttemps][$pfields3[$f]] = "?";
            
            // Daten selektieren
            for ($f=0;$f<$max1;$f++)
            {
                if (stripos($line,$gfields1[$f]."=") !== false)
                {
                    $tabtemps[$cnttemps][$pfields1[$f]] = getKeyValue($gfields1[$f],$line);
                }
            }
        }   
        elseif (stripos($line,"<stats ") !== false)
        {
            // Daten für stats selektieren
            for ($f=0;$f<$max2;$f++)
            {
                if (stripos($line,$gfields2[$f]."=") !== false)
                {
                    $tabtemps[$cnttemps][$pfields2[$f]] = getKeyValue($gfields2[$f],$line);
                }
            }
        }
        elseif (stripos($line,"<talk_info") !== false)
        {
            // Daten für talk_info selektieren
            for ($f=0;$f<$max3;$f++)
            {
                if (stripos($line,$gfields3[$f]."=") !== false)
                {
                    $tabtemps[$cnttemps][$pfields3[$f]] = getKeyValue($gfields3[$f],$line);
                }
            }
        }
    }
    fclose($hdlstr);
    
    logLine("- gelesene Zeilen",$anzles);
    logLine("- erkannte NPCs  ",$anznpc);
     

    sort($tabtemps);

    if ($hdlout = openOutputFile($fileincl))
    {        
        $lastline = "";
        $leer     = "                  ";
        $anznpc   = 0;
        
        logSubHead("Erzeuge Include $fileincl");

        fwrite($hdlout,"<?PHP\n");
        fwrite($hdlout,"\$tabtemps = array(\n");
        
        $max     = count($tabtemps);
        for ($i=0;$i<$max;$i++)
        {
            $anznpc++;
            $trenn = "";
            
            if ($lastline != "")
                fwrite($hdlout,$lastline."),\n");
                
            $lastline = $leer.'"'.$tabtemps[$i]['npc_id'].'" => array(';
            
            for ($f=0;$f<$max1;$f++)
            {
                $lastline .= $trenn.' "'.$pfields1[$f].'" => "'.$tabtemps[$i][$pfields1[$f]].'"';
                $trenn = ",";
            }
            for ($f=0;$f<$max2;$f++)
            {
                $lastline .= $trenn.' "'.$pfields2[$f].'" => "'.$tabtemps[$i][$pfields2[$f]].'"';
                $trenn = ",";
            }
            for ($f=0;$f<$max3;$f++)
            {
                $lastline .= $trenn.' "'.$pfields3[$f].'" => "'.$tabtemps[$i][$pfields3[$f]].'"';
                $trenn = ",";
            }
        }
        fwrite($hdlout,$lastline.")\n");
        fwrite($hdlout,"                 );\n");
        fwrite($hdlout,"?>");
        
        fclose($hdlout);
        
        logLine("ausgegebene Npcs",$anznpc);
    }
}
// ----------------------------------------------------------------------------
//
//                              S C H R I T T   2
//
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
// ermittelt aus der angegebenen Datei alle relevanten NPC-Informationen
// ----------------------------------------------------------------------------
function getNpcInfos()
{
    global $tabnpcs, $cntnpcs, $pathdata;
    
    $files = array( "client_npcs_npc.xml",
                    "client_npcs_monster.xml"
                   );
    $max   = count($files);
    
    // Tabelle mit Schlüsselbegriffen aus dem Client
    $tabkeys  = array("id","name","desc","npc_title","dir","npc_function_type","ui_type",
                      "ui_race_type","head","torso","leg","foot","shoulder","glove","main",
                      "sub","front","side","upper","scale","move_speed_normal_walk",
                      "move_speed_normal_run","move_speed_combat_run","cursor_type",
                      "talking_distance","talk_delay_time","hpgauge_level","attack_delay",
                      "ai_name","tribe","race_type","sensory_range","attack_range",
                      "attack_rate","npc_type","ment","float_corpse","abyss_npc_type");   
    $maxkeys  = count($tabkeys);
    
    // Tabelle mit fehlenden Schlüsselbegriffen im Client
    $tabnone  = array("level","maxhp","maxxp","nameid","rank","rating","main_hand_attack",
                      "main_hand_accuracy","pdef","mresist","power","evasion","accuracy",
                      "race","type","on_mist","ai","state","npcname",
                      "titleid","func_dialogs");
        
    for ($f=0;$f<$max;$f++)
    {
        $fileutf16 = str_replace("\\\\","\\",$pathdata."\\Npcs\\".$files[$f]);    
        $filename = convFileToUtf8($fileutf16);
                        
        $anzles   = 0;
        $anznpc   = 0;
        $fndnpc   = false;
        $starttime= microtime(true);
        
        logHead("Ermitteln Informationen aus ".$files[$f]);
        logLine("Eingabedatei UTF16",$fileutf16);
        logLine("Eingabedatei UTF8 ",$filename);
        logFileSize("",$filename);
        
        flush();
        
        if (!file_exists($filename))
        {
            logLine("Fehler","Datei nicht gefunden");
            return;
        }
        
        $hdlin = openInputFile($filename);
        
        while (!feof($hdlin))
        {
            $line = rtrim(fgets($hdlin));
            $anzles++;
            
            if (stripos($line,"<npc_client>") !== false)
            {
                $fndnpc = true;
                $anznpc++;
                
                initNpcInTab($tabkeys,$tabnone);
            }
            
            if (stripos($line,"</npc_client>") !== false)
            {
                chkNpcInfos($cntnpcs);
                
                // abschliessen letzten NPC - Informationen, die noch nicht vorhanden sind            
                $fndnpc = false;
                $cntnpcs++;
            }
            
            if ($fndnpc)
            {
                for ($k=0;$k<$maxkeys;$k++)
                {
                    if ($tabnpcs[$cntnpcs][$tabkeys[$k]] == "?"
                    &&  stripos($line,"<".$tabkeys[$k].">") !== false)
                    {
                        $tabnpcs[$cntnpcs][$tabkeys[$k]] = getXmlValue($tabkeys[$k],$line);
                        $k = $maxkeys;
                    }
                }
            }
        }
        fclose($hdlin);
        
        unlink($filename);
        
        $usetime = substr(microtime(true) - $starttime,0,8);
        
        logLine("Zeilen gelesen",$anzles);
        logLine("gefundene NPCs",$anznpc);
        logLine("verbrauchte Zeit",$usetime." secs");
    }
    
    putNpcInclude("scan");
}
// ----------------------------------------------------------------------------
// interne Tabelle mit den NPC-Infos überprüfen / vervollständigen
// - float-Werte prüfen
// - int-Werte erzeugen
// - name_id ermitteln
// - titleId ermitteln
// - Boolean-Werte setzen
// ----------------------------------------------------------------------------
function chkNpcInfos($n)
{
    global $tabnpcs;
    
    // Tabelle der Float-Wert-Felder
    $tabfloat  = array("front","side","upper","move_speed_normal_walk",
                       "move_speed_normal_run","move_speed_combat_run");
    $tabints   = array("sensory_range","attack_range","talking_distance","talk_delay_time");
    $maxfloat  = count($tabfloat);
    $maxints   = count($tabints);
    $starttime = microtime(true);
    
    // Float-Werte prüfen
    for ($v=0;$v<$maxfloat;$v++)
    {
        if ($tabnpcs[$n][$tabfloat[$v]] != "?")
            $tabnpcs[$n][$tabfloat[$v]] = getFloatValue($tabnpcs[$n][$tabfloat[$v]]);
    }
    // Int-Werte erzeugen
    for ($v=0;$v<$maxints;$v++)
    {
        if ($tabnpcs[$n][$tabints[$v]] != "?")
            $tabnpcs[$n][$tabints[$v]]  = (int)$tabnpcs[$n][$tabints[$v]];
    } 
    
    // TitleId ermitteln
    if ($tabnpcs[$n]['npc_title'] != "?")
        $tabnpcs[$n]['titleid']    = getNpcTitleId($tabnpcs[$n]['npc_title']);
    
    // Boolean Value for float_corpse
    if ($tabnpcs[$n]['float_corpse'] != "?")
        $tabnpcs[$n]['float_corpse']  = $tabnpcs[$n]['float_corpse'] == "1" ? "true" : "false";
    
    getSpecialValues($n);
        
    // name wird nicht geliefert, und desc_name ist eigentlich name
    if ($tabnpcs[$n]['npcname'] == "?" || $tabnpcs[$n]['npcname'] == "") 
    {
        if ($tabnpcs[$n]['name'] == $tabnpcs[$n]['desc'])
            $tabnpcs[$n]['npcname'] = $tabnpcs[$n]['name'];
        else
            $tabnpcs[$n]['npcname'] = "None";
    }
    $tabnpcs[$n]['desc'] = $tabnpcs[$n]['name'];
}
// ----------------------------------------------------------------------------
//
//                            S C H R I T T   3
//
// ----------------------------------------------------------------------------
// Einlesen der NPC-Infos vom letzten Scan
// (Felder wurden nach dem Scan in der u.a. Reihenfolge gespeichert)
// ----------------------------------------------------------------------------
function getNpcInfosScanned()
{
    global $tabnpcs, $cntnpcs;
    
    $cntnpcs  = 0;
    $anzles   = 0;
    $tabkeys  = array("id","name","desc","npc_title","dir","npc_function_type","ui_type",
                      "ui_race_type","head","torso","leg","foot","shoulder","glove","main",
                      "sub","front","side","upper","scale","move_speed_normal_walk",
                      "move_speed_normal_run","move_speed_combat_run","cursor_type",
                      "talking_distance","talk_delay_time","hpgauge_level","attack_delay",
                      "ai_name","tribe","race_type","sensory_range","attack_range",
                      "attack_rate","npc_type","ment","float_corpse","abyss_npc_type",     
    // Tabelle mit fehlenden Schlüsselbegriffen im Client
                      "level","maxhp","maxxp","nameid","rank","rating","main_hand_attack",
                      "main_hand_accuracy","pdef","mresist","power","evasion","accuracy",
                      "race","type","on_mist","ai","state","npcname",
                      "titleid","func_dialogs","csvende");
    $maxkeys  = count($tabkeys);
    $tmpline  = "";
    
    logHead("Einlesen der NPC-Infos vom letzten Scan");
    logLine("Eingabedatei","parse_temp/inc_tabnpcs_scan.csv");
    logFileSize("","parse_temp/inc_tabnpcs_scan.csv");
    
    flush();
    
    if ($hdlin = openInputFile("parse_temp/inc_tabnpcs_scan.csv"))
    {
        $line = fgets($hdlin);      // überlesen der Zeile mit den Spalten-Namen
        
        while (!feof($hdlin))
        {
            $line = fgets($hdlin);
            $line = $tmpline.$line;
            
            if (stripos($line,"~#~") !== false)
            {
                $anzles++;
                                    
                $tab  = explode(";",$line);
                    
                for ($f=0;$f<$maxkeys;$f++)
                {
                    $tabnpcs[$cntnpcs][$tabkeys[$f]] = $tab[$f];
                }
                
                $tmpline = "";
                $cntnpcs++;
            }
            else
            {
                $tmpline = $line;
            }
        }
        fclose($hdlin);
    }
    logLine("Anzahl NPCs gelesen",$anzles);
}
// ----------------------------------------------------------------------------
// Ausgabedatei npc_templates.xml erzeugen
// ----------------------------------------------------------------------------
function putNpcTemplates()
{
    global $tabnpcs;
    
    // putNpcInclude("temp");
    
    $lev1 = "    ";
    $lev2 = "        ";
    $lev3 = "            ";
    $out  = "";
    
    logHead("Ausgabe der npc_templates.xml");
    
    $filename = "../outputs/parse_output/npcs/npc_templates.xml";
    $outstart = microtime(true);
    
    if ($hdlout = openOutputFile($filename))
    {    
        // Vorspann ausgeben
        fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
        fwrite($hdlout,'<npc_templates>'."\n");
        
        $anznpc   = 0;
        $maxcnt   = count($tabnpcs);
        flush();
        
        for ($n=0;$n<$maxcnt;$n++)
        {
            $anznpc++;
            
            getMissingValues($n);  // aus vorhandener npc_template.xml
            getDefaultValues($n);  // für neue NPCs (meist bei neuem Patch)
        
            $speedline    = getSpeedLine($n);    // füllt SpeedLine
            $equipline    = getEquipLines($n);   // füllt EquipLine
            $talkline     = getTalkLine($n);     // füllt TalkLine
            
            // fix 2016-02-25 für nameid/titleid
            if (!is_numeric($tabnpcs[$n]['titleid']))
                $tabnpcs[$n]['titleid'] = "?";
                
            // NPC-Start-Zeile        
            fwrite($hdlout, $lev1.'<npc_template'.
                    getOutText("npc_id",$tabnpcs[$n]['id']).
                    getOutText("level",$tabnpcs[$n]['level']).
                    getOutText("name",$tabnpcs[$n]['npcname']).
                    getOutText("name_id",$tabnpcs[$n]['nameid']).
                    getOutText("name_desc",$tabnpcs[$n]['desc']).
                    getOutText("height",$tabnpcs[$n]['upper']).
                    getOutText("title_id",$tabnpcs[$n]['titleid']).
                    getOutText("rank",$tabnpcs[$n]['rank']). 
                    getOutText("rating",$tabnpcs[$n]['rating']).
                    getOutText("race",$tabnpcs[$n]['race']).
                    getOutText("tribe",strtoupper($tabnpcs[$n]['tribe'])).
                    getOutText("type",$tabnpcs[$n]['type']).
                    getOutText("ai",$tabnpcs[$n]['ai']).
                    getOutText("srange",$tabnpcs[$n]['sensory_range']).
                    getOutText("arange",$tabnpcs[$n]['attack_range']).
                    getOutText("adelay",$tabnpcs[$n]['attack_delay']).
                    getOutText("arate",$tabnpcs[$n]['attack_rate']).
                    getOutText("hpgauge",$tabnpcs[$n]['hpgauge_level']).
                    getOutText("floatcorpse",$tabnpcs[$n]['float_corpse']).
                    getOutText("on_mist",$tabnpcs[$n]['on_mist']).
                    getOutText("state",$tabnpcs[$n]['state']).
                    '>'."\n");
                    
            // Stats-Zeile
            $end1 = ($speedline != "?") ? ">\n" : "/>\n";
            $end2 = ($speedline != "?") ? "\n".$lev2."</stats>\n" : "";
                       
            fwrite($hdlout, $lev2.'<stats'.
                    getOutText("maxHp",$tabnpcs[$n]['maxhp']).
                    getOutText("maxXp",$tabnpcs[$n]['maxxp']).
                    getOutText("main_hand_attack",$tabnpcs[$n]['main_hand_attack']).
                    getOutText("main_hand_accuracy",$tabnpcs[$n]['main_hand_accuracy']).
                    getOutText("pdef",$tabnpcs[$n]['pdef']).
                    getOutText("mresist",$tabnpcs[$n]['mresist']).
                    getOutText("power",$tabnpcs[$n]['power']).
                    getOutText("evasion",$tabnpcs[$n]['evasion']).
                    getOutText("accuracy",$tabnpcs[$n]['accuracy']).
                    $end1);

            // Speed-Zeile                
            if ($speedline != "?")
                fwrite($hdlout,$lev3.'<speeds'.$speedline.'/>'.$end2);

            // Equipment-Zeile
            if ($equipline != "?")
                fwrite($hdlout, $equipline."\n");
            
            // Bound-Radius-Zeile
            fwrite($hdlout, $lev2.'<bound_radius'.
                    getOutText("front",$tabnpcs[$n]['front']).
                    getOutText("side",$tabnpcs[$n]['side']).
                    getOutText("upper",$tabnpcs[$n]['upper']).
                    '/>'."\n");
                    
            // TalkInfo-Zeile
            if ($talkline != "?")
                fwrite($hdlout, $talkline."\n");
            
            // Npc-Ende-Zeile
            fwrite($hdlout, $lev1."</npc_template>\n");
        }
        // Nachspann ausgeben
        fwrite($hdlout,"</npc_templates>");
        fclose($hdlout);
        
        logLine("Ausgabedatei",$filename);
        logLine("Anzahl NPCs geschrieben",$anznpc);
    }
}
// ----------------------------------------------------------------------------
//
//                         A L L E   S C H R I T T E
// 
// ----------------------------------------------------------------------------
// temporäre Dateien löschen
// ----------------------------------------------------------------------------
function clearOutParserFiles($step)
{
    global $outfiles;
    
    $max    = count($outfiles);
    
    for ($f=0;$f<$max;$f++)
    {
        if (file_exists($outfiles[$f][3]))
            if ($step == "*"  ||  $outfiles[$f][0] >= $step)
                unlink($outfiles[$f][3]);
    }
}
// ----------------------------------------------------------------------------
//
//                                  M A I N
//
// ----------------------------------------------------------------------------
putHtmlHead("$selfname - $infoname","Client parsen zur Erstellung der npc_templates.xml");

$schritt = isset($_GET['schritt']) ? $_GET['schritt'] : 0;

logStart();

$starttime = microtime(true);

$pathsvn    = "";
$pathdata   = "";
$pathlevels = "";
$tabnpcs    = array();
$cntnpcs    = 0;
//                   0   1   2   3   
$tabsteps   = array("J","J","N","N");
$maxsteps   = count($tabsteps);

// Tabelle - benötigte Dateien je Schritt/Folgeschritt
$outfiles   = array(
                //     s   n   t   name
                //     |   |   +-----------> T=temporär, B=Benötigt, C=Control
                //     |   +---------------> nächster Schritt    
                //     +-------------------> Schritt 1 bis 3
                // aus Schritt 1 - SvnNpcTemplates
                array( 1 , 2 ,"B","parse_temp/inc_npcs_svn.php"),
                // aus Schritt 2 - Client-NpcInfos
                array( 2 , 3 ,"B","parse_temp/inc_tabnpcs_scan.csv"),
                // aus Schritt 3 - NpcTemplates
                array( 3 , 3 ,"B","parse_output/npc_templates.xml")
                   );

if (getConfData())
{
    showSchrittHead();
    
    switch ($schritt)
    {
        case 9:
            // B E R E I N I G E N     (löscht benötigte/temporäre Dateien)
            clearOutParserFiles("*");
            $schritt = 0;
            showHinweise();
            break;
        case 0:
            showHinweise();
            break;
        case 1:
            clearOutParserFiles( 1 );
            scanOldNpcTemplates();
            break;
        case 2:   
            clearOutParserFiles( 2 );
                        
            getNpcInfos();        
            break;
        case 3:
            include("parse_temp/inc_npcs_svn.php");
            include("includes/inc_tabdefs.php");
            include("includes/auto_inc_item_infos.php");
            
            clearOutParserFiles( 3 );
            
            getNpcInfosScanned();
            putNpcTemplates();
            break;
        default:
            showHinweise();
    }
    
    getNextSchritt();
            
    echo "   
  <tr><td colspan=3><br><hr><br><center>";
    
    for ($s=($schritt + 1);$s<$maxsteps;$s++)
    {
        if ($tabsteps[$s] == "J")
            echo "
  <a href='$selfname?schritt=$s' target='_self'><input type='button' value='Weiter mit Schritt $s'></a>";
    }
        
    if ($schritt > 0)
        echo "   
  <tr><td colspan=3>
  <br><br><center><a href='parseNpcs.php?schritt=0' target='_self'><input type='button' value='Startseite'></a></center></td></tr>";
}
else
    logLine("Programm-Abbruch","Fehler in der Konfigurations-Datei");

logStop($starttime,true,true);
 
putHtmlFoot();
?>