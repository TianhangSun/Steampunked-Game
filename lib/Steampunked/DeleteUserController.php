<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 4/14/2016
 * Time: 7:27 PM
 */

namespace Steampunked;


class DeleteUserController
{

    /**
     * LoginController constructor.
     * @param Site $site The Site object
     * @param array $session $_SESSION
     * @param assay $post $_POST
     */
    public function __construct(Site $site, array $post) {
        // Create a Users object to access the table
        $users = new Users($site);

        $id = strip_tags($post['id']);
        $delete = strip_tags($post['Yes']);
        $root = $site->getRoot();



        if($delete == 'Yes' && $id != null)
        {
            $data =  $users->delete($id);
            if($data == null) {
                $this->redirect = "$root/delete-user.php?e";
            } else {
                $this->redirect = "$root/users.php";
            }

        }
        else
        {
            $this->redirect = "$root/delete-user.php?e";
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