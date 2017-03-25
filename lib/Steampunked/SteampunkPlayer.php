<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 2/28/2016
 * Time: 6:06 PM
 */

namespace Steampunked;


class SteampunkPlayer
{
    public function __construct()
    {
        //four basic choices
        $this->pipes[] = new SteampunkTile("cap-e.png");
        $this->pipes[] = new SteampunkTile("ninety-es.png");
        $this->pipes[] = new SteampunkTile("straight-h.png");
        $this->pipes[] = new SteampunkTile("tee-esw.png");

        //add random pipes into player's array
        for($i=0; $i<5; $i++){
            $this->pipe1[] = $this->getRandomPipe();
            $this->pipe2[] = $this->getRandomPipe();
        }
        $this->player = 1;
    }

    //switch player
    public function switchPlayer(){
        if($this->player == 1){
            $this->player = 2;
        } elseif($this->player == 2){
            $this->player = 1;
        }
    }

    public function getPlayerTurn(){
        return $this->player;
    }

    public function getRandomPipe() {
        return clone $this->pipes[rand(0, count($this->pipes)-1)];
    }

    //get the current player's pipe
    public function getPipes($player){
        if($player == 1) {
            return $this->pipe1;
        } elseif($player == 2){
            return $this->pipe2;
        }
    }

    //rotate a tile
    public function rotateTile($position){
        $this->position = $position;
        if($this->player == 1){
            $this->pipe1[$position]->rotate();
        } elseif($this->player == 2){
            $this->pipe2[$position]->rotate();
        }
    }

    public function setPlayerName($p1, $p2){
        if($p1 != "" and $p1 != " "){
            $this->player1Name = $p1;
        } else{
            $this->player1Name = "Player 1";
        }
        if($p2 != "" and $p2 != " "){
            $this->player2Name = $p2;
        } else{
            $this->player2Name = "Player 2";
        }
    }

    public function getPlayerName(){
        if($this->player == 1){
            return $this->player1Name;
        } elseif($this->player == 2){
            return $this->player2Name;
        }
    }

    public function getWinnerName($winner){
        if($winner == 1){
            return $this->player1Name;
        } elseif($winner == 2){
            return $this->player2Name;
        }
    }

    public function updateHand($pos){
        if($this->player == 1){
            $this->pipe1[$pos] = $this->getRandomPipe();
        } elseif($this->player == 2){
            $this->pipe2[$pos] = $this->getRandomPipe();
        }
    }

    public function getPosition(){
        return $this->position;
    }

    private $pipes = array();   //possible tiles
    private $player;        //the current player
    private $pipe1;             //player1's pipe
    private $pipe2;             //player2's pipe
    private $player1Name;
    private $player2Name;
    private $position;
}
