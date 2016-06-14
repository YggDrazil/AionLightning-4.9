<?PHP
// ----------------------------------------------------------------------------
// Modul  : inc_itemtmplparse.php                                 ITEM_TEMPLATE
// Version: 01.00, Mariella 02/2016
// Zweck  : definiert Variablen/Funktionen für die Item-Template-Generierung
// ----------------------------------------------------------------------------  

$tabTpls = array();

// ----------------------------------------------------------------------------
//
//                  E R M I T T L U N G S - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Ermitteln Wert für: item_mask
// ----------------------------------------------------------------------------
function getItemMask($key)
{
    global $tabTpls;
    
    //                  0=set 1=Mask 2=XML-Tag 3=Musswert
    $tabMasks = array(
                  array(true ,     1,"lore","true"),
                  array(true ,     2,"can_exchange","true"),
                  array(true ,     4,"can_sell_to_npc","true"),
                  array(true ,     8,"can_deposit_to_character_warehouse","true"),
                  array(true ,    16,"can_deposit_to_account_warehouse","true"),
                  array(true ,    32,"can_deposit_to_guild_warehouse","true"),
                  array(true ,    64,"breakable","true"),
                  array(true ,   128,"soul_bind","true"),
                  array(true ,   256,"remove_when_logout","true"),
                  array(true ,   512,"no_enchant","true"),
                  array(true ,  1024,"can_proc_enchant","true"),
                  array(true ,  2048,"can_composite_weapon","true"),
                  array(false,  4096,"cannot_changeskin",""),
                  array(true ,  8192,"can_split","true"),
                  array(true , 16384,"item_drop_permitted","true"),
                  array(true , 32768,"can_dye",""),
                  array(true , 65536,"can_ap_extraction","true"),
                  array(true ,131072,"can_polish","true")
                     );
    $maxMasks = count($tabMasks);
    $ret      = 0;
    
    $cISSET   = 0;
    $cMASK    = 1;
    $cXML     = 2;
    $cVALUE   = 3;
    
    for ($m=0;$m<$maxMasks;$m++)
    {
        // XML-Tag vorhanden?
        if (isset($tabTpls[$key][$tabMasks[$m][$cXML]]))
        {
            // Soll XML-Tag vorhanden sein?
            if ($tabMasks[$m][$cISSET] == true)
            {
                // muss ein bestimmter Wert vorhanden sein?
                if ($tabMasks[$m][$cVALUE] != "")
                {
                    if (strtolower($tabTpls[$key][$tabMasks[$m][$cXML]]) == $tabMasks[$m][$cVALUE])
                        $ret += $tabMasks[$m][$cMASK];
                }
                else
                {
                    // can_dye darf nicht "","0" sein
                    if ($tabMasks[$m][$cXML] == "can_dye")
                    {
                        if ($tabTpls[$key]['can_dye'] != "" && $tabTpls[$key]['can_dye'] != "0")
                            $ret += $tabMasks[$m][$cMASK];
                    }
                    else
                        $ret += $tabMasks[$m][$cMASK];
                }
            }
            else
                // gesetzt, aber Wert = false, 0 bzw. leer (ist wie nicht gesetzt)
                if ($tabTpls[$key][$tabMasks[$m][$cXML]] == ""
                ||  $tabTpls[$key][$tabMasks[$m][$cXML]] == "0"
                ||  strtoupper($tabTpls[$key][$tabMasks[$m][$cXML]]) == "FALSE")
                    $ret += $tabMasks[$m][$cMASK];
        }
        else
            // Soll XML-Tagauch nicht gesetzt sein?
            if ($tabMasks[$m][$cISSET] == false)
                $ret += $tabMasks[$m][$cMASK];
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: category
// ----------------------------------------------------------------------------
function getCategory($key)
{
    global $tabTpls;
    
    $tabCash = array("","pirate_","ninja_","gold_","sf_","lovelyhero_");
    $maxCash = count($tabCash);
    $tabPros = array("","nct_","ncj_","inn_","gf_","chn_");
    $maxPros = count($tabPros);
    $tabEvnt = array("","valen_","white_","devasday_");
    $maxEvnt = count($tabEvnt);
    
    $cCASH = "~cash~";
    $cPROS = "~pros~";
    $cEVNT = "~evnt~";
    
    // die Voreinstufung ergibt eine Zeit-Optimierung von ca. 28 % (ca. 40 secs)
    // ACHTUNG: grobe Voreinstufung, um die Suche zu beschleunigen!
    $tabCKey  = array(
    //                   Teilstring   Gruppe
                  array( "_stigma"   ,"STIGMA"    ),
                  array( "_sword"    ,"SWORD"     ),
                  array( "_mace"     ,"MACE"      ),
                  array( "_dagger"   ,"DAGGER"    ),
                  array( "_orb"      ,"ORB"       ),
                  array( "_2hsword"  ,"GREATSWORD"),
                  array( "_book"     ,"SPELLBOOK" ),
                  array( "_skillbook","SKILLBOOK" ),
                  array( "_polearm"  ,"POLEARM"   ),
                  array( "_staff"    ,"STAFF"     ),
                  array( "_bow"      ,"BOW"       ),
                  array( "_shield"   ,"SHIELD"    ),
                  array( "_harp"     ,"HARP"      ),
                  array( "_gun"      ,"GUN"       ),
                  array( "_cannon"   ,"CANNON"    ),
                  array( "_keyblade" ,"KEYBLADE"  ),
                  array( "_earring"  ,"EARRINGS"  ),
                  array( "_key"      ,"KEY"       ),
                  array( "_coin"     ,"COINS"     ),
                  array( "_badge"    ,"MEDALS"    )
                     );
    $maxCKey = count($tabCKey);
        
    // ACHTUNG: wenn die Platzhalter im Namen enthalten sind, dann werden diese
    //          aus den o.a. Tabellen ersetzt und damit gesucht! In diesem Fall
    //          ist auf die korrekte Vorgabe der Unterstriche zu achten !!!!!!!
    $tabCateg = array(
    //            Gruppe                 Teilstring        Category
                  "SWORD" => array( 
                                  array("icon_item_sword_","SWORD"), 
                                  array("icon_item_star_sword_","SWORD"),
                                  array("icon_cash_item_~cash~sword_","SWORD"),     
                                  array("icon_event_item_~evnt~sword_","SWORD")
                                  ),
                  "MACE" => array (                                 
                                  array( "icon_item_mace_","MACE"),
                                  array( "icon_item_star_mace_","MACE"),
                                  array( "icon_cash_item_~cash~mace_","MACE"),      
                                  array( "icon_event_item_~evnt~mace_","MACE")   
                                  ),
                  "DAGGER" => array(                                  
                                  array( "icon_item_dagger_","DAGGER"),
                                  array( "icon_item_star_dagger_","DAGGER"),
                                  array( "icon_cash_item_~cash~dagger_","DAGGER"),   
                                  array( "icon_event_item_~evnt~dagger_","DAGGER")
                                   ),
                  "ORB" => array(                                   
                                  array( "icon_item_orb_","ORB"),  
                                  array( "icon_item_star_orb_","ORB"),
                                  array( "icon_cash_item_~cash~orb_","ORB"),    
                                  array( "icon_event_item_~evnt~orb_","ORB")
                                   ),
                  "GREATSWORD" => array(                                   
                                  array( "icon_item_2hsword_","GREATSWORD"),
                                  array( "icon_item_star_2hsword_","GREATSWORD"),
                                  array( "icon_cash_item_~cash~2hsword_","GREATSWORD"),    
                                  array( "icon_event_item_~evnt~2hsword_","GREATSWORD")
                                   ),
                  "SPELLBOOK" => array(                                   
                                  array( "icon_item_book_","SPELLBOOK"), 
                                  array( "icon_item_star_book_","SPELLBOOK"),
                                  array( "icon_cash_item_~cash~book_","SPELLBOOK"),    
                                  array( "icon_event_item_~evnt~book_","SPELLBOOK")
                                   ),
                  "SKILLBOOK" => array(                                      
                                  array( "icon_item_skillbook_","SKILLBOOK"),
                                  array( "icon_item_star_skillbook_","SKILLBOOK"),
                                  array( "icon_cash_item_~cash~skillbook_","SKILLBOOK"),     
                                  array( "icon_event_item_~evnt~skillbook_","SKILLBOOK")
                                   ),                                  
                  "POLEARM" => array(
                                  array( "icon_item_polearm_","POLEARM"),
                                  array( "icon_item_star_polearm_","POLEARM"),
                                  array( "icon_cash_item_~cash~polearm_","POLEARM"),   
                                  array( "icon_event_item_~evnt~polearm_","POLEARM")
                                   ),
                  "STAFF" => array(                                   
                                  array( "icon_item_staff_","STAFF"), 
                                  array( "icon_item_star_staff_","STAFF"),
                                  array( "icon_cash_item_~cash~staff_","STAFF"),   
                                  array( "icon_event_item_~evnt~staff_","STAFF")
                                   ),
                  "BOW" => array(                                   
                                  array( "icon_item_bow_","BOW"),                                   
                                  array( "icon_item_star_bow_","BOW"),
                                  array( "icon_cash_item_~cash~bow_","BOW"),     
                                  array( "icon_event_item_~evnt~bow_","BOW")
                                   ),
                  "SHIELD" => array(                                   
                                  array( "icon_item_shield_","SHIELD"),
                                  array( "icon_item_star_shield_","SHIELD"),
                                  array( "icon_cash_item_~cash~shield_","SHIELD"),   
                                  array( "icon_event_item_~evnt~shield_","SHIELD")
                                   ),
                  "HARP" => array(                                   
                                  array( "icon_harp_","HARP"),
                                  array( "icon_item_harp_","HARP"),
                                  array( "icon_item_star_harp_","HARP"),
                                  array( "icon_pro_item_~pros~harp_","HARP"),
                                  array( "icon_cash_item_~cash~harp_","HARP"),   
                                  array( "icon_event_item_~evnt~harp_","HARP")
                                   ),
                  "GUN" => array(                                   
                                  array( "icon_gun_","GUN"),
                                  array( "icon_item_gun_","GUN"),
                                  array( "icon_item_star_gun_","GUN"),
                                  array( "icon_pro_item_~pros~gun_","GUN"),
                                  array( "icon_cash_item_~cash~gun_","GUN"),    
                                  array( "icon_event_item_~evnt~gun_","GUN")
                                   ),
                  "CANNON" => array(                                 
                                  array( "icon_cannon_","CANNON"),
                                  array( "icon_item_cannon_","CANNON"),
                                  array( "icon_item_star_cannon_","CANNON"),
                                  array( "icon_pro_item_~pros~cannon_","CANNON"),
                                  array( "icon_cash_item_~cash~cannon_","CANNON"),   
                                  array( "icon_event_item_~evnt~cannon_","CANNON")
                                   ),
                  "KEYBLADE" => array(                                 
                                  array( "icon_keyblade_","KEYBLADE"),
                                  array( "icon_item_keyblade_","KEYBLADE"),
                                  array( "icon_item_star_keyblade_","KEYBLADE"),
                                  array( "icon_pro_item_~pros~keyblade_","KEYBLADE"),
                                  array( "icon_cash_item_~cash~keyblade_","KEYBLADE"),   
                                  array( "icon_event_item_~evnt~keyblade_","KEYBLADE")
                                   ),
                  "EARRINGS" => array(
                                  array( "_earring_","EARRINGS"),
                                  array( "icon_cash_item_earring_","EARRINGS")
                                   ),
                  "STIGMA" => array(                                   
                                  array( "icon_item_stigma","STIGMA"), 
                                  array( "icon_item_enhanced_stigma","STIGMA"),
                                  array( "icon_item_broken_stigma","STIGMA")        // ab 4.8
                                   ),
                  "KEY" => array(
                                  array( "icon_item_key","KEY"),
                                  array( "_keydoor","KEY")
                                   ),
                  "COINS" => array(
                                  array( "_coin_","COINS"),
                                  array( "icon_item_coin","COINS")
                                   ),
                  "MEDALS" => array(
                                  array( "icon_item_badge","MEDALS"),
                                  array( "_badge_","MEDALS")
                                   ),
                  "OTHER" => array(
                                  array( "_ring_","RINGS"),
                                  array( "_necklace_","NECKLACE"),
                                  array( "_belt_","BELT"),
                                  array( "_head_","HELMET"),
                                  array( "_cap_","HELMET"),
                                  array( "_helm_","HELMET"),
                                  array( "_glasses_","HELMET"),
                                  array( "_body_","JACKET"),
                                  array( "_torso_","JACKET"),
                                  array( "_pants_","PANTS"),
                                  array( "_shoes_","SHOES"),
                                  array( "_glove_","GLOVES"),
                                  array( "_shoulder","SHOULDERS"),
                                  array( "Icon_Item_tshirt_","PLUME"),
                                  array( "icon_item_synthesis","COMBINATION"),
                                  array( "icon_item_tool","CRAFT_BOOST"),
                                  array( "icon_item_rawhide","RAWHIDE"),
                                  array( "icon_item_dragonhorn","BALIC_MATERIAL"),
                                  array( "icon_item_enchant","ENCHANTMENT"),
                                  array( "icon_item_holystone_","GODSTONE"),
                                  array( "icon_item_magicstone_","MANASTONE"),
                                  array( "icon_item_battery","SHARD")
                                   )
                     );    

    // besondere Items werden vorab geprüft!     
    if (isset($tabTpls[$key]['desc']))
    {
        $desc = strtolower(getTabTplsValue($key,"desc"));
        
        if ($desc != "")
        {
            if (stripos($desc,"str_matter_enchant_") !== false) return "ENCHANTMENT";
            if (stripos($desc,"str_ws_material_")    !== false
            ||  stripos($desc,"str_as_meterial_")    !== false
            ||  stripos($desc,"str_fs_material_")    !== false
            ||  stripos($desc,"str_we_material_")    !== false
            ||  stripos($desc,"str_ac_material_")    !== false
            ||  stripos($desc,"str_ar_meterial_")    !== false) return "FLUX";
            if (stripos($desc,"str_as_ab_material_") !== false
            ||  stripos($desc,"str_ws_ab_material_") !== false) return "BALIC_EMOTION";
            if (stripos($desc,"str_dr_material_")    !== false) return "BALIC_MATERIAL";
            if (stripos($desc,"str_rawhide_")        !== false) return "RAWHIDE";
            if (stripos($desc,"str_soulstone_")      !== false) return "SOULSTONE";
            if (stripos($desc,"str_rec_")            !== false) return "RECIPE";
            if (stripos($desc,"str_dropmaterial_")   !== false) return "DROP_MATERIAL";
            if (stripos($desc,"str_harvest_dye_")    !== false
            ||  stripos($desc,"str_harvest_potion")  !== false) return "GATHERABLE_BONUS";
            if (stripos($desc,"_quest_")             !== false) return "QUEST";            
        }        
    }  
    
    if (isset($tabTpls[$key]['category']))
    {
        if (strtolower($tabTpls[$key]['category']) == "harvest")
            return "GATHERABLE";
    }    
    
    // Prüfung aller anderen Items über die o.a. Tabellen
    if (isset($tabTpls[$key]["icon_name"]))
    {
        $icon = strtolower($tabTpls[$key]['icon_name']);
        $ckey = "OTHER";
        
        // Category-Gruppenschlüssel ermittelbar?
        for ($c=0;$c<$maxCKey;$c++)
        {
            if (stripos($icon,$tabCKey[$c][0]) !== false)
            {
                $ckey = $tabCKey[$c][1];
                $c    = $maxCKey;
            }
        }
                   
        $maxCateg = count($tabCateg[$ckey]);
        
        for ($c=0;$c<$maxCateg;$c++)
        {
            // Platzhalter vorhanden für PROS?
            if     (stripos($tabCateg[$ckey][$c][0],$cPROS) !== false)
            {
                for ($s=0;$s<$maxPros;$s++)
                {
                    $such = str_replace($cPROS,$tabPros[$s],$tabCateg[$ckey][$c][0]);
                    
                    if (stripos($icon,$such) !== false)
                        return $tabCateg[$ckey][$c][1];
                }
            }
            // Platzhalter vorhanden für CASH
            elseif (stripos($tabCateg[$ckey][$c][0],$cCASH) != false)
            {
                for ($s=0;$s<$maxCash;$s++)
                {
                    $such = str_replace($cCASH,$tabCash[$s],$tabCateg[$ckey][$c][0]);
                                           
                    if (stripos($icon,$such) !== false)
                        return $tabCateg[$ckey][$c][1];
                }
            }
            // Platzhalter vorhanden für EVNT
            elseif (stripos($tabCateg[$ckey][$c][0],$cEVNT) != false)
            {
                for ($s=0;$s<$maxEvnt;$s++)
                {
                    $such = str_replace($cEVNT,$tabEvnt[$s],$tabCateg[$ckey][$c][0]);
                                           
                    if (stripos($icon,$such) !== false)
                        return $tabCateg[$ckey][$c][1];
                }
            }
            elseif (stripos($icon,$tabCateg[$ckey][$c][0]) !== false)
            {
                return $tabCateg[$ckey][$c][1];
            }
        }
        
        return "NONE";
    }
    
    return "";
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: weapontype
// ----------------------------------------------------------------------------
function getWeaponType($key)
{
    global $tabTpls;
    
    if (isset($tabTpls[$key]['weapon_type']) 
    &&  $tabTpls[$key]['weapon_type'] != ""
    &&  strtoupper($tabTpls[$key]['weapon_type']) != "NOWEAPON")
    {
        if (substr(strtoupper($tabTpls[$key]['weapon_type']),0,3) == "1H_"
        ||  substr(strtoupper($tabTpls[$key]['weapon_type']),0,3) == "2H_")
        {
            return strtoupper( substr($tabTpls[$key]['weapon_type'],3)."_".substr($tabTpls[$key]['weapon_type'],0,2));
        }
        else
            if (strtolower($tabTpls[$key]['weapon_type']) == "bow")
                return "BOW";
            else
            return "";
    }
    else
        return "";
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: armortype
// ----------------------------------------------------------------------------
function getArmorType($key)
{
    global $tabTpls;
    
    if (isset($tabTpls[$key]['armor_type']))
        return "ARMOR";
    
    if (!isset($tabTpls[$key]['desc']))
    {
        if ($key == "182400004")
            $desc = "noweapon";
        else
            $desc = "";
    }
    else
        $desc = strtolower($tabTpls[$key]['desc']);
    
    if (isset($tabTpls[$key]['icon_name']))
        $icon = strtolower($tabTpls[$key]['icon_name']);
    else
        $icon = "";
    
    if (stripos($desc,"stigma")       === false
    && (stripos($desc,"shield")       !== false
    ||  stripos($desc,"buckler")      !== false
    ||  stripos($desc,"_wing_")       !== false
    ||  stripos($desc,"str_tshirt")   !== false
    ||  stripos($desc,"str_battery_") !== false
    ||  stripos($icon,"_arrow")       !== false))
        return "ARMOR";
    
    if (stripos($desc,"stigma")       === false
    && (stripos($desc,"str_ring_")    !== false
    ||  stripos($icon,"_ring_")       !== false
    ||  stripos($desc,"_earring")     !== false
    ||  stripos($desc,"earring_")     !== false
    ||  stripos($desc,"_earring_")    !== false
    ||  stripos($icon,"_earring_")    !== false
    ||  stripos($desc,"str_necklace") !== false
    ||  stripos($desc,"str_belt_")    !== false))
        return "ACCESSORY";
        
    return "";
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: equipment
// ----------------------------------------------------------------------------
function getEquipmentType($key)
{
    global $tabTpls;
    
    $ret = "";
    
    if     (isset($tabTpls[$key]["weapon_type"])) $ret = "WEAPON";
    elseif (isset($tabTpls[$key]["armor_type"]))  $ret = "ARMOR";
    elseif (isset($tabTpls[$key]['desc']))
    {
        $desc = strtolower($tabTpls[$key]['desc']);
        
        if (isset($tabTpls[$key]['icon_name']))
            $icon = strtolower($tabTpls[$key]['icon_name']);
        else
            $icon = "";
            
        if (stripos($desc,"stigma")       === false
        && (stripos($desc,"shield")       !== false
        ||  stripos($desc,"buckler")      !== false
        ||  stripos($desc,"_wing_")       !== false
        ||  stripos($desc,"str_tshirt")   !== false
        ||  stripos($desc,"str_belt_")    !== false
        ||  stripos($icon,"_belt_")       !== false
        ||  stripos($desc,"str_ring_")    !== false
        ||  stripos($desc,"str_necklace") !== false
        ||  stripos($desc,"str_battery_") !== false
        ||  stripos($desc,"_earring")     !== false
        ||  stripos($desc,"earring_")     !== false
        ||  stripos($desc,"_earring_")    !== false
        //  über den Icon-Namen
        ||  stripos($icon,"_earring_")    !== false
        ||  stripos($icon,"_necklace_")   !== false
        ||  stripos($icon,"_ring_")       !== false
        ||  stripos($icon,"_arrow")       !== false))
            $ret = "ARMOR";
    }
    
    return $ret;
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: name
// ----------------------------------------------------------------------------
function getName($key)
{
    global $tabTpls;
    
    if ($key == 150000001 || $key == 182400004)
        return "";
    else
        return str_replace("\n","\\n",getClientItemName($tabTpls[$key]['name']));
}    
// ----------------------------------------------------------------------------
// Ermitteln Wert für: desc ID
// ----------------------------------------------------------------------------
function getDesc($key)
{    
    $ret = "";
    
    // Tabelle ist aus dem aktuellen 4.8-SVN entnommen
    $tabSpezi = array(
                  array("150000001","480669"),
                  array("162001042","0"),
                  array("162001043","0"),
                  array("182400004","1401117")
                );
    $maxSpezi = count($tabSpezi);
    
    // Sonderbehandlung für einige spezielle Items gem. o.a. Tabelle
    for ($s=0;$s<$maxSpezi;$s++)
    {
        if ($key == $tabSpezi[$s][0])
        {
            return $tabSpezi[$s][1];
        }
    }
    
    // Ermittlung über die Angaben desc, desc_long
    $sname = getTabTplsValue($key,'desc');
    $slong = getTabTplsValue($key,'desc_long');
    $ret   = getDescNameId($sname,$slong);
    
    // Hinweis: nichts gefunden
    if ($ret == "" || $ret == "0")
    {
        logLine("- <font color=red>ID zu DESC nicht gefunden</font>","Key = $key, text = '".strtoupper($sname)."' - auf '0' gesetzt");
        return "0";
    }
    else
        return $ret;
}       
// ----------------------------------------------------------------------------
// Ermitteln Wert für: desc Name
// ----------------------------------------------------------------------------
function getNameDesc($key)
{
    global $tabTpls;
    
    if (isset($tabTpls[$key]['name']))
        return $tabTpls[$key]['name'];
    else
        return "";
}    
// ----------------------------------------------------------------------------
// Ermitteln Wert für: race
// ----------------------------------------------------------------------------
function getRace($key)
{
    global $tabTpls;
    
    $ret = "";
    
    if (isset($tabTpls[$key]['race_permitted']))
    {
        switch($tabTpls[$key]['race_permitted'])
        {
            case "pc_dark":  $ret = "ASMODIANS"; break;
            case "pc_light": $ret = "ELYOS";     break;
            default:         $ret = "PC_ALL";    break;
        }
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: randombonus
// ----------------------------------------------------------------------------
function getRndBonus($key)
{
    global $tabTpls;
    
    $ret = "";
    
    if (isset($tabTpls[$key]['random_option_set']))
        return getRndOptionNameId($tabTpls[$key]['random_option_set']);
    else
        return "";
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: randormcount
// ----------------------------------------------------------------------------
function getRndCount($key)
{
    global $tabTpls;
    
    $ret = "";
    
    if (isset($tabTpls[$key]['reidentify_count']))
        return $tabTpls[$key]['reidentify_count'];
    else
        return "";
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: restrict
// ----------------------------------------------------------------------------
function getRestrict($key)
{
    global $tabTpls;
    /* so sind die Klassen in der ...SVN.../model/PlayerClass.java definiert!
       daher wird diese Reihenfolge auch in der nachfolgenden Tabelle analog
       vorgegeben: 0 - 16 = 17 Stellen (ALL entfällt hierbei)!
       
    WARRIOR(0, true),
    GLADIATOR(1), // fighter
    TEMPLAR(2), // knight
    SCOUT(3, true),
    ASSASSIN(4),
    RANGER(5),
    MAGE(6, true),
    SORCERER(7), // wizard
    SPIRIT_MASTER(8), // elementalist
    PRIEST(9, true),
    CLERIC(10),
    CHANTER(11),
    ENGINEER(12, true),
    RIDER(13),
    GUNNER(14),
    ARTIST(15, true),
    BARD(16),
    */
    $tabClass = array( "WARRIOR","FIGHTER","KNIGHT",
                       "SCOUT","ASSASSIN","RANGER",
                       "MAGE","WIZARD","ELEMENTALIST",
                       "PRIEST","CLERIC","CHANTER",
                       "ENGINEER","RIDER","GUNNER",
                       "ARTIST","BARD"
                     );
    $maxClass = count($tabClass);
    
    $ret = "";
    $trn = "";
    
    for ($c=0;$c<$maxClass;$c++)
    {   
        if (isset($tabTpls[$key][$tabClass[$c]]))
            $ret .= $trn.$tabTpls[$key][$tabClass[$c]];
        else
            if (isset($tabTpls[$key][strtolower($tabClass[$c])]))
                $ret .= $trn.$tabTpls[$key][strtolower($tabClass[$c])];
            else
                $ret .= $trn."0";
        
        $trn = ",";
    }
    
    return $ret;
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: restrictmax
// ----------------------------------------------------------------------------
function getRestrictMax($key)
{
    global $tabTpls;
    
    $tabClass = array( "WARRIOR_MAX","FIGHTER_MAX","KNIGHT_MAX",
                       "SCOUT_MAX","ASSASSIN_MAX","RANGER_MAX",
                       "MAGE_MAX","WIZARD_MAX","ELEMENTALIST_MAX",
                       "PRIEST_MAX","CLERIC_MAX","CHANTER_MAX",
                       "ENGINEER_MAX","RIDER_MAX","GUNNER_MAX",
                       "ARTIST_MAX","BARD_MAX"
                     );
    
    $maxClass = count($tabClass);
    
    $ret = "";
    $not = "";
    $trn = "";
    
    for ($c=0;$c<$maxClass;$c++)
    {   
        if (isset($tabTpls[$key][$tabClass[$c]]))
            $ret .= $trn.$tabTpls[$key][$tabClass[$c]];
        else
            if (isset($tabTpls[$key][strtolower($tabClass[$c])]))
                $ret .= $trn.$tabTpls[$key][strtolower($tabClass[$c])];
            else
                $ret .= $trn."0";
            
        $not .= $trn."0";
        $trn = ",";
    }
    
    if ($ret != $not)
        return $ret;
    else
        return "";
}
// ----------------------------------------------------------------------------
// Ermimtteln Wert für: activation_combat
// ----------------------------------------------------------------------------
function getActivateCombat($key)
{
    global $tabTpls;
    
    if (isset($tabTpls[$key]['activation_mode']))
    {
        $mode = strtoupper(getTabTplsValue($key,'activation_mode'));
        
        if ($mode == "COMBAT")
            return "true";
    }
    return "";
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: slot
// ----------------------------------------------------------------------------
function getSlot($key)
{
    global $tabTpls;
    
    $tabSlots = array(
                  array(     0,"none"),
                  array(     0,"torso glove foot shoulder leg"),
                  array(     1,"main"),
                  array(     2,"sub"),
                  array(     3,"main_or_sub"),
                  array(     4,"head"),
                  array(     8,"torso"),
                  array(    16,"glove"),
                  array(    32,"foot"),
            //    array(    64,"right_ear"),     NOTUSED
            //    array(   128,"left_ear"),      NOTUSED            
                  array(   192,"right_or_left_ear"),
            //    array(   256,"right_finger")   NOTUSED
            //    array(   512,"left_finger")    NOTUSED            
                  array(   768,"right_or_left_finger"),
                  array(  1024,"neck"),
                  array(  2048,"shoulder"),
                  array(  4096,"leg"),
            //    array(  8192,"right_battery")  NOTUSED  
            //    array( 16384,"left_battery")   NOTUSED            
                  array( 24576,"right_or_left_battery"),                  
                  array( 32768,"wing"),
                  array( 65536,"waist"),
                  array(524288,"t_shirt")
                     );
    $maxSlots = count($tabSlots);
    
    if (isset($tabTpls[$key]['equipment_slots']))
    {
        for ($s=0;$s<$maxSlots;$s++)
        {
            if (strtolower($tabTpls[$key]['equipment_slots']) == $tabSlots[$s][1])
                return $tabSlots[$s][0];
        }   
    }
    return 0;
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: maxenchant
// ----------------------------------------------------------------------------
function getMaxEnchant($key)
{
    global $tabTpls;
    
    if (isset($tabTpls[$key]['max_enchant_value']))
    {
        if ($tabTpls[$key]['max_enchant_value'] != "0")
            return $tabTpls[$key]['max_enchant_value'];
    }
    return "";
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: robot
// ----------------------------------------------------------------------------
function getRobotId($key)
{
    global $tabTpls;
    
    if (isset($tabTpls[$key]['robot_name']))
        return getRobotNameId($tabTpls[$key]['robot_name']);
    else
        return "";
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: anim
// ----------------------------------------------------------------------------
function getAnimId($name)
{
    global $tabAnimNames;
    
    $such = strtoupper($name);
    
    if (isset($tabAnimNames[$such]))
        return $tabAnimNames[$such];
    else
    {
        logLine("Animations-Id fehlt",$name);
        return "";
    }
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: authorize
// ----------------------------------------------------------------------------
function getAuthId($key)
{
    global $tabTpls,$tabAuthNames;
    
    $such = strtoupper(getTabTplsValue($key,'authorize_name'));
    
    if ($such != "")
    {
        if (isset($tabAuthNames[$such]))
            return $tabAuthNames[$such];
        else
        {
            logLine("- <font color=red>Authorize-Id fehlt (Client)</font>",$key." / ".$such);
            return "";
        }
    }
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: npcname
// ----------------------------------------------------------------------------
/*
function getNpcNameId($name)
{
    global $tabNpcInfos;
    
    $such = strtoupper($name);
    
    if (isset($tabNpcInfos[$such]))
        return $tabNpcInfos[$such]['npc_id'];
    else
    {
        logLine("NPC-Name fehlt",$such);
        return "";
    }
}
*/
// ----------------------------------------------------------------------------
// Ermitteln Wert für: skillclass
// ----------------------------------------------------------------------------
function getSkillClassName($key)
{
    global $tabTpls;
    
    $tabClass = array( "warrior","scout","mage","cleric","engineer","artist","fighter",
                       "knight","assassin","ranger","wizard","elementalist","chanter",
                       "priest","gunner","bard","rider"
                     );
    $maxClass = count($tabClass);
    $cntClass = 0;
    $retClass = "";
    
    for ($c=0;$c<$maxClass;$c++)
    {
        if (isset($tabTpls[$key][$tabClass[$c]]))
        {
            if ($tabTpls[$key][$tabClass[$c]] != "0")
            {    
                $retClass = $tabClass[$c];
                $cntClass++;
            }
        }
    }
    
    if ($cntClass == 17)
        return "all";
    else
        if ($cntClass > 0)
            return $retClass;
        else
            return "";
}
// ----------------------------------------------------------------------------
// Ermitteln Wert für: class
// ----------------------------------------------------------------------------
function getClassName($class)
{
    switch($class)
    {
        case "all":          return "ALL";
        case "warrior":      return "WARRIOR";
        case "scout":        return "SCOUT";
        case "mage":         return "MAGE";
        case "cleric":       return "CLERIC";
        case "engineer":     return "ENGINEER";
        case "artist":       return "ARTIST";
        case "fighter":      return "FIGHTER";
        case "knight":       return "KNIGHT";
        case "assassin":     return "ASSASIN";
        case "ranger":       return "RANGER";
        case "wizard":       return "SORCERER";
        case "elementalist": return "SPIRIT_MASTER";
        case "chanter":      return "CHANTER";
        case "priest":       return "CLERIC";
        case "gunner":       return "GUNNER";
        case "bard":         return "BARD";
        case "rider":        return "RIDER";
        default: return strtoupper($class);
    }
}
// ----------------------------------------------------------------------------
//
//                  S E T T I N G - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Nullwerte auf Blank setzen ( "0" = "" ) 
// ----------------------------------------------------------------------------
function setZeroToBlank($key,$field)
{
    global $tabTpls;
    
    if (isset($tabTpls[$key][$field]))
    {
        if ($tabTpls[$key][$field] == "0")
            $tabTpls[$key][$field] = "";
    }    
}
// ----------------------------------------------------------------------------
// False-Werte auf Blank setzen ( FALSE = "" )
// ----------------------------------------------------------------------------
function setFalseToBlank($key,$field)
{
    global $tabTpls;
    
    if (isset($tabTpls[$key][$field]))
    {
        if (strtoupper($tabTpls[$key][$field]) == "FALSE")
            $tabTpls[$key][$field] = "";
    }    
}
// ----------------------------------------------------------------------------
//
//               A U F B E R E I T U N G S - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// XML-Key-Text aufbereiten, wenn vorhanden
// Params: $key         Schlüssel zur Tabelle (ItemID)
//         $upper       Rückgabe in Grossbuchstaben
//         $blank       Rückgabe auch von leeren Feldern
//         $name        Client-XML-Tag-Name
//         $text        EMU-XML-Key-Name
// return: string       aufbereiteter Text oder Leer, wenn Feld nicht vorhanden
// ----------------------------------------------------------------------------
function getFieldValue($key,$upper,$blank,$name,$text)
{
    global $tabTpls;
    
    $ret = "";
    
    if (isset($tabTpls[$key][$name]))
    {
        if ($tabTpls[$key][$name] != "")
            if ($upper == false)
                $ret = ' '.$text.'="'.$tabTpls[$key][$name].'"';
            else
                $ret = ' '.$text.'="'.strtoupper($tabTpls[$key][$name]).'"';
        else
            if ($blank)
                $ret = ' '.$text.'=""';
    }  
    else
    {
        if ($blank)
            $ret = ' '.$text.'=""';
    }

    if ($name == "item_type" && stripos($ret,"NOMAL") !== false)
    {
        $ret = str_replace("NOMAL","NORMAL",$ret);
        logLine("- <font color=orange>Client-Syntax-Korrektur</font>",$key." / item_type / NOMAL = NORMAL");
    }  
    
    return $ret;
}
// ----------------------------------------------------------------------------
// Zurückgeben "" oder Value zum vorgegebenen Tabellen-Feld
// ----------------------------------------------------------------------------
function getTabTplsValue($key,$field)
{
    global $tabTpls;
    
    return isset($tabTpls[$key][$field]) ? $tabTpls[$key][$field] : "";
}
// ----------------------------------------------------------------------------
// Ausgabezeilen aufbereiten zu: item_template 
// ----------------------------------------------------------------------------
function getItemTemplateLines($key)
{       
    $ret = '    <item_template'.
           getFieldValue($key,false,false,"id","id").
           getFieldValue($key,false,true ,"outname","name").      
           getFieldValue($key,false,false,"outdesc","desc").           
           getFieldValue($key,false,false,"name_desc","name_desc"). 
           getFieldValue($key,false,false,"level","level").
           getFieldValue($key,false,false,"mask","mask").
           getFieldValue($key,true ,false,"category","category").
           getFieldValue($key,true ,false,"outweapontype","weapon_type").
           getFieldValue($key,false,false,"outarmortype","armor_type").
           getFieldValue($key,false,false,"max_authorize","max_authorize").
           getFieldValue($key,false,false,"outauthorizename","authorize_name").
           getFieldValue($key,true ,false,"attack_type","attack_type").
           getFieldValue($key,false,false,"max_stack_count","max_stack_count").
           getFieldValue($key,false,false,"can_pack_count","pack_count").
           getFieldValue($key,true ,false,"item_type","item_type").
           getFieldValue($key,true ,false,"quality","quality").
           getFieldValue($key,false,false,"price","price").
           getFieldValue($key,true ,false,"race","race").
           getFieldValue($key,false,false,"rnd_bonus","rnd_bonus").
           getFieldValue($key,false,false,"rnd_count","rnd_count").
           getFieldValue($key,false,false,"option_slot_bonus","option_slot_bonus").
           getFieldValue($key,false,false,"restrict","restrict").
           getFieldValue($key,false,false,"restrict_max","restrict_max").
           getFieldValue($key,false,false,"return_worldid","return_world").
           getFieldValue($key,true ,false,"return_alias","return_alias").
           getFieldValue($key,false,false,"weapon_boost_value","weapon_boost").
           getFieldValue($key,false,false,"robot_id","robot_id").
           getFieldValue($key,true ,false,"bonus_apply","bonus_apply").
           getFieldValue($key,true ,false,"equipmenttype","equipment_type").
           getFieldValue($key,false,false,"slot","slot").
           getFieldValue($key,false,false,"max_enchant_bonus","max_enchant_bonus").
           getFieldValue($key,false,false,"max_enchant_value","max_enchant").
           getFieldValue($key,false,false,"option_slot_value","m_slots").
           getFieldValue($key,false,false,"special_slot_value","s_slots").
           getFieldValue($key,true ,false,"activate_target","activate_target").
           getFieldValue($key,false,false,"activatecombat","activate_combat").
           getFieldValue($key,false,false,"activation_count","activate_count").
           getFieldValue($key,false,false,"expire_time","expire_time").
           getFieldValue($key,false,false,"temporary_exchange_time","temp_exchange_time").
           getFieldValue($key,false,false,"exceed_enchant","exceed_enchant");
    
    return $ret;
}
// ----------------------------------------------------------------------------
// Ausgabezeilen aufbereiten zu: modifiers 
// ----------------------------------------------------------------------------
function getModifierLines($key)
{
    global $tabTpls;
    
    $tabTags = array("block","dodge","magical_skill_boost_resist","magical_defend",
                     "magical_resist","max_hp","physical_critical_reduce_rate",
                     "physical_defend","damage_reduce"
                    );
    $maxTags = count($tabTags);
    
    $ret   = "";
    $cond  = "";
    
    for ($t=0;$t<$maxTags;$t++)
    {
        if (isset($tabTpls[$key][$tabTags[$t]]))
        {
            if ($tabTpls[$key][$tabTags[$t]] != "0"
            &&  $tabTpls[$key][$tabTags[$t]] != "")
            {
                $xml = "add";
                
                // bei damage_reduce wird im SVN "rate" statt "add" vorgegeben !?!?
                if ($tabTags[$t] == "damage_reduce") $xml = "rate";
                
                $ret .= '            <'.$xml.' name="'.getModifierAttrName($tabTags[$t]).'" value="'.
                        $tabTpls[$key][$tabTags[$t]].'"/>'."\n";
            }
        }
    }
    
    // zusätzlich, da im SVN aktuell vorhanden (überwiegend Attribute von Manasteinen)
    // momentan ( bis Version 4.8) sind bis zu   5   Attribute im Client vorgegeben
    // sollte bei der Generierung der Text "MAXB = x" erscheinen, dann Werte anpassen
    // in der nachfolgenden Schleife!
    for ($b=0;$b<7;$b++)
    {
        $akey = "stat_enchant_type".$b;
        $aval = "stat_enchant_value".$b;
        
        if (isset($tabTpls[$key][$akey]) && isset($tabTpls[$key][$aval]))
        {
            if ($b > 5) echo "\n<br>MAXB = $b (bitte die Schleife anpassen - in inc_itemtplparse.php ab Zeile ca. 1002)";
            $aktkey = getTabTplsValue($key,$akey);
            $aktval = getTabTplsValue($key,$aval);
            $xml    = "add";
            
            if (stripos($aktval,"%") !== false) $xml = "rate";
            
            $ret .= '            <'.$xml.' name="'.getModifierAttrName($aktkey).'" value="'.
                    $aktval.'" bonus="true"/>'."\n";
        }
    }
    // bonus_attr
    for ($b=1;$b<13;$b++)
    {
        $akey = "bonus_attr".$b;
        if (isset($tabTpls[$key][$akey]))
        {
            // Schreibfehler-Korrektur in ClientDatei (100501221)
            if (strtolower($tabTpls[$key][$akey]) == "booscasting  time 60")
            {
                logLine("- <font color=orange>Client-Syntax-Korrektur</font>",$key." / ".$akey." / ".$tabTpls[$key][$akey]);
                $tabTpls[$key][$akey] = "BoostCastingTime 60";
            }
            
            if ($tabTpls[$key][$akey] != "" 
            &&  $tabTpls[$key][$akey] != "0"
            &&  stripos($tabTpls[$key][$akey]," ") !== false)
            {
                $tab = explode(" ",str_replace("  "," ",$tabTpls[$key][$akey]));
                $xml = "add";
                
                if ($tab[1] != "0" && $tab[1] != "")
                {
                    if (stripos($tab[1],"%") !== false)
                    {
                        $xml    = "rate";
                        $tab[1] = trim(str_replace("%","",$tab[1]));
                        if (strtolower($tab[0]) == "attackdelay") $tab[1] *= -1;
                    }
                    if ($cond != "")
                        $ret .= '            <'.$xml.' name="'.getModifierAttrName($tab[0]).'" value="'.
                                $tab[1].'" bonus="true"'.$cond.'            </'.$xml.">\n";
                    else
                        $ret .= '            <'.$xml.' name="'.getModifierAttrName($tab[0]).'" value="'.
                                $tab[1].'" bonus="true"/>'."\n";                   
                }
            }
        }
    }
    
    // Conditions? gilt für alle bonus_attr_a-Angaben
    $cond = "";
    if (isset($tabTpls[$key]['charge_price1']))
    {
        $price = intval(ceil($tabTpls[$key]['charge_price1']*10));
        // $price = intval(ceil($tabTpls[$key]['charge_price1']));
        $cond  = '>'."\n".
                 "                <conditions>\n".
                 '                    <charge value="'.$price.'"/>'."\n".
                 "                </conditions>\n";
    }
        
    // bonus_attr_a
    for ($b=1;$b<5;$b++)
    {
        $akey = "bonus_attr_a".$b;
        
        if (isset($tabTpls[$key][$akey]))
        {
            if ($tabTpls[$key][$akey] != "" 
            &&  $tabTpls[$key][$akey] != "0"
            &&  stripos($tabTpls[$key][$akey]," ") !== false)
            {
                $tab = explode(" ",str_replace("  "," ",$tabTpls[$key][$akey]));
                $xml = "add";
                
                if ($tab[1] != "0" && $tab[1] != "")
                {
                    if (stripos($tab[1],"%") !== false)
                    {
                        $xml = "rate";
                        $tab[1] = trim(str_replace("%","",$tab[1]));
                        if (strtolower($tab[0]) == "attackdelay") $tab[1] *= -1;

                    }
                    if ($cond != "")
                        $ret .= '            <'.$xml.' name="'.getModifierAttrName($tab[0]).'" value="'.
                                $tab[1].'" bonus="true"'.$cond.'            </'.$xml.">\n";
                    else
                        $ret .= '            <'.$xml.' name="'.getModifierAttrName($tab[0]).'" value="'.
                                $tab[1].'" bonus="true"/>'."\n";
                }
            }
        }
    }
    
    // Conditions? gilt für alle bonus_attr_b-Angaben
    $cond = "";
    if (isset($tabTpls[$key]['charge_price2']))
    {
        $price = intval(ceil($tabTpls[$key]['charge_price2']*10));
        // $price = intval(ceil($tabTpls[$key]['charge_price2']));
        $cond  = '>'."\n".
                 "                <conditions>\n".
                 '                    <charge value="'.$price.'"/>'."\n".
                 "                </conditions>\n";
    }
        
    // bonus_attr_b
    for ($b=1;$b<5;$b++)
    {
        $akey = "bonus_attr_b".$b;
        
        if (isset($tabTpls[$key][$akey]))
        {
            if ($tabTpls[$key][$akey] != "" 
            &&  $tabTpls[$key][$akey] != "0"
            &&  stripos($tabTpls[$key][$akey]," ") !== false)
            {
                $tab = explode(" ",str_replace("  "," ",$tabTpls[$key][$akey]));
                $xml = "add";
            
                if ($tab[1] != "0" && $tab[1] != "")
                {
                    if (stripos($tab[1],"%") !== false)
                    {
                        $xml = "rate";
                        $tab[1] = trim(str_replace("%","",$tab[1]));
                        if (strtolower($tab[0]) == "attackdelay") $tab[1] *= -1;
                    }
                    if ($cond != "")
                        $ret .= '            <'.$xml.' name="'.getModifierAttrName($tab[0]).'" value="'.
                                $tab[1].'" bonus="true"'.$cond.'            </'.$xml.">\n";
                    else
                        $ret .= '            <'.$xml.' name="'.getModifierAttrName($tab[0]).'" value="'.
                                $tab[1].'" bonus="true"/>'."\n";
                }
            }
        }
    }
    
    if ($ret != "")
        $ret = "        <modifiers>\n".
               $ret.
               "        </modifiers>";
        
    return $ret;
}
// ----------------------------------------------------------------------------
// Ausgabezeilen aufbereiten zu: action 
// ----------------------------------------------------------------------------
function getActionLines($key)
{
    global $tabTpls;
    
    $ret = "";
    
    $titcat = getTabTplsValue($key,'target_item_category');
    $aprate = getTabTplsValue($key,'ap_extraction_rate');
    $rident = getTabTplsValue($key,'reidentify_type');
    $rcount = getTabTplsValue($key,"reidentify_count_not_decrease");
    
    // tuning 
    if ($titcat != "" && $rident != ""  && $aprate == "")
    {
        $ret .= '            <tuning target="'.strtoupper($titcat).'" type="'.$rident.'"';
        
        if ($rcount != "" && $rcount != "0")
            $ret .= ' del="'.$rcount.'"/>'."\n";
        else
            $ret .= "/>\n";
    }  
    
    // apextract
    if ($titcat != "" && $aprate != "")
        $ret .= '            <apextract rate="'.($aprate / 10).'" target="'.strtoupper($titcat).'"/>'."\n";
        // $ret .= '            <apextract rate="'.($aprate / 1000).'" target="'.strtoupper($titcat).'"/>'."\n";
    
    
    // pack
    if ($titcat != "" && $aprate == "" && $rident == "")
    {
        // Versuch: da im SVN offensichtlich ebenfalls abgefragt
        if (isset($tabTpls[$key]['can_sell_to_npc']))
        {
            $sell = strtoupper(getTabTplsValue($key,'can_sell_to_npc'));
            
            if ($sell == "FALSE")
                $ret .= '            <pack target="'.strtoupper($titcat).'"/>'."\n";
        }
    }
    unset($titcat,$aprate,$rident);
    
    // composition / authorize
    $name   = getTabTplsValue($key,'name');
    $disass = getTabTplsValue($key,'disassembly_item');
    $subench= getTabTplsValue($key,'sub_enchant_material_many');
    
    if ($name != "")
    {
        if (stripos($name,"_composition_") !== false && ($disass == "0" || $disass == ""))
            $ret .= '            <composition/>'."\n";
            
        if (stripos($name,"matter_2stenchant_") !== false && ($subench != "" && $subench != "0"))
            $ret .= '            <authorize count="'.$subench.'"/>'."\n";
    }
    
    unset($name,$disass,$subench);
    
    // polish
    if (isset($tabTpls[$key]['polish_set_name']))
        $ret .= '            <polish set_id="'.getPolishNameId($tabTpls[$key]['polish_set_name']).'"/>'."\n";
    
    // expextract
    $exprew = getTabTplsValue($key,'exp_extraction_reward');
    $excost = getTabTplsValue($key,'exp_extraction_cost'); 
    
    if ($exprew != "" && $excost != "")
    {
        if (stripos($excost,"%") !== false)
        {
            $percnt = ' percent="true"';
            $excost = trim(str_replace("%","",$excost));
        }
        else
            $percnt = "";
            
        $ret .= '            <expextract item_id="'.strtoupper($exprew).'" '.$percnt.' cost="'.$excost.'"/>'."\n";
    }    
    
    unset($exprew,$excost,$percnt);
    
    // remodel    
    $exskin = getTabTplsValue($key,'extract_skin_type');
    $avmins = getTabTplsValue($key,'cash_available_minute');

    if ($exskin != "")
    {
        if ($avmins != "")
            $mins = ' minutes="'.$avmins.'"';
        else
            $mins = "";
            
        $ret .= '            <remodel type="'.$exskin.'"'.$mins.'/>'."\n";
    }
    unset($exskin,$avmins,$mins);
    
    // adoptpet
    $funpet = getTabTplsValue($key,'func_pet_name');
    $confir = getTabTplsValue($key,'confirm_to_delete_cash_item');
    $petmin = getTabTplsValue($key,'func_pet_dur_minute');
    
    if ($funpet != "")
    {
        $ret .= '            <adoptpet petId="'.getToypetNameId($funpet).'"';
        
        if (strtoupper($confir) == "TRUE")
            $ret .= ' sidekick="true"';
        if ($petmin != "" && $petmin != "0")
            $ret .= ' minutes="'.$petmin.'"';
        
        $ret .= '/>'."\n";
    }
    unset($funpet,$confir,$petmin);
    
    // assemble
    $asitem = getTabTplsValue($key,'assembly_item');
    
    if (trim($asitem != ""))
        $ret .= '            <assemble item_id="'.strtolower($asitem).'"/>'."\n";
    unset($asitem);
    
    // housedeco
    if (isset($tabTpls[$key]['custom_part_name']))
    {
        $part   = getTabTplsValue($key,'custom_part_name');
        $deco   = getHouseDecoNameId($part);
        
        if ($deco == "")
            $deco = getHouseDecoNameId($part."A");
            
        if ($deco != "")
            $ret .= '            <housedeco id="'.$deco.'"/>'."\n";
        else
            $ret .= '            <housedeco/>'."\n";
            
        unset($part);
    }    
    // houseobject
    // if (isset($tabTpls[$key]['custom_house_object'])) ab 4.8 wohl nicht mehr
    if (isset($tabTpls[$key]['summon_housing_object']))
    {
        $obj    = getTabTplsValue($key,'summon_housing_object');
        $oname  = getHouseObjectNameId($obj);
        
        if ($oname != "")
            $ret .= '            <houseobject id="'.$oname.'"/>'."\n";
        else
            $ret .= '            <houseobject/>'."\n";
            
        unset($obj);
    }    
    // ride
    if (isset($tabTpls[$key]['ride_data_name']))
    {
        $ride = getTabTplsValue($key,'ride_data_name');
        if ($ride != "")
            $ret .= '            <ride npc_id="'.getRideNameId($ride).'"/>'."\n";
        
        unset($ride);
    }
    // charge
    if (isset($tabTpls[$key]['charge_capacity']))
    {
        $capa = getTabTplsValue($key,'charge_capacity');
        if ($capa != "" && $capa != "0")
            $ret .= '            <charge capacity="'.$capa.'"/>'."\n";
        
        unset($capa);
    }
    // cosmetic
    if (isset($tabTpls[$key]['cosmetic_name']))
    {
        $name = getTabTplsValue($key,'cosmetic_name');
        if ($name != "")
            $ret .= '            <cosmetic name="'.$name.'"/>'."\n";
        
        unset($name);
    }
    // instancetimeclear
    if (isset($tabTpls[$key]['reset_instance_coolt_sync_id']))
    {
        $sync = getTabTplsValue($key,'reset_instance_coolt_sync_id');
        if ($sync != "")
        {
            $sync = str_replace(","," ",$sync);
            $sync = str_replace("  "," ",$sync);
            $ret .= '            <instancetimeclear sync_ids="'.$sync.'"/>'."\n";
        }
        unset($sync);
    }
    // decompose
    if (isset($tabTpls[$key]['disassembly_item']))
    {
        $deco = getTabTplsValue($key,'disassembly_item');
        $typ1 = getTabTplsValue($key,'disassembly_type'); // TEST für select=...
        //$typ2 = getTabTplsValue($key,'confirm_to_delete_cash_item');
        
        if ($typ1 == "1")
        //if ($typ1 == "1")
            $sel = ' select="true"';
        else
            $sel = "";
            
        if ($deco == "1")
            $ret .= '            <decompose'.$sel.'/>'."\n";
        
        unset($deco);
    }
    // fireworkact
    if (isset($tabTpls[$key]['icon_name']))
    {
        $icon = getTabTplsValue($key,'icon_name');
        if (stripos($icon,"_firecracker_") !== false)
            $ret .= '            <fireworkact/>'."\n";
        
        unset($icon);
    }
    // animation
    $idle = getTabTplsValue($key,'custom_idle_anim');
    $run  = getTabTplsValue($key,'custom_run_anim');
    $jump = getTabTplsValue($key,'custom_jump_anim');
    $rest = getTabTplsValue($key,'custom_rest_anim');
    $shop = getTabTplsValue($key,'custom_shop_anim');
    $mins = getTabTplsValue($key,'anim_expire_time');
    
    if ($idle != "" || $run  != "" || $jump != "" || $rest != "" || $shop != "")
    {
        $ret .= '            <animation';
        
        if ($idle != "") $ret .= ' idle="'.getAnimId($idle).'"';
        if ($run  != "") $ret .= ' run="'.getAnimId($run).'"';
        if ($jump != "") $ret .= ' jump="'.getAnimId($jump).'"';
        if ($rest != "") $ret .= ' rest="'.getAnimId($rest).'"';
        if ($shop != "") $ret .= ' shop="'.getAnimId($shop).'"';
        if ($mins != "" && $mins != "0")
            $ret .= ' minutes="'.$mins.'"';
            
        $ret .= "/>\n";
    }
    unset ($idle,$run,$jump,$rest,$shop,$mins);
    
    // learnemotion
    $emot = getTabTplsValue($key,'cash_social');
    $mins = getTabTplsValue($key,'cash_available_minute');
    
    if ($emot != "")
    {
        $ret .= '            <learnemotion emotionid="'.$emot.'"';
        
        if ($mins != "" && $mins != "0")
            $ret .= ' minutes="'.$mins.'"';
            
        $ret .= "/>\n";
    }
    unset ($emot,$mins);
    
    // titleadd
    $tadd = getTabTplsValue($key,'cash_title');
    $mins = getTabTplsValue($key,'cash_available_minute');
    
    if ($tadd != "")
    {
        $ret .= '            <titleadd titleid="'.$tadd.'"';
        
        if ($mins != "" && $mins != "0")
            $ret .= ' minutes="'.$mins.'"';
            
        $ret .= "/>\n";
    }
    unset ($tadd,$mins);
    
    // expandinventory
    $levl = getTabTplsValue($key,'inven_warehouse_max_extendlevel');
    $name = getTabTplsValue($key,'name');
    
    if ($levl != "")
    {
        $stor = "";
        
        if (stripos($name,'_extend_cube_') !== false) 
            $stor = ' storage="CUBE"';
        elseif (stripos($name,'_extend_warehouse_') !== false)
            $stor = ' storage="WAREHOUSE"';
            
        $ret .= '            <expandinventory level="'.$levl.'"'.$stor."/>\n";
        
        unset ($levl,$name);
    }
    // toypetspawn
    $name = getTabTplsValue($key,'toy_pet_name');
    
    if ($name != "")
    {
        $ret .= '            <toypetspawn npcid="'.getNpcNameId($name).'"/>'."\n";
    }
    unset($name);
    
    // craftlearn
    $info = getTabTplsValue($key,'craft_recipe_info');
    
    if ($info != "")
    {
        $ret .= '            <craftlearn recipeid="'.getRecipeNameId($info).'"/>'."\n";
    }
    unset($info);
    
	// 165000001 - extraction tool
    if ($key == "165000001")
        $ret .= '            <extract/>'."\n";
            
	// 169100000, 169110000 - dye removers
    if ($key == "169100000" || $key == "169110000")
        $ret .= '            <dye color="no"/>'."\n";
        
    // dye
    $dcol = getTabTplsValue($key,'dyeing_color');
    $cols = array();
    $mins = getTabTplsValue($key,'cash_available_minute');
    $stench = "";
    
    if ($dcol != "")
    {
        $cols = explode(",",$dcol);
        $ret .= '            <dye color="';
        
        for ($c=0;$c<3;$c++)
        {
            $ret .= sprintf("%02x",$cols[$c]);
        }
        $ret .= '"';
        if ($mins != "")
            $ret .= ' minutes="'.$mins.'"';
            
        $ret .= "/>\n";
    }
    unset($dcol,$cols,$mins);
    
    // enchant / stenchant
    $name = getTabTplsValue($key,'name');
    $many = getTabTplsValue($key,'sub_enchant_material_many');
    $effe = getTabTplsValue($key,'sub_enchant_material_effect');
    
    if ((($many != "" && $many != "0")
      || ($effe != "" && $effe != "0"))
    &&  stripos($name,'matter_2stenchant_') === false)
    {
        $ret .= '            <enchant';
        
        if ($many != "" && $many != "0")  $ret .= ' count="'.$many.'"';
        if ($effe != "")  
        {
            $effe = $effe / 10;
            if (stripos($effe,".") === false)
                $effe .= ".0";
            $ret .= ' chance="'.$effe.'"';
        }
        
        if (isset($tabTpls[$key]['target_item_level_min']))
            $ret .= ' min_level="'.getTabTplsValue($key,'target_item_level_min').'"';
        
        if (isset($tabTpls[$key]['target_item_level_max']))
            $ret .= ' max_level="'.getTabTplsValue($key,'target_item_level_max').'"';
        
        if (isset($tabTpls[$key]['sub_enchant_material_effect_type']))
        {
            $prob = getTabTplsValue($key,'sub_enchant_material_effect_type');
            if (strtolower(substr($prob,-16)) == "cash_option_prob")
                $ret .= ' manastone_only="true"';
            unset($prob);
        }
        $ret .= "/>\n";
    }
    else
    {
        // stenchant (abgeleitet aus der XSD, da bisher wohl nicht genutzt)
        if (stripos($name,"matter_2stenchant_") !== false)
        {
            $stench .= '            <stenchant';
            
            if ($many != "" && $many != "0")  $stench .= ' count="'.$many.'"';
            
            $stench .= '/>'."\n";
        }
    }
    unset($many,$effe,$name);
    
    // skilluse
    $skill = getTabTplsValue($key,'activation_skill');
    $level = getTabTplsValue($key,'activation_level');
    $sktxt = getSkillNameId($skill);
    
    if ($skill != "")
    {                
        $ret = '            <skilluse';
        
        if ($level != "" && $level != "0")
            $ret .= ' level="'.$level.'"';
            
        $ret .= ' skillid="'.$sktxt.'"/>'."\n";
        
    }
    unset($skill,$level,$sktxt);
    
    // queststart
    $name = getTabTplsValue($key,'motion_name');
    $area = getTabTplsValue($key,'area_to_use');
    
    if ($name == "" && $area == "")
    {
        $targ  = getTabTplsValue($key,'activate_target');
        $name  = getTabTplsValue($key,'name');
        $quest = getTabTplsValue($key,'quest');
        
        if ($targ != "" && $quest != "")
        {
            if (strtolower($targ) == "standalone"
            &&  stripos($name,"quest_") !== false
            &&  $quest == 3)
            {
                $qid  = preg_replace("/\D+/","",$name);
                
                if ($qid != "")
                    $ret .= '            <queststart questid="'.$qid.'"/>'."\n";
            }            
        }
        unset($targ,$name,$quest);
    }
    unset($name,$area);
    
    // read
    if (isset($tabTpls[$key]['doc_bg']))
        $ret .= '            <read/>'."\n";
        
    // skilllearn
    $skill = getTabTplsValue($key,'skill_to_learn');
    $class = getSkillClassName($key);
    
    if ($class == "all")
        $level = getTabTplsValue($key,"ranger");
    else
        $level = getTabTplsValue($key,$class);
        
    if ($skill != "" && $class != "" && $level != "")
    {
        $ret .= '            <skilllearn skillid="'.getSkillNameId($skill).'"'.
                ' class="'.getClassName($class).'" level="'.$level.'"/>'."\n";
    }
    unset($skill,$class,$level);
                
    // <stenchant>, wenn sonst nichts in den actions war und stenchant gesetzt ist
    if ($ret == "" && $stench != "")
        $ret = $stench;
        
    // Rückgabe
    if ($ret != "")
        $ret = '        <actions>'."\n".$ret.'        </actions>';
            
    return $ret;
}
// ----------------------------------------------------------------------------
// Ausgabezeilen aufbereiten zu: godstone 
// ----------------------------------------------------------------------------
function getGodstoneLines($key)
{
    global $tabTpls;
    
    $ret = "";
    
    if (isset($tabTpls[$key]['proc_enchant_skill']))
    {
        $ret = '        <godstone skillid="'.getSkillNameId($tabTpls[$key]['proc_enchant_skill']).'"';
        
        if (isset($tabTpls[$key]['proc_enchant_skill_level']))
            $ret .= ' skilllvl="'.$tabTpls[$key]['proc_enchant_skill_level'].'"';
            
        if (isset($tabTpls[$key]['proc_enchant_effect_occur_prob']))
            $ret .= ' probability="'.$tabTpls[$key]['proc_enchant_effect_occur_prob'].'"';
            
        if (isset($tabTpls[$key]['proc_enchant_effect_occur_left_prob']))
            $ret .= ' probabilityleft="'.$tabTpls[$key]['proc_enchant_effect_occur_left_prob'].'"';
        else
            $ret .= ' probabilityleft="0"';
            
        $ret .= '/>';        
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Ausgabezeilen aufbereiten zu: stigma 
// ----------------------------------------------------------------------------
function getStigmaLines($key)
{
    global $tabTpls;
    
    $ret = "";
    $logkey = "";
    
    // gültig ab Client-Version 4.8
    $desc  = isset($tabTpls[$key]['desc'])      ? strtoupper($tabTpls[$key]['desc'])      : "";
    $icon  = isset($tabTpls[$key]['icon_name']) ? strtolower($tabTpls[$key]['icon_name']) : "";
    
    // beschädigte (broken) Stigma-Items ignorieren, da nicht mehr nutzbar
    // if (stripos($icon,"_broken_") !== false)
    //    return $ret;    
        
    if ($desc != "" 
    && (substr($desc,0,10) == "STR_STIGMA"  
     || substr($desc,0, 7) == "STIGMA_"
     || substr($desc,0,15) == "STR_ITEM_STIGMA")
    &&  stripos($desc,"SHARD")   === false)
    // &&  stripos($desc,"SUMMON")  === false)
    {    
        if ($key == $logkey) echo "\n<br>(1) $key = $desc"; 
        
        $kinah = isset($tabTpls[$key]['price']) ? $tabTpls[$key]['price'] : "";
        
        // 1. Versuch: Skill aus dem DESC-Namen ableiten (gültig für alle Namen)!
        if     (substr($desc,0, 9) == "STR_ITEM_")       $desc = substr($desc, 9);
        elseif (substr($desc,0,14) == "STR_STIGMA_FI_")  $desc = substr($desc,14);
        elseif (substr($desc,0,14) == "STR_STIGMA_KN_")  $desc = substr($desc,14);
        elseif (substr($desc,0,14) == "STR_STIGMA_RA_")  $desc = substr($desc,14);
        elseif (substr($desc,0,14) == "STR_STIGMA_AS_")  $desc = substr($desc,14);
        elseif (substr($desc,0,14) == "STR_STIGMA_PR_")  $desc = substr($desc,14);
        elseif (substr($desc,0,14) == "STR_STIGMA_CH_")  $desc = substr($desc,14);
        elseif (substr($desc,0,14) == "STR_STIGMA_WI_")  $desc = substr($desc,14);
        elseif (substr($desc,0,14) == "STR_STIGMA_EL_")  $desc = substr($desc,14);
        elseif (substr($desc,0,14) == "STR_STIGMA_PR_")  $desc = substr($desc,14);
        elseif (substr($desc,0,13) == "STR_STIGMA_N_")   $desc = substr($desc,13);
        elseif (substr($desc,0,14) == "STR_STIGMA_NE_")  $desc = substr($desc,14);
        
        $skill = getSkillNameId($desc);        
        
        if ($key == $logkey) echo "\n<br>(2) $key = '$desc' / '$skill'"; 
        
        // 2. Versuch: Sonder-Nachbehandlung (nur einige Namen)
        if ($skill == $desc)
        {
            $skill = "";
            
            if     (substr($desc,0, 9) == "RA_LIGHT_")       $desc = substr($desc,9);
            elseif (substr($desc,0, 8) == "RA_DARK_")        $desc = substr($desc,8);
            elseif (substr($desc,-5)   == "_PROC")           $desc = substr($desc,0,strlen($desc)-5);
            elseif (substr($desc,0, 9) == "FI_WA_GAT")       $desc = substr($desc,3);
            elseif (substr($desc,0,11) == "FI_DRAINCUT")     $desc = "FI_STIGMA".substr($desc,2);
            elseif (substr($desc,0,12) == "FI_ANKLESNAT")    $desc = str_replace("SNATCHER","GRAB",$desc); 
            elseif (substr($desc,0,11) == "KN_RESISTAR")     $desc = "KN_STIGMA".substr($desc,2);
            elseif (substr($desc,0,11) == "AS_SHADOWWA")     $desc = "AS_STIGMA".substr($desc,2);
            elseif (substr($desc,0,11) == "RA_SC_TRUES")     $desc = substr($desc,3);
            elseif (substr($desc,0,11) == "WI_ICYVEINS")     $desc = "WI_DARK".substr($desc,2);
            elseif (substr($desc,0,11) == "WI_ICELANCE")     $desc = "WI_STIGMA".substr($desc,2);
            elseif (substr($desc,0,15) == "EL_ORDER_DESTRU") $desc = "EL_STIGMA".substr($desc,2);
            elseif (substr($desc,0,15) == "EL_ORDER_ETHERE") $desc = "EL_STIGMA".substr($desc,2);
            elseif (substr($desc,0,11) == "EL_STORMBLA")     $desc = "EL_STIGMA".substr($desc,2);
            elseif (substr($desc,0,11) == "CH_HARSHTHR")     $desc = str_replace("THRUST_","THRUST_1_",$desc);
        }
        
        // für die veralteten Stigmen (broken), die nicht mehr nutzbar sind, wird
        // kein SKILL erzeugt
        if (stripos($icon,"broken") !== false)
            $skill = "";
        else
        {
            if ($key == $logkey) echo "\n<br>(3) $key = $desc"; 
            
            $skill = getSkillNameId($desc); 
            
            if ($skill == $desc)
            {
                $skill = "";
            }
        }
        // Besonderheiten zu einigen Stigmen!
        if ($skill == 539)  $skill = "539 1:749";  // WHIRLRAIN oder WHIRLTORNADO nutzbar
            
        // wenn beides vorhanden, dann Zeile aufbereiten!
        if ($kinah != "" && $skill != "")
        {
            $ret = '        <stigma kinah="'.$kinah.'" skill="1:'.$skill.'"/>';
        }
        else
        {
            if ($kinah != ""  &&  stripos($icon,"broken") !== false)
                $ret .= '        <stigma kinah="'.$kinah.'"/>  <!-- broken stigma -->';
        }
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Ausgabezeilen aufbereiten zu: weaponstat 
// ----------------------------------------------------------------------------
function getWeaponStatLines($key)
{
    global $tabTpls;
    
    $ret = "";
    
    $mindmg = isset($tabTpls[$key]['min_damage'])           ? $tabTpls[$key]['min_damage']           : "";
    $maxdmg = isset($tabTpls[$key]['max_damage'])           ? $tabTpls[$key]['max_damage']           : "";
    $attdel = isset($tabTpls[$key]['attack_delay'])         ? $tabTpls[$key]['attack_delay']         : "";
    $critic = isset($tabTpls[$key]['critical'])             ? $tabTpls[$key]['critical']             : "";
    $hitacc = isset($tabTpls[$key]['hit_accuracy'])         ? $tabTpls[$key]['hit_accuracy']         : "";
    $parry  = isset($tabTpls[$key]['parry'])                ? $tabTpls[$key]['parry']                : "";
    $magacc = isset($tabTpls[$key]['magical_hit_accuracy']) ? $tabTpls[$key]['magical_hit_accuracy'] : "";
    $magboo = isset($tabTpls[$key]['magical_skill_boost'])  ? $tabTpls[$key]['magical_skill_boost']  : "";
    $arange = isset($tabTpls[$key]['attack_range'])         ? $tabTpls[$key]['attack_range']         : "";
    $hcount = isset($tabTpls[$key]['hit_count'])            ? $tabTpls[$key]['hit_count']            : "";
    $redmax = isset($tabTpls[$key]['reduce_max'])           ? $tabTpls[$key]['reduce_max']           : "";
    
    // es muss mindestens einer der Werte gesetzt sein!
    if ($mindmg != "" || $maxdmg != "" || $attdel != "" 
    ||  $critic != "" || $hitacc != "" || $parry  != "" 
    ||  $magacc != "" || $magboo != "" || $arange != "" 
    ||  $hcount != "" || $redmax != "")
    {
        $ret = "";
        
        if ($mindmg != "" && $mindmg != "0")  $ret .= ' min_damage="'.$mindmg.'"';
        if ($maxdmg != "" && $maxdmg != "0")  $ret .= ' max_damage="'.$maxdmg.'"';
        if ($attdel != "" && $attdel != "0")  $ret .= ' attack_speed="'.$attdel.'"';
        if ($critic != "" && $critic != "0")  $ret .= ' physical_critical="'.$critic.'"';
        if ($hitacc != "" && $hitacc != "0")  $ret .= ' physical_accuracy="'.$hitacc.'"';
        if ($parry  != "" && $parry  != "0")  $ret .= ' parry="'.$parry.'"';
        if ($magacc != "" && $magacc != "0")  $ret .= ' magical_accuracy="'.$magacc.'"';
        if ($magboo != "" && $magboo != "0")  $ret .= ' boost_magical_skill="'.$magboo.'"';
        if ($arange != "" && $arange != "0")  $ret .= ' attack_range="'.intval($arange * 1000).'"';
        if ($hcount != "" && $hcount != "0")  $ret .= ' hit_count="'.$hcount.'"';
        if ($redmax != "" && $redmax != "0")  $ret .= ' reduce_max="'.$redmax.'"';
        
        if ($ret != "")
            $ret  = '        <weapon_stats'.$ret.'/>';
    }    
    return $ret;
}
// ----------------------------------------------------------------------------
// Ausgabezeilen aufbereiten zu: tradein_list 
// ----------------------------------------------------------------------------
function getTradeInLines($key)
{
    global $tabTpls;
    
    $ret = "";
    
    if (isset($tabTpls[$key]['trade_in_item']))
    {
        $domax = $tabTpls[$key]['trade_in_item'];
        $apprice = "";
        
        if (isset($tabTpls[$key]['trade_in_abyss_point']))  
            $apprice .= ' ap="'.$tabTpls[$key]['trade_in_abyss_point'].'"';
        if (isset($tabTpls[$key]['trade_in_price']))         
            $apprice .= ' price="'.$tabTpls[$key]['trade_in_price'].'"';            
        
        $ret   = '        <tradein_list'.$apprice.'>'."\n";
        
        for ($t=1;$t<=$domax;$t++)
        {
            $ret .= '            <tradein_item id="'.getClientItemId($tabTpls[$key]['trade_in_item'.$t]).'"'.
                    ' price="'.$tabTpls[$key]['trade_in_item_count'.$t].'"/>'."\n";
        }
        
        $ret  .= '        </tradein_list>';
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Ausgabezeilen aufbereiten zu: acquisition 
// ----------------------------------------------------------------------------
function getAcquisitionLines($key)
{
    global $tabTpls;
    
    $ret = "";
    
    // acqusition-Type: REWARD    
    if (isset($tabTpls[$key]['extra_currency_item']))
    {
        $item  = $tabTpls[$key]['extra_currency_item'];
        $count = isset($tabTpls[$key]['extra_currency_item_count']) ? $tabTpls[$key]['extra_currency_item_count'] : "";
        $ap    = isset($tabTpls[$key]['abyss_point'])               ? $tabTpls[$key]['abyss_point']               : "";
        
        $ret  .= '        <acquisition type="REWARD"';
        if ($count != "") $ret .= ' count="'.$count.'"';
        if ($item  != "") $ret .= ' item="'.getClientItemId($item).'"';
        if ($ap    != "") $ret .= ' ap="'.$ap.'"';   
        $ret  .= '/>'."\n";       
    }
    
    // acqusition-Type: AP    
    $item  = isset($tabTpls[$key]['abyss_item'])       ? $tabTpls[$key]['abyss_item']       : "";
    $count = isset($tabTpls[$key]['abyss_item_count']) ? $tabTpls[$key]['abyss_item_count'] : "";
    $point = isset($tabTpls[$key]['abyss_point'])      ? $tabTpls[$key]['abyss_point']      : "";
    
    if (!isset($tabTpls[$key]['extra_currency_item']) && $item == "" && $count == "" && $point != "")
    {
        $ret .= '        <acquisition type="AP" ap="'.$point.'"/>'."\n";        
    }
    
    // acquisition-Type: ABYSS
    if ($item != "" && $count != "" && $point != "")
    {
        $ret .= '        <acquisition type="ABYSS" count="'.$count.'" item="'.getClientItemId($item).'"'.
                ' ap="'.$point.'"/>'."\n";
    }
    unset($itme,$count,$point);
    
    // acqusition-Type: COUPON
    if (isset($tabTpls[$key]['coupon_item']))
    {
        $item  = $tabTpls[$key]['coupon_item'];
        $count = isset($tabTpls[$key]['coupon_item_count']) ? $tabTpls[$key]['coupon_item_count'] : "";
                
        $ret  .= '        <acquisition type="COUPON"';
        if ($count != "") $ret .= ' count="'.$count.'"';
        if ($item  != "") $ret .= ' item="'.getClientItemId($item).'"';
        $ret  .= '/>'."\n";       
    }
    
    return $ret;
}
// ----------------------------------------------------------------------------
// Ausgabezeilen aufbereiten zu: disposition 
// ----------------------------------------------------------------------------
function getDispositionLines($key)
{
    global $tabTpls;
    
    $ret = "";
    
    $itemid = isset($tabTpls[$key]['disposable_trade_item']) ? $tabTpls[$key]['disposable_trade_item'] : "";
    $itmcnt = isset($tabTpls[$key]['disposable_trade_item_count']) ? $tabTpls[$key]['disposable_trade_item_count'] : "";
    
    if ($itemid != "" || $itmcnt != "")
    {
        $ret = '        <disposition';
        
        if ($itemid != "") $ret .= ' id="'.getClientItemId($itemid).'"';
        if ($itmcnt != "") $ret .= ' count="'.$itmcnt.'"';
        
        $ret .= '/>';
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Ausgabezeilen aufbereiten zu: improve 
// ----------------------------------------------------------------------------
function getImproveLines($key)
{
    global $tabTpls;
    
    $ret = "";
    
    if (isset($tabTpls[$key]['charge_way']))
    {
        $ret = '        <improve way="'.$tabTpls[$key]['charge_way'].'"';
        
        if (isset($tabTpls[$key]['charge_level']))
            $ret .= ' level="'.$tabTpls[$key]['charge_level'].'"';
        if (isset($tabTpls[$key]['burn_on_attack']))
            $ret .= ' burn_attack="'.$tabTpls[$key]['burn_on_attack'].'"';
        if (isset($tabTpls[$key]['burn_on_defend']))
            $ret .= ' burn_defend="'.$tabTpls[$key]['burn_on_defend'].'"';
        if (isset($tabTpls[$key]['charge_price1']))
            $ret .= ' price1="'.intval($tabTpls[$key]['charge_price1'] * 1000000).'"';
        if (isset($tabTpls[$key]['charge_price2']))
            $ret .= ' price2="'.intval($tabTpls[$key]['charge_price2'] * 1000000).'"';
        $ret .= '/>';
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Ausgabezeilen aufbereiten zu: uselimits 
// ----------------------------------------------------------------------------
function getUseLimitLines($key)
{
    global $tabTpls;
    
    $ret     = "";
    $world   = "";
    $oship   = isset($tabTpls[$key]['ownership_world'])       ? $tabTpls[$key]['ownership_world']        : "";
    $guild   = isset($tabTpls[$key]['guild_level_permitted']) ? $tabTpls[$key]['guild_level_permitted']  : "";
    $area    = isset($tabTpls[$key]['area_to_use'])           ? $tabTpls[$key]['area_to_use']            : "";
    $delay   = isset($tabTpls[$key]['use_delay'])             ? $tabTpls[$key]['use_delay']              : "";
    $dtype   = isset($tabTpls[$key]['use_delay_type_id'])     ? $tabTpls[$key]['use_delay_type_id']      : "";
    $rkmax   = isset($tabTpls[$key]['usable_rank_max'])       ? $tabTpls[$key]['usable_rank_max']        : "";
    $rkmin   = isset($tabTpls[$key]['usable_rank_min'])       ? $tabTpls[$key]['usable_rank_min']        : "";
    $gender  = isset($tabTpls[$key]['gender_permitted'])      ? $tabTpls[$key]['gender_permitted']       : "";
    $uride   = isset($tabTpls[$key]['ride_usable'])           ? $tabTpls[$key]['ride_usable']            : "";
        
    if ($oship != "" || $guild != "" || $area   != "" 
    ||  $delay != "" || $dtype != "" || $rkmax  != "" 
    ||  $rkmin != "" || $uride != "" || $gender != "")
    {        
        if (strtoupper($gender) != "ALL")
            $ret .= ' gender="'.strtoupper($gender).'"';
            
        // WorldId zu OwnerShip-World umsetzen und ermitteln
        if ($oship != "")
        {
            // Achtung: die anderen abweichenden IDs sind in 4.8 nicht mehr existent
            //          (hier hat GF wohl schlampig gearbeitet, sind die Items noch OK???)
            if ($oship == "IDLDF4RE_01_L") $oship = "IDLDF4RE_01"; 
            
            $world = getWorldNameId($oship);         
        }
        
        if ($rkmin != "")    $ret .= ' rank_min="'.$rkmin.'"';
        if ($rkmax != "")    $ret .= ' rank_max="'.$rkmax.'"';
        if ($delay != ""
        &&  $delay != "0")   $ret .= ' usedelay="'.$delay.'"';
        if ($dtype != "")    $ret .= ' usedelayid="'.$dtype.'"';
        if ($uride != "")    $ret .= ' ride_usable="'.($uride == "0" ? "false" : "true").'"';
        if ($area  != "")    $ret .= ' usearea="'.strtoupper($area).'"';
        if ($world != "")    $ret .= ' ownership_world="'.$world.'"';
        if ($guild != "")    $ret .= ' guild_level="'.$guild.'"';
        
        if ($ret != "")      $ret  = '        <uselimits'.$ret.'/>';
    }
    
    return $ret;
}
// ----------------------------------------------------------------------------
// Ausgabezeilen aufbereiten zu: inventory 
// ----------------------------------------------------------------------------
function getInventoryLines($key)
{
    global $tabTpls;
    
    $ret = "";
    
    if (isset($tabTpls[$key]['extra_inventory']))
    {
        if ($tabTpls[$key]['extra_inventory'] != ""
        &&  $tabTpls[$key]['extra_inventory'] != "0")
            $ret = '        <inventory id="'.$tabTpls[$key]['extra_inventory'].'"/>';
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Ausgabezeilen aufbereiten zu: idian 
// ----------------------------------------------------------------------------
function getIdianLines($key)
{
    global $tabTpls;
    
    $ret = "";
        
    $attack = isset($tabTpls[$key]['polish_burn_on_attack']) ? $tabTpls[$key]['polish_burn_on_attack'] : "";    
    $defend = isset($tabTpls[$key]['polish_burn_on_defend']) ? $tabTpls[$key]['polish_burn_on_defend'] : "";
    
    if ($attack != "" || $defend != "")
    {
        $ret = '        <idian';
        
        if ($attack != "")   $ret .= ' burn_attack="'.$attack.'"';
        if ($defend != "")   $ret .= ' burn_defend="'.$defend.'"';
        
        $ret .= '/>';
    }
    return $ret;
}