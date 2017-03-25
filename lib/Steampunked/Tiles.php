<?php
/**
 * Created by PhpStorm.
 * User: Tianhang
 * Date: 16/4/10
 * Time: 下午11:57
 */

namespace Steampunked;


class Tiles extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Tile");
    }

    /**
     * Database connection function
     * @returns PDO object that connects to the database
     */
    public function pdo() {
        return $this->site->pdo();
    }

    public function getTile($gameId) {
        $sql =<<<SQL
select id, name, x, y
from $this->tableName
order by id desc
limit 1;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($gameId));
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function addTile($name, $x, $y, $game, $owner){
        $sql =<<<SQL
insert into $this->tableName (name,x,y,gameid,owner)
values(?,?,?,?,?);
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($name,$x,$y,$game,$owner));
        if($statement->rowCount() === 0) {
            return null;
        }

        //$statement->fetch(\PDO::FETCH_ASSOC);
        return true;
    }

    public function getTileNum($id, $player){
        $sql =<<<SQL
select count(owner) from $this->tableName
where gameid=? and owner=?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id,$player));
        if($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function clear($id){
        $sql =<<<SQL
delete from $this->tableName
where gameid = ?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return false;
        }

        //$statement->fetchAll(\PDO::FETCH_ASSOC);
        return true;
    }

}