/**
 * This file is part of Aion-Lightning <aion-lightning.org>.
 *
 *  Aion-Lightning is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Aion-Lightning is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details. *
 *  You should have received a copy of the GNU General Public License
 *  along with Aion-Lightning.
 *  If not, see <http://www.gnu.org/licenses/>.
 */
package com.aionemu.gameserver.network.factories;

import com.aionemu.gameserver.network.aion.AionClientPacket;
import com.aionemu.gameserver.network.aion.AionConnection.State;
import com.aionemu.gameserver.network.aion.AionPacketHandler;
import com.aionemu.gameserver.network.aion.clientpackets.*;

/**
 * This factory is responsible for creating {@link AionPacketHandler} object. It also initializes created handler with a
 * set of packet prototypes.<br>
 * Object of this classes uses <tt>Injector</tt> for injecting dependencies into prototype objects.<br>
 * <br>
 *
 * @author Luno, Alcapwnd, Ever, Falke34, FrozenKiller
 * @version 4.8.x.x
 */
public class AionPacketHandlerFactory {

    private AionPacketHandler handler;

    public static AionPacketHandlerFactory getInstance() {
        return SingletonHolder.instance;
    }

    /**
     * Creates new instance of <tt>AionPacketHandlerFactory</tt><br>
     */
    public AionPacketHandlerFactory() {

        handler = new AionPacketHandler();
        
		addPacket(new CM_UI_SETTINGS(0xC4, State.IN_GAME)); // 4.9
		addPacket(new CM_MOTION(0x101, State.IN_GAME)); // 4.9
		addPacket(new CM_WINDSTREAM(0x100, State.IN_GAME)); // 4.9
		addPacket(new CM_STOP_TRAINING(0x112, State.IN_GAME)); // 4.9
		addPacket(new CM_REVIVE(0xC3, State.IN_GAME)); // 4.9
		addPacket(new CM_DUEL_REQUEST(0x14C, State.IN_GAME)); // 4.9
		addPacket(new CM_CRAFT(0x14B, State.IN_GAME)); // 4.9
		addPacket(new CM_QUESTION_RESPONSE(0x10C, State.IN_GAME)); // 4.9
		addPacket(new CM_OPEN_STATICDOOR(0xD1, State.IN_GAME)); // 4.9
		addPacket(new CM_SPLIT_ITEM(0x15B, State.IN_GAME)); // 4.9
		addPacket(new CM_CUSTOM_SETTINGS(0xCA, State.IN_GAME)); // 4.9
		addPacket(new CM_PLAY_MOVIE_END(0x12F, State.IN_GAME)); // 4.9
		addPacket(new CM_LEVEL_READY(0xC7, State.IN_GAME)); // 4.9
		addPacket(new CM_ENTER_WORLD(0xC6, State.AUTHED)); // 4.9
		addPacket(new CM_TIME_CHECK(0xEC, State.CONNECTED, State.AUTHED, State.IN_GAME)); // 4.9
		addPacket(new CM_QUIT(0xDD, State.AUTHED, State.IN_GAME)); // 4.9
		addPacket(new CM_L2AUTH_LOGIN_CHECK(0x153, State.CONNECTED)); // 4.9
		addPacket(new CM_CHARACTER_LIST(0x150, State.AUTHED)); // 4.9
		addPacket(new CM_CREATE_CHARACTER(0x151, State.AUTHED)); // 4.9
		addPacket(new CM_MAC_ADDRESS(0x17B, State.CONNECTED, State.AUTHED, State.IN_GAME)); // 4.9
		addPacket(new CM_CHARACTER_PASSKEY(0x1AC, State.AUTHED)); // 4.9
		addPacket(new CM_MAY_LOGIN_INTO_GAME(0x174, State.AUTHED)); // 4.9
		addPacket(new CM_MOVE(0x10E, State.IN_GAME)); // 4.8
		addPacket(new CM_CASTSPELL(0xFF, State.IN_GAME)); // 4.9
		addPacket(new CM_EMOTION(0xE5, State.IN_GAME)); // 4.9
		addPacket(new CM_TITLE_SET(0x145, State.IN_GAME)); // 4.9 TODO
		addPacket(new CM_DELETE_ITEM(0x132, State.IN_GAME)); // 4.9
		addPacket(new CM_QUEST_SHARE(0x162, State.IN_GAME)); // 4.9
		addPacket(new CM_DELETE_QUEST(0x12E, State.IN_GAME)); // 4.9
		addPacket(new CM_ABYSS_RANKING_PLAYERS(0x17A, State.IN_GAME)); // 4.9
		addPacket(new CM_ABYSS_RANKING_LEGIONS(0x130, State.IN_GAME)); // 4.9
		addPacket(new CM_PRIVATE_STORE(0x131, State.IN_GAME)); // 4.9
		addPacket(new CM_USE_ITEM(0xE3, State.IN_GAME)); // 4.9
		addPacket(new CM_TARGET_SELECT(0xD9, State.IN_GAME)); // 4.9
		addPacket(new CM_SHOW_DIALOG(0x2F2, State.IN_GAME)); // 4.9
		addPacket(new CM_CHECK_NICKNAME(0x18F, State.AUTHED)); // 4.9
		addPacket(new CM_PRIVATE_STORE_NAME(0x136, State.IN_GAME)); // 4.9
		addPacket(new CM_DELETE_CHARACTER(0x156, State.AUTHED)); // 4.9
		addPacket(new CM_RESTORE_CHARACTER(0x157, State.AUTHED)); // 4.9
		addPacket(new CM_MACRO_CREATE(0x169, State.IN_GAME)); // 4.9
		addPacket(new CM_MACRO_DELETE(0x18E, State.IN_GAME)); // 4.9
		addPacket(new CM_GATHER(0xED, State.IN_GAME)); // 4.9
		addPacket(new CM_INSTANCE_INFO(0x19E, State.IN_GAME)); // 4.9
		addPacket(new CM_CLIENT_COMMAND_ROLL(0x125, State.IN_GAME)); // 4.9
		addPacket(new CM_START_LOOT(0x154, State.IN_GAME)); // 4.9
		addPacket(new CM_CLOSE_DIALOG(0x2F3, State.IN_GAME)); // 4.9
		addPacket(new CM_DIALOG_SELECT(0x2F0, State.IN_GAME)); // 4.9
		addPacket(new CM_BUY_ITEM(0x10D, State.IN_GAME)); // 4.9
		addPacket(new CM_EQUIP_ITEM(0xE0, State.IN_GAME)); // 4.9
		addPacket(new CM_TELEPORT_SELECT(0x152, State.IN_GAME)); // 4.9
		addPacket(new CM_LOOT_ITEM(0x155, State.IN_GAME)); // 4.9
		addPacket(new CM_QUESTIONNAIRE(0x16F, State.IN_GAME)); // 4.9
		addPacket(new CM_ATTACK(0xFE, State.IN_GAME)); // 4.9
		addPacket(new CM_PET(0xD0, State.IN_GAME)); // 4.9
		addPacket(new CM_TUNE(0x1A5, State.IN_GAME)); // 4.9
		addPacket(new CM_PET_EMOTE(0xD3, State.IN_GAME)); // 4.9
		addPacket(new CM_CHALLENGE_LIST(0x1A6, State.IN_GAME)); // 4.9

		// ********************(FRIEND LIST)*********************
		addPacket(new CM_SHOW_FRIENDLIST(0x1A0, State.IN_GAME)); // 4.9
		addPacket(new CM_FRIEND_ADD(0x129, State.IN_GAME)); // 4.9
		addPacket(new CM_FRIEND_DEL(0x14E, State.IN_GAME)); // 4.9
		addPacket(new CM_FRIEND_STATUS(0x164, State.IN_GAME)); // 4.9
        addPacket(new CM_FRIEND_EDIT(0x1A9, State.IN_GAME)); // 4.9 (NEW)(Notiz Friendlist)	
		addPacket(new CM_SET_NOTE(0x2F4, State.IN_GAME)); // 4.9       	
		addPacket(new CM_MARK_FRIENDLIST(0x128, State.IN_GAME)); // 4.9
		addPacket(new CM_SHOW_BLOCKLIST(0x158, State.IN_GAME)); // 4.9
		addPacket(new CM_BLOCK_ADD(0x160, State.IN_GAME)); // 4.9
		addPacket(new CM_BLOCK_DEL(0x161, State.IN_GAME)); // 4.9
		addPacket(new CM_PLAYER_SEARCH(0x159, State.IN_GAME)); // 4.9
				
		// ********************(LEGION)*********************
		addPacket(new CM_LEGION(0xEB, State.IN_GAME)); // 4.9
		addPacket(new CM_LEGION_WH_KINAH(0x10A, State.IN_GAME)); // 4.9
		addPacket(new CM_LEGION_UPLOAD_INFO(0x17E, State.IN_GAME)); // 4.9
		addPacket(new CM_LEGION_UPLOAD_EMBLEM(0x17F, State.IN_GAME)); // 4.9
		addPacket(new CM_LEGION_SEARCH(0x1BA, State.IN_GAME)); //4.9
		addPacket(new CM_LEGION_JOIN_REQUEST(0x1BB, State.IN_GAME)); //4.9
		addPacket(new CM_LEGION_JOIN_REQUEST_CANCEL(0x1B8, State.IN_GAME)); //4.9
        addPacket(new CM_LEGION_SEND_EMBLEM_INFO(0xEE, State.IN_GAME)); // 4.9
		addPacket(new CM_LEGION_SEND_EMBLEM(0xE9, State.IN_GAME)); // 4.9
		addPacket(new CM_LEGION_MODIFY_EMBLEM(0x2F5, State.IN_GAME)); // 4.9
		addPacket(new CM_LEGION_TABS(0x2F1, State.IN_GAME)); // 4.9
		addPacket(new CM_STONESPEAR_SIEGE(0xDB, State.IN_GAME)); // 4.9 TODO
		
		// ******************(GROUP)******************* (BUGGY)
		addPacket(new CM_FIND_GROUP(0x10B, State.IN_GAME)); // 4.9
		addPacket(new CM_AUTO_GROUP(0x186, State.IN_GAME)); // 4.9
		addPacket(new CM_INVITE_TO_GROUP(0x13F, State.IN_GAME)); // 4.9
		addPacket(new CM_GROUP_DISTRIBUTION(0x12A, State.IN_GAME)); // 4.9
		addPacket(new CM_GROUP_LOOT(0x176, State.IN_GAME)); // 4.9
		addPacket(new CM_GROUP_DATA_EXCHANGE(0x109, State.IN_GAME)); //TODO find 18B
		addPacket(new CM_DISTRIBUTION_SETTINGS(0x177, State.IN_GAME)); // 4.9
		addPacket(new CM_SHOW_BRAND(0x173, State.IN_GAME)); // 4.9 (Group Mark Target etc)
		
		// ******************(BROKER)******************
		addPacket(new CM_BROKER_LIST(0x135, State.IN_GAME)); // 4.9
		addPacket(new CM_BROKER_SEARCH(0x13A, State.IN_GAME)); // 4.9
		addPacket(new CM_REGISTER_BROKER_ITEM(0x139, State.IN_GAME)); // 4.9
		addPacket(new CM_BROKER_ADD_ITEM(0x133, State.IN_GAME)); // 4.9
		addPacket(new CM_BROKER_SETTLE_LIST(0x15F, State.IN_GAME)); // 4.9
		addPacket(new CM_BROKER_REGISTERED(0x13B, State.IN_GAME)); // 4.9
		addPacket(new CM_BUY_BROKER_ITEM(0x138, State.IN_GAME)); // 4.9
		addPacket(new CM_BROKER_CANCEL_REGISTERED(0x15E, State.IN_GAME)); // 4.9
		addPacket(new CM_BROKER_SETTLE_ACCOUNT(0x15C, State.IN_GAME)); // 4.9
		
		// ******************(PING)******************
		addPacket(new CM_PING_REQUEST(0x121, State.IN_GAME)); // 4.9
		addPacket(new CM_PING(0xEA, State.AUTHED, State.IN_GAME)); // 4.9

		// ******************(SUMMON)******************
		addPacket(new CM_SUMMON_EMOTION(0x184, State.IN_GAME)); // 4.9
		addPacket(new CM_SUMMON_ATTACK(0x185, State.IN_GAME)); // 4.9
		addPacket(new CM_SUMMON_CASTSPELL(0x190, State.IN_GAME)); // 4.9
		addPacket(new CM_SUMMON_COMMAND(0x137, State.IN_GAME)); // 4.9
		addPacket(new CM_SUMMON_MOVE(0x187, State.IN_GAME)); // 4.9
		
		// ******************(MAIL)******************
		addPacket(new CM_CHECK_MAIL_SIZE(0x143, State.IN_GAME)); // 4.9
		addPacket(new CM_CHECK_MAIL_SIZE2(0x193, State.IN_GAME)); // 4.9
		addPacket(new CM_SEND_MAIL(0x142, State.IN_GAME)); // 4.9
		addPacket(new CM_READ_MAIL(0x140, State.IN_GAME)); // 4.9
		addPacket(new CM_READ_EXPRESS_MAIL(0x17C, State.IN_GAME)); // 4.9
		addPacket(new CM_DELETE_MAIL(0x147, State.IN_GAME)); // 4.9
		addPacket(new CM_GET_MAIL_ATTACHMENT(0x146, State.IN_GAME)); // 4.9
		
		// ******************(EXCHANGE)******************
		addPacket(new CM_EXCHANGE_ADD_ITEM(0x11E, State.IN_GAME)); // 4.9
		addPacket(new CM_EXCHANGE_ADD_KINAH(0x11C, State.IN_GAME)); // 4.9
		addPacket(new CM_EXCHANGE_LOCK(0x11D, State.IN_GAME)); // 4.9
		addPacket(new CM_EXCHANGE_CANCEL(0x103, State.IN_GAME)); // 4.9
		addPacket(new CM_EXCHANGE_OK(0x102, State.IN_GAME)); // 4.9
		addPacket(new CM_EXCHANGE_REQUEST(0x2F9, State.IN_GAME)); // 4.9

		// *************(HOUSE)***************************
		addPacket(new CM_HOUSE_OPEN_DOOR(0x1BC, State.IN_GAME)); // 4.9
		addPacket(new CM_HOUSE_TELEPORT_BACK(0x119, State.IN_GAME)); // 4.9
		addPacket(new CM_HOUSE_SCRIPT(0xD8, State.IN_GAME)); // 4.9
		addPacket(new CM_HOUSE_TELEPORT(0x198, State.IN_GAME)); // 4.9
		addPacket(new CM_HOUSE_EDIT(0x12C, State.IN_GAME)); // 4.9 TODO !
		addPacket(new CM_USE_HOUSE_OBJECT(0x1BE, State.IN_GAME)); // 4.9
		addPacket(new CM_HOUSE_SETTINGS(0x107, State.IN_GAME)); // 4.9
		addPacket(new CM_HOUSE_KICK(0x106, State.IN_GAME)); // 4.9
		addPacket(new CM_GET_HOUSE_BIDS(0x194, State.IN_GAME)); // 4.9
		addPacket(new CM_HOUSE_PAY_RENT(0x199, State.IN_GAME)); // 4.9 TODO 
		addPacket(new CM_REGISTER_HOUSE(0x195, State.IN_GAME)); // 4.9
		addPacket(new CM_PLACE_BID(0x19B, State.IN_GAME)); // 4.9
		addPacket(new CM_HOUSE_DECORATE(0x105, State.IN_GAME)); // 4.9
		addPacket(new CM_RELEASE_OBJECT(0x1BF, State.IN_GAME)); // 4.9
		
		// ******************(OTHERS)******************
		addPacket(new CM_OBJECT_SEARCH(0xC5, State.IN_GAME)); // 4.9
		addPacket(new CM_MOVE_IN_AIR(0x10F, State.IN_GAME)); // 4.9
		addPacket(new CM_VIEW_PLAYER_DETAILS(0x122, State.IN_GAME)); // 4.9
		addPacket(new CM_TELEPORT_DONE(0xC9, State.IN_GAME)); // 4.9
		addPacket(new CM_CHARACTER_EDIT(0xC1, State.AUTHED)); // 4.9
		addPacket(new CM_PLAYER_STATUS_INFO(0x13E, State.IN_GAME)); // 4.9
		addPacket(new CM_MANASTONE(0x104, State.IN_GAME)); // 4.9
		addPacket(new CM_FUSION_WEAPONS(0x188, State.IN_GAME)); // 4.9
		addPacket(new CM_ITEM_REMODEL(0x114, State.IN_GAME)); // 4.9
		addPacket(new CM_TOGGLE_SKILL_DEACTIVATE(0xFC, State.IN_GAME)); // 4.9
		addPacket(new CM_RECIPE_DELETE(0x117, State.IN_GAME)); // 4.9
		addPacket(new CM_REMOVE_ALTERED_STATE(0xFD, State.IN_GAME)); // 4.9
		addPacket(new CM_MAY_QUIT(0xC2, State.AUTHED, State.IN_GAME)); // 4.9
		addPacket(new CM_REPORT_PLAYER(0x179, State.IN_GAME)); // 4.9
		addPacket(new CM_PLAYER_LISTENER(0xE6, State.IN_GAME)); // 4.9
		addPacket(new CM_BONUS_TITLE(0x1A7, State.IN_GAME)); // 4.9 TODO
		addPacket(new CM_BUY_TRADE_IN_TRADE(0x116, State.IN_GAME)); // 4.9 (Machtkampf aufwertung)
		addPacket(new CM_BREAK_WEAPONS(0x189, State.IN_GAME)); // 4.9
		addPacket(new CM_CHARGE_ITEM(0x108, State.IN_GAME)); // 4.9
		addPacket(new CM_USE_CHARGE_SKILL(0x1A4, State.IN_GAME)); // 4.9
		addPacket(new CM_RECONNECT_AUTH(0x171, State.AUTHED)); // 4.9
		addPacket(new CM_BLOCK_SET_REASON(0x18D, State.IN_GAME)); // 4.9
		addPacket(new CM_INSTANCE_LEAVE(0xE8, State.IN_GAME)); // 4.9
		addPacket(new CM_APPEARANCE(0x183, State.IN_GAME)); // 4.9
		addPacket(new CM_CAPTCHA(0xC8, State.IN_GAME)); // 4.9
		addPacket(new CM_COMPOSITE_STONES(0x1AE, State.IN_GAME)); // 4.9
		addPacket(new CM_MEGAPHONE(0x1AB, State.IN_GAME)); // 4.9
		addPacket(new CM_SUBZONE_CHANGE(0x17D, State.IN_GAME)); // 4.9
		addPacket(new CM_MOVE_ITEM(0x15A, State.IN_GAME)); // 4.9
		addPacket(new CM_SELECTITEM_OK(0x1AA, State.IN_GAME)); // 4.9
		addPacket(new CM_GAMEGUARD(0x126, State.IN_GAME)); // 4.9

		// ******************(Fast Track Server)******************
		addPacket(new CM_FAST_TRACK_CHECK(0x191, State.IN_GAME)); // 4.9	
		addPacket(new CM_FAST_TRACK(0x196, State.IN_GAME)); // 4.9
		addPacket(new CM_DIRECT_ENTER_WORLD(0x191, State.IN_GAME)); // 4.9
						
		// ******************(CHAT)******************
		addPacket(new CM_CHAT_AUTH(0x168, State.IN_GAME)); // 4.9
		addPacket(new CM_CHAT_MESSAGE_PUBLIC(0xD5, State.IN_GAME)); // 4.9
		addPacket(new CM_CHAT_GROUP_INFO(0x2FB, State.IN_GAME)); // 4.9 
		addPacket(new CM_CHAT_MESSAGE_WHISPER(0xDA, State.IN_GAME)); // 4.9
		addPacket(new CM_CHAT_PLAYER_INFO(0xE1, State.IN_GAME)); // 4.9
		
		// ******************(CM_VERSION_CHECK)******************
		addPacket(new CM_VERSION_CHECK(0xDE, State.CONNECTED)); // 4.9
		
		// ******************(Emu Feature)******************		
		addPacket(new CM_FATIGUE_RECOVER(0x135, State.IN_GAME));
				
		// /////////////////// NEW 4.7 //////////////////////
		addPacket(new CM_ATREIAN_PASSPORT(0x1B6, State.IN_GAME)); // 4.9
		addPacket(new CM_HOTSPOT_TELEPORT(0x1B2, State.IN_GAME)); // 4.9
		addPacket(new CM_ITEM_PURIFICATION(0x1B1, State.IN_GAME)); // 4.9
		addPacket(new CM_UPGRADE_ARCADE(0x1B0, State.IN_GAME)); // 4.9
        addPacket(new CM_FILE_VERIFY(0x2F8, State.IN_GAME)); // 4.9
        
        // /////////////////// NEW 4.9 //////////////////////
        addPacket(new CM_EXPAND_CUBE(0x1B5, State.IN_GAME)); // 4.9
        
		// /////////////////// GM PACKET ////////////////////
		addPacket(new CM_GM_COMMAND_SEND(0xE4, State.IN_GAME)); // 4.9
		addPacket(new CM_GM_BOOKMARK(0xE7, State.IN_GAME)); // 4.9
		
		// /////////////////////////////////////////////////
		addPacket(new CM_1A3_UNK(0x1A3, State.IN_GAME)); // 4.9
		addPacket(new CM_11A_UNK(0x11A, State.IN_GAME)); // 4.9
    }

    public AionPacketHandler getPacketHandler() {
        return handler;
    }

    private void addPacket(AionClientPacket prototype) {
        handler.addPacketPrototype(prototype);
    }

    @SuppressWarnings("synthetic-access")
    private static class SingletonHolder {

        protected static final AionPacketHandlerFactory instance = new AionPacketHandlerFactory();
    }
}
