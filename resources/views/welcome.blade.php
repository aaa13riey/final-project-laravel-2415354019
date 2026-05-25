<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test UI Tailwind v4</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl text-center max-w-lg w-full border border-gray-200">
        <h1 class="text-4xl font-bold text-primary mb-2">Halo!</h1>
        
        <p class="text-success font-medium text-lg mb-8">
            Vite, Laravel, dan Tailwind CSS v4 berhasil terintegrasi.
        </p>
        
        <div class="flex flex-wrap gap-4 justify-center">
            <button class="bg-info hover:opacity-80 text-white font-semibold py-2 px-6 rounded-lg transition-all">
                Tombol Info
            </button>
            
            <button class="bg-warning hover:opacity-80 text-white font-semibold py-2 px-6 rounded-lg transition-all">
                Tombol Warning
            </button>
            
            <button class="bg-danger hover:opacity-80 text-white font-semibold py-2 px-6 rounded-lg transition-all">
                Tombol Danger
            </button>
        </div>
    </div>

</body>
</html>