<?php

/**
 * Created by PhpStorm.
 * User: Tianhang
 * Date: 16/2/17
 * Time: 下午6:57
 */
namespace Steampunked;

class SteampunkedController
{
    public function __construct(Steampunked $Steampunked, $post, $site) {
        $this->Steampunked = $Steampunked;

        //get the size
        /*if(isset($post['size'])){
            $this->Steampunked->setSize($post['size']);
        }*/

        //get the player name
        if(isset($post['player1']) and !isset($post['go'])){
            //get the size
            if(isset($post['size'])) {
                $this->Steampunked->setSize($post['size']);
                $this->Steampunked->setPlayerName($post['player1'], "");
                $game = new Games($site);
                $game->createGame($post['player1'], "", $post['size']);
                $id = $game->getId();
                $this->Steampunked->setId($id['id']);
                $this->Steampunked->setWait(true);
                $this->Steampunked->setPlayerNum(1);
                $this->Steampunked->setCnt(0);
            }
        }

        if(isset($post['player1']) and isset($post['go'])){
            $game = new Games($site);
            $id = $post['go'];
            $size = $game->getSize($id);
            $this->Steampunked->setSize($size['size']);
            $game->setName2($post['player1'],$id);
            $name = $game->getName($id);
            $this->Steampunked->setPlayerName($name['name'],$post['player1']);
            $this->Steampunked->setId($id);
            $game->hide($id);
            $this->Steampunked->setWait(true);
            $this->Steampunked->setPlayerNum(2);
            $game->setTurn($id,1);
            $this->Steampunked->setCnt(0);
            $this->reload();
        }

        //if a leak button is clicked
        if(isset($post['leak'])) {

            //get the leak position
            $split = explode(',', strip_tags($post['leak']));
            $i = intval($split[0]);
            $j = intval($split[1]);

            //if one of the choices is selected
            if(isset($post['choice'])){

                //create a new tile
                $choice = explode(',', strip_tags($post['choice']));
                $this->Steampunked->addTile($i, $j, $choice, $site);
                /*$item = new SteampunkTile(substr($choice[0],6));
                $item->setOwner(intval($this->Steampunked->getPlayer()->getPlayerTurn()));
                $game = $this->Steampunked->getGame();
                $add = true;

                $open = $item->open();
                foreach(array("N", "W", "S", "E") as $direction){
                    if($open[$direction]){
                        if($direction == "N" and $i != 0 and $game[$i-1][$j] instanceof SteampunkTile){
                            if(!$game[$i-1][$j]->open()["S"]){
                                $add = false;
                            }
                        }
                        if($direction == "S" and $i != $this->Steampunked->getSize()-1 and $game[$i+1][$j] instanceof SteampunkTile){
                            if(!$game[$i+1][$j]->open()["N"]){
                                $add = false;
                            }
                        }
                        if($direction == "W" and $j !=0 and $game[$i][$j-1] instanceof SteampunkTile){
                            if(!$game[$i][$j-1]->open()["E"]){
                                $add = false;
                            }
                        }
                        if($direction == "E" and $j != $this->Steampunked->getSize()-1 and $game[$i][$j+1] instanceof SteampunkTile){
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
                        if($direction == "S" and $i != $this->Steampunked->getSize()-1 and $game[$i+1][$j] instanceof SteampunkTile){
                            if($game[$i+1][$j]->open()["N"]){
                                $add = false;
                            }
                        }
                        if($direction == "W" and $j !=0 and $game[$i][$j-1] instanceof SteampunkTile){
                            if($game[$i][$j-1]->open()["E"]){
                                $add = false;
                            }
                        }
                        if($direction == "E" and $j != $this->Steampunked->getSize()-1 and $game[$i][$j+1] instanceof SteampunkTile){
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
                            if($direction == "S" and $i != $this->Steampunked->getSize()-1 and $game[$i+1][$j] instanceof SteampunkTile){
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
                            if($direction == "E" and $j != $this->Steampunked->getSize()-1 and $game[$i][$j+1] instanceof SteampunkTile){
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
                    $turn = intval($this->Steampunked->getPlayer()->getPlayerTurn());
                    $this->Steampunked->setGame($i, $j, $item);
                    $this->Steampunked->Findleaks($turn);
                    $this->Steampunked->switchPlayer();
                    $this->Steampunked->updateHand(intval($choice[1]));
                    $tile = new Tiles($site);
                    $tile->addTile(substr($choice[0],6),$i,$j,$this->Steampunked->getId(),$turn);
                    $game = new Games($site);
                    $game->setTurn($this->Steampunked->getId(),3-$turn);
                    $this->Steampunked->setCnt($this->Steampunked->getCnt()+1);*/

                    /*
                    * PHP code to cause a push on a remote client.
                    */
                    /*$msg = json_encode(array('key'=>'Mecks', 'cmd'=>'reload'));
                    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

                    $sock_data = socket_connect($socket, '127.0.0.1', 8078);
                    if(!$sock_data) {
                        echo "Failed to connect";
                    } else {
                        socket_write($socket, $msg, strlen($msg));
                    }
                    socket_close($socket);
                }*/
            }
        } elseif (isset($post['rotate'])) {     //if we want to rotate a button
            if(isset($post['choice'])){
                $split = explode(',', strip_tags($post['choice']));
                $this->Steampunked->getPlayer()->rotateTile(intval($split[1]));
            }
        } elseif(isset($post['discard'])){      //if we want to discard all pipes
            if(isset($post['choice'])){
                $split = explode(',', strip_tags($post['choice']));
                $this->discard(intval($split[1]),$site);
            }

        } elseif(isset($post['open_valve'])){
            $this->open_valve($this->Steampunked->getPlayer()->getPlayerTurn(),$site);
        } elseif(isset($post['give_up']) or isset($_GET['give_up'])){
            $this->give_up($site);
        } elseif(isset($post['back'])) {
            $this->reset = true;
            $this->page = 'index.php';
        } else {
            //
        }
    }

    public function isReset(){
        return $this->reset;
    }

    public function getPage(){
        return $this->page;
    }

    public function discard($pos,$site){
        $game = new Games($site);
        $id = $this->Steampunked->getId();
        $turn = $game->getTurn($id)['turn'];
        if($turn == $this->Steampunked->getPlayerNum()) {
            for ($i = 0; $i < 5; $i++) {
                if ($pos == $i) {
                    $this->Steampunked->updateHand($i);
                }
            }
            $this->Steampunked->switchPlayer();
            $game->setTurn($id,3-$turn);
            $this->reload();
        }
    }

    public function open_valve($player,$site){
        $game = new Games($site);
        $id = $this->Steampunked->getId();
        $winner = $this->Steampunked->findPlayerLeak($player);
        $game->setWinner($id,$winner);
        $this->page = 'win.php';
        $this->reload();
    }

    public function give_up($site){
        $game = new Games($site);
        $id = $this->Steampunked->getId();
        if($this->Steampunked->getPlayerNum() == 1){
            $this->Steampunked->setWinner(2);
            $game->setWinner($id,2);
        } elseif($this->Steampunked->getPlayerNum() == 2){
            $this->Steampunked->setWinner(1);
            $game->setWinner($id,1);
        }
        $this->page = 'win.php';
        $this->reload();
    }

    public function reload(){
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

    public function clearDB($site,$id){
        $game = new Games($site);
        $tile = new Tiles($site);
        $game->clear($id);
        $tile->clear($id);
    }

    private $Steampunked;          // The  object we are controlling
    private $reset = false;         // True if we need to reset the game
    private $page = 'game.php';
}