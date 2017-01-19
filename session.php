<?php

class Session {
 
  private $conn;

  public function __construct(){
    include 'connect.php';
    $this->conn = $conn;
  }

  public function session_open(){
    if($this->conn){
      return true;
    }
    return false;
  }

  public function session_close(){
    if(mysql_close($this->conn)){
      return true;
    }
    return false;
  }

  public function session_read($id){
    $query = mysql_query("SELECT data FROM sessions WHERE id='$id'", $this->conn);
    $row = mysql_fetch_assoc($query);
    return $row['data'];
  }

  public function session_write($id, $data){
    $access = time();
    mysql_query("REPLACE INTO sessions VALUES ('$id', '$access', '$data')", $this->conn);
    return true;
  }

  public function session_destroy($id){
    mysql_query("DELETE FROM sessions WHERE id = '$id'", $this->conn);
    return true;
  } 

  public function session_gc($max){
    $old = time() - $max;
    mysql_query("DELETE FROM sessions WHERE access < '$old'", $this->conn);
    return true;
  }
 
}

$ses = new Session();

session_set_save_handler(
  array($ses, 'session_open'),
  array($ses, 'session_close'),
  array($ses, 'session_read'),
  array($ses, 'session_write'),
  array($ses, 'session_destroy'),
  array($ses, 'session_gc')
);

session_start();

?>