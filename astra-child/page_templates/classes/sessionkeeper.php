<?php 
/*
SessionKeeper must start a session in order to use session superglobal
Sessions end when the browser is closed
Data is stored on the server side
Works best for when security is needed
(user information)
One session is open at a time per user
as the session depends on one particular cookie

working behind the scenes on the client side
NOTE:
If this is problematic may need to 
implement a DataKeeper which stores a 
session id in a CookieKeeper 
and keeps the rest in an (as of yet)
undeveloped database named Keeper_Metavalues
(stored with keeper_id, sessionkey, valuekey, value)
*/
class SessionKeeper implements IKeeper{
  private $session_id;
  private $currentkey;
  private $key_names;
  private $keyvaluedictionary;
  /*
  session_id is for checksession
  key_names helps with building retrieve_all
  keyvalu
  */
  public function __construct(){
    session_start();
    $this->$session_id = session_id();
    $this->$currentkey = "default";
    $_SESSION[$this->currentkey] = "";
    $this->$keyvaluedictionary = array();
    $this->$key_names = array();
    array_push($this->$key_names, $currentkey);
  }
  /*
  method: currentkey($key)
  description:
  this method switches the 
  key for the $_SESSION
  and adds a key if not 
  existing
  */
  public function currentkey($key){
    $this->currentkey = $key;
    if (!in_array($key, $this->$key_names)){
      array_push($this->$key_names, $currentkey);
    }
    //--set default value -------------
    $_SESSION[$this->currentkey] = "";
    //---------------------------------
  }
  public function checksession(){
    $sessioncheck = false;
    if (session_id() == $this->$session_id){
      $sessioncheck = true;
    }
    return $sessioncheck;
  }
  /*
  only needed if session names are used
  private function sane_session_name($name)
  {
    session_name($name);
    if(!isset($_COOKIE[$name]))
    {
        $_COOKIE[$name] = session_create_id();
    }
    session_id($_COOKIE[$name]);
  }
  */
  
  public function new_store($key, $value){
    $checkvalue = false;
    if (!in_array($key, $this->$key_names)){
      array_push($this->$key_names, $key);
      $this->$currentkey = $key;
      $_SESSION[$key] = $value;
      $checkvalue = true;
    }
    return $checkvalue;
  }
  public function store($sessionvalue){
    $_SESSION[$this->$currentkey] = $sessionvalue;
  }
  public function retrieve() {
    return $_SESSION($this->$currentkey);
  }
  /*
  method: retrieve_all()
  description:
  loops through key names, 
  retrieves associated $_SESSION values,
  returns:
  associative array with current $_SESSION key names and values
  */
  public function retrieve_all(){
    foreach ($this->$key_names as &$key_name) {
      $this->$keyvaluedictionary[$key_name] = $_SESSION[$key_name];
    }
    unset($key_name);
    return $this->$keyvaluedictionary;
  }
  public function close(){
    session_write_close(); 
  }
  public function kill() {
    unset($_SESSION);
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"],$params["httponly"]);
    }
  
    session_destroy();
    ////this just closes write session
    /*
    Session will persist on server until expiration
    user actions may close session (like closing browser)
    but sessions persist across pages
    as long as pages are on the same server
    Each session must be closed to start a new one
    */
  }
}
?>