<html>
<head>
  <title>
    DropGenerator - Generieren Item-Template-PHP-Includes"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
    include("../includes/inc_globals.php");
    
    getConfData();
    
    $pslastpath = $pathsvn;
    /*
    // zuletzt gemachte Eingabe vorhanden / bereitstellen
    $pslastpath = "";
    $psgenlast  = "saved_data/generSvnPath.txt";
   
    if (file_exists($psgenlast))
    {
        $lines = file($psgenlast);
        
        if (isset($lines[0]))
            $pslastpath = $lines[0];
    }
    */
?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Hilfsfunktion - Generieren Item-Template-PHP-Includes</div>
  <div class="hinweis" id="hinw">
    Erzeugen PHP-Includes item_template_inc.php und item_dropgroup_inc.php (Dauer: ca. 40 Sekunden).
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte notwendige Informationen einf&uuml;gen</h1>
<form name="edit" method="GET" action="generItemIncludes.php">
 <br>
 <table width="100%">
   <tr>
     <td colspan=2>
       <center>
       <span style="font-size:14px;color:orange">Diese Generierung ist nur f&uuml;r eine neue Version der item_templates.xml-Datei im SVN notwendig<br><br></span>
       </center>
     </td>
   </tr>
   <tr>
     <td><span style="color:cyan;font-size:16px;">SVN-Root-Pfad</span></td>
     <td>
<?PHP
    echo '     
     <input type="text" id="idpath" name="pathsvn" value="'.$pslastpath.'" style="width:600px;">';
?>
   </tr>
 </table> 
 <br><br>
 
 <input style="width:120px" name="submit" type="submit">
 <input style="width:120px" name="reset" type="reset">
</form>
<?PHP
    putIndexFoot();
?>

</body>
</html>