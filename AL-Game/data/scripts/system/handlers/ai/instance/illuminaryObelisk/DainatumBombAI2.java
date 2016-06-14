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
package ai.instance.illuminaryObelisk;

import ai.AggressiveNpcAI2;
import com.aionemu.commons.network.util.ThreadPoolManager;
import com.aionemu.gameserver.ai2.AIName;
import com.aionemu.gameserver.model.actions.NpcActions;
import com.aionemu.gameserver.model.gameobjects.Npc;
import com.aionemu.gameserver.skillengine.SkillEngine;
import java.util.concurrent.Future;

/**
 * 
 * @author Alcapwnd
 *
 */
@AIName("dainatum_mine")
public class DainatumBombAI2 extends AggressiveNpcAI2 {

	private Future<?> TasksBomb;
	private boolean isCancelled;

	@Override
	protected void handleSpawned() {
		SkillActive();
		super.handleSpawned();
	}

	private void DainatumBomb(int skillId) {
		SkillEngine.getInstance().getSkill(getOwner(), skillId, 65, getOwner()).useNoAnimationSkill();
	}

	private void SkillActive() {

		TasksBomb = ThreadPoolManager.getInstance().schedule(new Runnable() {

			@Override
			public void run() {
				if (isAlreadyDead() && isCancelled == true) {
					CancelTask();
				}
				else {
					DainatumBomb(21275);
				}
			}
		}, 6000);

		TasksBomb = ThreadPoolManager.getInstance().schedule(new Runnable() {

			@Override
			public void run() {
				if (isAlreadyDead() && isCancelled == true) {
					CancelTask();
				}
				else {
					Npc npc = getOwner();
					NpcActions.delete(npc);
				}
			}
		}, 10000);
	}

	private void CancelTask() {
		if (TasksBomb != null && !TasksBomb.isCancelled()) {
			TasksBomb.cancel(true);
		}
	}

	@Override
	protected void handleDespawned() {
		super.handleDespawned();
		CancelTask();
		isCancelled = true;
	}

}