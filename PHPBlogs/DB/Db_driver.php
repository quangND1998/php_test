<?php 
   class DB_driver{
       //biến connect
       private $__conn;


       function connect(){
           if(!$this->__conn){
               $this->__conn= mysqli_connect('localhost', 'root', '', 'blog') or die ('Lỗi kết nối');
                // Xử lý truy vấn UTF8 để tránh lỗi font
            mysqli_query($this->__conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
           
            }

       }

    function disconnect(){
        if($this->__conn){
            mysqli_close($this->__conn);
                }
        }
            
    function insert($table,$data){
        $this->connect();

            $fied_list='';
            $value_list='';
                

            foreach($data as $key =>$value){
                $fied_list .=",$key";
                $value_list .=",'".$value."'";
            }
            $sql = 'INSERT INTO '.$table. '('.trim($fied_list, ',').') VALUES ('.trim($value_list, ',').')';
            
            // var_dump($data);
            // echo($sql);
        return mysqli_query($this->__conn,$sql);
        }


    function update($table,$data,$where){
        $this->connect();

        $sql = '';

        foreach($data as $key => $value){
            $sql .="$key ='".$value."',";

        }
        $data_new = trim($sql,',');

        $sql_query = "UPDATE $table SET $data_new WHERE $where";
        var_dump($table);
        return mysqli_query($this->__conn,$sql_query);

    }

    function remove($table,$where){

        $this->connect();

        $sql = "DELETE FROM $table WHERE $where";
        return mysqli_query($this->__conn, $sql);

    }
    function get_list($sql){
        $this->connect();


        $result = mysqli_query($this->__conn,$sql);

        if(!$result){
            die ('Cau truy van bi sai');
        }
        $return = array();
    
        while($row =mysqli_fetch_assoc($result)){
            $return[] = $row;
        }
        mysqli_free_result($result);
 
        return $return;


    }
        function get_row($sql)
            {
            // Kết nối
            $this->connect();
        
            $result = mysqli_query($this->__conn, $sql);
        
            if (!$result){
                die ('Câu truy vấn bị sai');
            }
        
            $row = mysqli_fetch_assoc($result);
        
            // Xóa kết quả khỏi bộ nhớ
            mysqli_free_result($result);
        
            if ($row){
                return $row;
            }
        
            return false;
        }
        

   
    

            



   } 


?>