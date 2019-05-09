<?php

namespace App\Console\Commands;

use App\Gliederung;
use Illuminate\Console\Command;

class commandUpdateGliederungen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gliederung:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Gliederung Table from DLRG API';

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
        $str = json_decode(file_get_contents('http://services.dlrg.net/service.php?doc=poi&strict=1&typFilter=Gld&limit=5000'), true);

        if (!empty($str['locs']))
        {
            foreach($str['locs'] as $loc => $gliederung)
            {
                /*
                "lat": "50.9241",
                "lon": "14.7701",
                "typ": "Gld",
                "pois": [{
                    "bez": "Bezirk",
                    "name": "Zittau e.V.",
                    "plz": "02763",
                    "ort": "Zittau",
                    "typ": "Gld",
                    "id": "2059"
                }],
                "dist": "5.605647941815509"
                */

                if (!Gliederung::where('gliederung_id', $gliederung['pois'][0]['id'])->exists())
                {
                    $gliederung = new Gliederung();
                    $gliederung->gliederung_id = $gliederung['pois'][0]['id'];
                    $gliederung->name = $gliederung['pois'][0]['name'];
                    $gliederung->ort = $gliederung['pois'][0]['ort'];
                    $gliederung->plz = $gliederung['pois'][0]['plz'];
                    $gliederung->bez = $gliederung['pois'][0]['bez'];

                    $gliederung->save();
                    echo "create " . $gliederung['pois'][0]['name'] . "\n";
                }
            }
        }
    }
}
