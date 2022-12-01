<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function proseslogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password'); 
    
        $db = \Config\Database::connect();
        
        $data_login = $db->query("SELECT * FROM account WHERE email='$email' AND password='$password'");
        $row = $data_login->getRow();

        $account_id = $row->ACCOUNT_ID;

        $data_store = $db->query("SELECT * FROM store WHERE account_account_id='$account_id'");
        $row_store = $data_store->getRow();

        $data_user = $db->query("SELECT * FROM users WHERE account_account_id='$account_id'");
        $row_user = $data_user->getRow();

        //  echo $account_id;
        //  dd($row_user);

        if($row)
        {
            if($row->ROLE == 2)
            {

                session()->set([
                    'name' => $row_user->NAME,
                    'logged_in' => TRUE
                ]);

                return view('home');
            }
            else if($row->ROLE == 1)
            {
                
                session()->set([
                    'name' => $row_store->OWNER,
                    'logged_in' => TRUE
                ]);

                return view('store');
            }
        }
        else 
        {
            return view('login');
        }
        
    }
}
