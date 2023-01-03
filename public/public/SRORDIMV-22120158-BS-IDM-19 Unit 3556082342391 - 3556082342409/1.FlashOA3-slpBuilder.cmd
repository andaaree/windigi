@echo off

:: BatchGotAdmin
:-------------------------------------
REM  --> Check for permissions
    IF "%PROCESSOR_ARCHITECTURE%" EQU "amd64" (
>nul 2>&1 "%SYSTEMROOT%\SysWOW64\cacls.exe" "%SYSTEMROOT%\SysWOW64\config\system"
) ELSE (
>nul 2>&1 "%SYSTEMROOT%\system32\cacls.exe" "%SYSTEMROOT%\system32\config\system"
)

REM --> If error flag set, we do not have admin.
if '%errorlevel%' NEQ '0' (
    echo Requesting administrative privileges...
    goto UACPrompt
) else ( goto gotAdmin )

:UACPrompt
    echo Set UAC = CreateObject^("Shell.Application"^) > "%temp%\getadmin.vbs"
    set params= %*
    echo UAC.ShellExecute "cmd.exe", "/c ""%~s0"" %params:"=""%", "", "runas", 1 >> "%temp%\getadmin.vbs"

    "%temp%\getadmin.vbs"
    del "%temp%\getadmin.vbs"
    exit /B

:gotAdmin
    pushd "%CD%"
    CD /D "%~dp0"
:--------------------------------------   


::config\SlpBuilder.exe /oa30:OA3.bin
title Flash OA3 Tools

:InjectSN
echo Silahkan masukan SN
echo Mohon Perhatikan SN yang di input
set /p input="Ketikan SN :"
Bin\AMI\AMIDEWINx64.EXE /SS %input%
if %errorlevel%==0 goto :injectSNpass
goto :injectSNfail


 :injectSNfail
 del sde.log
 cls
 color 4f
 echo.
 echo                               GEAR COMPUTER
 echo.	                   
 echo.	                   
 echo         +--------+      +--------+      +--------+      +--------+
 echo         ^| Inject  ^|      ^|  SN   ^|      ^| Result ^|      ^| FAIL!! ^|
 echo         +--------+      +--------+      +--------+      +--------+
 echo.
 echo.
 echo                       Tolong minta bantuan teknisi!!
 echo.   
 pause>nul
 goto :end

 :injectSNpass
 del sde.log
 cls
 color 2f
 echo.
 echo                               GEAR COMPUTER
 echo.	                   
 echo.	                   
 echo         +--------+      +--------+      +--------+      +--------+
 echo         ^| Inject  ^|      ^|  SN   ^|      ^| Result ^|      ^| PASS!! ^|
 echo         +--------+      +--------+      +--------+      +--------+
 echo.
 echo.
 echo                       SN = %input%
 echo.   
 pause>nul
rem goto :checkkey

:checkkey
sde.log
echo Checking BIOS MSDM table ...
bin\config\OEMCheckMSDM | find /i "Product key:"
if %errorlevel%==0 goto :msdmfail
goto :getkey

:msdmfail
bin\config\OEMCheckMSDM | find /i "Product key:" > bin\config\key.txt
set /p keys=<bin\config\key.txt
del bin\config\key.txt
cls
color 4f
echo.
echo.
echo                                 GEAR COMPUTER
echo.
echo.
echo         +---------+      +---------+      +---------+      +---------+
echo         ^|  OA3.0  ^|      ^|  Check  ^|      ^|   KEY   ^|      ^| Exist!! ^|
echo         +---------+      +---------+      +---------+      +---------+
echo.
echo.
echo                     Key Sudah Ter-inject Di MSDM Table!!
echo.
echo              %keys%
echo.
echo. 
pause>nul
goto end


:getkey
for /f "delims=" %%i in ('dir /a-d /b Offline\XMLKeys\*.xml') do (
   set "fname=%%~i"
   for /f %%h in ('call bin\config\xpath.bat Offline\XMLKeys\%%~i "Key/ProductKey"') do set "nname=%%h" 
   for /f %%j in ('call bin\config\xpath.bat Offline\XMLKeys\%%~i "Key/ProductKeyID"') do set "idname=%%j"
   goto :crtbin
   )

:crtbin
color 07
echo Create bin File...
echo ^<InputKeyXMLFile^>Offline\XMLKeys\%fname%^</InputKeyXMLFile^> > bin\config\Input_XML.cfg
echo ^<ReportedXMLFile^>Gear_OA3_LOG\Out_Report\%fname%^</ReportedXMLFile^> > bin\config\Report_XML.cfg
type bin\config\Cfg_Front.cfg bin\config\Input_XML.cfg bin\config\Cfg_Assemble.cfg bin\config\Report_XML.cfg bin\config\Cfg_Back.cfg > bin\config\Cfg_offline.cfg
del bin\config\Input_XML.cfg
del bin\config\Report_XML.cfg
bin\config\OA3Tool64 /assemble /configfile=bin\config\Cfg_offline.cfg
if %errorlevel%==0 goto :inject
goto :getfail

:inject
echo Injecting key to BIOS MSDM table ...
if not exist oa3.bin goto :crtbin
bin\config\SlpBuilder.exe /oa30:OA3.bin
if %errorlevel%==1 goto :injectfail
slmgr /ipk %nname%
if %errorlevel%==0 goto :CreateLog
goto :injectfail

:getfail
del bin\config\Cfg_offline.cfg
cls
color 4f
echo.
echo.
echo                               GEAR COMPUTER
echo.
echo.
echo         +--------+      +--------+      +--------+      +--------+
echo         ^| OA3.0  ^|      ^|  KEY   ^|      ^| INJECT ^|      ^| FAIL!! ^|
echo         +--------+      +--------+      +--------+      +--------+
echo.
echo.
echo                   Pastikan XML File sudah di masukan!!!
echo.
echo.   
pause>nul
goto :end

:injectfail
del oa3.bin
del bin\config\Cfg_offline.cfg
cls
color 4f
echo.
echo.
echo                                GEAR COMPUTER
echo.
echo.
echo         +--------+      +--------+      +--------+      +--------+
echo         ^| OA3.0  ^|      ^|  KEY   ^|      ^| INJECT ^|      ^| FAIL!! ^|
echo         +--------+      +--------+      +--------+      +--------+
echo.
echo.
echo                           BIOS Tidak Compatible!!
echo.
echo. 
pause>nul
goto :end

:CreateLog
del oa3.bin
echo %input% >> Gear_OA3_LOG\LogSNCasing\%input%.txt
echo %nname% >> Gear_OA3_LOG\LogSNCasing\%input%.txt
echo %idname% >> Gear_OA3_LOG\LogSNCasing\%input%.txt
echo %nname%>>Gear_OA3_LOG\LogKeys.txt
echo %idname%>>Gear_OA3_LOG\LogID.txt
echo %nname%>>Gear_OA3_LOG\QRlog.txt
echo %nname%>>Gear_OA3_LOG\BClog.txt
bin\config\OA3Tool64 /Report /configfile=bin\config\Cfg_offline.cfg /LogTrace=Gear_OA3_LOG\Out_Log\%idname%.log
bin\config\OA3Tool64 /Report /configfile=bin\config\Cfg_offline.cfg
bin\config\QR\zint -b 58 --scale=3 --border=10 -o Gear_OA3_LOG\QR\%idname%.png -i Gear_OA3_LOG\QRlog.txt
bin\config\QR\zint -b 60 --scale=1 --border=10 -o Gear_OA3_LOG\Barcode\%idname%.png -i Gear_OA3_LOG\BClog.txt
move Offline\XMLKeys\%fname% Gear_OA3_LOG\Out_XML\%fname%
del bin\config\Cfg_offline.cfg
del Gear_OA3_LOG\QRlog.txt
del Gear_OA3_LOG\BClog.txt
if %errorlevel%==1 goto :getfail
goto :injectsuccess

:injectsuccess
cls
color 2f
echo.
echo.
echo                               GEAR COMPUTER
echo.
echo.
echo.
echo         +--------+      +--------+      +--------+      +--------+
echo         ^| OA3.0  ^|      ^|  KEY   ^|      ^| INJECT ^|      ^| PASS!! ^|
echo         +--------+      +--------+      +--------+      +--------+
echo.
echo.
echo                 ProductrKey  = %nname%
echo                 ProductKeyId = %idname%
echo.
echo.   
pause>nul
goto :Q


:Q
shutdown /r -t 5 -c "Unit akan segera di restart dalam 5 detik!!!"

:end
exit