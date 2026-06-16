<?php
// Meload file autoloader class
require_once __DIR__ . '/autoload.php';

// Menginisialisasi token CSRF untuk keamanan form
$csrf_token = SessionManager::generateCsrfToken();

// File koneksi database, penanganan request, dan pemrosesan thread
require_once 'db.php';
require_once 'actions.php';
require_once 'threads.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YTTA - Anonymous Threads</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;900&family=Libre+Baskerville:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo filemtime('style.css'); ?>">
    <script src="script.js?v=<?php echo filemtime('script.js'); ?>" defer></script>
</head>
<body class="bg-[#390014] text-white min-h-screen">
    <div class="max-w-4xl mx-auto my-8 px-4">
        <!-- Header -->
        <header class="p-6 mb-8 text-center">
            <h1 class="text-6xl text-white uppercase">
                <span>YTTA</span>
                <span class="font-black">THRE<span class="italic">AD</span>S</span>
            </h1>
            <p class="text-white text-sm mt-1">
                Made by <a href="https://madebydap.com" target="_blank" class="underline">dap</a>
            </p>
        </header>

        <!-- Message Alerts -->
        <?php if ($error_message !== ''): ?>
            <div class="bg-[#AB1B4C] text-white p-4 mb-6 text-sm">
                <strong class="font-black">Error:</strong> <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <!-- Create Thread Form -->
        <section class="mb-8">
            <h2 class="text-2xl mb-4 text-white pb-2">
                Post a <span class="font-black">THRE<span class="italic">A</span>D</span>
            </h2>
            <form method="POST" action="" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input type="hidden" name="action" value="create">
                <input type="hidden" name="parent_id" value="">
                
                <div>
                    <label class="block text-sm mb-1 text-white">Namamu (opsional)</label>
                    <input type="text" name="author_name" placeholder="Anonymous" class="w-full p-3 bg-white text-[#AB1B4C] outline-none text-sm">
                </div>
                
                <div>
                    <label class="block text-sm mb-1 text-white">Mau ngomong apa?</label>
                    <textarea name="content" required rows="4" placeholder="What's on your mind?..." class="w-full p-3 bg-white text-[#AB1B4C] outline-none text-sm"></textarea>
                </div>
                
                <button type="submit" class="bg-[#AB1B4C] text-white py-3 px-6 text-sm cursor-pointer w-full sm:w-auto">
                    Publish this <span class="font-black">THRE<span class="italic">A</span>D</span>
                </button>
            </form>
        </section>

        <!-- Threads Feed -->
        <main class="space-y-6">
            <h2 class="text-2xl text-white pb-2 mb-4">
                <span class="font-black">THRE<span class="italic">A</span>D</span> Feeds
            </h2>
            <?php if (empty($root_threads)): ?>
                <div class="bg-[#1B1B1B] p-6 text-center text-slate-300 font-mono">
                    No threads posted yet. Be the first to start a conversation!
                </div>
            <?php else: ?>
                <?php
                $renderer = new ThreadRenderer($csrf_token, $threads_by_parent);
                foreach ($root_threads as $thread) {
                    $renderer->render($thread);
                }
                ?>
            <?php endif; ?>
        </main>
    </div>

</body>
</html>
