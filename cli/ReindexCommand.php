<?php
namespace Grav\Plugin\Console;

use Grav\Console\ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
require_once(__DIR__ . '/../vendor/fortune.php');

/**
 * Class HelloCommand
 *
 * @package Grav\Plugin\Console
 */
class ReindexCommand extends ConsoleCommand
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * Greets a person with or without yelling
     */
    protected function configure()
    {
        $this
            ->setName("reindex")
            ->setDescription("Reindexes specific 'fortune' files or a folder of such files.")
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'The file or folder to be indexed.'
            )
            ->setHelp('The <info>reindex</info> command generates the necessary ".dat" files from properly formatted fortune files or a whole folder of such files.')
        ;
    }

    /**
     * @return int|null|void
     */
    protected function serve()
    {
        // Collects the arguments and options as defined
        $this->options = [
            'name' => $this->input->getArgument('name'),
        ];

        if (is_dir($this->options['name']))
        {
            $f = new \Fortune;
            $dir = new \DirectoryIterator($this->options['name']);
            foreach ($dir as $fileinfo) {
                if ( ($fileinfo->isFile()) && (! self::endsWith($fileinfo->getFilename(), ".dat")) ) {
                    $f->createIndexFile($fileinfo->getPathname(), true);        
                }
            }
        }
        elseif (is_file($this->options['name'])) 
        {
            $f = new \Fortune;
            $f->createIndexFile($this->options['name'], true);
        }
        else
        {
            $this->output->writeln('<red>ERROR:</red> The name you provided is neither a valid file nor a valid folder.');
        }
    }

    /**
     * Check if the $haystack string ends with the substring $needle
     *
     * @param  string $haystack
     * @param  string|string[] $needle
     *
     * @return bool
     */
    private static function endsWith($haystack, $needle)
    {
        $status = false;
        foreach ((array)$needle as $each_needle) {
            $status = $each_needle === '' || substr($haystack, -strlen($each_needle)) === $each_needle;
            if ($status) {
                break;
            }
        }
        return $status;
    }
}
