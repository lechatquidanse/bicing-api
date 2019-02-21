<?php

$projectPath = __DIR__;

$scanDirectories = [
    $projectPath.'/bin/',
    $projectPath.'/config/',
    $projectPath.'/public/',
    $projectPath.'/src/',
    $projectPath.'/tests/',
];

$skipPackages = [
    'symfony/flex',
    'symfony/yaml',
    'symfony/proxy-manager-bridge',
    'simple-bus/doctrine-orm-bridge',
    'sensiolabs/security-checker',
    'jsor/doctrine-postgis',
];

return [
    'composerJsonPath' => $projectPath.'/composer.json', 'vendorPath' => $projectPath.'/vendor/',
    'skipPackages' => $skipPackages,
    'scanDirectories' => $scanDirectories,
];
