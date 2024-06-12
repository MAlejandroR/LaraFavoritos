<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;

class MovieDBServices
{

    public function getMovie()
    {
        //$response = Http::get('https://api.themoviedb.org/3/movie/157336?api_key=79031594e5d8d7625177c75adafd032b');
        //dd($response);

        $response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI3OTAzMTU5NGU1ZDhkNzYyNTE3N2M3NWFkYWZkMDMyYiIsInN1YiI6IjY2NDlkZmUwNDZmNzA3ZWU5ZjhlY2I2OSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.SK4eOm62OL-n3J2sEUNh0GoSSJd4KKmWpd5sA349RNc')
            ->get('https://api.themoviedb.org/3/movie/popular?api_key=79031594e5d8d7625177c75adafd032b')
            ->json();
        return $response;


    }

}
