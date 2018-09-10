<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\btg_user_betting_accounts;
use Session;

class RechargeUserAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:recharge-user-account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recharge user account every week';

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
        $data = array('amount'=>100000,
                      'updation_date'=>date("Y-m-d H:i:s")
                      );
        $InsertQuery = btg_user_betting_accounts::where('status',1)->update($data);
    }
}
