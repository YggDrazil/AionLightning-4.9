<?PHP
// -----------------------------------------------------------------------------
// Modul   : inc_getautonameids.php
// Version : 1.01, Mareilla, 03/2016
// Zweck   : GET-Funktionen für die automatisch generierten Includes
// -----------------------------------------------------------------------------
// GET SEARCHKEY für ClientItem
// es wird versucht, einen Such-Begriff zu dem aktuellen ClientItem zu finden
// (zentral, da sowohl bei getClientItemId als auch bei getClientItemName
// notwendig)
// -----------------------------------------------------------------------------
function getClientKeyName($name)
{    
    global $tabItemInfos;
    
    $key = strtoupper($name);
    
    // ersetzen von GF-Schreibfehlern
    // _DECE_ wird zu _DECO_
    if (stripos($name,"_DECE_") !== false)
    {
        $name = str_replace("_DECE_","_DECO_",$name);
        $key = strtoupper($name);
    }
    
    // direkt
    if (isset($tabItemInfos[$key]))
        return $key;
        
    $key = "STR_".$key;
    if (isset($tabItemInfos[$key]))
        return $key;
        
    // ersetzen ITEM_... durch STR_...  
    $key = strtoupper($name);
    
    if (substr($key,0,5) == "ITEM_")
    {
        $key = "STR_".substr($key,5);
            
        if (isset($tabItemInfos[$key]))
            return $key;
    }  

    // eine evtl. vorhandene Nummerierung am Ende ersetzen
    if (substr($name,-2,2) == "04"
    ||  substr($name,-2,2) == "03"
    ||  substr($name,-2,2) == "02")
    {
        $name = strtoupper( substr($name,0,strlen($name) - 2)."01" );
        
        $key = getClientKeyName($name);
        
        if (isset($tabItemInfos[$key]))
            return $key;
    }
    
    // nichts gefunden, also $name in Grossbuchstaben zurückgeben
    return strtoupper($name);    
}
// -----------------------------------------------------------------------------
// GET ID zu ClientItemName
// -----------------------------------------------------------------------------
function getClientItemId($name)
{
    global $tabItemInfos;
    
    $key = getClientKeyName($name);
    
    if (isset($tabItemInfos[$key]))
        return $tabItemInfos[$key]['id'];
    else
        return "000000000";
}
// ----------------------------------------------------------------------------
// GET NAME zu ClientItemName
// ----------------------------------------------------------------------------
function getClientItemName($name)
{
    global $tabItemInfos;
    
    $key = getClientKeyName($name);
    
    if (isset($tabItemInfos[$key]))
        return $tabItemInfos[$key]['name'];
    else
        return "? ".$key;
}
// ----------------------------------------------------------------------------
// GET NAME zu ClientItemDesc
// ----------------------------------------------------------------------------
function getItemNameByDesc($desc)
{
    global $tabItemNames;
    
    $key = strtoupper($desc);
    
    if (isset($tabItemNames[$key]))
        return $tabItemNames[$key];
    else
        return $key;
}
// ----------------------------------------------------------------------------
// GET NAME zu ClientItemName
// ----------------------------------------------------------------------------
function getClientItemDesc($name)
{
    global $tabItemInfos;
    
    $key = getClientKeyName($name);
    
    if (isset($tabItemInfos[$key]))
        return $tabItemInfos[$key]['desc'];
    else
        return "? ".$key;
}
// -----------------------------------------------------------------------------
// GET ID zu DescName
// -----------------------------------------------------------------------------
function getDescNameId($name,$long)
{
    global $tabDescNames, $tabQuestNames;
    
    $key = strtoupper($name);
    
    // um ein Ergebnis herbeizuführen, werden hier mehrere Schritte für die
    // ID-Suche durchgefüührt!
    
    $ret = "";
    
    // direkt über DESC
    $ret = isset($tabDescNames[$key])   ? $tabDescNames[$key] : "";
    if ($ret != "") return $ret;
    
    // über den Desc-Long-Namen
    $key = strtoupper($long);
    $ret = isset($tabDescNames[$key])   ? $tabDescNames[$key] : "";
    if ($ret != "") return $ret;
    
    // über den Quest-Namen ( ID = ID * 2 + 1)
    $key = strtoupper($name);
    $ret = isset($tabQuestNames[$key])   ? ($tabQuestNames[$key] * 2) + 1 : "";
    if ($ret != "") return $ret;

    // ansonsten wird "0" zurückgegeben
    return "0";
}
// -----------------------------------------------------------------------------
// GET ID zu HouseDecoName
// -----------------------------------------------------------------------------
function getHouseDecoNameId($id)
{
    global $tabHouseDecoNames;
    
    $key = strtoupper($id);
    
    if (isset($tabHouseDecoNames[$key]))
        return $tabHouseDecoNames[$key];
    else
       return "";
}
// ----------------------------------------------------------------------------
// ermitteln Id zum Npc-Namen                                         
// ----------------------------------------------------------------------------
function getNpcNameId($name)
{
    global $tabNpcInfos;
        
    $name = strtoupper($name);
        
    if (isset($tabNpcInfos[$name]))
        return( $tabNpcInfos[$name]['nameid'] );
    else
        return $name;
}
// ----------------------------------------------------------------------------
// ermitteln Id zum Npc-Titel                                        
// ----------------------------------------------------------------------------
function getNpcTitleId($name)
{
    global $tabNpcTitles;
        
    $name = strtoupper($name);
        
    if (isset($tabNpcTitles[$name]))
        return( $tabNpcTitles[$name] );
    else
        return "";
}
// ----------------------------------------------------------------------------
// prüfen, ob der Name teilweise vorhanden ist (Table-Scan)
// ----------------------------------------------------------------------------
function getNpcPartKey($nameid)
{
    global $tabNpcInfos, $tabWorldmaps, $welt;
    
    $such = strtoupper($nameid);
        
    // vorne abschneiden bis Welt-Id
    $weltid = $tabWorldmaps[$welt]['offiname'];
    if (stripos($such,$weltid) !== false) $such = substr($such,stripos($such,$weltid));
        
    if (isset($tabNpcInfos[$such]))
    {
        return $tabNpcInfos[$such]['offiname'];
    }
    
    // hinten den letzten Part nach Unterstrich abschneiden
    $parts = explode("_",$such);
    $domax = count($parts) - 1;     // letzten abschneiden
    $trenn = "";
    $such  = "";
    
    for ($p=0;$p<$domax;$p++)
    {
        $such .= $trenn.$parts[$p];
        $trenn = "_";
    }
    
    if (isset($tabNpcInfos[$such]))
    {
        return $tabNpcInfos[$such]['offiname'];
    }
    
    return "";
}
// ----------------------------------------------------------------------------
// NpcId aus der internen Tabelle ermitteln
// ----------------------------------------------------------------------------
function getNpcIdNameTab($nameid)
{
    global $tabNpcInfos;
    
    $key = strtoupper($nameid);
    $ret = array();
    $ret['npcid'] = "000000";
    $ret['nname'] = "";   
    $ret['namid'] = "";
    
    if (isset($tabNpcInfos[$key]))
    {
        $ret['npcid'] = $tabNpcInfos[$key]['npc_id'];
        $ret['nname'] = $tabNpcInfos[$key]['name'];
        $ret['namid'] = $tabNpcInfos[$key]['nameid'];
                
        return $ret;
    }
    else
    {
        if (substr($key,0,4) == "NPC_" && substr($key,strlen($key)-3,3) == "_SP")
        {
            $key = substr($key,4,stripos($key,"_SP") - 4);
            
            if (isset($tabNpcInfos[$key]))
            {
                $ret['npcid'] = $tabNpcInfos[$key]['npc_id'];
                $ret['nname'] = $tabNpcInfos[$key]['name'];
                $ret['namid'] = $tabNpcInfos[$key]['nameid'];
                
                return $ret;
            }
        }
    }
    
    // erweiterte Suche starten
    $key = getNpcPartKey($nameid);
    
    if (isset($tabNpcInfos[$key]))
    {
        $ret['npcid'] = $tabNpcInfos[$key]['npc_id'];
        $ret['nname'] = $tabNpcInfos[$key]['name'];
        $ret['namid'] = $tabNpcInfos[$key]['nameid'];
                
        return $ret;
    }
    else
        return $ret;
}
// -----------------------------------------------------------------------------
// GET ID zu HouseObjectName
// -----------------------------------------------------------------------------
function getHouseObjectNameId($id)
{
    global $tabHouseObjectNames;
    
    $key = strtoupper($id);
    
    if (isset($tabHouseObjectNames[$key]))
        return $tabHouseObjectNames[$key];
    else
       return "";
}
// -----------------------------------------------------------------------------
// GET ID zu PolishSetName
// -----------------------------------------------------------------------------
function getPolishNameId($id)
{
    global $tabPolishNames;
    
    $key = strtoupper($id);
    
    if (isset($tabPolishNames[$key]))
        return $tabPolishNames[$key];
    else
       return "";
}
// -----------------------------------------------------------------------------
// GET ID zu RecipeName
// -----------------------------------------------------------------------------
function getRecipeNameId($name)
{
    global $tabRecipeNames;
    
    $key = strtoupper($name);
    
    if (isset($tabRecipeNames[$key]))
        return $tabRecipeNames[$key];
    else
       return "";
}
// -----------------------------------------------------------------------------
// GET ID zu RideName
// -----------------------------------------------------------------------------
function getRideNameId($name)
{
    global $tabRideNames;
    
    $key = strtoupper($name);
    
    if (isset($tabRideNames[$key]))
        return $tabRideNames[$key];
    else
       return "";
}
// -----------------------------------------------------------------------------
// GET ID zu RandomOptionName
// -----------------------------------------------------------------------------
function getRndOptionNameId($name)
{
    global $tabRndOptionNames;
    
    $key = strtoupper($name);
    
    if (isset($tabRndOptionNames[$key]))
        return $tabRndOptionNames[$key];
    else
       return "";
}
// -----------------------------------------------------------------------------
// GET ID zu RobotName
// -----------------------------------------------------------------------------
function getRobotNameId($name)
{
    global $tabRobotNames;
    
    $key = strtoupper($name);
    
    if (isset($tabRobotNames[$key]))
        return $tabRobotNames[$key];
    else
       return "";
}
// -----------------------------------------------------------------------------
// GET ID zu SkillName
// -----------------------------------------------------------------------------
function getSkillNameId($name)
{
    global $tabSkillNames;
    
    $key = strtoupper($name);
    
    if (isset($tabSkillNames[$key]))
        return $tabSkillNames[$key];
    else
        return getSkillReplaceNameId($key);
}
// -----------------------------------------------------------------------------
// GET ID zu SkillReplaceName (wird automatisch aufgerufen, wenn die Funktion
//                             getSkillNameId kein Ergebnis liefern konnte)
// -----------------------------------------------------------------------------
function getSkillReplaceNameId($name)
{
    global $tabSkillReplaceNames;
    
    $key = strtoupper($name);
    
    if (isset($tabSkillReplaceNames[$key]))
        return $tabSkillReplaceNames[$key];
    else
        return $key;
}
// -----------------------------------------------------------------------------
// GET ID zu ToyPet
// -----------------------------------------------------------------------------
function getToypetNameId($name)
{
    global $tabToypetNames;
    
    $key = strtoupper($name);
    
    if (isset($tabToypetNames[$key]))
        return $tabToypetNames[$key];
    else
        return "";
}
// -----------------------------------------------------------------------------
// Get ID zu WorldName
// -----------------------------------------------------------------------------
function getWorldNameId($name)
{
    global $tabWorldNames;
    
    $key = strtoupper($name);
    
    if (isset($tabWorldNames[$key]))
        return $tabWorldNames[$key];
    else
    {
        return "";
    }
}