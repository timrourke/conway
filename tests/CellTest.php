<?php

declare(strict_types=1);

namespace Conway;

use PHPUnit\Framework\TestCase;

class CellTest extends TestCase
{
    /**
     * @test
     */
    public function shouldInitializeToAliveByDefault()
    {
        $cell = new Cell();

        $this->assertSame(
            Cell::ALIVE,
            $cell->getCurrentState()
        );
    }

    /**
     * @test
     */
    public function shouldBeAliveIfExplicitlyInitializedAsAlive()
    {
        $cell = new Cell(Cell::ALIVE);

        $this->assertSame(
            Cell::ALIVE,
            $cell->getCurrentState()
        );
    }

    /**
     * @test
     */
    public function shouldBeDeadIfExplicitlyInitializedAsDead()
    {
        $cell = new Cell(Cell::DEAD);

        $this->assertSame(
            Cell::DEAD,
            $cell->getCurrentState()
        );
    }

    /**
     * @test
     */
    public function liveCellShouldDieIfZeroLiveNeighbors()
    {
        $cell = new Cell();

        $cell->setLiveNeighbors(0);

        $cell->calculateNextState();

        $this->assertSame(
            Cell::DEAD,
            $cell->getCurrentState()
        );
    }

    /**
     * @test
     */
    public function liveCellShouldDieIfOneLiveNeighbor()
    {
        $cell = new Cell();

        $cell->setLiveNeighbors(1);

        $cell->calculateNextState();

        $this->assertSame(
            Cell::DEAD,
            $cell->getCurrentState()
        );
    }

    /**
     * @test
     */
    public function liveCellShouldDieIfMoreThan3LiveNeighbors()
    {
        $cell = new Cell();

        $cell->setLiveNeighbors(4);

        $cell->calculateNextState();

        $this->assertSame(
            Cell::DEAD,
            $cell->getCurrentState()
        );
    }

    /**
     * @test
     */
    public function deadCellShouldComeToLifeIfExactlyTheeLiveNeighbors()
    {
        $cell = new Cell(Cell::DEAD);

        $cell->setLiveNeighbors(3);

        $cell->calculateNextState();

        $this->assertSame(
            Cell::ALIVE,
            $cell->getCurrentState()
        );
    }

    /**
     * @test
     */
    public function deadCellWithLessThanThreeLiveNeighborsShouldStayDead()
    {
        $cell = new Cell(Cell::DEAD);

        $cell->setLiveNeighbors(2);

        $cell->calculateNextState();

        $this->assertSame(
            Cell::DEAD,
            $cell->getCurrentState()
        );
    }

    /**
     * @test
     */
    public function deadCellWithMoreThanThreeLiveNeighborsShouldStayDead()
    {
        $cell = new Cell(Cell::DEAD);

        $cell->setLiveNeighbors(4);

        $cell->calculateNextState();

        $this->assertSame(
            Cell::DEAD,
            $cell->getCurrentState()
        );
    }
}
