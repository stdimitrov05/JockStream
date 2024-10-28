<?php

namespace Stdimitrov\Jockstream\Lib;

class Helper
{
    /**
     * Prepare fields, placeholders & values for sql string
     *
     * @param array $params
     * @return array
     */
    public static function prepareSqlParams(array $params): array
    {
        $result = [];

        if (!empty($params)) {
            $result['columns'] = implode(', ', array_keys($params));
            $count = count($params);
            $result['placeholders'] = implode(', ', array_fill(1, $count, '?'));
            $result['values'] = array_values($params);
        }

        return $result;
    }

    public static function extractPlaceholders($query): array
    {
        preg_match_all('/\?/', $query, $matches);

        return array_keys($matches[0]); // Return the indices array
    }

    /**
     * Converts keys in a multidimensional array from snake_case to camelCase recursively.
     *
     * @param $data
     * @return array|mixed
     */
    public static function snakeToCamelArray($data): mixed
    {
        if (!is_array($data)) {
            return $data; // If not an array, return as is
        }

        $result = [];
        foreach ($data as $key => $value) {
            // Convert snake_case key to camelCase
            $camelKey = lcfirst(str_replace('_', '', ucwords($key, '_')));

            // Recursively apply the conversion to nested arrays
            if (is_array($value)) {
                $result[$camelKey] = self::snakeToCamelArray($value);
            } else {
                $result[$camelKey] = $value;
            }

            ksort($result);
        }

        return $result;
    }

    /**
     * Checks if an object is empty (has no properties or all properties are null).
     *
     * @param object $obj The object to check.
     * @return bool Returns true if the object is empty, false otherwise.
     */
    public static function isObjectEmpty(object $obj): bool
    {
        // Get object properties
        $properties = get_object_vars($obj);

        // Check if the object has no properties or all properties are null
        foreach ($properties as $property) {
            if (!is_null($property)) {
                return false;
            }
        }

        return true;
    }


}