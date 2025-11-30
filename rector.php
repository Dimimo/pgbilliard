<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use RectorLaravel\Rector\Class_\LivewireComponentComputedMethodToComputedAttributeRector;

try {
    return RectorConfig::configure()
        ->withPaths([
            __DIR__ . '/app',
            __DIR__ . '/lang',
            __DIR__ . '/resources',
            __DIR__ . '/routes',
            __DIR__ . '/tests',
        ])
        // uncomment to reach your current PHP version
        ->withPhpSets(php83: true)
        ->withSets([
            \RectorLaravel\Set\LaravelLevelSetList::UP_TO_LARAVEL_120,
            //\RectorLaravel\Set\LaravelSetList::LARAVEL_CODE_QUALITY,
            //\RectorLaravel\Set\LaravelSetList::LARAVEL_ARRAYACCESS_TO_METHOD_CALL,

        ])
        ->withRules([
            //LivewireComponentComputedMethodToComputedAttributeRector::class,
        ])
        ->withTypeCoverageLevel(0)
        ->withDeadCodeLevel(0)
        ->withCodeQualityLevel(0);
} catch (\Rector\Exception\Configuration\InvalidConfigurationException $e) {
    //
}
