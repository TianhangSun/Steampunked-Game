<?php
/**
 * Created by PhpStorm.
 * User: Tianhang
 * Date: 16/4/11
 * Time: 上午12:01
 */

namespace Steampunked;


class Tile
{
    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->x = $row['x'];
        $this->y = $row['y'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    private $id;		///< The internal ID for the user
    private $name; 		///< Filename (which include orientation info)
    private $x;         ///< x location in game
    private $y;         ///< y location in game
}