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
package com.aionemu.gameserver.model.stats.calc.functions;

import com.aionemu.gameserver.model.stats.calc.Stat2;
import com.aionemu.gameserver.model.stats.calc.StatOwner;
import com.aionemu.gameserver.model.stats.container.StatEnum;
import com.aionemu.gameserver.skillengine.condition.Conditions;

import javax.xml.bind.annotation.*;

/**
 * @author ATracer
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "SimpleModifier")
public class StatFunction implements IStatFunction {

    @XmlAttribute(name = "name")
    protected StatEnum stat;
    @XmlAttribute
    private boolean bonus;
    @XmlAttribute
    protected int value;
    @XmlElement(name = "conditions")
    private Conditions conditions;
    @XmlTransient
    private int rndNumber;

    public StatFunction() {
    }

    public StatFunction(StatEnum stat, int value, boolean bonus) {
        this.stat = stat;
        this.value = value;
        this.bonus = bonus;
    }

    @Override
    public int compareTo(IStatFunction o) {
        int result = getPriority() - o.getPriority();
        if (result == 0) {
            return this.hashCode() - o.hashCode();
        }
        return result;
    }

    @Override
    public StatOwner getOwner() {
        return null;
    }

    @Override
    public final StatEnum getName() {
        return stat;
    }

    @Override
    public final boolean isBonus() {
        return bonus;
    }

    @Override
    public int getPriority() {
        return 0x10;
    }

    @Override
    public int getValue() {
        return value;
    }

    @Override
    public boolean validate(Stat2 stat, IStatFunction statFunction) {
        return conditions != null ? conditions.validate(stat, statFunction) : true;
    }

    @Override
    public void apply(Stat2 stat) {
    }

    @Override
    public String toString() {
        return "stat=" + stat + ", bonus=" + bonus + ", value=" + value + ", priority=" + getPriority();
    }

    public StatFunction withConditions(Conditions conditions) {
        this.conditions = conditions;
        return this;
    }

    public boolean hasConditions() {
        return conditions != null;
    }

    public int getRandomNumber() {
        return rndNumber;
    }

    public void setRandomNumber(int rndNumber) {
        this.rndNumber = rndNumber;
    }
}
