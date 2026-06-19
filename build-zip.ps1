<#
.SYNOPSIS
    Builds an installable WordPress theme ZIP for grand4you.

.DESCRIPTION
    Produces ../grand4you.zip with the structure WordPress expects:
      - a single top-level "grand4you/" folder
      - forward slashes in every entry (Compress-Archive on PS 5.1 writes
        backslashes, which break installs -> we use System.IO.Compression)
      - explicit directory entries (without them WordPress reports
        "Dem Theme fehlt das Stylesheet style.css")

    Development-only files (.git, build-zip.ps1) are excluded.

.EXAMPLE
    powershell -ExecutionPolicy Bypass -File .\build-zip.ps1
#>

[CmdletBinding()]
param(
    # Theme folder to package. Defaults to the folder this script lives in.
    [string]$Source = $PSScriptRoot,

    # Output ZIP path. Defaults to <parent>/grand4you.zip
    [string]$OutFile = (Join-Path (Split-Path $PSScriptRoot -Parent) 'grand4you.zip')
)

$ErrorActionPreference = 'Stop'
Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem

$Source  = (Resolve-Path $Source).Path.TrimEnd('\')
$prefix  = Split-Path $Source -Leaf            # top-level folder name inside the ZIP, e.g. "grand4you"
$vcsDir  = '.g' + 'it'                         # the version-control directory to skip
$selfName = Split-Path $PSCommandPath -Leaf    # this script, so it isn't shipped in the theme

# Files/dirs to skip entirely (matched against any path segment, case-insensitive).
$excludeSegments = @($vcsDir)
# Files to skip by exact relative path (forward-slash form).
$excludeFiles    = @($selfName)

function Get-RelativeForwardSlash([string]$fullPath) {
    return ($fullPath.Substring($Source.Length + 1) -replace '\\', '/')
}

function Test-Excluded($item) {
    $segments = $item.FullName.Substring($Source.Length + 1).Split('\')
    foreach ($seg in $segments) {
        if ($excludeSegments -contains $seg) { return $true }
    }
    if (-not $item.PSIsContainer) {
        if ($excludeFiles -contains (Get-RelativeForwardSlash $item.FullName)) { return $true }
    }
    return $false
}

# Pull the theme version from style.css for a friendly summary line.
$version = '?'
$styleCss = Join-Path $Source 'style.css'
if (Test-Path $styleCss) {
    $m = Select-String -Path $styleCss -Pattern 'Version:\s*([\d.]+)' | Select-Object -First 1
    if ($m) { $version = $m.Matches[0].Groups[1].Value }
}

Write-Host "Packaging '$prefix' (version $version)" -ForegroundColor Cyan
Write-Host "  Source: $Source"
Write-Host "  Output: $OutFile"

if (Test-Path $OutFile) { [System.IO.File]::Delete($OutFile) }

$items = Get-ChildItem -Path $Source -Recurse -Force | Where-Object { -not (Test-Excluded $_) }
$dirs  = $items | Where-Object {  $_.PSIsContainer } | Sort-Object FullName
$files = $items | Where-Object { -not $_.PSIsContainer } | Sort-Object FullName

$zip = [System.IO.Compression.ZipFile]::Open($OutFile, [System.IO.Compression.ZipArchiveMode]::Create)
try {
    # Root + every sub-directory as an explicit entry (trailing slash).
    $zip.CreateEntry("$prefix/") | Out-Null
    foreach ($d in $dirs) {
        $zip.CreateEntry("$prefix/$(Get-RelativeForwardSlash $d.FullName)/") | Out-Null
    }
    # File entries.
    foreach ($f in $files) {
        $entryName = "$prefix/$(Get-RelativeForwardSlash $f.FullName)"
        [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile(
            $zip, $f.FullName, $entryName, [System.IO.Compression.CompressionLevel]::Optimal) | Out-Null
    }
} finally {
    $zip.Dispose()
}

$size = (Get-Item $OutFile).Length
Write-Host ("Done: {0:N0} bytes, {1} dirs + {2} files = {3} entries" -f `
    $size, ($dirs.Count + 1), $files.Count, ($dirs.Count + 1 + $files.Count)) -ForegroundColor Green
