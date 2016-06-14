<html>
<head>
  <title>
    PhpParser - Auswahl-Menue
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script type="text/javascript">
    function callPhpScript()
    {
        var php = document.edit.phpscript.value;
        
        if (php != "")
            document.location = php;
    }
  </script>
</head>

<body style="background-color:#000055;color:silver;padding:0px;"">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">PhpParser - Auswahl-Menue</div>
  <div class="hinweis" id="hinw">
    Bitte die gew&uuml;nschte Funktion ausw&auml;hlen
  </div>
  <div width=100%>
<h1 style="color:orange">Funktions-Auswahl</h1>
<form name="edit" method="GET" action="index.php">
 <br>
 <input type="submit" name="allesneu" value="Auto-Includes neu erstellen" style="width:220px;background-color:red;">
 <br><br><br><hr><br><br>
 <table width="100%">
   <tr>
     <td valign="top">
       <center>
       
       <a href="parseNpcs.php"     target="_self"><input type="button" value="Generieren NPC-Templates"  style="width:220px"></a><br><br>
       <a href="genSpawns.php"     target="_self"><input type="button" value="Generieren NPC-Spawns ..."  style="width:220px"></a><br><br>
       <a href="genTeleporter.php" target="_self"><input type="button" value="Generieren NPC-Teleporter" style="width:220px"></a><br><br>
       <a href="genGather.php"     target="_self"><input type="button" value="Generieren Gather-Spawns"  style="width:220px"></a>
       <br>
       </center>
     </td>
     <td valign="top">
       <center>
       
       <a href="genItem.php"     target="_self"><input type="button" value="Generieren Item-Dateien ..."   style="width:220px"></a><br><br>
       <a href="genQuest.php"    target="_self"><input type="button" value="Generieren Quest-Dateien ..."  style="width:220px"></a><br><br>
       <a href="genTribes.php"   target="_self"><input type="button" value="Generieren Tribe-Dateien ..."  style="width:220px"></a><br><br>
       <a href="genGoodlist.php" target="_self"><input type="button" value="Generieren Trade-Dateien ..."  style="width:220px"></a>
       </center>
     </td>
     <td valign="top">
       <center>
       <span style="font-size:18px;line-height:27px;color:cyan;">sonstige Datei-Generierungen</span><br><br>
       <select name="phpscript" onchange="callPhpScript();" style="width:220px">
<?PHP
    $tabPhp = array(
                array("","&gt; Bitte Datei ausw&auml;hlen &lt;"),
                array("#","------------------------------"),
                array("genAbyssRaceBonus.php","Abyss-Race-Bonus"),
                array("genCosmeticItems.php","Cosmetic-Items"),
                array("genGatherable.php","Gatherable-Templates"),
                array("genFlyPath.php","FlyPath"),
                array("genHotspotTeleporter.php","Hotspot-Teleporter"),
                array("genLoginEvents.php","Login-Events"),
                array("genPlayerTitles.php","Player-Titles"),
                array("genRide.php","Ride"),
                array("genRobot.php","Robot"),
                array("genWeatherTable.php","Weather-Table")
              );
    $maxPhp = count($tabPhp);

    for ($p=0;$p<$maxPhp;$p++)
    {
        $disable = $tabPhp[$p][0] == "#" ? " disabled" : "";
        
        echo "
         <option value='".$tabPhp[$p][0]."'".$disable.">".$tabPhp[$p][1]."</option>";
    }
?>
       </select> 
       </center>
     </td>
   </tr>
 </table>
</form>
<?PHP
    // prüfen der Ausgabeverzeichnisse
    include("../includes/inc_globals.php");
    include("includes/inc_inc_scan.php");
    
    // zentrale Prüfung aller Auto-Include-Dateien!
    $allesneu = isset($_GET['allesneu']) ? "J" : "N";
    
    getConfData();
    
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
    
    $tabouts = array( "../outputs",
                      "../outputs/parse_output",
                      "parse_input_utf8",
                      "parse_temp"
                    );
                    
    checkOutPathes($tabouts);   

    $starttime = microtime(true);
    logStart();
    checkAutoIncludeFiles();
    logStop($starttime,true);  
?>
</body>
</html>