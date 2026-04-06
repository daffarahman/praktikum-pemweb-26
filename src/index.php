<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dap's Pemweb</title>
</head>
<body>

<h1>Welcome to Dap's Prak Pemweb Repo</h1>
<hr>
<p>This is basiscally my tugas wkwkwk</p>

<div style="border: 1px solid black;padding: 0.5rem 2rem;">
    <p>Muhammad Daffa Rahman</p>
    <p>NIM L0124062</p>
</div>

<h2>Check it out here:</h2>

<?php
$path = __DIR__;
$items = scandir($path);

echo "<ul>";

foreach ($items as $item) {
    if ($item === '.' || $item === '..') continue;

    if (is_dir($path . DIRECTORY_SEPARATOR . $item)) {
        $url = htmlspecialchars($item) . '/';
        $name = htmlspecialchars(ucwords($item));

        echo "<li><a href=\"$url\">$name</a></li>";
    }
}

echo "</ul>";

?>
    
</body>
</html>