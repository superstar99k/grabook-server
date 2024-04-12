<?php

namespace Tests;

use App\Utils\Log;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function runTest()
    {
        try {
            return parent::runTest();
        } catch (\Throwable $e) {
            Log::error($e);

            throw $e;
        }
    }
}
