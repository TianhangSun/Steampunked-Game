<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 4/11/2016
 * Time: 9:08 PM
 */

namespace Steampunked;


class UsersController
{
    public function __construct(Site $site, array $post) {
        $users = new Users($site);

        $add = strip_tags($post['add']);
        $id = strip_tags($post['id']);
        if($id == null)
        {
            $id =0;
        }
        $delete = strip_tags($post['delete']);
        $root = $site->getRoot();

        if ($add === 'Add' && $id ==0) {
            // Login failed
            $this->redirect = "$root/user.php";
        }
        else {
            $this->redirect = "$root/users.php?e";
        }
        if($delete === 'Delete' && $id != null)
        {
            $this->redirect="$root/delete-user.php?id=".$id;

        }




    }
    public function getRedirect()
    {
        return $this->redirect;
    }

    private $redirect;	///< Page we will redirect the user to.

}