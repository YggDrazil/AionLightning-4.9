<html>
<head>
  <title>
    DropGenerator - Auswahl-Menue
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
</head>

<body style="background-color:#000055;color:silver;padding:0px;"">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">DROP-Generator - Auswahl-Menue</div>
  <div class="hinweis" id="hinw">
    Bitte die gew&uuml;nschte Funktion ausw&auml;hlen
  </div>
  <div width=100%>
<h1 style="color:orange">Funktions-Auswahl</h1>
<form name="edit" method="GET" action="index.php">
 <table width="75%">
   <tr>
     <th colspan=2><br>
       <font color="orange" size="+1">
         Generieren der Drop-Dateien aus verschiedenen Eingabequellen<br><br>
       </font>  
     </th></tr>
   <tr>
     <th valign="top"><font color="cyan">von AionDataBase</font></th>
     <th valign="top"><font color="cyan">von PacketSamurai</font></th>
   </tr>
   <tr><th colspan=2>&nbsp;</th></tr>
   <tr>
     <th valign="top">
       <a href="index_aiondb.php" target="_self"><input type="button" value="Scan f&uuml;r NPC von AionDB" style="width:220px"></a><br><br>
       <a href="index_adblog.php" target="_self"><input type="button" value="Formatieren AionDB-Log-File" style="width:220px"></a>
     </th>
     <th valign="top">
       <a href="index_ps.php" target="_self"><input type="button" value="Formatieren PS-Drop-File" style="width:220px"></a>
     </th>
   </tr> 
   <tr>
   <th colspan=2>
     <font color="orange" size="+1">
     <br><br>
       Generieren von PHP-Include-Dateien und Testen der Includes<br><br>
     </font>  
   </th></tr>
   <tr>
     <th valign="top"><font color="cyan"">generieren ItemTemplate-Include</font></th>
     <th valign="top"><font color="cyan"">generieren DropTemplate-Include</font></th>
   </tr>
   <tr><th colspan=2>&nbsp;</th></tr>
   <tr>
     <th valign="top">
       <a href="index_genitm_tmpl.php" target="_self"><input type="button" value="Gener Item-Template-PHP-Include" style="width:220px"></a><br><br>
     </th>
     <th valign="top">
       <a href="index_gen_drop.php" target="_self"><input type="button" value="Gener Drop-Template-PHP-Include" style="width:220px"></a><br><br>
     </th>
   </tr>
   <tr>
     <th valign="top" colspan="2">
       <a href="index_genitm_test.php" target="_self"><input type="button" value="Testen/Anzeigen der Informationen" style="width:220px;background-color:dodgerblue"></a>
     </th>
   </tr>
 </table>  
</form>

<?PHP
    // prüfen der Ausgabeverzeichnisse
    include("../includes/inc_globals.php");
    
    $tabouts = array( "../outputs/drop_output_ps",
                      "../outputs/drop_output_adb",
                      "../outputs/drop_output_gener",
                      "data_backups",
                      "saved_data"
                    );
    checkOutPathes($tabouts);
    
    putIndexFoot();
?>

</body>
</html>