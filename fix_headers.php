<?php
$dir = __DIR__ . '/origamiez';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($it as $file) {
    if ($file->getExtension() === 'php') {
        $path = $file->getRealPath();
        if (strpos($path, '/vendor/') !== false) continue;
        
        $content = file_get_contents($path);
        
        // Check if it already has a doc comment with @package
        if (preg_match('/\/\*\*.*@package/s', $content)) {
            continue;
        }
        
        $fileName = basename($path);
        $humanName = ucwords(str_replace(['-', '_', '.php'], [' ', ' ', ''], $fileName));
        
        if (strpos($content, '<?php') === 0) {
            // File starts with PHP
            $newHeader = "<?php\n/**\n * " . $humanName . "\n *\n * @package Origamiez\n */\n";
            $newContent = preg_replace('/<\?php\s*/', $newHeader . "\n", $content, 1);
        } else {
            // File starts with HTML or something else
            $header = "<?php\n/**\n * " . $humanName . "\n *\n * @package Origamiez\n */\n?>\n";
            $newContent = $header . $content;
        }
        file_put_contents($path, $newContent);
        echo "Fixed header for $path\n";
    }
}
