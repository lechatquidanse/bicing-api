<?php

$projectPath = __DIR__;

$scanDirectories = [
    $projectPath.'/src/',
    $projectPath.'/config/',
    $projectPath.'/tests/',
];

return [
    'composerJsonPath' => $projectPath.'/composer.json', 'vendorPath' => $projectPath.'/vendor/',
    'scanDirectories' => $scanDirectories,
];
