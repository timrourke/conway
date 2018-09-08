<?php

declare(strict_types=1);

namespace Conway;

use InvalidArgumentException;

class Board
{
    /**
     * @var int
     */
    private $width = 0;

    /**
     * @var int
     */
    private $height = 0;

    /**
     * @var array
     */
    private $board = [];

    public function __construct(int $width, int $height)
    {
        $this->validateWidth($width);
        $this->validateHeight($height);

        $this->width = $width;
        $this->height = $height;

        $this->generateRandomCells();
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getBoard(): array
    {
        return $this->board;
    }

    private function validateWidth(int $width): void
    {
        if ($width < 1) {
            throw new InvalidArgumentException(
                sprintf('Board must be at least 1 column wide, got: %d', $width)
            );
        }
    }

    private function validateHeight(int $height): void
    {
        if ($height < 1) {
            throw new InvalidArgumentException(
                sprintf('Board must be at least 1 row tall, got: %d', $height)
            );
        }
    }

    private function generateRandomCells(): void
    {
        $this->board = [];

        for ($i = 0; $i < $this->height; $i++) {
            $this->board[$i] = [];

            for ($j = 0; $j < $this->width; $j++) {
                $randomState = mt_rand(0, 1);

                $this->board[$i][] = new Cell((bool) $randomState);
            }
        }
    }
}