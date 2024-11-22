
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


<?php include 'sidebar.php';?>


    <div class="mt-12">
        <h class="text-5xl font-bold flex justify-center mb-12 text-zinc-50">Daily Mix For You</h>
        <div class="grid gap-14 grid-cols-4 grid-rows-2 ml-6">

                <form method="POST" action="playlist.php">
                <input type="hidden" name='genre' value="Metalcore">
                <button type="submit" class="card backdrop-blur-sm bg-gray-900 bg-opacity-40 w-64 h-64 shadow-2xl mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md hover:shadow-red-700">
                    <figure>
                        <img class="min-w-32 min-h-48" src="/media/metalcore1.jpg"/>
                    </figure>
                </button>
                </form>

                <form method="POST" action="playlist.php">
                    <input type="hidden" name='genre' value="Alternative Rock">
                    <button type="submit" class="card backdrop-blur-sm bg-gray-900 bg-opacity-40 w-64 h-64 shadow-2xl mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md hover:shadow-red-700">
                        <figure>
                            <img class="min-w-32 min-h-48" src="/media/rock1.jpg"/>
                        </figure>
                    </button>
                </form>

                <form method="POST" action="playlist.php">
                    <input type="hidden" name='genre' value="Modern Hardcore">
                    <button type="submit" class="card backdrop-blur-sm bg-gray-900 bg-opacity-40 w-64 h-64 shadow-2xl mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md hover:shadow-red-700">
                        <figure>
                            <img class="min-w-32 min-h-48" src="/media/hardcore1.jpg"/>
                        </figure>
                    </button>
                </form>

                <form method="POST" action="playlist.php">
                    <input type="hidden" name='genre' value="Thrash Metal">
                    <button type="submit" class="card backdrop-blur-sm bg-gray-900 bg-opacity-40 w-64 h-64 shadow-2xl mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md hover:shadow-red-700">
                        <figure>
                            <img class="min-w-32 min-h-48" src="/media/thrashmetal1.jpg"/>
                        </figure>
                    </button>
                </form>

                <form method="POST" action="playlist.php">
                <input type="hidden" name='genre' value="Metalcore">
                <button type="submit" class="card backdrop-blur-sm bg-gray-900 bg-opacity-40 w-64 h-64 shadow-2xl mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md hover:shadow-red-700">
                    <figure>
                        <img class="min-w-32 min-h-48" src="/media/metalcore2.jpg"/>
                    </figure>
                </button>
                </form>

                <form method="POST" action="playlist.php">
                    <input type="hidden" name='genre' value="Alternative Rock">
                    <button type="submit" class="card backdrop-blur-sm bg-gray-900 bg-opacity-40 w-64 h-64 shadow-2xl mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md hover:shadow-red-700">
                        <figure>
                            <img class="min-w-32 min-h-48" src="/media/rock2.jpg"/>
                        </figure>
                    </button>
                </form>

                <form method="POST" action="playlist.php">
                    <input type="hidden" name='genre' value="Modern Hardcore">
                    <button type="submit" class="card backdrop-blur-sm bg-gray-900 bg-opacity-40 w-64 h-64 shadow-2xl mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md hover:shadow-red-700">
                        <figure>
                            <img class="min-w-32 min-h-48" src="/media/hardcore2.jpg"/>
                        </figure>
                    </button>
                </form>

                <form method="POST" action="playlist.php">
                    <input type="hidden" name='genre' value="Thrash Metal">
                    <button type="submit" class="card backdrop-blur-sm bg-gray-900 bg-opacity-40 w-64 h-64 shadow-2xl mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md hover:shadow-red-700">
                        <figure>
                            <img class="min-w-32 min-h-48" src="/media/thrashmetal2.jpg"/>
                        </figure>
                    </button>
                </form>
        </div>
    </div>
</body>
</html>