<?php
declare(strict_types=1);

namespace SilvermoonTests\Configuration\Proxies\Helper;

use Silvermoon\Configuration\Helper\_ConfigMergeHelper;

class ConfigMergeHelperProxy extends _ConfigMergeHelper
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
    protected static function _mergeConfigRecursive(array &$configuration, array &$configurationToAdd): void
    {
        parent::_mergeConfigRecursive($configuration, $configurationToAdd); // TODO: Change the autogenerated stub
    }


}
