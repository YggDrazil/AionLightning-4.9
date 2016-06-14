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
package com.aionemu.gameserver.skillengine.effect;

import com.aionemu.gameserver.model.gameobjects.Creature;
import com.aionemu.gameserver.model.gameobjects.player.Player;
import com.aionemu.gameserver.network.aion.serverpackets.SM_TARGET_SELECTED;
import com.aionemu.gameserver.network.aion.serverpackets.SM_TARGET_UPDATE;
import com.aionemu.gameserver.skillengine.model.Effect;
import com.aionemu.gameserver.utils.PacketSendUtility;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlType;

/**
 * @author Kill3r
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "TargetChangeEffect")
public class TargetChangeEffect extends EffectTemplate{

    @Override
    public void applyEffect(Effect effect) {
        effect.addToEffectedController();
    }

    /**
     * For Skill Shimmerbomb - 3236, 3237 , 3238
      if the effected is EnemyPlayer target needs to be deselected
      Also some other Taunt Skills does the same thing, but it changes the target to the effector
     * @param effect
     */
    @Override
    public void startEffect(Effect effect) {
        Creature effected = effect.getEffected();
        if (effected instanceof Player){
            effected.setTarget(null);
            PacketSendUtility.sendPacket((Player) effected, new SM_TARGET_SELECTED(null));
            PacketSendUtility.broadcastPacket(effected, new SM_TARGET_UPDATE((Player) effected));
        }

    }
}
