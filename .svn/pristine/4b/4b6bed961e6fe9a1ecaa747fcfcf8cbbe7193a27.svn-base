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

import com.aionemu.gameserver.model.templates.item.ItemEnchantTemplate;
import gnu.trove.map.hash.TIntObjectHashMap;

import javax.xml.bind.Unmarshaller;
import javax.xml.bind.annotation.*;
import java.util.List;


/**
 * @author Alcapwnd
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlRootElement(name = "enchant_templates")
public class ItemEnchantData {

    @XmlElement(name = "enchant_template", required = true)
    protected List<ItemEnchantTemplate> enchantTemplates;

    @SuppressWarnings({"rawtypes", "unchecked"})
    @XmlTransient
    private TIntObjectHashMap<ItemEnchantTemplate> authorizes = new TIntObjectHashMap();

    void afterUnmarshal(Unmarshaller u, Object parent) {
        for (ItemEnchantTemplate it : this.enchantTemplates) {
            getEnchantMap().put(it.getId(), it);
        }
    }

    private TIntObjectHashMap<ItemEnchantTemplate> getEnchantMap() {
        return this.authorizes;
    }

    public ItemEnchantTemplate getEnchantTemplate(int id) {
        return (ItemEnchantTemplate) this.authorizes.get(id);
    }

    public int size() {
        return this.authorizes.size();
    }
}
