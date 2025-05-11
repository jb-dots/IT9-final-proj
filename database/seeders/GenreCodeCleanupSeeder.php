<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenreCodeCleanupSeeder extends Seeder
{
    public function run()
    {
        $genres = DB::table('genres')->get();

        $existingCodes = DB::table('genres')
            ->whereNotNull('code')
            ->where('code', '<>', '')
            ->pluck('code')
            ->toArray();

        foreach ($genres as $genre) {
            if (empty($genre->code)) {
                // Generate a unique code based on genre name or random string
                $baseCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $genre->name), 0, 5));
                $code = $baseCode;
                $suffix = 1;

                // Ensure uniqueness
                while (in_array($code, $existingCodes) || $code === '') {
                    $code = $baseCode . $suffix;
                    $code = substr($code, 0, 5); // Ensure max length 5
                    $suffix++;
                }

                // Update the genre with the unique code
                DB::table('genres')
                    ->where('id', $genre->id)
                    ->update(['code' => $code]);

                $existingCodes[] = $code;
            }
        }
    }
}
