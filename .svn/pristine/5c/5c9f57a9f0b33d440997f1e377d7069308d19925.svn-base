<html>
<head>
  <title>
    DropCheck - Löschen Drops von nicht gespawnten NPCs
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
// ----------------------------------------------------------------------------
// ----------------------------------------------------------------------------
include("../includes/inc_globals.php");

getConfData();

if (!file_exists("../outputs/drop_output_check"))
    mkdir("../outputs/drop_output_check");
    
if (!file_exists("../outputs/drop_output_check/delete"))
    mkdir("../outputs/drop_output_check/delete");
  
$selfile  = isset($_GET['file'])     ? $_GET['file']     : "";
$submit   = isset($_GET['submit'])   ? "J"               : "N";

?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">L&ouml;schen Drops zu nicht gespawnten NPCs</div>
  <div class="hinweis" id="hinw">
    L&ouml;schen aller Drops von NPCs, die aktuell im gew&auml;hlten Gebiet nicht gespawnt werden/sind.<br><br>
    ACHTUNG: die Pfade werden der aktuellen Konfigurations-Datei entnommen.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte notwendige Informationen einf&uuml;gen</h1>
<form name="edit" method="GET" action="index_dropcheck.php" target="_self">
 <br>
 <table width="700px">
   <colgroup>
     <col style="width:200px">
     <col style="width:500px">
   </colgroup>
   <tr><td colspan=2>&nbsp;</td></tr>
   <tr>
     <td colspan="2">
       <center>
       <span style="font-size:14px;color:cyan;padding-right:49px;">Drop-Datei-Auswahl</span>
       <select name="file" id="idfile" style="width:385;"> 
<?PHP
$droppath  = formFileName($pathsvn."\\trunk\\AL-Game\\data\\static_data\\npc_drops");
$spawnpath = formFileName($pathsvn."\\trunk\\AL-Game\\data\\static_data\\spawns");

$filetab   = scandir($droppath);
$filemax   = count($filetab);
$selected  = "";

for ($f=0;$f<$filemax;$f++)
{
    if (stripos($filetab[$f],".xml") !== false)
    {    
        if ($selfile == $filetab[$f])
            $selected = " selected";
        else
            $selected = "";
        
        echo "\n            <option value='".$filetab[$f]."'$selected>".$filetab[$f]."</option>";
    }
}

echo ' 
       </select>
     </td>
   </tr>';
   
// ----------------------------------------------------------------------------
//
//                       H I L F S F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Prüfen, ob Drop- und Spawn-Datei vorhanden sind
// ----------------------------------------------------------------------------
function checkFiles()
{
    global $droppath, $spawnpath, $selfile, $dropfile, $spawnfile;
    
    $checktab  = array( "Npcs","Instances","Bases","Beritra","Sieges","Statics" ); 
    $checkmax  = count($checktab);
    
    $ret       = true;
    $c_spawn   = false;
    $dropfile  = formFileName($droppath."\\".$selfile);
    
    // Drop-Datei vorhanden?
    if (!file_exists($dropfile))
    {
        logLine("Drop-Datei fehlt",$dropfile);
        $ret = false;
    }
    
    // Spawn-Datei in eines der Unterverzeichnisse vorhanden?
    for ($c=0;$c<$checkmax;$c++)
    {
        $spawnfile = formFileName($spawnpath."\\".$checktab[$c]."\\".$selfile);
        
        if (file_exists($spawnfile))
        {
            $c_spawn = true;
            $c       = $checkmax;
        }   
    }
    
    if ($c_spawn == false)
    {
        logLine("Spawn-Datei fehlt",$selfile);
        $ret = false;
    }
    
    return $ret;
}    
// ----------------------------------------------------------------------------
//
//                         S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// neuen NPC in die Spawn-Tabelle übernehmen
// ----------------------------------------------------------------------------
function addNpcToSpawnTable($npcid,$xpos,$ypos,$zpos,$name,$offi)
{   
}
// ----------------------------------------------------------------------------
// Spawns aus der Gebietsdatei lesen
// ----------------------------------------------------------------------------
function getSpawnsFromSvnFile()
{
    global $spawnfile, $tabSpawn;
    
    logHead("Ermitteln der Spawns");
    
    $hdlsvn = openInputFile($spawnfile);
    $cntnpc = 0;
    
    while (!feof($hdlsvn))
    {
        $line = rtrim(fgets($hdlsvn));
        
        if (stripos($line,"npc_id=") !== false)
        {
            $key = getKeyValue("npc_id",$line);
            
            $tabSpawn[$key] = $key;
            $cntnpc++;
        }
    }
    fclose($hdlsvn);
    
    logLine("Anzahl gefundener NPCs",$cntnpc);
}
// ----------------------------------------------------------------------------
// ausgeben der neuen Drop-Datei sowie der gelöschten Npc-Drop-Infos
// ----------------------------------------------------------------------------
function generDropFile()
{
    global $dropfile,$tabSpawn;
    
    $filenew = "../outputs/drop_output_check/".basename($dropfile);
    $filedel = "../outputs/drop_output_check/delete/".basename($dropfile);
    
    logHead("Pr&uuml;fen der Drops");
    logLine("Ausgabedatei Neu",$filenew);
    logLine("Ausgabedatei Delete",$filedel);
    
    $hdlsvn = openInputFile($dropfile);
    $hdlnew = openOutputFile($filenew);
    $dodel  = false;
    $lfnew  = "";
    $lfdel  = "";
    $cntles = 0;
    $cntnew = 0;
    $cntdel = 0;
    
    while (!feof($hdlsvn))
    {
        $line = rtrim(fgets($hdlsvn));
        $cntles++;
        
        if (stripos($line,"npc_id=") !== false)
        {
            $key = getKeyValue("npc_id",$line);
            
            if (isset($tabSpawn[$key]))
                $dodel = false;
            else
            {
                $dodel = true;
                logLine("- entferne Drops zu NpcId",$key);
            }
        }
        
        if ($dodel)
        {
            // muss die Datei noch geöffnet werden?
            if ($cntdel == 0)
                $hdldel = openOutputFile($filedel);
                
            fwrite($hdldel,$lfdel.$line);
            $cntdel++;
            $lfdel = "\n";
        }
        else
        {
            fwrite($hdlnew,$lfnew.$line);
            $cntnew++;
            $lfnew = "\n";
        }
        
        if (stripos($line,"</npc_drop>") !== false)
            $dodel = false;
    }
    
    fclose($hdlsvn);
    fclose($hdlnew);
    
    if ($cntdel > 0)
        fclose($hdldel);
    
    logLine("Zeilen eingelesen",$cntles);
    logLine("Zeilen &uuml;bernommen",$cntnew);
    logLine("Zeilen entfernt",$cntdel);
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------

$tabSpawn  = array();
$dropfile  = "";
$spawnfile = "";
$starttime = microtime(true);

echo '
   <tr>
     <td colspan=2>
       <center>
       <br><br>
       <input type="submit" name="submit" value="Drop-Check Starten">
       </center>
       <br>
     </td>
   </tr>
   <tr>
     <td colspan=2>';    

logStart();

if ($submit == "J")
{   
    if ($pathsvn == "")
    {
        logLine("ACHTUNG","die Pfade sind anzugeben");
    }
    else
    {
        logHead("Drop-Check erfolgt f&uuml;r Datei: $selfile");
        
        if (checkFiles())
        {
            logLine("Eingabedatei Drops",$dropfile);
            logLine("Eingabedatei Spawns",$spawnfile);
            
            getSpawnsFromSvnFile();  
            generDropFile();
        }
    }
}    
logStop($starttime,true);

echo '
      </td>
    </tr>
  </table>
</form>';
?>

</body>
</html>