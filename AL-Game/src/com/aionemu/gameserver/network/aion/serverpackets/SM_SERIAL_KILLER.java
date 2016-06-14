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

import java.util.Collection;

/**
 * @author Source & xTz
 */
public class SM_SERIAL_KILLER extends AionServerPacket {

	private int type;
    private int debuffLvl;
    private Collection<Player> players;
    private Player player;


    public SM_SERIAL_KILLER(boolean showMsg, int debuffLvl) {
        this.type = showMsg ? 1 : 0;
        this.debuffLvl = debuffLvl;
    }

    public SM_SERIAL_KILLER(Collection<Player> players) {
        this.type = 4;
        this.players = players;
    }

    public SM_SERIAL_KILLER(Player player, boolean isProtector, boolean showMsg, int buffLvl){
        this.player = player;
        if (showMsg){
            this.type = isProtector ? 8 : 1;
        }else{
            this.type = isProtector ? 9 : 0;
        }
        this.debuffLvl = buffLvl;
    }

    @Override
    protected void writeImpl(AionConnection con) {
        switch (type) {
            case 0: // Conqueror Without Msg
            case 1: // Conqueror With Msg
            case 6:
            case 7:
            case 8: // Protector With Msg
                writeD(type);
                writeD(0x01); //0x01
                writeD(0x01); //0x01
                writeH(0x01); //0x01
                writeD(debuffLvl); //lvl
                writeD(0x00);
                break;
            case 4:
                writeD(type);
                writeD(0x01); // unk
                writeD(0x01); // unk
                writeH(players.size());
                for (Player player : players) {
                    writeD(player.getSKInfo().getRank());
                    writeD(player.getObjectId());
                    writeD(0x01); // unk
                    writeD(player.getAbyssRank().getRank().getId());
                    writeH(player.getLevel());
                    writeF(player.getX());
                    writeF(player.getY());
                    writeS(player.getName(), 118);
                    writeD(0x00); // unk
                    writeD(0x00); // unk
                    writeD(0x00); // unk
                    writeD(0x00); // unk
                }
                break;
            case 9: // Protector Without msg
                writeD(type);
                writeD(0x01); //0x01
                writeD(0x01); //0x01
                writeH(0x01); //0x01
                writeD(debuffLvl); //lvl
                writeD(player.getObjectId());
                break;
        }
    }
}
