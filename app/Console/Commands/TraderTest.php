<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Services\BacktestService;
use App\Models\Repositories\UserRepository;

class TraderTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trader:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public $backtestService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(BacktestService $backtest_service)
    {
        parent::__construct();

        $this->backtestService = $backtest_service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->backtestService->run(1, 'MeanTrader', 1);
    }
}
