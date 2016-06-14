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
package quest.reshanta;

import com.aionemu.gameserver.model.gameobjects.player.Player;
import com.aionemu.gameserver.questEngine.handlers.QuestHandler;
import com.aionemu.gameserver.model.DialogAction;
import com.aionemu.gameserver.questEngine.model.QuestEnv;
import com.aionemu.gameserver.questEngine.model.QuestState;
import com.aionemu.gameserver.questEngine.model.QuestStatus;

/**
 * @author pralinka
 */
 
public class _2817AGhostHosts extends QuestHandler {

    private final static int questId = 2817;

    public _2817AGhostHosts() {
        super(questId);
    }

    @Override
    public void register() {
		int[] npcs = {279007, 263569, 263267, 264769, 263567, 263265, 264767};
        qe.registerQuestNpc(279007).addOnQuestStart(questId);
        for (int npc : npcs) {
            qe.registerQuestNpc(npc).addOnTalkEvent(questId);
        }
    }

    @Override
    public boolean onDialogEvent(QuestEnv env) {
        Player player = env.getPlayer();
        int targetId = env.getTargetId();
        QuestState qs = player.getQuestStateList().getQuestState(questId);

        if (qs == null || qs.getStatus() == QuestStatus.NONE) {
            if (targetId == 279007) { // Jakurerk
                if (env.getDialog() == DialogAction.QUEST_SELECT) {
                    return sendQuestDialog(env, 4762);
                } else {
                    return sendQuestStartDialog(env);
                }
            }
        } else if (qs.getStatus() == QuestStatus.START) {
            int var = qs.getQuestVarById(0);
            switch (targetId) {
                case 263569: { // Astar
                    switch (env.getDialog()) {
                        case QUEST_SELECT: {
                            return sendQuestDialog(env, 1011);
                        }
                        case SETPRO1: {
                            return defaultCloseDialog(env, 0, 1); // 1
                        }
					default:
						break;
                    }
                    break;
                }
                case 263267: { // Lirhel
                    switch (env.getDialog()) {
                        case QUEST_SELECT: {
                            if (var == 1) {
                                return sendQuestDialog(env, 1352);
                            }
                        }
                        case SETPRO2: {
                            return defaultCloseDialog(env, 1, 2); // 2
                        }
					default:
						break;
                    }
                    break;
                }
                case 264769: { // Gudharten
                    switch (env.getDialog()) {
                        case QUEST_SELECT: {
                            if (var == 2) {
                                return sendQuestDialog(env, 1693);
                            }
                        }
                        case SETPRO3: {
							giveQuestItem(env, 182215689, 1);
                            return defaultCloseDialog(env, 2, 3); // 3
                        }
					default:
						break;
                    }
                    break;
                }
                case 279007: { // Jakurerk
                    switch (env.getDialog()) {
                        case QUEST_SELECT: {
                            if (var == 3) {
                                return sendQuestDialog(env, 2034);
                            }
                        }
                        case SETPRO4: {
							removeQuestItem(env, 182215689, 1);
							giveQuestItem(env, 182215690, 3);
                            return defaultCloseDialog(env, 3, 4); // 4
                        }
					default:
						break;
                    }
                    break;
                }

                case 263567: { // Ahsur
                    switch (env.getDialog()) {
                        case QUEST_SELECT: {
                            if (var == 4) {
                                return sendQuestDialog(env, 2375);
                            }
                        }
                        case SETPRO5: {
							removeQuestItem(env, 182215690, 1);
                            return defaultCloseDialog(env, 4, 5); // 5
                        }
					default:
						break;
                    }
                    break;
                }
                case 263265: { // Lote
                    switch (env.getDialog()) {
                        case QUEST_SELECT: {
                            if (var == 5) {
                                return sendQuestDialog(env, 2716);
                            }
                        }
                        case SETPRO6: {
							removeQuestItem(env, 182215690, 1);
                            return defaultCloseDialog(env, 5, 6); // 6
                        }
					default:
						break;
                    }
                    break;
                }
                case 264767: { // Naun
                    switch (env.getDialog()) {
                        case QUEST_SELECT: {
                            if (var == 6) {
                                return sendQuestDialog(env, 3057);
                            }
                        }
                        case SET_SUCCEED: {
							removeQuestItem(env, 182215690, 1);
                            return defaultCloseDialog(env, 6, 6, true, false);
                        }
					default:
						break;
                    }
                }
            }
        } else if (qs.getStatus() == QuestStatus.REWARD) {
            if (targetId == 279007) { // Jakurerk
                if (env.getDialog() == DialogAction.USE_OBJECT) {
                    return sendQuestDialog(env, 10002);
                } else if (env.getDialog() == DialogAction.SELECT_QUEST_REWARD) {
                    return sendQuestDialog(env, 5);
                } else {
                    return sendQuestEndDialog(env);
                }
            }
        }
        return false;
    }
}