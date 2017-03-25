<?php
namespace Steampunked;

/**
 * Manage users in our system.
 */
class Users extends Table
{

    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site)
    {
        parent::__construct($site, "user");
    }


    /**
     * Test for a valid login.
     * @param $email User email
     * @param $password Password credential
     * @returns User object if successful, null otherwise.
     */
    public function login($email, $password)
    {
        $sql = <<<SQL
SELECT * from $this->tableName
where email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        if ($statement->rowCount() === 0) {
            return null;
        }

        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        // Get the encrypted password and salt from the record
        $hash = $row['password'];
        $salt = $row['salt'];

        // Ensure it is correct
        if ($hash !== hash("sha256", $password . $salt)) {
           return null;
        }
        return new User($row);
    }

    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @returns User object if successful, null otherwise.
     */
    public function get($id)
    {
        $sql = <<<SQL
SELECT * from $this->tableName
where id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if ($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(\PDO::FETCH_ASSOC));
    }
    /*
    public function getValidator($id)
    {
        $users = new Users($this->site);
        $usersTable = $users->getTableName();
        $sql = <<<SQL
SELECT validator.userid, id from $this->tableName
LEFT JOIN $usersTable validator ON id = validator.userid
where  $usersTable validator.validator=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if ($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(\PDO::FETCH_ASSOC));
    }
    */
/*
    public function getClients()
    {
        $sql = <<<SQL
SELECT id, name FROM $this->tableName WHERE role="C"
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute();
        if ($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

*/
    public function getUsers()
    {

        $users = new Users($this->site);
        $usersTable = $users->getTableName();

        $sql = <<<SQL
    SELECT * FROM $this->tableName
SQL;
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute();

        $User = array();
        foreach ($stmt as $row) {
            $User[] = new User($row);
        }

        return $User;

    }


    /**
     * Modify a user record based on the contents of a User object
     * @param User $user User object for object with modified data
     * @return true if successful, false if failed or user does not exist
     */
    public function update(User $user)
    {
        if ($this->get($user->getId()) == null) {
            return false;
        }
        $sql = <<<SQL
UPDATE $this->tableName SET  email = ?,
  name = ?, role = ?
 WHERE id= ?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        try {
            $statement->execute(array( $user->getEmail(), $user->getName(), $user->getRole(), $user->getId()));
        } catch (\PDOException $e) {
            return false;
        }
        return true;
    }

    public function delete($id)
    {
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE id=?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);


        try {
            if ($statement->execute(array($id)) === false) {
                return null;
            }

        } catch (\PDOException $e) {
            return null;
        }

        return $pdo->lastInsertId();
    }

    /**
     * Determine if a user exists in the system.
     * @param $email An email address.
     * @returns true if $email is an existing email address
     */
    public function exists($email)
    {
        $sql = <<<SQL
SELECT email FROM $this->tableName WHERE email = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        if ($statement->rowCount() === 0) {
            return false;
        }

        return true;
    }

    public function other_exist($email, $id)
    {
        $sql = <<<SQL
SELECT email FROM $this->tableName WHERE email = ? and id!=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email, $id));
        if ($statement->rowCount() === 0) {
            return false;
        }

        return true;
    }

    /**
     * Create a new user.
     * @param User $user The new user data
     * @param Email $mailer An Email object to use
     * @return null on success or error message if failure
     */
    public function add(User $user, Email $mailer)
    {
        // Ensure we have no duplicate email address
        // Ensure we have no duplicate email address
        if ($this->exists($user->getEmail())) {
            return "Email address already exists.";
        }
        // Add a record to the user table
        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(email, name, role)
values(?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array(
            $user->getEmail(), $user->getName(), $user->getRole()));
        $id = $this->pdo()->lastInsertId();
        // Create a validator and add to the validator table
        // Create a validator and add to the validator table
        $validators = new Validators($this->site);
        $validator = $validators->newValidator($id);
        // Send email with the validator in it
        // Send email with the validator in it
        $link = "http://webdev.cse.msu.edu" . $this->site->getRoot() .
            '/password-validate.php?v=' . $validator;

        $from = $this->site->getEmail();
        $name = $user->getName();

        $subject = "Confirm your email";
        $message = <<<MSG
<html>
<p>Greetings, $name,</p>

<p>Welcome to Felis. In order to complete your registration,
please verify your email address by visiting the following link:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
        $mailer->mail($user->getEmail(), $subject, $message, $headers);
        return $id;
    }

    /**
     * Set the password for a user
     * @param $userid The ID for the user
     * @param $password New password to set
     */
    public function setPassword($userid, $password)
    {

        $salt = $this->randomSalt(16);
        $hash = hash("sha256", $password . $salt);
        $this->salt = $salt;
        $sql = <<<SQL
update $this->tableName SET password = ?, salt = ?
 WHERE id= ?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if ($statement->execute(array($hash, $salt, $userid)) === false) {
                return null;
            }
        } catch (\PDOException $e) {
            return null;
        }

        return $pdo->lastInsertId();

    }

    /**
     * Generate a random salt string of characters for password salting
     * @param $len Length to generate, default is 16
     * @returns Salt string
     */
    public static function randomSalt($len = 16)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()-=_+';
        $l = strlen($chars) - 1;
        $str = '';
        for ($i = 0; $i < $len; ++$i) {
            $str .= $chars[rand(0, $l)];
        }
        return $str;
    }


    public function emailer($email, Email $mailer)
    {
        $sql = <<<SQL
SELECT * from $this->tableName
where email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($email));
        if ($statement->rowCount() === 0) {
            return null;
        }

        $user= new User($statement->fetch(\PDO::FETCH_ASSOC));
        // Ensure we have no duplicate email address
        // Ensure we have no duplicate email address
        if ($this->exists(!($user->getEmail()))) {
            return "Email Does Not exist!";
        }
        // Add a record to the user table
        $id = $user->getId();
        // Create a validator and add to the validator table
        // Create a validator and add to the validator table
        $validators = new Validators($this->site);
        $validator = $validators->newValidator($id);
        // Send email with the validator in it
        // Send email with the validator in it
        $link = "http://webdev.cse.msu.edu" . $this->site->getRoot() .
            '/password-validate.php?v=' . $validator;

        $from = $this->site->getEmail();
        $name = $user->getName();

        $subject = "Password Recovery";
        $message = <<<MSG
<html>
<p>Greetings, $name,</p>

<p>To create a new password, click the link below:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
        $mailer->mail($user->getEmail(), $subject, $message, $headers);
        return $id;
    }

    private $salt;
}