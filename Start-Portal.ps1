$ErrorActionPreference = 'Stop'
$workspaceDirectory = $PSScriptRoot
$portalDirectory = Join-Path $workspaceDirectory 'portal'
$temporaryDirectory = Join-Path $workspaceDirectory 'tmp'
function Test-LocalPort([int] $Port) {
    $client = [System.Net.Sockets.TcpClient]::new()
    try { $client.Connect('127.0.0.1', $Port); return $true }
    catch { return $false }
    finally { $client.Dispose() }
}
if (-not (Test-Path (Join-Path $portalDirectory 'vendor\autoload.php'))) {
    throw 'Install dependencies first: open portal and run composer install.'
}
$localEnvironment = Get-Content (Join-Path $portalDirectory '.env')
$usesBundledMySql = ($localEnvironment -match '^DB_PORT=3308$') -and ($localEnvironment -match '^DB_CONNECTION=mysql$')
if ($usesBundledMySql -and -not (Test-LocalPort 3308)) {
    $mysqlDirectory = Get-ChildItem (Join-Path $temporaryDirectory 'mysql-runtime') -Directory | Where-Object {Test-Path (Join-Path $_.FullName 'bin\mysqld.exe')} | Sort-Object Name -Descending | Select-Object -First 1
    if (-not $mysqlDirectory -or -not (Test-Path (Join-Path $temporaryDirectory 'mysql8-data\auto.cnf'))) {
        throw 'The local MySQL runtime is missing. Follow docs/LOCAL_RUN.md or configure your own MySQL server in portal/.env.'
    }
    $mysqlDataDirectory = Join-Path $temporaryDirectory 'mysql8-data'
    $mysqlArguments = @('--no-defaults', "--basedir=`"$($mysqlDirectory.FullName)`"", "--datadir=`"$mysqlDataDirectory`"", '--port=3308', '--bind-address=127.0.0.1', '--mysqlx=OFF', '--console')
    Start-Process -FilePath (Join-Path $mysqlDirectory.FullName 'bin\mysqld.exe') -ArgumentList $mysqlArguments -WindowStyle Hidden -RedirectStandardOutput (Join-Path $temporaryDirectory 'mysql8.out.log') -RedirectStandardError (Join-Path $temporaryDirectory 'mysql8.err.log') | Out-Null
}
if (-not (Test-LocalPort 8000)) {
    Start-Process -FilePath (Get-Command php).Source -ArgumentList @('artisan', 'serve', '--host=127.0.0.1', '--port=8000', '--tries=1', '--no-reload') -WorkingDirectory $portalDirectory -WindowStyle Hidden -RedirectStandardOutput (Join-Path $temporaryDirectory 'portal-mysql.out.log') -RedirectStandardError (Join-Path $temporaryDirectory 'portal-mysql.err.log') | Out-Null
}
Write-Output 'CoursePath is starting at http://127.0.0.1:8000'
Write-Output 'Admin login: http://127.0.0.1:8000/login'
Write-Output 'Local account details are in tmp/LOCAL_ADMIN_ACCESS.txt if created during setup.'
