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
package com.aionemu.gameserver.model.templates.item.actions;

import com.aionemu.gameserver.model.gameobjects.Item;
import com.aionemu.gameserver.model.gameobjects.player.Player;
import com.aionemu.gameserver.network.aion.serverpackets.SM_SYSTEM_MESSAGE;
import com.aionemu.gameserver.utils.PacketSendUtility;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlAttribute;
import javax.xml.bind.annotation.XmlType;

/**
 * @author Kill3r
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "ExpReturnAction")
public class ExpReturnAction extends AbstractItemAction{

    @XmlAttribute
    protected int percent;

    @Override
    public boolean canAct(Player player, Item parentItem, Item targetItem) {
        int nameId = parentItem.getItemTemplate().getNameId();
        //int restrictLevelMin = parentItem.getItemTemplate().getMinLevelRestrict(player);
        byte restrictLevelMax = parentItem.getItemTemplate().getMaxLevelRestrict(player);

        if (restrictLevelMax != 0){
            PacketSendUtility.sendPacket(player, SM_SYSTEM_MESSAGE.STR_CANNOT_USE_ITEM_TOO_LOW_LEVEL_MUST_BE_THIS_LEVEL(restrictLevelMax, nameId));
            return false;
        }
        /*if (restrictLevelMin != 0){
            PacketSendUtility.sendPacket(player, SM_SYSTEM_MESSAGE.STR_CANNOT_USE_ITEM_TOO_HIGH_LEVEL(restrictLevelMin, nameId));
            return false;
        }*/
        return false;
    }

    @Override
    public void act(Player player, Item parentItem, Item targetItem) {
        long totalXp = player.getCommonData().getExpNeed();
        long currentXp = player.getCommonData().getExp();
        long calcuatedXp = 0;

        calcuatedXp = (int)(totalXp * 0.2);
        player.getCommonData().setExp(currentXp + calcuatedXp);
    }
}
