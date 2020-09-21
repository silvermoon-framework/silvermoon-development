<?php
declare(strict_types=1);

namespace Silvermoon\Configuration\Internal\Utility;

use Silvermoon\Configuration\Exception\InvalidNameException;

/**
 * Class ConfigMergeUtility
 * @package Silvermoon\Configuration\Helper
 */
class ConfigurationMergeUtility
{
    /**
     * @param array<mixed> $configuration
     * @param array<mixed> $configurationToAdd
     * @return array<mixed>
     */
    public static function mergeConfigRecursive(array $configuration, array $configurationToAdd): array
    {
        self::_mergeConfigRecursive($configuration, $configurationToAdd);
        return $configuration;
    }

    /**
     * @param array<mixed> $configuration
     * @param array<mixed> $configurationToAdd
     * @throws InvalidNameException
     */
    protected static function _mergeConfigRecursive(array &$configuration, array &$configurationToAdd): void
    {
        foreach ($configurationToAdd as $key => $value) {
            $parsedKey = self::parseKey($key);
            if (\array_key_exists($key, $configuration) === false) {
                $configuration[$key] = [];
            }
            if (\is_array($value) && $parsedKey['type'] === 'standard') {
                self::_mergeConfigRecursive($configuration[$key], $value);
                continue;
            }
            $configuration[$key] = $value;
        }
    }

    /**
     * @param string $key
     * @return array<mixed>
     * @throws InvalidNameException
     */
    protected static function parseKey(string $key): array
    {
        $result = [];
        $result['type'] = 'standard';
        $result['name'] = $key;
        $result['dataType'] = '';

        if (substr($key, -1) === ']') {
            $result['type'] = 'array';
            $openPosition = (int) \strpos($key, '[');
            $result['name'] = \substr($key, 0, $openPosition);
            $result['dataType'] = \substr($key, $openPosition + 1, -1);
            if ($result['dataType'] === '+') {
                $result['type'] = 'arrayAdd';
            }
        }
        if (substr($key, -1) === '>') {
            $result['type'] = 'object';
            $openPosition = (int) \strpos($key, '<');
            $result['name'] = \substr($key, 0, $openPosition);
            $result['dataType'] = \substr($key, $openPosition + 1, -1);
        }

        if (self::checkForValidCharacters($result['name']) === false) {
            throw new InvalidNameException(1600597338);
        }

        if ($result['type'] === 'array' || $result['type'] === 'object') {
            if (self::checkForValidDataType($result['dataType']) === false) {
                throw new InvalidNameException(1600629990);
            }
        }
        return $result;
    }

    /**
     * @param string $dataString
     * @return bool
     */
    protected static function checkForValidCharacters(string $dataString): bool
    {
        if (\preg_match('#^[a-zA-Z_][a-zA-Z0-9_]+$#', $dataString) !== 1) {
            return false;
        }
        return true;
    }

    /**
     * @param string $dataString
     * @return bool
     */
    protected static function checkForValidDataType(string $dataString): bool
    {
        $parts = \explode('\\', $dataString);
        foreach ($parts as $part) {
            if (self::checkForValidCharacters($part) === false) {
                return false;
            }
        }
        return true;
    }
}
