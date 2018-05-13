<?php

namespace phauto;

include_once("sql.php");
include_once("except.php");

class ORMException extends AnException{
  public function __toString() {
    return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
  }
}

class ORMObject{
  private $fs;
  private $t;
  public function __construct($t, $fs){
    $this->t  = $t;
    $this->fs = $fs;
  }
  public function all()  { return $this->fs;}
  public function table()  {
    $GLOBALS["DBG"]->inf(__FILE__, __LINE__, $this->t->name());
    return $this->t;
  }
  public function get($f)  {
    if(!isset($fs[$f]))
      throw new ORMException("$f is not a field on table $t->");
    return $fs[$f];
  }

  public function save(){
    $GLOBALS["ORM"]->save($this);
  }
}

class ORMTable{
  private $c; //Columns in table
  private $n; //Table in db
  private $db;
  public function __construct($n, $c = array()){
    $this->n = $n;
    $this->c = $c;
  }
  public function setDB($db){
    $this->db = $db;
  }
  public function cols(){
    return $this->c;
  }
  public function name(){
    return $this->n;
  }
  public function get($oid){
    $sql = "SELECT * FROM $this->n WHERE o_id = :o_id LIMIT 1";
    $q = $this->db->prepare($sql);
    $q->bindValue(':o_id', $oid);
    $rs = $this->db->query($q);
    $fs;
    foreach($rs as $k => $v) $fs[$k] = $v;
    return new ORMObject($this, $fs);
  }
}

class ORMManager{
  private $tables;
  private $db;
  public function __construct($db){
    $this->db = $db;
  }
  public function db(){ return $this->db; }
  public function addTable($n, $t){
    $this->tables[$n] = $t;
    $t->setDB($this->db);
  }
  public function table($t){
    if(!isset($this->tables[$t]))
      throw new ORMException("No object $t found");
    return $this->tables[$t];
  }
  public function tables(){
    return $this->tables;
  }
  public function save($oo){
    $t = $oo->table();
    $sql = "INSERT INTO " .$t->name(). " VALUES (";
    foreach($t->cols() as $c)
      $sql .= ":" .$c. ", ";
    $sql = substr($sql, 0, strlen($sql) - 2) . ")";
    $q = $this->db->prepare($sql);
    for($i = 0; $i < count($oo->all()); $i++){
      if(is_string($oo->all()[$i]))  $q->bindValue(':'.$t->cols()[$i], "'".$oo->all()[$i]."'");
      else               $q->bindValue(':'.$t->cols()[$i], $oo->all()[$i]);
    }
    $this->db->exec($q);
  }
  public function delete($oo){
    $t = $oo->table();
    $sql = "DELETE FROM " .$t->name(). " WHERE o_id = :". $t->cols()[0]. " LIMIT 1";
    $q = $this->db->prepare($sql);
    $q->bindValue(':o_id', $oid);
    $this->db->exec($q);
  }
}

?>