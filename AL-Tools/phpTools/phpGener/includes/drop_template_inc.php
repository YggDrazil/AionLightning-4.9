<?PHP
// ----------------------------------------------------------------------------
// Tabelle mit den Drop-Template-Vorgaben
//
// ist eine der ItemIds aus einer Gruppe im NPC-Drop vorhanden, dann werden 
// grundsätzlich alle Items der Gruppe als Drop übernommen. Der Name der
// Gruppe wird bei der Drop-Generierung als group_name genutzt. Die ItemId
// muss eindeutig sein, d.h. sie darf nur einmal über alle Gruppen definiert
// werden. Die Initialisierung erzeugt eine Fehlermeldung, wenn dies nicht
// der Fall sein sollte und ignoriert die betroffene ItemId.
//
// Aufbau der Tabelle:  
//   
// Kopfzeile :    1  =  Gruppen-Item-SortId   = für die Item-Sortierung
//                2  =  Template-Gruppe       = eindeutiger Gruppenname
//                3  =  Drop-Gruppen-Name     = group_name für den Drop
//                4  =  Item-Array
//                      1  =  ItemId          = ItemId
//                      2  =  Drop-Chance     = Prozentsatz für die Drop-Chance
//                      3  =  Item-Text       = Item-Bezeichnung
//
// HINWEIS: Die Gruppen-Item-SortId wird genutzt, um die Gruppe in die Item-
//          Sortierung einzubinden, da unter Umständen in einer Gruppe ver-
//          schiedene (auf den 1. 3 Stellen) Items definiert sind.
// ----------------------------------------------------------------------------

$tabDropTemplates = array (
                        //
                        //         1  0  0
                        //
                        // generiert aus Drops_Template_Weapon_Common_Lvl2.xml
                        array("100","WEAPON_COMMON_2","WEAPON_COMMON_LVL2",
                          array (
                            array("100000133","0.295","Plainsman's Sword"),
                            array("100000390","0.295","Plainsman's Sword"),
                            array("100000391","0.295","Plainsman's Sword"),
                            array("100100047","0.295","Plainsman's Mace"),
                            array("100100272","0.295","Plainsman's Mace"),
                            array("100100273","0.295","Plainsman's Mace"),
                            array("100200147","0.295","Plainsman's Dagger"),
                            array("100200380","0.295","Plainsman's Dagger"),
                            array("100200390","0.295","Plainsman's Dagger"),
                            array("100600070","0.295","Plainsman's Spellbook"),
                            array("100600299","0.295","Plainsman's Spellbook"),
                            array("100600309","0.295","Plainsman's Spellbook"),
                            array("101800205","0.295","Plainsman's Pistol"),
                            array("101800329","0.295","Plainsman's Pistol"),
                            array("101800339","0.295","Plainsman's Pistol"),
                            array("102000218","0.295","Plainsman's Harp"),
                            array("102000343","0.295","Plainsman's Harp"),
                            array("102000353","0.295","Plainsman's Harp"),
                            array("102100205","0.295","Plainsman's Cipher-Blade"),
                            array("102100312","0.295","Plainsman's Cipher-Blade"),
                            array("102100322","0.295","Plainsman's Cipher-Blade"),
                            array("115000325","0.295","Plainsman's Shield"),
                            array("115000550","0.295","Plainsman's Shield"),
                            array("115000560","0.295","Plainsman's Shield")
                          )
                        ),
                        // generiert aus Drops_Template_Weapon_Common_Lvl2_Asmo.xml
                        array("100","WEAPON_COMMON_2A","WEAPON_COMMON_LVL2A",
                          array (
                            array("100000143","0.295","Sword of the Prairie"),
                            array("100000410","0.295","Sword of the Prairie"),
                            array("100000411","0.295","Sword of the Prairie"),
                            array("100100057","0.295","Mace of the Prairie"),
                            array("100100292","0.295","Mace of the Prairie"),
                            array("100100293","0.295","Mace of the Prairie"),
                            array("100200157","0.295","Dagger of the Prairie"),
                            array("100200400","0.295","Dagger of the Prairie"),
                            array("100200410","0.295","Dagger of the Prairie"),
                            array("100600080","0.295","Spellbook of the Prairie"),
                            array("100600319","0.295","Spellbook of the Prairie"),
                            array("100600329","0.295","Spellbook of the Prairie"),
                            array("101800215","0.295","Pistol of the Prairie"),
                            array("101800349","0.295","Pistol of the Prairie"),
                            array("101800359","0.295","Pistol of the Prairie"),
                            array("102000228","0.295","Harp of the Prairie"),
                            array("102000363","0.295","Harp of the Prairie"),
                            array("102000373","0.295","Harp of the Prairie"),
                            array("102100215","0.295","Cipher-Blade of the Prairie"),
                            array("102100332","0.295","Cipher-Blade of the Prairie"),
                            array("102100342","0.295","Cipher-Blade of the Prairie"),
                            array("115000335","0.295","Shield of the Prairie"),
                            array("115000570","0.295","Shield of the Prairie"),
                            array("115000580","0.295","Shield of the Prairie")
                          )
                        ),
                        // generiert aus Drops_Template_Weapon_Rare_Lvl4.xml
                        array("100","WEAPON_RARE_4","WEAPON_RARE_LVL4",
                          array (
                            array("100000153","1.475","Ranger's Sword"),
                            array("100000430","1.475","Ranger's Sword"),
                            array("100000431","1.475","Ranger's Sword"),
                            array("100001117","1.475","Ranger's Sword"),
                            array("100100067","1.475","Ranger's Warhammer"),
                            array("100100312","1.475","Ranger's Warhammer"),
                            array("100100322","1.475","Ranger's Warhammer"),
                            array("100100856","1.475","Ranger's Warhammer"),
                            array("100200167","1.475","Ranger's Dagger"),
                            array("100200420","1.475","Ranger's Dagger"),
                            array("100200430","1.475","Ranger's Dagger"),
                            array("100200985","1.475","Ranger's Dagger"),
                            array("100600090","1.475","Ranger's Tome"),
                            array("100600339","1.475","Ranger's Tome"),
                            array("100600349","1.475","Ranger's Tome"),
                            array("100600926","1.475","Ranger's Tome"),
                            array("101800225","1.475","Woodkeeper's Pistol"),
                            array("101800369","1.475","Woodkeeper's Pistol"),
                            array("101800379","1.475","Woodkeeper's Pistol"),
                            array("102000238","1.475","Woodkeeper's Harp"),
                            array("102000383","1.475","Woodkeeper's Harp"),
                            array("102000393","1.475","Woodkeeper's Harp"),
                            array("102100225","1.475","Ranger's Cipher-Blade"),
                            array("102100352","1.475","Ranger's Cipher-Blade"),
                            array("102100362","1.475","Ranger's Cipher-Blade"),
                            array("102100895","1.475","Ranger's Cipher-Blade"),
                            array("115000345","1.475","Ranger's Shield"),
                            array("115000590","1.475","Ranger's Shield"),
                            array("115000600","1.475","Ranger's Shield")
                          )
                        ),
                        // generiert aus Drops_Template_Weapon_Rare_Lvl4_Asmo.xml
                        array("100","WEAPON_RARE_4A","WEAPON_RARE_LVL4A",
                          array (
                            array("100000163","1.475","Fiendish Sword"),
                            array("100000450","1.475","Fiendish Sword"),
                            array("100000451","1.475","Fiendish Sword"),
                            array("100001118","1.475","Fiendish Sword"),
                            array("100100077","1.475","Fiendish Warhammer"),
                            array("100100332","1.475","Fiendish Warhammer"),
                            array("100100342","1.475","Fiendish Warhammer"),
                            array("100100857","1.475","Fiendish Warhammer"),
                            array("100200177","1.475","Fiendish Dagger"),
                            array("100200440","1.475","Fiendish Dagger"),
                            array("100200450","1.475","Fiendish Dagger"),
                            array("100200986","1.475","Fiendish Dagger"),
                            array("100600100","1.475","Fiendish Tome"),
                            array("100600359","1.475","Fiendish Tome"),
                            array("100600369","1.475","Fiendish Tome"),
                            array("100600927","1.475","Fiendish Tome"),
                            array("101800235","1.475","Fiendish Pistol"),
                            array("101800389","1.475","Fiendish Pistol"),
                            array("101800399","1.475","Fiendish Pistol"),
                            array("102000248","1.475","Fiendish Harp"),
                            array("102000403","1.475","Fiendish Harp"),
                            array("102000413","1.475","Fiendish Harp"),
                            array("102100235","1.475","Fiendish Cipher-Blade"),
                            array("102100372","1.475","Fiendish Cipher-Blade"),
                            array("102100382","1.475","Fiendish Cipher-Blade"),
                            array("102100896","1.475","Fiendish Cipher-Blade"),
                            array("115000355","1.475","Fiendish Shield"),
                            array("115000610","1.475","Fiendish Shield"),
                            array("115000620","1.475","Fiendish Shield")
                          )
                        ),
                        // generiert aus Drops_Template_Weapon_Common_Lvl7.xml
                        array("100","WEAPON_COMMON_7","WEAPON_COMMON_LVL7",
                          array (
                            array("100000134","0.28","Canyon Sword"),
                            array("100000392","0.28","Canyon Sword"),
                            array("100000393","0.28","Canyon Sword"),
                            array("100100048","0.28","Canyon Mace"),
                            array("100100274","0.28","Canyon Mace"),
                            array("100100275","0.28","Canyon Mace"),
                            array("100200148","0.28","Canyon Dagger"),
                            array("100200381","0.28","Canyon Dagger"),
                            array("100200391","0.28","Canyon Dagger"),
                            array("100600071","0.28","Canyon Spellbook"),
                            array("100600300","0.28","Canyon Spellbook"),
                            array("100600310","0.28","Canyon Spellbook"),
                            array("101800206","0.28","Canyon Pistol"),
                            array("101800330","0.28","Canyon Pistol"),
                            array("101800340","0.28","Canyon Pistol"),
                            array("102000219","0.28","Canyon Harp"),
                            array("102000344","0.28","Canyon Harp"),
                            array("102000354","0.28","Canyon Harp"),
                            array("102100206","0.28","Canyon Cipher-Blade"),
                            array("102100313","0.28","Canyon Cipher-Blade"),
                            array("102100323","0.28","Canyon Cipher-Blade"),
                            array("115000326","0.28","Canyon Shield"),
                            array("115000551","0.28","Canyon Shield"),
                            array("115000561","0.28","Canyon Shield")
                          )
                        ),
                        // generiert aus Drops_Template_Weapon_Common_Lvl7_Asmo.xml
                        array("100","WEAPON_COMMON_7A","WEAPON_COMMON_LVL7A",
                          array (
                            array("100000144","0.28","Sword of the Lake"),
                            array("100000412","0.28","Sword of the Lake"),
                            array("100000413","0.28","Sword of the Lake"),
                            array("100100058","0.28","Mace of the Lake"),
                            array("100100294","0.28","Mace of the Lake"),
                            array("100100295","0.28","Mace of the Lake"),
                            array("100200158","0.28","Dagger of the Lake"),
                            array("100200401","0.28","Dagger of the Lake"),
                            array("100200411","0.28","Dagger of the Lake"),
                            array("100600081","0.28","Spellbook of the Lake"),
                            array("100600320","0.28","Spellbook of the Lake"),
                            array("100600330","0.28","Spellbook of the Lake"),
                            array("101800216","0.28","Pistol of the Lake"),
                            array("101800350","0.28","Pistol of the Lake"),
                            array("101800360","0.28","Pistol of the Lake"),
                            array("102000229","0.28","Harp of the Lake"),
                            array("102000364","0.28","Harp of the Lake"),
                            array("102000374","0.28","Harp of the Lake"),
                            array("102100216","0.28","Cipher-Blade of the Lake"),
                            array("102100333","0.28","Cipher-Blade of the Lake"),
                            array("102100343","0.28","Cipher-Blade of the Lake"),
                            array("115000336","0.28","Shield of the Lake"),
                            array("115000571","0.28","Shield of the Lake"),
                            array("115000581","0.28","Shield of the Lake")
                          )
                        ),
                        // generiert aus Drops_Template_Weapon_Rare_Lvl9.xml
                        array("100","WEAPON_RARE_9","WEAPON_RARE_LVL9",
                          array (
                            array("100000154","0.14","Mercenary Captain's Sword"),
                            array("100000432","0.14","Mercenary Captain's Sword"),
                            array("100000433","0.14","Mercenary Captain's Sword"),
                            array("100100068","0.14","Mercenary Captain's Warhammer"),
                            array("100100313","0.14","Mercenary Captain's Warhammer"),
                            array("100100323","0.14","Mercenary Captain's Warhammer"),
                            array("100200168","0.14","Mercenary Captain's Dagger"),
                            array("100200421","0.14","Mercenary Captain's Dagger"),
                            array("100200431","0.14","Mercenary Captain's Dagger"),
                            array("100600091","0.14","Mercenary Captain's Tome"),
                            array("100600340","0.14","Mercenary Captain's Tome"),
                            array("100600350","0.14","Mercenary Captain's Tome"),
                            array("101800226","0.14","Mercenary Captain's Pistol"),
                            array("101800370","0.14","Mercenary Captain's Pistol"),
                            array("101800380","0.14","Mercenary Captain's Pistol"),
                            array("102000239","0.14","Mercenary Captain's Harp"),
                            array("102000384","0.14","Mercenary Captain's Harp"),
                            array("102000394","0.14","Mercenary Captain's Harp"),
                            array("102100226","0.14","Mercenary Captain's Cipher-Blade"),
                            array("102100353","0.14","Mercenary Captain's Cipher-Blade"),
                            array("102100363","0.14","Mercenary Captain's Cipher-Blade"),
                            array("115000346","0.14","Mercenary Captain's Shield"),
                            array("115000591","0.14","Mercenary Captain's Shield"),
                            array("115000601","0.14","Mercenary Captain's Shield")
                          )
                        ),
                        // generiert aus Drops_Template_Weapon_Rare_Lvl9_Asmo.xml
                        array("100","WEAPON_RARE_9A","WEAPON_RARE_LVL9A",
                          array (
                            array("100000164","0.14","Night Sky Sword"),
                            array("100000452","0.14","Night Sky Sword"),
                            array("100000453","0.14","Night Sky Sword"),
                            array("100100078","0.14","Night Sky Warhammer"),
                            array("100100333","0.14","Night Sky Warhammer"),
                            array("100100343","0.14","Night Sky Warhammer"),
                            array("100200178","0.14","Night Sky Dagger"),
                            array("100200441","0.14","Night Sky Dagger"),
                            array("100200451","0.14","Night Sky Dagger"),
                            array("100600101","0.14","Night Sky Tome"),
                            array("100600360","0.14","Night Sky Tome"),
                            array("100600370","0.14","Night Sky Tome"),
                            array("101800236","0.14","Night Sky Pistol"),
                            array("101800390","0.14","Night Sky Pistol"),
                            array("101800400","0.14","Night Sky Pistol"),
                            array("102000249","0.14","Night Sky Harp"),
                            array("102000404","0.14","Night Sky Harp"),
                            array("102000414","0.14","Night Sky Harp"),
                            array("102100236","0.14","Night Sky Cipher-Blade"),
                            array("102100373","0.14","Night Sky Cipher-Blade"),
                            array("102100383","0.14","Night Sky Cipher-Blade"),
                            array("115000356","0.14","Night Sky Shield"),
                            array("115000611","0.14","Night Sky Shield"),
                            array("115000621","0.14","Night Sky Shield")
                          )
                        ),
                        // new with 4.9 from drop_template.xml
                        array("100","WEAPON_LEGEND_LVL20","WEAPON_LEGEND_LVL20",
                          array (
                            array("100000761","1.25","Nochsana Sword"),
                            array("100100576","1.25","Nochsana Warhammer"),
                            array("100200696","1.25","Nochsana Dagger"),
                            array("100500594","1.25","Nochsana Jewel"),
                            array("100600631","1.25","Nochsana Tome"),
                            array("100900586","1.25","Nochsana Greatsword"),
                            array("101300559","1.25","Nochsana Spear"),
                            array("101500600","1.25","Nochsana Staff"),
                            array("101700615","1.25","Nochsana Bow"),
                            array("101800571","1.25","Nochsana Pistol"),
                            array("101900566","1.25","Nochsana Aethercannon"),
                            array("102000596","1.25","Nochsana Harp"),
                            array("102100519","1.25","Nochsana Cipher-Blade"),
                            array("115000851","1.25","Nochsana Shield")
                          )
                        ),
                        // generiert aus Drops_Template_Weapon_Unique_Lvl50.xml
                        array("100","WEAPON_UNIQUE_50","WEAPON_UNIQUE_LVL50",
                          array (
                            array("100000318","0.05","Elder Sword"),
                            array("100100231","0.05","Elder Warhammer"),
                            array("100200339","0.05","Elder Dagger"),
                            array("100500242","0.05","Elder Jewel"),
                            array("100600258","0.05","Elder Tome"),
                            array("100900235","0.05","Elder Greatsword"),
                            array("101300232","0.05","Elder Spear"),
                            array("101500244","0.05","Elder Staff"),
                            array("101700256","0.05","Elder Longbow"),
                            array("101800312","0.05","Elder Pistol"),
                            array("101900313","0.05","Elder Aethercannon"),
                            array("102000326","0.05","Elder Harp"),
                            array("102100295","0.05","Elder Cipher-Blade"),
                            array("115000504","0.05","Elder Shield")
                          )
                        ),
                        // generiert aus Drops_Template_Weapon_Common.xml
                        array("100","WEAPON_COM59","WEAPON_COMMON_LVL59",
                          array (
                            array("100001186","1.6","Balaurbone Sword"),
                            array("100001187","1.6","Balaurbone Sword"),
                            array("100001188","1.6","Balaurbone Sword"),
                            array("100100897","1.6","Balaurbone Mace"),
                            array("100100898","1.6","Balaurbone Mace"),
                            array("100100899","1.6","Balaurbone Mace"),
                            array("100201050","1.6","Balaurbone Dagger"),
                            array("100201051","1.6","Balaurbone Dagger"),
                            array("100201052","1.6","Balaurbone Dagger"),
                            array("100500918","1.6","Balaurbone Jewel"),
                            array("100500919","1.6","Balaurbone Jewel"),
                            array("100500920","1.6","Balaurbone Jewel"),
                            array("100600972","1.6","Balaurbone Tome"),
                            array("100600973","1.6","Balaurbone Tome"),
                            array("100600974","1.6","Balaurbone Tome"),
                            array("100900901","1.6","Balaurbone Greatsword"),
                            array("100900902","1.6","Balaurbone Greatsword"),
                            array("100900903","1.6","Balaurbone Greatsword"),
                            array("101300864","1.6","Balaurbone Polearm"),
                            array("101300865","1.6","Balaurbone Polearm"),
                            array("101300866","1.6","Balaurbone Polearm"),
                            array("101500926","1.6","Balaurbone Staff"),
                            array("101500927","1.6","Balaurbone Staff"),
                            array("101500928","1.6","Balaurbone Staff"),
                            array("101700943","1.6","Balaurbone Bow"),
                            array("101700944","1.6","Balaurbone Bow"),
                            array("101700945","1.6","Balaurbone Bow"),
                            array("101800747","1.6","Balaurbone Pistol"),
                            array("101800748","1.6","Balaurbone Pistol"),
                            array("101800749","1.6","Balaurbone Pistol"),
                            array("101900753","1.6","Balaurbone Aethercannon"),
                            array("101900754","1.6","Balaurbone Aethercannon"),
                            array("101900755","1.6","Balaurbone Aethercannon"),
                            array("102000787","1.6","Balaurbone Harp"),
                            array("102000788","1.6","Balaurbone Harp"),
                            array("102000789","1.6","Balaurbone Harp"),
                            array("115001247","1.6","Balaurbone Shield"),
                            array("115001248","1.6","Balaurbone Shield"),
                            array("115001249","1.6","Balaurbone Shield")
                          )
                        ),
                        // generiert aus Drops_Template_Weapon_Legend.xml
                        array("100","WEAPON_LEG58","WEAPON_LEGEND_LVL58",
                          array (
                            array("100001192","0.08","Genesis Sword"),
                            array("100001193","0.08","Genesis Sword"),
                            array("100001194","0.08","Genesis Sword"),
                            array("100100903","0.08","Genesis Warhammer"),
                            array("100100904","0.08","Genesis Warhammer"),
                            array("100100905","0.08","Genesis Warhammer"),
                            array("100201056","0.08","Genesis Dagger"),
                            array("100201057","0.08","Genesis Dagger"),
                            array("100201058","0.08","Genesis Dagger"),
                            array("100500924","0.08","Genesis Jewel"),
                            array("100500925","0.08","Genesis Jewel"),
                            array("100500926","0.08","Genesis Jewel"),
                            array("100600978","0.08","Genesis Tome"),
                            array("100600979","0.08","Genesis Tome"),
                            array("100600980","0.08","Genesis Tome"),
                            array("100900907","0.08","Genesis Greatsword"),
                            array("100900908","0.08","Genesis Greatsword"),
                            array("100900909","0.08","Genesis Greatsword"),
                            array("101300870","0.08","Genesis Spear"),
                            array("101300871","0.08","Genesis Spear"),
                            array("101300872","0.08","Genesis Spear"),
                            array("101500932","0.08","Genesis Staff"),
                            array("101500933","0.08","Genesis Staff"),
                            array("101500934","0.08","Genesis Staff"),
                            array("101700949","0.08","Genesis Longbow"),
                            array("101700950","0.08","Genesis Longbow"),
                            array("101700951","0.08","Genesis Longbow"),
                            array("101800753","0.08","Genesis Pistol"),
                            array("101800754","0.08","Genesis Pistol"),
                            array("101800755","0.08","Genesis Pistol"),
                            array("101900759","0.08","Genesis Aethercannon"),
                            array("101900760","0.08","Genesis Aethercannon"),
                            array("101900761","0.08","Genesis Aethercannon"),
                            array("102000793","0.08","Genesis Harp"),
                            array("102000794","0.08","Genesis Harp"),
                            array("102000795","0.08","Genesis Harp"),
                            array("115001253","0.08","Genesis Shield"),
                            array("115001254","0.08","Genesis Shield"),
                            array("115001255","0.08","Genesis Shield")
                          )
                        ),
                        // generiert aus Drops_Template_Weapon_Unique_Lvl65.xml
                        array("100","WEAPON_UNI65","WEAPON_UNIQUE_LVL65",
                          array (
                            array("100001498","0.084","Savior's Sword"),
                            array("100101145","0.084","Savior's Mace"),
                            array("100201309","0.084","Savior's Dagger"),
                            array("100501151","0.084","Savior's Orb"),
                            array("100601233","0.084","Savior's Spellbook"),
                            array("100901161","0.084","Savior's Greatsword"),
                            array("101301096","0.084","Savior's Polearm"),
                            array("101501177","0.084","Savior's Staff"),
                            array("101701195","0.084","Savior's Bow"),
                            array("101800957","0.084","Savior's Pistol"),
                            array("101900944","0.084","Savior's Aethercannon"),
                            array("102001000","0.084","Savior's Harp"),
                            array("102100790","0.084","Savior's Cipher-Blade")
                          )
                        ),
                        // generiert aus Drops_Template_Weapon_Mythic_Lvl65.xml
                        array("100","WEAPON_MYTHIC_LVL65","WEAPON_MYTHIC_LVL65",
                          array (
                            array("100001791","0.001","Wave Song Sword"),
                            array("100101381","0.001","Wave Song Mace"),
                            array("100201556","0.001","Wave Song Dagger"),
                            array("100501349","0.001","Wave Song Orb"),
                            array("100601466","0.001","Wave Song Spellbook"),
                            array("100901418","0.001","Wave Song Greatsword"),
                            array("101301307","0.001","Wave Song Polearm"),
                            array("101501396","0.001","Wave Song Staff"),
                            array("101701402","0.001","Wave Song Bow"),
                            array("101801260","0.001","Wave Song Pistol"),
                            array("101901167","0.001","Wave Song Aethercannon"),
                            array("102001286","0.001","Wave Song Harp"),
                            array("102101103","0.001","Wave Song Cipher-Blade")
                          )
                        ),
                        //
                        //         1  1  0
                        //
                        // generiert aus Drops_Template_Armor_Common_Lvl2.xml
                        array("110","ARMOR_COMMON_2","ARMOR_COMMON_LVL2",
                          array (
                            array("110100355","0.59","Plainsman's Tunic"),
                            array("110100616","0.59","Plainsman's Tunic"),
                            array("110100626","0.59","Plainsman's Tunic"),
                            array("110300316","0.59","Plainsman's Jerkin"),
                            array("110300577","0.59","Plainsman's Jerkin"),
                            array("110300587","0.59","Plainsman's Jerkin"),
                            array("110500345","0.59","Plainsman's Hauberk"),
                            array("110500555","0.59","Plainsman's Hauberk"),
                            array("110500565","0.59","Plainsman's Hauberk"),
                            array("113100293","0.59","Plainsman's Leggings"),
                            array("113100542","0.59","Plainsman's Leggings"),
                            array("113100552","0.59","Plainsman's Leggings"),
                            array("113300303","0.59","Plainsman's Breeches"),
                            array("113300558","0.59","Plainsman's Breeches"),
                            array("113300568","0.59","Plainsman's Breeches"),
                            array("113500328","0.59","Plainsman's Chausses"),
                            array("113500531","0.59","Plainsman's Chausses"),
                            array("113500541","0.59","Plainsman's Chausses"),
                            array("114100311","0.59","Plainsman's Shoes"),
                            array("114100560","0.59","Plainsman's Shoes"),
                            array("114100570","0.59","Plainsman's Shoes"),
                            array("114300317","0.59","Plainsman's Boots"),
                            array("114300573","0.59","Plainsman's Boots"),
                            array("114300583","0.59","Plainsman's Boots"),
                            array("114500340","0.59","Plainsman's Brogans"),
                            array("114500539","0.59","Plainsman's Brogans"),
                            array("114500549","0.59","Plainsman's Brogans")
                          )
                        ),
                        // generiert aus Drops_Template_Armor_Common_Lvl4_Asmo.xml
                        array("110","ARMOR_COMMON_4A","ARMOR_COMMON_LVL4A",
                          array (
                            array("110100365","0.59","Tunic of the Prairie"),
                            array("110100636","0.59","Tunic of the Prairie"),
                            array("110100646","0.59","Tunic of the Prairie"),
                            array("110300326","0.59","Jerkin of the Prairie"),
                            array("110300597","0.59","Jerkin of the Prairie"),
                            array("110300607","0.59","Jerkin of the Prairie"),
                            array("110500355","0.59","Hauberk of the Prairie"),
                            array("110500575","0.59","Hauberk of the Prairie"),
                            array("110500585","0.59","Hauberk of the Prairie"),
                            array("113100303","0.59","Leggings of the Prairie"),
                            array("113100562","0.59","Leggings of the Prairie"),
                            array("113100572","0.59","Leggings of the Prairie"),
                            array("113300313","0.59","Breeches of the Prairie"),
                            array("113300578","0.59","Breeches of the Prairie"),
                            array("113300588","0.59","Breeches of the Prairie"),
                            array("113500338","0.59","Chausses of the Prairie"),
                            array("113500551","0.59","Chausses of the Prairie"),
                            array("113500561","0.59","Chausses of the Prairie"),
                            array("114100321","0.59","Shoes of the Prairie"),
                            array("114100580","0.59","Shoes of the Prairie"),
                            array("114100590","0.59","Shoes of the Prairie"),
                            array("114300327","0.59","Boots of the Prairie"),
                            array("114300593","0.59","Boots of the Prairie"),
                            array("114300603","0.59","Boots of the Prairie"),
                            array("114500350","0.59","Brogans of the Prairie"),
                            array("114500559","0.59","Brogans of the Prairie"),
                            array("114500569","0.59","Brogans of the Prairie")
                          )
                        ),
                        // generiert aus Drops_Template_Armor_Rare_Lvl7_Asmo.xml
                        array("110","ARMOR_RARE_7A","ARMOR_RARE_LVL7A",
                          array (
                            array("110100384","0.356","Aldelle's Tunic"),
                            array("110100674","0.356","Aldelle's Tunic"),
                            array("110100683","0.356","Aldelle's Tunic"),
                            array("110101648","0.356","Aldelle's Tunic"),
                            array("110300345","0.356","Aldelle's Jerkin"),
                            array("110300635","0.356","Aldelle's Jerkin"),
                            array("110300644","0.356","Aldelle's Jerkin"),
                            array("110500374","0.356","Aldelle's Hauberk"),
                            array("110500613","0.356","Aldelle's Hauberk"),
                            array("110500622","0.356","Aldelle's Hauberk"),
                            array("113100322","0.356","Aldelle's Leggings"),
                            array("113100600","0.356","Aldelle's Leggings"),
                            array("113100609","0.356","Aldelle's Leggings"),
                            array("113300332","0.356","Aldelle's Breeches"),
                            array("113300616","0.356","Aldelle's Breeches"),
                            array("113300625","0.356","Aldelle's Breeches"),
                            array("113500357","0.356","Aldelle's Chausses"),
                            array("113500589","0.356","Aldelle's Chausses"),
                            array("113500598","0.356","Aldelle's Chausses"),
                            array("114100340","0.356","Aldelle's Shoes"),
                            array("114100618","0.356","Aldelle's Shoes"),
                            array("114100627","0.356","Aldelle's Shoes"),
                            array("114300346","0.356","Aldelle's Boots"),
                            array("114300631","0.356","Aldelle's Boots"),
                            array("114300640","0.356","Aldelle's Boots"),
                            array("114500369","0.356","Aldelle's Brogans"),
                            array("114500597","0.356","Aldelle's Brogans"),
                            array("114500606","0.356","Aldelle's Brogans")
                          )
                        ),
                        // generiert aus Drops_Template_Armor_Rare_Lvl7_Elyos.xml
                        array("110","ARMOR_RARE_7E","ARMOR_RARE_LVL7E",
                          array (
                            array("110100375","0.356","Cliona Tunic"),
                            array("110100656","0.356","Cliona Tunic"),
                            array("110100665","0.356","Cliona Tunic"),
                            array("110101647","0.356","Cliona Tunic"),
                            array("110300336","0.356","Cliona Jerkin"),
                            array("110300617","0.356","Cliona Jerkin"),
                            array("110300626","0.356","Cliona Jerkin"),
                            array("110301650","0.356","Cliona Jerkin"),
                            array("110500365","0.356","Cliona Hauberk"),
                            array("110500595","0.356","Cliona Hauberk"),
                            array("110500604","0.356","Cliona Hauberk"),
                            array("113100313","0.356","Cliona Leggings"),
                            array("113100582","0.356","Cliona Leggings"),
                            array("113100591","0.356","Cliona Leggings"),
                            array("113300323","0.356","Cliona Breeches"),
                            array("113300598","0.356","Cliona Breeches"),
                            array("113300607","0.356","Cliona Breeches"),
                            array("113500348","0.356","Cliona Chausses"),
                            array("113500571","0.356","Cliona Chausses"),
                            array("113500580","0.356","Cliona Chausses"),
                            array("114100331","0.356","Cliona Shoes"),
                            array("114100600","0.356","Cliona Shoes"),
                            array("114100609","0.356","Cliona Shoes"),
                            array("114300337","0.356","Cliona Boots"),
                            array("114300613","0.356","Cliona Boots"),
                            array("114300622","0.356","Cliona Boots"),
                            array("114500360","0.356","Cliona Brogans"),
                            array("114500579","0.356","Cliona Brogans"),
                            array("114500588","0.356","Cliona Brogans")
                          )
                        ),
                        // generiert aus Drops_Template_Armor_Common_Lvl9.xml
                        array("110","ARMOR_COMMON_9","ARMOR_COMMON_LVL9",
                          array (
                            array("110100356","0.59","Canyon Tunic"),
                            array("110100617","0.59","Canyon Tunic"),
                            array("110100627","0.59","Canyon Tunic"),
                            array("110300317","0.59","Canyon Jerkin"),
                            array("110300578","0.59","Canyon Jerkin"),
                            array("110300588","0.59","Canyon Jerkin"),
                            array("110500346","0.59","Canyon Hauberk"),
                            array("110500556","0.59","Canyon Hauberk"),
                            array("110500566","0.59","Canyon Hauberk"),
                            array("113100294","0.59","Canyon Leggings"),
                            array("113100543","0.59","Canyon Leggings"),
                            array("113100553","0.59","Canyon Leggings"),
                            array("113300304","0.59","Canyon Breeches"),
                            array("113300559","0.59","Canyon Breeches"),
                            array("113300569","0.59","Canyon Breeches"),
                            array("113500329","0.59","Canyon Chausses"),
                            array("113500532","0.59","Canyon Chausses"),
                            array("113500542","0.59","Canyon Chausses"),
                            array("114100312","0.59","Canyon Shoes"),
                            array("114100561","0.59","Canyon Shoes"),
                            array("114100571","0.59","Canyon Shoes"),
                            array("114300318","0.59","Canyon Boots"),
                            array("114300574","0.59","Canyon Boots"),
                            array("114300584","0.59","Canyon Boots"),
                            array("114500341","0.59","Canyon Brogans"),
                            array("114500540","0.59","Canyon Brogans"),
                            array("114500550","0.59","Canyon Brogans")
                          )
                        ),
                        // generiert aus Drops_Template_Armor_Common_Lvl9_Asmo.xml
                        array("110","ARMOR_COMMON_9A","ARMOR_COMMON_LVL9A",
                          array (
                            array("110100366","0.59","Tunic of the Lake"),
                            array("110100637","0.59","Tunic of the Lake"),
                            array("110100647","0.59","Tunic of the Lake"),
                            array("110300327","0.59","Jerkin of the Lake"),
                            array("110300598","0.59","Jerkin of the Lake"),
                            array("110300608","0.59","Jerkin of the Lake"),
                            array("110500356","0.59","Hauberk of the Lake"),
                            array("110500576","0.59","Hauberk of the Lake"),
                            array("110500586","0.59","Hauberk of the Lake"),
                            array("113100304","0.59","Leggings of the Lake"),
                            array("113100563","0.59","Leggings of the Lake"),
                            array("113100573","0.59","Leggings of the Lake"),
                            array("113300314","0.59","Breeches of the Lake"),
                            array("113300579","0.59","Breeches of the Lake"),
                            array("113300589","0.59","Breeches of the Lake"),
                            array("113500339","0.59","Chausses of the Lake"),
                            array("113500552","0.59","Chausses of the Lake"),
                            array("113500562","0.59","Chausses of the Lake"),
                            array("114100322","0.59","Shoes of the Lake"),
                            array("114100581","0.59","Shoes of the Lake"),
                            array("114100591","0.59","Shoes of the Lake"),
                            array("114300328","0.59","Boots of the Lake"),
                            array("114300594","0.59","Boots of the Lake"),
                            array("114300604","0.59","Boots of the Lake"),
                            array("114500351","0.59","Brogans of the Lake"),
                            array("114500560","0.59","Brogans of the Lake"),
                            array("114500570","0.59","Brogans of the Lake")
                          )
                        ),
                        // new with 4.9 from drop_template.xml
                        array("110","ARMOR_LEGEND_LVL20","ARMOR_LEGEND_LVL20",
                          array (
                            array("110100784","0.75","Grounded Tunic"),
                            array("110300741","0.75","Grounded Jerkin"),
                            array("110500718","0.75","Grounded Hauberk"),
                            array("110600706","0.75","Grounded Breastplate"),
                            array("111100699","0.75","Grounded Gloves"),
                            array("111300701","0.75","Grounded Vambrace"),
                            array("111500688","0.75","Grounded Handguards"),
                            array("111600680","0.75","Grounded Gauntlets"),
                            array("112100659","0.75","Grounded Pauldrons"),
                            array("112300659","0.75","Grounded Shoulderguards"),
                            array("112500647","0.75","Grounded Spaulders"),
                            array("112600655","0.75","Grounded Shoulderplates"),
                            array("113100708","0.75","Grounded Leggings"),
                            array("113300724","0.75","Grounded Breeches"),
                            array("113500698","0.75","Grounded Chausses"),
                            array("113600672","0.75","Grounded Greaves"),
                            array("114100727","0.75","Grounded Shoes"),
                            array("114300740","0.75","Grounded Boots"),
                            array("114500706","0.75","Grounded Brogans"),
                            array("114600666","0.75","Grounded Sabatons")
                          )
                        ),
                        // generiert aus Drops_Template_Armor_Unique_Lvl50.xml
                        array("110","ARMOR_UNIQUE_50","ARMOR_UNIQUE_LVL50",
                          array (
                            array("110100575","0.05","Elder Tunic"),
                            array("110300536","0.05","Elder Jerkin"),
                            array("110500514","0.05","Elder Hauberk"),
                            array("110600509","0.05","Elder Breastplate"),
                            array("111100504","0.05","Elder Gloves"),
                            array("111300506","0.05","Elder Vambrace"),
                            array("111500493","0.05","Elder Handguards"),
                            array("111600480","0.05","Elder Gauntlets"),
                            array("112100468","0.05","Elder Pauldrons"),
                            array("112300468","0.05","Elder Shoulderguards"),
                            array("112500456","0.05","Elder Spaulders"),
                            array("112600461","0.05","Elder Shoulderplates"),
                            array("113100503","0.05","Elder Leggings"),
                            array("113300519","0.05","Elder Breeches"),
                            array("113500492","0.05","Elder Chausses"),
                            array("113600476","0.05","Elder Greaves"),
                            array("114100520","0.05","Elder Shoes"),
                            array("114300533","0.05","Elder Boots"),
                            array("114500499","0.05","Elder Brogans"),
                            array("114600466","0.05","Elder Sabatons")
                          )
                        ),
                        // generiert aus Drops_Template_Armor_Common_Lvl57.xml
                        array("110","ARMOR_COM57","ARMOR_COMMON_LVL57",
                          array (
                            array("110101303","2.7","Balaurbone Tunic"),
                            array("110101304","2.7","Balaurbone Tunic"),
                            array("110101305","2.7","Balaurbone Tunic"),
                            array("110301230","2.7","Balaurbone Jerkin"),
                            array("110301231","2.7","Balaurbone Jerkin"),
                            array("110301232","2.7","Balaurbone Jerkin"),
                            array("110501208","2.7","Balaurbone Hauberk"),
                            array("110501209","2.7","Balaurbone Hauberk"),
                            array("110501210","2.7","Balaurbone Hauberk"),
                            array("110601177","2.7","Balaurbone Breastplate"),
                            array("110601178","2.7","Balaurbone Breastplate"),
                            array("110601179","2.7","Balaurbone Breastplate"),
                            array("111101178","2.7","Balaurbone Gloves"),
                            array("111101179","2.7","Balaurbone Gloves"),
                            array("111101180","2.7","Balaurbone Gloves"),
                            array("111301173","2.7","Balaurbone Vambrace"),
                            array("111301174","2.7","Balaurbone Vambrace"),
                            array("111301175","2.7","Balaurbone Vambrace"),
                            array("111501167","2.7","Balaurbone Handguards"),
                            array("111501168","2.7","Balaurbone Handguards"),
                            array("111501169","2.7","Balaurbone Handguards"),
                            array("111601146","2.7","Balaurbone Gauntlets"),
                            array("111601147","2.7","Balaurbone Gauntlets"),
                            array("111601148","2.7","Balaurbone Gauntlets"),
                            array("112101136","2.7","Balaurbone Pauldrons"),
                            array("112101137","2.7","Balaurbone Pauldrons"),
                            array("112101138","2.7","Balaurbone Pauldrons"),
                            array("112301119","2.7","Balaurbone Shoulderguards"),
                            array("112301120","2.7","Balaurbone Shoulderguards"),
                            array("112301121","2.7","Balaurbone Shoulderguards"),
                            array("112501112","2.7","Balaurbone Spaulders"),
                            array("112501113","2.7","Balaurbone Spaulders"),
                            array("112501114","2.7","Balaurbone Spaulders"),
                            array("112601124","2.7","Balaurbone Shoulderplates"),
                            array("112601125","2.7","Balaurbone Shoulderplates"),
                            array("112601126","2.7","Balaurbone Shoulderplates"),
                            array("113101197","2.7","Balaurbone Leggings"),
                            array("113101198","2.7","Balaurbone Leggings"),
                            array("113101199","2.7","Balaurbone Leggings"),
                            array("113301199","2.7","Balaurbone Breeches"),
                            array("113301200","2.7","Balaurbone Breeches"),
                            array("113301201","2.7","Balaurbone Breeches"),
                            array("113501184","2.7","Balaurbone Chausses"),
                            array("113501185","2.7","Balaurbone Chausses"),
                            array("113501186","2.7","Balaurbone Chausses"),
                            array("113601137","2.7","Balaurbone Greaves"),
                            array("113601138","2.7","Balaurbone Greaves"),
                            array("113601139","2.7","Balaurbone Greaves"),
                            array("114101224","2.7","Balaurbone Shoes"),
                            array("114101225","2.7","Balaurbone Shoes"),
                            array("114101226","2.7","Balaurbone Shoes"),
                            array("114301230","2.7","Balaurbone Boots"),
                            array("114301231","2.7","Balaurbone Boots"),
                            array("114301232","2.7","Balaurbone Boots"),
                            array("114501188","2.7","Balaurbone Brogans"),
                            array("114501189","2.7","Balaurbone Brogans"),
                            array("114501190","2.7","Balaurbone Brogans"),
                            array("114601130","2.7","Balaurbone Sabatons"),
                            array("114601131","2.7","Balaurbone Sabatons"),
                            array("114601132","2.7","Balaurbone Sabatons")
                          )
                        ),
                        // generiert aus Drops_Template_Armor_Legend_Lvl60.xml
                        array("110","ARMOR_LEG60","ARMOR_LEGEND_LVL60",
                          array (
                            array("110101310","0.094","Genesis Tunic"),
                            array("110301237","0.094","Genesis Jerkin"),
                            array("110501215","0.094","Genesis Hauberk"),
                            array("111101185","0.094","Genesis Gloves"),
                            array("111301180","0.094","Genesis Vambrace"),
                            array("111501174","0.094","Genesis Handguards"),
                            array("111601153","0.094","Genesis Gauntlets"),
                            array("112101143","0.094","Genesis Pauldrons"),
                            array("112301126","0.094","Genesis Shoulderguards"),
                            array("112501119","0.094","Genesis Spaulders"),
                            array("112601131","0.094","Genesis Shoulderplates"),
                            array("113101204","0.094","Genesis Leggings"),
                            array("113301206","0.094","Genesis Breeches"),
                            array("113501191","0.094","Genesis Chausses"),
                            array("113601144","0.094","Genesis Greaves"),
                            array("114101231","0.094","Genesis Shoes"),
                            array("114301237","0.094","Genesis Boots"),
                            array("114501195","0.094","Genesis Brogans"),
                            array("114601137","0.094","Genesis Sabatons"),
                            // array("115001254","0.094","Genesis Shield") // doppelt
                          )
                        ),
                        // generiert aus Drops_Template_Armor_Rare_Lvl63.xml
                        array("110","ARMOR_RAR60","ARMOR_RARE_LVL60",
                          array (
                            array("110101554","0.099","Unyielding Tunic"),
                            array("110301451","0.099","Unyielding Jerkin"),
                            array("110501412","0.099","Unyielding Hauberk"),
                            array("110601387","0.099","Unyielding Breastplate"),
                            array("111101399","0.099","Unyielding Gloves"),
                            array("111301391","0.099","Unyielding Vambrace"),
                            array("111501369","0.099","Unyielding Handguards"),
                            array("111601349","0.099","Unyielding Gauntlets"),
                            array("112101353","0.099","Unyielding Pauldrons"),
                            array("112301335","0.099","Unyielding Shoulderguards"),
                            array("112501311","0.099","Unyielding Spaulders"),
                            array("112601331","0.099","Unyielding Shoulderplates"),
                            array("113101417","0.099","Unyielding Leggings"),
                            array("113301416","0.099","Unyielding Breeches"),
                            array("113501386","0.099","Unyielding Chausses"),
                            array("113601339","0.099","Unyielding Greaves"),
                            array("114101446","0.099","Unyielding Shoes"),
                            array("114301452","0.099","Unyielding Boots"),
                            array("114501394","0.099","Unyielding Brogans"),
                            array("114601337","0.099","Unyielding Sabatons"),
                            array("115001531","0.099","Unyielding Shield")
                          )
                        ),
                        // generiert aus Drops_Template_Armor_Unique_Lvl65.xml
                        array("110","ARMOR_UNI65","ARMOR_UNIQUE_LVL65",
                          array (
                            array("110101557","0.084","Savior's Tunic"),
                            array("110301454","0.084","Savior's Jerkin"),
                            array("110501415","0.084","Savior's Hauberk"),
                            array("110601390","0.084","Savior's Breastplate"),
                            array("111101402","0.084","Savior's Gloves"),
                            array("111301394","0.084","Savior's Vambrace"),
                            array("111501372","0.084","Savior's Handguards"),
                            array("111601352","0.084","Savior's Gauntlets"),
                            array("112101356","0.084","Savior's Pauldrons"),
                            array("112301338","0.084","Savior's Shoulderguards"),
                            array("112501314","0.084","Savior's Spaulders"),
                            array("112601334","0.084","Savior's Shoulderplates"),
                            array("113101420","0.084","Savior's Leggings"),
                            array("113301419","0.084","Savior's Breeches"),
                            array("113501389","0.084","Savior's Chausses"),
                            array("113601342","0.084","Savior's Greaves"),
                            array("114101449","0.084","Savior's Shoes"),
                            array("114301455","0.084","Savior's Boots"),
                            array("114501397","0.084","Savior's Brogans"),
                            array("114601340","0.084","Savior's Sabatons"),
                            array("115001534","0.084","Savior's Shield")
                          )
                        ),
                        // generiert aus Drops_Template_Armor_Epic_Lvl65.xml
                        array("110","ARMOR_EPIC_LVL65","ARMOR_EPIC_LVL65",
                          array (
                            array("110101870","0.005","Wave Song Jacket"),
                            array("110301862","0.005","Wave Song Jerkin"),
                            array("110551189","0.005","Wave Song Hauberk"),
                            array("110601657","0.005","Wave Song Breastplate"),
                            array("111101685","0.005","Wave Song Gloves"),
                            array("111301800","0.005","Wave Song Vambraces"),
                            array("111501748","0.005","Wave Song Handguards"),
                            array("111601620","0.005","Wave Song Gauntlets"),
                            array("112101634","0.005","Wave Song Pauldrons"),
                            array("112301739","0.005","Wave Song Shoulderguards"),
                            array("112501687","0.005","Wave Song Spaulders"),
                            array("112601602","0.005","Wave Song Shoulderplates"),
                            array("113101696","0.005","Wave Song Leggings"),
                            array("113301831","0.005","Wave Song Legguards"),
                            array("113501766","0.005","Wave Song Chausses"),
                            array("113601603","0.005","Wave Song Greaves"),
                            array("114101730","0.005","Wave Song Shoes"),
                            array("114301868","0.005","Wave Song Boots"),
                            array("114501776","0.005","Wave Song Brogans"),
                            array("114601610","0.005","Wave Song Plate Boots")
                          )
                        ),
                        //
                        //         1  2  0
                        //
                        // generiert aus Drops_Template_Accessory_Common_Lvl60.xml
                        array("120","ACCESSORY_COM60","ACCESSORY_COMMON_LVL60",
                          array (
                            array("120001154","4.8","Balaurbone Corundum Earrings"),
                            array("120001155","4.8","Balaurbone Turquoise Earrings"),
                            array("120001156","4.8","Balaurbone Elatrite Earrings"),
                            array("121001072","4.8","Balaurbone Corundum Necklace"),
                            array("121001073","4.8","Balaurbone Turquoise Necklace"),
                            array("121001074","4.8","Balaurbone Elatrite Necklace"),
                            array("122001313","4.8","Balaurbone Corundum Ring"),
                            array("122001314","4.8","Balaurbone Turquoise Ring"),
                            array("122001315","4.8","Balaurbone Elatrite Ring"),
                            array("123001125","4.8","Balaurbone Leather Belt"),
                            array("123001126","4.8","Balaurbone Sash"),
                            array("125002662","4.8","Balaurbone Headband"),
                            array("125002663","4.8","Balaurbone Hat"),
                            array("125002664","4.8","Balaurbone Chain Hood"),
                            array("125002665","4.8","Balaurbone Helm")
                          )
                        ),
                        //
                        //         1  2  5
                        //
                        // generiert aus Drops_Template_Accessory_Mythic_Lvl65.xml
                        array("125","ACCESSORY_MYTHIC_LVL65","ACCESSORY_MYTHIC_LVL65",
                          array (
                            array("125004237","0.001","Wave Song Plate Helmet"),
                            array("125004238","0.001","Wave Song Chain Helm"),
                            array("125004239","0.001","Wave Song Leather Hat"),
                            array("125004240","0.001","Wave Song Cloth Bandana"),
                            array("125004301","0.001","Wave Song Hairpin")
                          )
                        ),
                        //
                        //         1  5  2
                        //
                        // generiert aus Drops_Template_Balaur Mats_Lvl61.xml
                        array("152","BAL_MAT_61","BALAUR_MATS_LVL61",
                          array(
			                array("152014021","9.02","Gleaming Balaur Horn"),
			                array("152014022","9.02","Gleaming Balaur Scale"),
			                array("152014023","9.02","Gleaming Balaur Skin"),
			                array("152014024","9.02","Gleaming Balaur Blood"),
			                array("152014025","9.02","Gleaming Balaur Meat"),
			                array("186000235","9.02","Divine Balaur Heart")
                          )
                        ),
                        // generiert aus Drops_Template_Balaur Mats_Lvl50.xml
                        array("152","BALAUR MATS_50","BALAUR MATS_LVL50",
                          array (
                            array("152014011","9.02","Solid Balaur Horn"),
                            array("152014012","9.02","Solid Balaur Scale"),
                            array("152014013","9.02","Solid Balaur Skin"),
                            array("152014014","9.02","Boiling Balaur Blood Stain"),
                            array("152014015","9.02","Fresh Balaur Meat"),
                            array("186000033","9.02","Hot Balaur Heart")
                          )
                        ),
                       // aus Drop_Templates_Elemental_Stones.xml
                       array("152","ELEM_STONE","ELEMENTAL_STONES",
                         array (
                            array("152010325","11.5","Wispy Elemental Stone"),
			                array("152010326","21.5","Sublime Wispy Elemental Stone"),			
			                array("152010327","2.5","Resplendent Wispy Elemental Stone")
                          )
                        ),
                        // new with 4.9 from drops_template.xml
                        array("152","BALIC_MATERIAL_RARE_LVL30","BALIC_MATERIAL_RARE_LVL30",
                          array (
                            array("152013007","2.75","Vicious Terrifying Mind"),
                            array("152013013","2.75","Vicious Mind of Pleasure"),
                            array("152014001","2.75","Thick Balaur Horn"),
                            array("152014002","2.75","Thick Balaur Scale"),
                            array("152014003","2.75","Thick Balaur Skin"),
                            array("152014004","2.75","Cold Balaur Blood Stain"),
                            array("152014005","2.75","Tough Balaur Meat")
                          )
                        ),
                        // new with 4.9 Veredelungsstein Lvl48.xml
                        array("152","FLUX_COM48","FLUX_COMMON_LVL48",
                          array (
                            array("152011008","3.8","Premium Weapon Flux"),
                            array("152011028","3.8","Premium Armor Flux"),
                            array("152011048","3.8","Premium Accessory Flux")
                          )
                        ),
                        // new with 4.9 from template.xml
                        array("152","FLUX_COM18","FLUX_COMMON_LVL18",
                          array (
                            array("152011002","2.8","Lesser Weapon Flux"),
                            array("152011022","2.8","Lesser Armor Flux"),
                            array("152011042","2.8","Lesser Accessory Flux")
                          )
                        ),
                        // new with 4.9 from template.xml
                        array("152","FLUX_COM28","FLUX_COMMON_LVL28",
                          array (
                            array("152011004","2.80","Greater Weapon Flux"),
                            array("152011024","2.80","Greater Armor Flux"),
                            array("152011044","2.80","Greater Accessory Flux")
                          )
                        ),
                        // new with 4.9 from template.xml
                        array("152","FLUX_COM38","FLUX_COMMON_LVL38",
                          array (
                            array("152011006","2.80","Fine Weapon Flux"),
                            array("152011026","2.80","Fine Armor Flux"),
                            array("152011046","2.80","Fine Accessory Flux")
                          )
                        ),
                        // new with 4.9 Veredelungsstein Lvl53.xml
                        array("152","FLUX_COM53","FLUX_COMMON_LVL53",
                          array (
                            array("152011070","2.8","Special Greater Armor Flux"),
                            array("152011065","2.8","Special Greater Weapon Flux"),
                            array("152011075","2.8","Special Greater Accessory Flux")
                          )
                        ),
                        // new with 4.9 Veredelungsstein Lvl58.xml
                        array("152","FLUX_COM58","FLUX_COMMON_LVL58",
                          array (
                            array("152011080","1.8","Finest Weapon Flux"),
                            array("152011084","1.8","Finest Armor Flux"),
                            array("152011088","1.8","Finest Accessory Flux")
                          )
                        ),
                        // new with 4.9 Veredelungsstein Lvl61.xml
                        array("152","FLUX_COM61","FLUX_COMMON_LVL61",
                          array (
                            array("152011100","1.8","Lesser Mystic Weapon Flux"),
                            array("152011103","1.8","Lesser Mystic Armor Flux"),
                            array("152011106","1.8","Lesser Mystic Accessory Flux")
                          )
                        ),
                        //
                        //         1  6  0
                        //
                        // new with 4.9 from template.xml
                        array("160","OTHER_COM10","OTHER_COMMON_LVL10",
                          array (
                            array("160003551","2.90","Minor Rally Serum"),
                            array("160003557","2.90","Minor Focus Agent")
                          )
                        ),
                        // new with 4.9 from template.xml
                        array("160","OTHER_COM20","OTHER_COMMON_LVL20",
                          array (
                            array("160003552","2.80","Lesser Rally Serum"),
                            array("160003558","2.80","Lesser Focus Agent")
                          )
                        ),
                        // new with 4.9 from template.xml
                        array("160","OTHER_COM30","OTHER_COMMON_LVL30",
                          array (
                            array("160003553","2.70","Rally Serum"),
                            array("160003559","2.70","Focus Agent")
                          )
                        ),
                        // new with 4.9 from template.xml
                        array("160","OTHER_COM40","OTHER_COMMON_LVL40",
                          array (
                            array("160003554","2.60","Greater Rally Serum"),
                            array("160003560","2.60","Greater Focus Agent")
                          )
                        ),
                        // new with 4.9 from template.xml
                        array("160","OTHER_COM50","OTHER_COMMON_LVL50",
                          array (
                            array("160003555","2.50","Major Rally Serum"),
                            array("160003561","2.50","Major Focus Agent")
                          )
                        ),
                        // new with 4.9 from template.xml
                        array("160","OTHER_COM60","OTHER_COMMON_LVL60",
                          array (
                            array("160003556","2.40","Fine Rally Serum"),
                            array("160003562","2.40","Fine Focus Agent")
                          )
                        ),
                        //
                        //         1  6  6
                        //
                        // generiert aus Drops_Template_Idian_KALDOR.xml
                        array("166","IDIAN_LVL50","IDIAN_LVL50",
                          array (
                            array("166050032","3.0","Esoteric Idian: Magical Attack"),
                            array("166050057","5.0","Audacious Idian: Physical Defense"),
                            array("166050059","4.0","Sparkling Idian: Physical Attack")
                          )
                        ),
                        //
                        //          1  6  7
                        //  
                        // new with 4.9 Manastones Lvl10.xml
                        array("167","MANASTONES_10","MANASTONES_LVL10",
                          array (
                            array("188054199","0.5","Minor Manastone Ore")
                          )
                        ),
                        // new with 4.9 Manastones Lvl20.xml
                        array("167","MANASTONES_20","MANASTONES_LVL20",
                          array (
                            array("188054200","0.4","Lesser Manastone Ore")
                          )
                        ),
                        // new with 4.9 Manastones Lvl30.xml
                        array("167","MANASTONES_30","MANASTONES_LVL30",
                          array (
                            array("188054201","0.3","Manastone Ore")
                          )
                        ),
                        // new with 4.9 Manastones Lvl40.xml
                        array("167","MANASTONES_40","MANASTONES_LVL40",
                          array (
                            array("188054202","0.2","Greater Manastone Ore")
                          )
                        ),
                        // new with 4.9 Manastones Lvl50.xml
                        array("167","MANASTONES_50","MANASTONES_LVL50",
                          array (
                            array("188054203","0.1","Major Manastone Ore")
                          )
                        ),
                        // new with 4.9 Manastones LvL60.xml		
                        array("167","MS_60","MANASTONES_LVL60", 
                          array (                        	
			                array("188054204","0.01","Fine Manastone Ore")
                          )
                        ),
                        // new with 4.9 Manastones LvL70.xml			
                        array("167","MS_70","MANASTONES_LVL70", 
                          array (                        	
			                array("188054205","0.02","Superior Manastone Ore")
                          )
                        ),
                        // aus Drop_Templates_Manastones_LvL70.xml
                        array("167","MS_70_A","MANASTONE_ANCIENT_LVL70",
                          array (
                            array("167000358","2.52","Manastone: Attack +3"),
			                array("167000758","2.52","Manastone: HP +80"),
			                array("167000759","2.52","Manastone: MP +80"),
			                array("167000760","2.52","Manastone: Accuracy +24"),
			                array("167000761","2.52","Manastone: Evasion +16"),
			                array("167000762","2.52","Manastone: Magic Boost +24"),
			                array("167000763","2.52","Manastone: Parry +24"),
			                array("167000764","2.52","Manastone: Block +24"),
			                array("167000765","2.52","Manastone: Crit Strike +16"),
			                array("167000518","1.52","Manastone: Attack +5"),
			                array("167000766","1.52","Manastone: HP +100"),
			                array("167000767","1.52","Manastone: MP +105"),
			                array("167000768","1.52","Manastone: Accuracy +29"),
			                array("167000769","1.52","Manastone: Evasion +19"),
			                array("167000770","1.52","Manastone: Magic Boost +28"),
			                array("167000771","1.52","Manastone: Parry +29"),
			                array("167000772","1.52","Manastone: Block +29"),
			                array("167000773","1.52","Manastone: Crit Strike +19"),
			                array("167000775","1.52","Manastone: Magical Accuracy +16"),
			                array("167000776","1.52","Manastone: Resist Magic +16"),
			                array("167000777","1.52","Manastone: Crit Spell +5"),
			                array("167000778","1.52","Manastone: Magical Critical Resistance +5")
                          )
                        ),
                        // aus Drop_Templates_Manastones_LvL70_Ancient.xml	
                        array("167","MS_70_AN","MANASTONE_ANCIENT_LVL70_AN", 
                          array (                        			
			                array("167020041","1.02","Ancient Manastone: Accuracy +29"),
			                array("167020042","1.02","Ancient Manastone: Evasion +19"),
			                array("167020043","1.02","Ancient Manastone: Parry +29"),
			                array("167020044","1.02","Ancient Manastone: Block +29"),
			                array("167020045","1.02","Ancient Manastone: Crit Strike +18"),
			                array("167020046","1.02","Ancient Manastone: Physical Critical Resistance +20"),
			                array("167020047","1.02","Ancient Manastone: Crit Spell +6"),
			                array("167020048","1.02","Ancient Manastone: Magical Critical Resistance +7"),
			                array("167020049","1.02","Ancient Manastone: Physical Defense +60"),
			                array("167020050","1.02","Ancient Manastone: Resist Magic +17"),
			                array("167020051","1.02","Ancient Manastone: Attack +5"),
			                array("167020052","1.02","Ancient Manastone: Magical Accuracy +16"),
			                array("167020053","1.02","Ancient Manastone: Magic Boost +28"),
			                array("167020054","1.02","Ancient Manastone: Magic Suppression +30"),
			                array("167020055","1.02","Ancient Manastone: Healing Boost +4"),
			                array("167020024","0.11","Ancient Manastone: HP +105"),
			                array("167020025","0.11","Ancient Manastone: MP +120"),
			                array("167020026","0.11","Ancient Manastone: Accuracy +31"),
			                array("167020027","0.11","Ancient Manastone: Evasion +21"),
			                array("167020028","0.11","Ancient Manastone: Parry +31"),
			                array("167020029","0.11","Ancient Manastone: Block +31"),
			                array("167020030","0.11","Ancient Manastone: Crit Strike +20"),
			                array("167020031","0.11","Ancient Manastone: Strike Resist +21"),
			                array("167020032","0.11","Ancient Manastone: Crit Spell +7"),
			                array("167020033","0.11","Ancient Manastone: Magical Critical Resistance +8"),
			                array("167020034","0.11","Ancient Manastone: Physical Defense +70"),
			                array("167020035","0.11","Ancient Manastone: Resist Magic +19"),
			                array("167020036","0.11","Ancient Manastone: Attack +6"),
			                array("167020037","0.11","Ancient Manastone: Magical Accuracy +18"),
			                array("167020038","0.11","Ancient Manastone: Magic Boost +30"),
			                array("167020039","0.11","Ancient Manastone: Magic Suppression +40"),
			                array("167020040","0.11","Ancient Manastone: Healing Boost +5"),
			                array("167020056","0.03","Ancient Manastone: Accuracy +33"),
			                array("167020057","0.03","Ancient Manastone: Evasion +23"),
			                array("167020058","0.03","Ancient Manastone: Parry +33"),
			                array("167020059","0.03","Ancient Manastone: Block +33"),
			                array("167020060","0.03","Ancient Manastone: Physical Critical Resistance +22"),
			                array("167020061","0.03","Ancient Manastone: Magical Critical Resistance +9"),
			                array("167020062","0.03","Ancient Manastone: Physical Defense +80"),
			                array("167020063","0.03","Ancient Manastone: Attack +7"),
			                array("167020064","0.03","Ancient Manastone: Magical Accuracy +20"),
			                array("167020065","0.03","Ancient Manastone: Magic Boost +32")
                          )
                        ),
                        // aus Drops_Template_Manastones_Other.xml
                        array("167","MS_OTHER","MANASTONE_ANCIENT_OTHER", 
                          array (                        
                            array("167020006","0.16","Ancient Manastone: HP +105"),
                            array("167020007","0.16","Ancient Manastone: MP +120"),
                            array("167020008","0.16","Ancient Manastone: Accuracy +31"),
                            array("167020009","0.16","Ancient Manastone: Evasion +21"),
                            array("167020010","0.16","Ancient Manastone: Parry +31"),
                            array("167020011","0.16","Ancient Manastone: Block +31"),
                            array("167020012","0.16","Ancient Manastone: Crit Strike +20"),
                            array("167020013","0.16","Ancient Manastone: Physical Critical Resistance +18"),
                            array("167020014","0.16","Ancient Manastone: Crit Spell +7"),
                            array("167020015","0.16","Ancient Manastone: Spell Resist +7"),
                            array("167020016","0.16","Ancient Manastone: Physical Defense +50"),
                            array("167020017","0.16","Ancient Manastone: Resist Magic +19"),
                            array("167020018","0.16","Ancient Manastone: Attack +6"),
                            array("167020019","0.16","Ancient Manastone: Magical Accuracy +18"),
                            array("167020020","0.16","Ancient Manastone: Magic Boost +30"),
                            array("167020021","0.16","Ancient Manastone: Magic Suppression +40"),
                            array("167020022","0.16","Ancient Manastone: Recovery Boost +5")
                          )
                        ),
                        //
                        //          1  6  8
                        // 
                        // generiert aus Drops_Template_Godstones.xml
                        array("168","GODSTONES","GODSTONES",
                          array (
                            array("168000034","0.008","Godstone: Fasimedes' Majesty"),
                            array("168000035","0.008","Godstone: Vidar's Dignity"),
                            array("168000036","0.008","Godstone: Helkes' Revenge"),
                            array("168000039","0.008","Godstone: Deltras' Loyalty"),
                            array("168000041","0.008","Godstone: Orissan's Blood"),
                            array("168000042","0.008","Godstone: Mahisha's Wrath"),
                            array("168000043","0.008","Godstone: Boreas' Encouragement"),
                            array("168000044","0.008","Godstone: Charna's Cleverness"),
                            array("168000045","0.008","Godstone: Thrasymedes' Wit"),
                            array("168000046","0.008","Godstone: Jumentis' Agility"),
                            array("168000047","0.008","Godstone: Traufnir's Bravery"),
                            array("168000048","0.008","Godstone: Sif's Knowledge"),
                            array("168000049","0.008","Godstone: Freyr's Wisdom"),
                            array("168000050","0.008","Godstone: Sigyn's Intelligence"),
                            array("168000072","0.008","Godstone: Freyr's Rest"),
                            array("168000073","0.008","Godstone: Khrudgelmir's Tacitness"),
                            array("168000074","0.008","Godstone: Bollvig's Tragedy"),
                            array("168000075","0.008","Godstone: Ieo's Sadness"),
                            array("168000117","0.002","Godstone: Meslamtaeda's Greed"),
                            array("168000118","0.002","Godstone: Ereshkigal's Honor"),
                            array("168000119","0.002","Godstone: Nezekan's Advance"),
                            array("168000120","0.002","Godstone: Beritra's Plot"),
                            array("168000121","0.002","Godstone: Fregion's Trick"),
                            array("168000122","0.002","Godstone: Lumiel's Intervention"),
                            array("168000123","0.002","Godstone: Kaisinel's Fantasy"),
                            array("168000124","0.002","Godstone: Zikel's Arrogance"),
                            array("168000125","0.002","Godstone: Fregion's Stratagem"),
                            array("168000126","0.002","Godstone: Tiamat's Counterattack"),
                            array("168000127","0.002","Godstone: Marchutan's Impartiality"),
                            array("168000128","0.002","Godstone: Yustiel's Generosity"),
                            array("168000129","0.002","Godstone: Beritra's Selfishness"),
                            array("168000130","0.002","Godstone: Tiamat's Fury"),
                            array("168000131","0.002","Godstone: Triniel's Rationality"),
                            array("168000132","0.002","Godstone: Vaizel's Vow"),
                            array("168000133","0.002","Godstone: Meslamtaeda's Regret")
                          )
                        ),
                        // aus Drop_Templates_Illusion_Godstones.xml
                        array("168","ILLU_GODSTONE","ILLUSION_GODSTONES",
                          array (
			                array("168000161","0.01","Illusion Godstone: Meslamtaeda's Greed"),
			                array("168000162","0.01","Illusion Godstone: Ereshkigal's Honor"),
			                array("168000163","0.01","Illusion Godstone: Nezekan's Advance"),
			                array("168000164","0.01","Illusion Godstone: Beritra's Plot"),
			                array("168000165","0.01","Illusion Godstone: Fregion's Trick"),
			                array("168000166","0.01","Illusion Godstone: Lumiel's Intervention"),
			                array("168000167","0.01","Illusion Godstone: Kaisinel's Fantasy"),
			                array("168000168","0.01","Illusion Godstone: Zikel's Arrogance"),
			                array("168000169","0.01","Illusion Godstone: Fregion's Stratagem"),
			                array("168000170","0.01","Illusion Godstone: Tiamat's Counterattack"),
			                array("168000171","0.01","Illusion Godstone: Marchutan's Impartiality"),
			                array("168000172","0.01","Illusion Godstone: Yustiel's Generosity"),
			                array("168000173","0.01","Illusion Godstone: Beritra's Selfishness"),
			                array("168000174","0.01","Illusion Godstone: Tiamat's Fury"),
			                array("168000175","0.01","Illusion Godstone: Triniel's Rationality"),
			                array("168000176","0.01","Illusion Godstone: Vaizel's Vow"),
			                array("168000177","0.01","Illusion Godstone: Meslamtaeda's Regret"),
			                array("168000212","0.03","Illusion Godstone: Aion's Sorrow"),
			                array("168000213","0.03","Illusion Godstone: Fasimedes' Authority"),
			                array("168000214","0.03","Illusion Godstone: Thrasymedes' Foresight"),
			                array("168000215","0.03","Illusion Godstone: Freyr’s Esprit"),
			                array("168000216","0.03","Illusion Godstone: Vidar's Nobility"),
			                array("168000217","0.03","Illusion Godstone: Charna's Cleverness"),
			                array("168000218","0.03","Illusion Godstone: Sif's Extensive Knowledge"),
			                array("168000219","0.03","Illusion Godstone: Jumentis' Agility"),
			                array("168000220","0.03","Illusion Godstone: Sigyn's Brightness"),
			                array("168000221","0.03","Illusion Godstone: Boreas' Encouragement"),
			                array("168000222","0.03","Illusion Godstone: Traufnir's Spirit"),
			                array("168000223","0.03","Illusion Godstone: Bollvig's Grief"),
			                array("168000224","0.03","Illusion Godstone: Helkes' Vengeance"),
			                array("168000225","0.03","Illusion Godstone: Deltras' Loyalty"),
			                array("168000226","0.03","Illusion Godstone: Orissan’s Blood"),
			                array("168000227","0.03","Illusion Godstone: Mahisha's Wrath"),
			                array("168000228","0.03","Illusion Godstone: Khrudgelmir's Silence")
                          )
                        ),
                        //
                        //         1  8  8
                        //
                        // generiert aus Drops_Template_Manastone_Box_KALDOR.xml
                        array("188","MANASTONE_BOX","MANASTONE_BOX",
                          array (
                            array("188053322","7.0","Levinshor Alliance Manastone Box"),
                            array("188053325","3.0","Heavy Ancient Manastone Box of Levinshor Alliance"),
                            array("188053328","5.0","Levinshor Alliance Heavy Composite Manastone Box")
                          )
                        ),
                        // generiert aus Drops_Template_Stigma_Bundles.xml
                        array("188","STIGMA_BUNDLE","STIGMA_BUNDLE",
                          array (
                            array("188053750","0.01","Gladiator Stigma Bundle"),
                            array("188053751","0.01","Templar Stigma Bundle"),
                            array("188053752","0.01","Assassin Stigma Bundle"),
                            array("188053753","0.01","Ranger Stigma Bundle"),
                            array("188053754","0.01","Sorcerer Stigma Bundle"),
                            array("188053755","0.01","Spiritmaster Stigma Bundle"),
                            array("188053756","0.01","Cleric Stigma Bundle"),
                            array("188053757","0.01","Chanter Stigma Bundle"),
                            array("188053758","0.01","Gunslinger Stigma Bundle"),
                            array("188053759","0.01","Aethertech Stigma Bundle"),
                            array("188053760","0.01","Songweaver Stigma Bundle"),
                            // generiert aus Drops_Template_Greater_Stigma_Bundles.xml
                            array("188053761","0.001","Gladiator Greater Stigma Bundle"),
                            array("188053762","0.001","Templar Greater Stigma Bundle"),
                            array("188053763","0.001","Assassin Greater Stigma Bundle"),
                            array("188053764","0.001","Ranger Greater Stigma Bundle"),
                            array("188053765","0.001","Sorcerer Greater Stigma Bundle"),
                            array("188053766","0.001","Spiritmaster Greater Stigma Bundle"),
                            array("188053767","0.001","Cleric Greater Stigma Bundle"),
                            array("188053768","0.001","Chanter Greater Stigma Bundle"),
                            array("188053769","0.001","Gunslinger Greater Stigma Bundle"),
                            array("188053770","0.001","Aethertech Greater Stigma Bundle"),
                            array("188053771","0.001","Songweaver Greater Stigma Bundle")
                          )
                        ),
                        // generiert aus Drops_Template_Manastone_Bundle.xml
                        array("188","MANASTONE_BUNDLE","MANASTONE_BUNDLE",
                          array (
                            array("188053742","75.00","Faded Middle Grade Manastone Bundle"),
                            array("188053743","55.00","Faded High Grade Manastone Bundle"),
                            array("188053904","45.00","Faded Middle Grade Composite Manastone Bundle"),
                            array("188053905","25.00","Faded High Grade Composite Manastone Bundle")
                          )
                        ),
                        //
                        //         1  8  9
                        //
                        // new with 4.9 Other_Items Drops in Levinshor, kaldor, Cygnea and Enshar
                        array("189","OTHER_ITEMS","OTHER_ITEMS",
                          array (
                            array("185000223","0.001","Aetheric Field Fragment"),
                            array("185000243","0.001","Aetheric Field Piece")
                          )
                        ),
                        //
                        //         1  9  0
                        //
                        // Omega Enchantment Stone
                        array("190","ENCHANTMENT_MYTHIC","ENCHANTMENT_MYTHIC",
                          array (
                            array("166020000","0.0001","Omega Enchantment Stone")
                          )
                        )
                      );
?>