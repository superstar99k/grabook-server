<?php

namespace App\Domain;

/**
 * @package namespace App\Domain;
 */
final class ClientUrlConcrete implements ClientUrl
{
    /**
     * クライアント側のUrl生成
     *
     * @param string $path
     * @param array $params
     * @param array $query
     *
     * @return string etc:domain/path?queryParam
     */
    public function getClientUrl(string $pathName, array $params = [], array $query = []): string
    {
        $baseUrl = config('app.client_url');
        $path = config($pathName);

        foreach ($params as $key => $value) {
            $path = str_replace(":{$key}", $value, $path);
        }

        return sprintf('%s%s?%s', $baseUrl, $path, http_build_query($query));
    }
}
