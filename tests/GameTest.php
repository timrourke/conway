<?php

declare(strict_types=1);

namespace Conway;

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * @test
     */
    public function shouldRenderInitialStateToOutputBuffer()
    {
        $board = new Board(3, 3);

        $game = new Game($board);

        ob_start();
        $game->tick();
        $output = ob_get_clean();

        $this->assertNotEmpty($output);

        $this->assertRegExp("/^([░█]{3}\n){3}$/u", $output);
    }

    /**
     * @test
     */
    public function shouldRenderCorrectState()
    {
        $expected = "░█░\n█░█\n░░█\n";

        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|Board $board
         */
        $board = $this->getMockBuilder(Board::class)
            ->disableOriginalConstructor()
            ->getMock();

        $board->expects($this->once())
            ->method('getBoard')
            ->willReturn($this->getBoardFixture());

        $game = new Game($board);

        ob_start();
        $game->tick();
        $actual = ob_get_clean();

        $this->assertSame(
            $expected,
            $actual
        );
    }

    /**
     * @test
     */
    public function shouldRenderNextState()
    {
        $expected = "█░█\n██░\n░░█\n";

        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|Board $board
         */
        $board = $this->getMockBuilder(Board::class)
            ->disableOriginalConstructor()
            ->getMock();

        $board->expects($this->once())
            ->method('getBoard')
            ->willReturn($this->getBoardFixture());

        $game = new Game($board);

        ob_start();
        $game->tick();
        ob_end_clean();

        ob_start();
        $game->tick();
        $actual = ob_get_clean();

        $this->assertSame(
            $expected,
            $actual
        );
    }

    /**
     * @return array
     */
    private function getBoardFixture(): array
    {
        return [
            [
                new Cell(true),
                new Cell(false),
                new Cell(true),
            ],
            [
                new Cell(false),
                new Cell(true),
                new Cell(false),
            ],
            [
                new Cell(true),
                new Cell(true),
                new Cell(false),
            ],
        ];
    }
}
