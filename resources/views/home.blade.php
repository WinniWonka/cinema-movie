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
    <div class="w-full h-auto min-h-screen flex flex-col">
        {{-- header --}}
        @include('header')

        {{-- banner --}}
        <div class="w-full h-[512px] flex flex-col relative bg-black">

            {{-- banner data --}}
            @foreach ($banner as $item)

            @php
            $bannerImg = "{$image_url}/original{$item->backdrop_path}";
            @endphp
            <div class="flex flex-row items-center w-full h-full relative slide">
                {{-- image --}}
                <img src="{{$bannerImg}}" class="absolute w-full h-full object-cover" />
                {{-- overlay --}}
                <div class="w-full h-full absolute bg-black bg-opacity-40"></div>

                <div class="w-10/12 flex flex-col ml-28 z-10">
                    <span class="font-bold font-inter text-4xl text-white">{{ $item->title }}</span>
                    <span class="font-inter text-xl text-white w-1/2 line-clamp-2">{{ $item->overview }}</span>
                    <a href="/movie/{{$item->id}}"
                        class="w-fit bg-customColors-500 text-white pl-2 pr-4 py-2 mt-5 font-inter text-sm flex flex-row rounded-full items-center hover:drop-shadow-lg duration-200">
                        <svg style="color: white" xmlns="https://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                            <path
                                d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"
                                fill="white"></path>
                        </svg>
                        <span>Detail</span>
                    </a>
                </div>
            </div>
            @endforeach

            {{-- prev btn --}}
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1/12 flex justify-center" onclick="moveSlide(-1)">
                <button class="bg-white p-3 rounded-full opacity-20 hover:opacity-100 duration-200">
                    <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-chevron-compact-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M9.224 1.553a.5.5 0 0 1 .223.67L6.56 8l2.888 5.776a.5.5 0 1 1-.894.448l-3-6a.5.5 0 0 1 0-.448l3-6a.5.5 0 0 1 .67-.223z" />
                    </svg>
                </button>
            </div>

            {{-- next btn --}}
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1/12 flex justify-center" onclick="moveSlide(1)">
                <button class="bg-white p-3 rounded-full opacity-20 hover:opacity-100 duration-200">
                    <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-chevron-compact-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z" />
                    </svg>
                </button>
            </div>

            {{-- indicator --}}
            {{-- reason why the indent is broken -- need to be fixed!!! --}}
            <div class="absolute bottom-0 w-full mb-8">
                <div class="w-full flex flex-row items-center justify-center">
                    @for ($i = 1; $i <= count($banner); $i++) <div
                        class="w-2.5 h-2.5 rounded-full mx-1 cursor-pointer dot" onclick="currentSlide({{$i}})">
                </div>
                @endfor
            </div>
        </div>
    </div>

    {{-- Top 10 Movies --}}
    <div class="mt-12">
        <span class="ml-28 font-inter font-bold  text-x">Top 10 Movies</span>

        <div class="w-auto flex flex-row overflow-x-auto pl-28 pt-6 pb-10">

            @foreach ($top_movies as $item)

            @php
            $oriDt = $item->release_date;
            $timeStamp = strtotime($oriDt);
            $movieYear = date("Y", $timeStamp);

            $movieId = $item->id;
            $movieTitle = $item->title;
            $movieRate = round((float)$item->vote_average*10);
            $movieImg = "{$image_url}/w500{$item->poster_path}";
            @endphp
            <a href="movie/{{$movieId}}" class="group">
                <div
                    class="min-w-[232px] min-h-[482px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">
                    <div class="overflow-hidden rounded-[32px]">
                        <img class="w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200"
                            src="{{$movieImg}}" />
                    </div>
                    <span
                        class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none">{{$movieTitle}}</span>
                    <span class="font-inter text-sm mt-1">{{$movieYear}}</span>
                    <div class="flex flex-row mt-1 items-center">
                        <svg style="color: rgb(224, 212, 133);" xmlns="https://www.w3.org/2000/svg" width="16"
                            height="16" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                            <path
                                d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"
                                fill="#e0d485"></path>
                        </svg>
                        <span class="font-inter text-sm ml-1">{{$movieRate}}%</span>
                    </div>
                </div>
            </a>
            @endforeach

        </div>
    </div>

    {{-- Top 10 Tv Shows --}}
    <div>
        <span class="ml-28 font-inter font-bold  text-x">Top 10 Tv Shows</span>
        <div class="w-auto flex flex-row overflow-x-auto pl-28 pt-6 pb-10">
            @foreach ($top_tv_shows as $item)

            @php
            $oriDt = $item->first_air_date;
            $timeStamp = strtotime($oriDt);
            $TvShowYear = date("Y", $timeStamp);

            $TvShowId = $item->id;
            $TvShowTitle = $item->name;
            $TvShowRate = round((float)$item->vote_average*10);
            $TvShowImg = "{$image_url}/w500{$item->poster_path}";
            @endphp
            <a href="tv/{{$TvShowId}}" class="group">
                <div
                    class="min-w-[232px] min-h-[482px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">
                    <div class="overflow-hidden rounded-[32px]">
                        <img class="w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200"
                            src="{{$TvShowImg }}" />
                    </div>
                    <span
                        class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none">{{$TvShowTitle}}</span>
                    <span class="font-inter text-sm mt-1">{{$TvShowYear}}</span>
                    <div class="flex flex-row mt-1 items-center">
                        <svg style="color: rgb(224, 212, 133);" xmlns="https://www.w3.org/2000/svg" width="16"
                            height="16" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                            <path
                                d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"
                                fill="#e0d485"></path>
                        </svg>
                        <span class="font-inter text-sm ml-1">{{$TvShowRate}}%</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    {{-- footer --}}
    @include('footer')

    </div>

    <script>
        //default index
        let slideIndex = 1;

        showSlide(slideIndex);

        function showSlide(pos){
            let index;
            const slidesArr = document.getElementsByClassName("slide");
            const dotsArr = document.getElementsByClassName("dot");

            if(pos > slidesArr.length){
                slideIndex = 1;
            }

            if(pos < 1){
                slideIndex = slidesArr.length;
            }

            //hide all slides
            for(index = 0; index<slidesArr.length; index++){
                slidesArr[index].classList.add('hidden');
            }

            //show active slide
            slidesArr[slideIndex-1].classList.remove('hidden');

            //remove active status
            for(index = 0; index<dotsArr.length; index++){
                dotsArr[index].classList.remove('bg-customColors-500');
                dotsArr[index].classList.add('bg-white');
            }

            //set active status
            dotsArr[slideIndex-1].classList.remove('bg-white');
            dotsArr[slideIndex-1].classList.add('bg-customColors-500');
        }

        function moveSlide(moveStep){
            showSlide(slideIndex += moveStep);
        }

        function currentSlide(pos){
            showSlide(slideIndex = pos);
        }
    </script>
</body>

</html>