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

import com.aionemu.gameserver.model.templates.arcadeupgrade.ArcadeTab;
import com.aionemu.gameserver.model.templates.arcadeupgrade.ArcadeTabItemList;
import com.aionemu.gameserver.network.aion.AionConnection;
import com.aionemu.gameserver.network.aion.AionServerPacket;
import com.aionemu.gameserver.services.ArcadeUpgradeService;

import java.util.List;

/**
 * @author Raziel
 */

public class SM_UPGRADE_ARCADE extends AionServerPacket {

	/**
	 * Actions:
	 * 0 = Show Icon
	 * 1 = Start
	 *
	 */


	private int action;
	private int showicon = 1;
	private int frenzy = 0;
	private boolean success = false;
	private int level;
	private ArcadeTabItemList itemList;

	public SM_UPGRADE_ARCADE(boolean showicon) {
		this.action = 0;
		this.showicon = showicon ? 1 : 0;
	}

	public SM_UPGRADE_ARCADE()
	{
		this.action = 1;
	}
	
	public SM_UPGRADE_ARCADE(int action) {
		this.action = action;
	}

	public SM_UPGRADE_ARCADE(int action, boolean success, int frenzy)
	{
		this.action = action;
		this.success = success;
		this.frenzy = frenzy;
	}

	public SM_UPGRADE_ARCADE(int action, int level)
	{
		this.action = action;
		this.level = level;
	}

	public SM_UPGRADE_ARCADE(int action, ArcadeTabItemList itemList)
	{
		this.action = action;
		this.itemList = itemList;
	}

	@Override
	protected void writeImpl(AionConnection con) {
		writeC(action);

		switch(action)
		{
			case 0://show icon
				writeD(this.showicon);
				break;
			case 1: //show start upgrade arcade info
				writeD(64519);//SessionId
				writeD(0);//unk
				writeD(0);//frenzy meter
				writeD(1);
				writeD(4);
				writeD(6);
				writeD(8);
				writeD(8);//max upgrade
				writeH(272);
				writeS("success_weapon01");
				writeS("success_weapon01");
				writeS("success_weapon01");
				writeS("success_weapon02");
				writeS("success_weapon02");
				writeS("success_weapon03");
				writeS("success_weapon03");
				writeS("success_weapon04");
				break;
			case 2:
				writeD(64519);
				break;
			case 3: //try result
				writeC(this.success ? 1 : 0);//1 success - 0 fail
				writeD(this.frenzy > 100 ? 100 : this.frenzy);//frenzyPoints
			break;
			case 4: //try result
				writeD(this.level);//upgradeLevel
			break;
			case 5: //show fail
				writeD(this.level);//upgradeLevel
				writeC(level >= 6 ? 1 : 0);//canResume? 1 yes - 0 no
				writeD(level >= 6 ? 2 : 0);//needed Arcade Token
				writeD(0);//unk
			break;
			case 6: //show reward icon
				writeD(this.itemList.getItemId());//templateId
				writeD(this.itemList.getNormalCount() > 0 ? this.itemList.getNormalCount() : this.itemList.getFrenzyCount());//itemCount
				writeD(0);//unk
			break;
			case 7:
				writeD(0); //unk 4.9
				writeD(0); //unk 4.9 
			break;			
			case 10: //show reward list
				List<ArcadeTab> tabs = ArcadeUpgradeService.getInstance().getTabs();
				for(ArcadeTab tab : tabs)
				{
					writeC(tab.getArcadeTabItems().size());
				}

				for (ArcadeTab arcadetab : tabs){
					for (ArcadeTabItemList arcadetabitem : arcadetab.getArcadeTabItems()){
						writeD(arcadetabitem.getItemId()); //getId()
						writeD(arcadetabitem.getNormalCount()); //getUncheckedcount()
						writeD(0);
						writeD(arcadetabitem.getFrenzyCount()); //getCheckedcount
						writeD(0);
					}
				}
			break;
		}
	}
}