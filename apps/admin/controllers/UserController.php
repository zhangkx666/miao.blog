<?php

namespace Miao\Admin\Controllers;

use Miao\Common\Models\User;

class UserController extends BaseController
{

    public function indexAction()
    {
        $users = User::find();

        $this->view->users = $users;
    }
}

