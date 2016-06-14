<html>
<head>
  <title>
    DropGenerator - Generieren Drop-Template-PHP-Include"
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script> <script type="text/javascript">
    // XML-Dateien im angegebenen Pfad ermitteln  
    function getAjaxFileList()
    {            
        $.get('../includes/ajaxFileList.php?type=.xml&path='+$("#idpath").val(),function(data) {
            $("#idfile").html(data);
        });
    }
    
    // Dateiliste aktualiseren, wenn Seite neu geladen wurde
    $(document).ready( function() {  
        getAjaxFileList();
    })
    
    // Dateiliste aktualiseren, wenn auf den Button geklickt wurde
    $(function() {
        $("#filelist").click(function(e) {
            e.preventDefault();
            getAjaxFileList();
        });
    })       
    
    // Dateiliste aktualiseren, wenn der Pfad geändert wurde
    $(function() {
        $("#idpath").change(function(e) {
            e.preventDefault();
            getAjaxFileList();
        });
    })    
  </script>
</head>
<?PHP
    // zuletzt gemachte Eingabe vorhanden / bereitstellen
    $pslastpath = "";
    $psgenlast  = "saved_data/generSvnPath.txt";
   
    if (file_exists($psgenlast))
    {
        $lines = file($psgenlast);
        
        if (isset($lines[0]))
            $pslastpath = str_replace("\\\\","\\",$lines[0]."\\trunk\\Todo\\Drops_Templates");
    }
?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Hilfsfunktion - Generieren Drop-Template-PHP-Includes</div>
  <div class="hinweis" id="hinw">
    Erzeugen PHP-Include aus einer Drop-Template-Datei (Dauer: ca. 1 Sekunde).
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte notwendige Informationen einf&uuml;gen</h1>
<form name="edit" method="GET" action="generDropInclude.php">
 <br>
 <table width="100%">
   <tr>
     <td colspan=2>
       <center>
       <span style="font-size:16px;color:silver">Bitte das Verzeichnis zur Drop-Template-Datei angeben<br><br></span>
       </center>
     </td>
   </tr>
   <tr>
     <td><span style="color:cyan;font-size:16px;">Drop-Template-Pfad</span></td>
     <td>
<?PHP
    echo '     
     <input type="text" id="idpath" name="pathsvn" value="'.$pslastpath.'" style="width:600px;">';
?>
   </tr>
   <tr><td colspan=2>&nbsp;</td></tr>
   <tr>
     <td><span style="color:cyan;font-size:16px;">Drop-Template-Datei</span></td>
     <td><select name="ifile" id="idfile" style="width:350px;"><option>bitte mittels Dateiliste-Button abrufen</option></select></td>
   </tr>
 </table> 
 <br><br>
 
 <input style="width:120px" name="submit" type="submit">
 <input style="width:120px" name="reset" type="reset">
</form>
<?PHP
include("../includes/inc_globals.php");

putIndexFoot();
?>
</body>
</html>