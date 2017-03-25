<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 2/18/2016
 * Time: 5:44 PM
 */

namespace Steampunked;


class Steampunked
{

    public function __construct($seed = null)
    {
        if($seed === null) {
            $seed = time();
        }

        srand($seed);

        //$this->constructionGame($size);
        //Add initial pictures
    }

    //set the size the player choose for the game
    public function setSize($size)
    {
        if($size == 10 || $size == 20 || $size == 6 )
        {
            $this->size = $size;
            $this->constructGame();
        }
        }

    public function constructGame()
    {
        //construct an array of array to keep track of tiles
        for($i=0; $i<$this->size; $i++){
            $row = array();
            for($j=0; $j<$this->size; $j++){
                $row[] = "";
            }
            $this->game[] = $row;
        }

        //create the initial tiles
        $t1l = new SteampunkTile("valve-closed.png");
        $t2l = new SteampunkTile("valve-closed.png");
        $t1r1 = new SteampunkTile("gauge-top-0.png");
        $t2r2 = new SteampunkTile("gauge-top-0.png");
        $t1r = new SteampunkTile("gauge-0.png");
        $t2r = new SteampunkTile("gauge-0.png");

        //place tiles to initial position
        $mid = ($this->size / 2);
        $this->game[$mid-2.5][0] = $t1l;
        $this->game[$mid+2.5][0] = $t2l;
        $this->game[$mid-2.5][$this->size-1] = $t1r1;
        $this->game[$mid-2.5][1] = "leak";
        $this->game[$mid-1.5][$this->size-1] = $t1r;
        $this->game[$mid+2.5][1] = "leak";
        $this->game[$mid+0.5][$this->size-1] = $t2r2;
        $this->game[$mid+1.5][$this->size-1] = $t2r;

        //instantiate the players and attach tiles to players
        $this->player = new SteampunkPlayer();

        $t1l->setOwner(1);
        $t2l->setOwner(2);

    }

    public function Findleaks($player)
    {
        // check each column
        for($i=0; $i<$this->size; $i++){
            // check each row
            for($j=0; $j<$this->size; $j++){
                // is it a tile?
                if($this->game[$i][$j] != "" and $this->game[$i][$j] != "leak"){
                    // is this player's tile?
                    if($this->game[$i][$j]->getOwner() == $player){
                        // check opening
                        $tile = $this->game[$i][$j];
                        $open = $tile->open();
                        foreach(array("N", "W", "S", "E") as $direction) {
                            // Are we open in this direction?
                            if ($open[$direction]) {
                                $n = $tile->neighbor($direction);
                                if ($n === null) {
                                    // We have a leak in this direction...
                                    if($direction == "N"){
                                        $this->game[$i-1][$j] = "leak";
                                    } elseif($direction == "W"){
                                        $this->game[$i][$j-1] = "leak";
                                    } elseif($direction == "S"){
                                        $this->game[$i+1][$j] = "leak";
                                    } elseif($direction == "E"){
                                        $this->game[$i][$j+1] = "leak";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function addTile($i, $j, $choice, $site, $turn_ = -1){
        $item = new SteampunkTile(substr($choice[0],6));
        $item->setOwner(intval($this->getPlayer()->getPlayerTurn()));
        if($turn_ != -1){
            $item->setOwner($turn_);
        }
        $game = $this->getGame();
        $add = true;

        $open = $item->open();
        foreach(array("N", "W", "S", "E") as $direction){
            if($open[$direction]){
                if($direction == "N" and $i != 0 and $game[$i-1][$j] instanceof SteampunkTile){
                    if(!$game[$i-1][$j]->open()["S"]){
                        $add = false;
                    }
                }
                if($direction == "S" and $i != $this->getSize()-1 and $game[$i+1][$j] instanceof SteampunkTile){
                    if(!$game[$i+1][$j]->open()["N"]){
                        $add = false;
                    }
                }
                if($direction == "W" and $j !=0 and $game[$i][$j-1] instanceof SteampunkTile){
                    if(!$game[$i][$j-1]->open()["E"]){
                        $add = false;
                    }
                }
                if($direction == "E" and $j != $this->getSize()-1 and $game[$i][$j+1] instanceof SteampunkTile){
                    if(!$game[$i][$j+1]->open()["W"]){
                        $add = false;
                    }
                }
            }
            else{
                if($direction == "N" and $i != 0 and $game[$i-1][$j] instanceof SteampunkTile){
                    if($game[$i-1][$j]->open()["S"]){
                        $add = false;
                    }
                }
                if($direction == "S" and $i != $this->getSize()-1 and $game[$i+1][$j] instanceof SteampunkTile){
                    if($game[$i+1][$j]->open()["N"]){
                        $add = false;
                    }
                }
                if($direction == "W" and $j !=0 and $game[$i][$j-1] instanceof SteampunkTile){
                    if($game[$i][$j-1]->open()["E"]){
                        $add = false;
                    }
                }
                if($direction == "E" and $j != $this->getSize()-1 and $game[$i][$j+1] instanceof SteampunkTile){
                    if($game[$i][$j+1]->open()["W"]){
                        $add = false;
                    }
                }
            }
        }
        if($add == true){
            foreach(array("N", "W", "S", "E") as $direction){
                if($open[$direction]){
                    if($direction == "N" and $i != 0 and $game[$i-1][$j] instanceof SteampunkTile){
                        $item->addNeighbor($game[$i-1][$j], "N");
                        $game[$i-1][$j]->addNeighbor($item, "S");
                        $item->close("N");
                        $game[$i-1][$j]->close("S");
                        $add = true;
                    }
                    if($direction == "S" and $i != $this->getSize()-1 and $game[$i+1][$j] instanceof SteampunkTile){
                        $item->addNeighbor($game[$i+1][$j], "S");
                        $game[$i+1][$j]->addNeighbor($item, "N");
                        $item->close("S");
                        $game[$i+1][$j]->close("N");
                        $add = true;
                    }
                    if($direction == "W" and $j !=0 and $game[$i][$j-1] instanceof SteampunkTile){
                        $item->addNeighbor($game[$i][$j-1], "W");
                        $game[$i][$j-1]->addNeighbor($item, "E");
                        $item->close("W");
                        $game[$i][$j-1]->close("E");
                        $add = true;
                    }
                    if($direction == "E" and $j != $this->getSize()-1 and $game[$i][$j+1] instanceof SteampunkTile){
                        $item->addNeighbor($game[$i][$j+1], "E");
                        $game[$i][$j+1]->addNeighbor($item, "W");
                        $item->close("E");
                        $game[$i][$j+1]->close("W");
                        $add = true;
                    }
                }
            }
        }

        //put the tile into array, recheck the leak condition and switch player
        if($add == true) {
            $turn = intval($this->getPlayer()->getPlayerTurn());
            if($turn_ != -1){
                $turn = $turn_;
            }
            $this->setGame($i, $j, $item);
            $this->Findleaks($turn);
            $this->updateHand(intval($choice[1]));
            $this->switchPlayer();
            $tile = new Tiles($site);
            $tile->addTile(substr($choice[0],6),$i,$j,$this->getId(),$turn);
            $game = new Games($site);
            $game->setTurn($this->getId(),3-$turn);
            $this->setCnt($this->getCnt()+1);

            /*
            * PHP code to cause a push on a remote client.
            */
            $msg = json_encode(array('key'=>'Mecks', 'cmd'=>'reload'));
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

            $sock_data = socket_connect($socket, '127.0.0.1', 8078);
            if(!$sock_data) {
                echo "Failed to connect";
            } else {
                socket_write($socket, $msg, strlen($msg));
            }
            socket_close($socket);
        }
    }

    public function findPlayerLeak($player){

        $mid = ($this->size / 2);
        $root1 = $this->game[$mid-1.5][$this->size-1];
        $root2 = $this->game[$mid+1.5][$this->size-1];
        $result = null;

        if($player == 1){
            echo "<p>here r1</p>";
            $result = $root1->indicateLeaks();
        } elseif($player == 2){
            $result = $root2->indicateLeaks();
        }

        if($result == "leak"){
            $this->setWinner(3 - $player);
            return 3-$player;
        } elseif($result == null){
            $this->setWinner($player);
            return $player;
        }
        //echo $result;
    }

    public function getSize(){
        return $this->size;
    }

    public function getGame(){
        return $this->game;
    }

    public function getPlayer(){
        return $this->player;
    }

    public function setGame($i, $j, $item){
        $this->game[$i][$j] = $item;
    }

    public function setPlayerName($p1, $p2){
        $this->player->setPlayerName($p1, $p2);
    }

    public function switchPlayer(){
        $this->player->switchPlayer();
        $this->wait = !$this->wait;
    }

    public function updateHand($pos){
        $this->player->updateHand($pos);
    }

    public function getWinner(){
        return $this->winner;
    }

    public function setWinner($winner){
        if($winner== 1  || $winner==2) {
            $this->winner = $winner;
        }
    }

    public function getWinnerName($winner){
        return $this->player->getWinnerName($winner);
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setWait($wait){
        $this->wait = $wait;
    }

    public function getWait(){
        return $this->wait;
    }

    /**
     * @return mixed
     */
    public function getPlayerNum()
    {
        return $this->playerNum;
    }

    /**
     * @param mixed $playerNum
     */
    public function setPlayerNum($playerNum)
    {
        $this->playerNum = $playerNum;
    }

    /**
     * @return mixed
     */
    public function getCnt()
    {
        return $this->cnt;
    }

    /**
     * @param mixed $cnt
     */
    public function setCnt($cnt)
    {
        $this->cnt = $cnt;
    }

    public function getWinnerHTML(){
        $winner = $this->getWinner();

        $name = $this->getWinnerName($winner);

        $html = "<p class=\"win\">Player ";
        $html .= $winner;
        $html .= ": ";
        $html .= $name;
        $html .= " Wins the Game!</p>";

        return $html;

    }



    private $game = array();
    private $size;
    private $player;
    private $winner;
    private $id;
    private $wait;
    private $playerNum;
    private $cnt;
}
