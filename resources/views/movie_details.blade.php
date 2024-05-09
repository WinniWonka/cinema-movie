<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Andreas Lie">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Cinema</title>
    <link rel="icon" href="favicon.ico">
    <link rel="apple-touch-icon" href="favicon.ico">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    @vite('resources/css/app.css')
</head>

<body>
    <div class="w-full h-screen flex flex-col relative">
        @php
        $backdropPath = "";
        $title = "";
        $tagline = "";
        $year = "";
        $duration = "" ;
        $rating = 0;

        if($movie_data){
        $backdropPath = "{$image_url}/original{$movie_data->backdrop_path}";
        $oriDt = $movie_data->release_date;
        $timeStamp = strtotime($oriDt);
        $movieYear = date("Y", $timeStamp);
        $rating = round((float)($movie_data->vote_average*10));
        $title = $movie_data->title;

        if($movie_data->tagline){
        $tagline = $movie_data->tagline;
        }
        else{
        $tagline = $movie_data->overview;
        }

        if($movie_data->runtime){
        $hour = (int)($movie_data->runtime/60);
        $minute = ($movie_data->runtime%60);
        $duration = "{$hour}h {$minute}m";
        }
        }
        //32 pixel (2 * pi * r)
        $circumference = 2 * 22/7 * 32;
        $progressRating = $circumference - ($rating/100) * $circumference;
        $trailerId = "";

        if(isset($movie_data->videos->results)){
        foreach ($movie_data->videos->results as $item) {
        if(strtolower($item->type) == 'trailer'){
        $trailerId = $item->key;
        break;
        }
        }
        }

        @endphp

        {{-- bg-image --}}
        <img src="{{$backdropPath}}" alt="" class="w-full h-screen absolute object-cover lg:object-fill" />
        <div class="w-full h-screen absolute bg-black bg-opacity-60 z-10"></div>

        {{-- Menu Section Header --}}
        <div class="w-full bg-transparent h-[96px] drop-shadow-lg flex flex-row items-center z-10">
            <div class="w-1/3 pl-5">
                <a href="/movies"
                    class="uppercase text-base mx-5 text-white hover:text-customColors-500 duration-200 font-inter">Movies</a>
                <a href="/tv-shows"
                    class="uppercase text-base mx-5 text-white hover:text-customColors-500 duration-200 font-inter">TV
                    Shows</a>
            </div>

            <div class="w-1/3 flex items-center justify-center">
                <a href="/"
                    class="font-bold text-5xl font-quicksand text-white hover:text-customColors-500 duration-200">CINEMA</a>
            </div>

            <div class="w-1/3 flex flex-row justify-end pr-10">
                <a href="/search" class="group">
                    <svg style="color: rgb(24, 24, 22);" xmlns="https://www.w3.org/2000/svg" width="32" height="32"
                        fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"
                            class="fill-white group-hover:fill-customColors-500 duration-200"></path>
                    </svg>
                </a>
            </div>
        </div>

        {{-- cotent --}}
        <div class="w-full h-full z-10 flex flex-col justify-center px-20">
            <span class="font-quicksand font-bold text-6xl mt-4 text-white">{{$title}}</span>
            <span class="font-inter italic text-2xl mt-4 text-white max-w-3xl line-clamp-5">{{$tagline}}</span>

            <div class="flex flex-row mt-4 items-center">
                {{-- rating --}}
                <div class="w-20 h-20 rounded-full flex items-center justify-center mr-4" style="background: #00304D;">
                    <svg class="-rotate-90 w-20 h-20">
                        <circle style="color: #004F80;" stroke-width="8" stroke="currentColor" fill="transparent" r="32"
                            cx="40" cy="40" />
                        <circle style="color: #6FCF87;" stroke-width="8" stroke-dasharray="{{$circumference}}"
                            stroke-dashoffset="{{$progressRating}}" stroke-linecap="round" stroke="currentColor"
                            fill="transparent" r="32" cx="40" cy="40" />
                    </svg>
                    <span class="absolute font-inter font-bold text-xl text-white">{{$rating}}%</span>
                </div>

                {{-- movie year --}}
                <span
                    class="font-inter text-xl text-white bg-transparent rounded-md border border-white p-2 mr-4">{{$movieYear}}</span>

                {{-- movie duration --}}
                @if ($duration)
                <span
                    class="font-inter text-xl text-white bg-transparent rounded-md border border-white p-2">{{$duration}}</span>
                @endif
            </div>

            {{-- play trailer --}}
            @if ($trailerId)
            <button
                class="w-fit bg-customColors-500 text-white pl-4 pr-6 py-3 mt-5 font-inter text-xl flex flex-row rounded-lg items-center hover:drop-shadow-lg duration-200"
                onclick="showTrailer(true)">
                <svg style="color: white" xmlns="https://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-play-fill" viewBox="0 0 16 16">
                    <path
                        d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"
                        fill="white"></path>
                </svg>
                <span>Play Trailer</span>
            </button>
            @endif
        </div>

        {{-- trailer section --}}
        <div class="absolute z-10 w-full h-screen p-20 bg-black flex flex-col" id="trailerWrapper">
            <button class="ml-auto group mb-4" onclick="showTrailer(false)">
                <svg xmlns="https://www.w3.org/2000/svg" height="48" width="48">
                    <path
                        d="m12.45 37.65-2.1-2.1L21.9 24 10.35 12.45l2.1-2.1L24 21.9l11.55-11.55 2.1 2.1L26.1 24l11.55 11.55-2.1 2.1L24 26.1Z"
                        class="fill-white group-hover:fill-customColors-500 duration-200" />
                </svg>
            </button>

            <iframe id="youtubeVideo" class="w-full h-full"
                src="https://www.youtube.com/embed/{{$trailerId}}?enablejsapi=1" title="{{$title}}" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        // Hide trailer
        $("#trailerWrapper").hide();
  
        function showTrailer(isVisible){
          if (isVisible){
            // Show trailer
            $("#trailerWrapper").show();
          } 
          else {
            // Stop youtube video
            $('#youtubeVideo')[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
  
            // Hide trailer
            $("#trailerWrapper").hide();
          }
        }
    </script>
</body>

</html>