<?php

namespace App\Console\Commands;

use App\Models\Passenger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AddPassengers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:passengers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add more Passengers';

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
        factory(Passenger::class, 10)->create();
    }
}
