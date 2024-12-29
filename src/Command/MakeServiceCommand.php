<?php

namespace App\Command;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'make:service',
    description: 'Create a new service class',
)]
class MakeServiceCommand extends Command
{
    private Filesystem $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'Name of the service class');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        // If no name is provided, ask the user for input
        if (!$name) {
            $helper = $this->getHelper('question');
            // $output->writeln('');
            $question = new Question("<fg=green>\n Choose a name for your service class (e.g. <fg=yellow>MyService</>)</> \n > ");

            $name = $helper->ask($input, $output, $question);

            // If the user doesn't provide a name, return with an error
            if (!$name) {
                $output->writeln('');
                $output->writeln('<error>[ERROR] This value cannot be blank.</error>');
                $output->writeln('');
                return Command::FAILURE;
            }
        }

        // Ensure the name is valid
        if (!preg_match('/^[A-Za-z][A-Za-z0-9_]*$/', $name)) {
            $output->writeln('');
            $output->writeln('<error>Invalid service name. Use only letters, numbers, and underscores, starting with a letter.</error>');
            return Command::FAILURE;
        }
        if (!str_ends_with(strtolower($name), "service")) {
            $name = ucfirst($name) . "Service";
        }

        $directory = __DIR__ . '/../../src/Service';
        $filePath = $directory . '/' . $name . '.php';

        // Check if the file already exists
        if ($this->filesystem->exists($filePath)) {
            $output->writeln('');
            $output->writeln('<error>The service file already exists!</error>');
            return Command::FAILURE;
        }

        // Create the file content
        $fileContent = <<<PHP
<?php

namespace App\Service;

class $name
{
    public function __construct()
    {
        // Initialize your service
    }
}
PHP;

        // Ensure the directory exists
        $this->filesystem->mkdir($directory);

        // Write the file
        $this->filesystem->dumpFile($filePath, $fileContent);
        $output->writeln("");
        $output->writeln("<info>Service '$name' created successfully in src/Service!</info>");
        $output->writeln("");
        return Command::SUCCESS;
    }
}
