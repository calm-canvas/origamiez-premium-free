<?php
$dir = __DIR__ . '/origamiez';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($it as $file) {
    if ($file->getExtension() === 'php') {
        $path = $file->getRealPath();
        if (strpos($path, '/vendor/') !== false) continue;
        
        $content = file_get_contents($path);
        
        // If it has our new header but no blank line after it
        if (preg_match('/<\?php\n\/\*\*\n \* .*\n \*\n \* @package Origamiez\n \*\/\n(?![\n])/', $content)) {
             $newContent = preg_replace('/(\*\/)\n/', "$1\n\n", $content, 1);
             file_put_contents($path, $newContent);
             echo "Added blank line for $path\n";
        }
    }
}
