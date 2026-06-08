<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header class="flex m-8">
        <h1 class="text-4xl montserrat-500">
            <span class="text-slate-400 text-2xl">Welcome to</span>
            <br/>
            <span class="text-slate-800 text-6xl">Dap's</span>
            <br />
            <span class="text-slate-800 text-3xl">PrakPemweb Server</span>
        </h1>
    </header>

    <main>
        <section class="flex justify-center m-8">
            <img class="object-cover rounded-[32px]" src="assets/img/michael.png" alt="michael">
        </section>

        <section class="flex flex-wrap justify-around m-8 w-100vw bg-yellow-400 text-yellow-800 py-1 px-8 rounded-full">

            <?php for ($i=1; $i <= 5; $i++) { ?>
                <a class="hover:bg-yellow-600 hover:text-yellow-200 duration-200 p-3 rounded-full px-12" href="/tugas<?= $i ?>/index.html" target="_blank" rel="noopener noreferrer">Tugas <?= $i ?></a>    
            <?php } ?>
            <a class="hover:bg-yellow-600 hover:text-yellow-200 duration-200 p-3 rounded-full px-12" href="/tugas6/index.php" target="_blank" rel="noopener noreferrer">Tugas 6</a>
        </section>

    </main>

    <footer class="flex justify-center items-center">
        <a class="hover:bg-slate-300 hover:text-slate-800 duration-200 p-3 rounded-full px-12" href="https://madebydap.com" target="_blank" rel="noopener noreferrer">madebydap.com</a>
    </footer>
    
</body>

</html>