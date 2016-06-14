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
package com.aionemu.gameserver.model.templates.event;

import com.aionemu.gameserver.model.AttendType;
import com.aionemu.gameserver.utils.gametime.DateTimeUtil;
import org.joda.time.DateTime;

import javax.xml.bind.annotation.*;
import javax.xml.datatype.XMLGregorianCalendar;
import java.sql.Timestamp;


/**
 * @author Alcapwnd
 */
@XmlRootElement(name = "login_event")
@XmlAccessorType(XmlAccessType.NONE)
public class AtreianPassport {

    /**
     * Location Id.
     */
    @XmlAttribute(name = "id", required = true)
    private int id;
    /**
     * location name.
     */
    @XmlAttribute(name = "name")
    private String name = "";
    @XmlAttribute(name = "active", required = true)
    private int active;
    @XmlAttribute(name = "period_start", required = true)
    @XmlSchemaType(name = "dateTime")
    protected XMLGregorianCalendar pStart;
    @XmlAttribute(name = "period_end", required = true)
    @XmlSchemaType(name = "dateTime")
    protected XMLGregorianCalendar pEnd;
    @XmlAttribute(name = "attend_type", required = true)
    private AttendType attendType;
    @XmlAttribute(name = "attend_num")
    private int attendNum;
    @XmlAttribute(name = "reward_item", required = true)
    private int rewardItem;
    @XmlAttribute(name = "reward_item_num", required = true)
    private int rewardItemNum = 1;
    @XmlAttribute(name = "reward_item_expire")
    private int rewardItemExpire;
    private int rewardId = 0;
    private boolean finish = false;
    private int stamps = 0;
    private Timestamp lastStamp;

    public int getId() {
        return id;
    }

    public int getActive() {
        return active;
    }

    public String getName() {
        return name;
    }

    public DateTime getPeriodStart() {
        return DateTimeUtil.getDateTime(pStart.toGregorianCalendar());
    }

    public DateTime getPeriodEnd() {
        return DateTimeUtil.getDateTime(pEnd.toGregorianCalendar());
    }

    public AttendType getAttendType() {
        return attendType;
    }

    public int getAttendNum() {
        return attendNum;
    }

    public int getRewardItem() {
        return rewardItem;
    }

    public int getRewardItemNum() {
        return rewardItemNum;
    }

    public int getRewardItemExpire() {
        return rewardItemExpire;
    }

    public int getRewardId() {
        return rewardId;
    }

    public void setRewardId(int rewardId) {
        this.rewardId = rewardId;
    }

    public boolean isFinish() {
        return finish;
    }

    public void setFinish(boolean finish) {
        this.finish = finish;
    }

    public int getStamps() {
        return stamps;
    }

    public void setStamps(int stamps) {
        this.stamps = stamps;
    }

    public Timestamp getLastStamp() {
        return lastStamp;
    }

    public void setLastStamp(Timestamp lastStamp) {
        this.lastStamp = lastStamp;
    }
}
