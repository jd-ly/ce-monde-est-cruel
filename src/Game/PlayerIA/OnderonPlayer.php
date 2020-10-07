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
    protected $opponentR = 0;
    protected $opponentP = 0;
    protected $opponentS = 0;
    protected $random = false;

    public function getChoice()
    {
        $scores = $this->result->getScoresFor($this->mySide);
        $length = count($scores);
        if ($length == 0) {
            return parent::rockChoice();
        }
        $myLastChoice = $this->result->getLastChoiceFor($this->mySide);
        $opponentLastChoice = $this->result->getLastChoiceFor($this->opponentSide);

        switch ($opponentLastChoice) {
            case 'rock':
                $this->opponentR++;
                break;
            case 'paper':
                $this->opponentP++;
                break;
            case 'scissors':
                $this->opponentS++;
        }

        $nbRound = $this->result->getNbRound();

        if ($nbRound % 30 == 0) {
            if (($this->opponentP <= 11 * ($nbRound / 30) && $this->opponentP >= 9 * ($nbRound / 30))
                && ($this->opponentR <= 11 * ($nbRound / 30) && $this->opponentR >= 9 * ($nbRound / 30))
                && ($this->opponentS <= 11 * ($nbRound / 30) && $this->opponentS >= 9 * ($nbRound / 30))) {
                $this->random = true;
            }
        }

        if ($this->opponentR + $this->opponentP < $this->opponentS) {
            return parent::rockChoice();
        }
        if ($this->opponentP + $this->opponentS < $this->opponentR) {
            return parent::paperChoice();
        }
        if ($this->opponentS + $this->opponentR < $this->opponentP) {
            return parent::scissorsChoice();
        }

        if ($this->random) {
            if ($this->opponentR < $this->opponentP && $this->opponentR < $this->opponentS) {
                return parent::paperChoice();
            }
            if ($this->opponentP < $this->opponentR && $this->opponentP < $this->opponentS) {
                return parent::scissorsChoice();
            }
            if ($this->opponentS < $this->opponentP && $this->opponentS < $this->opponentR) {
                return parent::rockChoice();
            }

            if ($this->opponentR == $this->opponentP && $this->opponentR < $this->opponentS) {
                return parent::paperChoice();
            }
            if ($this->opponentR == $this->opponentS && $this->opponentR < $this->opponentP) {
                return parent::rockChoice();
            }
            if ($this->opponentS == $this->opponentP && $this->opponentS < $this->opponentR) {
                return parent::scissorsChoice();
            }

            return parent::scissorsChoice();
        }

        if ($nbRound == 100) {
            $myScore = $this->result->getStatsFor($this->mySide)['score'];
            $opponentScore = $this->result->getStatsFor($this->opponentSide)['score'];
            if ($opponentScore > $myScore) {
                $this->inverted = false;
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
