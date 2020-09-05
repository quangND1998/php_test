<?php 
        require './DB_business.php';
    
        class User extends DB_business 
        {
            function __construct() 
            {
                // Khai báo tên bảng
                $this->_table_name = 'users';
                
                // Khai báo tên field id
                $this->_key = 'id';
                $this->_username ='username';

                 $this->_password ='password';
                // Gọi hàm khởi tạo cha
                parent::__construct();
            }
        }
    
        

        function filterName($field){
            // Sanitize user name
            $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
            
            // Validate user name
            if(filter_var($field, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^([a-zA-Z0-9ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{10,25}+)$/i")))){
                return $field;
            } else{
                return FALSE;
            }
        } 
        if(isset($_POST['do-login'])){


            $username = addslashes( $_POST['username']);       
            $password = addslashes( $_POST['password']);
            if (!$username || !$password) {
                echo "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu. <a href='javascript: history.go(-1)'>Trở lại</a>";
                exit;
            }
            $newUser= new User();
            $password= md5($password);
            
            $newUser->login($username,$password);
            //var_dump($newUser->login($username,$password));

            //echo($_SESSION['user_id']['id']);


        //     unset($_SESSION['user_id']);
  
        // // Xóa hết session
        //     session_destroy();'

               $id= $_SESSION['user_id'] =$newUser->login($username,$password)['id'];

            if( $newUser->login($username,$password)){
                echo '<script language="javascript">alert("Đăng nhập thành công"); window.location="dangnhap.php";</script>';
                header("location:trangchu.php?id=$id");
            }
            else {
                echo '<script language="javascript">alert("Có lỗi trong quá trình xử lý"); window.location="dangnhap.php";</script>';
            }

            
           


        }



        







?>


<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="demo.css">
    
    
    </head>
    <body>
    


     
<form method="post" action="dangnhap.php">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sign in to continue to Bootsnipp</h1>
            <div class="account-wall">
                <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
                    alt="">
                <form class="form-signin">
                <input type="text"
                         class="form-control" 
                         placeholder="Name" required autofocus
                        name="username">
           
                <input type="password" 
                        class="form-control" 
                        placeholder="Password" required
                       name ='password'>
                
                
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="do-login">
                    Sign in</button>
                <label class="checkbox pull-left">
                    <input type="checkbox" value="remember-me">
                    Remember me
                </label>
                <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                </form>
            </div>
            <a href='register.php' class="text-center new-account">Create an account </a>
           
          
     
        </div>
    </div>
</form>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>

