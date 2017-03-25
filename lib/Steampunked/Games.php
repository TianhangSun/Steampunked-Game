<?php
/**
 * Created by PhpStorm.
 * User: Tianhang
 * Date: 16/4/11
 * Time: 下午2:52
 */

namespace Steampunked;


class Games extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Game");
    }

    /**
     * Database connection function
     * @returns PDO object that connects to the database
     */
    public function pdo() {
        return $this->site->pdo();
    }

    public function createGame($player1,$player2,$size) {
        $sql =<<<SQL
insert into $this->tableName (name,name2,turn,available,size,winner)
values(?,?,0,1,?,0);
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($player1,$player2,$size));
        if($statement->rowCount() === 0) {
            return null;
        }

        //$statement->fetch(\PDO::FETCH_ASSOC);
        return true;
    }

    public function setWinner($id,$winner){
        $sql =<<<SQL
update $this->tableName
set winner = ?
where id = ?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($winner, $id));
        if($statement->rowCount() === 0) {
            return null;
        }

        //$statement->fetch(\PDO::FETCH_ASSOC);
        return true;
    }

    public function getWinner($id){
        $sql =<<<SQL
select winner,name,size,turn from $this->tableName
where id=?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function getSize($id){
        $sql =<<<SQL
select size from $this->tableName
where id = ?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function getName($id){
        $sql =<<<SQL
select name,name2 from $this->tableName
where id = ?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function setName2($name2,$id){
        $sql =<<<SQL
update $this->tableName
set name2 = ?
where id = ?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($name2,$id));
        if($statement->rowCount() === 0) {
            return false;
        }

        //$statement->fetch(\PDO::FETCH_ASSOC);
        return true;
    }

    public function setTurn($id,$turn){
        $sql =<<<SQL
update $this->tableName
set turn = ?
where id = ?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($turn, $id));
        if($statement->rowCount() === 0) {
            return null;
        }

        //$statement->fetch(\PDO::FETCH_ASSOC);
        return true;
    }

    public function getTurn($id){
        $sql =<<<SQL
select turn from $this->tableName
where id = ?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function hide($id){
        $sql =<<<SQL
update $this->tableName
set available = 0
where id = ?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        //$statement->fetch(\PDO::FETCH_ASSOC);
        return true;
    }

    public function getId(){
        $sql =<<<SQL
select id from $this->tableName
order by id desc
limit 1;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute();
        if($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function available(){
        $sql =<<<SQL
select * from $this->tableName
where available = 1;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute();
        if($statement->rowCount() === 0) {
            return array();
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function clear($id){
        $sql =<<<SQL
delete from $this->tableName
where id = ?;
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