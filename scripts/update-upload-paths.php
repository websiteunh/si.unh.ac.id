<?php
/**
 * Script to update all old upload paths to new paths
 * Run this once to migrate from old paths to new paths
 * 
 * Usage: php scripts/update-upload-paths.php
 */

$basePath = dirname(__DIR__);
$applicationPath = $basePath . '/application';

// Path mappings
$pathMappings = [
    'assets/art1kel/' => 'assets/uploads/artikel/',
    'assets/im493/' => 'assets/uploads/images/',
    'assets/dokum3nt/' => 'assets/uploads/dokumen/',
    './assets/art1kel/' => './assets/uploads/artikel/',
    './assets/im493/' => './assets/uploads/images/',
    './assets/dokum3nt/' => './assets/uploads/dokumen/',
    "'assets/art1kel/" => "'assets/uploads/artikel/",
    "'assets/im493/" => "'assets/uploads/images/",
    "'assets/dokum3nt/" => "'assets/uploads/dokumen/",
    '"assets/art1kel/' => '"assets/uploads/artikel/',
    '"assets/im493/' => '"assets/uploads/images/',
    '"assets/dokum3nt/' => '"assets/uploads/dokumen/',
];

// Find all PHP files
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($applicationPath),
    RecursiveIteratorIterator::SELF_FIRST
);

$filesUpdated = 0;
$totalReplacements = 0;

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $originalContent = $content;
        $fileReplacements = 0;
        
        foreach ($pathMappings as $oldPath => $newPath) {
            $count = substr_count($content, $oldPath);
            if ($count > 0) {
                $content = str_replace($oldPath, $newPath, $content);
                $fileReplacements += $count;
            }
        }
        
        if ($content !== $originalContent) {
            file_put_contents($file->getPathname(), $content);
            $filesUpdated++;
            $totalReplacements += $fileReplacements;
            echo "Updated: " . str_replace($basePath . '/', '', $file->getPathname()) . " ($fileReplacements replacements)\n";
        }
    }
}

echo "\nMigration complete!\n";
echo "Files updated: $filesUpdated\n";
echo "Total replacements: $totalReplacements\n";

