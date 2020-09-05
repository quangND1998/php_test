<?php 

    class Comment {
        public $content;
       
        private $post_comment_id;
        private $user_post_id;


        function getUserComment_id(){
            return $this->post_comment_id;
        }
        function setUserComment_id($post_comment_id){
             $this->post_comment_id =$post_comment_id;  
        }
        function getPostComment_id(){
            return $this->user_post_id;
        }
        function setPostComment_id($user_post_id){
             $this->user_post_id = $user_post_id;  
        }
  

    }


?>