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

import com.aionemu.gameserver.model.templates.tradelist.TradeListTemplate;
import com.aionemu.gameserver.model.templates.tradelist.TradeNpcType;
import com.aionemu.gameserver.network.aion.AionConnection;
import com.aionemu.gameserver.network.aion.AionServerPacket;

/**
 * @author orz, Sarynth, modified by Artur
 */
public class SM_SELL_ITEM extends AionServerPacket {

    private int targetObjectId;
    private TradeListTemplate plist;
    private int sellPercentage;
    private byte action = 0x01;

    public SM_SELL_ITEM(int targetObjectId, int sellPercentage) {
        this.sellPercentage = sellPercentage;
        this.targetObjectId = targetObjectId;
    }

    public SM_SELL_ITEM(int targetObjectId, TradeListTemplate plist, int sellPercentage) {

        this.targetObjectId = targetObjectId;
        this.plist = plist;
        this.sellPercentage = sellPercentage;
        if (plist.getTradeNpcType() == TradeNpcType.ABYSS) {
            this.action = 0x02;
        }
    }

    /**
     * {@inheritDoc}
     */
    protected void writeImpl(AionConnection con) {
    	if ((this.plist != null) && (this.plist.getNpcId() != 0) && (this.plist.getCount() != 0)) {
            writeD(this.targetObjectId);
            writeC(this.plist.getTradeNpcType().index());
            writeD(this.sellPercentage);
            writeH(256);
            writeH(this.plist.getCount());
            for (TradeListTemplate.TradeTab tradeTabl : this.plist.getTradeTablist())
                writeD(tradeTabl.getId());
        } else {
            writeD(this.targetObjectId);
            writeD(5121);
            writeD(65792);
            writeC(0);
        }
    }
}
