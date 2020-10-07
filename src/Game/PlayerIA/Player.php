<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class Player
 * @package Hackathon\PlayerIA
 *
 * This abstract class give a panel of function
 * You don't have to override functions expect getChoice
 */
abstract class Player
{
    /**
     * Stupid Function -- The only one, you can override !
     */
    protected function getChoice()
    {
        return $this->rockChoice();
    }

    /**
     * You don't need this function
     * @DON'T OVERRIDE
     */
    public function getName()
    {
        return str_replace('Hackathon\\IA\\', "", str_replace("Player", "", get_class($this)));
    }

    /**
     * This function tells you, if you are 'a' or 'b'
     * @DON'T OVERRIDE
     */
    public function getSide()
    {
        return $this->side;
    }

    /**
     * @param $side - The value can be 'a' or 'b'
     * --> The Engine sets this value for you
     * @DON'T OVERRIDE
     */
    public function setSide($side)
    {
        $this->mySide = $side;
        $this->opponentSide = ($side === 'a') ? 'b' : 'a';
    }

    /**
     * @param $result - value of the last result (in an object)
     * --> The Engine update this value for you
     * @DON'T OVERRIDE
     */
    public function updateResult(Result $result)
    {
        $this->result = $result;
    }

    /**
     * @return string 'scissors'
     * @DON'T OVERRIDE
     */
    public function scissorsChoice()
    {
        return 'scissors';
    }

    /**
     * @return string 'paper'
     * @DON'T OVERRIDE
     */
    public function paperChoice()
    {
        return 'paper';
    }

    /**
     * @return string 'rock'
     * @DON'T OVERRIDE
     */
    public function rockChoice()
    {
        return 'rock';
    }

    /**
     * @DON'T OVERRIDE
     * This function helps you to debug
     */
    protected function prettyDisplay()
    {
        $myStat= $this->result->getStatsFor($this->mySide);
        $oppoStat= $this->result->getStatsFor(($this->opponentSide));

        echo "(", $this->result->getNbRound(), ") Last round ", $myStat['name'], " plays ", $this->result->getLastChoiceFor($this->mySide), " \t ",
        $oppoStat['name'], " plays ", $this->result->getLastChoiceFor($this->opponentSide), PHP_EOL, "\t",
        $myStat['name'], " :  ", $this->result->getLastScoreFor($this->mySide), " \t ", $oppoStat['name'], " : ", $this->result->getLastScoreFor($this->opponentSide), PHP_EOL;
    }
};