<?php
class Weightpro_model  extends CI_Model
{
    private $_caPrefix;
    private $_wghtPredix;
    function __construct()
    {   
       parent::__construct();
       $this->_caPrefix = "im_";
       $this->_wghtPredix = "uptW_";
       $this->_uptList = "wUptList";
       $this->load->driver('cache');
    }

    function processWeight($isPlus,$pid)
    {   
        $pidKey = $this->_wghtPredix.$pid; 
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


        $weight = $this->cache->memcached->get($pidKey);
        if($isPlus==true)   
            $value = $weight+1;
        else
            $value = $weight-1;
        $ret = $this->cache->memcached->set($pidKey,$value);
        return $ret;
    }

    function getIndexWeights($pidArr)
    {
        $pidkeys = array();    
        foreach ($pidArr as $index => $eachPid) {
            $key = $this->_wghtPredix.$eachPid;
            $pidkeys[$index]=$key;
        }
     
        $wghtArr = $this->cache->memcached->get($pidkeys);
        return $wghtArr;
    }

    function processWeightMc()
    {
        
    }


    function processWeightSql()
    {
        
    }
   
}

?>
