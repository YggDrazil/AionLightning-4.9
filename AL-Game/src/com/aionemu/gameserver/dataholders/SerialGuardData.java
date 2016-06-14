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
package com.aionemu.gameserver.dataholders;

import com.aionemu.gameserver.model.Race;
import com.aionemu.gameserver.model.templates.serial_guard.GuardRankRestriction;
import gnu.trove.map.hash.TIntObjectHashMap;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import javax.xml.bind.Unmarshaller;
import javax.xml.bind.annotation.*;
import java.util.List;

/**
 * @author Kill3r
 * @modify Elo
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "", propOrder = {
        "guardRankRestriction"
})
@XmlRootElement(name = "serial_guards")
public class SerialGuardData {

    @XmlElement(name = "guard_rank_restriction")
    protected List<GuardRankRestriction> guardRankRestriction;
    @XmlTransient
    private TIntObjectHashMap<GuardRankRestriction> templates = new TIntObjectHashMap<GuardRankRestriction>();

    public static final Logger log = LoggerFactory.getLogger(SerialGuardData.class);


    void afterUnmarshal(Unmarshaller u, Object parent){
        for (GuardRankRestriction template : guardRankRestriction){
            templates.put(template.getId(), template);
        }
        guardRankRestriction.clear();
        guardRankRestriction = null;
    }

    public int size(){
        return templates.size();
    }

    public GuardRankRestriction getGuardRankRestriction(int rank, Race race){
        for (int i = 1; i < this.templates.size(); i++){
            GuardRankRestriction grr = (GuardRankRestriction) this.templates.get(i);
            if (grr.getRank_num() == rank && grr.getRace() == race){
                return grr;
            }
        }
        return null;
    }

}
