<?php 

			require './DB_business.php';
			$id =$_GET['id'];
			// echo $id;
			// idx la id của thằng user xem post
			$idx =$_GET['idx'];
			// echo $idx;

			class Comment extends DB_business 
			{
				function __construct() 
				{
					// Khai báo tên bảng
					$this->_table_name = 'comment';
					
					// Khai báo tên field id
					$this->_key = 'id';
					
					// Gọi hàm khởi tạo cha
					parent::__construct();
				}
			}
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

			$post = new Post();


			$post_id = $post->select_by_id('*',$id);
			// echo $post_id['user_id'];

			if(isset($_POST['edit_post']) && !empty($post_id)){
				
				$data['content']    = isset($_POST['content']) ? $_POST['content'] :
				$errors = array();
		
				$data['text'] = isset($_POST['text']) ? $_POST['text'] :'';
				$data['display'] = isset($_POST['display']) ? $_POST['display'] :'';


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
					// echo $file;
	
				}

				if (empty($data['content'])){
					$errors['content'] = 'Ban chua nhap content';
				}
				//echo $data['content'];
				 
				if (empty($data['text'])){
					$errors['text'] = 'Ban chua nhap text';
				}
				
				
					$post->update_by_id(array(
						'content' =>$data['content'],
						'text' =>$data['text'],
						'image'=>$target_file,
						'display'=>$data['display']
					),$id);
			
					
					header("Location:blog-post.php?id=$id&idx=$idx");
			}

			$sql="SELECT comment.content ,username,post_comment_id FROM comment,users,post WHERE comment.user_post_id = users.id and comment.post_comment_id = post.id  and post_comment_id =$id";
			$comment = new Comment;
			$comments= $comment->get_list($sql);
			// var_dump($comments);
			
			///add comment

			$add_comment= array();
			
			if( isset($_POST['add_comment'])){	
				$add_comment['message'] = isset($_POST['message']) ? $_POST['message'] : '';
				$add_comment['post_id'] =$id;
				$add_comment['user_id']= $post_id['user_id'];
		
				$comment = new Comment();
	
				$comment ->add_new(array(
					'content' =>$add_comment['message'],
					'post_comment_id'=>$id,
					'user_post_id'=>$idx
				));
				// var_dump($newpost);
				header("Location:blog-post.php?id=$id&idx=$idx");
				
			}

			
?>
<!-- thong ke cac user co bai viet -->
<!-- SELECT users.id, users.username  FROM users INNER JOIN  post  ON users.id = post.user_id GROUP BY users.id -->

<!-- SELECT users.id, users.username, COUNT(post.id) as number FROM users INNER JOIN  post  ON users.id = post.user_id GROUP BY users.id ORDER BY number DESC -->



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
							<li><a href="index.html">Home</a></li>

							<li><a href="blog.html" class="active">Blog</a></li>

							<li><a href="about.html">About</a></li>

							<li><a href="team.html">Authors</a></li>

							<li><a href="contact.html">Contact Us</a></li>

							<?php if( $idx ==1){ ?>
								<li><a href="ranking.php">Rankking</a></li>
							<?php } ?>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">
						<div class="inner">
							<h1><?php echo $post_id['content'];?></h1>

							<div class="image main">
								<img src=<?php echo $post_id['image']; ?> class="img-fluid" alt="" />
							</div>

							<p><?php echo $post_id['text']; ?></p>

					
						</div>
					</div>

				<!-- Sửa -->
			

					<?php  if($post_id['user_id'] ==$idx || $idx ==1){ ?>
							<form method="post" action="blog-post.php?id=<?php echo $id; ?>&idx=<?php echo $idx ?>" enctype="multipart/form-data">
								<div class="form-group">
										<label for="exampleFormControlInput1">Content</label>
										<input type="text" class="form-control" id="exampleFormControlInput1" name='content' value="<?php echo $post_id['content'];?>">
								</div>

								<div class="form-group">
								<label for="exampleFormControlTextarea1">Text</label>
								<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"   name='text'><?php echo $post_id['text'];?></textarea>
								</div>
								<div class="form-group">
									<label for="exampleFormControlFile1">Image</label>
									<input type="file" class="form-control-file" id="exampleFormControlFile1"  name="image"  value ="<?php  echo $post_id['image'];?>" >
								</div>
								<div class="form-group">
										<label for="exampleFormControlSelect1">Type</label>
											<select class="form-control" id="exampleFormControlSelect1" name="display" >
											<option value="0">public</option>
											<option  value="1">private</option>
										
										</select>
								</div>
							
							
								<button type="submit" class="btn btn-primary mb-2" name="edit_post">Edit Post</button>
							</form>
					<?php }?>
				


				<!-- Comments -->

							<section class="blog-posts grid-system">
							<div class="container">
								<div class="row">
								<div class="col-lg-8">
									<div class="all-blog-posts">
									<div class="row">
										<div class="col-lg-12">
										<div class="blog-post">
											<div class="blog-thumb">
											<img src="assets/images/blog-post-02.jpg" alt="">
											</div>
										
										</div>
										</div>
										<div class="col-lg-12">
										<div class="sidebar-item comments">
											<div class="sidebar-heading">
											<h2><?php echo  count($comments); ?> Comments</h2>
											</div>
											<div class="content">
											<ul>

											<?php foreach ($comments as $item){ ?>	
												<li>
													<div class="author-thumb">
														
														<img src="assets/images/comment-author-01.jpg" alt="">
														<strong><?php echo $item['username'] ; ?></strong>
													</div>
													<div class="right-content">
														
														<p><?php echo $item['content']; ?></p>
													</div>
												</li>
											<?php } ?>

											</ul>
											</div>
										</div>
										</div>
									
									</div>
									</div>
								</div>
						
								</div>
							</div>
							</section>

					<footer id="footer">
			<div class="inner">
							<section>
								<h2>Leave a comment</h2>
								
								<form method="post" action="blog-post.php?id=<?php echo $id; ?>&idx=<?php echo $idx ?>">
									<div class="fields">
									
										<div class="field">
											<textarea name="message" id="message" rows="3" placeholder="Your message" name ="message"></textarea>
										</div>

										<div class="field text-right">
											<label>&nbsp;</label>

											<ul class="actions">
												<li><input type="submit" value="Submit" class="primary" name="add_comment"/></li>
											</ul>
										</div>
									</div>
								</form>
							</section>
							<section>

								<h2>Share This</h2>

								<ul class="icons">
									<li><a href="#" class="icon style2 fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="#" class="icon style2 fa-facebook"><span class="label">Facebook</span></a></li>
									<li><a href="#" class="icon style2 fa-linkedin"><span class="label">LinkedIn</span></a></li>
									<li><a href="#" class="icon style2 fa-behance"><span class="label">Behance</span></a></li>
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