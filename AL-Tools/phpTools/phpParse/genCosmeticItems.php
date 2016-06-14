<html>
<head>
  <title>
    CosmeticItems - Erzeugen cosmetic_items.xml"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
include("../includes/inc_globals.php");

getConfData();

if (!file_exists("../outputs/parse_output/cosmetic_items"))
    mkdir("../outputs/parse_output/cosmetic_items");

$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen CosmeticItems-Datei</div>
  <div class="hinweis" id="hinw">
    Erzeugen der cosmetic_items.xml-Datei.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genCosmeticItems.php" target="_self">
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
// Umrechnen RGB-Angaben in einen INT 
//
// Beispiel:   '255, 255, 255'  wird zu  '16777215' 
// ----------------------------------------------------------------------------
function getColorInt($rgb)
{
    // ACHTUNG: bisher werden in der EMU die Farben als BGR interpretiert !!!
   $tab = explode(",",str_replace(" ","",$rgb));
      
   $hex = "";
   $hex .= str_pad(dechex($tab[2]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($tab[1]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($tab[0]), 2, "0", STR_PAD_LEFT);
   
   return hexdec($hex);
}
// ----------------------------------------------------------------------------
// normale PRESET-Zeile aufbereiten
// ----------------------------------------------------------------------------
function getXmlLine($line)
{
    $xml = getXmlKey($line);
    
    $ret = '            <'.$xml.'>'.getXmlValue($xml,$line).'</'.$xml.'>'."\n";
        
    return $ret;
}
// ----------------------------------------------------------------------------
// Farben-PRESET-Zeile aufbereiten
// ----------------------------------------------------------------------------
function getColorLine($line)
{
    $xml = getXmlKey($line);
    $col = getXmlValue($xml,$line);
    $val = getColorInt($col);
    
    $ret = '            <'.$xml.'>'.$val.'</'.$xml.'>'."\n";
        
    return $ret;
}
// ----------------------------------------------------------------------------
// Ausgabezeilen für PRESET formatieren 
// ----------------------------------------------------------------------------
function getPresetLines($pres)
{
    global $pathdata;
    
    $ret = "";
    
    $presfile = formFileName($pathdata."\\custompreset\\preset_".strtolower($pres).".xml");
    $presfile = convFileToUtf8($presfile);
    
    logLine("- verarbeite PRESET-Datei",$presfile);
    
    if (!file_exists($presfile))
    {
        logLine("PresetFile fehlt",$presfile);
        $ret = '        <preset/>'."\n";
        
        return $ret;
    }
    $hdlpres = openInputFile($presfile);
    
    while (!feof($hdlpres))
    {
        $line = rtrim(fgets($hdlpres));
        
        if     (stripos($line,"<scale>")          !== false) $ret .= getXmlLine($line);
        elseif (stripos($line,"<hair_type>")      !== false) $ret .= getXmlLine($line);
        elseif (stripos($line,"<face_type>")      !== false) $ret .= getXmlLine($line); 
        elseif (stripos($line,"<hair_color>")     !== false) $ret .= getColorLine($line);
        elseif (stripos($line,"<lip_color>")      !== false) $ret .= getColorLine($line);
        elseif (stripos($line,"<eye_color")       !== false) $ret .= getColorLine($line);
        elseif (stripos($line,"<skin_color")      !== false) $ret .= getColorLine($line);
    }
    fclose($hdlpres);
    
    if ($ret != "")
        $ret = '        <preset>'."\n".$ret.'        </preset>'."\n";
        
    return $ret;
}
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// CosmeticItems-Datei ausgeben
// ----------------------------------------------------------------------------
function generCosmeticItemsFile()
{
    global $pathdata;
    
    $fileu16 = formFileName($pathdata."\\PC\\client_cosmetic_item_info.xml");
    $fileout = "../outputs/parse_output/cosmetic_items/cosmetic_items.xml";
    
    $fileext = convFileToUtf8($fileu16);
    logHead("Generierung der Datei");
    logLine("Eingabedatei UTF16",$fileu16);
    logLine("Eingabedatei UTF8",$fileext);
    logLine("Ausgabedatei",$fileout);
    
    $cntles = 0;
    $cntout = 0; 
    $cntprs = 0;
    
    $hdlout = openOutputFile($fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
    fwrite($hdlout,'<cosmetic_items xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="cosmetic_items.xsd">'."\n");
    $cntout += 2;
    
    $lines = file($fileext);
    $domax = count($lines);
        
    $name = $type = $tcol = $race = $gend = $pres = ""; 
    
    for ($l=0;$l<$domax;$l++)
    {
        $line = rtrim($lines[$l]);
        $cntles++;
        
        if (stripos($line,"<?xml") === false
        &&  stripos($line,"client_ride_data") === false)
        {  
            // Start CosmeticItems
            if     (stripos($line,"<name>")              !== false) $name = getXmlValue("name",$line);
            elseif (stripos($line,"<hair_type>")         !== false) $type = getXmlValue("hair_type",$line);
            elseif (stripos($line,"<face_type>")         !== false) $type = getXmlValue("face_type",$line);
            elseif (stripos($line,"<tattoo_type>")       !== false) $type = getXmlValue("tattoo_type",$line);
            elseif (stripos($line,"<makeup_type>")       !== false) $type = getXmlValue("makeup_type",$line);
            elseif (stripos($line,"<voice_type>")        !== false) $type = getXmlValue("voice_type",$line);
            elseif (stripos($line,"<hair_color>")        !== false) $tcol = getXmlValue("hair_color",$line);
            elseif (stripos($line,"<face_color>")        !== false) $tcol = getXmlValue("face_color",$line);
            elseif (stripos($line,"<eye_color>")         !== false) $tcol = getXmlValue("eye_color",$line);
            elseif (stripos($line,"<lip_color>")         !== false) $tcol = getXmlValue("lip_color",$line);
            elseif (stripos($line,"<gender_permitted>")  !== false) $gend = getXmlValue("gender_permitted",$line);
            elseif (stripos($line,"<race_permitted>")    !== false) $race = getXmlValue("race_permitted",$line);
            elseif (stripos($line,"<preset_name")        !== false) $pres = getXmlValue("preset_name",$line);
            elseif (stripos($line,"</client_cosmeticiteminfo>") !== false)
            {
                // Wert für TYPE festlegen
                $xtype = "";
                
                if     ($pres                         != "")     $xtype = "preset_name";
                elseif (stripos($name,"hair_type_")   !== false) $xtype = "hair_type";
                elseif (stripos($name,"face_type_")   !== false) $xtype = "face_type";
                elseif (stripos($name,"tattoo_type_") !== false) $xtype = "tattoo_type";
                elseif (stripos($name,"makeup_type_") !== false) $xtype = "makeup_type";
                elseif (stripos($name,"voice_type")   !== false) $xtype = "voice_type";
                elseif (stripos($name,"hair_color")   !== false) $xtype = "hair_color";
                elseif (stripos($name,"face_color")   !== false) $xtype = "face_color";
                elseif (stripos($name,"eye_color")    !== false) $xtype = "eye_color";
                elseif (stripos($name,"lip_color")    !== false) $xtype = "lip_color";
                
                // Besonderheiten abfangen (zusammengesetzte Typen)
                if     (stripos($name,"hair_type_hair_color")    !== false) $xtype = "hair_color";
                elseif (stripos($name,"face_type_face_color")    !== false) $xtype = "face_color";
               
                // Wert für GENDER festlegen
                $xgend = "ALL";
                
                switch (strtoupper($gend))
                {
                    case "MALE"  : $xgend = "MALE";   break;
                    case "FEMALE": $xgend = "FEMALE"; break;
                    default :      $xgend = "ALL";    break;                    
                }
                
                // Wert für RACE festlegen
                $xrace = "PC_ALL";
                
                switch (strtoupper($race))
                {
                    case "PC_LIGHT": $xrace = "ELYOS";     break;
                    case "PC_DARK":  $xrace = "ASMODIANS"; break;
                    default:         $xrace = "PC_ALL";    break;
                }
                
                // Wert für "ID festlegen
                if (stripos($xtype,"color") !== false)
                    $xid = getColorInt($tcol);
                else
                    $xid = $type;
                                
                // Zeile aufbereiten / ausgeben                             
                if ($pres == "") 
                {
                    fwrite($hdlout,'    <cosmetic_item type="'.$xtype.'" cosmetic_name="'.$name.'" id="'.$xid.
                                   '" race="'.$xrace.'" gender_permitted="'.$xgend.'"/>'."\n");
                    $cntout++;
                }
                else                
                {
                    // wenn preset angegeben, dann lesen / ergänzen   
                    fwrite($hdlout,'    <cosmetic_item type="'.$xtype.'" cosmetic_name="'.$name.
                                   '" race="'.$xrace.'" gender_permitted="'.$xgend.'">'."\n");
                    $cntout++;
                    $xpres = getPresetLines($pres);
                    
                    if ($xpres != "")
                    {
                        fwrite($hdlout,$xpres);
                        $cntout += substr_count("\n",$xpres);
                        
                        fwrite($hdlout,'    </cosmetic_item>'."\n");
                        $cntout++;
                        
                        $cntprs++;
                    }
                }
                
                $name = $type = $race = $gend = $pres = ""; 
            }
        }
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</cosmetic_items>");
    $cntout++;
    
    fclose($hdlout);
    
    logLine("Zeilen Eingabedatei",$domax);
    logLine("Zeilen verarbeitet ",$cntles);
    logLine("Zeilen ausgegeben  ",$cntout);
    logLine("- davon mit PRESETs",$cntprs);
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
        generCosmeticItemsFile();
        
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