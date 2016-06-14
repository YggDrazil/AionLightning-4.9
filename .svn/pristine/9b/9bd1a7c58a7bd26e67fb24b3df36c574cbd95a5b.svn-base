<html>
<head>
  <title>
    QuestFiles - Erzeugen der Quest-xml-Dateien
  </title>
  <link rel='stylesheet' type='text/css' href='../includes/aioneutools.css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.js"></script>
</head>
<?PHP
// ----------------------------------------------------------------------------
// Modul  : genQuest.php                                  
// Version: 01.00, Mariella 03/2016
// Zweck  : führt die Generierung der für die Quests notwendigen XML-Dateien
//          durch und erzeugt auch die hierfür notwendigen PHP-Includes.
// ----------------------------------------------------------------------------
  
include("../includes/inc_globals.php");

getConfData();

if (!file_exists("../outputs/parse_output/quest_data"))
    mkdir("../outputs/parse_output/quest_data");
if (!file_exists("../outputs/parse_output/quest_script_data"))
    mkdir("../outputs/parse_output/quest_script_data");

$submit   = isset($_GET['submit'])   ? "J" : "N";
?>
<body style="background-color:#000055;color:silver;padding:0px;">
<center>
<div id="body" style='width:800px;padding:0px;'>
  <div width="100%"><img src="../includes/aioneulogo.png" width="100%"></div>
  <div class="aktion">Erzeugen Quest-xml-Dateien</div>
  <div class="hinweis" id="hinw">
    Erzeugen der Quest-xml-Dateien.
  </div>
  <div width=100%>
<h1 style="color:orange">Bitte Generierung starten</h1>
<form name="edit" method="GET" action="genQuest.php" target="_self">
 <br>
 <table width="700px">
   <colgroup>
     <col style="width:200px">
     <col style="width:500px">
   </colgroup>
   <tr><td colspan=2>&nbsp;</td></tr>
<?php   
// ----------------------------------------------------------------------------
//
//                       H I L F S F U N K T I O N E N
////
// ----------------------------------------------------------------------------
// ermitteln Wert aus QuestTabelle
// ----------------------------------------------------------------------------
function getTabValue($key,$val,$def)
{
    global $tabQuests;

    if (isset($tabQuests[$key][$val]))
    {
        if ($tabQuests[$key][$val] == "")
            return $def;
        else
            return $tabQuests[$key][$val];
    }
    else
        return $def;
}
// ----------------------------------------------------------------------------
// ermitteln Name der Quest
// ----------------------------------------------------------------------------
function getQuestName($key)
{
    global $tabQuests, $tabQNames;
    
    $name = strtoupper( $tabQuests[$key]['desc'] );
    
    if (isset($tabQNames[$name]))
        return $tabQNames[$name]['body'];
    else
        return "???";
}
// ----------------------------------------------------------------------------
// ermitteln NameId der Quest-Task
// ----------------------------------------------------------------------------
function getTaskNameId($name)
{
    global $tabQNames;
    
    $name = strtoupper( $name );
    
    if (isset($tabQNames[$name]))
        return $tabQNames[$name]['id'];
    else
        return "???";
}
// ----------------------------------------------------------------------------
// ermitteln Name zur Quest-Msg-Id
// ----------------------------------------------------------------------------
function getQuestMsgId($msg)
{
    global $tabMsgIds;
    
    $name = strtoupper( $msg );
    
    if (isset($tabMsgIds[$name]))
        return $tabMsgIds[$name]['id'];
    else
        return getTaskNameId($msg);
}
// ----------------------------------------------------------------------------
// ermitteln Rasse zur Quest
// ----------------------------------------------------------------------------
function getQuestRace($key)
{
    global $tabQuests;
        
    if (isset($tabQuests[$key]['race_permitted']))
    {
        $race = strtoupper( $tabQuests[$key]['race_permitted'] );
        
        if     ($race == "PC_LIGHT")
            return "ELYOS";
        elseif ($race == "PC_DARK")
            return "ASMODIANS";
    }
    
    return "PC_ALL";
}
// ----------------------------------------------------------------------------
// ermitteln NameId der Quest
// ----------------------------------------------------------------------------
function getQuestNameId($key)
{
    global $tabQuests, $tabQNames;
    
    $name = strtoupper( $tabQuests[$key]['desc'] );
    
    if (isset($tabQNames[$name]))
        return $tabQNames[$name]['id'];
    else
        return "???";
}
// ----------------------------------------------------------------------------
// ermitteln Name der Quest
// merken Quest-Zone und QuestId in $tabQData
// ----------------------------------------------------------------------------
function getQuestCat($key)
{
    global $tabQuests, $tabQNames, $tabQData;
    
    if (isset($tabQuests[$key]['category2']))
    {
        $name = strtoupper( $tabQuests[$key]['category2'] );
        
        if (isset($tabQNames[$name]))
        {
            $fkey  = str_replace(" ","_",$tabQNames[$name]['body']);
            $fkey  = str_replace("_Quest","",$fkey);
            $fkey  = strtolower($fkey);
            
            $tabQData[$fkey][$key] = getQuestName($key); 
            return ' category_name="'.$tabQNames[$name]['body'].'"';
        }
        else
            return "";
    }
    else
        return "";
}
// ----------------------------------------------------------------------------
// ermitteln Skill zur Quest
// ----------------------------------------------------------------------------
function getQuestSkillPart($key)
{
    global $tabQuests;
    
    $skill = getTabValue($key,"combineskill","");
    $level = getTabValue($key,"combine_skillpoint","");
    $ret   = "";
    
    if (strtoupper($skill) != "ANY")
    {
        if ($skill != "")        $ret .= ' combineskill="'.getSkillNameId($skill).'"';
        if ($level != "")        $ret .= ' combine_skillpoint="'.$level.'"';
    }
    
    return $ret;
}
// ----------------------------------------------------------------------------
// ermitteln Faction zur Quest
// ----------------------------------------------------------------------------
function getQuestFactionPart($key)
{
    global $tabQuests, $tabNpcFacs;
    
    $fact = strtoupper(getTabValue($key,"npcfaction_name",""));
    $ret   = "";
    
    if ($fact != "")  
    {
        if (isset($tabNpcFacs[$fact]))
            $ret = ' npcfaction_id="'.$tabNpcFacs[$fact].'"';
        else
            $ret = ' npcfaction_id="-1"';
    }
    
    return $ret;
}
// ----------------------------------------------------------------------------
//
//        Z E I L E N A U F B E R E I T U N G S - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Rückgabe der Zeile für <quest...
// ----------------------------------------------------------------------------
function getQuestLine($key)
{
    global $tabQuests;
        
    $ret  = '    <quest id="'.$key.'"'.
            ' name="'.str_replace(",","",getQuestName($key)).'"'.
            getQuestCat($key).
            ' nameId="'.getQuestNameId($key).'"'.
            ' minlevel_permitted="'.$tabQuests[$key]['minlevel_permitted'].'"';
    
    $val  = getTabValue($key,"maxlevel_permitted","0");    
    if ($val != "0")         $ret .= ' maxlevel_permitted="'.$val.'"';
    
    $ret .= ' max_repeat_count="'.$tabQuests[$key]['max_repeat_count'].'"';

    $val  = getTabValue($key,"quest_repeat_cycle","");
    $val  = str_replace(","," ",$val);;
    $val  = str_replace("  "," ",$val);
    if ($val != "")          $ret .= ' repeat_cycle="'.strtoupper($val).'"';    

    $val  = getTabValue($key,"cannot_share","false");
    if ($val == "true")      $ret .= ' cannot_share="'.$val.'"';
    
    $val  = getTabValue($key,"cannot_giveup","false");
    if ($val == "true")      $ret .= ' cannot_giveup="'.$val.'"';
    
    $val  = getTabValue($key,"use_class_reward","0");
    if ($val != "0")         $ret .= ' use_class_reward="'.$val.'"';
    
    $ret .= ' race_permitted="'.getQuestRace($key).'"';
    
    $ret .= getQuestSkillPart($key);    

    $val  = getTabValue($key,"category1","");
    if ($val != "")          $ret .= ' category="'.strtoupper($val).'"';

    $ret .= getQuestFactionPart($key);

    $val  = getTabValue($key,"titles","");
    if ($val != "")          $ret .= ' titleid="'.$val.'"';
    
    $ret .= '>';
   
    return $ret;
}
// ----------------------------------------------------------------------------
// Rückgabe der Angaben für die Items gem. Typ
// ----------------------------------------------------------------------------
function getItemLine($typ,$xml)
{
    global $tabItems;
    
    if (count($tabItems) == 0)
        return "";
    
    $ret   = "";
    $indent= str_pad(" ",12);
    
    if ($xml == "*")
    {    
        $xml    = strtolower($typ."_selectable_reward");
        $indent = str_pad(" ",8);
    }
    
    reset($tabItems);
    
    while (list($ikey,$ival) = each($tabItems))
    {        
        $tab = explode(" ",$tabItems[$ikey]['nam']);
            
        // keine Bonus-Items zurückgeben
        if (substr($tab[0],0,1) != "%")
        {
            if (!isset($tab[1])) $tab[1] = 1;
            if ($tab[1] == "")   $tab[1] = 1;
            
            if ($tabItems[$ikey]['typ'] == $typ)
                $ret .= $indent.'<'.$xml.' item_id="'.
                        getClientItemId($tab[0]).'" count="'.$tab[1].'"/>'."\n";
        }
    }
    reset($tabItems);
    
    return $ret;
}
// ----------------------------------------------------------------------------
// Rückgabe der Zeile für <bonus
// ----------------------------------------------------------------------------
function getBonusLine()
{
    global $tabItems;
    
    if (count($tabItems) == 0)
        return "";
        /*
        public enum BonusType
	    {
		NONE = 0,
		BOSS,			// %Quest_L_boss; siege related?
		COIN,			// %Quest_L_coin (mage)
		                //				 (warrior)
		                // %Quest_L_coin (mage)
		                //				 (warrior)
		ENCHANT,
		FOOD,			// %Quest_L_food
		FORTRESS,		// %Quest_L_fortress; sends promotion mails with medals?
		GODSTONE,
		GOODS,			// %Quest_L_Goods
		ISLAND,			// %Quest_L_3_island; siege related?
		MAGICAL,		// %Quest_L_magical
		MANASTONE,		// %Quest_L_matter_option
		MASTER_RECIPE,	// %Quest_ta_l_master_recipe
		MATERIAL,		// %Quest_L_material
		MEDAL,			// %Quest_L_medal
		MEDICINE,		// %Quest_L_medicine; potions and remedies
		MOVIE,			// %Quest_L_Christmas; cut scenes
		RECIPE,			// %Quest_L_Recipe
		REDEEM,			// %Quest_L_Rnd_Redeem and %Quest_L_redeem
		TASK,			// %Quest_L_task; craft related
        }
        */
    
    $tabBonus = array(
                  array("QUEST_L_BOSS"         ,"BOSS"),
                  array("QUEST_L_COIN"         ,"COIN"),
                  array("QUEST_L_ENCHANT"      ,"ENCHANT"),
                  array("QUEST_L_FOOD"         ,"FOOD"),
                  array("QUEST_L_FORTRESS"     ,"FORTRESS"),
                  array("QUEST_L_GATHER"       ,"GATHER"),
                  array("QUEST_L_GOODS"        ,"GOODS"),
                  array("QUEST_L_3_ISLAND"     ,"ISLAND"),
                  array("QUEST_L_LUNAR"        ,"LUNAR"),
                  array("QUEST_L_MAGICAL"      ,"MAGICAL"),
                  array("MANASTONE"            ,"QUEST_L_MATTER"),
                  array("QUEST_TA_L_MASTER_RECIPE","MASTER_RECIPE"),
                  array("QUEST_L_MATERIAL"     ,"MATERIAL"),
                  array("QUEST_L_MEDAL"        ,"MEDAL"),
                  array("QUEST_MEDAL"          ,"MEDAL"),
                  array("QUEST_L_MEDICINE"     ,"MEDICINE"),
                  array("QUEST_L_CHRISTMAS"    ,"MOVIE"),
                  array("QUEST_L_RECIPE"       ,"RECIPE"),
                  array("QUEST_L_REDEEM"       ,"REDEEM"),
                  array("QUEST_L_RND_REDEEM"   ,"REDEEM"),
                  array("QUEST_L_RIFT"         ,"RIFT"),
                  array("QUEST_L_TASK"         ,"TASK"),
                );
    $maxBonus = count($tabBonus);
    $ret      = "";
    
    reset($tabItems);
    
    while (list($ikey,$ival) = each($tabItems))
    {
        for ($b=0;$b<$maxBonus;$b++)
        {
            if ($tabItems[$ikey]['typ'] == "BONUS")
            {                
                $btyp = "";
                $blev = "";  
                $lang = strlen($tabBonus[$b][0]);                 
                $bnam = strtoupper(substr($tabItems[$ikey]['nam'],1));
                
                if     (substr($bnam,0,$lang) == $tabBonus[$b][0])
                {
                    $btyp = $tabBonus[$b][1];
                    $blev = substr($bnam,$lang + 1);
                    
                    if     (stripos($blev,"_") !== false)
                        $blev = substr($blev,0,stripos($blev,"_"));
                    if     (stripos($blev," ") !== false)
                        $blev = substr($blev,0,stripos($blev," "));
                        
                    $blev = filter_var($blev,FILTER_SANITIZE_NUMBER_INT);
                    $blev = ($blev == "") ? "0" : $blev;
                    
                    $ret .= '        <bonus level="'.$blev.'" type="'.$btyp.'"/>'."\n";
                    $b    = $maxBonus;
                }    
            }
        }
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Rückgabe der Zeile für <quest_drop
// ----------------------------------------------------------------------------
function getDropLine($key)
{
    global $tabQuests;
    
    $step  = getTabValue($key,"collect_progress",0);    
    $xstep = ($step >= 1) ? ' collecting_step="'.$step.'"' : "";    
    $ret   = "";
    
    for ($d=0;$d<5;$d++)
    {
        $xkey = "drop_item_".$d;
        
        if (isset($tabQuests[$key][$xkey]))
        {
            $item  = trim(getTabValue($key,$xkey,""));
            $npcs  = getTabValue($key,"drop_monster_".$d,"");
            $proz  = getTabValue($key,"drop_prob_".$d,"100");
            $each  = getTabValue($key,"drop_each_member_".$d,"");
            
            $tnpc  = explode(" ",trim($npcs));
            $maxn  = count($tnpc);
            
            for ($n=0;$n<$maxn;$n++)
            {                
                $tabnpc = getNpcIdNameTab($tnpc[$n]);
                
                $ret .= '        <quest_drop npc_id="'.$tabnpc['npcid'].'"'.
                        ' item_id="'.getClientItemId($item).'"';
                if ($proz > 0 && $proz < 100)
                    $ret .= ' chance="'.$proz.'"';
                if ($each == 1)
                    $ret .= ' drop_each_member="1"';
                $ret .= $xstep."/>\n";
            }
        }
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Rückgabe der Zeile für <quest_kill
// ----------------------------------------------------------------------------
function getKillLine($key)
{
    global $tabMonster;
    
    $ret = "";
    
    if (isset($tabMonster[$key]))
    {
        reset($tabMonster);
        
        while (list($skey,$sval) = each($tabMonster[$key]))
        {
            $ret .= '        <quest_kill npc_ids="'.$sval.'" seq="'.$skey.'"/>'."\n";
        }
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Rückgabe der Zeile für <start_conditions
// ----------------------------------------------------------------------------
function getStartLine($key)
{
    global $tabQuests;
    
    $tabCond = array(
                 array("finished_quest_cond","finished","Q"),
                 array("unfinished_quest_cond","unfinished","X"),
                 array("noacquired_quest_cond","noacquired","X"),
                 array("acquired_quest_cond","acquired","X"),
                 array("equiped_item_name","equipped","I")
               );
    $maxCond = count($tabCond);
    $ret     = "";
    
    for ($i=0;$i<7;$i++)
    {
        $cond    = "";
        
        for ($c=0;$c<$maxCond;$c++)
        {
            $xkey = $tabCond[$c][0].$i;
            if (isset($tabQuests[$key][$xkey]))
            {
                $quest = $tabQuests[$key][$xkey];
                $qtab  = explode(",",$quest);
                $qmax  = count($qtab);
                
                for ($q=0;$q<$qmax;$q++)
                {
                    switch ($tabCond[$c][2])
                    {
                        case "I":   // Ausgabe ItemId
                            $cond .= '            <'.$tabCond[$c][1].'>'.getClientItemId($qtab[$q]).'</'.$tabCond[$c][1].'>'."\n";
                            break;
                        case "X":   // Ausgabe als Tag, also ohne quest_id=...
                            $cond .= '            <'.$tabCond[$c][1].'>'.substr($qtab[$q],1).'</'.$tabCond[$c][1].'>'."\n";
                            break;
                        default :   // Ausgabe generell
                            if (stripos($qtab[$q],":") !== false)
                            {
                                $tqr = explode(":",$qtab[$q]);
                                $qid = $tqr[0];
                                $rew = ' reward="'.$tqr[1].'"';
                            }
                            else
                            {
                                $qid = $qtab[$q];
                                $rew = "";
                            }
                            $qid   = filter_var($qid,FILTER_SANITIZE_NUMBER_INT);
                            $cond .= '            <'.$tabCond[$c][1].' quest_id="'.$qid.'"'.$rew.'/>'."\n";
                            break;
                    }
                }
            }
        }
        if ($cond != "")
        {
            $ret .= '        <start_conditions>'."\n".
                    $cond.
                    '        </start_conditions>'."\n";
        }
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Rückgabe der Zeile für <rewards
// ----------------------------------------------------------------------------
function getRewardsLine($key)
{
    global $tabQuests;
    
    $ret  = "";
    $gold = array();
    $inv  = array();
    $exp  = array();
    $aps  = array();
    $gps  = array();
    $sel  = array();
    $max  = 0;
    
    for ($i=1;$i<7;$i++)
    {
        $gold[$i] = $inv[$i] = $exp[$i] = $aps[$i] = $gps[$i] = 0;
        $sel[$i]  = "";
    }
        
    for ($i=1;$i<7;$i++)
    {
        // Gold 
        if (isset($tabQuests[$key]['reward_gold'.$i]))
            $gold[$i] = $tabQuests[$key]['reward_gold'.$i];
        // Inventory
        if (isset($tabQuests[$key]['reward_extend_inventory'.$i]))           
            $inv[$i] = $tabQuests[$key]['reward_extend_inventory'.$i];        
        // Exp-Points
        if (isset($tabQuests[$key]['reward_exp'.$i]))           
            $exp[$i] = $tabQuests[$key]['reward_exp'.$i];        
        // Abyss-Points
        if (isset($tabQuests[$key]['reward_abyss_point'.$i]))    
            $aps[$i] = $tabQuests[$key]['reward_abyss_point'.$i];        
        // Glory-Points
        if (isset($tabQuests[$key]['reward_glory_point'.$i]))
            $gps[$i] = $tabQuests[$key]['reward_glory_point'.$i];
        // Selectable-Items / Reward-Items
        $sel[$i]     = getItemLine("SELECT".$i,"selectable_reward_item").
                       getItemLine("REWARD".$i,"reward_item");
    }
            
    for ($i=1;$i<7;$i++)
    {                
        $tmp = "";
        
        if ($gold[$i] != 0)   $tmp .= ' gold="'.$gold[$i].'"';
        if ($inv[$i]  != 0)   $tmp .= ' extend_inventory="'.$inv[$i].'"';
        if ($exp[$i]  != 0)   $tmp .= ' exp="'.$exp[$i].'"';
        if ($aps[$i]  != 0)   $tmp .= ' reward_abyss_point="'.$aps[$i].'"';
        if ($gps[$i]  != 0)   $tmp .= ' reward_glory_point="'.$gps[$i].'"';
        
        // Ausgabe nur, wenn etwas vorgegeben wurde
        if ($tmp != "" || $sel[$i] != "")
        {
            $ret .= '        <rewards'.$tmp;
            
            // wenn keine Items, dann Ende (short) sonst Item-Liste ergänzen
            if ($sel[$i] == "")
                $ret .= "/>\n";
            else
            {
                $ret .= ">\n".$sel[$i];
                $ret .= '        </rewards>'."\n";                
            }
        }
    }    
        
    return $ret;
}
// ----------------------------------------------------------------------------
// Rückgabe der Zeile für <task
// ----------------------------------------------------------------------------
function getTaskLine($key)
{
    global $tabQuests, $tabQNames;
    
    $race="PC_ALL";
    
    switch (strtoupper($tabQuests[$key]['race']))
    {
        case "PC_LIGHT": $race = "ELYOS"; break;
        case "PC_DARK" : $race = "ASMODIANS"; break;
        default        : $race = "PC_ALL"; break;
    }
    $namid = getTaskNameId($tabQuests[$key]['desc']);
    $xrep  = getTabValue($key,"challenge_task_repeat","0");
    $xprev = getTabValue($key,"challenge_task_prev","");
    $xres  = getTabValue($key,"town_residence","0");
    
    $repeat= ($xrep == "1") ? ' repeat="true"' : '';
    $town  = ($xres == "1") ? ' town_residence="true"' : "";
    $prev  = ($xprev == "") ? '' : ' prev_task="'.$xprev.'"';
    
    $ret = '    <task id="'.$key.'" type="'.strtoupper($tabQuests[$key]['type']).
           '" race="'.$race.'"'.$prev.' min_level="'.$tabQuests[$key]['level_min'].'" '.
           'max_level="'.$tabQuests[$key]['level_max'].'" name_id="'.$namid.'"'.
           $repeat.$town.'>';
    
    return $ret;
}
// ----------------------------------------------------------------------------
// Rückgabe der Zeile für <quest
// ----------------------------------------------------------------------------
function getTaskQuestLine($key)
{
    global $tabQuests;
    
    $ret = "";
    
    for ($x=0;$x<10;$x++)
    {
        $qid = $rep = $sco = "";
        $i   = ($x == 0) ? "" : $x;
        
        if (isset($tabQuests[$key]['quest_id'.$i]))
            $qid = $tabQuests[$key]['quest_id'.$i];
        if (isset($tabQuests[$key]['quest_repeat'.$i]))
            $rep = $tabQuests[$key]['quest_repeat'.$i];
        if (isset($tabQuests[$key]['score'.$i]))
            $sco = $tabQuests[$key]['score'.$i];
            
        if ($qid != "" && $rep != "" && $sco != "")
        {
            $ret .= '        <quest id="'.$qid.'" repeat_count="'.$rep.'" '.
                    'score="'.$sco.'"/>'."\n";
        }
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Rückgabe der Zeile für <contrib
// ----------------------------------------------------------------------------
function getTaskContribLine($key)
{
    global $tabQuests;
    
    $ret = "";
    
    for ($x=0;$x<10;$x++)
    {
        $rnk = $num = $rew = $cnt = "";
        $i   = ($x == 0) ? "" : $x; 
        
        if (isset($tabQuests[$key]['contributor_rank'.$i]))
            $rnk = $tabQuests[$key]['contributor_rank'.$i];
        if (isset($tabQuests[$key]['contributor_num'.$i]))
            $num = $tabQuests[$key]['contributor_num'.$i];
        if (isset($tabQuests[$key]['reward_item'.$i]))
            $rew = getClientItemId($tabQuests[$key]['reward_item'.$i]);
        if (isset($tabQuests[$key]['reward_item_count'.$i]))
            $cnt = $tabQuests[$key]['reward_item_count'.$i];
            
        if ($rnk != "" && $num != "" && $rew != "" && $cnt != "")
        {
            $ret .= '        <contrib rank="'.$rnk.'" number="'.$num.'" '.
                    'reward_id="'.$rew.'" item_count="'.$cnt.'"/>'."\n";
        }
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// Rückgabe der Zeile für <reward
// ----------------------------------------------------------------------------
function getTaskRewardLine($key)
{
    global $tabQuests;
    
    $ret = "";
    
    for ($x=0;$x<10;$x++)
    {
        $typ = $val = $msg = "";
        $i   = ($x == 0) ? "" : $x;
        
        if (isset($tabQuests[$key]['challenge_task_union_reward_type'.$i]))
            $typ = $tabQuests[$key]['challenge_task_union_reward_type'.$i];
        if (isset($tabQuests[$key]['challenge_task_union_reward_value'.$i]))
            $val = $tabQuests[$key]['challenge_task_union_reward_value'.$i];
        if (isset($tabQuests[$key]['challenge_task_union_reward_desc'.$i]))
            $msg = $tabQuests[$key]['challenge_task_union_reward_desc'.$i];
            
        if ($typ != "")
        {
            $mid  = getQuestMsgId($msg);
            $ret .= '        <reward type="'.strtoupper($typ).'"';
            
            if ($val != "")
                $ret .= ' value="'.$val.'"';
            
            if ($mid != "")            
                $ret .= ' msg_id="'.$mid.'"';
              
            $ret .= "/>\n";
        }
    }
    return $ret;
}
// ----------------------------------------------------------------------------
// alle Item-Typen in $tabItems übernehmen
// ----------------------------------------------------------------------------
function getAllQuestItemTypes($key)
{
    global $tabQuests, $tabItems;
    
    $tabTemp  = $tabQuests[$key];
    $tabItems = array();
    
    while (list($xkey,$val) = each($tabTemp))
    {
        $iakt = strtoupper($xkey);
        
        if (substr($val,0,1) == "%")
        {            
            $tabItems[$iakt]['typ'] = "BONUS";
            $tabItems[$iakt]['nam'] = $val." 0";        
        }
        elseif (substr($xkey,0,15) == 'quest_work_item')
        {            
            $tabItems[$iakt]['typ'] = "QUESTWORK";
            $tabItems[$iakt]['nam'] = $val." 1";
        }
        // Items collect
        elseif (substr($xkey,0,12) == 'collect_item')
        {            
            $tabItems[$iakt]['typ'] = "COLLECT";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items inventory
        elseif (substr($xkey,0,14) == 'inventory_item')
        {
            $tabItems[$iakt]['typ'] = "INVENTORY";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items check
        elseif (substr($xkey,0,11) == 'check_item')
        {
            $tabItems[$iakt]['typ'] = "CHECK";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items reward extended
        elseif (substr($xkey,0,15) == 'reward_item_ext')
        {
            $tabItems[$iakt]['typ'] = "EXTREWARD";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items reward
        elseif (substr($xkey,0,11) == 'reward_item')
        {
            // Hier muss zusätzlich die ID gemerkt werden!
            $id                     = filter_var(substr($xkey,11,2),FILTER_SANITIZE_NUMBER_INT);
            $tabItems[$iakt]['typ'] = "REWARD".$id;
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items selectable
        elseif (substr($xkey,0,22) == 'selectable_reward_item')
        {
            // Hier muss zusätzlich die ID gemerkt werden!
            $id                     = filter_var(substr($xkey,22,2),FILTER_SANITIZE_NUMBER_INT);
            $tabItems[$iakt]['typ'] = "SELECT".$id;
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items selectable fighter
        elseif (substr($xkey,0,23) == 'fighter_selectable_item')
        {
            $tabItems[$iakt]['typ'] = "FIGHTER";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items selectable knight
        elseif (substr($xkey,0,22) == 'knight_selectable_item')
        {
            $tabItems[$iakt]['typ'] = "KNIGHT";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items selectable ranger
        elseif (substr($xkey,0,22) == 'ranger_selectable_item')
        {
            $tabItems[$iakt]['typ'] = "RANGER";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items selectable assassin
        elseif (substr($xkey,0,24) == 'assassin_selectable_item')
        {
            $tabItems[$iakt]['typ'] = "ASSASSIN";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items selectable assassin
        elseif (substr($xkey,0,22) == 'wizard_selectable_item')
        {
            $tabItems[$iakt]['typ'] = "WIZARD";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items selectable elementalist
        elseif (substr($xkey,0,28) == 'elementalist_selectable_item')
        {
            $tabItems[$iakt]['typ'] = "ELEMENTALIST";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items selectable priest
        elseif (substr($xkey,0,22) == 'priest_selectable_item')
        {
            $tabItems[$iakt]['typ'] = "PRIEST";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items selectable chanter
        elseif (substr($xkey,0,23) == 'chanter_selectable_item')
        {
            $tabItems[$iakt]['typ'] = "CHANTER";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items selectable gunner
        elseif (substr($xkey,0,22) == 'gunner_selectable_item')
        {
            $tabItems[$iakt]['typ'] = "GUNNER";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items selectable rider
        elseif (substr($xkey,0,21) == 'rider_selectable_item')
        {
            $tabItems[$iakt]['typ'] = "RIDER";
            $tabItems[$iakt]['nam'] = $val;
        }
        // Items selectable bard
        elseif (substr($xkey,0,20) == 'bard_selectable_item')
        {
            $tabItems[$iakt]['typ'] = "BARD";
            $tabItems[$iakt]['nam'] = $val;
        }
        elseif (stripos($xkey,"_selectable_item") !== false)
            logLine("nicht bekannter Eintrag",$xkey);
    }    

    unset($tabTemp);
}
// ----------------------------------------------------------------------------
//
//                        S C A N - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Scannen der Client-Quest-Xml-Datei
// ----------------------------------------------------------------------------
function scanClientQuestData()
{
    global $pathdata, $tabQuests;
    
    logSubHead("Scanne die Client-Datei");
    
    $fileext = formFileName($pathdata."\\Quest\\quest.xml");
    $fileext = convFileToUtf8($fileext);    
    $hdlext  = openInputFile($fileext);
    
    $cntles  = 0;
    $cntqst  = 0;
    $id      = "";
    
    $tabCnt  = array();
    
    if (!$hdlext)
    {
        logLine("Fehler OpenInputFile",$fileext);
        return;
    }
    
    logLine("Eingabedatei",$fileext);
    
    flush();
    
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        $cntles++;
        
        if     (stripos($line,"<id>") !== false)
        {
            $id = getXmlValue("id",$line);
            $tabQuests[$id]['id'] = $id;
            $cntqst++;
            
            $tabCnt = array();
        }
        elseif (stripos($line,"</quest>") !== false)
            $id = "";
        
        if ($id != "")
        {
            $xml = getXmlKey($line);
            $val = getXmlValue($xml,$line);
            
            // nur Tags mit Inhalt übernehmen
            if ($val != "")
            {
                // identische Tags durch lfdNr erweitern 
                if (isset($tabCnt[$xml]))
                {
                    $tabCnt[$xml]++;
                    $xml .= $tabCnt[$xml];
                }
                else
                    $tabCnt[$xml] = 1;
                    
                $tabQuests[$id][$xml] = $val;
            }
        }
    }
    fclose($hdlext);
    unlink($fileext);
    
    logLine("Anzahl Zeilen gelesen",$cntles);
    logLine("Anzahl Quests gefunden",$cntqst);
}
// ----------------------------------------------------------------------------
// Scannen der Client-Challenge-Task-Xml-Datei
// ----------------------------------------------------------------------------
function scanClientChallengeData()
{
    global $pathdata, $tabQuests;
    
    logSubHead("Scanne die Client-Datei");
        
    $fileext = formFileName($pathdata."\\Quest\\challenge_task.xml");
    $fileext = convFileToUtf8($fileext);    
    $hdlext  = openInputFile($fileext);
    
    $cntles  = 0;
    $cntqst  = 0;
    $id      = "";
    
    $tabCnt  = array();
    $tabQuests = array();
    
    if (!$hdlext)
    {
        logLine("Fehler OpenInputFile",$fileext);
        return;
    }
    
    logLine("Eingabedatei",$fileext);
    
    flush();
    
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        $cntles++;
        
        if     (stripos($line,"<id>") !== false)
        {
            $id = getXmlValue("id",$line);
            $tabQuests[$id]['id'] = $id;
            $cntqst++;
            
            $tabCnt = array();
        }
        elseif (stripos($line,"</client_challenge_task>") !== false)
            $id = "";
        
        if ($id != "")
        {
            $xml = getXmlKey($line);
            $val = getXmlValue($xml,$line);
            
            // nur Tags mit Inhalt übernehmen
            if ($val != "")
            {
                // identische Tags durch lfdNr erweitern 
                if (isset($tabCnt[$xml]))
                {
                    $tabCnt[$xml]++;
                    $xml .= $tabCnt[$xml];
                }
                else
                    $tabCnt[$xml] = 1;
                    
                $tabQuests[$id][$xml] = $val;
            }
        }
    }
    fclose($hdlext);
    unlink($fileext);
    
    logLine("Anzahl Zeilen gelesen",$cntles);
    logLine("Anzahl Quests gefunden",$cntqst);
}
// ----------------------------------------------------------------------------
// Scannen der Client-Quest-Strings aus PacketSamurai
// ----------------------------------------------------------------------------
function scanClientQuestNames()
{
    global $pathstring, $tabQNames;
    
    logSubHead("Scanne die Quest-Strings aus PS");
    
    $filestr = formFileName($pathstring."\\client_strings_quest.xml");
    $hdlstr  = openInputFile($filestr);
    
    if (!$hdlstr)
    {
        logLine("Fehler openInputFile",$filestr);
        return;
    }
    
    logLine("Eingabedatei",$filestr);
    
    $id     = "";
    $name   = "";
    $body   = "";
    $cntles = 0;
    $cntstr = 0;
    
    flush();
    
    while (!feof($hdlstr))
    {
        $line = rtrim(fgets($hdlstr));
        $cntles++;
        
        if     (stripos($line,"<id>")     !== false)
            $id   = getXmlValue("id",$line);
        elseif (stripos($line,"<name>")   !== false)
            $name = strtoupper(getXmlValue("name",$line));
        elseif ( stripos($line,"<body>")  !== false)
            $body = getXmlValue("body",$line);
        elseif (stripos($line,"</string") !== false)
        {   
            $tabQNames[$name]['body'] = $body;
            $tabQNames[$name]['id']   = $id;
            
            $id = $name = $body = "";
            $cntstr++;
        }
    }
    fclose($hdlstr);
    
    logLine("Anzahl Zeilen gelesen",$cntles);
    logLine("Anzahl Strings gefunden",$cntstr);
}
// ----------------------------------------------------------------------------
// Scannen der Client-Msg-Strings aus PacketSamurai
// ----------------------------------------------------------------------------
function scanClientMsgNames()
{
    global $pathstring, $tabMsgIds;
    
    logSubHead("Scanne die Msg-Strings aus PS");
    
    $filestr = formFileName($pathstring."\\client_strings_ui.xml");
    $hdlstr  = openInputFile($filestr);
    
    if (!$hdlstr)
    {
        logLine("Fehler openInputFile",$filestr);
        return;
    }
    
    logLine("Eingabedatei",$filestr);
    
    $id     = "";
    $name   = "";
    $body   = "";
    $cntles = 0;
    $cntstr = 0;
    
    flush();
    
    while (!feof($hdlstr))
    {
        $line = rtrim(fgets($hdlstr));
        $cntles++;
        
        if     (stripos($line,"<id>")     !== false)
            $id   = getXmlValue("id",$line);
        elseif (stripos($line,"<name>")   !== false)
            $name = strtoupper(getXmlValue("name",$line));
        elseif ( stripos($line,"<body>")  !== false)
            $body = getXmlValue("body",$line);
        elseif (stripos($line,"</string") !== false)
        {   
            $tabMsgIds[$name]['body'] = $body;
            $tabMsgIds[$name]['id']   = $id;
            
            $id = $name = $body = "";
            $cntstr++;
        }
    }
    fclose($hdlstr);
    
    logLine("Anzahl Zeilen gelesen",$cntles);
    logLine("Anzahl Strings gefunden",$cntstr);
}
// ----------------------------------------------------------------------------
// Scannen der Client-NPC-Factions
// ----------------------------------------------------------------------------
function scanNpcFactionNames()
{
    global $pathdata, $tabNpcFacs;
    
    logSubHead("Scanne die Client-Npc_faction-Names");
    
    $fileext = formFileName($pathdata."\\Faction\\NpcFactions.xml");
    $fileext = convFileToUtf8($fileext); 
    $hdlext  = openInputFile($fileext);
    
    if (!$hdlext)
    {
        logLine("Fehler openInputFile",$fileext);
        return;
    }
    
    logLine("Eingabedatei",$fileext);
    
    $id     = "";
    $name   = "";
    $cntles = 0;
    $cntfac = 0;
    
    flush();
    
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        $cntles++;
        
        if     (stripos($line,"<id>")     !== false)
            $id   = getXmlValue("id",$line);
        elseif (stripos($line,"<name>")   !== false)
            $name = strtoupper(getXmlValue("name",$line));
        elseif (stripos($line,"</npcfaction>") !== false)
        {   
            $tabNpcFacs[$name] = $id;
            
            $id = $name = "";
            $cntfac++;
        }
    }
    fclose($hdlext);
    unlink($fileext);
    
    logLine("Anzahl Zeilen gelesen",$cntles);
    logLine("Anzahl Factions gefunden",$cntfac);
}
// ----------------------------------------------------------------------------
// Scannen der Datei quest_monster.csv
// ----------------------------------------------------------------------------
function scanQuestMonsterCsv()
{
    global $pathdata, $tabMonster;
    
    $fileext = formFileName($pathdata."\\Quest\\quest_monster.csv");
    $hdlext  = openInputFile($fileext);
    $cntles  = 0;
    $cntfnd  = 0;
    
    if (!$hdlext)
    {
        logLine("Fehler openInputFile",$fileext);
        return;
    }
    
    logSubHead("Scanne die Client-Monster_quest-Vorgaben");
    logLine("Eingabedatei",$fileext);
    
    flush();
    
    while (!feof($hdlext))
    {
        $line = rtrim(fgets($hdlext));
        $cntles++;
        
        // questId, questProgress, item, sourceType, sourceName, num, monsters_gathers_npcs_list[]
        // 0        1              2     3           4           5    6
        $tab = explode(",",$line,7);   // nur max. 7 Splits
        
        // berücksichtigt werden nur Einträge, die eine SECTION...-Angabe im
        // questProgress beinhalten!
        if (count($tab) > 6)
        {
            if (stripos($tab[1],"SECTION") !== false)
            {
                $quest = $tab[0];
                $seq   = substr($tab[1],stripos($tab[1],"SECTION"),9);
                $seq   = filter_var($seq,FILTER_SANITIZE_NUMBER_INT);
                $tmon  = explode(",",$tab[6]);
                $mmax  = count($tmon);
                $monst = "";
                
                for ($m=0;$m<$mmax;$m++)
                {
                    $tnpc   = getNpcIdNameTab($tmon[$m]);
                    $monst .= $tnpc['npcid']." ";
                }
                $tabMonster[$quest][$seq] = trim($monst);
            }
        }
    }
    fclose($hdlext);
    
    logLine("Anzahl Zeilen gelesen",$cntles);
    logLine("Anzahl Quests/Sequences",count($tabMonster));
}
// ----------------------------------------------------------------------------
//
//               G E N E R I E R U N G S - F U N K T I O N E N
//
// ----------------------------------------------------------------------------
// Ausgeben der Datei: quest_data.xml
// ----------------------------------------------------------------------------
function makeQuestDataFile()
{
    global $tabQuests;
    
    logSubHead("Erzeugen der Ausgabedatei");
    
    $fileout = "../outputs/parse_output/quest_data/quest_data.xml";
    $hdlout  = openOutputFile($fileout);
    $cntout  = 0;
    $cntqst  = 0;
    $cntl99  = 0;
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="utf-8"?>'."\n");
    fwrite($hdlout,'<quests xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">'."\n");
    $cntout += 2;
    
    logLine("Ausgabedatei",$fileout);
    
    flush();
    
    while (list($key,$val) = each($tabQuests))
    {
        $cntqst++;
        
        $min  = getTabValue($key,"minlevel_permitted","");
        $max  = getTabValue($key,"maxlevel_permitted","");
        $pack = getTabValue($key,"package_permitted","");
        
        // 2016-04-03 alle 99-er Quests ignorieren (auch bei min/maxLevel-permitted)
        if ($tabQuests[$key]['client_level'] != "99"
        &&  $min  != ""  &&  $min != "99"
        &&  $max  != ""  &&  $max != "99"
        &&  $pack == "")
        {
            getAllQuestItemTypes($key);
            
            // Ausgabe <quest...
            $line = getQuestLine($key);
            
            if ($line != "")
            {
                fwrite($hdlout,$line."\n");
                $cntout++;
            }
            
            // Ausgabe <collect_items
            $iline = getItemLine("COLLECT","collect_item");
            
            if ($iline != "")
            {
                fwrite($hdlout,"        <collect_items>\n");
                $cntout++;
                
                fwrite($hdlout,$iline);
                $cntout += substr_count($iline,"\n");
                
                fwrite($hdlout,"        </collect_items>\n");
                $cntout++;
            }
            // Ausgabe <inventory_items
            $iline = getItemLine("INVENTORY","inventory_item");
            
            if ($iline != "")
            {
                fwrite($hdlout,"        <inventory_items>\n");
                $cntout++;
                
                fwrite($hdlout,$iline);
                $cntout += substr_count($iline,"\n");
                
                fwrite($hdlout,"        </inventory_items>\n");
                $cntout++;
            }
            
            // Ausgabe <rewards
            $iline = getRewardsLine($key);
            
            if ($iline != "")
            {
                fwrite($hdlout,$iline);
                $cntout += substr_count($iline,"\n");
            }
            
            // Ausgabe <bonus
            $iline = getBonusLine();
            
            if ($iline != "")
            {
                fwrite($hdlout,$iline);                
                $cntout += substr_count($iline,"\n");
            }
            
            // Ausgabe <extended_rewards            
            $iline = getItemLine("EXTREWARD","reward_item");
            
            if ($iline != "")
            {
                fwrite($hdlout,'        <extended_rewards>'."\n");
                $cntout++;
                
                fwrite($hdlout,$iline);
                $cntout += substr_count($iline,"\n");
                
                fwrite($hdlout,'        </extended_rewards>'."\n");
                $cntout++;                
            }
            
            // Ausgabe <quest_drop            
            $iline = getDropLine($key);
            
            if ($iline != "")
            {
                fwrite($hdlout,$iline);                
                $cntout += substr_count($iline,"\n");
            }
            
            // Ausgabe <quest_kill   
            $iline = getKillLine($key);
            
            if ($iline != "")
            {
                fwrite($hdlout,$iline);                
                $cntout += substr_count($iline,"\n");
            }
            
            // Ausgabe <start_conditions              
            $iline = getStartLine($key);
            
            if ($iline != "")
            {                
                fwrite($hdlout,$iline);
                $cntout += substr_count($iline,"\n");
            }
            
            // Ausgabe <class_permitted
            $classes = strtoupper($tabQuests[$key]['class_permitted']);
            
            $classes = str_replace("FIGHTER","GLADIATOR",$classes);
            $classes = str_replace("KNIGHT","TEMPLAR",$classes);
            $classes = str_replace("WIZARD","SORCERER",$classes);
            $classes = str_replace("ELEMENTALLIST","SPIRIT_MASTER",$classes);
            
            fwrite($hdlout,'        <class_permitted>'.$classes.'</class_permitted>'."\n");
            $cntout++;
            
            // Ausgabe <gender_permitted
            if (isset($tabQuests[$key]['gender_permitted']))
            {
                $gender = strtoupper(getTabValue($key,"gender_permitted",""));
                
                if ($gender == "MALE" || $gender == "FEMALE")
                {
                    fwrite($hdlout,'        <gender_permitted>'.$gender.'</gender_permitted>'."\n");
                    $cntout++;
                }
            }
            
            // Ausgabe <quest_work              
            $iline = getItemLine("QUESTWORK","quest_work_item");
            
            if ($iline != "")
            {
                fwrite($hdlout,'        <quest_work_items>'."\n");
                $cntout++;
                
                fwrite($hdlout,$iline);
                $cntout += substr_count($iline,"\n");
                
                fwrite($hdlout,'        </quest_work_items>'."\n");
                $cntout++;                
            }
            
            // Ausgabe <class>_selectables
            $selClasses = array("FIGHTER","KNIGHT","RANGER","ASSASSIN","WIZARD",
                                "ELEMENTALIST","PRIEST","CHANTER","BARD",
                                "GUNNER","RIDER");
            $maxClasses = count($selClasses);
            
            for ($c=0;$c<$maxClasses;$c++)
            {
                $iline = getItemLine($selClasses[$c],"*");
                
                if ($iline != "")
                {
                    fwrite($hdlout,$iline);
                    $cntout += substr_count($iline,"\n");
                }
            }
            
            // Ende zur aktuellen Quest
            fwrite($hdlout,"    </quest>\n");
            $cntout++;
        }
        else
            $cntl99++;
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</quests>");
    $cntout++;
    fclose($hdlout);
    
    logLine("Anzahl Quest verarbeitet",$cntqst);
    logLine("- davon ignoriert (Lev99)",$cntl99);
    logLine("- somit Quest ausgegeben",$cntqst - $cntl99);
    logLine("Anzahl Zeilen ausgegeben",$cntout);
}
// ----------------------------------------------------------------------------
// Ausgeben der Datei: challenge_tasks.xml
// ----------------------------------------------------------------------------
function makeChallengeDataFile()
{
    global $tabQuests;
    
    logSubHead("Erzeugen der Ausgabedatei");
    
    $fileout = "../outputs/parse_output/quest_data/challenge_tasks.xml";
    $hdlout  = openOutputFile($fileout);
    $cntout  = 0;
    $cntqst  = 0;
    
    // Vorspann ausgeben
    fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
    fwrite($hdlout,'<challenge_tasks>'."\n");
    $cntout += 2;
    
    logLine("Ausgabedatei",$fileout);
    
    flush();
    
    while (list($key,$val) = each($tabQuests))
    {
        $cntqst++;
        
        // Ausgabe <task
        $iline = getTaskLine($key);
        fwrite($hdlout,$iline."\n");
        $cntout++;
        
        // Ausgabe <quest
        $iline = getTaskQuestLine($key);
        if ($iline != "")
        {
            fwrite($hdlout,$iline);
            $cntout += substr_count($iline,"\n");
        }
        
        // Ausgabe <contrib
        $iline = getTaskContribLine($key);
        if ($iline != "")
        {
            fwrite($hdlout,$iline);
            $cntout += substr_count($iline,"\n");
        }
        
        // Ausgabe <reward
        $iline = getTaskRewardLine($key);
        if ($iline != "")
        {
            fwrite($hdlout,$iline);
            $cntout += substr_count($iline,"\n");
        }
        
        // Ende ausgeben
        fwrite($hdlout,"    </task>\n");
        $cntout++;
    }
    // Nachspann ausgeben
    fwrite($hdlout,"</challenge_tasks>");
    $cntout++;
    fclose($hdlout);
    
    logLine("Anzahl Tasks verarbeitet",$cntqst);
    logLine("Anzahl Zeilen ausgegeben",$cntout);
}
// ----------------------------------------------------------------------------
// Erzeugen Datei: quest_data.xml
// ----------------------------------------------------------------------------
function generQuest()
{
    logHead("Generiere Datei: quest_data.xml");
    
    scanClientQuestData();
    scanClientQuestNames();
    scanNpcFactionNames();
    scanQuestMonsterCsv();
    makeQuestDataFile();
}
// ----------------------------------------------------------------------------
// Wert $val 5-stellig (führende Leerzeichen) zurückgeben
// ----------------------------------------------------------------------------
function getNum5($val)
{
    $ret = strval($val);
    if (strlen($ret) < 5) $ret = str_pad(" ",5 - strlen($ret)).$ret;
    
    return $ret;
}
// ----------------------------------------------------------------------------
// SVN etc. Scannen für zusätzliche Angaben
// ----------------------------------------------------------------------------
function makeNewQuestTable()
{
    global $pathsvn, $tabQData, $tabQSvn, $tabQScr;
    
    $svnPathes = array();
    $svnFiles  = array();
    $tabQSvn   = array();
    $tabQScr   = array();    
    
    // Scripte aus dem SVN scannen!
    $scanpath  = formFileName($pathsvn."\\trunk\\AL-Game\\data\\scripts\\system\\handlers\\quest");
    $svnPathes = scandir($scanpath);
    $domax     = count($svnPathes);
    
    for ($p=0;$p<$domax;$p++)
    {
        if (substr($svnPathes[$p],0,1) != "." && substr($svnPathes[$p],0,1) != "_")
        {
            $aktsvnpath = formFileName($scanpath."\\".$svnPathes[$p]);
            
            // Quest-Dateien ermitteln
            $svnFiles = scandir($aktsvnpath);
            $dofiles  = count($svnFiles);
            
            for ($f=0;$f<$dofiles;$f++)
            {
                if (substr($svnFiles[$f],0,1) == "_")
                {
                    $quest = substr($svnFiles[$f],1,5);
                    $quest = filter_var($quest,FILTER_SANITIZE_NUMBER_INT);
                                        
                    $tabQScr[$quest] = 1;
                }
            }  
            unset($svnFiles);            
        }
    }
    unset($svnPathes);
    
    // Daten aus dem SVN ermitteln bzgl. der dortigen Script-Vorgaben
    $scanpath = formFileName($pathsvn."\\trunk\\AL-Game\\data\\static_data\\quest_script_data");
    $svnfiles = scandir($scanpath);
    $dofiles  = count($svnfiles);
    
    for ($f=0;$f<$dofiles;$f++)
    {
        if (substr($svnfiles[$f],0,1) != ".")
        {
            $filesvn = formFileName($scanpath."\\".$svnfiles[$f]);
            $hdlsvn  = openInputFile($filesvn);
            $begin   = false;
            
            while (!feof($hdlsvn))
            {
                $line = rtrim(fgets($hdlsvn));
                
                if (!$begin)
                {
                    if (stripos($line,"[BEGIN]") !== false)
                        $begin = true;
                }
                else
                {
                    if (stripos($line,"[END]") !== false)
                        $begin = false;    
                        
                    // innerhalb des Kommentarblockes!!!
                    if ($begin)
                    {   
                        $quest = trim(substr($line,0,stripos($line,"[")));
                        $todo  = substr($line,stripos($line,"[") + 1);
                        $todo  = trim(substr($todo,0,stripos($todo,"]")));                           
                        
                        if ($quest != "")          
                        {                        
                            $tabQSvn[$quest]['todo'] = $todo;
                            $tabQSvn[$quest]['file'] = basename($filesvn);
                        }
                    }
                }
            }
            fclose($hdlsvn);
        }
    }
}
// ----------------------------------------------------------------------------
// Erzeugen Dateien: /quest_script_data/....xml
// ----------------------------------------------------------------------------    
function generQuestData()
{
    global $tabQData, $tabQSvn, $tabQScr;
    
    makeNewQuestTable();
    
    $tabSort = array_keys($tabQData);
    sort ($tabSort);
    $maxSort = count($tabSort);
    $cntFile = 0;
    
    if (!file_exists("../outputs/parse_output/quest_script_data"))
        mkdir("../outputs/parse_output/quest_script_data");
    
    logHead("Erzeuge die Vorlagen der Quest-Script-Data-Dateien");  
    logLine("Ausgabe-Verzeichnis","../outputs/parse_output/quest_script_data");
    
    for ($d=0;$d<$maxSort;$d++)
    {
        $fileout = "../outputs/parse_output/quest_script_data/".$tabSort[$d].".xml";
        $hdlout  = openOutputFile($fileout);
        $cntFile++;
        
        $tabQIds = array_keys($tabQData[$tabSort[$d]]);
        $maxQIds = count($tabQIds);
        
        // Vorspann ausgeben
        fwrite($hdlout,'<?xml version="1.0" encoding="UTF-8"?>'."\n");
        fwrite($hdlout,'<quest_scripts xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'."\n");
        fwrite($hdlout,'               xsi:noNamespaceSchemaLocation="quest_script_data.xsd">'."\n");
        fwrite($hdlout,'    <!-- '.$maxQIds.' Quests listed - generated '.date("Y-m-d H:i").' -->'."\n");
        fwrite($hdlout,'    <!--'."\n");
        fwrite($hdlout,'        [BEGIN] SUMMARY'."\n");
        
        for ($q=0;$q<$maxQIds;$q++)
        {
            $todo  = "[TODO]";
            $quest = trim($tabQIds[$q]);
            
            // Aktion übernehmen aus Scripten oder SVN
            if     (isset($tabQScr[$quest])) $todo = "[SCRIPT]";
            elseif (isset($tabQSvn[$quest])) $todo = "[".$tabQSvn[$quest]['todo']."]";
            
            // SVN als übernommen markieren
            if (isset($tabQSvn[$quest])) $tabQSvn[$quest]['todo'] = "-DONE-";
                       
            // Aktion formatieren           
            if (strlen($todo) < 8) $todo  .= str_pad(" ",8 - strlen($todo));
                
            fwrite($hdlout,'               '.getNum5($quest).' '.$todo.' '.$tabQData[$tabSort[$d]][$quest]."\n");
        }
        // Nachspann ausgeben
        fwrite($hdlout,'        [END] SUMMARY'."\n");
        fwrite($hdlout,'    -->'."\n");
        fwrite($hdlout,'    <!-- REPORTING QUESTS -->'."\n");
        fwrite($hdlout,'    <!-- COLLECTING QUESTS -->'."\n");
        fwrite($hdlout,'    <!-- HUNTING QUESTS -->'."\n");
        fwrite($hdlout,'</quest_scripts>');
        fclose($hdlout);
    }
    logLine("Anzahl erzeugte Dateien",$cntFile);
    
    $fileout = "../outputs/parse_output/quest_script_data/__delete_quests.txt";
    $hdlout  = openOutputFile($fileout);
    fwrite($hdlout,"+-------------------------------------------------------------------+\n");
    fwrite($hdlout,"|      Liste der in diesem Client nicht mehr relevanten Quests      |\n");
    fwrite($hdlout,"|    (darin sind auch die ignorierten Level=99-Quests enthalten)    |\n"); 
    fwrite($hdlout,"|                                                                   |\n");
    fwrite($hdlout,"| Bitte prüfen und entsprechend deaktivieren bzw. Scripte entfernen |\n");
    fwrite($hdlout,"+-------------------------------------------------------------------+\n");
    $cntdel  = 0;    

    // alle im SVN nicht als übernommen markierten ausgeben    
    while (list($key,$val) = each($tabQSvn))
    {  
        if ($key != "" 
        &&  $tabQSvn[$key]['todo'] != "-DONE-"
        &&  $tabQSvn[$key]['todo'] != "")
        {
            fwrite($hdlout," (".getNum5($key).") <= [CHECK FOR DELETE] ".$tabQSvn[$key]['todo']." in ".
                           $tabQSvn[$key]['file']."\n");
            $cntdel++;
        }
    }
    fwrite($hdlout,"\nAnzahl unbenutzter Quests: $cntdel");
    logLine("nicht mehr genutzte Quests",$cntdel);
}
// ----------------------------------------------------------------------------
// Erzeugen Datei: challenge_tasks.xml
// ----------------------------------------------------------------------------
function generChallenge()
{
    logHead("Generiere Datei: challenge_tasks.xml");
    
    scanClientMsgNames();
    scanClientChallengeData();
    makeChallengeDataFile();
}
// ----------------------------------------------------------------------------
//                             M  A  I  N
// ----------------------------------------------------------------------------

$starttime     = microtime(true);
$tabQuests     = array();
$tabQNames     = array();
$tabMsgIds     = array();
$tabNpcFacs    = array();
$tabMonster    = array();
$tabQData      = array();
$tabQSvn       = array();
$tabQScr       = array();

echo '
   <tr>
     <td colspan=2>
       <center>
       <br><br>
       <input type="submit" name="submit" value="Generierung starten" style="width:220px;"><br><br>
       </center>
       <br>
     </td>
   </tr>
   <tr>
     <td colspan=2>';    

logStart();

include("includes/inc_getautonameids.php");
include("includes/inc_inc_scan.php");
include("includes/inc_itemtmplparse.php");

if ($submit == "J")
{   
    if ($pathdata == "")
    {
        logLine("ACHTUNG","die Pfade sind anzugeben");
    }
    else
    {
        // prüfen, ob die sonstigen Includes existieren, sonst erzeugen
        checkAutoIncludeFiles();              
        cleanPathUtf8Files();      
        
        // wenn Vorarbeiten notwendig waren, dann Hinweis und neu starten
        if ($doneGenerInclude)
        {
            logSubHead("<br><br><div style='background-color:#000033;border:1px solid silver;padding:20px;text-align:center;'>".
                       "WICHTIGER HINWEIS<br><br>".    
                       "Ein Teil der Vorarbeiten zum Erzeugen der Includes ist abgeschlossen.<br><br>".
                       "Bitte die <font color=magenta>Generierung erneut starten</font>!<br><br><br>".                       
                       "<input type='submit' name='submit' value='Erneut starten'><br></div>");
        }
        else
        {
            writeHinweisOhneVorarbeiten();
            
            include("includes/auto_inc_skill_names.php");
            include("includes/auto_inc_item_infos.php");       // neu in 4.9
            include("includes/auto_inc_npc_infos.php");        // neu in 4.9
            
            generQuest();
            generQuestData();
            generChallenge();
        }
    }
}
        
logStop($starttime,true,true);

echo '
      </td>
    </tr>
  </table>';
?>
</form>
</body>
</html>