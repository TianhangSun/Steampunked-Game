<?php
/**
 * Created by PhpStorm.
 * User: Joshua Christ
 * Date: 2/18/2016
 * Time: 2:43 AM
 */

namespace Steampunked;


class SteampunkedView
{
    public function __construct(Steampunked $Steampunked, $site){  //Steampuncked $Steampuncked, $post) {
        $this->Steampunked = $Steampunked;
        $this->game = new Games($site);
        $this->wait = $this->Steampunked->getWait();
        $id = $Steampunked->getId();
        $names = $this->game->getName($id);
        $this->Steampunked->setPlayerName($names['name'],$names['name2']);
        $turn = $this->game->getTurn($id);
        $playerNum = $Steampunked->getPlayerNum();
        if($turn['turn'] == $playerNum){
            $this->wait = false;
            $this->Steampunked->setWait(false);
            $tile = new Tiles($site);
            $cnt = $tile->getTileNum($id, 3-$playerNum)['count(owner)'];
            if($cnt!=0){
                $t = $tile->getTile($id);
                $tmp = "array(".$t['name'].",".(3-$playerNum).")";
                $choice = explode(',', strip_tags($tmp));
                $Steampunked->addTile($t['x'],$t['y'],$choice,$site, 3-$playerNum);
            }
            if($playerNum != $Steampunked->getPlayer()->getPlayerTurn()){
                $Steampunked->switchPlayer();
            }
        } else{
            $this->wait = true;
            $this->Steampunked->setWait(true);
        }
        $winner = $this->game->getWinner($id)['winner'];
        if($winner != 0){
            $this->Steampunked->setWinner($winner);
            header("location: win.php");
            exit;
        }
    }

    public function getHtml() {
        $player = $this->Steampunked->getPlayer()->getPlayerTurn();

        $html = '<form method="post" action="game-post.php"><div class="game">';
        for($i=0; $i<$this->Steampunked->getSize(); $i++){
            $html.='<div class="row">';
            for($j=0; $j<$this->Steampunked->getSize(); $j++){
                if($this->Steampunked->getGame()[$i][$j] == ""){
                    $html.='<div class="cell"></div>';
                } elseif($this->Steampunked->getGame()[$i][$j] == "leak"){
                    $disable = "";
                    if($this->wait == true){
                        $disable = "disabled tag='d'";
                    }
                    $game = $this->Steampunked->getGame();
                    if($j!= 0 and $game[$i][$j-1] instanceof SteampunkTile and $game[$i][$j-1]->open()["E"]) {
                        if($game[$i][$j-1]->getOwner() == 3 - $player)  $disable = "disabled tag='d'";
                        $html .= "<div class=\"cell\"><input type=\"submit\" name=\"leak\" id=\"leakW\" value=\"$i, $j\" $disable></div>";
                    } elseif($j != $this->Steampunked->getSize()-1 and $game[$i][$j+1] instanceof SteampunkTile and $game[$i][$j+1]->open()["W"]) {
                        if($game[$i][$j+1]->getOwner() == 3 - $player)  $disable = "disabled tag='d'";
                        $html .= "<div class=\"cell\"><input type=\"submit\" name=\"leak\" id=\"leakE\" value=\"$i, $j\" $disable></div>";
                    } elseif($i != 0 and $game[$i-1][$j] instanceof SteampunkTile and $game[$i-1][$j]->open()["S"]) {
                        if($game[$i-1][$j]->getOwner() == 3 - $player)  $disable = "disabled tag='d'";
                        $html .= "<div class=\"cell\"><input type=\"submit\" name=\"leak\" id=\"leakN\" value=\"$i, $j\" $disable></div>";
                    } elseif($i != $this->Steampunked->getSize()-1 and $game[$i+1][$j] instanceof SteampunkTile and $game[$i+1][$j]->open()["N"]) {
                        if($game[$i+1][$j]->getOwner() == 3 - $player)  $disable = "disabled tag='d'";
                        $html .= "<div class=\"cell\"><input type=\"submit\" name=\"leak\" id=\"leakS\" value=\"$i, $j\" $disable></div>";
                    }
                } elseif($this->Steampunked->getGame()[$i][$j] instanceof SteampunkTile){
                    $type = $this->Steampunked->getGame()[$i][$j]->getId();
                    $html.="<div class='cell' name =".$type."></div>";

                }
            }

            $html.='</div>';
        }
        $html.="</div>";
        if($this->wait == true){
            $html.="<p class = 'info'>Waiting for the other player!</p>";
        }
        //display the player information
        $playerName = $this->Steampunked->getPlayer()->getPlayerName();
        $html.="<p class = 'info'>Player $player : $playerName's turn! </p>";

        //diaplay control buttons
        $html.= <<<HTML
<fieldset>
        <legend>Controls</legend>
HTML;
        $playerNum = $this->Steampunked->getPlayerNum();
        $pipes = $this->Steampunked->getPlayer()->getPipes($playerNum);
        $pos = $this->Steampunked->getPlayer()->getPosition();
        $checked="";
        $i = 0;
        foreach($pipes as $pipe){
            if($i == $pos) {
                $checked = "checked";
            } else{
                $checked = "";
            }
            $name = $pipe->getId();
            $html.="<div class = 'choice' name =".$name.">";
            $html.="<input type=\"radio\" name=\"choice\" $checked value=array($name,$i)></div>";
            $i++;
        }

        $html.=<<<HTML
<div class="button"><p>
            <input type="submit" value="Rotate" name="rotate" id = "rotate" >
            <input type="submit" value="Discard" name="discard" id = "discard">
            <input type="submit" value="Open Valve" name="open_valve" id = "open_valve">
            <input type="submit" value="Give Up" name="give_up" id = "give_up">
        </p></div>
    </fieldset>
HTML;

        $html.="</form>";
        return $html;
    }

    public function getWinner(){
        $winner = $this->Steampunked->getWinner();

            $name = $this->Steampunked->getWinnerName($winner);

            $html = "<p class=\"win\">Player ";
            $html .= $winner;
            $html .= ": ";
            $html .= $name;
            $html .= " Wins the Game!</p>";

            return $html;
    }

    public function head(){
        $html =<<<HTML
<link href="lib/css/main-css.less" type="text/css" rel="stylesheet" />
<meta charset="UTF-8">
<title>Steampunked</title>
<script>
    /**
     * Initialize monitoring for a server push command.
     * @param key Key we will receive.
     */
    function pushInit(key) {
        var conn = new WebSocket('ws://webdev.cse.msu.edu:8079');
        conn.onopen = function (e) {
            console.log("Connection to push established!");
            conn.send(key);
        };

        conn.onmessage = function (e) {
            try {
                var msg = JSON.parse(e.data);
                if (msg.cmd === "reload") {
                    location.reload();
                }
            } catch (e) {
            }
        };
    }

    pushInit("Mecks");
</script>
HTML;

        return $html;
    }

    private $Steampunked;  //stored model class
    private $game;
    private $wait;
}