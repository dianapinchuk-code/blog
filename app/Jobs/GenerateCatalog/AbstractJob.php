<?php

namespace App\Jobs\GenerateCatalog;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AbstractJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        // Всі задачі цього типу йдуть в окрему чергу
        $this->onQueue('generate-catalog');
    }

    public function handle()
    {
        $this->debug('done');
    }

    protected function debug(string $msg)
    {
        $class = static::class;
        \Log::info("{$msg} [{$class}]");
    }
}
