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
     * @param bool   $fileReWrite
     *
     * @return bool
     */
    public static function arrayToCsv(string $filePath, array $arData, string $r = ';', array $arHeads = [], bool $fileReWrite = false): bool
    {
        if ($arData) {
            if (file_exists($filePath) && $fileReWrite) {
                unlink($filePath);
            }

            $fileTemp = tmpfile();
            $pathTempFile = stream_get_meta_data($fileTemp)['uri'];
            $tempOut  = fopen($pathTempFile, 'w');

            if ($arHeads) {
                fputcsv($tempOut, $arHeads, $r);
            }

            foreach ($arData as $arItems) {
                fputcsv($tempOut, $arItems, $r);
            }

            file_put_contents($filePath, file_get_contents($pathTempFile), FILE_APPEND);
            fclose($tempOut);

            return true;
        }

        return false;
    }
}
