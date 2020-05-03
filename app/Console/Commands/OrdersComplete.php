<?php

namespace App\Console\Commands;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class OrdersComplete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Complete all yesterday orders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $yesterday = new DateTime('yesterday');
        $now = new DateTime();

        DB::table('orders')
            ->whereBetween('created_at', [$yesterday, $now])
            ->where('status', 'accepted')
            ->update(['status' => 'processed']);
    }
}
