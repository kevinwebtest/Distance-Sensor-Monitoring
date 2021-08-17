<?php
class hcsr04{
 public $link='';
 function __construct($distance){
  $this->connect();
  $this->storeInDB($distance);
 }
 
 function connect(){
  $this->link = mysqli_connect("localhost", "id17043007_smsultrasonic", "dE)qQfwdP2/h4xs") or die('Cannot connect to the DB');
  mysqli_select_db($this->link,"id17043007_sms_ultrasonic") or die('Cannot select the DB');
 }
 
 function storeInDB($distance){
  $query = "insert into hcsr04 set distance='".$distance."'";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
 }
 
}
if($_GET['distance'] != ''){
 $hcsr04=new hcsr04($_GET['distance']);
}
?>