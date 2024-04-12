<?php

namespace App\Domain;

/**
 * @package namespace App\Domain;
 */
interface ClientUrl
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
    public function getClientUrl(string $path, array $params = [], array $query = []): string;
}
