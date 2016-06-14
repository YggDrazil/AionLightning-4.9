package com.aionemu.gameserver.network.aion.clientpackets;

import com.aionemu.gameserver.model.gameobjects.player.Player;
import com.aionemu.gameserver.network.aion.AionClientPacket;
import com.aionemu.gameserver.network.aion.AionConnection.State;
import com.aionemu.gameserver.services.LegionService;

/**
 * @author CoolyT
 */
public class CM_LEGION_JOIN_REQUEST extends AionClientPacket {

    
    private String legionName;
    private String joinRequestMsg;
    private int legionId;
    private int joinType;

    public CM_LEGION_JOIN_REQUEST(int opcode, State state, State... restStates) {
        super(opcode, state, restStates);
    }

    @Override
    protected void readImpl() 
    {
        legionId = readD();
        legionName = readS();
        joinType = readC();
        joinRequestMsg = readS();
        
    }

    @Override
    protected void runImpl() 
    {
        Player player = getConnection().getActivePlayer();
        if (player == null)
        	return;
        System.out.println(" set request");
        LegionService.getInstance().handleLegionJoinRequest(player, legionId, joinType, joinRequestMsg);
    }
}
