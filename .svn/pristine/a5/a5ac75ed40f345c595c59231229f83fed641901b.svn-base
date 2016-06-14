<?PHP
// ----------------------------------------------------------------------------
// Modul  :  inc_inc_scan.php
// Version:  1.01, Mariella, 03/2016
// Zweck  :  erzeugt die notwendigen Includes
// ----------------------------------------------------------------------------
// Übergangsphase, weil neue Include-Namen vergeben wurden, werden die bis-
// herigen Dateien umbenannt !!!    
// ----------------------------------------------------------------------------

if (file_exists("includes/inc_clientitemnames.php"))
    rename("includes/inc_clientitemnames.php","includes/auto_inc_clientitem_names.php");
if (file_exists("includes/inc_emuitemnames.php"))
    rename("includes/inc_emuitemnames.php","includes/auto_inc_emuitem_names.php");
if (file_exists("includes/inc_gather_infos.php"))
    rename("includes/inc_gather_infos.php","includes/auto_inc_gather_infos.php");

// ----------------------------------------------------------------------------
// Anpassungen für Client 4.9:
// die Includes auto_inc_clientitem_names.php und auto_inc_emuitem_names.php
// wurden zusammengelegt und die Namen nun aus den PS-String-Dateien ermittelt!
// Das neue Include besitzt nun den Namen: auto_inc_item_infos.php. Daher sind
// die beiden alten Includes nicht mehr erforderlich und werden gelöscht.
//
// Das Include inc_npc_infos.php wurde ebenfalls abgelöst und durch das neue
// Include auto_inc_npc_infos.php ersetzt. Auch werden die Namen aus den PS
// String-Dateien ermittelt.
// ----------------------------------------------------------------------------

if (file_exists("includes/auto_inc_clientitem_names.php"))
    unlink("includes/auto_inc_clientitem_names.php");
if (file_exists("includes/auto_inc_emuitem_names.php"))
    unlink("includes/auto_inc_emuitem_names.php");
if (file_exists("includes/inc_npc_infos.php"))
    unlink("includes/inc_npc_infos.php");
    
// ----------------------------------------------------------------------------
// Anapssungen wegen Pfad-Korrekturen
//
// es soll die Struktur wie im SVN erzeugt werden
// ----------------------------------------------------------------------------
$tabMoves = array( "goodslists",
                   "Items",
                   "Quest",
                   "tribe"
                  );
$maxMoves = count($tabMoves);

for ($m=0;$m<$maxMoves;$m++)
{
    $old = "../outputs/".$tabMoves[$m];
    $new = "../outputs/parse_output/".$tabMoves[$m];
    
    if (file_exists($old))
        rename($old,$new);
}    
// einige Dateien verschieben
if (file_exists("../outputs/parse_output/goodslists/npc_trade_list.xml"))
    rename("../outputs/parse_output/goodslists/npc_trade_list.xml","../outputs/parse_output/npc_trade_list.xml");
if (file_exists("../outputs/parse_output/Items/item_sets.xml"))
{
    if (!file_exists("../outputs/parse_output/item_sets"))
        mkdir("../outputs/parse_output/item_sets");
   
    rename("../outputs/parse_output/Items/item_sets.xml","../outputs/parse_output/item_sets/item_sets.xml");   
}
if (file_exists("../outputs/parse_output/Quest/quest_script_data"))
    rename("../outputs/parse_output/Quest/quest_script_data","../outputs/parse_output/quest_script_data");
if (file_exists("../outputs/parse_output/Quest"))
    rename("../outputs/parse_output/Quest","../outputs/parse_output/quest_data");
if (file_exists("../outputs/parse_output/npc_templates.xml"))
    rename("../outputs/parse_output/npc_templates.xml","../outputs/parse_output/npcs/npc_templates.xml");
// ----------------------------------------------------------------------------
// Voreinstellungen
// ----------------------------------------------------------------------------
$isFirstInclude = true;

if (file_exists("auto_inc_item_infos.php")
&&  file_exists("auto_inc_quest_names.php"))
{
    include_once("auto_inc_item_infos.php");
    include_once("auto_inc_quest_names.php");
} 
include_once("inc_getautonameids.php");
    
// ----------------------------------------------------------------------------
// notwendige PHP-Includes erzeugen, wenn noch nicht vorhanden
// ----------------------------------------------------------------------------
function checkAutoIncludeFiles()
{    
    // aus Gründen der Übersichtlichkeit Verarbeitung mittels Tabelle
    // neue, notwendige Include-ateien bitte in die nachfolgende Tabelle eintragen
    // (Name der Include-Datei, Name der Funktion zur Erstellung)
    $incFiles = array( 
                  //    Include-Datei-Name                Erstellungs-Funktionsname
                  // 1. Basis-Tabellen, die auch zum Erstellen anderer Includes genutzt werden
                  array("auto_inc_anim_names.php"        ,"makeIncludeAnimNames"),
                  array("auto_inc_auth_names.php"        ,"makeIncludeAuthNames"),
                  array("auto_inc_desc_names.php"        ,"makeIncludeDescNames"),
                  array("auto_inc_housedeco_names.php"   ,"makeIncludeHouseDecoNames"),
                  array("auto_inc_houseobject_names.php" ,"makeIncludeHouseObjectNames"),
                  array("auto_inc_item_names.php"        ,"makeIncludeItemNames"),       // neu in 4.9
                  array("auto_inc_polish_names.php"      ,"makeIncludePolishNames"),
                  array("auto_inc_quest_names.php"       ,"makeIncludeQuestNames"),
                  array("auto_inc_recipe_names.php"      ,"makeIncludeRecipeNames"),
                  array("auto_inc_ride_names.php"        ,"makeIncludeRideNames"),
                  array("auto_inc_rndopt_names.php"      ,"makeIncludeRandomOptionNames"),
                  array("auto_inc_robot_names.php"       ,"makeIncludeRobotNames"),
                  array("auto_inc_skill_names.php"       ,"makeIncludeSkillNames"),
                  array("auto_inc_skillreplace_names.php","makeIncludeSkillReplaceNames"),
                  array("auto_inc_title_names.php"       ,"makeIncludeNpcTitleNames"),   // neu in 4.9
                  array("auto_inc_toypet_names.php"      ,"makeIncludeToypetNames"),
                  array("auto_inc_world_names.php"       ,"makeIncludeWorldNames"),
                  // 2. Info-Tabellen
                  array("auto_inc_item_infos.php"        ,"makeIncludeItemInfos"),       // neu in 4.9
                  array("auto_inc_npc_infos.php"         ,"makeIncludeNpcInfos"),        // neu in 4.9
                  array("auto_inc_gather_infos.php"      ,"makeIncludeGatherInfos")
                );
                    
    $maxFiles = count($incFiles);
    
    for ($f=0;$f<$maxFiles;$f++)
    {
        if (!file_exists("includes/".$incFiles[$f][0]))
            $incFiles[$f][1]();
    }
}
// ----------------------------------------------------------------------------
// Ausgeben Hinweis auf VORARBEITEN - Client-Items
// ----------------------------------------------------------------------------
function writeHinweisVorarbeiten($teil="notwendige PHP-Includes")
{
    global $isFirstInclude;
    
    if ($isFirstInclude)
    {
        $isFirstInclude = false;
        
        logSubHead("<div style='background-color:#000033;border:1px solid silver;padding:20px;text-align:justify;'>".
                   "<center><h1>Vorarbeiten ($teil)</h1></center><br>".    
                   "Aus Performance-Gr&uuml;nden werden einige Informationen aus den Client-Dateien vorab gescannt und als ".
                   "CSV-/PHP-Include-Datei gespeichert. Wenn diese Dateien (auto_inc_...) neu erzeugt werden sollen, dann ".
                   "bitte die Schaltfl&auml;che &nbsp;'Includes neu erstellen'&nbsp; bet&auml;tigen! Es wird in diesem ".
                   "Durchgang noch KEINE Generierung der Datei item_templates.php vorgenommen!<br><br>".
                   "<center>Anschliessend bitte die <font color=magenta>Generierung erneut starten</font>!</center></div><br><br>");
    }
}
// ----------------------------------------------------------------------------
// Ausgeben Hinweis auf KEINE VORARBEITEN 
// ----------------------------------------------------------------------------
function writeHinweisOhneVorarbeiten($teil="sonstige")
{
    global $isFirstInclude;
    
    if ($isFirstInclude)
    {
        $isFirstInclude = false;
        
        logSubHead("<div style='background-color:#000033;border:1px solid silver;padding:20px;text-align:justify;'>".
                   "<center><h1>WICHTIGER HINWEIS</h1></center><br>".    
                   "Aus Performance-Gr&uuml;nden wurden einige Informationen aus den Client-Dateien vorab gescannt und als ".
                   "CSV-/PHP-Include-Datei gespeichert. Bei dieser Generierung werden diese vorab erzeugten Dateien genutzt. Wenn ".
                   "diese Dateien (auto_inc_...) neu erzeugt werden sollen, dann bitte die Schaltfl&auml;che &nbsp;".
                   "'Includes neu erstellen'&nbsp; bet&auml;tigen!</div><br><br>");
    }
}
// ----------------------------------------------------------------------------    
// Header-Doku für das zu erstellende Include-File erzeugen
// ----------------------------------------------------------------------------
function getIncludeFileHeader($file,$text,$script)
{
    global $doneGenerInclude;    
        
    $doneGenerInclude = true;
    
    $ret  = "<?PHP"."\n".
            "// ".str_pad("",77,"-")."\n".
            "//           A U T O M A T I S C H E   I N C L U D E - G E N E R I E R U N G"."\n".
            "// ".str_pad("",77,"-")."\n".
            "// Modul   : ".basename($file)."\n".
            "// Version : 1.01, Mariella, 03/2016"."\n".
            "// Zweck   : ".$text."\n".
            "// Erstellt: am  ".date("d.m.Y H:i")."  von  inc_inc_scan.php ($script)"."\n".
            "// ".str_pad("",77,"-");
            
    return $ret;
}
// ----------------------------------------------------------------------------
// Default-Erstellung von Referenztabellen mit Name => id          (03.03.2016)
//
// Wird Standard-mässig genutzt, wenn NUR eine Eingabedatei zu verarbeiten ist,
// und diese generell die beiden XML-Tags <id> und <name> beinhaltet!
//
// Params:  $outfile        Teile des Ausgabedatei-Namens 
//                          wird dann zu auto_inc_<$outfile>nameids.php
//          $pathtype       Kennung, welcher Pfad genommen werden soll
//                          DATA    = SVN-Data-Pfad
//                          STRING  = PS-String-Pfad
//          $infile         Sub-Pfad und Dateiname im extrahierten Client-Data
//          $tabname        Teil des Tabellen-Namens
//                          wird dann zu $tab<$tabname>Names
//          $conv           Konvertierung nach UTF8 erforderlich (immer true)
// ----------------------------------------------------------------------------
function makeIncludeDefaultNameId($outfile,$pathtype,$infile,$tabname,$conv)
{    
    global $pathdata,$pathstring;
    
	writeHinweisVorarbeiten();
    
    $fileout  = "includes/auto_inc_".$outfile."_names.php";
    $getpath  = "";
    
	logHead("Erzeugen Include mit den $tabname-Namen");
    logLine("Ausgabedatei",$fileout);
	
    if (file_exists($fileout))
    {
        logLine("- Verarbeitung","es wird die vorhandene Datei genutzt");
        return;
    }
    
    switch($pathtype)
    {
        case "DATA":    $getpath = $pathdata;   break;
        case "STRING":  $getpath = $pathstring; break;
        default:        logLine("<font color=red>unbekannte Pfadtyp-Angabe",$pathtype);
                        return;
    }  
    
    $fileext = formFileName($getpath."\\".$infile);
    
    // sofern gesetzt, Datei von UTF16 nach UTF8 konvertieren
    if ($conv)
        $fileext = convFileToUtf8($fileext);
    
    logLine("Eingabedatei UTF8",$fileext);
    $hdlout   = openOutputFile($fileout);
    $lastline = "";
    $cntles   = 0;
    $cntitm   = 0;
    
    // Ausgabedatei: Vorspann ausgeben
    fwrite($hdlout,getIncludeFileHeader($fileout,"Referenztabelle - ".$tabname." Name => ID","genItem.php")."\n");
    fwrite($hdlout,"\n\$tab".$tabname."Names = array(\n");
        
    $hdlext = openInputFile($fileext);
    $id     = "";
    $name   = "";
    $body   = "";
    
    flush();        
    
    while (!feof($hdlext))
    {	
        $line = trim(fgets($hdlext));
        $cntles++;         
        
        if (stripos($line,"<id>") !== false)
            $id   = getXmlValue("id",$line);
            
        if (stripos($line,"<name>") !== false)
            $name = strtoupper(str_replace('"',"'",getXmlValue("name",$line)));
                        
        if ($id != "" && $name != "")
        {            
            // vorheriges Item in Datei ausgeben
            if ($lastline != "")
            {
                fwrite($hdlout,$lastline.",\n");
                $cntitm++;
                $lastline = "";
            }     
            $lastline = '                  "'.$name.'" => "'.$id.'"';
            
            $id = $name = "";
        }
    }	
    fclose($hdlext);        
    
    if ($lastline != "")
    {
        fwrite($hdlout,$lastline."\n");
        $cntitm++;
    }  
    
    // Nachspann erzeugen
    fwrite($hdlout,"                      );\n");
    fwrite($hdlout,"?>");    
    
    fclose($hdlout);
	logLine("Anzahl Zeilen gelesen",$cntles);
    logLine("Anzahl Items gefunden",$cntitm);
    
    // sofern gesetzt, UTF8-Datei wieder löschen
    if ($conv)
        unlink($fileext);
    
    flush();
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: Anim-Namen
// ----------------------------------------------------------------------------
function makeIncludeAnimNames()
{	
    makeIncludeDefaultNameId(  "anim",
                               "DATA",
                               "Animations\\custom_animation.xml",
                               "Anim",
                               true);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: Auth-Namen
// ----------------------------------------------------------------------------
function makeIncludeAuthNames()
{	
    makeIncludeDefaultNameId(  "auth",
                               "DATA",
                               "Items\\client_item_authorizetable.xml",
                               "Auth",
                               true);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: inc_gather_infos.php
// ----------------------------------------------------------------------------
function makeIncludeGatherInfos()
{
    global $pathsvn, $pathdata, $pathstring;
        
	writeHinweisVorarbeiten();
    
    $tabfiles = array( "client_strings_item.xml",
                       "client_strings_item2.xml",
                       "client_strings_item3.xml"
                     );
    $maxfiles = count($tabfiles);
    $tabstr   = array();
    $tabsvn   = array();
    $tabincl  = array();
    
    $fileout  = "includes/auto_inc_gather_infos.php";
    $filesvn  = formFileName($pathsvn."\\trunk\\AL-Game\\data\\static_data\\gatherables\\gatherable_templates.xml");
    $fileext  = formFileName($pathdata."\\Gather\\gather_src.xml");
    
    logHead("Erzeuge Include mit den Gather-Infos");
    logLine("Ausgabedatei",$fileout);
    
    // Scanne PS-Strings
    logSubHead("Scanne die PS-String-Dateien");
    
    $name = "";
    $body = "";
    
    for ($f=0;$f<$maxfiles;$f++)
    {
        $filestr = formFileName($pathstring."\\".$tabfiles[$f]);
        $hdlstr  = openInputFile($filestr);
        
        if (!$hdlstr)
        {
            logLine("Fehler OpenInputFile",$filestr);
            return;
        }
        
        logLine("- Eingabedatei",$filestr);
        
        flush();
        
        while (!feof($hdlstr))
        {
            $line = rtrim(fgets($hdlstr));
            
            if     (stripos($line,"<name>")    !== false)
                $name = strtoupper(getXmlValue("name",$line));
            elseif (stripos($line,"<body>")    !== false)
                $body = getXmlValue("body",$line);
            elseif (stripos($line,"</string>") !== false)
            {
                $tabstr[$name] = $body;
                
                $name = $body = "";
            }
        }
        fclose($hdlstr);
    }
    
    // Scanne alte Datei    
    logSubHead("Scanne SVN-Datei: $filesvn");
    
    flush();
    
    $cntles = 0;
    $cntnpc = 0;
    $hdlsvn = openInputFile($filesvn);
    
    $id    = "";
    $name  = "";
    $offi  = "";
    $nid   = "";
        
    while (!feof($hdlsvn))
    {
        $line = rtrim(fgets($hdlsvn));
        $cntles++;
        
        if (stripos($line,"<gatherable_template ") !== false)
        {
            $cntnpc++;
            
            $id   = getkeyValue("id",$line);
            $name = getKeyValue("name",$line);
            $nid  = getKeyValue("nameId",$line);
            
            $tabsvn[$id] = $name;
        }
    }
    fclose($hdlsvn);
    
    logLine("Anzahl Zeilen gelesen",$cntles);
    logLine("gefundene Gather-Infos",$cntnpc);
     
    // Scanne Client-Datei
    
    logSubHead("Scanne EXT-Datei: $fileext");    
    $fileext = convFileToUtf8($fileext);
    
    logLine("UTF8-Konvertierung",$fileext);
    
    $cntles = 0;
    $cntnpc = 0;
    $cntupd = 0;
    $cntins = 0;
    $hdlext = openInputFile($fileext);
    
    $id     = "";
    $name   = "";
    $offi   = "";
    $desc   = "";
    $nid    = "";
        
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        $cntles++;
        
        if     (stripos($line,"<id>")         !== false)
            $id   = getXmlValue("id",$line);            
        elseif (stripos($line,"<name>")       !== false)    
            $offi = strtoupper(getXmlValue("name",$line));     
        elseif (stripos($line,"<desc>")       !== false)    
            $desc = strtoupper(getXmlValue("desc",$line));
        elseif (stripos($line,"<gather_src>") !== false)
        {      
            $cntnpc++;
            
            if (isset($tabincl[$id]))
            {
                $tabincl[$id]['offi'] = $offi;
                $cntupd++;
            }
            else
            {
                if (isset($tabstr[$desc]))
                    $name = $tabstr[$desc];
                else
                    logLine("<font color=lime>ItemName fehlt",$offi);
                    
                // kein Name vorhanden, dann im SVN suchen
                if ($name == "")
                {
                    // wenn im SVN vorhanden, dann diesen Namen nehmen
                    if (isset($tabsvn[$id]))
                        $name = $tabsvn[$id];
                    else
                        $name = strtolower($offi);
                    
                }
                        
                $tabincl[$id]['id']   = $id;
                $tabincl[$id]['name'] = $name;
                $tabincl[$id]['nid']  = $nid;
                $tabincl[$id]['offi'] = $offi;
                $tabincl[$id]['desc'] = $desc;
                $cntins++;
            }
            $id = $offi = "";
        }
    }
    fclose($hdlext);
    
    logLine("Anzahl Zeilen gelesen",$cntles);
    logLine("gefundene Gather-Infos",$cntnpc);
    logLine("- davon vorhanden",$cntupd);
    logLine("- davon neuangelegt",$cntins);
    
    logSubHead("Erzeuge Include-Datei: $fileout");
    
    $cntnpc = 0;
    $cntout = 0;
    
    $hdlout   = openOutputFile($fileout);
    $lastline = "";
    
    // Vorspann ausgeben
    fwrite($hdlout,getIncludeFileHeader($fileout,"Referenztabelle - Gather Name => id,name,offiname","genGather.php")."\n");
    fwrite($hdlout,"\$tabGatherInfos = array(\n");
    $cntout += 2;
    
    while (list($key,$val) = each($tabincl))
    {
        if ($lastline != "")
        {
            fwrite($hdlout,$lastline.",\n");
            $cntnpc++;
            $cntout++;
        }
            
        $lastline = '                    "'.
                    strtoupper($tabincl[$key]['offi']).'" => array( "npc_id" => "'.
                    $tabincl[$key]['id'].'", "name" => "'.
                    $tabincl[$key]['name'].'", "offiname" => "'.
                    $tabincl[$key]['desc'].'")';                       
    }
    if ($lastline != "")
    {
        fwrite($hdlout,$lastline."\n");
        $cntnpc++;
        $cntout++;
    }
    
    // Nachspann ausgeben
    fwrite($hdlout,"                       );");
    $cntout++;
    
    fclose($hdlout);
    
    logLine("geschriebene Zeilen",$cntout);
    logLine("ausgegebene Gather-Infos",$cntnpc);
    
    unlink($fileext);
    
    flush();
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: Item-Infos
// ----------------------------------------------------------------------------
function makeIncludeItemInfos()
{
    global $pathdata, $pathstring;
    
    writeHinweisVorarbeiten();
    
    $tabXml = array( "client_items_misc.xml",
                     "client_items_etc.xml",
                     "client_items_armor.xml"
                   );
    $maxXml = count($tabXml);
    
    $tabStr = array( "client_strings_item.xml",
                     "client_strings_item2.xml",
                     "client_strings_item3.xml",
                     "client_strings_quest.xml"
                   );
    $maxStr = count($tabStr);
    $tabItm = array();
    
    $fileout = "includes/auto_inc_item_infos.php";
    $tabName = array();
    
    logHead("Erzeugen Include mit den Item-Infos");
    logLine("Ausgabedatei",$fileout);
    
    // 1. Schritt: Namen aus den PS-String-Dateien einlesen
    logSubHead("Scanne die PS-String-Dateien");
    
    flush();
    
    $name   = "";
    $body   = "?";
    $cntitm = 0;
        
    for ($f=0;$f<$maxStr;$f++)
    {
        $filestr = formFileName($pathstring."\\".$tabStr[$f]);
        $hdlstr  = openInputFile($filestr);
        
        logLine("- Eingabedatei",$filestr);
        
        flush();
                
        while (!feof($hdlstr))
        {
            $line = rtrim(fgets($hdlstr));
            
            if     (stripos($line,"<name>") !== false)
                $name = strtoupper(getXmlValue("name",$line));
            elseif (stripos($line,"<body>") !== false)
                $body = getXmlValue("body",$line);
            elseif (stripos($line,"</string>") !== false)
            {
                // Sonderbehandlung für Item 150000001
                if ($name == "STR_TOOLTIP_ACTIONKEY_CONVERT" && ($body == "" || $body == "?"))
                    $body = "Transformation Ability";
                    
                $name = str_replace("_DECE_","_DECO_",$name);
                
                // Sonderzeichen im Namen ersetzen
                $body = str_replace('"',"'",$body);
                                    
                $tabName[$name] = $body;
                $cntitm++;
                
                $name = "";
                $body = "?";
            }
        }
        fclose($hdlstr);
    }
    logLine("Anzahl gefundene Item-Namen",$cntitm);
    
    // 2. Schritt: Daten aus den Client-Files einlesen
    $id     = "";
    $name   = "";
    $desc   = "";
    $cntitm = 0;
    
    flush();
    
    logSubHead("Scanne die Client-Item-Files");
    
    for ($f=0;$f<$maxXml;$f++)
    {
        $fileutf16 = formFileName($pathdata."\\Items\\".$tabXml[$f]);
        $fileutf8  = convFileToUtf8($fileutf16);
        $hdlext    = openInputFile($fileutf8);
        
        logLine("- Eingabedatei",$fileutf8);
        
        flush();
        
        while (!feof($hdlext))
        {
            $line = rtrim(fgets($hdlext));
            
            if     (stripos($line,"<id>") !== false)
                $id   = getXmlValue("id",$line);
            elseif (stripos($line,"<name>") !== false)
                $name = strtoupper(getXmlValue("name",$line));
            elseif (stripos($line,"<desc>") !== false)
                $desc = strtoupper(getXmlValue("desc",$line));
            elseif (stripos($line,"</client_item>") !== false)
            {
                $desc = str_replace("_DECE_","_DECO_",$desc);
                
                if ($name != "")
                {
                    if (!isset($tabItm[$name]))
                    {
                        $tabItm[$name]['desc'] = $desc;
                        $tabItm[$name]['id']   = $id;
                        
                        if (isset($tabName[$desc]))
                            $tabItm[$name]['name'] = $tabName[$desc];
                        else
                            $tabItm[$name]['name'] = "?";
                        
                        $id = $desc = $name = "";
                        $cntitm++;
                    }
                    else
                        if ($tabItm[$desc]['id'] != $id)
                            logLine("DUPLICATE ItemDescName!",$id." / ".$desc);
                }
            }
        }
        fclose($hdlext);
        unlink($fileutf8);
    }
    logLine("Anzahl gefundene Items",$cntitm);
    
    // 3. Schritt: erzeugen der Include-Datei
    logSubHead("Erzeuge das Auto-Include");
    $hdlout   = openOutputFile($fileout);
    fwrite($hdlout,getIncludeFileHeader($fileout,"Info-Tabelle - Item Name => id","genItem.php")."\n");    
    fwrite($hdlout,"\$tabItemInfos = array(\n");
    // Vospann ausgeben
    $lastline = "";
    
    flush();
    
    while (list($key,$val) = each($tabItm))
    {
        if ($lastline != "")
            fwrite($hdlout,$lastline.",\n");
            
        $lastline = '                 "'.$key.'" => array('.'"id" => "'.
                    $tabItm[$key]['id'].'", "name" => "'.$tabItm[$key]['name'].'", "desc" => "'.
                    $tabItm[$key]['desc'].'")';
    }
    if ($lastline != "")
        fwrite($hdlout,$lastline."\n");
    // Nachspann ausgeben    
    fwrite($hdlout,"                );\n");
    fwrite($hdlout,"?>");
    
    fclose($hdlout);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: Desc-Namen
// ----------------------------------------------------------------------------
function makeIncludeDescNames()
{
	global $pathstring;
    
	writeHinweisVorarbeiten();
	
    $tabFiles = array( "client_strings_item.xml",
                       "client_strings_item2.xml",
                       "client_strings_item3.xml"
                     );
    $maxFiles = count($tabFiles);
    $fileout  = "includes/auto_inc_desc_names.php";
    
	logHead("Erzeugen Include mit den Desc-Namen aus ...SVN../item_strings_item....xml");
    logLine("Ausgabedatei",$fileout);
	
    if (file_exists($fileout))
    {
        logLine("- Verarbeitung","es wird die vorhandene Datei genutzt");
        return;
    }
        
    $hdlout   = openOutputFile($fileout);
    $lastline = "";
    $cntles   = 0;
    $cntitm   = 0;
    $gesitm   = 0;
    
    // Ausgabedatei: Vorspann ausgeben
    fwrite($hdlout,getIncludeFileHeader($fileout,"Referenztabelle - ClientDesc Name => id","genItem.php")."\n");
    fwrite($hdlout,"\n\$tabDescNames = array(\n");
    
	for ($f=0;$f<$maxFiles;$f++)
    {
        $fileext = formFileName($pathstring."\\".$tabFiles[$f]);
        logSubHead("Scanne Datei: ".$fileext);
        //$fileext = convFileToUtf8($fileext);
        logLine("Eingabedatei",$fileext);
        
        $hdlext = openInputFile($fileext);
        $id     = "";
        $name   = "";
        $cntitm = 0;
        $cntles = 0;
        
        flush();        
        
        while (!feof($hdlext))
        {	
            $line = trim(fgets($hdlext));
            $cntles++; 
            
            // vorheriges Item in Datei ausgeben
            if ($lastline != "")
            {
                fwrite($hdlout,$lastline.",\n");
                $cntitm++;
                $lastline = "";
            }     
            
            if (stripos($line,"<id") !== false || stripos($line,"<name>") !== false)
            {
                if     (stripos($line,"<id>") !== false)
                {
                    $id = getXmlValue("id",$line);      
                    $id = ($id * 2) + 1;
                }                    
                elseif (stripos($line,"<name>") !== false)
                {                    
                    $name     = getXmlValue("name",$line);
                    $lastline = '                  "'.strtoupper($name).'" => "'.$id.'"';
                }
            }
        }	
        fclose($hdlext);
        
        logLine("Anzahl Zeilen gelesen",$cntles);
        logLine("Anzahl Items gefunden",$cntitm);
        
        $gesitm += $cntitm;
        
        //  unlink($fileext);      
    }
    
    if ($lastline != "")
    {
        fwrite($hdlout,$lastline."\n");
        $cntitm++;
    }  
    
    // Nachspann erzeugen
    fwrite($hdlout,"                      );\n");
    fwrite($hdlout,"?>");    
    
    fclose($hdlout);
    
    logLine("Anzahl Items Gesamt",$gesitm);
    
    flush();
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: Quest-Namen
// ----------------------------------------------------------------------------
function makeIncludeQuestNames()
{	
    makeIncludeDefaultNameId(  "quest",
                               "STRING",
                               "client_strings_quest.xml",
                               "Quest",
                               false);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: RandomOption-Namen
// ----------------------------------------------------------------------------
function makeIncludeRandomOptionNames()
{
    makeIncludeDefaultNameId(  "rndopt",
                               "DATA",
                               "Items\\client_item_random_option.xml",
                               "RndOption",
                               true);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: Robot-Namen
// ----------------------------------------------------------------------------
function makeIncludeRobotNames()
{
    makeIncludeDefaultNameId(  "robot",
                               "DATA",
                               "robot\\robot.xml",
                               "Robot",
                               true);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: Skill-Namen
// ----------------------------------------------------------------------------
function makeIncludeSkillNames()
{
    makeIncludeDefaultNameId(  "skill",
                               "DATA",
                               "skills\\client_skills.xml",
                               "Skill",
                               true);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: SkillReplace-Namen
// ----------------------------------------------------------------------------
function makeIncludeSkillReplaceNames()
{
    makeIncludeDefaultNameId(  "skillreplace",
                               "DATA",
                               "skills\\skill_shortcut_replace.xml",
                               "SkillReplace",
                               true);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: World-Namen
// ----------------------------------------------------------------------------
function makeIncludeWorldNames()
{
	global $pathdata;
    
	writeHinweisVorarbeiten();
	
    $fileext = formFileName($pathdata."\\World\WorldId.xml");
    $fileext = convFileToUtf8($fileext);
    $fileout = "includes/auto_inc_world_names.php";
    
	logHead("Erzeugen Include mit den World-Namen");
    logLine("Ausgabedatei",$fileout);
	
    if (file_exists($fileout))
    {
        logLine("- Verarbeitung","es wird die vorhandene Datei genutzt");
        return;
    }
        
    $hdlout   = openOutputFile($fileout);
    $lastline = "";
    $cntles   = 0;
    $cntworld = 0;
    
    // Ausgabedatei: Vorspann ausgeben
    fwrite($hdlout,getIncludeFileHeader($fileout,"Referenztabelle - World Name => id","genItem.php")."\n");
    fwrite($hdlout,"\n\$tabWorldNames = array(\n");
    
    logLine("Eingabedatei",$fileext);
    logLine("Ausgabedatei",$fileout);;
    
    $hdlext = openInputFile($fileext);
    $id     = "";
    $name   = "";
    
    flush();        
    
    while (!feof($hdlext))
    {	
        $line = trim(fgets($hdlext));
        $cntles++; 
        
        // vorheriges Item in Datei ausgeben
        if ($lastline != "")
        {
            fwrite($hdlout,$lastline.",\n");
            $lastline = "";
        }     
        
        if (stripos($line,"<data") !== false)
        {
            $id   = getKeyValue("id",$line); 
            $name = substr($line,stripos($line,">") + 1);
            $name = substr($name,0,stripos($name,"<"));
            $cntworld++;
            
            $lastline = '                  "'.strtoupper($name).'" => "'.$id.'"';
        }
    }	
    fclose($hdlext);  
    
    unlink($fileext);
    
    if ($lastline != "")
    {
        fwrite($hdlout,$lastline."\n");
        $cntitm++;
    }  
    
    // Nachspann erzeugen
    fwrite($hdlout,"                       );\n");
    fwrite($hdlout,"?>");    
    
    fclose($hdlout);
	logLine("Anzahl Zeilen gelesen",$cntles);
    logLine("Anzahl Worlds gefunden",$cntworld);
    
    flush();
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: Recipe-Namen
// ----------------------------------------------------------------------------
function makeIncludeRecipeNames()
{
    makeIncludeDefaultNameId(  "recipe",
                               "DATA",
                               "Items\\client_combine_recipe.xml",
                               "Recipe",
                               true);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: Ride-Namen
// ----------------------------------------------------------------------------
function makeIncludeRideNames()
{
    makeIncludeDefaultNameId(  "ride",
                               "DATA",
                               "rides\\rides.xml",
                               "Ride",
                               true);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: Polish-Namen
// ----------------------------------------------------------------------------
function makeIncludePolishNames()
{
    makeIncludeDefaultNameId(  "polish",
                               "DATA",
                               "Items\\polish_bonus_setlist.xml",
                               "Polish",
                               true);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: HouseDeco-Namen
// ----------------------------------------------------------------------------
function makeIncludeHouseDecoNames()
{
    makeIncludeDefaultNameId(  "housedeco",
                               "DATA",
                               "Housing\\client_housing_custom_part.xml",
                               "HouseDeco",
                               true);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: HouseObject-Namen
// ----------------------------------------------------------------------------
function makeIncludeHouseObjectNames()
{	
    makeIncludeDefaultNameId(  "houseobject",
                               "DATA",
                               "Housing\\client_housing_object.xml",
                               "HouseObject",
                               true);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: Toypet-Namen
// ----------------------------------------------------------------------------
function makeIncludeToypetNames()
{
    makeIncludeDefaultNameId(  "toypet",
                               "DATA",
                               "func_pet\\toypets.xml",
                               "Toypet",
                               true);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: Item-Names
// ----------------------------------------------------------------------------
function makeIncludeItemNames()
{
    global $pathstring;    
    
    $tabString = array( "client_strings_item.xml",
                        "client_strings_item2.xml",
                        "client_strings_item3.xml"
                      );
    $maxString = count($tabString);
    $cntles    = 0;
    $cntitm    = 0;
    $cntout    = 0;
    $desc      = "";
    $body      = "";
    
    writeHinweisVorarbeiten();
    
    $fileout   = "includes/auto_inc_item_names.php";
    $hdlout    = openOutputFile($fileout);
    $lastline  = "";
    
    logHead("Erzeugen Include mit den Item-Namen");
    logLine("Ausgabedatei",$fileout);
    
    flush();
    
    // Vorspann ausgeben
    fwrite($hdlout,getIncludeFileHeader($fileout,"Referenz-Tabelle - Item Str-Name => Name","genItem.php")."\n");
    fwrite($hdlout,"\n\$tabItemNames = array(\n");
    
    for ($f=0;$f<$maxString;$f++)
    {
        $fileext = formFileName($pathstring."\\".$tabString[$f]);
        $hdlext  = openInputFile($fileext);
        $cntnpc  = 0;
        $cntles  = 0;
        
        logSubHead("Scanne Eingabedatei ".$fileext);
        
        flush();
        
        while (!feof($hdlext))
        {
            $line = rtrim(fgets($hdlext));
            $cntles++;
            
            if     (stripos($line,"<id>") !== false)
                $id    = getXmlValue("id",$line);
            elseif (stripos($line,"<name>") !== false)
                $desc  = strtoupper(getXmlValue("name",$line));
            elseif (stripos($line,"<body>") !== false)
                $body = str_replace('"','\"',getXmlValue("body",$line));
                
            if (stripos($line,"</string>") !== false)
            {  
                if ($lastline != "")
                {
                    fwrite($hdlout,$lastline.",\n");
                    $cntout++;
                }
                $lastline = '                  "'.$desc.'" => "'.$body.'"';                    
                $cntitm++;
                
                $id = $desc = $body = "";
            }    
        }
                
        fclose($hdlext);
        
        logLine("- Anzahl Zeilen gelesen",$cntles);
        
        flush();
    }
    // Nachspann ausgeben
    fwrite($hdlout,"                );\n");
    fwrite($hdlout,"?>");
    fclose($hdlout);
    
    logLine("- Anzahl Zeilen ausgegeben",$cntout);
    logLine("- Anzahl Namen Gesamt",$cntitm);
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: NpcInfos
// ----------------------------------------------------------------------------
function makeIncludeNpcInfos()
{
    global $pathdata, $pathstring;
    
    $tabFiles = array( "client_npcs_npc.xml",
                       "client_npcs_monster.xml"
                     );
    $maxFiles = count($tabFiles);
    $tabnpcs  = array();
    $tabdesc  = array();
    
	writeHinweisVorarbeiten();
	
    $fileout = "includes/auto_inc_npc_infos.php";
    
	logHead("Erzeugen Include mit den NPC-Infos");
    logLine("Ausgabedatei",$fileout);
        
    $hdlout   = openOutputFile($fileout);
    $lastline = "";
    $cntles   = 0;
    $cntworld = 0;
    
    // Ausgabedatei: Vorspann ausgeben
    fwrite($hdlout,getIncludeFileHeader($fileout,"Info-Tabelle - NPCs/Monster Name => id","genSpawn.php")."\n");
    fwrite($hdlout,"\n\$tabNpcInfos = array(\n");
    
    // aus client_npcs_npc.xml und client_npc_monster.xml die Daten
    // id, name, desc filtern
    $id     = "";
    $name   = "";
    $desc   = "";
    $cntles = 0;
    $cntnpc = 0;

    for ($f=0;$f<$maxFiles;$f++)
    {
        $fileext = formFileName($pathdata."\\Npcs\\".$tabFiles[$f]);
        $fileext = convFileToUtf8($fileext);
        $hdlext  = openInputFile($fileext);
        $cntnpc  = 0;
        
        logSubHead("Scanne Eingabedatei ".$fileext);
        
        flush();
        
        while (!feof($hdlext))
        {
            $line = rtrim(fgets($hdlext));
            $cntles++;
            
            if     (stripos($line,"<id>") !== false)
                $id    = getXmlValue("id",$line);
            elseif (stripos($line,"<name>") !== false)
                $name = getXmlValue("name",$line);
            elseif (stripos($line,"<desc") !== false)
                $desc = strtoupper(getXmlValue("desc",$line));
                
            if ($id != "" && $name != "" && $desc != "")
            /*
            &&  stripos($desc,"_SENSORYAREA_") === false
            &&  stripos($desc,"_SENSORY_Q")    === false
            &&  stripos($desc,"_ITEMUSEAREA_") === false)
            */
            {                
                if (!isset($tabnpcs[$name]))
                {                    
                    $tabnpcs[$name]['id']     = $id;
                    $tabnpcs[$name]['name']   = $name;
                    $tabnpcs[$name]['desc']   = $desc;
                } 
                
                $cntnpc++;
                
                $id = $name = $desc = "";
            }
        }
        fclose($hdlext);
        
        logLine("- Anzahl Zeilen gelesen",$cntles);
        logLine("- Anzahl Npcs gefunden",$cntnpc);

        flush();
        
        unlink($fileext);        
    }
    logLine("- Anzahl Npcs Gesamt",count($tabnpcs));
    
    // anschliessend hierzu aus den PS/client_strings_xxx.xml die
    // entsprechenden bodies / Ids filtern
    $tabString = array( "client_strings_npc.xml",
                        "client_strings_monster.xml",
                        "client_strings_skill.xml",
                        "client_strings_item.xml",
                        "client_strings_item2.xml",
                        "client_strings_item3.xml"
                      );
    $maxString = count($tabString);
    $cntles    = 0;
    $cntnpc    = 0;
    $id        = "";
    $desc      = "";
    $body      = "";
    
    for ($f=0;$f<$maxString;$f++)
    {
        $fileext = formFileName($pathstring."\\".$tabString[$f]);
        $hdlext  = openInputFile($fileext);
        $cntnpc  = 0;
        $cntles  = 0;
        
        logSubHead("Scanne Eingabedatei ".$fileext);
        
        flush();
        
        while (!feof($hdlext))
        {
            $line = rtrim(fgets($hdlext));
            $cntles++;
            
            if     (stripos($line,"<id>") !== false)
                $id    = getXmlValue("id",$line);
            elseif (stripos($line,"<name>") !== false)
                $desc  = strtoupper(getXmlValue("name",$line));
            elseif (stripos($line,"<body>") !== false)
                $body = str_replace('"','\"',getXmlValue("body",$line));
                
            if (stripos($line,"</string>") !== false)
            {                
                $tabdesc[$desc]['nameid'] = ($id   == "") ? "?"    : $id;
                $tabdesc[$desc]['body']   = ($body == "") ? "NONE" : $body;
                    
                $cntnpc++;
                
                $id = $desc = $body = "";
            }    
        }
                
        fclose($hdlext);
        
        logLine("- Anzahl Zeilen gelesen",$cntles);
        logLine("- Anzahl Npcs gefunden",$cntnpc);
        
        flush();
    }
    logLine("- Anzahl Npcs Gesamt",count($tabdesc));
    
    // Ausgabe dieser Daten in Form von:
    // "SKILLZONE" => array( "npc_id" => "200000", "name" => "None", "offiname" => "SkillZone"),
    
    logSubHead("Erstellen der Ausgabedatei");
    
    $cntnpc = 0;
    
    flush();
    
    while (list($key,$val) = each($tabnpcs))
    {
        if ($lastline != "")
        {
            fwrite($hdlout,$lastline.",\n");
            $cntnpc++;
        }
        $desc = $tabnpcs[$key]['desc'];
        
        $lastline = '                 "'.strtoupper($tabnpcs[$key]['name']).'" => array("npc_id" => "'.$tabnpcs[$key]['id'].'"'.
                    ', "name" => "'.$tabdesc[$desc]['body'].'", "offiname" => "'.$tabnpcs[$key]['desc'].'"'.
                    ', "nameid" => "'.$tabdesc[$desc]['nameid'].'")';
    }
    if ($lastline != "")
    {
        fwrite($hdlout,$lastline."\n");
        $cntnpc++;
    }
    // Nachspann ausgeben
    fwrite($hdlout,"               );\n");
    fwrite($hdlout,"?>");
    fclose($hdlout);
    
    logLine("- Anzahl Npcs ausgegeben",$cntnpc);
    
    flush();
}
// ----------------------------------------------------------------------------
// INCLUDE erzeugen: NpcTitle
// ----------------------------------------------------------------------------
function makeIncludeNpcTitleNames()
{
    global $pathstring;
        
	writeHinweisVorarbeiten();
	
    $fileout = "includes/auto_inc_title_names.php";
    
	logHead("Erzeugen Include mit den NPC-Titeln");
    logLine("Ausgabedatei",$fileout);
        
    $hdlout   = openOutputFile($fileout);
    $lastline = "";
    $cntles   = 0;
    $cntworld = 0;
    
    // Ausgabedatei: Vorspann ausgeben
    fwrite($hdlout,getIncludeFileHeader($fileout,"Info-Tabelle - NPC Titel => id","genSpawn.php")."\n");
    fwrite($hdlout,"\n\$tabNpcTitles = array(\n");
        
    // entsprechenden bodies / Ids filtern
    $tabString = array( "client_strings_npc.xml",
                        "client_strings_monster.xml"
                      );
    $maxString = count($tabString);
    $cntles    = 0;
    $cnttit    = 0;
    $gestit    = 0;
    $id        = "";
    $name      = "";
    
    for ($f=0;$f<$maxString;$f++)
    {
        $fileext = formFileName($pathstring."\\".$tabString[$f]);
        $hdlext  = openInputFile($fileext);
        $cnttit  = 0;
        $cntles  = 0;
        
        logSubHead("Scanne Eingabedatei ".$fileext);
        
        flush();
        
        while (!feof($hdlext))
        {
            $line = rtrim(fgets($hdlext));
            $cntles++;
            
            if     (stripos($line,"<id>") !== false)
                $id    = getXmlValue("id",$line);
            elseif (stripos($line,"<name>") !== false)
                $name  = strtoupper(getXmlValue("name",$line));
            elseif (stripos($line,"</string>") !== false)
            {     
                if ($lastline != "")
                    fwrite($hdlout,$lastline.",\n");
                    
                $lastline = '                  "'.$name.'" => "'.$id.'"'; 
                $id = $name = ""; 
                $cnttit++;                
            }    
        }
        fclose($hdlext);
        
        logLine("- Anzahl Zeilen gelesen",$cntles);
        logLine("- Anzahl Titel gefunden",$cnttit);
        
        $gestit += $cnttit;
        
        flush();
    }
    // Nachspann       
    if ($lastline != "")
        fwrite($hdlout,$lastline."\n");
    
    fwrite($hdlout,"                );\n");    
    fwrite($hdlout,"?>");    
    logLine("- Anzahl Titel Gesamt",$gestit);
        
    flush();
}
// ----------------------------------------------------------------------------
//                               O  F  F  E  N
// ----------------------------------------------------------------------------
// Erzeugen Include: WorldMaps
// ----------------------------------------------------------------------------
function makeIncludeWorldInfos()
{
/*  aktuell wieder zurückgestellt, 

    das aktuelle Include   inc_worldmaps.php   wird noch manuell gepflegt!
                          
    Begründung: die Namen der Welten stimmen häufig nicht mit den verwendeten
                Namen in der Emu überein. Da aber u.a. über diese Namen Dateien
                im SVN gesucht werden, würde es derzeit zu Fehlern führen!
                
    PHP-Source: Funktion lokal gesichert in inc_inc_save_worldmaps.txt 
*/    
}