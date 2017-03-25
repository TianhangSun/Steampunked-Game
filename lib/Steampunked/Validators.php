<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 3/31/2016
 * Time: 5:13 PM
 */

namespace Steampunked;


class Validators extends Table
{
    public function __construct(Site $site)
    {
        parent::__construct($site,"validator");
    }
    /**
     * Create a new validator and add it to the table.
     * @param $userid User this validator is for.
     * @return The new validator.
     */
    public function newValidator($userid) {
        $validator = $this->createValidator();

        // Write to the table
        $sql=<<<SQL
insert into $this->tableName(userid,validator)values(?, ? )
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if($statement->execute(array($userid, $validator)) === false) {
                return null;
            }
        } catch(\PDOException $e) {
            return null;
        }

        return $validator;
    }
    /**
     * @brief Generate a random validator string of characters
     * @param $len Length to generate, default is 32
     * @returns Validator string
     */
    private function createValidator($len = 32) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $l = strlen($chars) - 1;
        $str = '';
        for ($i = 0; $i < $len; ++$i) {
            $str .= $chars[rand(0, $l)];
        }
        return $str;
    }
    /**
     * Determine if a validator is valid. If it is,
     * get the user ID for that validator. Then destroy any
     * validator records for that user ID. Return the
     * user ID.
     * @param $validator Validator to look up
     * @return User ID or null if not found.
     */
    public function getOnce($validator)
    {
        $sql2 = <<<SQL
DELETE FROM $this->tableName WHERE userid=?
SQL;
        $pdo2 = $this->pdo();
        $statement2 = $pdo2->prepare($sql2);


        try {
            if ($statement2->execute(array($this->hello)) === false) {
                return null;
            }
        } catch (\PDOException $e) {
            return null;
        }
        $sql = <<<SQL
SELECT userid FROM $this->tableName WHERE validator=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($validator));
        if ($statement->rowCount() === 0) {
            return null;
        }
        $user = $statement->fetch(\PDO::FETCH_ASSOC);
        $x= $user['userid'];
        $this->hello = $user['userid'];

        return $this->gethello();
    }
    public function gethello()
    {
        return $this->hello;
    }


    private $hello;

}