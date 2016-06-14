<html>
<head>
  <title>
    DropGenerator Test - Anzeigen Item-Templates / Drop-Gruppen"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
include("../includes/inc_globals.php");
include("includes/drop_template_inc.php");
include("includes/item_template_inc.php");
include("includes/item_dropgroup_inc.php");
include("classes/drop_template_class.php");
include("classes/item_template_class.php");
include("classes/item_dropgroup_class.php");

$item  = isset($_GET['item'])   ? $_GET['item']   : "182400001";
$group = isset($_GET['group'])  ? $_GET['group']  : "MANASTONE";
$isnot = isset($_GET['isnot'])  ? true            : false;
$send  = isset($_GET['submit']) ? $_GET['submit'] : "Suche Item";

$item  = trim($item);
?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Anzeige-/Test-Funktion - Anzeigen Item-Templates / Drop-Gruppen</div>
  <div class="hinweis" id="hinw">
    Testen der Item-Template-/Item-DropGroup-PHP-Generierung sowie der Verarbeitungs-Klassen.<br><br>
    Wenn bei der Anzeige keinerlei Fehler auftreten und auch die Suche ein korrektes (identisches)
    Ergebnis liefert, dann wurden die PHP-Includes korrekt generiert
    (eventuell dann im Backup-Verzeichnis data_backups l&ouml;schen). Diese Seite kann aber
    auch zur Ansicht von Item-/Gruppen-Infos genutzt werden.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte notwendige Informationen einf&uuml;gen</h1>
<form name="edit" method="GET" action="index_genitm_test.php" target="_self">
 <br>
 <table width="700px">
   <colgroup>
     <col style="width:180px">
     <col style="width:260px">
     <col style="width:260px">
   </colgroup>
   <tr>
     <td colspan=3><center>
       <span style="font-size:14px;color:cyan;padding-right:10px;">Suchen Item</span>
<?PHP
    
echo '     
       <input type="text" id="iditem" name="item" value="'.$item.'" style="width:80px;">';
?>
       <span style="font-size:14px;color:orange;padding-left:10px;">oder</span>
       <span style="font-size:14px;color:cyan;padding-left:10px;padding-right:10px">Suchen Gruppe(n)</span>
<?PHP
echo '     
       <input type="text" id="idgroup" name="group" value="'.$group.'" style="width:270px;">
       <input type="checkbox" id="idisnot" name="isnot" value="is not">
       <span style="font-size:14px;color:cyan;padding-right:10px;">ungleich</spawn>';
echo '
       </center>
     </td>
   </tr>';
// ----------------------------------------------------------------------------
//
//                       H I L F S F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Link zur Item-Anzeige der Gruppe aufbereiten
// ----------------------------------------------------------------------------
function getGroupLink($group)  
{
    global $tabIndexLink, $tabButtons;
    
    $ret = "<a href='".basename(__FILE__)."?submit=".$tabButtons[$tabIndexLink][1]."&group=$group' ".
           "target='_self'>".$group."</a>";
           
    return $ret;
} 
// ----------------------------------------------------------------------------
// Link zu AionDataBase-Item-Anzeige        id -> deutsch
// ----------------------------------------------------------------------------
function getItemLinkId($id,$text,$type)
{
    if ($type == "ID")        // ID = Link auf -> deutsch für ItemId
        $ret = "<a href='http://aiondatabase.net/de/item/$id' target='_blank'>".$id."</a>";
    else                      // TX = Link auf -> englisch für Text
        $ret = "<a href='http://aiondatabase.net/en/item/$id' target='_blank'>".$text."</a>";
        
    return $ret;
}
// ----------------------------------------------------------------------------
//
//                    A N Z E I G E - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// allgemeine Informationen anzeigen
// ----------------------------------------------------------------------------
function showInfos()
{
    global $tabItemTemplates, $tabItemDropGroups, $tabDropTemplates;
    
    $tempTpl = new DropTemplateClass($tabDropTemplates,false);
    $itemTpl = new ItemTemplateClass($tabItemTemplates);
    $dropTpl = new ItemDropGroupClass($tabItemDropGroups);
    
    // nur kurz testen wegen doppelter Einträge, dann wieder freigeben
    $drops   = count($tabDropTemplates);
    $dtext   = ($tempTpl->isError()) ? $tempTpl->getErrorText() : "";
    
    unset($tempTpl);
    unset($tabDropTemplates);
    
    $tdh     = "td style='color:orange;font-size:14px;border-bottom:1px solid cyan;padding-bottom:10px'";
    $td1     = "td style='color:orange'";
    $td2     = "td style='color:cyan'";
    $tdr     = "td style='color:orange;text-align:right'";
    
    echo "\n    <tr><td colspan=3><table width=100%>";
    echo "\n    <tr><$tdh>Aktion</td><$tdh>Beschreibung</td><$tdh colspan=2>Ergebnis</td><$tdh>in Zeit (secs)</tr>";
    echo "\n    <tr><$td1 colspan=5>&nbsp;</td></tr>";
    
    // Infos zu DropTemplates
    if ($dtext == "")
        echo   "\n    <tr><$td1 colspan=5><center><h2>Drop-Templates</h2></center></td></tr>".   
               "<tr><$td1>Initialisierung</td><$td2>OK</td><$tdr>".$drops.
               "</td><$td2>Gruppen in der Klassen-Tabelle</td><$td2>&nbsp;</td></tr>";
    else
    {
        echo   "\n    <tr><$td1 colspan=5><center><h2>Drop-Templates</h2></center></td></tr>".   
               "<tr><$td1>Initialisierung</td><$td2>ERROR</td><$tdr>".$drops.
               "</td><$td2>Gruppen in der Klassen-Tabelle</td><$td2>&nbsp;</td></tr>".
               "<tr><$td1>Fehlerhinweise</td><$td2 colspan=3>".$dtext."</td></tr>";
    }
    
    // Infos zu ItemTemplates
    echo "\n    <tr><$td1 colspan=5><center><h2>Item-Templates</h2></center></td></tr>".   
               "<tr><$td1>Initialisierung</td><$td2>OK</td><$tdr>".$itemTpl->getCountRows().
               "</td><$td2>Items in der Klassen-Tabelle</td><$td2>&nbsp;</td></tr>";
         
    $startat = microtime(true);    
    $dummy   = $itemTpl->getItemInfoToSearch("167000","","","","");
    $usetime = substr(microtime(true) - $startat,0,8);
    echo "\n    <tr><$td1>Item-Suche</td><$td2>Items, die mit '167000' beginnen</td><$tdr>".count($dummy).
               "</td><$td2>Items gefunden</td><$td2>$usetime</td></tr>";
    unset($dummy);
    
    // Infos zu ItemDropGroups
    echo "\n    <tr><$td1 colspan=5><center><h2>Item-Drop-Gruppen</h2></center></td></tr>".
               "<tr><$td1>Initialisierung</td><$td2>OK</td><$tdr>".$dropTpl->getCountRows().
               "</td><$td2>Gruppen in der Klassen-Tabelle</td><$td2>&nbsp;</td></tr>";
         
    $startat = microtime(true);    
    $dummy   = $dropTpl->getGroupInfoToSearch("MANASTONE",false);
    $usetime = substr(microtime(true) - $startat,0,8);
    echo "\n    <tr><$td1>Drop-Gruppen-Suche</td><$td2>Gruppen, die 'MANASTONE' enthalten</td>".
               "<$tdr>".count($dummy)."</td><$td2>Gruppen gefunden</td><$td2>$usetime</td></tr>";
    unset($dummy);
    
    $startat = microtime(true);    
    $dummy   = $dropTpl->getGroupInfoToSearch("MANASTONE",true);
    $usetime = substr(microtime(true) - $startat,0,8);
    echo "\n    <tr><$td1>Drop-Gruppen-Suche</td><$td2>Gruppen ohne 'MANASTONE' im Namen</td>".
               "<$tdr>".count($dummy)."</td><$td2>Gruppen gefunden</td><$td2>$usetime</td></tr>";
    echo "\n    </table></td></tr>";                  
    
    unset($dummy);
}
// ----------------------------------------------------------------------------
// Suche nach allen Items, deren ID mit $item beginnen
// ----------------------------------------------------------------------------
function searchAllItems()
{
    global $item, $tabItemTemplates;
    
    $tdh       = "td style='color:orange;font-size:14px;border-bottom:1px solid cyan;padding-bottom:10px'";
    $td1       = "td style='color:cyan'";
    
    echo "\n    <tr>
                  <td colspan=3>
                    <table width=100%>";
    
    $starttime = microtime(true);
    
    $itemTpl = new ItemTemplateClass($tabItemTemplates,false); 
    $itemTab = $itemTpl->getItemInfoToSearch($item,"","","",""); 
                
    echo "<tr><td colspan=4><center><h2 style='color:orange'>Ergebnis der Item-Suche (".count($itemTab)." Items)</h2></center></td></tr>";
    echo "\n    <tr><$tdh>Id</td><$tdh>Name</td><$tdh>Level</td><$tdh>Drop-Gruppe</td></tr>";             
    
    for ($i=0;$i<count($itemTab);$i++)
    {    
        echo "\n          <tr>
                            <$td1>".getItemLinkId($itemTab[$i]['id'],$itemTab[$i]['name'],"ID")."</td>
                            <$td1>".getItemLinkId($itemTab[$i]['id'],$itemTab[$i]['name'],"TX")."</td>
                            <$td1>".$itemTab[$i]['level']."</td>
                            <$td1>".getGroupLink($itemTab[$i]['group'])."</td>
                          </tr>";
    }
    $usetime = substr(microtime(true) - $starttime,0,8);
    
    echo "\n    <tr><td colspan=5>&nbsp;</td></tr>";
    echo "\n    <tr><$td1 colspan=3>Zeit in Sekunden</td><td colspan=2>".$usetime."</td></tr>";
    
    echo "
                    </table>
                  </td>
                </tr>";
}
// ----------------------------------------------------------------------------   
// Suche nach einem Item
// ----------------------------------------------------------------------------
function searchItem()
{
    global $item, $tabItemTemplates;
    
    // wenn die ItemId kürzer als 9 Stellen ist, dann alle Items suchen, die mit
    // der Vorgabe beginnen
    if (strlen($item) < 9)
    {
        searchAllItems();
        return;
    }
    
    $itemTpl = new ItemTemplateClass($tabItemTemplates);
       
    $key1      = "'".$item."'";
    $tdh       = "td style='color:orange;font-size:14px;border-bottom:1px solid cyan;padding-bottom:10px'";
    $td1       = "td style='color:cyan'";
    
    echo "<tr><td colspan=3><center><h2 style='color:orange'>Ergebnis der Item-Suche</h2></center></td></tr>"; 
    echo "<tr><$tdh>Beschreibung</td><$tdh>ohne Table-Scan<br>(direkter Zugriff per Key)</td><$tdh>mit Table-Scan<br>(sequentielles suchen in der Tabelle)</td></tr>";
    echo "<tr><th colspan=3>&nbsp;</th></tr>";
    
    if ($itemTpl->checkItemInTemplate($item))
    {
        $starttime = microtime(true);
        
        // direkter Zugriff über Item        
        $tabItem1 = $itemTpl->getItemInfoToItemId($item);
        $usetime1 = substr(microtime(true) - $starttime, 0, 8);
        
        // Scan-Zugriff (simuliert, da ja Item bekannt)
        $starttime = microtime(true);
        $key2      = $itemTpl->getItemTableKey($item);
        $tabItem2  = $itemTpl->getItemInfoToItemId($item);
        $usetime2  = substr(microtime(true) - $starttime, 0, 8);                
        
        echo "\n    <tr><$td1>ermittelter Schl&uuml;ssel = Index</td><td>'$item'<td>$key2</td></tr>";        
        echo "\n    <tr><$td1>ItemId</td><td>".getItemLinkId($tabItem1['id'],$tabItem1['name'],"ID")."</td><td>".$tabItem2['id']."<td></tr>";
        echo "\n    <tr><$td1>Name</td><td>".getItemLinkId($tabItem1['id'],$tabItem1['name'],"TX")."</td><td>".$tabItem2['name']."<td></tr>";
        echo "\n    <tr><$td1>Category</td><td>".$tabItem1['category']."</td><td>".$tabItem2['category']."<td></tr>";
        echo "\n    <tr><$td1>Quality</td><td>".$tabItem1['quality']."</td><td>".$tabItem2['quality']."<td></tr>";
        echo "\n    <tr><$td1>Level</td><td>".$tabItem1['level']."</td><td>".$tabItem2['level']."<td></tr>";
        echo "\n    <tr><$td1>Drop-Group</td><td>".getGroupLink($tabItem1['group'])."</td><td>".$tabItem2['group']."<td></tr>";
        echo "\n    <tr><$td1>Zeit in Sekunden</td><td>".$usetime1."</td><td>".$usetime2."</td></tr>";
    }
        else echo "\n    <tr><td colspan=3><center><font color='magenta'><h2>das vorgegebene Item ist NICHT vorhanden</h2></font></td></tr>";
}
// ----------------------------------------------------------------------------   
// Suche nach Gruppen, die im Namen die Such-Vorgabe enthalten
// ----------------------------------------------------------------------------
function searchGroup()
{
    global $group, $isnot, $tabItemDropGroups;
    
    $dropTpl = new ItemDropGroupClass($tabItemDropGroups);
       
    $tdh       = "td style='color:orange;font-size:14px;border-bottom:1px solid cyan;padding-bottom:10px'";
    $td1       = "td style='color:cyan'";
    
    $starttime = microtime(true);
    $ergTab    = $dropTpl->getGroupInfoToSearch($group,$isnot);
    $usetime   = substr(microtime(true) - $starttime, 0, 8);  
    $anzitems  = 0;
    
    echo "<tr><td colspan=3><center><h2 style='color:orange'>Ergebnis der Gruppen-Suche (".count($ergTab)." Gruppen)</h2></center></td></tr>";
    echo "<tr><$tdh colspan=2>Drop-Gruppen-Name</td><$tdh>Anzahl Items</td></tr>";
    echo "<tr><th colspan=2>&nbsp;</th></tr>";
    
    if (count($ergTab) > 0)
    {
        for ($g=0;$g<count($ergTab);$g++)
        {       
            echo "\n    <tr><$td1 colspan=2>".getGroupLink($ergTab[$g]['name'])."</td><td>".$ergTab[$g]['cntitems']."</td></tr>";
            
            $anzitems += $ergTab[$g]['cntitems'];
        }
        echo "\n    <tr><$td1 colspan=2><br>Gesamt Items im Suchergebnis</td><td><br>".$anzitems."</td></tr>";
    }
        else echo "\n    <tr><td colspan=3><center><font color='magenta'><h2>zur Suche wurden keine Gruppen gefunden</h2></font></td></tr>";
       
    echo "\n    <tr><$td1 colspan=2><br>Zeit in Sekunden</td><td><br>".$usetime."</td></tr>";
}
// ----------------------------------------------------------------------------
// Suchen aller Items einer Gruppe
// ----------------------------------------------------------------------------
function searchGroupItems()
{    
    global $group, $tabItemDropGroups, $tabItemTemplates;
    
    $tdh       = "td style='color:orange;font-size:14px;border-bottom:1px solid cyan;padding-bottom:10px'";
    $td1       = "td style='color:cyan'";
    
    echo "\n    <tr>
                  <td colspan=3>
                    <table width=100%>";                
    
    $dropTpl   = new ItemDropGroupClass($tabItemDropGroups);
    $starttime = microtime(true);    
    
    if ($dropTpl->checkGroupInDropGroup($group)) 
    {    
        $itemTpl = new ItemTemplateClass($tabItemTemplates); 
        $itemTab = $itemTpl->getItemInfoToSearch("","","","",$group); 
        
        echo "<tr><td colspan=5><center><h2 style='color:orange'>Ergebnis der Gruppen-Items-Suche (".count($itemTab)." Items)</h2></center></td></tr>";
        echo "\n    <tr><$tdh>Id</td><$tdh>Name</td><$tdh>Level</td><$tdh>Category</td><$tdh>Quality</td></tr>";             
        
        for ($i=0;$i<count($itemTab);$i++)
        {    
            echo "\n          <tr>
                                <$td1>".getItemLinkId($itemTab[$i]['id'],$itemTab[$i]['name'],"ID")."</td>
                                <$td1>".getItemLinkId($itemTab[$i]['id'],$itemTab[$i]['name'],"TX")."</td>
                                <$td1>".$itemTab[$i]['level']."</td>
                                <$td1>".$itemTab[$i]['category']."</td>
                                <$td1>".$itemTab[$i]['quality']."</td>
                              </tr>";
        }
        $usetime = substr(microtime(true) - $starttime,0,8);
        
        echo "\n    <tr><td colspan=5>&nbsp;</td></tr>";
        echo "\n    <tr><$td1>Zeit in Sekunden</td><td colspan=4>".$usetime."</td></tr>";
    }
    else
        echo "\n    <tr><td colspan=5><center><font color='magenta'><h2>die angegebene Gruppe ist nicht vorhanden</h2></font></td></tr>";
    
    echo "
                    </table>
                  </td>
                </tr>";
    
    unset($itemTab);
    unset($itemTpl);
}
// ----------------------------------------------------------------------------
function generDropTemplate()
{
    global $group, $tabItemDropGroups, $tabItemTemplates;
    
    $tdh       = "td style='color:orange;font-size:14px;border-bottom:1px solid cyan;padding-bottom:10px'";
    $td1       = "td style='color:cyan'";
    
    echo "\n    <tr>
                  <td colspan=3>
                    <table width=100%>";
    
    $fileout   = "drop_output_gener/".strtolower($group).".php";    
    $dropTpl   = new ItemDropGroupClass($tabItemDropGroups);
    $starttime = microtime(true);
    $leer      = str_pad("",24," ");
    $strich    = str_pad("",80,"-");
    
    if ($dropTpl->checkGroupInDropGroup($group)) 
    {    
        $itemTpl = new ItemTemplateClass($tabItemTemplates); 
        $itemTab = $itemTpl->getItemInfoToSearch("","","","",$group);              
        
        $hdlout = fopen($fileout,"w");
        
        fwrite($hdlout,$strich."\n");
        fwrite($hdlout,"// generiert am/um ".date("d.m.Y H.i")." aus der Drop-Generator-Oberfläche\n");
        fwrite($hdlout,"// Bitte die nachfolgenden Zeilen in das PHP-Include für die Drop-Templates einfügen\n");
        fwrite($hdlout,"// Bitte NICHT VERGESSEN, die notwendigen Anpassungen für die Gruppe vorzunehmen\n");
        fwrite($hdlout,$strich."\n\n");

        $sortid = substr($itemTab[0]['id'],0,3);
        
        $max = count($itemTab) - 1;
        
        fwrite($hdlout,$leer."//\n");
        fwrite($hdlout,$leer."//         ".substr($sortid,0,1)."  ".substr($sortid,1,1)."  ".substr($sortid,2,1)."\n");
        fwrite($hdlout,$leer."//\n");
        fwrite($hdlout,$leer."// generiert aus Drop-Generator\n");
        fwrite($hdlout,$leer.'array("'.$sortid.'","'.$group.'","'.$group.'",'."\n");
        fwrite($hdlout,$leer."  array (\n");
        
        for ($i=0;$i<($max - 1);$i++)
        {
            if ($itemTab[$i]['id'] == "182400001")
                fwrite($hdlout,$leer.'    array("'.$itemTab[$i]['id'].'","100.00","'.$itemTab[$i]['name'].'"),'."\n");
            else
                fwrite($hdlout,$leer.'    array("'.$itemTab[$i]['id'].'","10.00","'.$itemTab[$i]['name'].'"),'."\n");
        }
        // Letztes Item ohne abschliessendes Komma  
        $i = $max; 
        
        if ($itemTab[$i]['id'] == "182400001")
            fwrite($hdlout,$leer.'    array("'.$itemTab[$i]['id'].'","100.00","'.$itemTab[$i]['name'].'"),'."\n");
        else
            fwrite($hdlout,$leer.'    array("'.$itemTab[$i]['id'].'","10.00","'.$itemTab[$i]['name'].'"),'."\n");
                   
        fwrite($hdlout,$leer."  )\n");
        fwrite($hdlout,$leer."),");
        fclose($hdlout);
        
        $usetime = substr(microtime(true) - $starttime,0,8);
        echo "\n    <tr><td colspan=3><br><br><br><center><h2 style='color:orange'>Ergebnis der Drop-Template-Generierung</h2></center><br></td></tr>";
        echo "\n    <tr><$td1>Ausgabedatei</td><td colspan=2>".$fileout."</td></tr>";
        echo "\n    <tr><$td1>Ergebnis</td><td colspan=2>".count($itemTab)." Items wurden ausgegeben</td></tr>";
        echo "\n    <tr><td colspan=5>&nbsp;</td></tr>";
        echo "\n    <tr><$td1>Zeit in Sekunden</td><td colspan=4>".$usetime."</td></tr>";
    }
    else
        echo "\n    <tr><td colspan=5><center><font color='magenta'><h2>die angegebene Gruppe ist nicht vorhanden</h2></font></td></tr>";
    
    echo "
                    </table>
                  </td>
                </tr>";
}
// -------------------
//     M  A  I  N
// -------------------

$tabButtons = array(
                    array("IT","Suche Item(s)"),
                    array("GR","Suche Gruppen(n)"),
                    array("GI","Anzeige Gruppen-Items"),
                    array("GD","Generiere Drop-Template")
                   );
$tabIndexLink = 2; // zeigt auf GI (ggfs. anpassen) und wird für den LINK benutzt

$aktion = "0";

for ($b=0;$b<count($tabButtons);$b++)
{
    if ($tabButtons[$b][1] == $send)
        $aktion = $tabButtons[$b][0];
}
// Anforderung interpretieren
switch ($aktion)
{
    case "IT": searchItem();         break;
    case "GR": searchGroup();        break;
    case "GI": searchGroupItems();   break;
    case "GD": generDropTemplate();  break;
    default  : showInfos();          break;
}
echo "
 </table> 
 <br><br>";

$buttStyle = ' style="width:153px;padding:0px;" ';
$buttHome  = ' style="width:153px;padding:0px;background-color:dodgerblue;" ';
for ($b=0;$b<count($tabButtons);$b++)
{
    // Ausnahme: Generieren (GD) nur, wenn auch Gruppen-Item-Anzeige (GI) 
    if ($tabButtons[$b][0] != "GD" 
    || ($tabButtons[$b][0] == "GD" && $aktion == "GI") )
    echo ' 
 <input'.$buttStyle.'name="submit" type="submit" value="'.$tabButtons[$b][1].'">';
} 
echo ' 
 <a href="index_dropgen.php" target="_self"><input type="button"'.$buttHome.'value="Startseite"></a>
</form>';

putIndexFoot();
?>

</body>
</html>