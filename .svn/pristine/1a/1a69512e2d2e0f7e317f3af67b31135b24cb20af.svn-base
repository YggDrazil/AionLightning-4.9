<?php
// ----------------------------------------------------------------------------
// Script : formatPsProtocol.php
// Version: 1.00, Mariella, 04/2016
// Zweck  : sortiert die Packet-Einträge in der PS-Protocol-Datei getrennt
//          nach SM und CM aufsteigend gem. dem Hex-Code
// ----------------------------------------------------------------------------
include("../includes/inc_globals.php");          // allgemeine Prozeduren
 
$selfname = basename(__FILE__);
$infoname = "PS-Protocol-Definitionen umformatieren";

// ----------------------------------------------------------------------------
//                       F  U  N  K  T  I  O  N  E  N
// ----------------------------------------------------------------------------
// Sortierwert
// PS-Protocol-Datei einlesen und umsortieren
// ----------------------------------------------------------------------------
function formatPsProtocolFile()
{
    global $ifile;
    
    $fileout = "../outputs/check_output/".basename($ifile);    
    $lines   = file($ifile);
    $domax   = count($lines);
    $cntles  = 0;
    $cntout  = 0;
    
    $tabProt = array();
    $protFam = "";
    $aktPack = "";
    $sortid  = 0;
    $smVon   = 0;
    $smBis   = 0;
    $cmVon   = 0;
    $cmBis   = 0;
    $crlf    = "\n";
     
    $hdlprt  = openInputFile($ifile);

    if (!$hdlprt)
    {
        logLine("Fehler openInputFile",$ifile);
        return;
    }
    
    logHead("Umformatieren PS-Protocol-Datei"); 
    logSubHead("Einlesen der PS-Protocol-Datei");    
    logLine("Eingabedatei",$ifile);
        
    flush();
    
    // in interne Tabelle übernehmen
    while (!feof($hdlprt))
    {
        $cntles++;
        $line = rtrim(fgets($hdlprt));
        
        if     (stripos($line,"<packetfamilly")  !== false)
        {
            $aktPack = "0x000";
            
            if     (stripos($line,'way="Server') !== false) 
            {
                $protFam = "SM";
                $smVon   = $cntles;
                $sortid++;
            }
            elseif (stripos($line,'way="Client') !== false)
            {
                $protFam = "CM";
                $cmVon   = $cntles;
                $sortid++;
            }
        }
        elseif (stripos($line,"</packetfamilly>") !== false)
        {
            if     ($protFam == "SM") $smBis = $cntles;
            elseif ($protFam == "CM") $cmBis = $cntles;
            
            $sortid++;
            $protFam = "";
            $aktPack = "0xFFFFFF";
        }
        elseif (stripos($line,"<packet")   !== false && stripos($line," id=") !== false)
        {
            // Hex-Schreibweise einheitlich in Grossbuchstaben!
            $oldPack = getKeyValue("id",$line);        
            $aktPack = strtoupper($oldPack);
            $aktPack = str_replace("0X","0x",$aktPack);
            $line    = str_replace($oldPack,$aktPack,$line);
        }
        
        $tabProt[$cntles]['sort'] = $sortid."~~~".getSortNumValue($cntles); 
        $tabProt[$cntles]['prot'] = $sortid;
        $tabProt[$cntles]['pack'] = $aktPack;        
        $tabProt[$cntles]['line'] = $line;
       
        if (stripos($line,"</packet>") !== false 
        || (stripos($line,"<packet")   !== false && stripos($line," id=") !== false && stripos($line,"/>") !== false))
            $aktPack = "";    
    }
    fclose($hdlprt);
    
    logLine("Anzahl Zeilen gelesen",$cntles);
    
    // die PacketIds in den Sortierbegriff übernehmen
    $aktPack = "";
    
    for ($i=$cntles;$i>0;$i--)
    {
        if ($tabProt[$i]['pack'] !== "")
        {
            $aktPack = getSortNumValue(hexdec($tabProt[$i]['pack']));
            
            // offene Kommentare hinzunehmen
            for ($o=$i+1;$o<$cntles;$o++)
            {
                $such = trim($tabProt[$o]['line']);
                
                switch ( $such )
                {
                /*
                    case ""   : 
                        $tabProt[$o]['sort'] = $tabProt[$o]['prot']."_".$aktPack."_".getSortNumValue($o);
                        break;
                        */
                    case "-->":
                        $tabProt[$o]['sort'] = $tabProt[$o]['prot']."_".$aktPack."_".getSortNumValue($o);
                        $o = $cntles;
                        break;
                    default   : 
                        $o = $cntles;
                        break;
                }
            }
        }
        else
            $tabProt[$i]['pack'] = $aktPack;
            
        $tabProt[$i]['sort'] = str_replace("~~~","_".$aktPack."_",$tabProt[$i]['sort']);   
    }
    
    sort($tabProt);
    
    $hdlout = openOutputFile($fileout);
    $endprt = false;
    
    logSubHead("Ausgabe der neu formatierten PS-Protocol-Datei");
    logLine("Ausgabedatei",$fileout);
    
    for ($i=0;$i<$cntles;$i++)
    {
        if (stripos($tabProt[$i]['line'],"</protocol>") !== false)
        {
            fwrite($hdlout,$tabProt[$i]['line']);
            $cntout++;
            $endprt = true;
        }
        else
        
        if (!$endprt  || ($endprt && trim($tabProt[$i]['line']) !== ""))
        {
            fwrite($hdlout,$tabProt[$i]['line'].$crlf);
            $cntout++;
        }
    }
    fclose($hdlout);

    logLine("Anzahl Zeilen ausgegeben",$cntout);
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

putHtmlHead("$selfname - $infoname","PS-Protocol-Definitionen umformatieren");

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
    
    formatPsProtocolFile();
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
