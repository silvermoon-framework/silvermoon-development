<?php
declare(strict_types=1);

namespace SilvermoonTests\Configuration\Proxies\Utility;

use Silvermoon\Configuration\Internal\Utility\ConfigurationMergeUtility as OriginalConfigurationMergeUtility;

class ConfigurationMergeUtility extends OriginalConfigurationMergeUtility
{
    public static function parseKey(string $key): array
    {
        return parent::parseKey($key);
    }

    /**
     * @param array $configuration
     * @param array $configurationToAdd
     * @throws \Silvermoon\Configuration\Exception\InvalidNameException
     */
    public static function _mergeConfigRecursive(array &$configuration, array &$configurationToAdd): void
    {
        parent::_mergeConfigRecursive($configuration, $configurationToAdd); // TODO: Change the autogenerated stub
    }
}