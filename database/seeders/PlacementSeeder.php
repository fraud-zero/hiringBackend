<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Placement;
use Faker\Factory as Faker;

class PlacementSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $platforms = ['app', 'web'];

        for ($i = 0; $i < 1139; $i++) {
            $total = $faker->numberBetween(10000, 300000);
            $invalidTotal = $faker->numberBetween(0, $total);
            $invalidTotalPercent = $invalidTotal / $total * 100;

            $pixelStuffing = $faker->numberBetween(0, $invalidTotal);
            $pixelStuffingPercent = $pixelStuffing / $total * 100;

            $viewable = $faker->numberBetween(0, $total - $invalidTotal);
            $viewablePercent = $viewable / $total * 100;

            $nonViewable = $total - $invalidTotal - $viewable;
            $nonViewablePercent = $nonViewable / $total * 100;

            $mfaSiteSymptoms = $faker->numberBetween(0, $invalidTotal - $pixelStuffing);
            $mfaSiteSymptomsPercent = $mfaSiteSymptoms / $total * 100;

            $otherInvalid = $invalidTotal - $pixelStuffing - $mfaSiteSymptoms;
            $otherInvalidPercent = $otherInvalid / $total * 100;

            Placement::create([
                'key' => $faker->domainName,
                'platform' => $faker->randomElement($platforms),
                'total' => $total,
                'invalid_total' => $invalidTotal,
                'invalid_total_percent' => number_format($invalidTotalPercent, 1),
                'pixel_stuffing' => $pixelStuffing,
                'pixel_stuffing_percent' => number_format($pixelStuffingPercent, 1),
                'viewable' => $viewable,
                'viewable_percent' => number_format($viewablePercent, 1),
                'non_viewable' => $nonViewable,
                'non_viewable_percent' => number_format($nonViewablePercent, 1),
                'mfa_site_symptoms' => $mfaSiteSymptoms,
                'mfa_site_symptoms_percent' => number_format($mfaSiteSymptomsPercent, 1),
                'other_invalid' => $otherInvalid,
                'other_invalid_percent' => number_format($otherInvalidPercent, 1),
            ]);
        }
    }
}
