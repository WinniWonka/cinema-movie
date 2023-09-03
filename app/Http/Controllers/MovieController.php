<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    //
    public function index()
    {
        $baseUrl = env('MOVIE_DB_BASE_URL');
        $imageBaseUrl = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');
        $maxBanner = 3;
        $maxTopMovieItem = 10;

        //hit api banner
        $bannerResponses = Http::get("{$baseUrl}/trending/movie/week", [
            'api_key' => $apiKey,
        ]);

        //Prepare variable
        $bannerArr = [];

        //check response
        if ($bannerResponses->successful()) {
            $resArr = $bannerResponses->object()->results;

            if (isset($resArr)) {
                //loop res data
                foreach ($resArr as $item) {
                    //save response data to var
                    array_push($bannerArr, $item);

                    //max 3 item data to display
                    if (count($bannerArr) == $maxBanner) {
                        break;
                    }
                }
            }
        }

        //hit api top movie
        $topMoviesResponses = Http::get("{$baseUrl}/movie/top_rated", [
            'api_key' => $apiKey,
        ]);

        //Prepare variable
        $topMoviesArr = [];

        //check response
        if ($topMoviesResponses->successful()) {
            $resArr = $topMoviesResponses->object()->results;

            if (isset($resArr)) {
                //loop res data
                foreach ($resArr as $item) {
                    //save response data to var
                    array_push($topMoviesArr, $item);

                    //max 10 item data to display
                    if (count($topMoviesArr) == $maxTopMovieItem) {
                        break;
                    }
                }
            }
        }

        //hit api top tv shows
        $topTvShowsResponses = Http::get("{$baseUrl}/tv/top_rated", [
            'api_key' => $apiKey,
        ]);

        //Prepare variable
        $topTvShowsArr = [];

        //check response
        if ($topTvShowsResponses->successful()) {
            $resArr = $topTvShowsResponses->object()->results;

            if (isset($resArr)) {
                //loop res data
                foreach ($resArr as $item) {
                    //save response data to var
                    array_push($topTvShowsArr, $item);

                    //max 10 item data to display
                    if (count($topTvShowsArr) == $maxTopMovieItem) {
                        break;
                    }
                }
            }
        }

        return view('home', [
            'base_url' => $baseUrl,
            'image_url' => $imageBaseUrl,
            'api_key' => $apiKey,
            'banner' => $bannerArr,
            'top_movies' => $topMoviesArr,
            'top_tv_shows' => $topTvShowsArr,
        ]);
    }
}