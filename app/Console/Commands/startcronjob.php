<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\btg_countries;

class startcronjob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:soccer-feed-for-country';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch country data from API';

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
        /*$email = 'sumit.wgt@gmail.com';
        $data['msg'] = "Testing mail";
        Mail::send('mail_template', $data, function($message) use($email){
            $message->to($email)->subject('Welcome');
        });*/

        $APIkey='73dac184ad13d536393add5354f46bc4888797c9fa3387ed1d55b1e74f281b3c';
        $url="https://apifootball.com/api/?action=get_countries&APIkey=".$APIkey;
        $CountryResult = GetRequestFromAPI($url);
        foreach($CountryResult as $CountryKey=>$CountryValue)
        {
            $data = array('country_id'=>$CountryValue['country_id'],
                          'country_name'=>$CountryValue['country_name'],
                          'updation_date'=>date("Y-m-d H:i:s")
                          );
            $CheckCountryExist = btg_countries::where('country_id',$CountryValue['country_id'])->get()->toArray();
            if(empty($CheckCountryExist))
            {
                $InsertQuery = btg_countries::insert($data);
            }else{
                $UpdateTable = btg_countries::where('country_id',$CountryValue['country_id'])->update($data);
            }
        }
    }
}
