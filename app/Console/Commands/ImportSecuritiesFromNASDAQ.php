<?php

namespace Trade\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use Trade\Security;

class ImportSecuritiesFromNASDAQ extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'securities:import_nasdaq';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import securities from NASDAQ';

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
        $nasdaq_file = 'storage/app/security_lists/nasdaq_security_list.txt';

        if (!file_exists($nasdaq_file)) {
            // set up basic connection 
            $conn_id = ftp_connect('ftp.nasdaqtrader.com'); 

            // login with username and password 
            $login_result = ftp_login($conn_id, 'anonymous', ''); 

            //Download file
            $handle = fopen($nasdaq_file, 'w');

            ftp_fget($conn_id, $handle, 'SymbolDirectory/nasdaqlisted.txt', FTP_ASCII);
        }

        //Open file
        $handle = fopen($nasdaq_file, 'r');

        $header = fgetcsv($handle, 0, '|');

        while ($row = fgetcsv($handle, 0, '|')) {
            $row = array_combine($header, $row);
            if (!$row['Security Name']) {
                continue;
            }

            $existing_security = Security::where('symbol', $row['Symbol'])->first();

            if (!$existing_security) {
                $security = Security::create([
                    'symbol'    => $row['Symbol'],
                    'name'      => $row['Security Name'],
                    'market'    => 'NASDAQ'
                ]);
            }
        }
    }
}
