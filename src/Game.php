<?php

declare(strict_types=1);

namespace Conway;

class Game
{
    /**
     * @var \Conway\Board
     */
    private $gameBoard;

    /**
     * @var array
     */
    private $board;

    /**
     * @var string
     */
    private $outputBuffer;

    public function __construct(Board $board)
    {
        $this->gameBoard = $board;
        $this->board = $this->gameBoard->getBoard();
    }

    public function tick(): void
    {
        $this->displayCurrentState();

        for ($row = 0; $row < count($this->board); $row++) {
            for ($column = 0; $column < count($this->board[$row]); $column++) {
                $this->setLiveNeighborsForNextTick($row, $column);
            }
        }

        for ($row = 0; $row < count($this->board); $row++) {
            for ($column = 0; $column < count($this->board[$row]); $column++) {
                $this->calculateStateForNextTick($row, $column);
            }
        }
    }

    private function calculateStateForNextTick(int $row, int $column): void
    {
        /* @var \Conway\Cell $cell */
        $cell = $this->board[$row][$column];

        $cell->calculateNextState();
    }

    private function setLiveNeighborsForNextTick(int $row, int $column): void
    {
        $numLiveNeighbors = $this->getNumLiveNeighbors($row, $column);

        /* @var \Conway\Cell $cell */
        $cell = $this->board[$row][$column];

        $cell->setLiveNeighbors($numLiveNeighbors);
    }

    private function getNumLiveNeighbors(int $row, int $column): int
    {
        $board = $this->board;

        $topLeftNeighbor     = $board[$row - 1][$column - 1] ?? null;
        $topNeighbor         = $board[$row - 1][$column    ] ?? null;
        $topRightNeighbor    = $board[$row - 1][$column + 1] ?? null;
        $rightNeighbor       = $board[$row    ][$column + 1] ?? null;
        $bottomRightNeighbor = $board[$row + 1][$column + 1] ?? null;
        $bottomNeighbor      = $board[$row + 1][$column    ] ?? null;
        $bottomLeftNeighbor  = $board[$row + 1][$column - 1] ?? null;
        $leftNeighbor        = $board[$row    ][$column - 1] ?? null;

        $liveNeighbors = array_filter(
            [
                $topLeftNeighbor,
                $topNeighbor,
                $topRightNeighbor,
                $rightNeighbor,
                $bottomRightNeighbor,
                $bottomNeighbor,
                $bottomLeftNeighbor,
                $leftNeighbor,
            ],
            function (?Cell $cell): bool {
                return !is_null($cell) && $cell->getCurrentState();
            }
        );

        return count($liveNeighbors);
    }

    private function displayCurrentState(): void
    {
        $this->outputBuffer = "";

        foreach ($this->board as $row) {
            $line = array_map(
                function (Cell $cell) {
                    return $this->getStateCharacter($cell->getCurrentState());
                },
                $row
            );

            $this->outputBuffer .= sprintf("%s\n", implode("", $line));
        }

        echo $this->outputBuffer;
    }

    private function getStateCharacter(bool $state): string
    {
        if ($state) {
            return "░";
        }

        return "█";
    }
}