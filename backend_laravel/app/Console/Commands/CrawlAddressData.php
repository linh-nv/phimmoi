<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Util\Constains;

class CrawlAddressData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:address-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl address data from external APIs and store it in the database';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();

        // Crawl provinces
        $this->info('Crawling provinces...');
        $provinceResponse = $client->get(Constains::URL_API_PROVINCE);
        $provinces = json_decode($provinceResponse->getBody(), true)['results'];

        $provinceData = [];
        $provinceIds = [];
        foreach ($provinces as $province) {
            $provinceData[] = [
                'province_id' => $province['province_id'],
                'province_name' => $province['province_name'],
                'province_type' => $province['province_type'],
            ];
            $provinceIds[] = $province['province_id'];
        }

        Province::upsert($provinceData, ['province_id'], ['province_name', 'province_type']);

        // Crawl districts
        $this->info('Crawling districts...');
        $districtData = [];
        foreach ($provinceIds as $provinceId) {
            $districtResponse = $client->get(Constains::URL_API_DISTRICT . $provinceId);
            $districts = json_decode($districtResponse->getBody(), true)['results'];
            foreach ($districts as $district) {
                $districtData[] = [
                    'district_id' => $district['district_id'],
                    'district_name' => $district['district_name'],
                    'district_type' => $district['district_type'],
                    'lat' => $district['lat'] ?? null,
                    'lng' => $district['lng'] ?? null,
                    'province_id' => $district['province_id'],
                ];
            }
        }

        District::upsert($districtData, ['district_id'], ['district_name', 'district_type', 'lat', 'lng', 'province_id']);

        // Crawl wards
        $this->info('Crawling wards...');
        $wardData = [];
        foreach ($districtData as $district) {
            $districtId = $district['district_id'];
            $wardResponse = $client->get(Constains::URL_API_WARD . $districtId);
            $wards = json_decode($wardResponse->getBody(), true)['results'];
            foreach ($wards as $ward) {
                $wardData[] = [
                    'ward_id' => $ward['ward_id'],
                    'ward_name' => $ward['ward_name'],
                    'ward_type' => $ward['ward_type'],
                    'district_id' => $ward['district_id'],
                ];
            }
        }

        // Chunk the ward data to avoid too many placeholders error
        $chunkSize = 1000;
        foreach (array_chunk($wardData, $chunkSize) as $chunk) {
            Ward::upsert($chunk, ['ward_id'], ['ward_name', 'ward_type', 'district_id']);
        }

        $this->info('Crawling completed!');
    }
}
