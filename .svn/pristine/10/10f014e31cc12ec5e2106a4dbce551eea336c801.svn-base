<?PHP
// ----------------------------------------------------------------------------
// Modul  : inc_itemattrs.php                                           ENCHANT
// Version: 01.00, Mariella 02/2016
// Zweck  : definiert Vorgaben für die Item-Attribut-Namen-Umsetzung, die
//          Typen-Namen und Funktionen zur Ermittlung dieser Namen / Typen
// Hinweis: NUR FÜR DIE Item-Enchant-Attribute
// siehe  : inc_bonusattr.php  für die Random-Bonus-Attribut-Namen
// ----------------------------------------------------------------------------
      
$tabitemattrs  = array( 
                        "ARBLEED" => "BLEED_RESISTANCE",
                        "ARBLIND" => "BLIND_RESISTANCE",
                        "ARCHARM" => "CHARM_RESISTANCE",
                        "ARCONFUSE" => "CONFUSE_RESISTANCE",
                        "ARCURSE" => "CURSE_RESISTANCE",
                        "ARDISEASE" => "DISEASE_RESISTANCE",
                        "ARFEAR" => "FEAR_RESISTANCE",
                        "AROPENAREIAL" => "OPENAREIAL_RESISTANCE",
                        "ARPARALYZE" => "PARALYZE_RESISTANCE",
                        "ARPERIFICATION" => "PERIFICATION_RESISTANCE",
                        "ARPOISON" => "POISON_RESISTANCE",
                        "ARROOT" => "ROOT_RESISTANCE",
                        "ARSILENCE" => "SILENCE_RESISTANCE",
                        "ARSLEEP" => "SLEEP_RESISTANCE",
                        "ARSLOW" => "SLOW_RESISTANCE",
                        "ARSNARE" => "SNARE_RESISTANCE",
                        "ARSPIN" => "SPIN_RESISTANCE",
                        "ARSTAGGER" => "STAGGER_RESISTANCE",
                        "ARSTUMBLE" => "STUMBLE_RESISTANCE",
                        "ARSTUN" => "STUN_RESISTANCE",                        
                        "ATTACK_DELAY" => "ATTACK_SPEED",
                        "ATTACK_SPEED" => "ATTACK_SPEED",
                        "BLEED_ARP" => "BLEED_RESISTANCE_PENETRATION",
                        "BLIND_ARP" => "BLIND_RESISTANCE_PENETRATION",
                        "BLOCK" => "BLOCK",
                        "BOOST_CASTING_TIME" => "BOOST_CASTING_TIME",
                        "BOOSTHATE" => "BOOST_HATE",
                        "CHARM_ARP" => "CHARM_RESISTANCE_PENETRATION",
                        "CONFUSE_ARP" => "CONFUSE_RESISTANCE_PENETRATION",
                        "CRITICAL_MAGICAL" => "MAGICAL_CRITICAL",
                        "CRITICAL_PHYSICAL" => "PHYSICAL_CRITICAL",
                        "CURSE_ARP" => "CURSE_RESISTANCE_PENETRATION",
                        "DAMAGE_MAGICAL" => "MAGICAL_ATTACK",
                        "DAMAGE_PHYSICAL" => "PHYSICAL_ATTACK",
                        "DAMAGE_REDUCE" => "DAMAGE_REDUCE",
                        "DISEASE_ARP" => "DISEASE_RESISTANCE_PENETRATION",
                        "DODGE" => "EVASION",
                        "FEAR_ARP" => "FEAR_RESISTANCE_PENETRATION",
                        "FLY_SPEED" => "FLY_SPEED",
                        "HEAL_SKILL_BOOST" => "HEAL_BOOST",
                        "HIT_ACCURACY" => "PHYSICAL_ACCURACY",
                        "MAGICAL_CRITICAL_REDUCE_RATE" => "MAGICAL_CRITICAL_RESIST",
                        "MAGICAL_CRITICAL_DAMAGE_REDUCE" => "MAGICAL_CRITICAL_DAMAGE_REDUCE",
                        "MAGICAL_DEFEND" => "MAGICAL_DEFEND",
                        "MAGICAL_HIT_ACCURACY" => "MAGICAL_ACCURACY",
                        "MAGICAL_RESIST" => "MAGICAL_RESIST",
                        "MAGICAL_SKILL_BOOST" => "BOOST_MAGICAL_SKILL",
                        "MAGICAL_SKILL_BOOST_RESIST" => "MAGIC_SKILL_BOOST_RESIST",
                        "MAX_FP" => "FLY_TIME",
                        "MAX_HP" => "MAXHP",
                        "MAX_MP" => "MAXMP",
                        "OPENAREIAL_ARP" => "OPENAREIAL_RESISTANCE_PENETRATION",
                        "PARALYZE_ARP" => "PARALYZE_RESISTANCE_PENETRATION",
                        "PARRY" => "PARRY",
                        "PERIFICATION_ARP" => "PERIFICATION_RESISTANCE_PENETRATION",
                        "PHYSICAL_CRITICAL_DAMAGE_REDUCE" => "PHYSICAL_CRITICAL_DAMAGE_REDUCE",
                        "PHYSICAL_CRITICAL_REDUCE_RATE" => "PHYSICAL_CRITICAL_RESIST",
                        "PHYSICAL_DEFEND" => "PHYSICAL_DEFENSE",
                        "POISON_ARP" => "POISON_RESISTANCE_PENETRATION",
                        "PROCREDUCERATE" => "PROC_REDUCE_RATE",
                        "PVPATTACKRATIO_MAGICAL" => "PVP_ATTACK_RATIO_MAGICAL",
                        "PVPATTACKRATIO_PHYSICAL" => "PVP_ATTACK_RATIO_PHYSICAL",
                        "PVPBLOCK" => "PVP_BLOCK",
                        "PVPDEFENDRATIO_MAGICAL" => "PVP_DEFEND_RATIO_MAGICAL",
                        "PVPDEFENDRATIO_MAGICAL_O" => "PVP_DEFEND_RATIO_MAGICAL",
                        "PVPDEFENDRATIO_PHYSICAL" => "PVP_DEFEND_RATIO_PHYSICAL",
                        "PVPDEFENDRATIO_PHYSICAL_O" => "PVP_DEFEND_RATIO_PHYSICAL",
                        "PVPDODGE" => "PVP_DODGE",
                        "PVPHITACCURACY" => "PVP_HIT_ACCURACY",
                        "PVPPARRY" => "PVP_PARRY",
                        "PVPMAGICALHITACCURACY" => "PVP_MAGICAL_HIT_ACCURACY",
                        "PVPMAGICALRESIST" => "PVP_MAGICAL_RESIST",
                        "ROOT_ARP" => "ROOT_RESISTANCE_PENETRATION",
                        "SILENCE_ARP" => "SILENCE_RESISTANCE_PENETRATION",
                        "SLEEP_ARP" => "SLEEP_RESISTANCE_PENETRATION",
                        "SLOW_ARP" => "SLOW_RESISTANCE_PENETRATION",
                        "SNARE_ARP" => "SNARE_RESISTANCE_PENETRATION",
                        "SPEED" => "SPEED",
                        "SPIN_ARP" => "SPIN_RESISTANCE_PENETRATION",
                        "STAGGER_ARP" => "STAGGER_RESISTANCE_PENETRATION",
                        "STUMBLE_ARP" => "STUMBLE_RESISTANCE_PENETRATION",
                        "STUN_ARP" => "STUN_RESISTANCE_PENETRATION"
                      );  
$tabMissedItemAttr = array();
// ----------------------------------------------------------------------------
// Item-Attribut-Name ermitteln 
// Params:  $name       der im Client genutzte Attribut-Name
// return:  string      umgesetzter EMU-Name oder $name, wenn nicht gefunden
// ----------------------------------------------------------------------------
function getItemAttrName($name)
{
    global $tabitemattrs;
    
    $such = strtoupper($name);
    
    if (isset($tabitemattrs[$such]))
        return $tabitemattrs[$such];
    else
    {
        // bei vielen Namen wird die Endung "_O" nicht berücksichtigt!
        if (substr($such,-2,2) == "_O")
            $such = substr($such,0,strlen($such) - 2);
        else
            return $name;
            
        if (isset($tabitemattrs[$such]))
            return $tabitemattrs[$such];
        else
        {
            if (!isset($tabMissedItemAttr[$such]))
            {
                logLine("Item-Attribut-Name fehlt",$such);
                $tabMissedItemAttr[$such] = 1;
            }
            return $name;
        }
    }
}
// ----------------------------------------------------------------------------
// Typen-Namen-Text ermitteln
// Params:  $name       der im Client genutzte Typen-Name
// return:  string      kompletter, notwendigeer XML-Text
// ----------------------------------------------------------------------------
function getItemTypePartText($name)
{
    $xname = strtoupper($name);
    $xpart = "";
    
    // evtl. Namensumsetzung
    switch(strtoupper($name))
    {
        case "2HSWORD":
            $xname = "GREATSWORD"; 
            break;
        case "BOOK":
            $xname = "SPELLBOOK";
            break;
        case "TEST_OPTION01":
        case "TEST_OPTION02":
            $xname = "AUTHORIZE";
            break;
        default:
            break;
    }
    
    // Parts ermitteln
    if (stripos($xname,"_") !== false)
    {
        $parts = explode("_",$xname);
        
        switch($parts[0])
        {
            case "CH":       $xname = "CHAIN";     break;
            case "LT":       $xname = "LEATHER";   break;
            case "PL":       $xname = "PLATE";     break;
            case "RB":       $xname = "ROBE";      break;
            case "TSHIRT":   $xname = "PLUME";     break;
        }
        
        switch ($parts[1])
        {
            case "GLOVES":   $xpart = "GLOVES";    break;
            case "PANTS":    $xpart = "PANTS";     break;
            case "SHOES":    $xpart = "SHOES";     break;
            case "SHOULDER": $xpart = "SHOULDERS"; break;
            case "TORSO":    $xpart = "JACKET";    break;
        }
    }
    
    if ($xpart != "")
        return ' type="'.$xname.'" part="'.$xpart.'"';
    else
        return ' type="'.$xname.'"';
}
?>