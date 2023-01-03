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


::config\SlpBuilder.exe /clearoa30
title Clean OA3 Tools

:cleankey
bin\config\OEMCheckMSDM | find /i "Product key:"
if %errorlevel%==1 goto :cleanfail
bin\config\SlpBuilder.exe /clearoa30
slmgr /upk
goto :cleansuccess

:cleanfail
cls
color 4f
echo.
echo.
echo                                GEAR COMPUTER
echo.
echo.
echo         +---------+      +---------+      +---------+      +--------+
echo         ^|  OA3.0  ^|      ^|  Clean  ^|      ^|   KEY   ^|      ^| FAIL!! ^|
echo         +---------+      +---------+      +---------+      +--------+
echo.
echo.
echo                       Product Key di MSDM Table Kosong!!
echo.
echo.
echo. 
pause>nul
goto :end

:cleansuccess
cls
color 2f
echo.
echo.
echo                                GEAR COMPUTER
echo.
echo.
echo.
echo         +---------+      +---------+      +---------+      +--------+
echo         ^|  OA3.0  ^|      ^|  Clean  ^|      ^|   KEY   ^|      ^| PASS!! ^|
echo         +---------+      +---------+      +---------+      +--------+
echo.
echo.
echo                         Key Sudah Berhasil Dihapus
echo.
echo.   
pause>nul
shutdown /r -t 5 -c "Unit akan segera di restart dalam 5 detik!!!"

:end
exit