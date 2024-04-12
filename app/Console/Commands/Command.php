<?php

namespace App\Console\Commands;

use App\Utils\Log;
use Illuminate\Console\Command as BaseCommand;

class Command extends BaseCommand
{
    protected bool $disableLogging = false;

    public function line($string, $style = null, $verbosity = null)
    {
        if (!$this->disableLogging) {
            switch ($style) {
                case 'info':
                case 'error':
                    Log::log($style, $string, ['class' => static::class]);
                    break;

                case 'warn':
                    Log::warning($string, ['class' => static::class]);
                    break;

                default:
                    break;
            }
        }

        parent::line($string, $style, $verbosity);
    }

    /**
     * @param bool $value
     *
     * @return void
     */
    protected function disableLogging(bool $value)
    {
        $this->disableLogging = $value;
    }
}
