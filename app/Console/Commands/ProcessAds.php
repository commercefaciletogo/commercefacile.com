<?php

namespace App\Console\Commands;

use App\Jobs\ProcessAds as ProcessAdsJob;
use Illuminate\Console\Command;

class ProcessAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:processads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron to process ads status every mid-night';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            dispatch(new ProcessAdsJob());
            $this->info('Done Processing...');
        }catch (\Exception $e){
            $this->error("Error while processing... <> {$e->getMessage()}");
        }
    }
}
