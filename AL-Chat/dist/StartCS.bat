@ECHO off
TITLE AionReborn - CommunityServer Monitor
Color 9f
:START
CLS
IF "%MODE%" == "" (
CALL PanelCS.bat
)
ECHO Starte den Aion Reborn Community Server im %MODE%s Modus.
JAVA %JAVA_OPTS% -cp ./libs/*;AL-Chat.jar com.aionemu.chatserver.ChatServer
SET CLASSPATH=%OLDCLASSPATH%
IF ERRORLEVEL 2 GOTO START
IF ERRORLEVEL 1 GOTO ERROR
IF ERRORLEVEL 0 GOTO END
:ERROR
ECHO.
ECHO Der CommunityServer wurde unerwartet beendet!
ECHO.
PAUSE
EXIT
:END
ECHO.
ECHO Community Server Abgeschaltet!
ECHO.
PAUSE
EXIT
