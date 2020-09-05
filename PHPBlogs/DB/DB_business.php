<?php 

    require './Db_driver.php';

    class DB_business extends DB_driver{

        protected $_table_name ='';


        protected $_key ='';
        protected $_username='';
        protected $_password ='';


        function __construct()
        {
            parent::connect();
        }

        function __destruct()
        {
            parent::disconnect();
        }
    
        function add_new($data){
            return parent::insert($this->_table_name,$data);

        }
        function update_by_id($data,$id){
            return $this->update($this->_table_name,$data,$this->_key ."=".(int)$id);
        }
        function delete_by_id($id){
            return $this->remove($this->_table_name,$this->_key ."=". (int)$id);
        }
        function select_by_id($select, $id){
            $sql = "select $select from ".$this->_table_name." where ".$this->_key." = ".(int)$id;
            return $this->get_row($sql);
        }
        function login($username, $password){

           $sql =  "select * from $this->_table_name where $this->_username = '$username' and $this->_password = '$password'";
            return $this->get_row($sql);
        }
        
    }

?>
