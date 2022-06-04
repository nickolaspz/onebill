<?php

class Nik
{
    /**
     * Extract all values with specified key
     */
    public static function extract($array, $keyToExtract)
    {
        $results = [];
        return Nik::extractSub($array, $keyToExtract, $results);
    }

    public static function extractSub(array $array, $keyToExtract, $results)
    {
        foreach ($array as $key => $value) {
            if ($key === $keyToExtract) {
                $results[] = $value;
            } else if (is_array($value)) {
                $results = Nik::extractSub($value, $keyToExtract, $results);
            }
        }

        return $results;
    }
}