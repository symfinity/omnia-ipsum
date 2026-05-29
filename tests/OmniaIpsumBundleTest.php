<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum\Tests;

use Symfinity\OmniaIpsum\OmniaIpsumBundle;
use PHPUnit\Framework\TestCase;

final class OmniaIpsumBundleTest extends TestCase
{
    private OmniaIpsumBundle $bundle;

    protected function setUp(): void
    {
        $this->bundle = new OmniaIpsumBundle();
    }

    public function testGetPath(): void
    {
        $path = $this->bundle->getPath();

        $this->assertIsString($path);
        $this->assertDirectoryExists($path);
    }

    public function testGetPathPointsToPackageRoot(): void
    {
        $path = $this->bundle->getPath();

        // Should point to package root (containing src/, config/, etc.)
        $this->assertFileExists($path . '/composer.json');
        $this->assertDirectoryExists($path . '/src');
        $this->assertDirectoryExists($path . '/config');
    }
}
