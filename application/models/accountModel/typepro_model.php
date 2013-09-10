<?php
class Typepro_model  extends CI_Model
{
    private $_caPrefix;
    private $_wghtPredix;
    function __construct()
    {   
       parent::__construct();
       $this->_typePredix = "uptT_";
       $this->_uptList = "tUptList";
       $this->load->driver('cache');
    }

    function addType($pid,$type)
    {   
        $pidKey = $this->_typePredix.$pid;   
        $uptList = $this->cache->memcached->get($this->_uptList);
        if($uptList==NULL)
        {
            $value = array();
            array_push($value,$pid);
            $this->cache->memcached->set($this->_uptList,$value);
        }
        else if(is_array($uptList))
        {
            array_push($uptList,$pid);
            $uptList = array_unique($uptList);
            $this->cache->memcached->set($this->_uptList,$uptList);
        }
        else
        {
            return false;
        }

        return $this->cache->memcached->set($pidKey,$type);
    }

    function getType($pid)
    {   
        $pidKey = $this->_typePredix.$pid;  
        $type = $this->cache->memcached->get($pidKey);
        return $type;
    }
    function translateTypeId($type)
    {
        if ($type=="|自然|") 
            $typeId = 1;
        else if ($type=="|动物|")
            $typeId = 2;
        else if ($type=="|艺术|")
            $typeId = 3;
        else if ($type=="|人物|")
            $typeId = 4;
        else if ($type=="|幻想|")
            $typeId = 5;
        else if ($type=="|现代|")
            $typeId = 6;
        else if ($type=="|电影|")
            $typeId = 7;
        else if ($type=="|音乐|")
            $typeId = 8;
        else
            $typeId = -1;
        return $typeId;
    }

    function translateType($type)
    {   
       
        $ret = "success type";
        if ($type==1) 
            $typeNname = "自然";
        else if ($type==2)
            $typeNname = "动物";
        else if ($type==3)
            $typeNname = "艺术";
        else if ($type==4)
            $typeNname = "人物";
        else if ($type==5)
            $typeNname = "幻想";
        else if ($type==6)
            $typeNname = "现代";
        else if ($type==7)
            $typeNname = "电影";
        else if ($type==8)
            $typeNname = "音乐";
        else
            $typeNname = "err type";

        return $typeNname;
     
    }


}

?>
