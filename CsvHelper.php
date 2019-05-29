<?php

/**
 * Class CsvHelper
 */
class CsvHelper
{
    /**
     * Convert file csv in Array
     *
     * @param string $filePath
     * @param int    $headRow
     * @param string $r
     *
     * @return null|array
     */
    public static function csvToArray(string $filePath, int $headRow = 0, string $r = ';'): array
    {
        if (file_exists($filePath)) {
            $counter = 0;

            if (($res = fopen($filePath, 'r')) !== false) {
                $data = [];

                while (($row = fgetcsv($res, 1000, $r)) !== false) {

                    if ($counter > $headRow) {
                        $data[] = $row;
                    }

                    $counter++;
                }

                fclose($res);

                return $data;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Convert Array to file csv
     *
     * @param string $filePath
     * @param array  $arData
     * @param string $r
     * @param array  $arHeads
     *
     * @return bool
     */
    public static function arrayToCsv(string $filePath, array $arData, string $r = ';', array $arHeads = []): bool
    {
        if ($arData) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $out = fopen($filePath, 'w');

            if ($arHeads) {
                fputcsv($out, $arHeads, $r);
            }

            foreach ($arData as $arItems) {
                fputcsv($out, $arItems, $r);
            }

            fclose($out);

            return true;
        }

        return false;
    }
}