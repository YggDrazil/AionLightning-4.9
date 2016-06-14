<html>
<head>
  <title>
    PHP-Checker-Tools - Check PS-Gather
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
  <script type="text/javascript">
    // Pfad-Auswahl übernehmen
    function setPsPath()
    {   
        $("#idpath").val( $("#iselpath").val() );
        getAjaxFileList();
    }
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
    include("../includes/inc_globals.php");
    
    $taboutpath = array("check_temp","saved_data","..\\outputs\\check_output");
    checkOutPathes($taboutpath);
    
    // zuletzt gemachte Eingaben vorhanden / bereitstellen
    $pslastpath = "";
    $pssavefile = "saved_data/lastcheckgather.txt";
   
    if (file_exists($pssavefile))
    {
        $lines = file($pssavefile);
        
        $pslastpath = getParentPath($lines[0]);
    }
?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Checken PS-Gather-File gegen bestehendes SVN-Gather-File</div>
  <div class="hinweis" id="hinw">
    Checken eines PS-Gather-Files gegen ein bestehendes SVN-Gather-File.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte notwendige Informationen einf&uuml;gen</h1>
<form name="edit" method="GET" action="checkGather.php">
 <br>
 <table width="100%">
   <tr>
     <td><span style="color:cyan;font-size:16px;">Pfad-Auswahl</span></td>
     <td>
       <select id="iselpath" name="selpath" style="width:600px" onchange="setPsPath();">
<?PHP
    // wenn ein Pfad vorhanden ist, dann eine Pfadauswahl zum Parentpath erzeugen
    if ($pslastpath != "")
    {
        $suchpfad = getParentPath($pslastpath);
                
        if (file_exists($suchpfad))
        {
            $pathes = scandir($suchpfad);
            
            for ($i=0;$i<count($pathes);$i++)
            {
                $selpath = str_replace("\\\\","\\",formFileName($suchpfad."\\".$pathes[$i]));
                
                if ($pathes[$i] != "."  && $pathes[$i] != "..")
                    if( !is_file($selpath) )
                        echo '<option value="'.$selpath.'">'.$selpath.'</option>';
            }
        }
    }
?>
       </select>
     </td>
   </tr>
   <tr><td colspan=2>&nbsp;</td></tr>
   <tr><td colspan=2><hr></td></tr>
   <tr><td colspan=2>&nbsp;</td></tr>
   <tr>
     <td><span style="color:cyan;font-size:16px;">PS-Gather-Pfad</span></td>
     <td>
<?PHP
    echo '     
     <input type="text" id="idpath" name="ipath" value="'.$pslastpath.'" style="width:600px;">';
?>
         <button id="filelist">Dateiliste</button></td>
   </tr>
   <tr><td colspan=2>&nbsp;</td></tr>
   <tr>
     <td><span style="color:cyan;font-size:16px;">PS-Gather-Datei</span></td>
     <td><select name="ifile" id="idfile" style="width:350px;"><option>bitte mittels Dateiliste-Button abrufen</option></select></td>
   </tr>
 </table> 
 <br>
 <input style="width:120px" name="submit" type="submit">
 <input style="width:120px" name="reset" type="reset">
</form>

<?PHP
    putIndexFoot();
?>

</body>
</html>