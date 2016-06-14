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
package ai.instance.argentManor;

import ai.ActionItemNpcAI2;

import com.aionemu.gameserver.ai2.AIName;
import com.aionemu.gameserver.model.TeleportAnimation;
import com.aionemu.gameserver.model.gameobjects.player.Player;
import com.aionemu.gameserver.services.teleport.TeleportService2;

/**
 * @author Falke_34
 */
@AIName("argent_manor_portal")
public class ArgentManorPortalAI2 extends ActionItemNpcAI2 {

	//TODO
	
	@Override
	protected void handleUseItemFinish(Player player) {
		switch (getNpcId()) {
		case 731641: //Alchemie Lab
			TeleportService2.teleportTo(player, 301510000, 820.6594f, 1081.6353f, 53.671883f, (byte) 30, TeleportAnimation.JUMP_ANIMATION);
			break;
		case 731642: //Light Lab
			TeleportService2.teleportTo(player, 301510000, 794.67474f, 1195.2882f, 94.47192f, (byte) 3, TeleportAnimation.JUMP_ANIMATION);
			break;
		case 731644: //Boss
			TeleportService2.teleportTo(player, 301510000, 818.93384f, 1443.7001f, 195.00311f, (byte) 3, TeleportAnimation.JUMP_ANIMATION);
			break;
		}
	}
}
