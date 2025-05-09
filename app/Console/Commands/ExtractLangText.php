<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ExtractLangText extends Command
{
    // Define the command signature to accept a locale argument and an optional path
    protected $signature = 'lang:extract
                            {locale : the language of the extracted file}
                            {path? : the /lang/(locale).json file or a custom path}
                            {--force : overwrite the whole file or simply add new entries}';

    protected $description = 'Extract all text within the __() helper and output to the /lang/{locale}.json file or a custom path';

    // Execute the command
    public function handle(): void
    {
        // Get the locale and optional output path from the command arguments
        $locale = $this->argument('locale');
        $path = $this->argument('path') ?: base_path('lang'); // Default to base_path('/lang') if no path is provided
        $force = $this->option('force');

        // Ensure the directory exists
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $outputFile = $path . "/$locale.json";
        $translations = [];

        if (file_exists($outputFile)) {
            // if the force flag is set to true, overwrite the file, if not, keep the existing translations and add new ones
            // you keep existing translations, old translations are kept (for now)
            if (!$force) {
                $translations = \File::json($outputFile);
            } else {
                if ($this->confirm('You are about to overwrite all existing translations. Continue or keep existing translations?')) {
                    $this->components->info("$outputFile removed. Rebuilding...");
                } else {
                    $translations = \File::json($outputFile);
                }
            }
            unlink($outputFile);
        }

        // Find all files in app, routes, and resources/views directories
        $directories = [
            base_path('app'),
            base_path('routes'),
            base_path('resources/views'),
        ];

        $new_translations = [];

        foreach ($directories as $directory) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
            foreach ($files as $file) {
                if ($file->isFile() && in_array($file->getExtension(), ['php', 'blade.php'])) {
                    $content = file_get_contents($file->getPathname());

                    // Regex to find all instances of __()
                    preg_match_all("/__\(\s*['\"](.*?)['\"]\s*\)/", $content, $matches);

                    // Store the results
                    foreach ($matches[1] as $key) {
                        $new_translations[$key] = $key;
                        if (!isset($translations[$key])) {
                            $translations[$key] = $key;  // Initial extraction without translation
                        }
                    }
                }
            }
        }

        $difference = array_diff_key($translations, $new_translations);
        \Log::info(json_encode($difference));

        $translations = array_diff($translations, $difference);
        ksort($translations);

        // Write translations to a JSON file in the target directory
        file_put_contents($outputFile, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        $this->components->info(count($translations) . " translations extracted successfully and saved to $outputFile");
    }
}
