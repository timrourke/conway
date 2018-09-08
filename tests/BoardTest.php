<?php

declare(strict_types=1);

namespace Conway;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowExceptionIfBoardTooShort()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Board must be at least 1 row tall, got: 0'
        );

        new Board(20, 0);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfBoardTooNarrow()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Board must be at least 1 column wide, got: 0'
        );

        new Board(0, 83);
    }

    /**
     * @test
     */
    public function shouldGetWidth()
    {
        $board = new Board(23, 87);

        $this->assertSame(
            23,
            $board->getWidth()
        );
    }

    /**
     * @test
     */
    public function shouldGetHeight()
    {
        $board = new Board(23, 87);

        $this->assertSame(
            87,
            $board->getHeight()
        );
    }

    /**
     * @test
     */
    public function shouldGenerateBoard()
    {
        $boardObject = new Board(3, 3);

        $board = $boardObject->getBoard();

        $this->assertSame(
            3,
            count($board)
        );

        $cells = [];

        foreach ($board as $row) {
            $cells = array_merge($cells, $row);
        }

        foreach ($cells as $cell) {
            $this->assertInstanceOf(
                Cell::class,
                $cell
            );
        }

        $this->assertCount(9, $cells);
    }
}
