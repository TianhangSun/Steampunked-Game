<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 4/11/2016
 * Time: 2:19 PM
 */

namespace Steampunked;



class PasswordValidateController
{
    public function __construct(Site $site, array $post) {
      $root = $site->getRoot();

        // 1. Ensure the validator is correct! Use it to get the user ID.
        // 2. Destroy the validator record so it can't be used again!
        //
        $validators = new Validators($site);
        $userid = $validators->getOnce($post['validator']);
     //   $v = strip_tags($post['v']);
        $add = strip_tags($post['add']);

        $users = new Users($site);

        $editUser = $users->get($userid);

        $email = trim(strip_tags($post['email']));

        $password1 = trim(strip_tags($post['password']));
        $password2 = trim(strip_tags($post['password2']));
        if($password1 !== $password2) {
            // Passwords do not match
          $this->redirect = "$root/password-validate.php?e2";
           return;
        }
        if($password2=="")
        {
            // Passwords do not match
           $this->redirect = "$root/password-validate.php?e2";
            return;
        }

        if(strlen($password1) < 8  && $add=='OK') {
            // Password too short
           $this->redirect = "$root/password-validate.php?e3";
            return;
        }
        if( isset($_POST['cancel']) ) {
            $cancel = strip_tags($post['cancel']);
            if ($cancel === 'Cancel') {
             $this->redirect = "$root";
              return;
            }
        }
        $users->setPassword($userid, $password1);
        $userid = $validators->getOnce($post['validator']);
        $this->redirect = "$root";
        return;
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