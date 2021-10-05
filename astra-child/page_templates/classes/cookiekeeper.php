<?php
//CookieKeeper generalizes previous operations in recording-form-template.php with cookies
class CookieKeeper {
  protected $cookiename;
  protected $cookievalue;
  function __construct($cookiename) {
    $this->$cookiename = $cookiename;
  }
  function store($cookie_value){
    $this->cookievalue = $cookie_value;
    $expires = (1/48); //approximately 30 minutes, or 1800 seconds
    $cookie_name = $this->$name; //name is stored as part of CookieKeeper construction
    $currentexpiration = time () + (86400 * $expires);
    $allowedpath = "/";//the backslash indicates that this cookie is accessible across the entire server
    setcookie($cookie_name, $cookie_value, $currentexpiration, $allowedpath);
    $cookie_is_set = isset($_COOKIE[$this->$name]);
    return $cookie_is_set; //should return true
  }
  function retrieve(){
    if(isset($_COOKIE[$this->$name])) {
      $returnvalue = $_COOKIE[$this->$name];
    }else if(!empty($this->$cookievalue && !isset($_COOKIE[$this->$name]))) {
      $returnvalue = $this->$cookievalue;
    }else{
      $returnvalue = "";
    }
    return $returnvalue;
  }
  function kill(){
    $cookie_name = $this->$name;
    $cookievalue = "";
    $currentexpiration = time () - 3600;
    $allowedpath = "";//the backslash indicates that this cookie is accessible across the entire server
    setcookie($cookie_name, $cookievalue, $currentexpiration, $allowedpath);
    $cookie_is_set = !isset($_COOKIE[$this->$name]);
    return $cookie_is_set; //should return true
  }
}
?>
