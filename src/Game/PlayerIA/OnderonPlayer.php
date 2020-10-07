<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class OnderonPlayers
 * @package Hackathon\PlayerIA
 * @author YOUR NAME HERE
 */
class OnderonPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;
    protected $beat = ['parent::rockChoice()', 'parent::paperChoice()', 'parent::scissorsChoice()'];

    public function getChoice()
    {
        $scores = $this->result->getScoresFor($this->mySide);
        $length = count($scores);
        if ($length == 0) {
            return parent::rockChoice();
        }
        $myLastChoice = $this->result->getLastChoiceFor($this->mySide);
        $opponentLastChoice = $this->result->getLastChoiceFor($this->opponentSide);
        switch ($scores[$length - 1]) {
            case 0: //lost
                switch ($opponentLastChoice) {
                    case 'paper':
                        return parent::scissorsChoice();
                    case 'rock':
                        return parent::paperChoice();
                    case 'scissor':
                        return parent::rockChoice();
                }
                break;
            case 5: // won
                switch ($myLastChoice) {
                    case 'paper':
                        return parent::scissorsChoice();
                    case 'rock':
                        return parent::paperChoice();
                    case 'scissor':
                        return parent::rockChoice();
                }
                break;
            case 1: //tie
                switch ($myLastChoice) {
                    case 'paper':
                        return parent::scissorsChoice();
                    case 'rock':
                        return parent::paperChoice();
                    case 'scissor':
                        return parent::rockChoice();
                }
                break;
        }
        return parent::paperChoice();
    }
};
