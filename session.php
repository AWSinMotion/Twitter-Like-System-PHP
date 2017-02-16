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
    if($this->conn && mysql_close($this->conn)){
      return true;
    }
    return false;
  }

  public function session_read($id){
    if($this->conn){
      $query = mysql_query("SELECT data FROM sessions WHERE id='$id'", $this->conn);
      $row = mysql_fetch_assoc($query);
      return $row['data'];
    }
    return NULL;
  }

  public function session_write($id, $data){
    if($this->conn){
      $access = time();
      mysql_query("REPLACE INTO sessions VALUES ('$id', '$access', '$data')", $this->conn);
    }
    return true;
  }

  public function session_destroy($id){
    if($this->conn){
      mysql_query("DELETE FROM sessions WHERE id = '$id'", $this->conn);
    }
    return true;
  } 

  public function session_gc($max){
    if($this->conn){
      $old = time() - $max;
      mysql_query("DELETE FROM sessions WHERE access < '$old'", $this->conn);
    }
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