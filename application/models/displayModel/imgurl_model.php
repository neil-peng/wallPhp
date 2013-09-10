<?php
class Imgurl_model  extends CI_Model
{
    private $_caPrefix;
    private $_wghtPredix;
    function __construct()
    {   
       parent::__construct();
       $this->_caPrefix = "im_";
       $this->_wghtPredix = "pid_";
       $this->load->driver('cache');
    }
  
    function getIndexFromMc($pageIndex)
    {
             
        $key = $this->_caPrefix.$pageIndex;     
        $indexStr = $this->cache->memcached->get($key);
        //45_1920_1200.jpg|225_1600_1200.jpg|407_1920_1200.jpg|587_1920_1200.jpg|767_1920_1200.jpg|1029_1920_1200.jpg|1209_1600_1200.jpg|1389_1920_1280.jpg|1569_1280_1024.jpg|1749_1920_1200.jpg|1929_1600_1200.jpg|
        $indexArr = explode("|",$indexStr);
        unset($indexArr[count($indexArr)-1]);
        return $indexArr;
    }
    
    function getIndexImages($pageIndex)
    {
        $mcArr = $this->getIndexFromMc($pageIndex);
        return $mcArr;
    }

   

}

?>
