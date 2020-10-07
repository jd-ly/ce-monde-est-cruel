<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class OnderonPlayers
 * @package Hackathon\PlayerIA
 * @author Jean Damien Ly
 */
class OnderonPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;
    protected $beat = ['scissors' => 'parent::rockChoice()', 'rock' => 'parent::paperChoice()', 'paper' => 'parent::scissorsChoice()'];
    protected $inverted = false;

    public function getChoice()
    {
        $scores = $this->result->getScoresFor($this->mySide);
        $length = count($scores);
        if ($length == 0) {
            return parent::rockChoice();
        }
        $myLastChoice = $this->result->getLastChoiceFor($this->mySide);
        $opponentLastChoice = $this->result->getLastChoiceFor($this->opponentSide);

        if ($this->result->getNbRound() == 100) {
            $myScore = $this->result->getStatsFor($this->mySide)['score'];
            $opponentScore = $this->result->getStatsFor($this->opponentSide)['score'];
            if ($opponentScore > $myScore) {
                $this->inverted = true;
            }
        }

        switch ($scores[$length - 1]) {
            case 0: //lost
                if ($this->inverted) {
                    $opponentLastChoice = $myLastChoice;
                }
                switch ($opponentLastChoice) {
                    case 'paper':
                        return parent::scissorsChoice();
                    case 'rock':
                        return parent::paperChoice();
                    case 'scissors':
                        return parent::rockChoice();
                }
                break;
            case 3: // won
                if ($this->inverted) {
                    $myLastChoice = $opponentLastChoice;
                }
                switch ($myLastChoice) {
                    case 'paper':
                        return parent::scissorsChoice();
                    case 'rock':
                        return parent::paperChoice();
                    case 'scissors':
                        return parent::rockChoice();
                }
                break;
            case 1: //tie
                if ($length == 1) {
                    switch ($myLastChoice) {
                        case 'paper':
                            return parent::rockChoice();
                        case 'rock':
                            return parent::scissorsChoice();
                        case 'scissors':
                            return parent::paperChoice();
                    }
                }
                switch ($scores[$length - 2]) {
                    case 'paper':
                        return parent::rockChoice();
                    case 'rock':
                        return parent::scissorsChoice();
                    case 'scissors':
                        return parent::paperChoice();
                }
                break;
        }
        return parent::paperChoice();
    }
};
