<html>
<head>
  <title>
    GatherableTemplates - Erzeugen gatherable_templates.xml"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
include("../includes/inc_globals.php");

getConfData();

if (!file_exists("../outputs/parse_output/gatherables"))
    mkdir("../outputs/parse_output/gatherables");

$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen GatherableTemplates-Datei</div>
  <div class="hinweis" id="hinw">
    Erzeugen der gatherable_templates.xml-Datei.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genGatherable.php" target="_self">
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
// Suchen / Aufbereiten des Namens für das Item
// ----------------------------------------------------------------------------
function getKeyName($name)
{    
    global $tabNames;
    
    $key = strtoupper($name);
        
    // direkt
    if (isset($tabNames[$key]))
        return $key;
    
    // spezielle Namen    
    if     ($key == "MATERIAL_RARE_LDF4_DISASSEMBLY01") $name = "STR_MATERIAL_RARE_ALL_DISASSEMBLY01";
    elseif ($key == "MATERIAL_DYE_LDF4_DISASSEMBLY01")  $name = "STR_MATERIAL_FLOWER_ALL_DISASSEMBLY01";
    
    if (isset($tabNames[$key]))
        return $key;
    
    // "STR_" voranstellen    
    $key = "STR_".$key;
    if (isset($tabNames[$key]))
        return $key;
        
    // ersetzen ITEM_... durch STR_...  
    $key = strtoupper($name);
    
    if (substr($key,0,5) == "ITEM_")
    {
        $key = "STR_".substr($key,5);
            
        if (isset($tabNames[$key]))
            return $key;
    }  

    // eine evtl. vorhandene Nummerierung am Ende ersetzen
    if (substr($name,-2,2) == "04"
    ||  substr($name,-2,2) == "03"
    ||  substr($name,-2,2) == "02")
    {
        $name = strtoupper( substr($name,0,strlen($name) - 2)."01" );
                
        if (isset($tabNames[$key]))
            return $key;
    }
    
    // nichts gefunden, also $name in Grossbuchstaben zurückgeben
    return strtoupper($name);    
}
// ----------------------------------------------------------------------------
// ermitteln Name zum Item
// ----------------------------------------------------------------------------
function getName($name)
{
    global $tabNames;
    
    $name = getKeyName( $name );
    
    if (isset($tabNames[$name]))
        return $tabNames[$name]['body'];
    else
    {
        if (isset($tabNames["STR_".$name]))
            return $tabNames["STR_".$name]['body'];
        else
            return "???";
    }
}
// ----------------------------------------------------------------------------
// ermitteln NameId zum Item
// ----------------------------------------------------------------------------
function getNameId($name)
{
    global $tabNames;
    
    $name = getKeyName( $name );
    
    if (isset($tabNames[$name]))
        return $tabNames[$name]['id'];
    else
    {
        if (isset($tabNames["STR_".$name]))
            return $tabNames["STR_".$name]['id'];
        else
            return "???";
    }
}
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Scannen der Client-Item-Strings
// ----------------------------------------------------------------------------
function scanClientNames()
{
    global $pathstring, $tabNames;
    
    LogHead("Scanne die Namen aus den PS-Client-Dateien");
        
    $tabfiles = array( "client_strings_item.xml",
                       "client_strings_item2.xml",
                       "client_strings_item3.xml",
                       "client_strings_quest.xml"
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
// Client-Datei scannen
// ----------------------------------------------------------------------------
function scanClientGatherFile()
{
    global $pathdata, $tabsrc;
    
    $fileu16 = formFileName($pathdata."\\Gather\\gather_src.xml"); 
    $fileext = convFileToUtf8($fileu16);
    
    logHead("Scanne die Client-Datei");
    logLine("Eingabedatei UTF16",$fileu16);
    logLine("Eingabedatei UTF8",$fileext);
    
    $cntles = 0;
    
    $hdlext = openInputFile($fileext);
    
    if (!$hdlext)
    {
        logLine("Fehler openInputFile",$fileext);
        return;
    }
    
    $id = "";
    
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        $cntles++;
        
        // ToDo
        if     (stripos($line,"<id>")            !== false) 
            $id = getXmlValue("id",$line);
        elseif (stripos($line,"<name>")          !== false) 
            $tabsrc[$id]['name'] = getXmlValue("name",$line);
        elseif (stripos($line,"<desc>")          !== false) 
            $tabsrc[$id]['desc'] = getXmlValue("desc",$line);
        elseif (stripos($line,"<source_type>")   !== false) 
            $tabsrc[$id]['type'] = getXmlValue("source_type",$line);
        elseif (stripos($line,"<harvest_count>") !== false) 
            $tabsrc[$id]['count'] = getXmlValue("harvest_count",$line);
        elseif (stripos($line,"<skill_level>")   !== false)
            $tabsrc[$id]['level'] = getXmlValue("skill_level",$line);
        elseif (stripos($line,"<char_level_limit>") !== false)
            $tabsrc[$id]['limit'] = getXmlValue("char_level_limit",$line);
        elseif (stripos($line,"<harvestskill>") !== false)
            $tabsrc[$id]['skill'] = getXmlValue("harvestskill",$line);
        elseif (stripos($line,"_adj")            !== false)
        {
            $xml = getXmlKey($line);
            $tabsrc[$id][$xml] = getXmlValue($xml,$line);
        }
        elseif (stripos($line,"<required_item>") !== false)
            $tabsrc[$id]['ritem'] = getXmlValue("required_item",$line);
        elseif (stripos($line,"<check_type>") !== false)
            $tabsrc[$id]['check'] = getXmlValue("check_type",$line);
        elseif (stripos($line,"<erase_value>") !== false)
            $tabsrc[$id]['erase'] = getXmlValue("erase_value",$line);
        elseif (stripos($line,"<material")       !== false)
        {
            $xml = getXmlKey($line);
            $ind = substr($xml,-1,1) - 1;
            $tabsrc[$id]['mat'][$ind]['name'] = getXmlValue($xml,$line);
        }
        elseif (stripos($line,"<normal_rate")    !== false)
        {
            $xml = getXmlKey($line);
            $ind = substr($xml,-1,1) - 1;
            $tabsrc[$id]['mat'][$ind]['rate'] = getXmlValue($xml,$line);
        }
        elseif (stripos($line,"<extra_material")    !== false)
        {
            $xml = getXmlKey($line);
            $ind = substr($xml,-1,1) - 1;
            $tabsrc[$id]['ext'][$ind]['name'] = getXmlValue($xml,$line);
        }
        elseif (stripos($line,"<extra_normal_rate") !== false)
        {
            $xml = getXmlKey($line);
            $ind = substr($xml,-1,1) - 1;
            $tabsrc[$id]['ext'][$ind]['rate'] = getXmlValue($xml,$line);
        }
        elseif (stripos($line,"<captcha_rate>") !== false)
            $tabsrc[$id]['capt'] = getXmlValue("captcha_rate",$line);
    }
    fclose($hdlext);
    
    logLine("Anzahl Zeilen gelesen",$cntles);
    logLine("gefundene Gather-Templates",count($tabsrc));
}
// ----------------------------------------------------------------------------
// GatherableTemplates-Datei ausgeben
// ----------------------------------------------------------------------------
function generGatherablesFile()
{
    global $tabsrc;
        
    $fileout = "../outputs/parse_output/gatherables/gatherable_templates.xml";
    
    logHead("Generierung der Datei");
    logLine("Ausgabedatei",$fileout);
    
    $cntout = 0; 
    
    $hdlout = openOutputFile($fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
    fwrite($hdlout,'<gatherable_templates xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="gatherable_templates.xsd">'."\n");
    $cntout += 2;
        
    while (list($skey,$sval) = each($tabsrc))
    {        
        // Start-Tag
        $out  = '    <gatherable_template id="'.$skey.'"'.
                ' name="'.getName($tabsrc[$skey]['desc']).'"'. 
                ' nameId="'.getNameId($tabsrc[$skey]['desc']).'"'.      
                ' sourceType="'.strtoupper($tabsrc[$skey]['type']).'"'.
                ' harvestCount="'.$tabsrc[$skey]['count'].'"'.
                ' skillLevel="'.$tabsrc[$skey]['level'].'"'.
                ' harvestSkill="'.getSkillNameId($tabsrc[$skey]['skill']).'"';
                
        if (isset($tabsrc[$skey]['success_adj']))
            $out .= ' successAdj="'.$tabsrc[$skey]['success_adj'].'"';
        if (isset($tabsrc[$skey]['failure_adj']))
            $out .= ' failureAdj="'.$tabsrc[$skey]['failure_adj'].'"';
        if (isset($tabsrc[$skey]['aerial_adj']))
            $out .= ' aerialAdj="'.$tabsrc[$skey]['aerial_adj'].'"';
        if (isset($tabsrc[$skey]['capt']))
        {
            if ($tabsrc[$skey]['capt'] != "" && $tabsrc[$skey]['capt'] != "0")
                $out .= ' captcha="'.$tabsrc[$skey]['capt'].'"';
        }    
        if (isset($tabsrc[$skey]['limit']))
            $out .= ' lvlLimit="'.$tabsrc[$skey]['limit'].'"';
        if (isset($tabsrc[$skey]['ritem']))
        {
            $out .= ' reqItem="'.getClientItemId($tabsrc[$skey]['ritem']).'"'.
                    ' reqItemNameId="'.getNameId($tabsrc[$skey]['ritem']).'"';
        }
        if (isset($tabsrc[$skey]['check']))
        {
            if ($tabsrc[$skey]['check'] != "" && $tabsrc[$skey]['check'] != "0")
                $out .= ' checkType="'.$tabsrc[$skey]['check'].'"';
        }    
        if (isset($tabsrc[$skey]['erase']))
        {
            if ($tabsrc[$skey]['erase'] != "" && $tabsrc[$skey]['erase'] != "0")
                $out .= ' eraseValue="'.$tabsrc[$skey]['erase'].'"';
        }    
        $out .= '>'."\n";
        fwrite($hdlout,$out);
        $cntout++;
        
        // Materialien
        if (isset($tabsrc[$skey]['mat']))
        {
            fwrite($hdlout,'        <materials>'."\n");
            $cntout++;
            
            $maxmat = count($tabsrc[$skey]['mat']);
            
            for ($m=0;$m<$maxmat;$m++)
            {
                $out = '            <material rate="'.$tabsrc[$skey]['mat'][$m]['rate'].'"'.
                       ' nameid="'.getNameId($tabsrc[$skey]['mat'][$m]['name']).'"'.
                       ' itemid="'.getClientItemId($tabsrc[$skey]['mat'][$m]['name']).'"'.
                       ' name="'.getClientItemName($tabsrc[$skey]['mat'][$m]['name']).'"/>'."\n";
                fwrite($hdlout,$out);
                $cntout++;
            }
            fwrite($hdlout,'        </materials>'."\n");
            $cntout++;
        }
        // Extra-Materialien
        if (isset($tabsrc[$skey]['ext']))
        {
            fwrite($hdlout,'        <exmaterials>'."\n");
            $cntout++;
            
            $maxmat = count($tabsrc[$skey]['ext']);
            
            for ($m=0;$m<$maxmat;$m++)
            {
                $out = '            <material rate="'.$tabsrc[$skey]['ext'][$m]['rate'].'"'.
                       ' nameid="'.getNameId($tabsrc[$skey]['ext'][$m]['name']).'"'.
                       ' itemid="'.getClientItemId($tabsrc[$skey]['ext'][$m]['name']).'"'.
                       ' name="'.getName($tabsrc[$skey]['ext'][$m]['name']).'"/>'."\n";
                fwrite($hdlout,$out);
                $cntout++;
            }
            fwrite($hdlout,'        </exmaterials>'."\n");
            $cntout++;
        }
        fwrite($hdlout,'    </gatherable_template>'."\n");
        $cntout++;
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</gatherable_templates>");
    $cntout++;
    
    fclose($hdlout);
    
    logLine("Zeilen ausgegeben  ",$cntout);
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------

include("includes/auto_inc_item_infos.php");
include("includes/auto_inc_skill_names.php");
include("includes/inc_getautonameids.php");

$tabsrc    = array();
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
        scanClientGatherFile();
        generGatherablesFile();
        
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