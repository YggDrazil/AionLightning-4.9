<html>
<head>
  <title>
    DropGenerator - Drop-Definitionen zu einem NPC generieren
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script type="text/javascript">
  function GoAionDb()
  {
      var npcid  = document.edit.npcid.value;
      var aiondb = "http://aiondatabase.net/de/npc/" + npcid;
      
      document.edit.drops.value = "";
      
      window.open(aiondb,"winaiondb");
  }
  </script>
</head>

<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Hilfsfunktion - Drop-Definitionen generieren</div>
  <div class="hinweis" id="hinw">
    Bitte die notwendigen Informationen eintragen.
    <br><br>
    Bitte die <font color="orange">Seite des NPCs bei aiondatabase.net/en/npc/...id... anzeigen</font> lassen und dann bei der Drop-Auswahl auf 
    <font color='orange'>Anzeige 100</font> stellen, damit alle Dropssichtbar sind. Dann mit der Maus <font color='orange'>von der ersten ItemId 
    bis zum  Prozensatz des letzten Items</font> alles markieren und unten in die Textbox kopieren (STRG-C und dann die Textbox an klicken und STRG-V).
    <br> <br>
    Die Drop-Definitionen von aiondatabase.net <font color='orange'>d&uuml;rfen nicht ver&auml;ndert werden</font>! 
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte notwendige Informationen einf&uuml;gen</h1>
<form name="edit" method="GET" action="dropgen_adb.php">
 <br>
 <span style="color:cyan;font-size:16px;padding-right:15px;padding-left:15px;">NpcId</span>
 <input type="text" name="npcid" value="000000" style="width:60px;">
 <span style="color:cyan;font-size:16px;padding-right:15px;padding-left:15px;">Npc-Name</span>
 <input type="text" name="npctx" value="???" style="width:232px;">
 <span style="color:cyan;font-size:16px;padding-right:15px;padding-left:15px;">mit Kommentar Itemtext</span>
 <input type="checkbox" name="itext" value="Itemtext" checked style="padding-left:25px">
 <br><br><span style="color:cyan;font-size:18px">Drop-Definitionen (cut/paste von aiondatabase <font color="red">ohne Anpassung</font>)</span><br><br>
 <textarea name='drops' rows=10 cols=97></textarea>
 <br><br>
 <input style="width:120px" name="submit" type="submit">
 <input style="width:120px" name="reset" type="reset">
 <input type="button" name="aiondb" style="width:120px" value="AionDataBase.net" onclick="GoAionDb();">
</form>

<?PHP
include("../includes/inc_globals.php");

putIndexFoot();
?>

</body>
</html>