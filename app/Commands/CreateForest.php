<?php

declare(strict_types=1);

namespace App\Commands;

use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

final class CreateForest extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make
        {--w|where=./ : Destination where to create desired directory structure}
        {--f|from=./ : Directory structures file path (create directory structure using `tree -J` command)}
        {--s= : Structure}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create forest';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sourceFile = $this->option('from');
        $sourceFile = str($sourceFile)->startsWith('./') ?
            trim(shell_exec('pwd')) . str($sourceFile)->replaceFirst(search: './', replace: '/')
            : $sourceFile;
        $sourceFileContent = file_get_contents($sourceFile);
        $sourceFileContent = json_decode($sourceFileContent, true);

        $this->info('Creating forest...');
        $this->createForest($sourceFileContent);
        $this->info('Forest Created!');
    }

    public function createForest(array $sourceFileDetails, ?string $path = null): void
    {
        $destinationPath = $path ?? $this->option('where');
        $destinationPath = str($destinationPath)->startsWith('./') ?
            trim(shell_exec('pwd')) . str($destinationPath)->replaceFirst(search: './', replace: '/')
            : $destinationPath;

        foreach ($sourceFileDetails as $fileDetails) {
            if (str($fileDetails['type'])->contains('directory')) {
                $directoryPath = ('.' !== $fileDetails['name'])
                ? $destinationPath . '/' . $fileDetails['name'] : $destinationPath;

                if (! File::exists($directoryPath)) {
                    echo "Creating directory > {$destinationPath}\n";
                    File::makeDirectory($directoryPath, 0, true);
                }

                if ($fileDetails['contents']) {
                    $this->createForest($fileDetails['contents'], $directoryPath);
                }
            }

            if (str($fileDetails['type'])->contains('file')) {
                $filePath = $destinationPath . '/' . $fileDetails['name'];
                if (! File::exists($filePath)) {
                    echo "Creating File > {$filePath}\n";
                    File::put($filePath, '\n');
                }
            }
        }
    }
}
