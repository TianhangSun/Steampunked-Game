<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 4/11/2016
 * Time: 1:26 PM
 */

namespace Steampunked;



class LoginController
{
    /**
     * LoginController constructor.
     * @param Site $site The Site object
     * @param array $session $_SESSION
     * @param assay $post $_POST
     */
    public function __construct(Site $site, array &$session, array $post) {
        // Create a Users object to access the table
        $users = new Users($site);
        $email = strip_tags($post['email']);
        $password = strip_tags($post['password']);
        $user = $users->login($email, $password);
        $session[User::SESSION_NAME] = $user;
        $root = $site->getRoot();
        if($user === null) {
            // Login failed
            $this->redirect = "$root/Login.php?e";
        } else {
            if($user->isGamer()) {
                $this->redirect = "$root/index.php";
            } else {
                $this->redirect = "$root/instruction.php";
            }
        }

    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    private $redirect;	///< Page we will redirect the user to.

}