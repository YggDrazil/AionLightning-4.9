<html>
<head>
  <title>
    Php-Gener-Tools - Auswahl-Menue
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
</head>

<body style="background-color:#000055;color:silver;padding:0px;"">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Php-Generator-Tools - Auswahl-Menue</div>
  <div class="hinweis" id="hinw">
    Bitte die gew&uuml;nschte Funktion ausw&auml;hlen
  </div>
  <div width=100%>
<h1 style="color:orange">Funktions-Auswahl</h1>
<form name="edit" method="GET" action="index.php">
 <br><br>
 <a href="index_dropgen.php"  target="_self"><input type="button" value="Drop-Generator"  style="width:220px;"></a><br><br><br>
 <a href="index_dropcheck.php"  target="_self"><input type="button" value="Check Drops/nicht gespawnte NPC"  style="width:220px;"></a>
 <br><br>
</form>

<?PHP
include("../includes/inc_globals.php");

putIndexFoot();
?>

</body>
</html>