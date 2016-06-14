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
package quest.wisplight_abbey;

import com.aionemu.gameserver.model.gameobjects.player.Player;
import com.aionemu.gameserver.questEngine.handlers.QuestHandler;
import com.aionemu.gameserver.model.DialogAction;
import com.aionemu.gameserver.questEngine.model.QuestEnv;
import com.aionemu.gameserver.questEngine.model.QuestState;
import com.aionemu.gameserver.questEngine.model.QuestStatus;

/**
 * @author FrozenKiller
 */
public class _19601MeetYourInstructors extends QuestHandler {

    private final static int questId = 19601;

    public _19601MeetYourInstructors() {
        super(questId);
    }

    @Override
    public void register() {
        qe.registerQuestNpc(804651).addOnQuestStart(questId);
        qe.registerQuestNpc(804651).addOnTalkEvent(questId); // Lena
		qe.registerQuestNpc(804652).addOnTalkEvent(questId); // Rosette
		qe.registerQuestNpc(804653).addOnTalkEvent(questId); // Deronis
		qe.registerQuestNpc(804654).addOnTalkEvent(questId); // Agnes
		qe.registerQuestNpc(804655).addOnTalkEvent(questId); // Kiran
    }
	
	@Override
    public boolean onDialogEvent(final QuestEnv env) {
        final Player player = env.getPlayer();
        int targetId = env.getTargetId();
        QuestState qs = player.getQuestStateList().getQuestState(questId);
        DialogAction dialog = env.getDialog();

		if (qs == null || qs.getStatus() == QuestStatus.NONE || qs.canRepeat()) {
			if (targetId == 804651) { // Lena
			   if (env.getDialog() == DialogAction.QUEST_SELECT) {
				   return sendQuestDialog(env, 4762);
			   } else {
				   return sendQuestStartDialog(env);
			   }
			}
		} else if (qs.getStatus() == QuestStatus.START) {
			int var = qs.getQuestVarById(0);
			if (targetId == 804652) { // Rosette
				switch (dialog) {
					case QUEST_SELECT: {
						if (var == 0) {
							return sendQuestDialog(env, 1011);
						} 
					}
					case SETPRO1: {
						qs.setQuestVar(1);
                        updateQuestStatus(env);
						return closeDialogWindow(env);
					}
				default:
					break;
				}
			} else if (targetId == 804653) { // Deronis
				switch (dialog) {
					case QUEST_SELECT: {
						if (var == 1) {
							return sendQuestDialog(env, 1352);
						} 
					}
					case SETPRO2: {
						qs.setQuestVar(2);
                        updateQuestStatus(env);
						return closeDialogWindow(env);
					}
				default:
					break;
				}
			} else if (targetId == 804654) { // Agnes
				switch (dialog) {
					case QUEST_SELECT: {
						if (var == 2) {
							return sendQuestDialog(env, 1693);
						} 
					}
					case SET_SUCCEED: {
						return defaultCloseDialog(env, 2, 3, true, false); // reward
					}
				default:
					break;
				}
			} 
        } else if (qs.getStatus() == QuestStatus.REWARD) {
            if (targetId == 804655) { // Kiran
                if (dialog == DialogAction.USE_OBJECT) {
                    return sendQuestDialog(env, 10002);
                } else {
                    return sendQuestEndDialog(env);
                }
            }
        }
        return false;
	}
}