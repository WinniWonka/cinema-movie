<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Andreas Lie">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

        {{-- sort --}}
        <div class="ml-28 mt-8 flex flex-row items-center">
            <span class="font-inter font-bold text-xl">Sort</span>

            <div class="relative ml-4">
                <select
                    class="block appearance-none bg-white drop-shadow-[0_0px_4px_rgba(0,0,0,0.25)] text-black font-inter py-3 pl-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white"
                    onchange="changeSort(this)">
                    <option value="popularity.desc">Popularity (Descending)</option>
                    <option value="popularity.asc">Popularity (Ascending)</option>
                    <option value="vote_average.desc">Top Rated (Descending)</option>
                    <option value="vote_average.asc">Top Rated (Ascending)</option>
                </select>

                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-caret-down" viewBox="0 0 16 16">
                        <path
                            d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- content section --}}
        <div class="w-auto pl-28 pr-10 pt-6 pb-10 grid grid-cols-3 lg:grid-cols-5 gap-5" id="dataWrapper">
            @foreach ($movies as $item)
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

        {{-- data loader --}}
        <div class="w-full pl-28 pr-10 flex justify-center mb-5" id="autoLoad">
            <svg width="100" height="100" xmlns="https://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="40" fill="none" stroke="black" stroke-width="7">
                    <animate attributeName="r" from="40" to="20" dur="0.5s" begin="0s" repeatCount="indefinite" />
                    <animate attributeName="stroke-dasharray" values="0 251.2; 187 64.2; 187 64.2" dur="0.5s" begin="0s"
                        repeatCount="indefinite" />
                    <animate attributeName="stroke-dashoffset" values="0 -161.8; 187 -161.8; 187 -161.8" dur="0.5s"
                        begin="0s" repeatCount="indefinite" />
                </circle>
            </svg>
        </div>

        {{-- err notification --}}
        <div class="min-w-[250px] p-4 bg-red-700 text-white text-center rounded-lg fixed z-index-10 top-0 right-0 mr-10 mt-5 drop-shadow-lg"
            id="notification">
            <span id="notificationMessage"></span>
        </div>

        {{-- load more --}}
        <div class="w-full pl-28 pr-10" id="loadMore">
            <button
                class="w-full mb-10 bg-customColors-500 text-white p-4 font-inter font-bold rounded-xl uppercase drop-shadow-lg"
                onclick="loadMore()">Load More ...</button>
        </div>

        {{-- footer --}}
        @include('footer')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        let baseUrl = "<?php echo $base_url; ?>";
        let imgBaseUrl = "<?php echo $image_url; ?>";
        let apiKey = "<?php echo $api_key; ?>";
        let sortBy = "<?php echo $sort_by; ?>";
        let page = "<?php echo $page; ?>";
        let minimal_voter = "<?php echo $minimal_voter; ?>";

        //hide loader
        $("#autoLoad").hide();

        //hide notif
        $("#notification").hide();

        function loadMore(){
            $.ajax({
                url:`${baseUrl}/discover/movie?page=${++page}&sort_by=${sortBy}&api_key=${apiKey}&vote_count.gte=${minimal_voter}`,
                type:"get",
                beforeSend: function(){
                    //show loader
                    $("#autoLoad").show();
                }
            })
            .done(function (response){
                //hide loader
                $("#autoLoad").hide();

                //get data
                if(response.results){
                    var htmlData = [];
                    response.results.forEach(item => {
                        let oriDt = item.release_date;
                        let timeStamp = new Date(oriDt);
                        let movieYear = timeStamp.getFullYear();

                        let movieId = item.id;
                        let movieTitle = item.title;
                        let movieRate = Math.round(item.vote_average*10);
                        let movieImg = `${imgBaseUrl}/w500${item.poster_path}`; 

                        htmlData.push(`
                        <a href="movie/${movieId}" class="group">
                            <div
                                class="min-w-[232px] min-h-[482px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">
                                <div class="overflow-hidden rounded-[32px]">
                                    <img class="w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200"
                                        src="${movieImg}" />
                                </div>
                                <span
                                    class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none">${movieTitle}</span>
                                <span class="font-inter text-sm mt-1">${movieYear}</span>
                                <div class="flex flex-row mt-1 items-center">
                                    <svg style="color: rgb(224, 212, 133);" xmlns="https://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"
                                            fill="#e0d485"></path>
                                    </svg>
                                    <span class="font-inter text-sm ml-1">${movieRate}%</span>
                                </div>
                            </div>
                        </a>`);
                    });
                    $("#dataWrapper").append(htmlData.join(""));
                }
            })
            .fail(function (jqHXR, ajaxOptions, thrownError){
                //hide loader
                $("#autoLoad").hide();

                //show notif error
                $("#notificationMessage").text("An unexpected error occured, Please try again!");
                $("#notification").show();

                //set timeout notif
                setTimeout(function(){
                    $("#notification").hide();
                }, 3000);
            })
        }

        function changeSort(component){
            if(component.value){
                //set new value
                sortBy = component.value;

                //clear data
                $("#dataWrapper").html("");

                //Reset page value
                page=0;

                //getData
                loadMore();
            }
        }
    </script>
</body>

</html>