<?php
/**
 * Created by PhpStorm.
 * User: Tianhang
 * Date: 16/4/15
 * Time: 下午5:11
 */

namespace Steampunked;


class IndexView extends View
{
    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->setTitle("Index");
        $this->addLink("", "");
    }

    public function getHTML($available){
        $html =<<<HTML
<p><img src="./images/title.png" width="600" height="104" alt="Title"><br>
    <img src="./images/steamsplash2.png" width="415" height="350" alt="Steampunked ScreenShot"></p>

<form method="post" action="game-post.php">
    <fieldset>
        <legend>Enter Player's Name and Select the Playing Area Size to Start!</legend>
HTML;

        foreach($available as $i){
            $html.= "<p>Join Game ".$i['id']." with Player ".$i['name']."  ";
            $html.= "<button type=\"submit\" name=\"go\" value=\"".$i['id']."\">Go!</button></p>";
        }


        $html .=<<<HTML
        <div class="input"><p>
            <label for="player1">Player's Name: </label>
            <input type="text" name="player1" id="player1">
        </p>
        <p>
            <label for="size">Playing Area Size: </label>
            <select name="size" id="size">
                <option value="6">6 By 6</option>
                <option value="10">10 By 10</option>
                <option value="20">20 By 20</option>
            </select>
        </p></div>
        <div class="button"><p>
            <input type="submit" value="New Game!" name="new_game" id = "new_game">
                <a href="instruction.php" class="buttonlink">Instructions</a>
HTML;
        if(!isset($_SESSION['user'])) {
            $html .= <<<HTML
                <a href="Login.php" class="buttonlink">Login</a>
                <a href="user.php" class="buttonlink">New User</a>
        </p></div>
    </fieldset>
</form>
HTML;
        }
        else
        {
$id = $_SESSION['user']->getId();
            $html .= <<<HTML
                <a href="post/logout.php" class="buttonlink">Logout</a>
                <a href="user.php?id=$id" class="buttonlink">Edit User</a>
        </p></div>
    </fieldset>
</form>
HTML;
        }
        return $html;
    }
}