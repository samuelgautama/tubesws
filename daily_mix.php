<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GigsPedia</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex min-h-screen relative">


    <?php include 'sidebar.php'; ?>


    <div class="mt-12">
        <h class="text-5xl font-bold flex justify-center mb-12 text-zinc-50">Daily Mix For You</h>
        <div class="grid gap-14 grid-cols-4 grid-rows-2 ml-6">

            <form method="POST" action="playlist.php" class="relative group">
                <input type="hidden" name="genre" value="Metalcore">

                <!-- Card Container -->
                <div class="relative overflow-hidden bg-gray-900 bg-opacity-40 rounded-lg shadow-2xl w-64 h-64 transition-all duration-500 hover:scale-110">

                    <!-- Image -->
                    <img src="/media/metalcore1.jpg" alt="Album Cover" class="w-full h-full object-cover rounded-lg">

                    <!-- Playback Button -->
                    <div class='absolute bottom-4 right-4 transform translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-[1500ms]'>
                        <div
                            class='flex items-center justify-center w-12 h-12 rounded-full border border-black transition-all'
                            style='background-color: #3CAEA3;'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-white' viewBox='0 0 24 24' fill='currentColor'>
                                <path d='M4 3v18l17-9L4 3z' />
                            </svg>
                        </div>
                    </div>
                </div>
            </form>

            <form method="POST" action="playlist.php" class="relative group">
                <input type="hidden" name="genre" value="Alternative Rock">
                <button type="submit" class="relative overflow-hidden bg-gray-900 bg-opacity-40 w-64 h-64 mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md">
                    <figure>
                        <img class="min-w-32 min-h-48" src="/media/rock1.jpg" />
                    </figure>

                    <!-- Playback Button -->
                    <div class='absolute bottom-4 right-4 transform translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-[1500ms]'>
                        <div class='flex items-center justify-center w-12 h-12 rounded-full border border-black transition-all' style='background-color: #3CAEA3;'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-white' viewBox='0 0 24 24' fill='currentColor'>
                                <path d='M4 3v18l17-9L4 3z' />
                            </svg>
                        </div>
                    </div>
                </button>
            </form>

            <form method="POST" action="playlist.php" class="relative group">
                <input type="hidden" name="genre" value="Modern Hardcore">
                <button type="submit" class="relative overflow-hidden bg-gray-900 bg-opacity-40 w-64 h-64 mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md">
                    <figure>
                        <img class="min-w-32 min-h-48" src="/media/hardcore1.jpg" />
                    </figure>

                    <!-- Playback Button -->
                    <div class='absolute bottom-4 right-4 transform translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-[1500ms]'>
                        <div class='flex items-center justify-center w-12 h-12 rounded-full border border-black transition-all' style='background-color: #3CAEA3;'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-white' viewBox='0 0 24 24' fill='currentColor'>
                                <path d='M4 3v18l17-9L4 3z' />
                            </svg>
                        </div>
                    </div>
                </button>
            </form>

            <form method="POST" action="playlist.php" class="relative group">
                <input type="hidden" name="genre" value="Thrash Metal">
                <button type="submit" class="relative overflow-hidden bg-gray-900 bg-opacity-40 w-64 h-64 mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md">
                    <figure>
                        <img class="min-w-32 min-h-48" src="/media/thrashmetal1.jpg" />
                    </figure>

                    <!-- Playback Button -->
                    <div class='absolute bottom-4 right-4 transform translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-[1500ms]'>
                        <div class='flex items-center justify-center w-12 h-12 rounded-full border border-black transition-all' style='background-color: #3CAEA3;'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-white' viewBox='0 0 24 24' fill='currentColor'>
                                <path d='M4 3v18l17-9L4 3z' />
                            </svg>
                        </div>
                    </div>
                </button>
            </form>

            <form method="POST" action="playlist.php" class="relative group">
                <input type="hidden" name="genre" value="Metalcore">
                <button type="submit" class="relative overflow-hidden bg-gray-900 bg-opacity-40 w-64 h-64 mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md">
                    <figure>
                        <img class="min-w-32 min-h-48" src="/media/metalcore2.jpg" />
                    </figure>

                    <!-- Playback Button -->
                    <div class='absolute bottom-4 right-4 transform translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-[1500ms]'>
                        <div class='flex items-center justify-center w-12 h-12 rounded-full border border-black transition-all' style='background-color: #3CAEA3;'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-white' viewBox='0 0 24 24' fill='currentColor'>
                                <path d='M4 3v18l17-9L4 3z' />
                            </svg>
                        </div>
                    </div>
                </button>
            </form>

            <form method="POST" action="playlist.php" class="relative group">
                <input type="hidden" name="genre" value="Alternative Rock">
                <button type="submit" class="relative overflow-hidden bg-gray-900 bg-opacity-40 w-64 h-64 mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md">
                    <figure>
                        <img class="min-w-32 min-h-48" src="/media/rock2.jpg" />
                    </figure>

                    <!-- Playback Button -->
                    <div class='absolute bottom-4 right-4 transform translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-[1500ms]'>
                        <div class='flex items-center justify-center w-12 h-12 rounded-full border border-black transition-all' style='background-color: #3CAEA3;'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-white' viewBox='0 0 24 24' fill='currentColor'>
                                <path d='M4 3v18l17-9L4 3z' />
                            </svg>
                        </div>
                    </div>
                </button>
            </form>

            <form method="POST" action="playlist.php" class="relative group">
                <input type="hidden" name="genre" value="Modern Hardcore">
                <button type="submit" class="relative overflow-hidden bg-gray-900 bg-opacity-40 w-64 h-64 mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md">
                    <figure>
                        <img class="min-w-32 min-h-48" src="/media/hardcore2.jpg" />
                    </figure>

                    <!-- Playback Button -->
                    <div class='absolute bottom-4 right-4 transform translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-[1500ms]'>
                        <div class='flex items-center justify-center w-12 h-12 rounded-full border border-black transition-all' style='background-color: #3CAEA3;'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-white' viewBox='0 0 24 24' fill='currentColor'>
                                <path d='M4 3v18l17-9L4 3z' />
                            </svg>
                        </div>
                    </div>
                </button>
            </form>

            <form method="POST" action="playlist.php" class="relative group">
                <input type="hidden" name="genre" value="Thrash Metal">
                <button type="submit" class="relative overflow-hidden bg-gray-900 bg-opacity-40 w-64 h-64 mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md">
                    <figure>
                        <img class="min-w-32 min-h-48" src="/media/thrashmetal2.jpg" />
                    </figure>

                    <!-- Playback Button -->
                    <div class='absolute bottom-4 right-4 transform translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-[1500ms]'>
                        <div class='flex items-center justify-center w-12 h-12 rounded-full border border-black transition-all' style='background-color: #3CAEA3;'>
                            <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-white' viewBox='0 0 24 24' fill='currentColor'>
                                <path d='M4 3v18l17-9L4 3z' />
                            </svg>
                        </div>
                    </div>
                </button>
            </form>

        </div>
    </div>
</body>

</html>