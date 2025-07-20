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
                'genre' => 'Crime Drama',
                'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=600&fit=crop&crop=faces'
            ],
            [
                'name' => 'Breaking Bad',
                'description' => 'A high school chemistry teacher turned methamphetamine manufacturer',
                'year_started' => 2008,
                'year_ended' => 2013,
                'genre' => 'Crime Drama',
                'image_url' => 'https://images.unsplash.com/photo-1489599735734-79b4f9ab7b34?w=400&h=600&fit=crop&crop=faces'
            ],
            [
                'name' => 'The Office',
                'description' => 'A mockumentary sitcom about office employees',
                'year_started' => 2005,
                'year_ended' => 2013,
                'genre' => 'Comedy',
                'image_url' => 'https://images.unsplash.com/photo-1497032628192-86f99bcd76bc?w=400&h=600&fit=crop&crop=faces'
            ],
            [
                'name' => 'Stranger Things',
                'description' => 'Supernatural horror series set in the 1980s',
                'year_started' => 2016,
                'year_ended' => null,
                'genre' => 'Sci-Fi Horror',
                'image_url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=400&h=600&fit=crop&crop=faces'
            ],
            [
                'name' => 'Game of Thrones',
                'description' => 'Epic fantasy drama series',
                'year_started' => 2011,
                'year_ended' => 2019,
                'genre' => 'Fantasy Drama',
                'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=600&fit=crop&crop=faces'
            ]
        ];

        foreach ($shows as $show) {
            \App\Models\TvShow::create($show);
        }
    }
}
