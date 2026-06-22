<?php

declare(strict_types=1);

namespace Symfinity\OmniaIpsum;

use Symfinity\OmniaIpsum\DependencyInjection\OmniaIpsumExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class OmniaIpsumBundle extends Bundle
{
    /** Org policy: config root {@code symfinity_omnia_ipsum} (rule 22), not {@code omnia_ipsum}. */
    public function getContainerExtension(): ExtensionInterface
    {
        return new OmniaIpsumExtension();
    }

    public function getContainerExtensionClass(): string
    {
        return OmniaIpsumExtension::class;
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
