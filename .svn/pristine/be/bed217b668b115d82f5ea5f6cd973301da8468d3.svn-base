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
package com.aionemu.gameserver.model.templates.serial_guard;

import com.aionemu.gameserver.model.Race;

import javax.xml.bind.annotation.*;
import java.util.ArrayList;
import java.util.List;

/**
 * @author Kill3r
 * @modify Elo
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "GuardRankRestriction", propOrder = {
        "guardPenaltyAttr"
})
public class GuardRankRestriction {

    @XmlElement(name = "guard_penalty_attr")
    protected List<GuardRankPenaltyAttr> guardPenaltyAttr;
    @XmlAttribute(name = "id", required = true)
    protected int id;
    @XmlAttribute(name = "title_name", required = true)
    protected String title_name;
    @XmlAttribute(name = "race", required = true)
    protected Race race;
    @XmlAttribute(name = "rank_num")
    protected int rank_num;


    /**
     *
     * @return id
     */
    public int getId() {
        return id;
    }

    /**
     *
     * @return title_name
     */
    public String getTitle_name() {
        return title_name;
    }

    /**
     *
     * @return race
     */
    public Race getRace() {
        return race;
    }

    /**
     *
     * @return rank_num
     */
    public int getRank_num() {
        return rank_num;
    }

    /**
     *
     * @param rank_num rank_num
     */
    public void setRank_num(int rank_num) {
        this.rank_num = rank_num;
    }

    /**
     *
     * @return guardPenaltyAttr
     */
    public List<GuardRankPenaltyAttr> getGuardPenaltyAttr() {
        if (guardPenaltyAttr == null){
            guardPenaltyAttr = new ArrayList<GuardRankPenaltyAttr>();
        }
        return guardPenaltyAttr;
    }


}
