<html>
<head>
  <title>
    ItemFiles - Erzeugen der Item-xml-Dateien
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
// ----------------------------------------------------------------------------
// Modul  : genItem.php                                  
// Version: 01.01, Mariella 03/2016
// Zweck  : führt die Generierung der für die Items notwendigen XML-Dateien
//          durch und erzeugt auch die hierfür notwendigen PHP-Includes.
// ----------------------------------------------------------------------------
  
include("../includes/inc_globals.php");

getConfData();

if (!file_exists("../outputs/parse_output/Items"))
    mkdir("../outputs/parse_output/Items");
if (!file_exists("../outputs/parse_output/item_sets"))
    mkdir("../outputs/parse_output/item_sets");

$submit   = isset($_GET['submit'])   ? "J" : "N";
$abgleich = isset($_GET['abgleich']) ? "J" : "N";
$allesneu = isset($_GET['allesneu']) ? "J" : "N";
$itsort   = isset($_GET['itsort'])   ? $_GET['itsort']  : "SVN";
$docomp   = isset($_GET['compare'])  ? $_GET['compare'] : "";

$doSortItemsSvn = $itsort == "SVN" ? true : false;
$doCompareFiles = $docomp == "DO"  ? true : false;

if ($allesneu == "J")
{
    $files = scandir("includes");
    $domax = count($files);
    
    for ($f=0;$f<$domax;$f++)
    {
        if (substr($files[$f],0,9) == "auto_inc_")
            unlink("includes/".$files[$f]);
    }
}

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen Item-xml-Dateien</div>
  <div class="hinweis" id="hinw">
    Erzeugen der Item-xml-Dateien.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genItem.php" target="_self">
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
//
//                           G E N E R - I T E M S
//
// ----------------------------------------------------------------------------
// Erzeugen Datei: assembly_items.xml
// ----------------------------------------------------------------------------
function generAssemblyItems()
{
    global $pathdata;
    
    logHead("Generiere Datei: assembly_items.xml");
    
    $fileext = formFileName($pathdata."\\Items\\client_assembly_items.xml");
    $fileout = "../outputs/parse_output/Items/assembly_items.xml";
    $cntitem = 0;
    $cntext  = 0;
    $cntout  = 0;
    $id      = "";
    $name    = "";
    
    if (!file_exists($fileext))
    {
        logLine("Eingabedatei nicht gefunden",$fileext);
        return;
    }
    
    $fileext = convFileToUtf8($fileext);
    
    $hdlext = openInputFile($fileext);
    $hdlout = openOutputFile($fileout);
    logLine("Eingabedatei",$fileext);
    logLine("Ausgabedatei",$fileout);
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
    fwrite($hdlout,'<assembly_items>'."\n");
    $cntout += 2;
    $parts = "";
    $trenn = "";
    
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        $cntext++;
        
        if (stripos($line,"</assemble_parts>") !== false)
        {
            fwrite($hdlout,'    <!-- '.$ename.' -->'."\n");
            fwrite($hdlout,'    <item id="'.$aitemid.'" parts="'.$parts.'"/>'."\n");
            
            $cntout += 2;
            $name    = $aitemid = $parts = $trenn = "";
        }
        
        if (stripos($line,"<name>") !== false)
        {            
            $name    = getXmlValue("name",$line);
            $aitemid = getClientItemId($name);
            $ename   = getClientItemName($name);
            $cntitem++;
        }
        
        if (stripos($line,"<part_item>") !== false)
        {
            $pitemid = getClientItemId(getXmlValue("part_item",$line));
            
            $parts  .= $trenn.$pitemid;
            $trenn   = " ";
        }
    }
    // Nachspann ausgeben
    fwrite($hdlout,'</assembly_items>');
    $cntout++;
    
    fclose($hdlext);
    fclose($hdlout);
    
    logLine("Zeilen eingelesen",$cntext);
    logLine("- darin enthaltene Items",$cntitem);
    logLine("Zeilen ausgegeben",$cntout);
}
// ----------------------------------------------------------------------------
// Erzeugen Datei: enchant_tables.xml
// ----------------------------------------------------------------------------
function generEnchantTables()
{
    global $pathdata;
    
    $tabItems = array();
    
    logHead("Generiere Datei: enchant_tables.xml");       
    
    $fileext = formFileName($pathdata."\\Items\\client_item_enchanttable.xml");
    $fileout = "../outputs/parse_output/Items/enchant_tables.xml";
    $cntext  = 0;
    $cntout  = 0;
    $id      = "";
    $level   = "";
    $attr    = 0;
    
    if (!file_exists($fileext))
    {
        logLine("Eingabedatei nicht gefunden",$fileext);
        return;
    }
    
    $fileext = convFileToUtf8($fileext);
    
    $hdlext = openInputFile($fileext);
    logLine("Eingabedatei",$fileext);
    
    /* Aufbau der Eingabedatei
    <item_enchant>
        <id>1</id>
        <name>weapon_test</name>
        <enchant_attr_list>
          <data>
            <level>1</level>
            <attr1>critical_physical 10</attr1>
            <attr2>parry 10</attr2>
            <attr3>PvPDefendRatio_Physical 20</attr3>
          </data>
    */
    $limit = false;
    $aval  = 0;
    $aname = "";
    
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        $cntext++;
        
        // neue Vorgaben im Client ab 4.9: start_limitless
        if (stripos($line,"<start_limitless") !== false)
        {
            $limit = true;
            $level = getXmlValue("start_limitless",$line);
        }
        elseif (stripos($line,"</limitless_attr_list") !== false)
            $limit = false;
            
        if ($limit)
        {
            // Daten zu start_limitless ermitteln
            if     (stripos($line,"<index>")      !== false)
                $attr = getXmlValue("index",$line);
            elseif (stripos($line,"<attr_name>")  !== false)
                $aname = getXmlValue("attr_name",$line);
            elseif (stripos($line,"<attr_value>") !== false)
                $aval  = getXmlValue("attr_value",$line);
            elseif (stripos($line,"</data>")      !== false)
            {
                $tabItems[$id]['levs'][$level]['attr'][$attr] = $aname." ".$aval;
            }
        }
        else
        {
            // Daten zu enchant_attr_list ermitteln
            if     (stripos($line,"<id>") !== false)
                $id = getXmlValue("id",$line);
            elseif (stripos($line,"<name>") !== false)
                $tabItems[$id]['type'] = getXmlValue("name",$line);
            elseif (stripos($line,"<level>") !== false)
            {
                $level = getXmlValue("level",$line);
                $attr  = 0;
            }
            elseif (stripos($line,"<attr") !== false && stripos($line,"<attr_") === false)
            {
                $xmlkey = getXmlKey($line);
                $tabItems[$id]['levs'][$level]['attr'][$attr] = getXmlValue($xmlkey,$line);
                $attr++;
            }
        }
    }
    fclose ($hdlext);
    
    logLine("Zeilen eingelesen",$cntext);
    logLine("Items ermittelt",count($tabItems));
    
    logLine("Ausgabedatei",$fileout);
    $hdlout = openOutputFile($fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
    fwrite($hdlout,'<enchant_tables>'."\n");
    $cntout += 2;
    
    /* Aufbau der Ausgabedatei
    <?xml version="1.0" encoding="UTF-8"?>
    <enchant_tables>
        <enchant_table id="1" type="WEAPON_TEST">
            <item_enchant level="1">
                <modifiers>
                    <add name="PHYSICAL_CRITICAL" value="10"/>
                    <add name="PARRY" value="10"/>
                    <add name="PVP_DEFEND_RATIO_PHYSICAL" value="20"/>
                </modifiers>
            </item_enchant>
    */        
    // Tabelle abarbeiten und ausgeben
    while (list($ikey,$ival) = each($tabItems))
    {
        fwrite($hdlout,'    <enchant_table id="'.$ikey.'"'.getItemTypePartText($tabItems[$ikey]['type']).'>'."\n");
        $cntout++;
        
        while(list($lkey,$lval) = each($tabItems[$ikey]['levs']))
        {
            fwrite($hdlout,'        <item_enchant level="'.$lkey.'">'."\n");
            fwrite($hdlout,'            <modifiers>'."\n");
            $cntout += 2;
            
            while (list($akey,$aval) = each($tabItems[$ikey]['levs'][$lkey]['attr']))
            {
                $tab = explode(" ",$aval);
                $tab[0] = strtoupper($tab[0]);
                $addkey    = "add";
                if (stripos($tab[1],"%") !== false)
                {
                    $addkey = "rate";
                    $tab[1] = trim(str_replace("%","",$tab[1]));
                }
                $tabAttrs[$tab[0]] = 1;
                fwrite($hdlout,'                <'.$addkey.' name="'.getItemAttrName($tab[0]).'" value="'.$tab[1].'"/>'."\n");
                $cntout++;
            }
            
            fwrite($hdlout,'            </modifiers>'."\n");
            fwrite($hdlout,'        </item_enchant>'."\n");
            $cntout += 2;
        }
        
        fwrite($hdlout,'    </enchant_table>'."\n");
        $cntout++;
    }
    // Nachspann ausgeben
    fwrite($hdlout,'</enchant_tables>');
    $cntout++;
    
    fclose($hdlout);
    
    logLine("Zeilen ausgegeben",$cntout);
}
// ----------------------------------------------------------------------------
// Erzeugen Datei: enchant_templates.xml
// ----------------------------------------------------------------------------
function generEnchantTemplates()
{
    global $pathdata;
    
    $tabItems = array();
    
    logHead("Generiere Datei: enchant_templates.xml");    
    
    $fileext = formFileName($pathdata."\\Items\\client_item_authorizetable.xml");
    $fileout = "../outputs/parse_output/Items/enchant_templates.xml";
    $cntext  = 0;
    $cntout  = 0;
    $id      = "";
    $level   = "";
    $attr    = 0;
    
    if (!file_exists($fileext))
    {
        logLine("Eingabedatei nicht gefunden",$fileext);
        return;
    }
    
    $fileext = convFileToUtf8($fileext);
    
    $hdlext = openInputFile($fileext);
    logLine("Eingabedatei",$fileext);
    
    /* Aufbau der Eingabedatei
    <item_authorize>
        <id>1</id>
        <name>test_1</name>
        <enchant_attr_list>
            <data>
                <level>1</level>
                <attr1>PvPAttackRatio_Physical_O 2</attr1>
                <attr2>damage_physical 10</attr2>
                <attr3>hit_accuracy 5</attr3>
                <attr4>block 10</attr4>
            </data>
    */
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        $cntext++;
        
        if     (stripos($line,"<id>") !== false)
            $id = getXmlValue("id",$line);
        elseif (stripos($line,"<name>") !== false)
            $tabItems[$id]['type'] = getXmlValue("name",$line);
        elseif (stripos($line,"<level>") !== false)
        {
            $level = getXmlValue("level",$line);
            $attr  = 0;
        }
        elseif (stripos($line,"<attr") !== false && stripos($line,"<attr_") === false)
        {
            $xmlkey = getXmlKey($line);
            $tabItems[$id]['levs'][$level]['attr'][$attr] = getXmlValue($xmlkey,$line);
            $attr++;
        }
    }
    fclose ($hdlext);
    
    logLine("Zeilen eingelesen",$cntext);
    logLine("Items ermittelt",count($tabItems));
    
    logLine("Ausgabedatei",$fileout);
    $hdlout = openOutputFile($fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
    fwrite($hdlout,'<enchant_templates>'."\n");
    $cntout += 2;
    
    /* Aufbau der Ausgabedatei
    <?xml version="1.0" encoding="UTF-8"?>
    <enchant_templates>
        <enchant_template id="1" >
            <item_enchant level="1">
                <modifiers>
                    <add name="PVP_ATTACK_RATIO_PHYSICAL" value="2"/>
                    <add name="PHYSICAL_ATTACK" value="10"/>
                    <add name="PHYSICAL_ACCURACY" value="5"/>
                    <add name="BLOCK" value="10"/>
                </modifiers>
            </item_enchant>
    */        
    // Tabelle abarbeiten und ausgeben
    while (list($ikey,$ival) = each($tabItems))
    {
        fwrite($hdlout,'    <enchant_template id="'.$ikey.'">'."\n");
        $cntout++;
        
        if (isset($tabItems[$ikey]['levs']) && is_array($tabItems[$ikey]['levs']))
        {
            while(list($lkey,$lval) = each($tabItems[$ikey]['levs']))
            {
                fwrite($hdlout,'        <item_enchant level="'.$lkey.'">'."\n");
                fwrite($hdlout,'            <modifiers>'."\n");
                $cntout += 2;
                
                if (isset($tabItems[$ikey]['levs'][$lkey]['attr']) && is_array($tabItems[$ikey]['levs'][$lkey]['attr']))
                {
                    while (list($akey,$aval) = each($tabItems[$ikey]['levs'][$lkey]['attr']))
                    {
                        $tab = explode(" ",$aval);
                        $tab[0] = strtoupper($tab[0]);
                        $addkey    = "add";
                        if (stripos($tab[1],"%") !== false)
                        {
                            $addkey = "rate";
                            $tab[1] = trim(str_replace("%","",$tab[1]));
                        }
                        $tabAttrs[$tab[0]] = 1;
                        fwrite($hdlout,'                <'.$addkey.' name="'.getItemAttrName($tab[0]).'" value="'.$tab[1].'"/>'."\n");
                        $cntout++;
                    }
                }
                fwrite($hdlout,'            </modifiers>'."\n");
                fwrite($hdlout,'        </item_enchant>'."\n");
                $cntout += 2;
            }
        }
        fwrite($hdlout,'    </enchant_template>'."\n");
        $cntout++;
    }
    // Nachspann ausgeben
    fwrite($hdlout,'</enchant_templates>');
    $cntout++;
    
    fclose($hdlout);
    
    logLine("Zeilen ausgegeben",$cntout);
}
// ----------------------------------------------------------------------------
// Erzeugen Datei: item_groups.xml
// ----------------------------------------------------------------------------
function generGroups()
{
    logHead("Generiere Datei: item_groups.xml");
    
    logLine("HINWEIS","*** KEINE Informationen zum Generieren gefunden / erhalten ***");
}
// ----------------------------------------------------------------------------
// Erzeugen Datei: item_multi_returns.xml
// ----------------------------------------------------------------------------
function generMultiReturns()
{
    global $pathdata, $tabWorldmaps;    
    
    include("includes/inc_worldmaps.php");
    
    logHead("Generiere Datei: item_multi_returns.xml");
    
    $fileext = formFileName($pathdata."\\Items\\client_item_multi_return.xml");
    $fileout = "../outputs/parse_output/Items/item_multi_returns.xml";
    $cntitem = 0;
    $cntext  = 0;
    $cntout  = 0;
    $id      = "";
    $name    = "";
    
    if (!file_exists($fileext))
    {
        logLine("Eingabedatei nicht gefunden",$fileext);
        return;
    }
    
    $fileext = convFileToUtf8($fileext);
    
    $hdlext = openInputFile($fileext);
    $hdlout = openOutputFile($fileout);
    logLine("Eingabedatei",$fileext);
    logLine("Ausgabedatei",$fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="utf-8"?>'."\n");
    fwrite($hdlout,'<item_multi_returns xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="item_multi_returns.xsd">'."\n");
    $cntout += 2;
    $parts = "";
    $trenn = "";
    
    /* aus der Eingabe kommt z.B.:
    <client_item_multi_return>
    <id>1</id>
    <name>test_multi_retrun_1</name>
    <return_loc_list>
        <data>
        <return_alias>LC1_Return_Area_1</return_alias>
        <return_worldid>110010000</return_worldid>
        <return_desc>STR_LC1_DESC</return_desc>
        </data>
      
    <item id="1" name="test_multi_retrun_1">
        <loc worldid="110010000" desc="Sanctum" />
        <loc worldid="210030000" desc="Verteron" />
        <loc worldid="210020000" desc="Eltnen" />
        <loc worldid="210040000" desc="Heiron" />
        <loc worldid="210060000" desc="Aetheric Field Observatory Village" />
    </item>
    */
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        $cntext++;
        
        if (stripos($line,"</data>") !== false)
        {
            $komm = "";
            
            if (isset($tabWorldmaps[$wid]))
                $wdesc = $tabWorldmaps[$wid]['name'];
            else
            {
                $tab = explode("_",$wdesc);
                $lst = count($tab) - 1;
                
                if ($tab[0]    == "STR")    $tab[0]    = "";
                if ($tab[$lst] == "DESC")   $tab[$lst] = "";
                
                $wdesc = implode("_",$tab);
                $wdesc = trim(str_replace("__","_",$wdesc));
                $wdesc = trim($wdesc,"_");
                $xdesc = $wdesc;
                
                // fehlerhafte Client-Infos in 4.9 korrigieren
                switch ($wdesc)
                {
                    case "LF4A":           $wdesc = "Kamar"; break;
                    case "LF5A_L":         $wdesc = "Kaisinel's Beacon"; break;
                    case "LDF5A_D":        $wdesc = "Danuar Spire"; break; 
                    case "LDF5B":          $wdesc = "Pandarunerk's Delve"; break;
                    case "LDF5B_2":        $wdesc = "Pandarunerk"; break;
                    case "LDF5B_UNDER":    $wdesc = "Segarunerk's Bazaar"; break;
                    case "LDF5B_UNDER_2":  $wdesc = "Segarunerk's Bazaar"; break;
                    default:               $wdesc = $xdesc; break;
                }
                
                $komm = "         <!-- ??? $xdesc - WorldId not defined in client / not active ??? -->";
            }            
            fwrite($hdlout,'        <loc worldid="'.$wid.'" desc="'.$wdesc.'" />'.$komm."\n");
            $cntout++;
        }
        if (stripos($line,"</return_loc_list>") !== false)
        {
            fwrite($hdlout,'    </item>'."\n");            
            $cntout++;
            $name    = $id = $wid = $wdesc = "";
        }
        
        if     (stripos($line,"<id>") !== false)
            $id    = getXmlValue("id",$line);        
        elseif (stripos($line,"<name>") !== false)
        {
            $name  = getXmlValue("name",$line);      
            
            fwrite($hdlout,'    <item id="'.$id.'" name="'.$name.'">'."\n");
            $cntout++;
            $cntitem++;
        }            
        elseif (stripos($line,"<return_worldid>") !== false)
            $wid   = getXmlValue("return_worldid",$line);   
        elseif (stripos($line,"<return_desc>") !== false)
            $wdesc = getXmlValue("return_desc",$line);
    }
    // Nachspann ausgeben
    fwrite($hdlout,'</item_multi_returns>');
    $cntout++;
    
    fclose($hdlext);
    fclose($hdlout);
    
    logLine("Zeilen eingelesen",$cntext);
    logLine("- darin enthaltene Items",$cntitem);
    logLine("Zeilen ausgegeben",$cntout);
}
// ----------------------------------------------------------------------------
// Item-XML-Kommentar-Text zurückgeben
// ----------------------------------------------------------------------------
function getItemXmlText($key,$name)
{
    return '<!-- '.$key.' = '.getClientItemName($key).' -->';
}
// ----------------------------------------------------------------------------
// Erzeugen Datei: item_purification.xml
// ----------------------------------------------------------------------------
function generPurifications()
{
    global $pathdata, $purxmlkom;
    
    $tabItems = array();
    
    logHead("Generiere Datei: item_purification.xml");  
    
    $fileext = formFileName($pathdata."\\Items\\client_item_upgrade.xml");
    $fileout = "../outputs/parse_output/Items/item_purifications.xml";
    $cntext  = 0;
    $cntout  = 0;
    $id      = "";
    $level   = "";
    $attr    = 0;
    
    if (!file_exists($fileext))
    {
        logLine("Eingabedatei nicht gefunden",$fileext);
        return;
    }
    
    $fileext = convFileToUtf8($fileext);
    
    $hdlext = openInputFile($fileext);
    logLine("Eingabedatei",$fileext);
    
    /* Aufbau der Eingabedatei
    <client_item_upgrade>
        <id>1</id>
        <name>dagger_a_e2_65c</name>
        <upgrade_list>
            <data>
            <upgrade_item>dagger_a_em_65a_li</upgrade_item>
            <check_enchant_count>10</check_enchant_count>
            <sub_material_item1>medal_05</sub_material_item1>
            <sub_material_item_count1>143</sub_material_item_count1>
            <sub_material_item2>up_mid_weapon_abyss_r1</sub_material_item2>
            <sub_material_item_count2>1</sub_material_item_count2>
            <need_abyss_point>1374005</need_abyss_point>
            </data>
    */  
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        $cntext++;
        
        if     (stripos($line,"<name>") !== false)
        {
            $name = getXmlValue("name",$line);
            $tabItems[$name]['name'] = $name;
        }
        elseif (stripos($line,"<upgrade_item>") !== false)
        {
            $uitem = getXmlValue("upgrade_item",$line);
            $tabItems[$name]['ups'][$uitem]['upname'] = $uitem;
            $tabItems[$name]['ups'][$uitem]['count']  = "";
        }
        elseif (stripos($line,"<check_enchant_count>") !== false)
            $tabItems[$name]['ups'][$uitem]['count'] = getXmlValue("check_enchant_count",$line);
        elseif (stripos($line,"<sub_material_item") !== false && stripos($line,"_count") === false)
        {
            $xmlkey = getXmlKey($line);
            $subname = getXmlValue($xmlkey,$line);
        }
        elseif (stripos($line,"<sub_material_item_count") !== false)
        {
            $xmlkey = getXmlKey($line);
            $tabItems[$name]['ups'][$uitem]['subs'][$subname]['name']  = $subname;
            $tabItems[$name]['ups'][$uitem]['subs'][$subname]['count'] = getXmlValue($xmlkey,$line);
        }
        elseif (stripos($line,"<need_abyss_point>") !== false)
            $tabItems[$name]['ups'][$uitem]['abyss'] = getXmlValue("need_abyss_point",$line);
        elseif (stripos($line,"<need_qina>") !== false)
            $tabItems[$name]['ups'][$uitem]['qina'] = getXmlValue("need_qina",$line);
    }
    fclose ($hdlext);
    
    logLine("Zeilen eingelesen",$cntext);
    logLine("Items ermittelt",count($tabItems));  
    
    /* Aufbau der Ausgabedatei        
    <item_purification base_item="100201319">
        <purification_result_item item_id="100201416" enchant_count="10">
            <required_materials>
                <sub_material_item id="186000242" count="143"/>
                <sub_material_item id="169405379" count="1"/>
            </required_materials>
            <abyss_point_needed count="1374005"/>
        </purification_result_item>
    </item_purification>
    */
    
    logLine("Ausgabedatei",$fileout);
    $hdlout = openOutputFile($fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
    fwrite($hdlout,'<item_purifications xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'."\n");
    fwrite($hdlout,'                    xsi:noNamespaceSchemaLocation="item_purifications.xsd">'."\n");
    $cntout += 3;
    
    // Tabelle abarbeiten und ausgeben
    while (list($ikey,$ival) = each($tabItems))
    {     
        $baseid = $tabItems[$ikey]['name'];
        
        if ($purxmlkom)
        {
            fwrite($hdlout,'    '.getItemXmlText($ikey,$baseid)."\n");
            $cntout++;
        }
        fwrite($hdlout,'    <item_purification base_item="'.getClientItemId($baseid).'">'."\n");
        $cntout++;
        
        if (isset($tabItems[$ikey]['ups']) && is_array($tabItems[$ikey]['ups']))
        {
            while(list($ukey,$uvar) = each($tabItems[$ikey]['ups']))
            {     
                $resid = getClientItemId($tabItems[$ikey]['ups'][$ukey]['upname']);
                
                if ($purxmlkom)
                {
                    fwrite($hdlout,'        '.getItemXmlText($tabItems[$ikey]['ups'][$ukey]['upname'],$resid)."\n");
                    $cntout++;
                }
                
                fwrite($hdlout,'        <purification_result_item item_id="'.$resid.
                               '" enchant_count="'.$tabItems[$ikey]['ups'][$ukey]['count'].'">'."\n");
                $cntout++;
        
                if (isset($tabItems[$ikey]['ups'][$ukey]['subs']) && is_array($tabItems[$ikey]['ups'][$ukey]['subs']))
                {
                    fwrite($hdlout,'            <required_materials>'."\n");
                    $cntout++;
                    
                    while(list($skey,$sval) = each($tabItems[$ikey]['ups'][$ukey]['subs']))
                    {
                        fwrite($hdlout,'                <sub_material_item id="'.getClientItemId($skey).'" count="'.
                                       $tabItems[$ikey]['ups'][$ukey]['subs'][$skey]['count'].'"/>'."\n");
                        $cntout++;
                    }

                    fwrite($hdlout,'            </required_materials>'."\n");
                    $cntout++;
                    
                    if (isset($tabItems[$ikey]['ups'][$ukey]['qina']))
                    {
                        fwrite($hdlout,'            <kinah_needed count="'.$tabItems[$ikey]['ups'][$ukey]['qina'].'"/>'."\n");
                        $cntout++;
                    }
                    
                    if (isset($tabItems[$ikey]['ups'][$ukey]['abyss']))
                    {
                        fwrite($hdlout,'            <abyss_point_needed count="'.$tabItems[$ikey]['ups'][$ukey]['abyss'].'"/>'."\n");
                        $cntout++;
                    }
                }
                fwrite($hdlout,'        </purification_result_item>'."\n");
                $cntout++;
            }
        }
        fwrite($hdlout,'    </item_purification>'."\n");
        $cntout++;
    }
    // Nachspann ausgeben
    fwrite($hdlout,'</item_purifications>');
    $cntout++;
    
    fclose($hdlout);
    
    logLine("Zeilen ausgegeben",$cntout);
}
// ----------------------------------------------------------------------------
// Erzeugen Datei: item_random_bonuses.xml
// ----------------------------------------------------------------------------
function generRandomBonuses()
{
    global $pathdata;
    
    $tabItems = array();
    $tabFiles = array("client_item_random_option.xml",
                      "polish_bonus_setlist.xml"
                     );
    $maxFiles = count($tabFiles);
    
    logHead("Generiere Datei: item_random_bonuses.xml");    
    
    for ($f=0;$f<$maxFiles;$f++)
    {      
        $fileext = formFileName($pathdata."\\Items\\".$tabFiles[$f]);
        $cntext  = 0;
        $id      = "";
        $type    = $f == 0 ? "I" : "P";
        
        if (!file_exists($fileext))
        {
            logLine("Eingabedatei nicht gefunden",$fileext);
            return;
        }
        
        $fileext = convFileToUtf8($fileext);
        
        $hdlext = openInputFile($fileext);
        logLine("Eingabedatei",$fileext);
        
        /* Aufbau der Eingabedateien
        <polish_bonus_setlist>
            <id>2</id>
            <name>test_polish_set_01</name>
            <random_attr_group_list>
                <data>
                    <attr_group_id>1</attr_group_id>
                    <prob>5000</prob>
                    <random_attr1>BoostHate -100%</random_attr1>
                </data>
        */
        while (!feof($hdlext))
        {
            $line = rtrim(fgets($hdlext));
            $cntext++;
            
            if     (stripos($line,"<id>") !== false)
                $id   = getXmlValue("id",$line);
            elseif (stripos($line,"<prob>") !== false)
                $prob = getXmlValue("prob",$line);
            elseif (stripos($line,"<attr_group_id>") !== false)
                $grp  = getXmlValue("attr_group_id",$line);
            elseif (stripos($line,"<random_attr") !== false && stripos($line,"_group") === false)
            {
                $xmlkey = getXmlKey($line);
                $attr   = getXmlValue($xmlkey,$line);
                            
                $tabItems[$type][$id]['mods'][$grp]['prob']        = $prob;
                $tabItems[$type][$id]['mods'][$grp]['attr'][$attr] = $attr;
            }
        }
        fclose ($hdlext);
        
        logLine("Zeilen eingelesen",$cntext);
        logLine("Items ermittelt",count($tabItems));
    }
    
    $fileout = "../outputs/parse_output/Items/item_random_bonuses.xml";
    logLine("Ausgabedatei",$fileout);
    
    $hdlout = openOutputFile($fileout);
    $cntout  = 0;
    
    flush();
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
    fwrite($hdlout,'<random_bonuses>'."\n");
    $cntout += 2;
    $type    = "";

    /* Aufbau der  Ausgabedatei
    <random_bonus type="INVENTORY" id="2">
        <modifiers chance="50.0">
            <rate name="BOOST_HATE" value="-100" bonus="true"/>
        </modifiers>
        <modifiers chance="20.0">
            <rate name="BOOST_HATE" value="100" bonus="true"/>
        </modifiers>
        <modifiers chance="30.0">
            <rate name="BOOST_HATE" value="-50" bonus="true"/>
        </modifiers>
    </random_bonus>
    */
    
    // Tabelle abarbeiten und ausgeben 
    for ($t=0;$t<2;$t++)
    {
        $dotype = $t == 0 ? "I" : "P";
        $type   = $t == 0 ? "INVENTORY" : "POLISH";
        
        reset($tabItems);        
        
        while (list($ikey,$ival) = each($tabItems[$dotype]))
        {            
            fwrite($hdlout,'    <random_bonus type="'.$type.'" id="'.$ikey.'">'."\n");
            $cntout++;
            
            while(list($pkey,$pval) = each($tabItems[$dotype][$ikey]['mods']))
            {    
                $chance = strval($tabItems[$dotype][$ikey]['mods'][$pkey]['prob'] / 100);
                if (stripos($chance,".") === false) $chance .= ".0";
                
                fwrite($hdlout,'        <modifiers chance="'.$chance.'">'."\n");
                $cntout++;
                
                while (list($akey,$aval) = each($tabItems[$dotype][$ikey]['mods'][$pkey]['attr']))
                {
                    $tab    = explode(" ",$aval);
                    $tab[0] = strtoupper($tab[0]);
                    $addkey = "add";
                    
                    if (stripos($tab[1],"%") !== false)
                    {
                        $addkey = "rate";
                        $tab[1] = trim(str_replace("%","",$tab[1]));
                    }
                    
                    if (!isset($tabbonus[$tab[0]]))
                        $tabbonus[$tab[0]] = 1;
                    else
                        $tabbonus[$tab[0]]++;
                    // scheint bei INVENTORY immer der entgegengesetzte Wert zu sein
                    //if (($dotype == "I" && $tab[0] == "SPEED") || $tab[0] == "ATTACKDELAY")
                    if ($tab[0] == "ATTACKDELAY")
                        $tab[1] *= -1;
                        
                    $tabAttrs[$tab[0]] = 1;
                    fwrite($hdlout,'            <'.$addkey.' name="'.getBonusAttrName($tab[0]).'" value="'.$tab[1].'" bonus="true"/>'."\n");
                    $cntout++;
                }
                
                fwrite($hdlout,'        </modifiers>'."\n");
                $cntout++;
            }
            fwrite($hdlout,'    </random_bonus>'."\n");
            $cntout += 2;
        }
    }
    // Nachspann ausgeben
    fwrite($hdlout,'</random_bonuses>');
    $cntout++;
    
    fclose($hdlout);
    
    logLine("Zeilen ausgegeben",$cntout);
}
// ----------------------------------------------------------------------------
// Erzeugen Datei: item_restriction_cleanups.xml
// ----------------------------------------------------------------------------
function generRestrictionCleanups()
{
    logHead("Generiere Datei: item_restriction_cleanups.xml");
    
    logLine("HINWEIS","*** KEINE Informationen zum Generieren gefunden / erhalten ***");
}
// ----------------------------------------------------------------------------
// Erzeugen Datei: item_sets.xml
// ----------------------------------------------------------------------------
function generItemSets()
{
    // wegen wichtiger 4.9-er Anpassungen erst einmal fürs SVN wieder entfernt!
    global $pathdata;
    
    logHead("Generiere Datei: item_sets.xml");
    
    $tabsets = array();
    $cntles  = 0;
    $cntset  = 0;
    
    $fileext = formFileName($pathdata."\\Items\\client_setitem.xml");
    $fileext = convFileToUtf8($fileext);
    
    logSubHead("Scanne die Eingabedatei");
    
    if (!$hdlext = openInputFile($fileext))
    {
        logLine("Fehler OpenInputFile",$fileext);
        return;
    }
    
    logLine("Eingabedatei",$fileext);
    
    flush();
    
    $id   = "";
    $name = "";
    $desc = "";
    
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        $cntles++;
        
        if     (stripos($line,"<id>")   !== false)
        {
            $id = getXmlValue("id",$line);
            $cntset++;
        }
        elseif (stripos($line,"<name>") !== false)
        {
            $name = getXmlValue("name",$line);
            $tabsets[$id]['name'] = $name;
        }
        elseif (stripos($line,"<desc>") !== false)
        {
            $desc = getXmlValue("desc",$line);
            $tabsets[$id]['desc'] = $desc;
        }
        elseif (stripos($line,"<item")  !== false)
        {
            $xmlkey = getXmlKey($line);
            $xmlval = getXmlValue($xmlkey,$line);
            $tabsets[$id]['item'][$xmlkey] = $xmlval;
        }
        elseif (stripos($line,"<piece_bonus") !== false)
        {
            $xmlkey = getXmlKey($line);
            $xmlval = getXmlValue($xmlkey,$line);
            $tabsets[$id]['bonus'][$xmlkey] = $xmlval;
        }
        elseif (stripos($line,"<fullset_bonus") !== false)
        {
            $xmlkey = getXmlKey($line);
            $xmlval = getXmlValue($xmlkey,$line);
            $tabsets[$id]['full'][$xmlkey] = $xmlval;
        }
    }
    fclose($hdlext);
    
    logLine("- Anzahl Zeilen gelesen",$cntles);
    logLine("- Anzahl gefundene Sets",$cntset);    
    
    $fileout = "../outputs/parse_output/item_sets/item_sets.xml";
    $hdlout  = openOutputFile($fileout);
    $cntout  = 0;
    
    logSubHead("Erzeuge die Ausgabedatei");
    logLine("Ausgabedatei",$fileout);
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
    fwrite($hdlout,'<item_sets xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="item_sets.xsd">'."\n");
    
    flush();
    
    while (list($skey,$sval) = each($tabsets))
    {
        fwrite($hdlout,'    <itemset id="'.$skey.'" name="'.getItemNameByDesc($tabsets[$skey]['desc']).'">'."\n");
        $cntout++;
        
        /*
        <itemset id="1" name="Cloth Armor Set (Test)">
            <itempart itemid="110100919"/>
            <itempart itemid="113100831"/>
            <itempart itemid="112100781"/>
            <itempart itemid="111100823"/>
            <itempart itemid="114100859"/>
            <partbonus count="3">
                <modifiers>
                    <add name="BOOST_MAGICAL_SKILL" value="100" bonus="true"/>
                </modifiers>
            </partbonus>
            <partbonus count="5">
                <modifiers>
                    <add name="MAXHP" value="100" bonus="true"/>
                    <add name="MAXMP" value="100" bonus="true"/>
                </modifiers>
            </partbonus>
            <fullbonus>
                <modifiers>
                    <rate name="ATTACK_SPEED" value="-8" bonus="true"/>
                    <rate name="SPEED" value="10" bonus="true"/>
                    <rate name="FLY_SPEED" value="6" bonus="true"/>
                    <add name="MAXHP" value="500" bonus="true"/>
                </modifiers>
            </fullbonus>
        </itemset>
        */        
        // Ausgabe: itempart
        while (list($ikey,$ival) = each($tabsets[$skey]['item']))
        {
            fwrite($hdlout,'        <itempart itemid="'.getClientItemId($ival).'"/>'."\n");
            $cntout++;
        }
        // Ausgabe: partbonus (wenn angegeben)
        if (isset($tabsets[$skey]['bonus']))
        {
            while (list($ikey,$ival) = each($tabsets[$skey]['bonus']))
            {
                $count = str_replace("piece_bonus","",$ikey);
                fwrite($hdlout,'        <partbonus count="'.$count.'">'."\n");
                fwrite($hdlout,'            <modifiers>'."\n");
                $cntout += 2;
                
                $btab = explode(";",$ival);
                $bmax = count($btab);
                
                for ($b=0;$b<$bmax;$b++)
                {
                    $vtab = explode(" ",trim($btab[$b]));
                    
                    if (count($vtab) > 1)
                    {
                        $xml = (stripos($vtab[1],"%") !== false) ? "rate" : "add";
                        $nam = getBonusAttrName($vtab[0]);
                        $neg = 1;
                        
                        if ($nam == "ATTACK_SPEED"
                        ||  $nam == "BOOST_HATE")
                            $neg = -1;
                            
                        fwrite($hdlout,'                <'.$xml.' name="'.$nam.
                                       '" value="'.(trim(str_replace("%","",$vtab[1])) * $neg).'" bonus="true"/>'."\n");
                        $cntout++;
                    }
                }            
                
                fwrite($hdlout,'            </modifiers>'."\n");
                fwrite($hdlout,'        </partbonus>'."\n");
                $cntout += 2;
            }
        }
        else
        {
            // ohne partbonus stürzt die EMU ab, daher Dummy-Eintrag erzeugen
            fwrite($hdlout,'        <partbonus>'."\n");
            fwrite($hdlout,'            <modifiers />'."\n");
            fwrite($hdlout,'        </partbonus>'."\n");
            $cntout += 3;
        }
        // Ausgabe: fullbonus (wenn angegeben)
        if (isset($tabsets[$skey]['full']))
        {
            while (list($ikey,$ival) = each($tabsets[$skey]['full']))
            {
                fwrite($hdlout,'        <fullbonus>'."\n");
                fwrite($hdlout,'            <modifiers>'."\n");
                $cntout += 2;
                
                $btab = explode(";",$ival);
                $bmax = count($btab);
                
                for ($b=0;$b<$bmax;$b++)
                {
                    $vtab = explode(" ",$btab[$b]);
                    
                    if (count($vtab) > 1)
                    {
                        $xml = (stripos($vtab[1],"%") !== false) ? "rate" : "add";
                        $nam = getBonusAttrName($vtab[0]);
                        $neg = "";
                        
                        if ($nam == "ATTACK_SPEED")
                            $neg = "-";
                            
                        fwrite($hdlout,'                <'.$xml.' name="'.$nam.
                                       '" value="'.$neg.trim(str_replace("%","",$vtab[1])).'" bonus="true"/>'."\n");
                        $cntout++;
                    }
                }            
                
                fwrite($hdlout,'            </modifiers>'."\n");
                fwrite($hdlout,'        </fullbonus>'."\n");
                $cntout += 2;
            }
        }
        fwrite($hdlout,'    </itemset>'."\n");
        $cntout++;
    }
    // Nachspann ausgeben
    fwrite($hdlout,'</item_sets>');
    fclose($hdlout);
    
    logLine("- Anzahl Zeilen ausgegeben",$cntout);
}
// ----------------------------------------------------------------------------
//
//                       I T E M - T E M P L A T E S
//                              S C A N N E N
//
// ----------------------------------------------------------------------------
// Erzeugen Tabelle: $tabTpls mit allen Client-Item-Informationen
// ----------------------------------------------------------------------------
function scanClientItemTemplateFiles()
{
    global $pathdata, $tabTpls;
    
    $tabFiles = array( "client_items_etc.xml",    // 100000001 - 190070023
                       "client_items_armor.xml",  // 110000001 - 125300065
                       "client_items_misc.xml"    // 141000001 - 190200001
                     );
    $maxFiles = count($tabFiles);
    $gesitm   = 0;
    $startat  = microtime(true);
    
    logHead("Erzeuge die CSV-Datei mit den Client-Items");
    
    flush();
    
    for ($f=0;$f<$maxFiles;$f++)
    {
        $fileext = formFileName($pathdata."\\Items\\".$tabFiles[$f]);
        $fileext = convFileToUtf8($fileext);        
        $hdlext  = openInputFile($fileext);
        $cntext  = 0;
        $cntitm  = 0;
        $itemid  = "";
        $tradin  = 0;   // trade_in_...
        
        logSubHead("Eingabedatei UTF8: $fileext");
        logFileSize("- ",$fileext);
    
        flush();    
        
        while (!feof($hdlext))
        {
            $line = rtrim(fgets($hdlext));
            $cntext++;
            
            if (stripos($line,"<id>") !== false)
            {
                $itemid = getXmlValue("id",$line);
                $tradin = 0;
                $cntitm++;
            }
            if ($itemid != "")
            {
                $xmlkey = getXmlKey($line);
                $xmlval = getXmlValue($xmlkey,$line);
                
                // speziell: Trade_in_items können mehrfach sein, daher lfdNr. angehängt               
                if (strtolower($xmlkey) == "trade_in_item" || strtolower($xmlkey) == "trade_in_item_count")
                {
                    if ($xmlval != "")
                    {
                        if (strtolower($xmlkey) == "trade_in_item")
                        {
                            $tradin++;
                            $tabTpls[$itemid][$xmlkey] = $tradin;
                            $tabTpls[$itemid][$xmlkey.$tradin] = $xmlval;
                            $tabTpls[$itemid][$xmlkey.'_count'.$tradin] = "0";
                        }
                        else
                        {
                            $tabTpls[$itemid][$xmlkey.$tradin] = $xmlval;
                        }
                    }
                }                
                else
                    if ($xmlval != "")
                        $tabTpls[$itemid][strtolower($xmlkey)] = $xmlval; 
            }            
        }
        fclose($hdlext);
 
        logLine("- Zeilen gelesen",$cntext);
        logLine("- Items gefunden",$cntitm);
        
        flush();
        
        $gesitm += $cntitm;
    }
    logLine("Gesamt Items gefunden",$gesitm);
    
    // Sicherung des Originals erzeugen (Einsparung ca. 3 Minuten)
    logSubHead("Speichern der Daten als CSV-Datei");
    
    writeClientItemsFile();
    
    $usetime = substr(microtime(true) - $startat,0,8);
    logLine("- verbrauchte Zeit ca.",$usetime." Sekunden");
        
    flush();
}
// ----------------------------------------------------------------------------
// fehlende Informationen ermitteln
// ----------------------------------------------------------------------------
function makeMissingItemTemplateData()
{
    global $tabTpls;
    
    logSubHead("vorab einige zus&auml;tzliche Daten ermitteln");
        
    $cntitm = 0;
    
    flush();
    
    while (list($key,$val) = each($tabTpls))
    {
        $cntitm++;
        
        // einfache Ermittlungen
        // Wert = 0 wird nicht berücksichtigt !!!
        setZeroToBlank($key,"option_slot_value");
        setZeroToBlank($key,"option_slot_bonus");
        setZeroToBlank($key,"special_slot_value");
        setZeroToBlank($key,"can_pack_count");
        setZeroToBlank($key,"max_stack_count");
        
        //  Wert = FALSE wird nicht berücksichtigt
        setFalseToBlank($key,"exceed_enchant");
                    
        // funktionale Ermittlungen
        $tabTpls[$key]['outname']           = getName($key);
        $tabTpls[$key]['outdesc']           = getDesc($key);
        $tabTpls[$key]['name_desc']         = getNameDesc($key);
        $tabTpls[$key]['mask']              = getItemMask($key);
        $tabTpls[$key]['category']          = getCategory($key);
        $tabTpls[$key]['outarmortype']      = getArmorType($key);
        $tabTpls[$key]['outweapontype']     = getWeaponType($key);
        $tabTpls[$key]['outauthorizename']  = getAuthId($key);
        $tabTpls[$key]['race']              = getRace($key);
        $tabTpls[$key]['rnd_bonus']         = getRndBonus($key);
        $tabTpls[$key]['rnd_count']         = getRndCount($key);
        $tabTpls[$key]['restrict']          = getRestrict($key);
        $tabTpls[$key]['restrict_max']      = getRestrictMax($key);
        $tabTpls[$key]['robot_id']          = getRobotId($key);
        $tabTpls[$key]['slot']              = getSlot($key);
        $tabTpls[$key]['equipmenttype']     = getEquipmentType($key);
        $tabTpls[$key]['max_enchant_value'] = getMaxEnchant($key);
        $tabTpls[$key]['activatecombat']    = getActivateCombat($key);
        
        if (!isset($tabTpls[$key]['level']))
            $tabTpls[$key]['level'] = "0";
        else
            if ($tabTpls[$key]['level'] == "")
                $tabTpls[$key]['level'] = "0";
    }
    logLine("- verarbeitete Items",$cntitm);
}
// ----------------------------------------------------------------------------
// Erzeugen Datei: auto_inc_client_items.csv
// ----------------------------------------------------------------------------
function writeClientItemsFile()
{
    global $tabTpls;    
  
    $fileout = "includes/auto_inc_client_items.csv";
    $cntout  = 0;
        
    reset($tabTpls);
    
    // als csv-Datei schreiben, da es als PHP-Include wegen Speichermangels zu
    // Abbrüchen führt
    $hdlout = openOutputFile($fileout);
        
    while (list($key,$dum) = each($tabTpls))
    {                
        while (list($xml,$val) = each($tabTpls[$key]))
        {                
            fwrite($hdlout,"$key;$xml;$val\n");
            $cntout++;
        }     
    }    
    fclose($hdlout);
    reset($tabTpls);
    
    logLine("- ausgegebene Items",$cntout);
}
// ----------------------------------------------------------------------------
//
//                       I T E M - T E M P L A T E S
//                             E R Z E U G E N
//
// ----------------------------------------------------------------------------
// Einlesen Datei: auto_inc_client_items.csv
// ----------------------------------------------------------------------------
function readClientItemsFile()
{
    global $tabTpls;
    
    $startat = microtime(true);
    
    $filecsv = "includes/auto_inc_client_items.csv";
    $hdlcsv  = openInputFile($filecsv);
    
    logSubHead("Einlesen der gescannten Client-Item-Infos");
    logLine("- Eingabedatei",$filecsv);

    flush();
    
    while (!feof($hdlcsv))
    {
        $tab = explode(";",rtrim(fgets($hdlcsv)));
        
        if ($tab[0] != "")
            $tabTpls[$tab[0]][$tab[1]] = $tab[2];
    }
    fclose($hdlcsv);
    
    $usetime = substr(microtime(true) - $startat,0,8);
    
    logLine("- Anzahl gesicherte Items",count($tabTpls));    
    logLine("- verbrauchte Zeit",$usetime." Sekunden");        
    logLine("- Zeiteinsparung","ca. 80 bis 85 % anstelle der wiederholten Scan-Aktivit&auml;ten mit ca. 170 Sekunden");
}
// ----------------------------------------------------------------------------
// Erzeugen Datei: item_templates.xml
// ----------------------------------------------------------------------------
function generItemTemplates()
{
    global $tabTpls,$pathsvn,$doSortItemsSvn,$doCompareFiles;
    
    $tabKeys = array();
    $svnKeys = array();
    $txsort  = $doSortItemsSvn == true ? "Reihenfolge wie im SVN" : "numerisch aufsteigend";
    $txcomp  = $doCompareFiles == true ? "werden erstellt" : "werden NICHT erstellt";
    
    logHead("Generiere Datei: item_templates.xml");
    logSubHead("Anforderungen");
    logLine("- Sortierung",$txsort);
    logLine("- Abgleichdateien",$txcomp);
    
    readClientItemsFile();    
    makeMissingItemTemplateData();
    
    $fileout = "../outputs/parse_output/Items/item_templates.xml";
    $hdlout  = openOutputFile($fileout);
    $cntitm  = 0;
    $cntout  = 0;
    
    logSubHead("Sortierung der Items");
    
    flush();
    
    if ($doSortItemsSvn)
    {
        logLine("- <font color=yellow>doSortItemsSvn = TRUE</font>","Hole Reihenfolge der Items aus dem SVN");
        
        $filesvn = formFileName($pathsvn."\\trunk\\AL-Game\\data\static_data\\items\\item_templates.xml");
        $hdlsvn  = openInputFile($filesvn);
        
        logLine("SVN-Eingabedatei",$filesvn);
        
        while (!feof($hdlsvn))
        {
            $line = rtrim(fgets($hdlsvn));
            
            if (stripos($line,'<item_template ') !== false)
            {
                $key           = getKeyValue("id",$line);
                $svnKeys[$key] = 1;
                $tabTpls[$key]['insvn'] = true;
            }
        }
        fclose($hdlsvn);
        
        logLine("- Anzahl gefundene Items",count($svnKeys));
        $cntzus = 0;
        $cntchk = 0;
        
        reset($tabTpls);
        
        while (list($key,$dum) = each($tabTpls))
        {
            $cntchk++;
            
            if (!isset($tabTpls[$key]['insvn']))
            {                
                $svnKeys[$key] = 1;
                $cntzus++;
            }
        }
        logLine("- neue Items gem. Client",$cntzus);
        logLine("- Items GESAMT",count($svnKeys));
        
        $tabKeys = array_keys($svnKeys);
        unset($svnKeys);
        reset($tabTpls);
    }
    else
    {    
        logLine("- <font color=yellow>doSortItemsSvn = FALSE</font>","sortiere Items aufsteigend nach ID");
        
        $tabKeys = array_keys($tabTpls);
    
        sort ($tabKeys);
    }
    
    logSubHead("Erzeugen der Ausgabedatei");
    logLine("- Ausgabedatei",$fileout);
    
    $maxKeys = count($tabKeys);
    $cntitm  == 0;
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
    fwrite($hdlout,'<item_templates>'."\n");
    $cntout++;
   
    flush();
    
    for ($i=0;$i<$maxKeys;$i++)
    {
        $cntitm++;
        $key = $tabKeys[$i];
        
        // XML-Zeile: item_template
        if ($line = getItemTemplateLines($key))
        {
            $only = true;
            
            fwrite($hdlout,$line);
            $cntout++;
            
            if ($line = getModifierLines($key))
            {
                // <item_template abschliessen!
                if ($only)
                {
                    fwrite($hdlout,">\n");
                    $only = false;
                }
                fwrite($hdlout,$line."\n");
                $cntout += 1 + substr_count($line,"\n");
            }
            if ($line = getActionLines($key))
            {
                // <item_template abschliessen!
                if ($only)
                {
                    fwrite($hdlout,">\n");
                    $only = false;
                }
                fwrite($hdlout,$line."\n");
                $cntout += 1 + substr_count($line,"\n");
            }
            if ($line = getGodstoneLines($key))
            {
                // <item_template abschliessen!
                if ($only)
                {
                    fwrite($hdlout,">\n");
                    $only = false;
                }
                fwrite($hdlout,$line."\n");
                $cntout += 1 + substr_count($line,"\n");
            }
            if ($line = getStigmaLines($key))
            {
                // <item_template abschliessen!
                if ($only)
                {
                    fwrite($hdlout,">\n");
                    $only = false;
                }
                fwrite($hdlout,$line."\n");
                $cntout += 1 + substr_count($line,"\n");
            }
            if ($line = getWeaponStatLines($key))
            {
                // <item_template abschliessen!
                if ($only)
                {
                    fwrite($hdlout,">\n");
                    $only = false;
                }
                fwrite($hdlout,$line."\n");
                $cntout += 1 + substr_count($line,"\n");
            }
            if ($line = getTradeInLines($key))
            {
                // <item_template abschliessen!
                if ($only)
                {
                    fwrite($hdlout,">\n");
                    $only = false;
                }
                fwrite($hdlout,$line."\n");
                $cntout += 1 + substr_count($line,"\n");
            }
            if ($line = getAcquisitionLines($key))
            {
                // <item_template abschliessen!
                if ($only)
                {
                    fwrite($hdlout,">\n");
                    $only = false;
                }
                fwrite($hdlout,$line);
                $cntout += 1 + substr_count($line,"\n");
            }
            if ($line = getDispositionLines($key))
            {
                // <item_template abschliessen!
                if ($only)
                {
                    fwrite($hdlout,">\n");
                    $only = false;
                }
                fwrite($hdlout,$line."\n");
                $cntout += 1 + substr_count($line,"\n");
            }
            if ($line = getImproveLines($key))
            {
                // <item_template abschliessen!
                if ($only)
                {
                    fwrite($hdlout,">\n");
                    $only = false;
                }
                fwrite($hdlout,$line."\n");
                $cntout += 1 + substr_count($line,"\n");
            }
            if ($line = getUselimitLines($key))
            {
                // <item_template abschliessen!
                if ($only)
                {
                    fwrite($hdlout,">\n");
                    $only = false;
                }
                fwrite($hdlout,$line."\n");
                $cntout += 1 + substr_count($line,"\n");
            }
            if ($line = getInventoryLines($key))
            {
                // <item_template abschliessen!
                if ($only)
                {
                    fwrite($hdlout,">\n");
                    $only = false;
                }
                fwrite($hdlout,$line."\n");
                $cntout += 1 + substr_count($line,"\n");
            }
            if ($line = getIdianLines($key))
            {
                // <item_template abschliessen!
                if ($only)
                {
                    fwrite($hdlout,">\n");
                    $only = false;
                }
                fwrite($hdlout,$line."\n");
                $cntout += 1 + substr_count($line,"\n");
            }
            // <item_template abschliessen!
            if ($only)
                fwrite($hdlout,"/>\n");
            else
            {
                fwrite($hdlout,"    </item_template>\n");
                $cntout++;
            }
        }
    }
    
    // Nachspann ausgeben
    fwrite($hdlout,'</item_templates>');
    $cntout++;
    
    fclose($hdlout);
    
    logLine("- Zeilen ausgegeben",$cntout);
    logLine("- Items ausgegeben",$cntitm);
}
// ----------------------------------------------------------------------------
//
//                      T E S T - A B G L E I C H - D A T E I
//
// ----------------------------------------------------------------------------
// TEST - die bekannten Abweichungen aus dem Vergleich herausfiltern. Entweder
//        durch setzen von Konstant "xxx" als Wert oder durch entfernen
// ----------------------------------------------------------------------------
function changeValuesInLine($line)
{
    // bei bekannten Abweichungen besondere Behandlung vornehmen!
    //                
    // (1) Charge-Value wird das hier ausgeklammert und nur als Dummy geschrieben
    if (stripos($line,"<charge") !== false)
        $line = '                    <charge value=""/>';
    
    // (2) SILCENCE_RESISTANCE_PENETRATION oder SLEEP_RESISTANCE_PENETRATION   
    if (stripos($line,"SILENCE_RESISTANCE_PENETRATION") !== false)
    {
        $line = str_replace("SILENCE_","SILENCE_SLEEP_",$line);
    }
    // (2) SLEEP_RESISTANCE_PENETRATION
    elseif (stripos($line,"SLEEP_RESISTANCE_PENETRATION") !== false)
    {
        $line = str_replace("SLEEP_","SILENCE_SLEEP_",$line);
    }
    
    // (3) expire_time=...
    if (stripos($line,"expire_time=") !== false)
    {
        $oldmin = getKeyValue("expire_time",$line);
        $line   = str_replace(' expire_time="'.$oldmin.'"',' expire_time="xxx"',$line); 
    }
    // (4) minutes=...
    if (stripos($line,"minutes=") !== false)
    {
        $oldmin = getKeyValue("minutes",$line);
        $line   = str_replace(' minutes="'.$oldmin.'"',' minutes="xxx"',$line); 
    }
}
// ----------------------------------------------------------------------------
// bekannte Abweichungen im Test ausblenden
// ----------------------------------------------------------------------------
function hideValuesInLine($line)
{
    //  Ausblenden bekannter Abweichungen, um die weitere Suche zu erleichtern!
    //
    if (stripos($line,"category=") !== false)
    {
        // (5) category=...
        $oldmin = getKeyValue("category",$line);
        $line   = str_replace(' category="'.$oldmin.'"',' category="xxx"',$line); 
    }
    if (stripos($line,"bonus_apply=") !== false)
    {
        // (5) category=...
        $oldmin = getKeyValue("bonus_apply",$line);
        $line   = str_replace(' bonus_apply="'.$oldmin.'"','',$line); 
    }
    if (stripos($line,"authorize_name=") !== false)
    {
        // (5) category=...
        $oldmin = getKeyValue("authorize_name",$line);
        $line   = str_replace(' authorize_name="'.$oldmin.'"','',$line); 
    }
    if (stripos($line,"restrict=") !== false)
    {
        // (5) category=...
        $oldmin = getKeyValue("restrict",$line);
        $line   = str_replace(' restrict="'.$oldmin.'"',' restrict="xxx"',$line); 
    }
    if (stripos($line,"restrict_max=") !== false)
    {
        // (5) category=...
        $oldmin = getKeyValue("restrict_max",$line);
        $line   = str_replace(' restrict_max="'.$oldmin.'"',' restrict_max="xxx"',$line); 
    }
    if (stripos($line,"equipment_type=") !== false)
    {
        // (5) category=...
        $oldmin = getKeyValue("equipment_type",$line);
        $line   = str_replace(' equipment_type="'.$oldmin.'"','',$line); 
    }
    if (stripos($line,"armor_type=") !== false)
    {
        // (5) category=...
        $oldmin = getKeyValue("armor_type",$line);
        $line   = str_replace(' armor_type="'.$oldmin.'"','',$line); 
    }
    if (stripos($line,"weapon_type=") !== false)
    {
        // (5) category=...
        $oldmin = getKeyValue("weapon_type",$line);
        $line   = str_replace(' weapon_type="'.$oldmin.'"','',$line); 
    }
    
    return $line;
}
// ----------------------------------------------------------------------------
// Vergleichsdateien erzeugen (aus dem SVN und der akt. erzeugten Datei)
// - ersetzt u.a. alle Tabulatoren durch 4 Leerzeichen
// - wenn vorgegeben, dann werden bekannte Abweichungen heraus gefiltert
// ----------------------------------------------------------------------------
function makeCompareFiles()
{
    global $pathsvn;
    
    logHead("Erzeuge Vergleichsdateien");
    
    //                       letzer Ablgeich   Hinweise
    $doItemTemplate= false;  // OK 05.03.2016  Abweichunge lassen sich im Client nachvollziehen
    $doModifiers   = false;  // OK 02.03.2016  bekannte Abweichungen protokolliert/ausgeklammert!
    $doActions     = false;  // OK 06.03.2016  Abweichungen lassen sich im Client nachvollziehen!
    $doGodstone    = false;  // OK 03.03.2016  keine Abweichungen
    $doStigma      = false;  // OK 03.03.2016  nur broken Stigma-Abweichungen erkannt
    $doWeapon      = false;  // OK 03.03.2016  keine Abweichungen
    $doTradeIn     = false;  // OK 03.03.2016  keine Abweichungen
    $doAcquisition = false;  // OK 04.03.2016  keine Abweichungen
    $doDisposition = false;  // OK 04.03.2016  keine Abweichungen
    $doImprove     = false;  // OK 04.03.2016  keine Abweichungen
    $doUselimits   = false;  // OK 04.03.2016  Abweichungen lassen sich im Client nachvollziehen!
    $doInventory   = false;  // OK 04.03.2016  keine Abweichungen
    $doIdian       = false;  // OK 04.03.2016  keine Abweichungen
    
    $changeValues  = true;   // bekannte Abweichungen durch "xxx" ersetzen!!!!!!!
    $hideValues    = false;  // einige Abweichungen im Test ausblenden !!!!!!!!!!
    
    // bei 0 = SVN, bei 1 = neues File
    for ($i=0;$i<2;$i++)
    {    
        if ($i == 0)
        {
            $fileout = "../outputs/parse_output/Items/svn_item_templates_part.xml";
            $filesvn = formFileName($pathsvn."\\trunk\\AL-Game\\data\static_data\\Items\\item_templates.xml");
            logSubHead("Erstelle Vergleichsdatei aus dem SVN");
        }
        else
        {
            $fileout = "../outputs/parse_output/Items/neu_item_templates_part.xml";
            $filesvn = "../outputs/parse_output/Items/item_templates.xml";          
            logSubHead("Erstelle Vergleichsdatei aus dem Parser"); 
        }
        $hdlsvn  = openInputFile($filesvn);
        $hdlout  = openOutputFile($fileout);
        $inBlock = false;
        $itemid  = "";
        $cntles  = 0;
        $cntout  = 0;
        
        logLine("- Eingabedatei",$filesvn);
        logLine("- Ausgabedatei",$fileout);
        
        flush();
        
        while (!feof($hdlsvn))
        {
            $line = rtrim(fgets($hdlsvn));
            $cntles++;
            
            // Item-XML-Header immer ausgeben
            if (stripos($line,"<item_template ") !== false)
            {
                $itemid = getKeyValue("id",$line);
                fwrite($hdlout,"    <!-- ".$itemid." -->\n");
            }
            
            // innerhalb eines Block alles ausgeben
            if ($inBlock)
            {
                if ($changeValues) $line = changeValuesInLine($line);
                if ($hideValues)   $line = changeKnownValuesInLine($line);
                
                // Ausgabe der Zeile (mit Ersetzung der Tabulatoren!)
                fwrite($hdlout,str_replace("\t","    ",$line)."\n");
                $cntout++;
                
                // Blockende?
                if (($doItemTemplate    && stripos($line,"</item_template>") !== false)
                ||  ($doModifiers       && stripos($line,"</modifier") !== false)
                ||  ($doActions         && stripos($line,"</action")   !== false)
                ||  ($doGodstone        && stripos($line,"</godstone") !== false)
                ||  ($doStigma          && stripos($line,"</stigma")   !== false)
                ||  ($doWeapon          && stripos($line,"</weapon")   !== false)
                ||  ($doTradeIn         && stripos($line,"</tradein")  !== false)
                ||  ($doAcquisition     && stripos($line,"</acquisit") !== false)
                ||  ($doDisposition     && stripos($line,"</disposit") !== false)
                ||  ($doImprove         && stripos($line,"</improve")  !== false)
                ||  ($doUselimits       && stripos($line,"</uselimit") !== false)
                ||  ($doInventory       && stripos($line,"</inventor") !== false)
                ||  ($doIdian           && stripos($line,"</idian")    !== false))
                {
                    $inBlock = false;
                }
            }
            else
            {
                // Blockanfang?
                if (($doItemTemplate    && stripos($line,"<item_template ") !== false)
                ||  ($doModifiers       && stripos($line,"<modifier") !== false)
                ||  ($doActions         && stripos($line,"<action")   !== false)
                ||  ($doGodstone        && stripos($line,"<godstone") !== false)
                ||  ($doStigma          && stripos($line,"<stigma")   !== false)
                ||  ($doWeapon          && stripos($line,"<weapon")   !== false)
                ||  ($doTradeIn         && stripos($line,"<tradein")  !== false)
                ||  ($doAcquisition     && stripos($line,"<acquisit") !== false)
                ||  ($doDisposition     && stripos($line,"<disposit") !== false)
                ||  ($doImprove         && stripos($line,"<improve")  !== false)
                ||  ($doUselimits       && stripos($line,"<uselimit") !== false)
                ||  ($doInventory       && stripos($line,"<inventor") !== false)
                ||  ($doIdian           && stripos($line,"<idian")    !== false))
                {
                    if ($changeValues) $line = changeValuesInLine($line);
                    if ($hideValues)   $line = changeKnownValuesInLine($line);
                    
                    fwrite($hdlout,str_replace("\t","    ",$line)."\n");
                    $cntout++;
                    
                    // nur ein Einzeiler ?
                    if (stripos($line,"/>") === false)
                        $inBlock = true;
                    
                    // nur die Hauptzeile ausgeben zu <item_template                     
                    if ($doItemTemplate && stripos($line,"<item_template ") !== false)
                        $inBlock = false;
                }
            }
        }
        fclose($hdlsvn);
        fclose($hdlout);
        
        logLine("- Zeilen eingelesen",$cntles);
        logLine("- davon ausgegeben",$cntout);
    }
    
    flush();
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------

$starttime     = microtime(true);
$purxmlkom     = true;     // purification: XML-Kommentare (ohne=false)
$tabTpls       = array();

$chkNUM = $doSortItemsSvn  == false ? ' checked' : "";
$chkSVN = $doSortItemsSvn  == true  ? ' checked' : "";
$chkCMP = $doCompareFiles == true  ? ' checked' : "";

// Vorgaben für Sortierung / Abgleichdateien erzeugen
echo '
   <tr>
     <td><font color=orange>Item-Sortierung</font></td>
     <td>
       <input type="radio" name="itsort" value="SVN" '.$chkSVN.'> Reihenfolge wie im SVN &nbsp; &nbsp;
       <input type="radio" name="itsort" value="NUM" '.$chkNUM.'> numerisch aufsteigend 
     </td>
   </tr>
   <tr>
     <td><font color=orange>Abgleich-Dateien erstellen</font></td>
     <td>
       <input type="checkbox" name="compare" value="Ja" '.$chkCMP.'> markiert = Ja
     </td>
   </tr>';
echo '
   <tr>
     <td colspan=2>
       <center>
       <br><br>
       <input type="submit" name="submit" value="Generierung starten" style="width:220px;"><br><br>
       <input type="submit" name="abgleich" value="Abgleich-Dateien erzeugen" style="width:220px;background-color:orange">
       </center>
       <br>
     </td>
   </tr>
   <tr>
     <td colspan=2>';    

logStart();

include("includes/inc_getautonameids.php");
include("includes/inc_inc_scan.php");
include("includes/inc_itemtmplparse.php");

if ($submit == "J")
{   
    if ($pathdata == "")
    {
        logLine("ACHTUNG","die Pfade sind anzugeben");
    }
    else
    {
        // client_items_xxx.xml-Dateien einmalig scannen und ein Include erzeugen,
        // um Zeit einzusparen! Das Scannen muss gesplittet werden, da sonst der
        // Speicher nicht ausreicht (out of memory).
        if (!file_exists("includes/auto_inc_client_items.csv"))
        {
            writeHinweisVorarbeiten("Client-Items CSV-Datei");
            scanClientItemTemplateFiles();
            
            $doneGenerInclude = true;
            
            unset($tabTpls);
        }
        else
        {
            // prüfen, ob die sonstigen Includes existieren, sonst erzeugen
            checkAutoIncludeFiles();              
            cleanPathUtf8Files();      
        }
        // wenn Vorarbeiten notwendig waren, dann Hinweis und neu starten
        if ($doneGenerInclude)
        {
            logSubHead("<br><br><div style='background-color:#000033;border:1px solid silver;padding:20px;text-align:center;'>".
                       "WICHTIGER HINWEIS<br><br>".    
                       "Ein Teil der Vorarbeiten zum Erzeugen der Includes ist abgeschlossen.<br><br>".
                       "Bitte die <font color=magenta>Generierung erneut starten</font>!<br><br><br>".                       
                       "<input type='submit' name='submit' value='Erneut starten'><br></div>");
        }
        else
        {
            include("includes/inc_itemattrs.php");
            include("includes/inc_bonusattrs.php");
            include("includes/inc_modifierattrs.php");
            
            // auto-generated Includes
            include("includes/auto_inc_anim_names.php");
            include("includes/auto_inc_auth_names.php");
            include("includes/auto_inc_desc_names.php");
            include("includes/auto_inc_housedeco_names.php");
            include("includes/auto_inc_houseobject_names.php");
            include("includes/auto_inc_item_names.php");       // neu in 4.9
            include("includes/auto_inc_item_infos.php");       // neu in 4.9
            include("includes/auto_inc_npc_infos.php");        // neu in 4.9
            include("includes/auto_inc_polish_names.php");
            include("includes/auto_inc_quest_names.php");
            include("includes/auto_inc_recipe_names.php");
            include("includes/auto_inc_ride_names.php");
            include("includes/auto_inc_rndopt_names.php");
            include("includes/auto_inc_robot_names.php");
            include("includes/auto_inc_skill_names.php");
            include("includes/auto_inc_skillreplace_names.php");
            include("includes/auto_inc_toypet_names.php");
            include("includes/auto_inc_world_names.php");  
            
            writeHinweisOhneVorarbeiten();
            
            //logHead("<br><br><center><h1>ACHTUNG - TEST-VERSION - ACHTUNG</h1></center><br><br>");
            
            generAssemblyItems();
            generEnchantTables();
            generEnchantTemplates();
            generGroups();
            generMultiReturns();
            generPurifications();
            generRandomBonuses();
            generRestrictionCleanups();
            generItemSets();
            generItemTemplates();
            
            if ($doCompareFiles) 
            {
                $genertime = substr(microtime(true) - $starttime,0,8);
                logSubHead("<hr>");
                logLine("- Generierungs-Zeit",$genertime." Sekunden");
                
                makeCompareFiles();
            }
        }
    }
}
else  
    if ($abgleich == "J")
        makeCompareFiles();

        
logStop($starttime,true,true); 

echo '
      </td>
    </tr>
  </table>';
?>
</form>
</body>
</html>