
<?php 


	$id =$_GET['id'];
	//echo $id;
	require './DB_business.php';
	class Post extends DB_business 
	{
		function __construct() 
		{
			// Khai báo tên bảng
			$this->_table_name = 'post';
			
			// Khai báo tên field id
			$this->_key = 'id';
			
			// Gọi hàm khởi tạo cha
			parent::__construct();
		}
	}


	$data= array();
	if( isset($_POST['add_post'])){


		
		$data['content'] = isset($_POST['content']) ? $_POST['content'] : '';
		$data['text'] = isset($_POST['text']) ? $_POST['text'] : '';


		
			
			$name = $_FILES['image']['name'];
			$target_dir = "images/";
			$target_file = $target_dir. basename($_FILES["image"]["name"]);


			// Select file type
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			// Valid file extensions
			$extensions_arr = array("jpg","jpeg","png","gif");

			// Check extension
			if( in_array($imageFileType,$extensions_arr) ){
			
			
				// Upload file
				 move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);
				

			}

		$data['video'] = isset($_POST['video']) ? $_POST['video'] : '';
		
		$data['postcategory_id'] = isset($_POST['postcategory_id']) ? $_POST['postcategory_id'] : '';
		$data['display'] = isset($_POST['display']) ? $_POST['display'] : '';
		 $errors = array();
		// Validate
		if (empty($data['content'])){
			$errors['content'] = 'Ban chua nhap content';
		}
		//echo $data['content'];
		 
		if (empty($data['text'])){
			$errors['text'] = 'Ban chua nhap text';
		}
		 

	
	
		if (empty($data['postcategory_id'])){
			$errors['postcategory_id'] = 'Ban chua nhap postcategory_id';
		}
		 
		
		
			$newpost = new Post();

			$newpost ->add_new(array(
				'content' =>$data['content'],
				'text' =>$data['text'],
				'image'=>$target_file,
				'video'=>$data['video'],
				'user_id'=>$id,
				'postcategory_id'=>$data['postcategory_id'],
				'display' =>$data['display']
			));
			// var_dump($newpost);
			header("Location:blog.php?id=$id");
	

		

		
		
	}
	$id = $_GET['id'];
	$Post = new Post();
	if($id==1){
		$sql = "select  post.id,content,text,image,video,user_id,postcategory_id,postcategory.name from post,users,postcategory where post.user_id = users.id and post.postcategory_id = postcategory.id ";
		$posts = $Post->get_list($sql);
	}
	else{
		$sql ="select post.id,content,text,image,video,user_id,postcategory_id,postcategory.name from post,users,postcategory where post.user_id = users.id and post.postcategory_id = postcategory.id and user_id =$id";
		$posts = $Post->get_list($sql);
		// var_dump($posts);
	
		
	}

	
?>



<!DOCTYPE HTML>
<html>
	<head>
		<title>PHPJabbers.com | Free Blog Website Template</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
		<!-- Wrapper -->

		
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<div class="inner">

							<!-- Logo -->
								<a href="index.html" class="logo">
									<span class="fa fa-pencil"></span> <span class="title">Blog Website</span>
								</a>
							
								<nav>
									<ul>
										<li><a href="#menu">Menu</a></li>
									</ul>
								</nav>
							
						</div>
					</header>

				<!-- Menu -->
					<nav id="menu">
						<h2>Menu</h2>
						<ul>
							<li><a href="index.html">Home</a></li>

							<li><a href="blog.php?id=<?php echo $id; 
                    
                    
                    ?>">Blog</a></li>

							<li><a href="about.html">About</a></li>

							<li><a href="team.html">Authors</a></li>

							<li><a href="contact.html">Contact Us</a></li>
							<?php if( $id ==1){ ?>
								<li><a href="ranking.php">Rankking</a></li>
							<?php } ?>
						</ul>
					</nav>

				<!-- Main -->


			

					<div id="main">

					
						<div class="inner">

						<form method="post" action="blog.php?id=<?php echo $id;?>" enctype="multipart/form-data">
								<div class="form-group">
										<label for="exampleFormControlInput1">Content</label>
										<input type="text" class="form-control" id="exampleFormControlInput1" name='content' >
								</div>

								<div class="form-group">
								<label for="exampleFormControlTextarea1">Text</label>
								<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"   name='text'></textarea>
								</div>
								<div class="form-group">
									<label for="exampleFormControlFile1">Image</label>
									<input type="file" class="form-control-file" id="exampleFormControlFile1"  name="image">
								</div>
								<div class="form-group">
									<label for="exampleFormControlFile1">Video</label>
									<input type="file" class="form-control-file" id="exampleFormControlFile1"  name="video" >
								</div>
								<div class="form-group">
										<label for="exampleFormControlInput1">User_id</label>
										<input type="text" class="form-control" id="exampleFormControlInput1"  name="user_id" value="<?php echo $id;?>">
								</div> 
								
								<div class="form-group">
										<label for="exampleFormControlSelect1">Type</label>
											<select class="form-control" id="exampleFormControlSelect1" name="postcategory_id">
											<option value="1">Lập trình</option>
											<option  value="2">KHoa Học</option>
										
										</select>
								</div>
								<div class="form-group">
										<label for="exampleFormControlSelect1">Type</label>
											<select class="form-control" id="exampleFormControlSelect1" name="display">
											<option value="0">public</option>
											<option  value="1">private</option>
										
										</select>
								</div>
							
								<button type="submit" class="btn btn-primary mb-2" name="add_post">Add Post</button>
							</form>
										<h1>Blog</h1>

										<div class="image main">
											<img src="images/banner-image-3-1920x500.jpg" class="img-fluid" alt="" />
							</div>
							
							<div class="container-fluid">
								<div class="row">
									<div class="col-9">
										<div class="row">
											<div class="col-sm-6 text-center">
												<img src="images/blog-1-720x480.jpg" class="img-fluid" alt="" />

												<h2 class="m-n"><a href="blog-post.html">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a></h2>

												<p> John Doe &nbsp;|&nbsp; 12/06/2020 10:30</p>
											</div>
											<?php foreach ($posts as $item){ ?>
											<div class="col-sm-6 text-center">
												<p style="color:red"><?php  echo $item['name'];?></p>
												<img src=<?php echo $item['image'];?> class="img-fluid" alt="" />
											

												<h2 class="m-n"><a href="blog-post.php?id=<?php echo $item['id']; ?>&idx=<?php echo $id ?>"><?php echo $item['content']; ?></a></h2>

												
											</div> 
											<?php }?>

										</div>
									</div>

									<div class="col-3">
										<div class="form-group">
				                            <h4>Blog Search</h4>
				                        </div>

										<div class="form-group">
				                            <div class="input-group">
				                                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">

				                                <span class="input-group-addon"><a href="#"><i class="fa fa-search"></i></a></span>
				                            </div>
				                        </div>

				                        <br>

				                        <p><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a></p>

				                        <p><a href="#">Non, magni, sequi. Explicabo illum quas debitis ut.</a></p>

				                        <p><a href="#">Vatae expedita deleniti optio ex adipisci . </a></p>

				                        <p><a href="#">Soluta non modi dolorem voluptates dolor laborum.</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>

				<!-- Footer -->
					<footer id="footer">
						<div class="inner">
							<section>
								<ul class="icons">
									<li><a href="#" class="icon style2 fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="#" class="icon style2 fa-facebook"><span class="label">Facebook</span></a></li>
									<li><a href="#" class="icon style2 fa-instagram"><span class="label">Instagram</span></a></li>
									<li><a href="#" class="icon style2 fa-linkedin"><span class="label">LinkedIn</span></a></li>
								</ul>

								&nbsp;
							</section>

							<ul class="copyright">
								<li>Copyright © 2020 Company Name </li>
								<li>Template by: <a href="https://www.phpjabbers.com/">PHPJabbers.com</a></li>
							</ul>
						</div>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>


