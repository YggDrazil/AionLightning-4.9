<html>
<head>
  <title>
    Tribe - Erzeugen Dateien tribe_relations.xml und TribeClass.java"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
include("../includes/inc_globals.php");

getConfData();

if (!file_exists("../outputs/parse_output/tribe"))
    mkdir("../outputs/parse_output/tribe");

$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen Tribe-Dateien</div>
  <div class="hinweis" id="hinw">
    Erzeugen der Dateien tribe_relations.xml und TribeClass.java.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genTribes.php" target="_self">
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
// Ausgabezeile formatieren
// ----------------------------------------------------------------------------
function getFormattedLine($line)
{
    global $tabtribes;
    
    $xmlkey = getXmlKey($line);
    
    $val = getXmlValue($xmlkey,$line);
    $val = str_replace(","," ",$val);
    $val = strtoupper($val);
    
    /* ----------------> erstmal deaktiviert!!!!
    // Tribes merken
    $tab = explode(" ",$val);
    $max = count($tab);
    
    for ($t=0;$t<$max;$t++)
    {
        if (!isset($tabribes[$tab[$t]]))
            $tabtribes[$tab[$t]] = false;
    }
    ----------------------------------------< */
    
    // einige XML-Tags werden umbenannt
    if ($xmlkey == "friendly")        $xmlkey = "friend";
    if ($xmlkey == "aggressive")      $xmlkey = "aggro";
    
    $out = "    <".$xmlkey.">".$val."</".$xmlkey.">";
    return $out;
}
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// ----------------------------------------------------------------------------
// TribeRelations-Datei ausgeben
// ----------------------------------------------------------------------------
function generTribeFile()
{
    global $pathdata, $tabtribes;
    
    $fileu16 = formFileName($pathdata."\\Npcs\\npc_tribe_relation.xml");
    $fileout = "../outputs/parse_output/tribe/tribe_relations.xml";
    
    $fileext = convFileToUtf8($fileu16);
    logHead("Generierung der Datei");
    logLine("Eingabedatei UTF16",$fileu16);
    logLine("Eingabedatei UTF8",$fileext);
    logLine("Ausgabedatei",$fileout);
    
    $cntles = 0;
    $cntout = 0;
    
    $hdlout = openOutputFile($fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
    fwrite($hdlout,"<tribe_relations>\n");
    $cntout += 2;
    
    $lines = file($fileext);
    $domax = count($lines);
    $crel  = 0;
    
    for ($l=0;$l<$domax;$l++)
    {
        $line = rtrim($lines[$l]);
        $cntles++;
        
        if (stripos($line,"<?xml") === false
        &&  stripos($line,"npc_tribe_relations") === false)
        {            
            // Start Tribe
            if (stripos($line," Tribe=") !== false)
            {
                $val  = strtoupper(getKeyValue("Tribe",$line));
                $base = "";
                $crel = 0;
                
                // Tribe merken!
                if (!isset($tabtribes[$val]))
                {        
                    // zusätzlich als Basisklasse merken ?!?      
                    if (substr($val,0,5) == "GAB1_" || substr($val,0,3) == "PC_")
                        $tabtribes[$val] = true;  
                    else
                        $tabtribes[$val] = false;
                }    
                // BASE-Angabe vorhanden?
                for ($b=$l+1;$b<$domax;$b++)
                {
                    $xline = $lines[$b];
                    
                    if (stripos($xline,"base_tribe") !== false)
                    {
                        $base = strtoupper(getXmlValue("base_tribe",$xline));
                        
                        // als Basisklasse merken
                        $tabtribes[$base] = true;
                    }
                    else
                        if (stripos($xline,"</tribe>") !== false)
                            $b = $domax;
                        else
                            $crel++;
                }
                
                if ($base != "")
                    $base = ' base="'.$base.'"';
                
                if ($crel > 0)                 
                    fwrite($hdlout,'  <tribe name="'.$val.'"'.$base.'>'."\n");
                else
                    fwrite($hdlout,'  <tribe name="'.$val.'"'.$base.' />'."\n");
                    
                $cntout++;
            }
            else
            {
                // End Tribe
                if (stripos($line,"</tribe>") !== false)
                {
                    if ($crel > 0)
                    {
                        fwrite($hdlout,'  </tribe>'."\n");
                        $cntout++;
                    }
                }
                else
                {
                    // Relation
                    if (stripos($line,"base_tribe") === false)
                    {
                        fwrite($hdlout,getFormattedLine($line)."\n");
                        $cntout++;
                    }
                }
            }
        }
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</tribe_relations>");
    $cntout++;
    
    fclose($hdlout);
    
    logLine("Zeilen Eingabedatei",$domax);
    logLine("Zeilen verarbeitet ",$cntles);
    logLine("Zeilen ausgegeben  ",$cntout);
}
// ----------------------------------------------------------------------------
// Erzeugen der TribeList für die Java-Datei: ...model/tribeClass.java
// ----------------------------------------------------------------------------
function generTribeList()
{
    global $pathsvn,$tabtribes;
    
    $tablist = array_keys($tabtribes);
    sort($tablist);
    
    $filesvn = formFileName($pathsvn."\\trunk\\AL-Game\\src\\com\\aionemu\\gameserver\\model\\TribeClass.java");
    $fileout = "../outputs/parse_output/tribe/TribeClass.java";
    
    if (!file_exists($filesvn))
    {
        logLine("Eingabedatei fehlt",$filesvn);
        logLine("","Erzeugung der neuen Datei wurde abgebrochen");
        return;
    }
    if (!$hdlsvn = openInputFile($filesvn))
    {
        logLine("Eingabdatei","Konnte Datei nicht öffnen: ".$filesvn);
        return;
    }
    
    $hdlout = openOutputFile($fileout);
    $domax  = count($tablist);
    $inenum = 0;
    $cntsvn = 0;
    $cntdel = 0;
    $cntins = 0;
    $cntout = 0;
    $basold = 0;
    $basnew = 0;
    $dobase = true;
    
    logHead("Erzeugen der Datei TribeClass.java");
    logLine("Eingabedatei",$filesvn);
    logLine("Ausgabedatei",$fileout);
    
    while (!feof($hdlsvn))
    {
        $line = fgets($hdlsvn);
        $cntsvn++;
        
        switch ($inenum)
        {
            case 0:  // Anfang der Enumaration suchen
                    if (stripos($line," enum ") != false && stripos($line,"TribeClass") !== false)
                    {
                        if (stripos($line,"{") !== false)
                            $inenum = 2;
                        else
                            $inenum = 1;
                    }
                    fwrite($hdlout,$line);
                    $cntout++;
                    break;
            case 1:  // Enumeration - Start der Liste nach dem "{" suchen
                    if (stripos($line,"{") !== false)
                        $inenum = 2;
                        
                    fwrite($hdlout,$line);
                    $cntout++;
                    break;
            case 2:  // 1. TRIBE der Aufzählung suchen
                    if (trim($line) != "")
                        $inenum = 3;
                    else
                    {
                        fwrite($hdlout,$line);
                        $cntout++;
                    }
                    break;
            case 3:  // alles überlesen, bis zum ";"
                    if (stripos($line,"true") !== false)
                        $basold++;
                    
                    if (stripos($line,";") !== false)
                        $inenum = 4; 
                        
                    $cntdel++;   
                    break;
            case 4: // neue Liste hier einfügen
                    fwrite($hdlout,"    /* new tribe enumeration (sorted by name), generated by phpTools at ".date("Y-m-d H:i")." */\n");
                    $cntout++;
                    
                    for ($b=0;$b<2;$b++)
                    {
                        $dobase = $b == 0 ? true : false;
                        if ($b == 0)
                            fwrite($hdlout,"    /* BASE TRIBES */\n");
                        else
                            fwrite($hdlout,"    /* OTHER TRIBES */\n");
                        $cntout++;
                        
                        // um $b reduzieren, damit der letzte mit einem ";" abgeschlossen wird!
                        // gilt daher nur für die "Other TRIBES", nicht für die "BASE TRIBES"!
                        for ($t=0;$t<($domax - $b);$t++)
                        {
                            if ($tabtribes[$tablist[$t]] == $dobase)
                            {
                                if ($tabtribes[$tablist[$t]] == true)
                                {
                                    fwrite($hdlout,"    ".$tablist[$t]."(true),\n"); 
                                    $basnew++;
                                }                            
                                else
                                    fwrite($hdlout,"    ".$tablist[$t].",\n");
                                $cntins++;
                                $cntout++;    
                            }                            
                        } 
                    }
                    $t = $domax - 1;
                    fwrite($hdlout,"    ".$tablist[$t].";\n");
                    fwrite($hdlout,"    /* end of new tribe enumeration */\n");
                    $cntins++;
                    $cntout += 2; 

                    $inenum = 5;          
                    
                    break;
            default: // alles restliche ausgeben
                    fwrite($hdlout,$line);
                    $cntout++;
                    break;
        }
    }   
    fclose($hdlsvn);
    fclose($hdlout);
    
    logLine("Zeilen gelesen",$cntsvn);
    logLine("Zeilen ignoriert",$cntdel);
    logLine("Zeilen eingef&uuml;gt",$cntins);
    logLine("Zeilen ausgegeben",$cntout);
    logLine("Basisklassen alt",$basold);
    logLine("Basisklassen neu",$basnew);
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------

$tabtribes = array();
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
        generTribeFile();
        generTribeList();
        
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