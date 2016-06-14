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
package com.aionemu.gameserver.network.aion.serverpackets;

import com.aionemu.gameserver.model.gameobjects.player.Player;
import com.aionemu.gameserver.network.aion.AionConnection;
import com.aionemu.gameserver.network.aion.AionServerPacket;


/**
 * @author Alcapwnd
 */
public class SM_HOTSPOT_TELEPORT extends AionServerPacket {

    int playerObjectId;
    int teleportGoal;
    int id;
    int unk;
    int cooldown;

    public SM_HOTSPOT_TELEPORT(Player player, int id)
    {
        this.playerObjectId = player.getObjectId();
        this.id = id;
    }

    public SM_HOTSPOT_TELEPORT(Player player, int telegoal, int id, int cooldown) {
        this.playerObjectId = player.getObjectId();
        this.teleportGoal = telegoal;
        this.id = id;
        this.cooldown = cooldown;
    }

    public SM_HOTSPOT_TELEPORT(Player player, int teleportGoal, int id)
    {
        this.playerObjectId = player.getObjectId();
        this.teleportGoal = teleportGoal;
        this.id = id;
    }

    public SM_HOTSPOT_TELEPORT(int unk, int id) {
        this.unk = unk;
        this.id = id;
    }

    @Override
    protected void writeImpl(AionConnection con) {
        writeC(id);
    	switch (id) {
            case 0:
                writeD(unk);
                break;
            case 1:
                writeD(playerObjectId);
                writeD(teleportGoal);
                break;
            case 2:
                writeD(playerObjectId);
                break;
            case 3:
                writeD(playerObjectId);
                writeD(teleportGoal);
                writeD(cooldown);
                break;
        }
    }
}
