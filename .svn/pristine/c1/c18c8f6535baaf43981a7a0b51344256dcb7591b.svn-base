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

package com.aionemu.gameserver.services;

import java.util.ArrayList;
import java.util.List;

import com.aionemu.commons.utils.Rnd;
import com.aionemu.gameserver.configs.main.EventsConfig;
import com.aionemu.gameserver.dataholders.DataManager;
import com.aionemu.gameserver.model.gameobjects.player.Player;
import com.aionemu.gameserver.model.items.storage.Storage;
import com.aionemu.gameserver.model.templates.arcadeupgrade.ArcadeTab;
import com.aionemu.gameserver.model.templates.arcadeupgrade.ArcadeTabItemList;
import com.aionemu.gameserver.network.aion.serverpackets.SM_UPGRADE_ARCADE;
import com.aionemu.gameserver.services.item.ItemService;
import com.aionemu.gameserver.utils.PacketSendUtility;

/**
 * @author Lyras
 */
public class ArcadeUpgradeService {

    private int[] experience = new int[8];
    private int[] expReward = new int[8];

    public ArcadeUpgradeService() {
        this.experience[0] = 12;
        this.experience[1] = 36;
        this.experience[2] = 48;
        this.experience[3] = 60;
        this.experience[4] = 72;
        this.experience[5] = 84;
        this.experience[6] = 96;
        this.experience[7] = 100;
        this.expReward[0] = 0;
        this.expReward[1] = 4;
        this.expReward[2] = 6;
        this.expReward[3] = 8;
    }

    public static ArcadeUpgradeService getInstance()
    {
        return SingletonHolder.instance;
    }

    public int getLevelForExp(int exp)
    {
        int level = 1;
        for (int j = this.experience.length; j > 0; j--) {
            if (exp >= this.experience[(j - 1)])
            {
                level = j;
                break;
            }
        }
        if (level > this.experience.length) {
            return this.experience.length;
        }
        return level;
    }

    public int getRewardForLevel(int exp)
    {
        int reward = 1;
        for (int j = this.expReward.length; j > 0; j--) {
            if (exp >= this.expReward[(j - 1)])
            {
                reward = j;
                break;
            }
        }
        if (reward > this.expReward.length) {
            return this.expReward.length;
        }
        return reward;
    }

    public void closeWindow(Player player)
    {
        PacketSendUtility.sendPacket(player, new SM_UPGRADE_ARCADE(2));
    }

    public void startArcadeUpgrade(Player player)
    {
        PacketSendUtility.sendPacket(player, new SM_UPGRADE_ARCADE());
    }

    public void showRewardList(Player player)
    {
        PacketSendUtility.sendPacket(player, new SM_UPGRADE_ARCADE(10));
    }

    public List<ArcadeTab> getTabs()
    {
        return DataManager.ARCADE_UPGRADE_DATA.getArcadeTabs();
    }

    public void tryArcadeUpgrade(final Player player) {
        if (!EventsConfig.ENABLE_EVENT_ARCADE) {
            return;
        }
        Storage localStorage = player.getInventory();
        if ((player.getFrenzy() == 0) && (!localStorage.decreaseByItemId(186000389, 1L))) {
            return;
        }
        if (Rnd.get(1, 100) <= EventsConfig.EVENT_ARCADE_CHANCE) {
            player.setFrenzy(player.getFrenzy() + 8);
            PacketSendUtility.sendPacket(player, new SM_UPGRADE_ARCADE(3, true, player.getFrenzy()));
            PacketSendUtility.sendPacket(player, new SM_UPGRADE_ARCADE(4, getLevelForExp(player.getFrenzy())));
        } else {
            PacketSendUtility.sendPacket(player, new SM_UPGRADE_ARCADE(3, false, player.getFrenzy()));
            PacketSendUtility.sendPacket(player, new SM_UPGRADE_ARCADE(5, getLevelForExp(player.getFrenzy())));
            player.setFrenzy(0);
        }
    }

    public void getReward(Player player)
    {
        if (!EventsConfig.ENABLE_EVENT_ARCADE) {
            return;
        }
        int level = getLevelForExp(player.getFrenzy());
        int reward = getRewardForLevel(level);
        ArrayList<ArcadeTabItemList> rewards = new ArrayList<>();
        for(ArcadeTab tab : getTabs())
        {
            if(reward >= tab.getId())
            {
                for(ArcadeTabItemList itemList : tab.getArcadeTabItems())
                {
                    rewards.add(itemList);
                }
            }
        }
        if (rewards.size() > 0)
        {
            int random = Rnd.get(0, rewards.size() - 1);
            ArcadeTabItemList itemList = rewards.get(random);
            ItemService.addItem(player, itemList.getItemId(), itemList.getNormalCount() > 0 ? itemList.getNormalCount() : itemList.getFrenzyCount());
            PacketSendUtility.sendPacket(player, new SM_UPGRADE_ARCADE(6, itemList));
            player.setFrenzy(0);
        }
    }

    private static class SingletonHolder
    {
        protected static final ArcadeUpgradeService instance = new ArcadeUpgradeService();
    }
}
