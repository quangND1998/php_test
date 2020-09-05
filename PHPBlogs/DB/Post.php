<?php 

    class Post {
        public $content;
        public $text;
        public $image;
        public $video;
        private $user_id;
        private $postcategory_id;


        function getUser_id(){
            return $this->user_id;
        }
        function setUser_id($user_id){
             $this->user_id =$user_id;  
        }
        function getPostCategory_id(){
            return $this->postcategory_id;
        }
        function setPostCategory_id($post_id){
             $this->postcategory_id = $post_id;  
        }
        // function __construct($content,$text,$image,$video,$user_id,$postcategory_id)
        // {
        //     $this->content = $content;
        //     $this->text = $text;
        //     $this->image = $image;
        //     $this->video = $video;
        //     $this->user_id = $user_id;
        //     $this->postcategory_id =$postcategory_id;
        // }

    }

    // $newpost = new Post();
    // var_dump($newpost)
    // $newpost->setUser_id(1);
    // echo $newpost->getUser_id();
    


?>