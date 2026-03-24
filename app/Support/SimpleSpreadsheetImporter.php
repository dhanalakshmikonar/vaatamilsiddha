<?php

namespace App\Support;

use RuntimeException;
use ZipArchive;

class SimpleSpreadsheetImporter
{
    public static function parse(string $path): array
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return match ($extension) {
            'csv' => self::parseCsv($path),
            'xlsx' => self::parseXlsx($path),
            default => throw new RuntimeException('Only CSV and XLSX files are supported.'),
        };
    }

    private static function parseCsv(string $path): array
    {
        $rows = [];
        $handle = fopen($path, 'r');

        if (!$handle) {
            throw new RuntimeException('Unable to read the uploaded CSV file.');
        }

        while (($row = fgetcsv($handle)) !== false) {
            $rows[] = array_map(fn ($value) => trim((string) $value), $row);
        }

        fclose($handle);

        return self::removeEmptyRows($rows);
    }

    private static function parseXlsx(string $path): array
    {
        $zip = new ZipArchive();

        if ($zip->open($path) !== true) {
            throw new RuntimeException('Unable to open the uploaded XLSX file.');
        }

        $sharedStrings = [];
        $sharedStringsXml = $zip->getFromName('xl/sharedStrings.xml');

        if ($sharedStringsXml !== false) {
            $xml = simplexml_load_string($sharedStringsXml);

            if ($xml) {
                foreach ($xml->si as $item) {
                    $text = '';

                    if (isset($item->t)) {
                        $text = (string) $item->t;
                    } else {
                        foreach ($item->r as $run) {
                            $text .= (string) $run->t;
                        }
                    }

                    $sharedStrings[] = trim($text);
                }
            }
        }

        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if ($sheetXml === false) {
            throw new RuntimeException('The XLSX file does not contain a readable first sheet.');
        }

        $xml = simplexml_load_string($sheetXml);

        if (!$xml || !isset($xml->sheetData)) {
            throw new RuntimeException('Invalid XLSX sheet structure.');
        }

        $rows = [];

        foreach ($xml->sheetData->row as $row) {
            $currentRow = [];

            foreach ($row->c as $cell) {
                $reference = (string) $cell['r'];
                preg_match('/([A-Z]+)/', $reference, $matches);
                $columnLetters = $matches[1] ?? 'A';
                $columnIndex = self::columnLettersToIndex($columnLetters);
                $type = (string) $cell['t'];
                $value = '';

                if ($type === 's') {
                    $sharedIndex = (int) $cell->v;
                    $value = $sharedStrings[$sharedIndex] ?? '';
                } elseif ($type === 'inlineStr') {
                    $value = trim((string) $cell->is->t);
                } else {
                    $value = trim((string) $cell->v);
                }

                $currentRow[$columnIndex] = $value;
            }

            if ($currentRow !== []) {
                ksort($currentRow);
                $rows[] = array_values($currentRow);
            }
        }

        return self::removeEmptyRows($rows);
    }

    private static function removeEmptyRows(array $rows): array
    {
        return array_values(array_filter($rows, function ($row) {
            foreach ($row as $value) {
                if (trim((string) $value) !== '') {
                    return true;
                }
            }

            return false;
        }));
    }

    private static function columnLettersToIndex(string $letters): int
    {
        $letters = strtoupper($letters);
        $index = 0;

        for ($i = 0; $i < strlen($letters); $i++) {
            $index = ($index * 26) + (ord($letters[$i]) - 64);
        }

        return $index - 1;
    }
}
