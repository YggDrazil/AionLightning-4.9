<html>
<head>
  <title>
    CheckTools - Hilfsfunktion: PS-Protocol-Definitionen formatieren
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
        $.get('../includes/ajaxFileList.php?type=.xml&name=game&path='+$("#idpath").val(),function(data) {
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
    
    getConfData();
    
    // Ausgabepfad vorhanden?
    if (!file_exists("../outputs/check_output"))
        mkdir("../outputs/check_output");
        
    // zuletzt gemachte Eingaben vorhanden / bereitstellen
    $pslastpath = str_replace("\\data\client_strings","\\protocols",$pathstring);
?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Hilfsfunktion - PS-Protocol-Definitionen umformatieren</div>
  <div class="hinweis" id="hinw">
    Umformatieren eines PacketSamurai Protocol-Files.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte notwendige Informationen einf&uuml;gen</h1>
<form name="edit" method="GET" action="formatPsProtocol.php">
 <br>
 <table width="100%">
   <tr>
     <td><span style="color:cyan;font-size:16px;">Pfad-Auswahl</span></td>
     <td>
       <select id="iselpath" name="selpath" style="width:580px" onchange="setPsPath();">
<?PHP
    // wenn ein Pfad vorhanden ist, dann eine Pfadauswahl zum Parentpath erzeugen
    /*
    if ($pslastpath != "")
    {
        $slash    = "\\";
        $suchpfad = "";
        
        if (stripos($pslastpath,"\\") !== false)
            $suchpfad = substr($pslastpath,0,strripos($pslastpath,"\\"));
        else
        {
            $suchpfad = substr($pslastpath,0,strripos($pslastpath,"/"));
            $slash    = "/";
        }
        
        if (file_exists($suchpfad))
        {
            $pathes = scandir($suchpfad);
            
            for ($i=0;$i<count($pathes);$i++)
            {
                $selpath = str_replace($slash.$slash,$slash,$suchpfad.$slash.$pathes[$i]);
                
                if ($pathes[$i] != "."  && $pathes[$i] != "..")
                    if( !is_file($selpath) )
                        echo '<option value="'.$selpath.'">'.$selpath.'</option>';
            }
        }
    }
    */
?>
       </select>
     </td>
   </tr>
   <tr><td colspan=2>&nbsp;</td></tr>
   <tr><td colspan=2><hr></td></tr>
   <tr><td colspan=2>&nbsp;</td></tr>
   <tr>
     <td><span style="color:cyan;font-size:16px;">PS-Protocol-Pfad</span></td>
     <td>
<?PHP
    echo '     
     <input type="text" id="idpath" name="ipath" value="'.$pslastpath.'" style="width:580px;">';
?>
         <button id="filelist">Dateiliste</button></td>
   </tr>
   <tr><td colspan=2>&nbsp;</td></tr>
   <tr>
     <td><span style="color:cyan;font-size:16px;">PS-Protocol-Datei</span></td>
     <td><select name="ifile" id="idfile" style="width:350px;"><option>bitte mittels Dateiliste-Button abrufen</option></select></td>
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