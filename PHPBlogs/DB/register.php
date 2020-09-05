
<?php 
        require './DB_business.php';
        
        // Lớp khách hàng
        class User extends DB_business 
        {
            function __construct() 
            {
                // Khai báo tên bảng
                $this->_table_name = 'users';
                
                // Khai báo tên field id
                $this->_key = 'id';
                
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



    header('Content-Type: text/html; charset=utf-8');
    if( isset($_POST['do-register'])){

        $errors = array();


        if(empty($_POST['username'])){
            $errors['name'] ="Mời nhập tên đăng ky";
        }
        else{
            $username =filterName($_POST['username']);
            if($username== FALSE){
                $errors['name'] ="Nhập 10 đến 25 kí tự";
            }
            
        }
        
        if(empty($_POST['password'])){
            $errors['password'] ="Moi nhap password";
        }
         if(!empty($_POST["password"]) && ($_POST["password"] == $_POST["cpassword"])) {
      
            $password =$_POST['password'];
           
            if (strlen($_POST["password"]) <= '8') {
                $errors['password'] = "Your Password Must Contain At Least 8 Characters!";
            }
            elseif(!preg_match("#[0-9]+#",$password)) {
                $errors['password'] = "Your Password Must Contain At Least 1 Number!";
            }
            elseif(!preg_match("#[A-Z]+#",$password)) {
                $errors['password'] = "Your Password Must Contain At Least 1 Capital Letter!";
            }
            elseif(!preg_match("#[a-z]+#",$password)) {
                $errors['password'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
            }
        }
      
        $role  = isset($_POST['role']) ? (int)$_POST['role'] : '';

      
        $conn = mysqli_connect('localhost','root','','blog');
        mysqli_set_charset($conn, "utf8");

        // Kiểm tra username hoặc email có bị trùng hay không
        $sql = "SELECT * FROM users where username='$username'";

        $result = mysqli_query($conn,$sql);

        
        //da co ussername trong csdl
        if(mysqli_num_rows($result)>0){

            echo '<script language="javascript">alert("Thông tin đăng nhập bị sai"); window.location="register.php";</script>';
          
        // Dừng chương trình
            die ();
        }

        var_dump($errors);
        if(!$errors){
            $newuser = new User();
            $newuser->add_new(array(
                'username' => $username,
                'password' => md5($password),
                'role' => $role
            ));
   
                echo '<script language="javascript">alert("Đăng ký thành công"); window.location="register.php";</script>';
                header("location:trangchu.php");
            }
            else {
                echo '<script language="javascript">alert("Có lỗi trong quá trình xử lý"); window.location="register.php";</script>';
            }
        }




?>



<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="demo.css">
    </head>
    <body>

        <form method="post" action="register.php">
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
                                name="username" value="<?php echo !empty($username) ? $username : ''; ?>"/>
                        <?php if (!empty($errors['name'])) echo $errors['name']; ?>
                
                        <input type="password" 
                                class="form-control" 
                                placeholder="Password" required
                            name ='password'value="<?php echo !empty($password) ? $password : ''; ?>"/>
                        <?php if (!empty($errors['password'])) echo $errors['password']; ?>

                        <input type="password" 
                                class="form-control" 
                                placeholder="Password" required
                            name ='cpassword'/>
                  
                        <select id="inputState" class="form-control" name="role">
                            <option value="1" >Thanh Vien</option>
                        
                        </select>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="do-register">
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