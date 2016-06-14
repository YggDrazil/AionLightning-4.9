<html>
<head>
  <title>
    PlayerTitles - Erzeugen player_titles.xml"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
include("../includes/inc_globals.php");

getConfData();

if (!file_exists("../outputs/parse_output"))
    mkdir("../outputs/parse_output");

$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen Player-Titles-Datei</div>
  <div class="hinweis" id="hinw">
    Erzeugen der player_titles.xml-Datei.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genPlayerTitles.php" target="_self">
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
// ermitteln ID
// ----------------------------------------------------------------------------
function getNameId($desc)
{
    global $tabNames;
    
    $name = strtoupper( $desc );
    
    if (isset($tabNames[$name]))
        return $tabNames[$name]['id'];
    else
        return "???";
}
// ----------------------------------------------------------------------------
// ermitteln Name 
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
// PlayerTitles-Datei ausgeben
// ----------------------------------------------------------------------------
function generPlayerTitlesFile()
{
    global $pathdata;
    
    $fileu16 = formFileName($pathdata."\\PC\\client_titles.xml");  
    $fileext = convFileToUtf8($fileu16);
    $fileout = "../outputs/parse_output/player_titles.xml";  
    
    logHead("Generierung der Datei");
    logLine("Eingabedatei UTF16",$fileu16);
    logLine("Eingabedatei UTF8",$fileext);
    logLine("Ausgabedatei",$fileout);
    
    $cntles = 0;
    $cntout = 0;
    
    $hdlout = openOutputFile($fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
    fwrite($hdlout,'<player_titles>'."\n");
    $cntout += 2;
    
    $lines = file($fileext);
    $domax = count($lines);
    
    $id   = $desc = $nameid = $name = $race = "";
    $attr = array();
    $acnt = 0;
    
    for ($l=0;$l<$domax;$l++)
    {
        $line = rtrim($lines[$l]);
        $cntles++;
              
        if (stripos($line,"<?xml") === false
        &&  stripos($line,"<client_title>") === false)
        {            
            // Start ClientTitle
            if     (stripos($line,"<id>")                !== false) $id     = getXmlValue("id",$line);
            elseif (stripos($line,"<desc>")              !== false) $desc   = strtoupper(getXmlValue("desc",$line));
            elseif (stripos($line,"<bonus_attr>")        !== false)
            {
                $attr[$acnt]   = getXmlValue("bonus_attr",$line);
                $acnt++;
            }
            elseif (stripos($line,"</client_title>") !== false) 
            {
                $nameid = (getNameId($desc) * 2) + 1;
                $name   = getName($desc);
                $amax   = count($attr);
                
                if     (stripos($desc,"_LIGHT_") !== false) $race = "ELYOS";
                elseif (stripos($desc,"_DARK_")  !== false) $race = "ASMODIANS";
                else                                        $race = "PC_ALL";
                /*
                  <title id="1" nameId="2201801" desc="Poeta's Protector" race="ELYOS">
                        <modifiers>
                            <add name="MAXHP" value="20" bonus="true"/>
                            <add name="PHYSICAL_DEFENSE" value="5" bonus="true"/>
                        </modifiers>
                    </title>      
                */                
                fwrite($hdlout,'    <title id="'.$id.'" nameId="'.$nameid.'" desc="'.$name.'" race="'.$race.'">'."\n");
                fwrite($hdlout,'        <modifiers>'."\n");
                $cntout += 2;
                
                for ($a=0;$a<$amax;$a++)
                {
                    $tab    = explode(" ",$attr[$a]);
                    $tab[0] = getBonusAttrName($tab[0]);
                    $tab[1] = isset($tab[1]) ? $tab[1] : 1;
                    $xml    = "add";
                    
                    if (stripos($tab[1],"%") !== false)
                    {
                        $tab[1] = trim(str_replace("%","",$tab[1]));
                        $xml    = "rate";
                    }
                    
                    // AttackDelay = * -1
                    if ($tab[0] == "ATTACK_SPEED") $tab[1] = intval($tab[1]) * -1;
                    
                    fwrite($hdlout,'            <'.$xml.' name="'.$tab[0].'" value="'.$tab[1].'" bonus="true"/>'."\n");
                    $cntout++;
                }
                fwrite($hdlout,'        </modifiers>'."\n");
                fwrite($hdlout,'    </title>'."\n");
                $cntout += 2;
    
                $id   = $desc = $nameid = $name = $race = "";
                $attr = array();
                $acnt = 0;
            }
        }
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</player_titles>");
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
        generPlayerTitlesFile();
        
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