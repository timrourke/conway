<?php

declare(strict_types=1);

namespace Conway\Command;

use Conway\Board;
use Conway\Game;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RunGameCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('run')
            ->setDescription("Run Conway's Game of Life")
            ->setHelp(<<<EOT
Runs a new instance of Conway's Game of Life.
Output will be printed to stdout.
EOT
            )
            ->addOption(
                'columns',
                null,
                InputOption::VALUE_REQUIRED,
                'How many columns wide the game should be',
                90
            )
            ->addOption(
                'rows',
                null,
                InputOption::VALUE_REQUIRED,
                'How many rows tall the game should be',
                40
            )
            ->addOption(
                'tick-length',
                null,
                InputOption::VALUE_REQUIRED,
                'How long each tick should be in milliseconds. Controls frame rate.',
                100
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $columns = $input->getOption('columns');
        $rows = $input->getOption('rows');
        $tickLength = $input->getOption('tick-length');

        try {
            $numGenerations = 0;

            $board = new Board((int) $columns, (int) $rows);

            $game = new Game($board);

            $output->write($game->tick());
            $output->write("Generation: " . $numGenerations++);

            usleep($tickLength * 1000);

            while (true) {
                $frame = $game->tick();

                for ($i = 0; $i < $rows; $i++) {
                    $this->clearScreen($output);
                }

                $output->write($frame);
                $output->write("Generation: " . $numGenerations++);

                usleep($tickLength * 1000);
            }
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
        }
    }

    private function clearScreen(OutputInterface $output): void
    {
        $output->write("\x0D");
        $output->write("\x1B[2K");
        $output->write("\x1B[1A\x1B[2K");
    }
}