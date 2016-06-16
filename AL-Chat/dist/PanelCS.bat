@ECHO off
TITLE AionReborn - CommunityServer Monitor
Color 9f
:MENU
CLS
ECHO.
ECHO   ^*--------------------------------------------------------------------------^*
ECHO   ^|                    AionReborn - CommunityServer Monitor                  ^|
ECHO   ^*--------------------------------------------------------------------------^*
ECHO   ^|                                                                          ^|
ECHO   ^|    1 - Entwicklung                                       3 - Beenden     ^|
ECHO   ^|    2 - Betrieb                                                           ^|
ECHO   ^|                                                                          ^|
ECHO   ^*--------------------------------------------------------------------------^*
ECHO.
SET /P OPTION=Triff deine Auswahl und druecke ENTER: 
IF %OPTION% == 1 (
SET MODE=Entwicklung
SET JAVA_OPTS=-Xms256m -Xmx512m -Xdebug -Xrunjdwp:transport=dt_socket,address=8997,server=y,suspend=n -ea
CALL StartCS.bat
)
IF %OPTION% == 2 (
SET MODE=Betrieb
SET JAVA_OPTS=-Xms512m -Xmx1024m -client
CALL StartCS.bat
)
IF %OPTION% == 3 (
EXIT
)
IF %OPTION% GEQ 4 (
GOTO :MENU
)
