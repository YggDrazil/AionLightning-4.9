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
package com.aionemu.packetsamurai.utils;

import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.util.List;

import javolution.util.FastList;

import com.aionemu.packetsamurai.PacketSamurai;
import com.aionemu.packetsamurai.parser.datatree.ValuePart;
import com.aionemu.packetsamurai.session.DataPacket;

/**
 * @author Falke_34
 */
public class NpcRiftExporter {

	private List<DataPacket> packets;
	private String sessionName;	
	private FastList<NpcSpawn> spawns = new FastList<NpcSpawn>();

	public NpcRiftExporter(List<DataPacket> packets, String sessionName) {
		this.packets = new FastList<DataPacket>(packets);
		this.sessionName = sessionName;
	}

	public void parse() {
		String filename = "rift_spawns_" + sessionName + ".xml";
		System.currentTimeMillis();

		try {
			String file = "output/Rift_Spawn/"+filename;
			BufferedWriter out = new BufferedWriter(new FileWriter(file));

			// Collect info about all seen NPCs
			for (DataPacket packet : packets){
				String packetName = packet.getName();

				if ("SM_RIFT_ANNOUNCE".equals(packetName)){
					NpcSpawn spawn = new NpcSpawn();
					FastList<ValuePart> valuePartList = new FastList<ValuePart>(packet.getValuePartList());
					
					for (ValuePart valuePart : valuePartList){
						String partName = valuePart.getModelPart().getName();
						if ("x".equals(partName))
							spawn.x = Float.parseFloat(valuePart.readValue());
						else if ("y".equals(partName))
							spawn.y = Float.parseFloat(valuePart.readValue());
						else if ("z".equals(partName))
							spawn.z = Float.parseFloat(valuePart.readValue());
					}
					boolean exists = false;
					if (!exists)
						spawns.add(spawn);
				}
			}

			for (NpcSpawn n : spawns){
				StringBuilder sb = new StringBuilder();
				sb.append("<rift_template  x=\"");
				sb.append(n.x);
				sb.append("\" y=\"");
				sb.append(n.y);
				sb.append("\" z=\"");
				sb.append(n.z);
				sb.append("\" />\n");
				
				out.write(sb.toString());
			}
			out.close();
		}
		catch (IOException e) {
			e.printStackTrace();
		}
		if (!spawns.isEmpty())
			PacketSamurai.getUserInterface().log("Export [RiftSpawn] - Rift Spawns Has Been Written Successful");
	}

	class NpcSpawn {
		float x;
		float y;
		float z;
	}
}