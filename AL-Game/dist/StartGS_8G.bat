@echo off
TITLE AionReborn - WorldServer Monitor
Color 9f
SET PATH="..\..\Java\bin"
REM NOTE: Remove tag REM from previous line.
:START
CLS

echo.

echo Starte den Aion WorldServer fuer Client 4.9.

echo.

REM -------------------------------------  
REM Default parameters for a basic server.
java -Xms1280m -Xmx8192m -XX:MaxHeapSize=8192m -Xdebug -XX:MaxNewSize=24m -XX:NewSize=24m -XX:+UseParNewGC -XX:+CMSParallelRemarkEnabled -XX:+UseConcMarkSweepGC -XX:-UseSplitVerifier -ea -javaagent:./libs/al-commons.jar -cp ./libs/*;./libs/AL-Game.jar com.aionemu.gameserver.GameServer
REM -------------------------------------
SET CLASSPATH=%OLDCLASSPATH%

if ERRORLEVEL 2 goto restart
if ERRORLEVEL 1 goto error
if ERRORLEVEL 0 goto end

REM Restart...
:restart
echo.
echo Administrator Restart ...
echo.
goto start

REM Error...
:error
echo.
echo Server terminated abnormaly ...
echo.
goto end

REM End...
:end
echo.
echo Server terminated ...
echo.
pause
