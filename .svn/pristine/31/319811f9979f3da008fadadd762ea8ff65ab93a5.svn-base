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

import com.aionemu.commons.utils.Rnd;
import com.aionemu.gameserver.ai2.AIName;
import com.aionemu.gameserver.model.gameobjects.player.Player;
import com.aionemu.gameserver.world.WorldPosition;

/**
 * @author Falke_34
 */
@AIName("drained_hetgolem") // 856547
public class DrainedHetgolemAI2 extends ActionItemNpcAI2 {

	//TODO when you use drained hetgolem with 185000242 then spawns random 237196 or 237196
	
	protected void handleUseItemFinish(Player player) {
		final WorldPosition p = getPosition();
		if (p != null) {
			switch (getNpcId()) {
			case 804573:
				switch (Rnd.get(1, 2)) {
				case 1:
					spawn(237196, p.getX(), p.getY(), p.getZ(), (byte) 0);
					break;
				case 2:
					spawn(237197, p.getX(), p.getY(), p.getZ(), (byte) 0);
					break;
				}
			}
		}			
	}
}
