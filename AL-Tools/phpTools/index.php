<html>
<head>
  <title>
    PhpParser - Auswahl-Menue
  </title>
  <link rel='stylesheet' type='text/css' href='includes/aioneutools.css'>
</head>

<body style="background-color:#000055;color:silver;padding:0px;"">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">PhpTools - Auswahl-Menue</div>
  <div class="hinweis" id="hinw">
    Bitte die gew&uuml;nschte Funktion ausw&auml;hlen
  </div>
  <div width=100%>
<h1 style="color:orange">Funktions-Auswahl</h1>
<form name="edit" method="GET" action="index.php">
 <br><br>
 <a href="phpCheck/index.php"  target="_self"><input type="button" value="PHP-Checker-Tools"  style="width:220px;font-size:18px;"></a><br><br><br>
 <a href="phpGener/index.php"  target="_self"><input type="button" value="PHP-Generator-Tools"  style="width:220px;font-size:18px;"></a><br><br><br>
 <a href="phpParse/index.php"  target="_self"><input type="button" value="PHP-Parser-Tools"  style="width:220px;font-size:18px;"></a><br><br>
</form>
<?PHP
include("includes/inc_globals.php");

    if (!file_exists("config"))
        mkdir("config");
        
    if (!file_exists("config/path_config.txt"))
    {
        copy("includes/path_config.txt","config/path_config.txt");
        
        echo "<h1>BITTE ERST DIE DATEI config/path_config.txt ANPASSEN</h1>";
    }
    
    // alle Ausgaben erfolgen zentral ins Verzeichnis /outputs                
    if (!file_exists("outputs"))
        mkdir("outputs");
    
    putIndexFoot();    
?>
</body>
</html>