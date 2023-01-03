@echo off
title OA3 Check Key

:checkkey
echo Checking BIOS MSDM table ...
bin\config\OEMCheckMSDM | find /i "Product key:"
if %errorlevel%==0 goto :msdmsuccess
goto :msdmfail


:msdmsuccess
bin\config\OEMCheckMSDM | find /i "Product key:" > bin\config\key.txt
set /p keys=<bin\config\key.txt
del bin\config\key.txt
cls
color 2f
echo.
echo.
echo                                  GEAR COMPUTER
echo.
echo.
echo         +---------+      +---------+      +---------+      +---------+
echo         ^|  OA3.0  ^|      ^|  Check  ^|      ^|   KEY   ^|      ^| Exist!! ^|
echo         +---------+      +---------+      +---------+      +---------+
echo.
echo.
echo                      Key Sudah Ter-inject Di MSDM Table!!
echo.
echo              %keys%
echo.
echo. 
pause>nul
goto end

:msdmfail
cls
color 4f
echo.
echo.
echo                                  GEAR COMPUTER
echo.
echo.
echo         +---------+      +---------+      +---------+      +---------+
echo         ^|  OA3.0  ^|      ^|  Check  ^|      ^|   KEY   ^|      ^| Empty!! ^|
echo         +---------+      +---------+      +---------+      +---------+
echo.
echo.
echo                       Product Key di MSDM Table Kosong!!
echo.
echo.
echo. 
pause>nul
goto end

:end
exit