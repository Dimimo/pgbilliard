<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Livewire\Component;
use Symfony\Component\Finder\Finder;

class CreateLivewireTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livewire:test {--force : overwrite existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Discover Livewire Components and Generate Unit Test';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $paths = [
            app_path('Livewire')
        ];

        $this->components->success('Starting');

        foreach ((new Finder())->in($paths)->files() as $file) {
            $component = ucfirst(trim(
                str_replace(
                    [realpath(base_path()), '.php']
                    , '', $file->getRealPath()), '/'
            ));
            $className = str_replace(['/', '\\app'], ['\\', '\\App'], $component);

            if (is_subclass_of($className, Component::class)) {

                $directory = base_path(
                    'tests/Feature' . str_replace([app_path(), $file->getFilename()], '', $file->getRealPath())
                );
                $class = $file->getFilenameWithoutExtension();
                $filename = $class . 'Test.php';
                $filepath = $directory . DIRECTORY_SEPARATOR . $filename;

                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                $this->components->info('file path: ' . $filepath);

                $content = "<?php

        use $className;
        use Livewire\Livewire;

        it('renders successfully', function () {
            Livewire::test($class::class)
                ->assertStatus(200);
        });
        ";

                if ($this->option('force') || !file_exists($filepath)) {
                    file_put_contents($filepath, $content);
                }

                $this->info("Successfully created $className unit test.");
            }
        }
    }
}
