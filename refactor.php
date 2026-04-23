<?php
$dir = new RecursiveDirectoryIterator('app/Http/Controllers');
$iterator = new RecursiveIteratorIterator($dir);

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getRealPath());
        $original = $content;

        // Replace function arguments
        $content = preg_replace('/function\s+([a-zA-Z0-9_]+)\s*\(\s*int\s+\$id\s*\)/', 'function $1(string $id)', $content);
        $content = preg_replace('/function\s+([a-zA-Z0-9_]+)\s*\(\s*Request\s+\$request\s*,\s*int\s+\$id\s*\)/', 'function $1(Request $request, string $id)', $content);

        // Replace Model::findOrFail($id)
        $content = preg_replace('/([A-Z][a-zA-Z0-9_]*)::findOrFail\(\$id\)/', '$1::where(\'uuid\', $id)->firstOrFail()', $content);

        // Replace Model::with(...)->findOrFail($id)
        $content = preg_replace('/([A-Z][a-zA-Z0-9_]*)::with\(([^)]+)\)->findOrFail\(\$id\)/', '$1::with($2)->where(\'uuid\', $id)->firstOrFail()', $content);

        if ($content !== $original) {
            file_put_contents($file->getRealPath(), $content);
            echo "Updated: " . $file->getRealPath() . PHP_EOL;
        }
    }
}
