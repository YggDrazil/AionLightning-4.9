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
package com.aionemu.gameserver.model.templates.item;

import javax.xml.bind.annotation.*;
import java.util.ArrayList;
import java.util.List;

/**
 * @author ATracer
 * @reworked Kill3r
 */
@XmlAccessorType(XmlAccessType.NONE)
@XmlRootElement(name = "Stigma")
public class Stigma {

    @XmlElement(name = "require_skill")
    protected List<RequireSkill> requireSkill;
    @XmlAttribute
    protected List<String> skill;
    @XmlAttribute
    protected int kinah;

    /**
     * @return list
     */
    public List<StigmaSkill> getSkills() {
        List<StigmaSkill> list = new ArrayList<StigmaSkill>();
        for (String st : skill) {
            String[] array = st.split(":");
            list.add(new StigmaSkill(Integer.parseInt(array[0]), Integer.parseInt(array[1])));
        }

        return list;
    }

    /**
     * @return the kinah //4.8
     */
    public int getKinah() {
        return kinah;
    }

    public List<RequireSkill> getRequireSkill() {
        if (requireSkill == null) {
            requireSkill = new ArrayList<RequireSkill>();
        }
        return this.requireSkill;
    }

    public class StigmaSkill {

        private int skillId;
        private int skillLvl;

        public StigmaSkill(int skillLvl, int skillId) {
            this.skillId = skillId;
            this.skillLvl = skillLvl;
        }

        public int getSkillLvl() {
            return this.skillLvl;
        }

        public int getSkillId() {
            return this.skillId;
        }
    }
}
