<?PHP
// ----------------------------------------------------------------------------
// Modul  : inc_statics.php
// Version: 01.00, Mariella 01/2016
// Zweck  :  definiert einige Vorgaben für die STATIC-Spawns
// ----------------------------------------------------------------------------
                       
// relevante MapIds für die Statics   
$tabstaticmaps = array( "110010000" => "Sanctum",
                        "120010000" => "Pandaemonium",
                        "700010000" => "Oriel",
                        "710010000" => "Pernon"
                      );             
// relevante EntityClass-Angaben
$tabstaticclass = array(
                        "COOKING" => "Kochen",
                        "ARMOR_CRAFT" => "Ruestung",
                        "WEAPON_CRAFT" => "Waffen",
                        "HANDIWORK" => "Handwerk",
                        "ALCHEMY" => "Alchemie",
                        "TAILORING" => "Schneider",
                        "MENUISIER" => "Moebel"
                       );
// Zuordnung EntityClass_CraftObjectType zu ItemId                       
$tabstaticitems = array(
                        // normal (also ohne Type bzw. DEFAULT)
                        
                        "COOKING_DEFAULT"       => array("id" => "150000009", "name" => "Oven"),
                        "ARMOR_CRAFT_DEFAULT"   => array("id" => "150000010", "name" => "Armor Forge"),
                        "WEAPON_CRAFT_DEFAULT"  => array("id" => "150000011", "name" => "Weapon Forge"), 
                        "HANDIWORK_DEFAULT"     => array("id" => "150000012", "name" => "Workbench"),
                        "ALCHEMY_DEFAULT"       => array("id" => "150000013", "name" => "Alchemist Table"),
                        "TAILORING_DEFAULT"     => array("id" => "150000015", "name" => "Loom"),
                        "MENUISIER_DEFAULT"     => array("id" => "150000023", "name" => "Construction Bench"),
                        
                        // BOOST gem. CraftObjectType
                        
                        "COOKING_EXPBOOST"      => array("id" => "150000025", "name" => "Dresser of Concentration"),
                        "ARMOR_CRAFT_EXPBOOST"  => array("id" => "150000026", "name" => "Craft Table of Concentration"),
                        "WEAPON_CRAFT_EXPBOOST" => array("id" => "150000027", "name" => "Weapon Forge of Concentration"),
                        "HANDIWORK_EXPBOOST"    => array("id" => "150000028", "name" => "Handicrafting Shelf of Concentration"),
                        "ALCHEMY_EXPBOOST"      => array("id" => "150000029", "name" => "Alchemist Table of Concentration"),
                        "TAILORING_EXPBOOST"    => array("id" => "150000030", "name" => "Loom of Concentration"),
                        "MENUISIER_EXPBOOST"    => array("id" => "150000031", "name" => "Construction Bench of Concentration")
                       );
// ----------------------------------------------------------------------------
// prüfen, ob die MapId relevant ist
// ----------------------------------------------------------------------------
function checkIsStaticMap($mapid)
{
    global $tabstaticmaps;
            
    if (isset($tabstaticmaps[$mapid]))
    { 
        return true;
    }    
    else
    {
        return false;
    }
}
// ----------------------------------------------------------------------------
// prüfen, ob die EntityClass relevant ist
// ----------------------------------------------------------------------------
function checkIsStaticClass($class)
{
    global $tabstaticclass;
    
    $class = strtoupper($class);
    
    if (isset($tabstaticclass[$class]))
        return true;
    else
        return false;
}
// ----------------------------------------------------------------------------
// Item-Id ermitteln gem. EntityClass und CraftObjectType ("" = "DEFAULT")
// ----------------------------------------------------------------------------
function getStaticItemData($class,$type)
{
    global $tabstaticitems;
    
    if ($type == "") $type = "DEFAULT";
    
    $key         = strtoupper($class."_".$type);
    $ret         = array();
    $ret['id']   = "";
    $ret['name'] = "";
    
    if (isset($tabstaticitems[$key]))
    {
        $ret['id']   = $tabstaticitems[$key]['id'];
        $ret['name'] = $tabstaticitems[$key]['name'];
        return $ret;
    }
    else
        return $ret;
}
?>