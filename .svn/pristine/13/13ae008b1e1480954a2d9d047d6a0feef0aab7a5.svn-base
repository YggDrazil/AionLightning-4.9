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
package com.aionemu.gameserver.services.serialguards;

import com.aionemu.gameserver.dataholders.DataManager;
import com.aionemu.gameserver.model.gameobjects.player.Player;
import com.aionemu.gameserver.model.stats.calc.StatOwner;
import com.aionemu.gameserver.model.stats.calc.functions.IStatFunction;
import com.aionemu.gameserver.model.stats.calc.functions.StatAddFunction;
import com.aionemu.gameserver.model.templates.serial_guard.GuardRankPenaltyAttr;
import com.aionemu.gameserver.model.templates.serial_guard.GuardRankRestriction;
import com.aionemu.gameserver.skillengine.change.Func;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import java.util.ArrayList;
import java.util.List;

/**
 * @author Kill3r
 * @modify Elo
 */
public class SerialGuardDebuff implements StatOwner {

    private List<IStatFunction> functions = new ArrayList<IStatFunction>();
    private static final Logger log = LoggerFactory.getLogger(GuardRankPenaltyAttr.class);

    public void applyEffect(Player player, int ProcRank){
        if (ProcRank == 0){
            if (hasBuff()){
                player.getGameStats().endEffect(this);
            }
            return;
        }

        GuardRankRestriction grrProc = DataManager.SERIAL_GUARD_DATA.getGuardRankRestriction(ProcRank, player.getRace());

        if (hasBuff()){
            endEffect(player);
        }

        for (GuardRankPenaltyAttr GRPA : grrProc.getGuardPenaltyAttr()){
            if (GRPA.getFunc().equals(Func.ADD)){
                functions.add(new StatAddFunction(GRPA.getStat(), GRPA.getValue(), true));
            }
        }

        player.getGameStats().addEffect(this, functions);
    }

    public boolean hasBuff(){
        return !functions.isEmpty();
    }

    public void endEffect(Player player){
        functions.clear();
        player.getGameStats().endEffect(this);
    }

}
