<?php

namespace App\Controllers;

class Register extends BaseController
{
    public function user()
    {
        $db = \Config\Database::connect();
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password'); 

        $query = $db->query("INSERT INTO account (EMAIL,PASSWORD,ROLE) VALUES ('$email','$password',2)");

        return view('login');
    }

    public function store()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password'); 
        
        $data_login = $db->query("SELECT * FROM account WHERE email='$email' AND password='$password'");
        $row = $data_login->getRow();

        if($row)
        {
            //dd($row);
            session()->set([
                'username' => $row->EMAIL,
                'logged_in' => TRUE
            ]);
            if($row->ROLE == 2)
            {
                return view('home');
            }
            else if($row->ROLE == 1)
            {
                return view('store');
            }
        }
        else 
        {
            return view('login');
        }
        
    }
}
