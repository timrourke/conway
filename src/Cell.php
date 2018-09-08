<?php

declare(strict_types=1);

namespace Conway;

class Cell
{
    /**
     * @var bool
     */
    public const ALIVE = true;

    /**
     * @var bool
     */
    public const DEAD = false;

    /**
     * @var int
     */
    private $numLiveNeighbors;

    /**
     * @var bool
     */
    private $state;

    public function __construct(bool $initialState = self::ALIVE)
    {
        $this->state = $initialState;
    }

    public function setLiveNeighbors(int $numLiveNeighbors): void
    {
        $this->numLiveNeighbors = $numLiveNeighbors;
    }

    public function getCurrentState(): bool
    {
        return $this->state;
    }

    public function calculateNextState(): void
    {
        if ($this->state === self::ALIVE) {
            $this->state = $this->calculateNextStateForLiveCell();
        } else {
            $this->state = $this->calculateNextStateForDeadCell();
        }
    }

    private function calculateNextStateForLiveCell(): bool
    {
        if ($this->numLiveNeighbors < 2 || $this->numLiveNeighbors > 3) {
            return  self::DEAD;
        }

        return self::ALIVE;
    }

    private function calculateNextStateForDeadCell(): bool
    {
        if ($this->numLiveNeighbors === 3) {
            return self::ALIVE;
        }

        return self::DEAD;
    }
}