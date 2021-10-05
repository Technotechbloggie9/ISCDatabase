<?php
//set display code in MediaMaster
//all have same basic format
//could be set as display_functions to keep clean code
class HTML5AudioDisplayHandler extends AbstractHandler
{
    private $mediacode;
    public function handle(string $request): ?string
    {
        if ($request === "wpvideoshortcode") {
            return $mediacode;
        } else {
            return parent::handle($request);
        }
    }
    public function setdisplay($displaycode){
      $this->$mediacode = $displaycode;
    }
}
class WPAudioDisplayHandler extends AbstractHandler
{
    private $mediacode;
    public function handle(string $request): ?string
    {
        if ($request === "wpaudioshortcode") {
            return $this->$mediacode;
        } else {
            return parent::handle($request);
        }
    }
    public function setdisplay($displaycode){
      $this->$mediacode = $displaycode;
    }
}
class WPVideoDisplayHandler extends AbstractHandler {
    private $mediacode;
    
    public function handle(string $request): ?string
    {
        if ($request === "wpvideoshortcode") {
            return $this->$mediacode;
        } else {
            return parent::handle($request);
        }
    }
    public function setdisplay($displaycode) 
    {
      $this->mediacode = $displaycode;
    }
}
class HTML5VideoDisplayHandler extends AbstractHandler
{
    private $mediacode;
    public function handle(string $request): ?string
    {
        if ($request === "wpvideoshortcode") {
            return $this->mediacode;
        } else {
            return parent::handle($request);
        }
    }
    public function setdisplay($displaycode) 
    {
      $this->mediacode = $displaycode;
    }
}
?>