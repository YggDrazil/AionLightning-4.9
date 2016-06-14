<?php
// ----------------------------------------------------------------------------
// Script : formatPsSpawn.php
// Version: 1.00, Mariella, 11/2015
// Zweck  : erzeugt aus der vom PacketSamurai erstellten NPC-Spawn-Datei eine
//          Emu-gerechte Spawn-Definitions-Datei
// ----------------------------------------------------------------------------
include("../includes/inc_globals.php");          // allgemeine Prozeduren
 
$selfname = basename(__FILE__);
$infoname = "PS-Spawn-Definitionen umformatieren";

// ----------------------------------------------------------------------------
//                       F  U  N  K  T  I  O  N  E  N
// ----------------------------------------------------------------------------
// Spawns aus der neuen PS-Drop-Datei lesen und umformatieren
// ----------------------------------------------------------------------------
function formatPsSpawnFile()
{
    global $ifile;
    
    $fileout = "../outputs/check_output/".basename($ifile);    
    $lines   = file($ifile);
    $domax   = count($lines);
    $anzupd  = 0;
    $anzles  = 0;
    $anzout  = 0;
    $anzler  = 0;
    $anzign  = 0;
    /*
        <xs:attribute name="x" type="xs:float"/>
        <xs:attribute name="y" type="xs:float"/>
        <xs:attribute name="z" type="xs:float"/>
        <xs:attribute name="h" type="HeadingType" use="optional" default="0"/>
        <xs:attribute name="static_id" type="xs:int" use="optional" default="0"/>
        <xs:attribute name="random_walk" type="xs:int" use="optional" default="0"/>
        <xs:attribute name="walker_id" type="xs:string"/>
        <xs:attribute name="walker_index" type="xs:int" use="optional" default="0"/>
        <xs:attribute name="fly" type="xs:int" use="optional" default="0"/>
        <xs:attribute name="anchor" type="xs:string"/>
        <xs:attribute name="state" type="xs:int" use="optional" default="0"/>
    */
    $tabfields = array("x","y","z","h","static_id","random_walk","walker_id",
                       "walker_index","fly","anchor","state");
    $maxfields = count($tabfields);
    $tabvalues = array();
        
    logHead("Umformatieren PS-Spawn-Output");
    
    logSubHead("Scanne die neue Datei");
    logLine("Eingabedatei",$ifile);
    logLine("Anzahl Zeilen neue Datei",$domax);
        
    flush();
    
    $crlf   = "\n";
    $hdlout = openOutputFile($fileout);
    
    // in interne Tabelle übernehmen
    for ($l=0;$l<$domax;$l++)
    {
        $anzles++;
        $line = trim($lines[$l]);
        
        // Leerzeilen auslassen!
        if ($line != "")
        {
            if (stripos($line,"<spot ") !== false)
            {
                $tabvalues = array();
                
                // alle Werte gemäss Feld-Tabelle ermitteln
                for ($v=0;$v<$maxfields;$v++)
                {
                    if (stripos($line,$tabfields[$v]."=") !== false)
                        $tabvalues[$tabfields[$v]] = getKeyValue($tabfields[$v],$line);
                }
                
                // Versuch: fehlerhafte Zeilen eliminieren
                $cntval = 0;
                $cntnul = 0;
                
                while (list($key,$val) = each($tabvalues))
                {   
                    $cntval++;
                    if ($val == 0) $cntnul++;
                }
                
                if ($cntval != $cntnul)
                {
                    // neue Zeile aufbereiten
                    $line  = '            <spot';
                    
                    for ($v=0;$v<$maxfields;$v++)
                    {
                        if (isset($tabvalues[$tabfields[$v]]))
                            $line .= ' '.$tabfields[$v].'="'.$tabvalues[$tabfields[$v]].'"';
                    }
                    
                    $line .= '/>';
                    
                    $anzupd++;
                }
                else
                {
                    // alle Werte = 0 wird ignoriert
                    $line = "";
                    $anzign++;
                }
            }
            // Einrückungen prüfen!
            elseif (stripos($line,"<spawn_map ") !== false
            ||      stripos($line,"</spawn_map") !== false)
                $line = '    '.$line;
            elseif (stripos($line,"<spawn ")     !== false
            ||      stripos($line,"</spawn>")    !== false)
                $line = '        '.$line;            
            // letzte Zeile ohne Zeilenvorschub            
            elseif (stripos($line,"</spawns")   !== false)
                $crlf = "";
            
            if ($line != "")
            {            
                fwrite($hdlout,$line.$crlf);
                $anzout++;
            }
        }
        else
            $anzler++;
    }
    fclose($hdlout);
    
    if ($anzupd == 0)
    {
        unlink($fileout);
        logLine("Hinweis","offensichtlich wurde keine Spawn-Datei ausgew&auml;hlt, keine Formatierung!");
    }
    else
    {
        logLine("Anzahl Zeilen gelesen",$anzles,"(aus der PS-Spawn-Datei)");
        logLine("- davon umformatiert ",$anzupd,"(Zeile mit spot...)");
        logLine("- davon Leerzeilen ",$anzler,"(Leerzeilen ignoriert)");
        logLine("- davon Null-Zeilen",$anzign,"(alle Werte=0 wird ignoriert)");
        logSubHead("Ausgabe der umformartierten Datei");
        logLine("Ausgabedatei",$fileout);
        logLine("Anzahl Zeilen ausgegeben",$anzout);
    }
}
// ----------------------------------------------------------------------------
//
//                                 M  A  I  N
//
// ----------------------------------------------------------------------------
// Übergabe-Parameter (GET) aufbereiten
// ----------------------------------------------------------------------------
$ifile =  isset($_GET['ifile']) ? $_GET['ifile'] : "";
// ----------------------------------------------------------------------------
// globale Definitionen
// ----------------------------------------------------------------------------

putHtmlHead("$selfname - $infoname","PS-Spawn-Definitionen umformatieren");

// ----------------------------------------------------------------------------
// Start der Verarbeitung
// ----------------------------------------------------------------------------
logStart();

$starttime = microtime(true);

    
if ($ifile == "")
   echo "Ohne die notwendigen Vorgaben kann nichts generiert werden";
else
{           
    logHead("Vorgaben");
    logLine("Eingabedatei",$ifile);
    
    formatPsSpawnFile();
}
			
logSubHead("<br><br><br><center><a href='javascript:history.back()'>zur&uuml;ck</a></center>");

logStop($starttime,true);

echo '
      </td>
    </tr>
  </table>';
?>
</form>
</body>
</html>
