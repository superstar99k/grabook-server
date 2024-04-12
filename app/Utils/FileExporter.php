<?php

namespace App\Utils;

class FileExporter
{
    public static function getExportFileHeaders(string $fileName, string $contentType)
    {
        $headers = [
            'Content-type' => $contentType,
            'Content-Disposition' => sprintf('attachment; filename="%s";', urlencode($fileName)),
            'Access-Control-Expose-Headers' => 'Content-Disposition',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return $headers;
    }
}
