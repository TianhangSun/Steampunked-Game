<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 4/11/2016
 * Time: 5:15 PM
 */

namespace Steampunked;


class NewUserController
{
    public function __construct(Site $site, array $post) {

        $users = new Users($site);
        $root = $site->getRoot();
        $add = strip_tags($post['add']);
        $id = strip_tags($post['id']);

if($id ==null)
{
    $id =0;
}
        $name = strip_tags($post['name']);
        $email = strip_tags($post['email']);
        $role = strip_tags($post['role']);

        $row = array('id' => $id,
            'email' => $email,
            'name' => $name,
            'password' => null,
            'role' => $role
        );
        $user = new User($row);

        if($add === 'OK' && $id!=null)
        {
            $exist= $users->other_exist($email,$id);
            $update = $users->update($user);
            if ($update == null || $exist == 1) {
                $this->redirect = "$root/users.php?e";
            } else {
                $this->redirect = "$root/user.php?id=" .$id;
            }


        }
        else
        {
            $this->redirect = "$root/users.php";
        }
        if($id == 0) {

            // This is a new user
            $mailer = new Email();
            if($add=='OK') {
                $checker = $users->exists($email);
                if($checker== false) {


                    $insert = $users->add($user, $mailer);
                    if ($insert === null) {
                        $this->redirect = "$root/user.php?e";
                    } else {
                        $this->redirect = "$root/user.php?id=" . $insert;
                    }
                }
                else
                {
                    $this->redirect = "$root/user.php?e2";
                }
            }
            else{
                $this->redirect = "$root/users.php";
            }
        }
        if(isset($post['cancel']))
        {
            $this->redirect = "$root/users.php";
        }
    }
    /**
     * @return mixed
     */
    public function getRedirect() {
        return $this->redirect;
    }


    private $redirect;	///< Page we will redirect the user to.

}