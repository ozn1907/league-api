<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>League Api</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css'])
</head>

<body class="antialiased">
    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
            <a href="{{ url('/dashboard') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
            @else
            <a href="{{ route('login') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                in</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <img src="{{ asset('/svg/logo.svg') }}" alt="League API Logo" class="h-14 w-14">
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <div
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div
                                class="h-16 w-16 bg-gray-100 dark:bg-gray-400/20 flex items-center justify-center rounded-full">
                                <x-entypo-rocket class="w-7 h-7" />
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Why I Created This
                                Project:</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                League of Legends has been more than just a game for me; it's a passion that I enjoy
                                exploring even beyond the rift.
                                As part of my journey in mastering Laravel, I embarked on the creation of this project.
                            </p>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                League of Legends Laravel Project serves as a testament to my dedication to both the
                                gaming realm and the world of web development.
                            </p>
                        </div>
                    </div>

                    <div
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div
                                class="h-16 w-16 bg-gray-100 dark:bg-gray-400/20 flex items-center justify-center rounded-full">
                                <x-fas-code class="w-9 h-9" />
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">A Playground for
                                Laravel Mastery:</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                This project is not just about summoning champions; it's about summoning the power of
                                Laravel to create a robust and engaging experience for fellow gamers.
                            </p>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                By weaving together the Riot API and the Data Dragon Riot API, I've crafted a web
                                application that dives into the intricate details of Summoner profiles, explores the
                                current free champion rotation, provides a handy search functionality, and even includes
                                a favorite section for those memorable Summoners. </p>
                        </div>
                    </div>

                    <div
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div
                                class="h-16 w-16 bg-gray-100 dark:bg-gray-400/20 flex items-center justify-center rounded-full">
                                <x-heroicon-s-globe-asia-australia class="w-9 h-9" />
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Connecting Passion with
                                Technology:</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                League of Legends Laravel Project is not just about lines of code; it's a bridge that
                                connects my passion for gaming with the artistry of web development.
                                With this project, I hope to provide a valuable resource for fellow Summoners while
                                showcasing the capabilities of Laravel in building dynamic and feature-rich
                                applications.
                            </p>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Explore, enjoy, and may your elo rise both on the battlefield and in the world of web
                                development!
                            </p>
                        </div>
                    </div>

                    <div
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div
                                class="h-16 w-16 bg-gray-100 dark:bg-gray-400/20 flex items-center justify-center rounded-full">
                                <x-pepicon-chain class="w-9 h-9" />
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Get Started:</h2>

                            <ul class="pl-4 mt-4 text-gray-700 dark:text-gray-300 text-base leading-relaxed list-disc">
                                <li class="text-gray-500 text-sm">Clone the repository</li>
                                <li class="text-gray-500 text-sm">Configure your Riot API key and region</li>
                                <li class="text-gray-500 text-sm">Dive into the Summoner details, champion rotations, and more!
                                </li>
                            </ul>

                            <p class="mt-4 pb-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Thank you for joining me on this exciting journey. May your code be bug-free, and your
                                Nexus always secure!
                            </p>
                            <p
                                class="mt-4 text-blue-900 dark:text-gray-400 text-sm leading-relaxed duration-300 hover:text-sky-950">
                                <a href="https://github.com/ozn1907/league-api" target="blank">View Project on
                                    GitHub</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>