@echo off
start javaw -Xms8096m -Xmx8096m -cp ./libs/*;packetsamurai.jar com.aionemu.packetsamurai.PacketSamurai
exit