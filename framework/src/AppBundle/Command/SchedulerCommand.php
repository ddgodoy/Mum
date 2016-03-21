<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SchedulerCommand
 *
 * @package AppBundle\Command
 */
class SchedulerCommand extends ContainerAwareCommand
{
    /**
     * Configure the command
     */
    protected function configure()
    {
        $this
            ->setName('mum:scheduler:start')
            ->setDescription('MUM Scheduler Start')
            ->addOption(
                'daemon',
                'd',
                InputOption::VALUE_NONE,
                'Should run as a daemon?'
            )
            ->addOption(
                'output',
                'o',
                InputOption::VALUE_NONE,
                'Should print output messages to console?'
            );
    }

    /**
     * Print timestamp
     *
     * @return string
     */
    private function getTimestamp()
    {
        return "<info>" . date_format(new \DateTime(), "[Y-m-d H:i:s]") . "</info>";
    }

    /**
     * Dispatch the messages
     *
     * @param OutputInterface $output
     * @param boolean $print
     * @return integer
     */
    private function dispatch(OutputInterface $output, $print = false)
    {
        $container = $this->getContainer();
        $messageDispatcher = $container->get('mum.message.dispatcher');
        $stats = $messageDispatcher->dispatch();
        $total = array_sum(array_values($stats));
        if ($print) {
            $text = $this->getTimestamp();
            foreach ($stats as $statName => $value) {
                $text .= " <info>" . $value . "</info> " . $statName . " message ";
            }
            $text .= "for a total of <info>" . $total . "</info> messages delivered";

            $output->writeln($text);
        }
        return $total;
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startingText = $this->getTimestamp() . " Scheduler started";
        if ($input->getOption('daemon')) {
            $output->writeln("Scheduler started as a daemon");
            while (true) {
                $total = $this->dispatch($output, $input->getOption('output'));
                if (intval($total) === 0) {
                    $sleep = 60;
                    $output->writeln(sprintf("<info>No action performed. Sleeping for %s seconds</info>", $sleep));
                    sleep($sleep);
                }
            }
        } else {
            $output->writeln($startingText);
            $this->dispatch($output, $input->getOption('output'));
        }
    }
}