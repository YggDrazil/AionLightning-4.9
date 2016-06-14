<html>
<head>
  <title>
    Goodslist/Tradelist - Erzeugen goodslists.xml und npc_trade_list.xml"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
include("../includes/inc_globals.php");

getConfData();

if (!file_exists("../outputs/parse_output/goodslists"))
    mkdir("../outputs/parse_output/goodslists");

$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen Goodslists/TradeList-Dateien</div>
  <div class="hinweis" id="hinw">
    Erzeugen der Dateien goodslists.xml und npc_trade_list.xml.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genGoodlist.php" target="_self">
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
// Tabelle mit den Namen und IDs der Items aufbauen
// ----------------------------------------------------------------------------
function generGoodsItemTab()
{
    global $pathdata, $tabgoods;
    
    $tabfiles = array("client_items_misc.xml",
                      "client_items_etc.xml",
                      "client_items_armor.xml");
    $domax    = count($tabfiles);

    logHead("Erzeugen der Item-Referenz-Tabelle aus den Client-Files");
    
    for ($f=0;$f<$domax;$f++)
    {    
        $fileu16 = formFileName($pathdata."\\Items\\".$tabfiles[$f]);
        $fileext = convFileToUtf8($fileu16);
        
        flush();
        
        logSubHead("Verarbeite Datei: ".$fileu16);
        logLine("- Eingabedatei UTF8",$fileext);
        logFileSize("- ",$fileext);
        
        flush();
        
        $id     = "";
        $name   = "";
        $cntles = 0;
        $cntitm = 0;
        
        $hdlext = openInputFile($fileext);
        
        while (!feof($hdlext))
        {
            $line = rtrim(fgets($hdlext));
            $cntles++;
            
            if (stripos($line,"<id>") !== false)
                $id = getXmlValue("id",$line);
            else
            {
                if (stripos($line,"<name>") !== false)
                    $name = strtolower(getXmlValue("name",$line));
                
                if ($id != "" && $name != "")
                {
                    $tabgoods[$name] = $id;
                    $cntitm++;
                    
                    $id = $name = "";
                }
            }
        }
        logLine("- Zeilen eingelesen",$cntles);
        logLine("- selektierte Items",$cntitm);
    }
}
// ----------------------------------------------------------------------------
// Tabelle mit den Trade-Listen aufbauen
// ----------------------------------------------------------------------------
function generTradeListTab()
{
    global $pathdata,$tabtrades;
    
    $tabclient = array(
                       //    0=client-Filename              1=KeyPräfix
                       array("client_npc_goodslist.xml"    ,"0_G_"),
                       array("client_npc_trade_in_list.xml","1_T_"),
                       array("client_npc_purchase_list.xml","2_P_")
                      );
    $domax     = count($tabclient);
    $cnttab    = 0;
    
    for ($f=0;$f<$domax;$f++)
    {
        $fileext = "parse_input_utf8/".$tabclient[$f][0];
        
        logSubHead("Erzeuge Tabelle mit den Trade-Informationen");
        logLine("Eingabedatei UTF8",$fileext);
        
        flush();
        
        $hdlext = openInputFile($fileext);
        $id     = "";
        $name   = "";
        
        while (!feof($hdlext))
        {
            $line = rtrim(fgets($hdlext));
            
            if (stripos($line,"<id>") !== false)
                $id = getXmlValue("id",$line);
                
            if (stripos($line,"<name>") !== false)
            {
                $name = $tabclient[$f][1].strtolower(getXmlValue("name",$line));
                
                if (!isset($tabtrades[$name]))
                {
                    $tabtrades[$name] = $id;
                    $cnttab++;
                }
            }
        }
        fclose($hdlext);
    }
    logLine("ermittelte Trade-List-IDs",$cnttab);
}
// ----------------------------------------------------------------------------
// erzeugen der Tabelle mit den Referenzen NPC zu Trade-Listen
// ----------------------------------------------------------------------------
function generTradeInfoTab()
{
    global $pathdata,$tabnpcs;
    
    $fileu16 = formFileName($pathdata."\\Npcs\\client_npcs_npc.xml");
    $fileext = convFileToUtf8($fileu16);
    
    logSubHead("Erzeuge Tabelle mit den NPC-Trade-Infos");
    logLine("Eingabedatei UTF8",$fileext);
    
    flush();
    
    // Tabelle mit allen Trade-Infos-Xml-Tags
    // ACHTUNG: diese Tabelle enthält alle notwendigen Sterungs-Informationen, um die
    //          Verabeitung der zahlreichen Trade-XML-Tags einheitlich zu gestalten
    //          und steigert die Performance erheblich (10 statt 26 Sekunden)
    // AUFBAU : key    - das XML-Tag (ohne <>) wird als Schlüssel genutzt
    //          0      - XML-Tag, mit dem die Trade-Liste ermittelt werden kann
    //          1      - XML-Tag für einen möglichen Kaufpreis
    //          2      - XML-Tag für einen möglichen Verkaufspreis
    //          3      - NPC-Typen-Kennung
    //          4      - Präfix für das Sortieren und gleichzeitig als Quellen-Kennung:
    //                   - 0_G_  = Daten aus der goodslist
    //                   - 1_T_  = Daten aus der trade_in_list
    //                   - 2_P_  = Daten aus der purchase_list
    $tabxmls  = array(
                //    Start/Ende                           TradeList   Buy                  Sell               Npc-Type  Preafix
                //    Index =>                             0           1                    2                  3         4  
                //    Index-Konstante =>                   $cTRADELIST $cBUYPRICE           $cSELLPRICE        $cNPCTYPE $cPRAEFIX                
                      // Quelle: goodslist
                      "trade_info"                => array("tab",      "buy_price_rate",    "sell_price_rate", "NORMAL", "0_G_"),
                      "extra_currency_trade_info" => array("etab",     "buy_price_rate",    "sell_price_rate", "REWARD", "0_G_"),
                      "coupon_trade_info"         => array("ctab",     "buy_price_rate",    "sell_price_rate", "REWARD", "0_G_"),
                      "abyss_trade_info"          => array("atab",     "buy_price_rate",    "sell_price_rate", "ABYSS",  "0_G_"),
                      "abyss_qina_trade_info"     => array("ktab",     "buy_price_rate2",   "sell_price_rate2","ABYSS",  "0_G_"),
                      // Quelle: trade_in_list
                      "trade_in_trade_info"       => array("ttab",     "buy_price_rate",    "sell_price_rate", "NORMAL", "1_T_"),
                      // Quelle: purchase_list
                      "abyss_trade_buy_info"      => array("buy_atab", "ap_buy_price_rate2","sell_price_rate", "ABYSS",  "2_P_"),
                      "trade_buy_info"            => array("buy_tab",  "buy_price_rate2",   "sell_price_rate", "NORMAL", "2_P_"),
                     );
    // Konstanten für die Tabellen-Indizes (für die Verarbeitung einfacher)
    $cTRADELIST  = 0;
    $cBUYPRICE   = 1;
    $cSELLPRICE  = 2;
    $cNPCTYPE    = 3;
    $cPRAEFIX    = 4;
    
    $tabinfos = array();
    
    $hdlext = openInputFile($fileext);
    $cntnpc = 0;
    
    $infotype = "ohne";
    
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        
        if (stripos($line,"<id>") !== false)
        {
            $npcid = getXmlValue("id",$line);
        }
        
        // Trade-Liste-XML-Start-Tag vorgegeben?
        if (stripos($line,"_info>") !== false && stripos($line,"/") === false)
        {
            $infotype = "ohne";
            
            $xmlkey = getXmlKey($line);
            
            if (isset($tabxmls[$xmlkey]))
                $infotype = $xmlkey;
            
            if (isset($tabinfos[$xmlkey]))
                $tabinfos[$xmlkey]++;
            else
                $tabinfos[$xmlkey] = 1;
        }   
        else
        {
            // Trade-list-XML-Ende-Tag vorgegeben?
            if (stripos($line,$infotype) !== false && stripos($line,"/") !== false)
                $infotype = "ohne";
        }
        
        // entsprechend dem Infotypen (= Trade-List-XML-Tag) Zusatzinfos ermitteln
        if ($infotype != "ohne")
        {
            // Zusatzinformationen ermitteln
            $praef = $tabxmls[$infotype][$cPRAEFIX];
            
            if (stripos($line,"<".$tabxmls[$infotype][$cTRADELIST].">") !== false)
            {
                $list = $praef.strtolower(getXmlValue($tabxmls[$infotype][$cTRADELIST],$line));
                
                $tabnpcs[$npcid]['lists'][$list] = $list;
                
                if (!isset($tabnpcs[$npcid]['buypricerate']))
                {
                    $tabnpcs[$npcid]['listtype']      = $tabxmls[$infotype][$cPRAEFIX];
                    $tabnpcs[$npcid]['npctype']       = $tabxmls[$infotype][$cNPCTYPE];
                    $tabnpcs[$npcid]['buypricerate']  = 0;
                    $tabnpcs[$npcid]['sellpricerate'] = 0;
                    $cntnpc++;
                }
            }
            
            if (stripos($line,"<".$tabxmls[$infotype][$cBUYPRICE].">") !== false)
                $tabnpcs[$npcid]['buypricerate'] = getXmlValue($tabxmls[$infotype][$cBUYPRICE],$line);
            if (stripos($line,"<".$tabxmls[$infotype][$cSELLPRICE].">") !== false)
                $tabnpcs[$npcid]['sellpricerate'] = getXmlValue($tabxmls[$infotype][$cSELLPRICE],$line);            
        }
    }
    fclose($hdlext);
    
    logLine("ermittelte Trade-NPCs",$cntnpc);
    
    // Liste der gefundenen Trade-XML-Keys
    logSubHead("Liste der verwendeten XML-Trade-Info-Tags (XML-Tag / Anzahl gefunden)");
    
    while (list($key,$val) = each($tabinfos))
    {
        logLine($key,$val);
    }
}
// ----------------------------------------------------------------------------
// Erzeugen Tabelle mit den NPC-Trade-Infos
// ----------------------------------------------------------------------------
function generNpcTraderTab()
{
    global $tabtrades, $tabnpcs, $npctrades;
    
    $maxtrades = 0;
    $cntnpc    = 0;
    
    logSubHead("Zusammenf&uuml;hren der beiden Tabellen und sortieren");
    
    // Informationen zusammenführen
    while (list($npc,$val) = each($tabnpcs))
    {
        $cntnpc++;
        
        while (list($list,$val) = each($tabnpcs[$npc]['lists']))
        {
            if (isset($tabtrades[$list]))
            {
                $npctrades[$maxtrades]['sort']      = $tabnpcs[$npc]['listtype'].$npc."_".getSortNumValue($tabtrades[$list]);
                $npctrades[$maxtrades]['listtype']  = $tabnpcs[$npc]['listtype'];
                $npctrades[$maxtrades]['npcid']     = $npc;
                $npctrades[$maxtrades]['list']      = $tabtrades[$list];
                $npctrades[$maxtrades]['npctype']   = $tabnpcs[$npc]['npctype'];
                $npctrades[$maxtrades]['buyprice']  = $tabnpcs[$npc]['buypricerate'];
                $npctrades[$maxtrades]['sellprice'] = $tabnpcs[$npc]['sellpricerate'];
                
                $maxtrades++;
            }
            else
                logLine("Trade-Liste fehlt","npc=$npc, Liste=$list");
        }
    }
    
    sort($npctrades);
    
    // Zwischen-Tabellen freigeben, werden nicht mehr benötigt!
    unset($tabtrades);
    unset($tabnpcs);
    
    logLine("ermittelte Angaben",count($npctrades));
    logLine("Anzahl enthaltene NPCs",$cntnpc);
}
// ----------------------------------------------------------------------------
// Ausgabezeile formatieren
// ----------------------------------------------------------------------------
function getFormattedLine($line)
{
    $xmlkey = getXmlKey($line);
    
    $val = getXmlValue($xmlkey,$line);
    $val = str_replace(","," ",$val);
    
    // einige XML-Tags werden umbenannt
    if ($xmlkey == "friendly")        $xmlkey = "friend";
    if ($xmlkey == "aggressive")      $xmlkey = "aggro";
    
    $out = "    <".$xmlkey.">".strtoupper($val)."</".$xmlkey.">";
    return $out;
}
// ----------------------------------------------------------------------------
// Zeile für <salestime> aufbereiten!
// ----------------------------------------------------------------------------
function getSalestimeLine($time,$turn,$inter,$server)
{ 
    // ToDo: momentan fehlen noch die Informationen zur Interpretation, wie die
    //       salestime-Ausgabe aufgebaut ist, daher werden einige Werte derzeit
    //       wie folgt konstant gesetzt:
    //       <salestime>a b c ? d e</salestime>
    //
    //       a = 0
    //       b = 0
    //       c = 0
    //           ausser: wenn e = *, dann auch c = *
    //       d = *
    //       e = ersten 3 Stellen vom Client-Zeit-String (engl. Wochentag)
    //           ausser: EVE = siehe unten im switch
    //                   ALL = *  
    
    $fa = "0";
    $fb = "0";
    $fc = "0";
    $fd = "*";
    $fe = "*";
    
    // ToDo: prüfen, wie die nachfolgenden Strings korrekt interpretiert werden 
    //       müssten, aktuell werden sie KONSTANT ausgegeben!
    $timekey = strtoupper($time);
    
    switch ($timekey)
    {
        case "ALL_TURN":
                $fc ="*";
                break;
        case "EVERY_WEDNESDAY":
                $fe = "WED";
                break;
        case "EVERY_10_12_2_6_10_12":  
                $fc = "0,10,12,14,18,22";
                break;
        case "EVERY_10_12_4_8_10_12":
                $fc = "0,10,12,16,20,22";
                break;
        case "EVERY_10_14_18_22":
                $fc = "10,14,18,22";
                break;
        case "EVERY_MIDNIGHT_12":
                $fc = "12";
                break;
        case "EVENT_EVERY_10":
                $fc = "10";
                break;
        case "EVERY_NOON_12":
                $fc = "12";
                break;
        case "MONDAY_WORKTIME":
        case "TUESDAY_WORKTIME":
        case "WEDNESDAY_WORKTIME":
        case "THURSDAY_WORKTIME":
        case "FRIDAY_WORKTIME":
        case "SATURDAY_WORKTIME":
        case "SUNDAY_WORKTIME": 
                $fe = strtoupper(substr($time,0,3));
                $fc = "0";
                break;
        default: 
                logLine("Zeitangabe unbekannt",$timekey);
                break;
    }
    
    $ret = '        <salestime>'.$fa.' '.$fb.' '.$fc.' ? '.$fd.' '.$fe.'</salestime>';
    
    return $ret;
}
// ----------------------------------------------------------------------------
// Zeile für die sell-/buy-Limits aufbereiten
// ----------------------------------------------------------------------------
function getLimitsText($sell,$buy)
{
    if ($sell == "" || $sell == "?") $sell = "";
    if ($buy  == "" || $buy  == "?") $buy  = "";
    
    $ret = "";
    
    if ($sell != "") $ret .= ' sell_limit="'.$sell.'"';
    if ($buy  != "") $ret .= ' buy_limit="'.$buy.'"';
    
    return $ret;
}
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// ----------------------------------------------------------------------------
// Goodlist-Datei ausgeben
//
// Es werden verschiedene Client-Dateien hierzu gescannt, die allerdings alle
// ähnlich aufgebaut sind, sodass diese innerhalb dieser einen Funktion abge-
// arbeitet werden können. Die Unterschiede werden in der Tabelle $tabclient
// vorgegeben!
// ----------------------------------------------------------------------------
function generGoodlistFile()
{
    global $pathdata,$tabgoods,$hdlout;
    
    $tabclient = array(
                       //    0=client-Filename              1=Output-XML-Tag 
                       array("client_npc_goodslist.xml"    ,"list"         ),
                       array("client_npc_trade_in_list.xml","in_list"      ),
                       array("client_npc_purchase_list.xml","purchase_list")
                      );
    $taberror  = array();
    $domax     = count($tabclient);
    
    generGoodsItemTab();   
    
    $fileout   = "../outputs/parse_output/goodslists/goodslists.xml";
    $hdlout    = openOutputFile($fileout);
    $gesout    = 0;
    
    logHead("Generierung der Datei: goodslist.xml");    
        
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
    fwrite($hdlout,"<goodslists>\n");
    $gesout += 2;
    
    for ($c=0;$c<$domax;$c++)
    {
        $fileu16   = formFileName($pathdata."\\Npcs\\".$tabclient[$c][0]);    
        $fileext   = convFileToUtf8($fileu16);
        
        logSubHead("Scanne von Client-Datei: ".$tabclient[$c][0]);
        logLine("Eingabedatei UTF16",$fileu16);
        logLine("Eingabedatei UTF8",$fileext);
        
        flush();
        
        $cntles = 0;
        $cntout = 0;
        $cntitm = 0;
        $cntfnd = 0;
        $cntnfd = 0;
        
        $id     = "";
        $time   = "";
        $turn   = "";
        $inter  = "";
        $server = "";
        $sell   = "";
        $buy    = "";
        
        $dolist = false;
        $dosale = false;
        
        $hdlext = openInputFile($fileext);
        
        while (!feof($hdlext))
        {
            $line = rtrim(fgets($hdlext));
            $cntles++;
            
            // verzögerte Ausgabe für ...list id=...
            if (stripos($line,"<data>") !== false && $dolist)
            {             
                fwrite($hdlout,'    <'.$tabclient[$c][1].' id="'.$id.'">'."\n");
                $cntout++;
                $dolist = false;
                
                if ($dosale)
                {
                    $saleline = getSalestimeLine($time,$turn,$inter,$server);
                    
                    fwrite($hdlout,$saleline."\n");
                    $cntout++;
                    
                    $dosale = false;
                }
                $time = $turn = $inter = $server = "";
            }
            
            // substr-Erkennung, damit für alle identisch!
            if (stripos($line,"</client_npc_") !== false  &&  $id != "")
            {            
                if (!$dolist)
                {
                    // Abschluss, da Items vorhanden
                    fwrite($hdlout,"    </".$tabclient[$c][1].">\n"); 
                    $cntout++;
                }
                else
                {
                    // Abschluss als Leer-Xml-Tag, da keine Items vorhanden 
                    fwrite($hdlout,'    <'.$tabclient[$c][1].' id="'.$id.'" />'."\n");
                    $cntout++;
                }
                $id = "";
            }     
            
            // aktuelles Item ausgeben / abschliessen (verzögerte Ausgabe)
            if (stripos($line,"</data>") !== false)
            {
                if ($item != "")
                {
                    fwrite($hdlout,'        <item id="'.$itemid.'"'.getLimitsText($sell,$buy).' />'."\n");
                    $cntout++;
                }
                $item = $itemid = $sell = $buy = "";
            }
            
            // neue Goodslist?
            if (stripos($line,"<id>") !== false)
            {
                $id     = getXmlValue("id",$line);         
                $dolist = true;
            }
            
            // Zusatzangaben für salestime vorhanden?
            if (stripos($line,"<salestime_table_name>") !== false)      
            {
                $time   = getXmlValue("salestime_table_name",$line);
                $dosale = true;
            }        
            if (stripos($line,"<sales_clear_turn>") !== false)         
            {  
                $turn   = getXmlValue("sales_clear_turn",$line);
                $dosale = true;
            }
            if (stripos($line,"<sales_clear_interval>") !== false)       
            {
                $inter  = getXmlValue("sales_clear_interval",$line);
                $dosale = true;
            }
            if (stripos($line,"<sales_server>") !== false)            
            {   
                $server = getXmlValue("sales_server",$line);
                $dosale = true;
            }
                
            // Items zur aktuellen goodslist
            if (stripos($line,"<item>") !== false)
            {
                $item = strtolower(getXmlValue("item",$line));
                $cntitm++;
                
                if (isset($tabgoods[$item]))
                {
                    $itemid = $tabgoods[$item];
                    $cntfnd++;
                }
                else
                {
                    $cntnfd++;
                    fwrite($hdlout,'        <!-- <item id="" id not found for item "'.$item.'" /> -->'."\n");                    
                    $cntout++;
                    
                    if (isset($taberror[$item]))
                        $taberror[$item] .= ", $id"; 
                    else
                        $taberror[$item] = $id;
                    
                    $itemid = $item = "";
                }
            }
            if (stripos($line,"<sell_limit>") !== false)            $sell = getXmlValue("sell_limit",$line);
            if (stripos($line,"<buy_limit>")  !== false)            $buy  = getXmlValue("buy_limit",$line);
        }
    
        logLine("Zeilen Eingabedatei",$cntles);
        logLine("- darin enthaltene Items ",$cntitm);
        logLine("- davon Ids vorhanden",$cntfnd);
        logLine("- davon nicht gefunden",$cntnfd);
        logLine("Zeilen Ausgabedatei",$cntout);
        
        fclose($hdlext);
        
        $gesout += $cntout;
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</goodslists>");
    $gesout++;    
    fclose($hdlout);
    
    logSubHead("Erzeugen der Ausgabedatei");
    logLine("Ausgabedatei",$fileout);
    logLine("Gesamt Ausgabezeilen",$gesout);
    
    if (count($taberror) > 0)
    {    
        logHead("Liste der nicht gefundenen Items");
        
        while (list($key,$val) = each($taberror))
        {
            logLine("ID: $val",$key);
        }
    }
}
// ----------------------------------------------------------------------------
// Erzeugen der Referenzen von NPC zu Tradelist (npc_trade_liste.xml)
// ----------------------------------------------------------------------------
function generTradeListFile()
{    
    global $npctrades;
    
    logHead("Erzeugen der Datei: npc_trade_list.xml");
    
    generTradeListTab();
    generTradeInfoTab();
    generNpcTraderTab();
    
    $fileout = "../outputs/parse_output/npc_trade_list.xml";
    
    logSubHead("Erzeugen der Ausgabedatei");
    logLine("Ausgabedatei",$fileout);
    
    $hdlout = openOutputFile($fileout);
    
    $domax  = count($npctrades);
    $oldlist= "";
    $oldnpc = "";
    $aktxml = "";
    $cntnpc = 0;
    $cntout = 0;
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
    fwrite($hdlout,'<npc_trade_list xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="npc_trade_list.xsd">'."\n");
    $cntout += 2;
    
    for ($n=0;$n<$domax;$n++)
    {
        if ($oldlist != $npctrades[$n]['listtype'])
        {
            if ($oldnpc != "")
            {
                fwrite($hdlout,"    </".$aktxml."_template>\n");
                $cntout++;
            }
            
            $oldlist = $npctrades[$n]['listtype'];
            
            switch ($oldlist)
            {
                case "0_G_":
                    $aktxml = "tradelist";
                    fwrite($hdlout,"    <!-- TRADE LIST -->\n");
                    $cntout++;
                    break;
                case "1_T_":
                    $aktxml = "trade_in_list";
                    fwrite($hdlout,"    <!-- TRADE_IN LIST -->\n");
                    $cntout++;
                    break;
                case "2_P_":
                    $aktxml = "purchase";
                    fwrite($hdlout,"    <!-- PURCHASE LIST -->\n");
                    $cntout++;
                    break;
                default:
                    logLine("Fehler ListType",$oldlist);
                    $aktxml = "error";
                    fwrite($hdlout,"    <!-- UNKNOWN LIST -->\n");
                    $cntout++;
                    break;
            }
            $oldnpc = "";
        }    
        if ($oldnpc != $npctrades[$n]['npcid'])
        {
            if ($oldnpc != "")
            {
                fwrite($hdlout,"    </".$aktxml."_template>\n");
                $cntout++;
            }
            
            $oldnpc = $npctrades[$n]['npcid'];
            $text   = '    <'.$aktxml.'_template npc_id="'.$oldnpc.'"';
            $cntnpc++;
            
            if ($npctrades[$n]['buyprice'] != 0)
                $text .= ' buy_price_rate="'.$npctrades[$n]['buyprice'].'"';
            if ($npctrades[$n]['sellprice'] != 0)
                $text .= ' sell_price_rate="'.$npctrades[$n]['sellprice'].'"';
            if ($npctrades[$n]['npctype'] != "NORMAL")
                $text .= ' npc_type="'.$npctrades[$n]['npctype'].'"';
                
            fwrite($hdlout,$text.">\n");
            $cntout++;
        }
        
        fwrite($hdlout,'        <tradelist id="'.$npctrades[$n]['list'].'"/>'."\n");
        $cntout++;
    }
    fwrite($hdlout,"    </".$aktxml."_template>\n");
    $cntout++;
    
    // Nachspann ausgeben
    fwrite($hdlout,"</npc_trade_list>");
    $cntout++;
    
    fclose($hdlout);
    
    logLine("ausgegebene NPCs",$cntnpc);
    logLine("Gesamt Ausgabezeilen",$cntout);
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------

$tabgoods  = array();
$tabtrades = array();
$tabnpcs   = array();
$npctrades = array();

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
        generGoodlistFile();
        generTradeListFile();
        
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