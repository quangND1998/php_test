<?php 

    class User {

        private $username;
        private $password;
        public $role;


        function getUserName(){
            return $this->username;
        }
        function setUserName($username){
             $this->username =$username;  
        }
        function getPassword(){
            return $this->password;
        }
        function setPassword($password){
            $this->password = md5($password);  
        }

    
        // function __construct($username,$password,$role)
        // {
        //     $this->username = $username;
        //     $this->password = $password;
        //     $this->role = $role;
           
        // }


        
        


    }

    // $newpost = new User();
    // var_dump($newpost)
    // $newpost->use
    // echo $newpost->getUser_id();
    


?>