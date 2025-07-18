<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TvShowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shows = [
            [
                'name' => 'Dexter',
                'description' => 'Crime drama about a forensic blood spatter analyst who leads a secret life as a vigilante serial killer',
                'year_started' => 2006,
                'year_ended' => 2013,
                'genre' => 'Crime Drama'
            ],
            [
                'name' => 'Breaking Bad',
                'description' => 'A high school chemistry teacher turned methamphetamine manufacturer',
                'year_started' => 2008,
                'year_ended' => 2013,
                'genre' => 'Crime Drama'
            ],
            [
                'name' => 'The Office',
                'description' => 'A mockumentary sitcom about office employees',
                'year_started' => 2005,
                'year_ended' => 2013,
                'genre' => 'Comedy'
            ],
            [
                'name' => 'Stranger Things',
                'description' => 'Supernatural horror series set in the 1980s',
                'year_started' => 2016,
                'year_ended' => null,
                'genre' => 'Sci-Fi Horror'
            ],
            [
                'name' => 'Game of Thrones',
                'description' => 'Epic fantasy drama series',
                'year_started' => 2011,
                'year_ended' => 2019,
                'genre' => 'Fantasy Drama'
            ]
        ];

        foreach ($shows as $show) {
            \App\Models\TvShow::create($show);
        }
    }
}
