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

import com.aionemu.gameserver.network.aion.AionConnection;
import com.aionemu.gameserver.network.aion.AionServerPacket;

/**
 * @author pixfid
 * @modified Magenik
 */
public class SM_ACCOUNT_ACCESS_PROPERTIES extends AionServerPacket {

    private boolean isGM;

    public SM_ACCOUNT_ACCESS_PROPERTIES(boolean isGM) {
        this.isGM = isGM;
    }

    @Override
    protected void writeImpl(AionConnection con) {
    	writeH(this.isGM ? 3 : 0); //unk
        writeH(0x00); //unk
        writeD(0x00); //unk        
        writeD(0x00); //unk
        writeD(this.isGM ? 32768 : 0); //unk
        writeD(0x00); //unk
        writeC(0x00); //Korea Value
        writeD(this.isGM ? 8 : 0); //unk
        writeD(this.isGM ? 4 : 0); //Korea Value
		writeB(new byte[48]); // unk 4.9
    }
}
