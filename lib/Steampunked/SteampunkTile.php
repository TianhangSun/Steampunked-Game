<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 2/28/2016
 * Time: 6:09 PM
 */

namespace Steampunked;


class SteampunkTile
{
    // constructor
    public function __construct($tile_id)
    {
        // Needs to know valid openings
        $this->id = $tile_id;
        $this->changePicture();

    }

    // change the picture and opening
    public function changePicture(){

        // reset the opening to false
        $this->valid_openings["N"] = false;
        $this->valid_openings["E"] = false;
        $this->valid_openings["S"] = false;
        $this->valid_openings["W"] = false;

        // set the picture and opening
        switch ($this->id) {
            case "cap-e.png":
                $this->valid_openings["E"] = true;
                break;
            case "cap-n.png":
                $this->valid_openings["N"] = true;
                break;
            case "cap-s.png":
                $this->valid_openings["S"] = true;
                break;
            case "cap-w.png":
                $this->valid_openings["W"] = true;
                break;
            case "gauge-0.png":
                $this->valid_openings["W"] = true;
                break;
            case "gauge-190.png":
                $this->valid_openings["W"] = true;
                break;
            case "ninety-es.png":
                $this->valid_openings["E"] = true;
                $this->valid_openings["S"] = true;
                break;
            case "ninety-ne.png":
                $this->valid_openings["N"] = true;
                $this->valid_openings["E"] = true;
                break;
            case "ninety-sw.png":
                $this->valid_openings["S"] = true;
                $this->valid_openings["W"] = true;
                break;
            case "ninety-wn.png":
                $this->valid_openings["W"] = true;
                $this->valid_openings["N"] = true;
                break;
            case "straight-h.png":
                $this->valid_openings["E"] = true;
                $this->valid_openings["W"] = true;
                break;
            case "straight-v.png":
                $this->valid_openings["N"] = true;
                $this->valid_openings["S"] = true;
                break;
            case "tee-esw.png":
                $this->valid_openings["E"] = true;
                $this->valid_openings["S"] = true;
                $this->valid_openings["W"] = true;
                break;
            case "tee-nes.png":
                $this->valid_openings["N"] = true;
                $this->valid_openings["E"] = true;
                $this->valid_openings["S"] = true;
                break;
            case "tee-swn.png":
                $this->valid_openings["N"] = true;
                $this->valid_openings["W"] = true;
                $this->valid_openings["S"] = true;
                break;
            case "tee-wne.png":
                $this->valid_openings["W"] = true;
                $this->valid_openings["N"] = true;
                $this->valid_openings["E"] = true;
                break;
            case "valve-open.png":
                $this->valid_openings["E"] = true;
                break;
            case "valve-closed.png":
                $this->valid_openings["E"] = true;
                break;
        }
    }

    public function indicateLeaks() {

        echo "<p>here</p>";
        echo $this->flag;

        if($this->flag) {
            // Already visited
            return array();
        }

        $this->flag = true;

        $open = $this->open();

        foreach(array("N", "W", "S", "E") as $direction) {
            // Are we open in this direction?
            if($open[$direction]) {
                $n = $this->neighbor($direction);
                if($n === null) {
                    // We have a leak in this direction...
                    return "leak";

                } else {
                    // Recurse
                    return $n->indicateLeaks();
                }

            }
        }

    }

    public function neighbor($direction){
        return $this->neighbors_array[$direction];
    }

    public function rotate(){
        switch ($this->id) {
            case "cap-e.png":
                $this->id = "cap-s.png";
                break;
            case "cap-n.png":
                $this->id = "cap-e.png";
                break;
            case "cap-s.png":
                $this->id = "cap-w.png";
                break;
            case "cap-w.png":
                $this->id = "cap-n.png";
                break;
            case "ninety-es.png":
                $this->id = "ninety-sw.png";
                break;
            case "ninety-ne.png":
                $this->id = "ninety-es.png";
                break;
            case "ninety-sw.png":
                $this->id = "ninety-wn.png";
                break;
            case "ninety-wn.png":
                $this->id = "ninety-ne.png";
                break;
            case "straight-h.png":
                $this->id = "straight-v.png";
                break;
            case "straight-v.png":
                $this->id = "straight-h.png";
                break;
            case "tee-esw.png":
                $this->id = "tee-swn.png";
                break;
            case "tee-nes.png":
                $this->id = "tee-esw.png";
                break;
            case "tee-swn.png":
                $this->id = "tee-wne.png";
                break;
            case "tee-wne.png":
                $this->id = "tee-nes.png";
                break;
        }
        $this->changePicture();
    }

    public function addNeighbor($neighbor, $direction){
        $this->neighbors_array[$direction] = $neighbor;
    }

    public function open(){
        return $this->valid_openings;
    }

    public function setOwner($owner){
        $this->owner = $owner;
    }

    public function getOwner(){
        return $this->owner;
    }

    public function getId(){
        return $this->id;
    }

    public function close($direction){
        $this->valid_openings[$direction] = false;
    }

    private $neighbors_array = array("N" => null, "W" => null,
        "S" => null, "E" => null);
    private $valid_openings = array("N" => false, "W" => false,
        "S" => false, "E" => false);

    private $flag = false;      /// has been visited?
    private $id;                /// file name
    private $owner;             /// which player owns it?
}