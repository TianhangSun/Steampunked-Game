<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 4/11/2016
 * Time: 2:21 PM
 */

namespace Steampunked;



class LostPasswordController
{
    public function __construct(Site $site, array $post)
    {
        $root = $site->getRoot();

        // 1. Ensure the validator is correct! Use it to get the user ID.
        // 2. Destroy the validator record so it can't be used again!
        //
        $users = new Users($site);
        $email = strip_tags($post['email']);
        $mailer = new Email();
        $update = $users->emailer($email,$mailer);
        if ($update == null) {
            $this->redirect = "$root?e";
        } else {
            $this->redirect = "$root";
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