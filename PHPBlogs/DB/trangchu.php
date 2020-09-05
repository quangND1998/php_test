<?php 

		$id = isset($_GET['id'])? $_GET['id'] :'';
	
		$_SESSION['id'] =$id;
		echo $_SESSION['id'];
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
		$sql ="select * from post";

		$Post = new Post();
		$Posts = $Post->get_list($sql);
		



		// $name =$_GET['name'];
		// $search =$name;
		// $query ="SELECT * FROM post p
		// LEFT JOIN tags t
		// ON t.post_id=p.id
		// WHERE t.tag LIKE '%$search%'";

		
		
		if (isset($_GET['ok'])) {
			$search = addslashes($_GET['search']);
			if (empty($search)) {
				echo "Yeu cau nhap du lieu vao o trong";
			} else {
				$query ="SELECT * FROM post p LEFT JOIN tags t ON t.post_id=p.id WHERE t.tag LIKE '%$search%'";

				$tags =$Post->get_list($query);
				//header("location:trangchu.php?id=$id");
				if(empty($tags)){
					echo "khong tìm thầy kết quả";
				}
			
	
			}
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

							<!-- Nav -->
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
							<li><a href="index.html" class="active">Home</a></li>

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
				


						<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
						  <ol class="carousel-indicators">
						    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
						    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
						    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
						  </ol>
						  <div class="carousel-inner">
						    <div class="carousel-item active">
						      <img class="d-block w-100" src="images/slider-image-1-1920x700.jpg" alt="First slide">
						    </div>
						    <div class="carousel-item">
						      <img class="d-block w-100" src="images/slider-image-2-1920x700.jpg" alt="Second slide">
						    </div>
						    <div class="carousel-item">
						      <img class="d-block w-100" src="images/slider-image-3-1920x700.jpg" alt="Third slide">
						    </div>
						  </div>
						  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
						    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
						    <span class="sr-only">Previous</span>
						  </a>
						  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
						    <span class="carousel-control-next-icon" aria-hidden="true"></span>
						    <span class="sr-only">Next</span>
						  </a>
						</div>

						<br>
						<br>

						<div class="inner">
							<!-- About Us -->
							<!-- Search -->
							<form form action="trangchu.php?id=<?php echo $id ?>$idx=<?php echo $_SESSION['id']; ?>" method="get" class="form-group">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search" aria-label="Search" name="search" aria-describedby="basic-addon2">

									<span class="input-group-addon"> <input type="submit" name="ok" value="search" /></span>
								</div>
							</form>

							<header id="inner">
							<i class="fa fa-tag" aria-hidden="true"></i>

						
								<h1>Write your first blog post now!</h1>
								<p>Etiam quis viverra lorem, in semper lorem. Sed nisl arcu euismod sit amet nisi euismod sed cursus arcu elementum ipsum arcu vivamus quis venenatis orci lorem ipsum et magna feugiat veroeros aliquam. Lorem ipsum dolor sit amet nullam dolore.</p>
							</header>

							<br>

							<h2 class="h2">Latest blog posts</h2>
							<?php if (!empty($tags)) {?>
							<div class="row">

								<?php foreach ($tags as $item){   ?>
								<div class="col-sm-4 text-center">
									<img src=<?php echo $item['image']; ?> class="img-fluid" alt="" />

									<h2 class="m-n"><a href="blog-post.php?id=<?php echo $item['post_id'];  ?>&idx=<?php echo $_SESSION['id']; ?>"><?php  echo $item['content'];?></a></h2>

									<p> John Doe &nbsp;|&nbsp; 12/06/2020 10:30</p>
								</div>
								<?php } ?>			
								
							</div>
						<?php } else { ?>
							
								<div class="row">

								<?php foreach ($Posts as $item){   ?>
									<?php if ($item['display'] ==0){ ?>
								<div class="col-sm-4 text-center">
									<img src=<?php echo $item['image']; ?> class="img-fluid" alt="" />

									<h2 class="m-n"><a href="blog-post.php?id=<?php echo $item['id'];  ?>&idx=<?php echo $id ?>"><?php  echo $item['content'];?></a></h2>

									<p> John Doe &nbsp;|&nbsp; 12/06/2020 10:30</p>
								</div>
									<?php } ?>
								<?php } ?>			
								
							</div>
								<?php } ?>

							<p class="text-center"><a href="blog.html">Read More &nbsp;<i class="fa fa-long-arrow-right"></i></a></p>
						</div>
					</div>

				<!-- Footer -->
					<footer id="footer">
						<div class="inner">
							<section>
								<h2>Contact Us</h2>
								<form method="post" action="#">
									<div class="fields">
										<div class="field half">
											<input type="text" name="name" id="name" placeholder="Name" />
										</div>

										<div class="field half">
											<input type="text" name="email" id="email" placeholder="Email" />
										</div>

										<div class="field">
											<input type="text" name="subject" id="subject" placeholder="Subject" />
										</div>

										<div class="field">
											<textarea name="message" id="message" rows="3" placeholder="Notes"></textarea>
										</div>

										<div class="field text-right">
											<label>&nbsp;</label>

											<ul class="actions">
												<li><input type="submit" value="Send Message" class="primary" /></li>
											</ul>
										</div>
									</div>
								</form>
							</section>
							<section>
								<h2>Contact Info</h2>

								<ul class="alt">
									<li><span class="fa fa-envelope-o"></span> <a href="#">contact@company.com</a></li>
									<li><span class="fa fa-phone"></span> +1 333 4040 5566 </li>
									<li><span class="fa fa-map-pin"></span> 212 Barrington Court New York, ABC 10001 United States of America</li>
								</ul>

								<h2>Follow Us</h2>

								<ul class="icons">
									<li><a href="#" class="icon style2 fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="#" class="icon style2 fa-facebook"><span class="label">Facebook</span></a></li>
									<li><a href="#" class="icon style2 fa-instagram"><span class="label">Instagram</span></a></li>
									<li><a href="#" class="icon style2 fa-linkedin"><span class="label">LinkedIn</span></a></li>
								</ul>
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

<?php 




?>
