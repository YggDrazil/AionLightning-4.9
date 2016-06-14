<?PHP
// ----------------------------------------------------------------------------
// Script: inc_globals.php                      Build: 1.0 by Mariella, 11/2015
// ----------------------------------------------------------------------------
// Einige allgemeine Konfigurations-Einstellungen sowie global Funktionen für 
// Erstellung der eigenen Tools (Mini-Version für Weitergabe)
// ----------------------------------------------------------------------------			
// GENERELL: maximale Verarbeitungszeit und interne Speichergrösse setzen
// ----------------------------------------------------------------------------

ini_set("max_execution_time",7200);
ini_set("memory_limit","2048M");

// ----------------------------------------------------------------------------
// globale Definitionen
// ----------------------------------------------------------------------------
$mariella   = "&copy; Mariella 04/2015";

$pathsvn    = "";
$pathdata   = "";
$pathlevels = "";
$pathstring = "";

$tabPosOld  = array();
$doneGenerInclude = false;   // kann für die MAIN-Steuerung genutzt werden

// ----------------------------------------------------------------------------
//
//                      H T M L - F U N K T I O N E N
//
// ----------------------------------------------------------------------------			
// HTML-Header ausgeben
// ----------------------------------------------------------------------------
function putHtmlHead($title,$aktion)
{
echo '
<html>
<head>
  <title>
    '.$title.'
  </title>
  <link rel="stylesheet" type="text/css" href="../includes/aioneutools.css">
</head>

<body onload="onLoad()">
<center>
<div style="width:800px">
  <div width="100%"><img src="../includes/aioneulogo.png" width="99%"></div>
  <div class="aktion">'.$aktion.'<br><hr></div>
  <div width=100%>';
}				
// ----------------------------------------------------------------------------						
// HTML-Header ausgeben
// ----------------------------------------------------------------------------
function putHtmlFoot()
{
echo '
  </div>
</div>
</center>
</body>
</html>';
}
// ----------------------------------------------------------------------------
// HTML-Footer für die IKndex-Dateien ausgeben
// ----------------------------------------------------------------------------
function putIndexFoot()
{
    global $mariella;
    
    echo '
<div>
  <br><br><hr>
  <span style="font-size:10px;color:cyan">'.$mariella.'</span><br><br><br>
  <a href="../index.php" target="_self"><input type="button" value="Startmenue" style="width:220px;"></a>
</div>';
}
// ----------------------------------------------------------------------------
//
//                      F I L E - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// korrekt formatierten Dateinamen zurückgeben
// ----------------------------------------------------------------------------
function formFileName($filename)
{
    $filename = str_replace("\\\\","\\",$filename);
    $filename = str_replace("//","/",$filename);
    
    return $filename;
}
// ----------------------------------------------------------------------------
// ParentPath zum angegebenen Pfad zurückgeben
// ----------------------------------------------------------------------------
function getParentPath($path)
{
    $tmp = basename($path);
    
    return str_replace($tmp,"",$path);
}
// ----------------------------------------------------------------------------
// Konfigurations-Vorgaben einlesen
// ----------------------------------------------------------------------------
function getConfData()
{
    global $pathsvn, $pathdata, $pathlevels, $pathstring;    
    
    $conffile  = "../config/path_config.txt";
    $lines     = file($conffile);
    $ok        = true;
    $max       = count($lines);
    
    for ($l=0;$l<$max;$l++)
    {
        if (substr($lines[$l],0,1) != "#")
        {
            $pos = stripos($lines[$l],"=");
            $key = trim(substr($lines[$l],0,$pos));
            $val = trim(substr($lines[$l],$pos + 1));
            
            switch ($key)
            {
                case "RootPathSvn":    $pathsvn    = $val; break;
                case "RootPathData":   $pathdata   = $val; break;
                case "RootPathLevels": $pathlevels = $val; break;
                case "PathToPsStrings":$pathstring = $val; break;
                default:                                   break;
            }            
        }
    }
    /*
    if (!file_exists($pathsvn))    {$ok = false;  logLine("nicht gefunden: RootPathSvn",$pathsvn);}
    if (!file_exists($pathdata))   {$ok = false;  logLine("nicht gefunden: RootPathData",$pathdata);}
    if (!file_exists($pathlevels)) {$ok = false;  logLine("nicht gefunden: RootPathLevels",$pathlevels);} 
    **/
    return $ok;    
}
// ----------------------------------------------------------------------------
// Ausgabe-Verzeichnisse prüfen
// ----------------------------------------------------------------------------
function checkOutPathes($taboutpath)
{
    for ($p=0;$p<count($taboutpath);$p++)
    {
        if (!file_exists($taboutpath[$p]))
            mkdir($taboutpath[$p]);
    }
}
// ----------------------------------------------------------------------------
// Öffnen Ausgabedatei mit Buffer_size (1 MB) und in Locked-Mode "exklusiv"
// ----------------------------------------------------------------------------
function openOutputFile($filename)
{
    if (!$hdlout = fopen($filename,"wt"))
        return false;
    else
    {         
        if (!set_file_buffer($hdlout,1048576))
        {
            logLine("Fehler","stream_buffer_size 1.048.576 KB konnte nicht gesetzt werden");
            return false;
        }
        
        if (!flock($hdlout,LOCK_EX))
        {
            logLine("Fehler","LOCK auf Datei konnte nicht gesetzt werden");
            return false;
        }
        return $hdlout;
    }
}
// ----------------------------------------------------------------------------
// Öffnen Eingabedatei mit Buffer_size und in Locked-Mode (exklusiv)
// ----------------------------------------------------------------------------
function openInputFile($filename)
{
    if (!$hdlin = fopen($filename,"rt"))
        return false;
    else
    {
        if (!set_file_buffer($hdlin,1048576))
        {
            logLine("Fehler","stream_buffer_size 1.048.576 KB konnte nicht gesetzt werden");
            return false;
        }
        
        if (!flock($hdlin,LOCK_EX))
        {
            logLine("Fehler","LOCK auf Datei konnte nicht gesetzt werden");
            return false;
        }
        return $hdlin;
    }
}
// ----------------------------------------------------------------------------
// Datei von UTF-16 nach UTF-8 konvertieren 
// Params:  $filename      = Filename in UTF16-Coding
// Return:  string         = Filename in UTF8-Coding
// ----------------------------------------------------------------------------
function convFileToUtf8($filename)
{                       
    $convfile = "parse_input_utf8\\".basename($filename);
        
    $allText = file_get_contents($filename);
    $allText = iconv("UTF-16","UTF-8",$allText);
    
    file_put_contents($convfile,$allText);
    
    unset($allText);
        
    return $convfile;
}
// ----------------------------------------------------------------------------
// die temporären UTF8-Dateien wieder löschen, um Ressourcen freizugeben
// ----------------------------------------------------------------------------
function cleanPathUtf8Files()
{
    $files = scandir("parse_input_utf8");
    $domax = count($files);
    
    for ($f=0;$f<$domax;$f++)
    {
        if ($files[$f] != "." && $files[$f] != "..")
            unlink("parse_input_utf8/".$files[$f]);
    }
}    
// ----------------------------------------------------------------------------
//
//                    F I L T E R - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// aus der Zeile den aktuellen XML-Tag ermitteln
// Beispiel:  <key>wert</key>, soll key zurückgeben
// ----------------------------------------------------------------------------
function getXmlKey($line)
{
    $xmlkey = substr($line,stripos($line,"<") + 1);
    $xmlkey = substr($xmlkey,0,stripos($xmlkey,">"));
    
    return $xmlkey;
}
// ----------------------------------------------------------------------------
// zum angegebenen XML-Key den Wert ermitteln
// Beispiel: <key>wert</key>, soll wert zurückgeben
// ----------------------------------------------------------------------------
function getXmlValue($key,$line)
{    
    $such = "<".$key.">";
    $ret  = substr($line,stripos($line,$such) + strlen($such));
    $ret  = substr($ret,0,stripos($ret,"<"));
        
    return $ret;
}
// ----------------------------------------------------------------------------
// zum angegebenen Schlüssel den Wert ermitteln
// Beispiel: name="wert", soll den wert zurückgeben
// ----------------------------------------------------------------------------
function getKeyValue($key,$line)
{
    $such = " ".$key."=";
    
    if (stripos($line,$such) !== false)
    {
        $ret  = trim(substr($line,stripos($line,$such) + strlen($such) + 1));
        $ret  = substr($ret,0,stripos($ret,'"'));
    }
    else
        $ret = "?";
        
    return $ret;
}
// ----------------------------------------------------------------------------
// Werte um nachfolgende Nullen kürzen                                     
// ----------------------------------------------------------------------------
function getFloatValue($wert)
{
    $ret = rtrim($wert,"0");
    
    if (substr($ret,-1,1) == ".")
        $ret .= "0";
    
    if ($ret == "0.0")
        $ret = "?";
        
    return $ret;
}
// ----------------------------------------------------------------------------
// 5-stelligen Wert zurückgeben für die Sortierung
// ----------------------------------------------------------------------------
function getSortNumValue($wert)
{
    if     (intval($wert) <    10) return "00000".$wert;
    elseif (intval($wert) <   100) return "000".$wert;
    elseif (intval($wert) <  1000) return "00".$wert;
    elseif (intval($wert) < 10000) return "0".$wert;
    else                           return $wert;
}
// ----------------------------------------------------------------------------
//
//                       L O G - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Logging sttarten
// ----------------------------------------------------------------------------
function logStart()
{
    echo "\n<table style='width:100%'>";
	echo "\n  <colgroup>";
	echo "\n    <col style='width:25%;'>";
	echo "\n    <col style='width:10%;'>";
	echo "\n    <col style='width:65%;'>";
	echo "\n  </colgroup>";
}
// ----------------------------------------------------------------------------
// Log-Zeile ausgeben
// ----------------------------------------------------------------------------
function logLine($cnt,$text,$msg="")
{    
    if ($msg != "")
		echo "\n  <tr>  <td>$cnt</td> <td style='color:lime;''>$text</font></td> <td>$msg</td> </tr>";
	else
		echo "\n  <tr>  <td>$cnt</td> <td colspan='2' style='text-align:left;color:lime'>$text</td> </tr>";
}
// ----------------------------------------------------------------------------
// Log-Header-Zeile ausgeben
// ----------------------------------------------------------------------------
function logHead($head)
{	
	if ($head != "" && $head != "&nbsp;")
		echo "\n  <tr> <td colspan=3><hr><h1 class='head'>$head</h1><hr></td> </tr>";
	else
		echo "\n  <tr> <td colspan=3><h1 class='head'>$head</h1></td> </tr>";
}
// ----------------------------------------------------------------------------
// Log-SubHeader-Zeile ausgeben
// ----------------------------------------------------------------------------
function logSubHead($head)
{	
	echo "\n  <tr> <td colspan=3 style='text-align:left;color:cyan'>$head</td> </tr>";
}
// ----------------------------------------------------------------------------
// Logging beenden
//
// params:  $start  = true = Schaltflache für "Startmenue"
//          $menue  = true = Schaltfläche für "Auswahlmenue"
// ----------------------------------------------------------------------------
function logStop($starttime,$start=false,$menue=false)
{
    global $mariella;
    
	$usetime = substr(microtime(true) - $starttime, 0, 8);
	
	echo "\n  <tr> <td colspan=3>&nbsp;</td> </tr>";
    echo "\n  <tr> <td colspan=3 style='font-size:11px;text-align:center;color:cyan;border-top:1px solid cyan;padding-top:5px;'>$mariella - ".
	     "Generated in $usetime Seconds</td> </tr>";
	echo "\n</table>";
    
    if ($menue)
        echo '
<div>
  <center>
  <br><br>
  <a href="index.php" target="_self"><input type="button" value="Auswahlmenue" style="width:220px;background-color:cyan"></a>
  </center>
</div>';
    
    if ($start)
        echo '
<div>
  <center>
  <br><br>
  <a href="../index.php" target="_self"><input type="button" value="Startmenue" style="width:220px;"></a>
  </center>
</div>';
}	
// ----------------------------------------------------------------------------				
// Anzeige der Dateigrösse
// ----------------------------------------------------------------------------
function logFileSize($text,$filename)
{
    $aktsize = filesize($filename);
    
    if ($aktsize > (1024*1024))
        logLine($text."Dateigr&ouml;sse ca.",round(filesize($filename)/(1024*1024),1)." MB");
    else
        logLine($text."Dateigr&ouml;sse ca.",round(filesize($filename)/(1024),1)." KB");
}
// ----------------------------------------------------------------------------
//
//                 E R W E I T E R U N G S - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// baut eine Tabelle mit den X-/Y-/Z-Angaben aus der alten Spawn-Datei auf, um
// einige der Z-Angaben automatisch korrigieren zu können 
//
// params :  oldfile = Dateiname (inkl. Pfad) alte Datei
//           xmlkey  = XML-Suchzeile für Positionen (z.B. "<spot")
// returns:  true    = Tabelle aufgebaut
//           false   = Tabelle konnte nicht aufgebaut werden
// ----------------------------------------------------------------------------
function getPosTabFromOldFile($oldfile,$xmlkey)
{
    global $tabPosOld;
    
    $tabPosOld = array();
    
    if (!file_exists($oldfile))
        return false;
        
    $hdlin = openInputFile($oldfile);
    
    while (!feof($hdlin))
    {
        $line = rtrim(fgets($hdlin));
        
        if (stripos($line,$xmlkey) !== false)
        {
            $xpos = getKeyValue("x",$line);
            $ypos = getKeyValue("y",$line);
            $zpos = getKeyValue("z",$line);
            $xkey = intval(round($xpos));
            $ykey = intval(round($ypos));
            $zkey = intval(round($zpos));
            
            $tabPosOld[$xkey][$ykey][$zkey] = $zpos;
        }
    }
    if (count($tabPosOld) > 0)
        return true;
        
    return false;
}
// ----------------------------------------------------------------------------
// zu einer Vorgabe von X/Y eine annähernde Z-Angabe suchen
// ----------------------------------------------------------------------------
function getOldZPosFromTab($xpos,$ypos,$zpos)
{
    global $tabPosOld;
    
    $diff = 10;                           // max. Abweichung von X/Y
    $diffz=  5;                           // max. Abweichung für Z
    $xkey = intval(round($xpos));         // X-Tab-Schlüssel berechnen
    $ykey = intval(round($ypos));         // Y-Tab-Schlüssel berechnen
    $zkey = intval(round($zpos));         // Z-Tab-Schlüssel berechnen
        
    // Differenzensuche für X-Pos
    for ($xd=0;$xd<=$diff;$xd++)
    {    
        // (+) X-Eintrag suchen    
        $xnow = $xkey + $xd;                      
                
        if (isset($tabPosOld[$xnow]))
        {           
            for ($yd=0;$yd<=$diff;$yd++)
            {
                // (+) Y-Eintrag suchen
                $ynow = $ykey + $yd;          
                   
                if (isset($tabPosOld[$xnow][$ynow]))
                {                    
                    // (+-) Differenzensuche für Z-Pos
                    for ($yz=0;$yz<=$diffz;$yz++)
                    {
                        // (-) Z-Eintrag suchen (da meistens geringer)
                        $znow = $zkey - $yz;   
                            
                        if (isset($tabPosOld[$xnow][$ynow][$znow]))
                        {
                            return $tabPosOld[$xnow][$ynow][$znow];
                        }
                        // (+) Z-Eintrag suchen
                        $znow = $zkey + $yz;   
                            
                        if (isset($tabPosOld[$xnow][$ynow][$znow]))
                        {  
                            return $tabPosOld[$xnow][$ynow][$znow];
                        }
                    }
                }
            }  
            
            for ($yd=0;$yd<=$diff;$yd++)
            {
                // (-) Y-Eintrag suchen
                $ynow = $ykey - $yd;          
                   
                if (isset($tabPosOld[$xnow][$ynow]))
                {                    
                    // (+-) Differenzensuche für Z-Pos
                    for ($yz=0;$yz<=$diffz;$yz++)
                    {
                        // (-) Z-Eintrag suchen (da meistens geringer)
                        $znow = $zkey - $yz;  
                            
                        if (isset($tabPosOld[$xnow][$ynow][$znow]))
                        {  
                            return $tabPosOld[$xnow][$ynow][$znow];
                        }
                        // (+) Z-Eintrag suchen
                        $znow = $zkey + $yz;   
                            
                        if (isset($tabPosOld[$xnow][$ynow][$znow]))
                        {  
                            return $tabPosOld[$xnow][$ynow][$znow];
                        }
                    }
                }
            }
        }        
        // (-) X-Eintrag suchen    
        $xnow = $xkey - $xd;                      
                
        if (isset($tabPosOld[$xnow]))
        {           
            for ($yd=0;$yd<=$diff;$yd++)
            {
                // (+) Y-Eintrag suchen
                $ynow = $ykey + $yd;          
                   
                if (isset($tabPosOld[$xnow][$ynow]))
                {                    
                    // (+-) Differenzensuche für Z-Pos
                    for ($yz=0;$yz<=$diffz;$yz++)
                    {
                        // (-) Z-Eintrag suchen (da meistens geringer)
                        $znow = $zkey - $yz;   
                                                    
                        if (isset($tabPosOld[$xnow][$ynow][$znow]))
                        {
                            return $tabPosOld[$xnow][$ynow][$znow];
                        }
                        // (+) Z-Eintrag suchen
                        $znow = $zkey + $yz;  
                            
                        if (isset($tabPosOld[$xnow][$ynow][$znow]))
                        {  
                            return $tabPosOld[$xnow][$ynow][$znow];
                        }
                    }
                }
            }  
            
            for ($yd=0;$yd<=$diff;$yd++)
            {
                // (-) Y-Eintrag suchen
                $ynow = $ykey - $yd;          
                   
                if (isset($tabPosOld[$xnow][$ynow]))
                {                    
                    // (+-) Differenzensuche für Z-Pos
                    for ($yz=0;$yz<=$diffz;$yz++)
                    {
                        // (-) Z-Eintrag suchen (da meistens geringer)
                        $znow = $zkey - $yz;   
                            
                        if (isset($tabPosOld[$xnow][$ynow][$znow]))
                        {   
                            return $tabPosOld[$xnow][$ynow][$znow];
                        }
                        // (+) Z-Eintrag suchen
                        $znow = $zkey + $yz;  
                            
                        if (isset($tabPosOld[$xnow][$ynow][$znow]))
                        {  
                            return $tabPosOld[$xnow][$ynow][$znow];
                        }
                    }
                }
            }
        }        
    }
      
    // keine Annäherung gefunden, also Original zurückgeben
    return $zpos;
}
?>