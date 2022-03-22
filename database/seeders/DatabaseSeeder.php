<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(10)->create(50);
         \App\Models\Buyer::factory(10)->create(50);
         \App\Models\BuyerSetup::factory(10)->create(50);
         \App\Models\BuyerFilter::factory(10)->create(50);
         \App\Models\Partner::factory(10)->create(50);
         \App\Models\UKLead::factory(10)->create(50);
         \App\Models\USLead::factory(10)->create(50);
         \App\Models\Report::factory(10)->create(50);
         \App\Models\Invoice::factory(10)->create(50);
         \App\Models\Offer::factory(10)->create(50);
         \App\Models\LeadLog::factory(10)->create(50);
         \App\Models\Postback::factory(10)->create(50);
         \App\Models\Advertiser::factory(10)->create(50);
//          TODO
    }
}
