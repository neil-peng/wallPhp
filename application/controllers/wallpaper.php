<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallpaper extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('displayModel/imgurl_model','iM');
		
		$this->load->model('accountModel/Weightpro_model','pC');
	}

	public function home()
	{
		$this->showPage(1);
	} 

	public function processFavo()
	{
		$pid =  $_POST['pictureId'];
		$oper = $_POST['oper'];
		if($oper=="1")
		{
			var_dump($this->pC->processWeight(true,$pid));
		}
		else if($oper=="-1")
		{
			var_dump($this->pC->processWeight(false,$pid));
		}
		else
		{}
	}

	public function showPage($pageIndex)
	{
		$data['srcUrl']=array();
		$data["curIndex"] = $pageIndex;
		if($pageIndex>0)
		{
			$indexArr = $this->iM->getIndexImages($pageIndex-1);
			
			if(count($indexArr)==0)
				return;
			
			//var_dump($indexArr);
			//array(11) { [0]=> string(17) "236_1600_1200.jpg" [1]=> string(17) "416_1920_1200.jpg" [2]=> string(17) "596_1920_1200.jpg" [3]=> string(17) "999_1920_1080.jpg" [4]=> string(18) "1041_1920_1200.jpg" [5]=> string(18) "1179_1920_1200.jpg" [6]=> string(18) "1221_1600_1200.jpg" [7]=> string(18) "1359_1280_1024.jpg" [8]=> string(18) "1539_1280_1024.jpg" [9]=> string(18) "1719_1920_1200.jpg" [10]=> string(18) "1899_1920_1080.jpg" }
			
			$wghtReqs = array();
			for ($i=0; $i <12 ; $i++) { 
				if(isset($indexArr[$i]))
				{
					$picShort = explode("_",$indexArr[$i]);  
					$pid = $picShort[0];
					//$data['pids'][$i] = pid;
					$splictIndex = floor($pid/5000);
					$data['srcUrl'][$i][0] = img_url("/index".$splictIndex."/".$indexArr[$i]); 
					$data['srcUrl'][$i][1] = $pid;
					$wghtReqs[$i]=$pid;
				}
				else
				{
					$picShort = explode("_",$indexArr[0]); 
					$data['srcUrl'][$i][0] = img_url("/index".$splictIndex."/".$indexArr[0]);
					$data['srcUrl'][$i][1] = $picShort[0];
					$wghtReqs[$i] = $picShort[0];
				}

			}
			//$wghtRes = $this->iM->getIndexWeights($wghtReqs);
			//
			
			$wghtRes = $this->pC->getIndexWeights($wghtReqs);
			$index = 0;
			//var_dump($wghtRes);
			foreach ($wghtRes as $value) {
				$data['srcUrl'][$index][2] = $value;
				$index++;
			}
			for (; $index < 12; $index++) { 
				$data['srcUrl'][$index][2] = 0;	
			}

			$this->load->view('wall/headDisplay',$data);
			$this->load->view('wall/pageHome');	
			$this->load->view('wall/foot');	
		}
	} 

	public function profile($indexPath)
	{
		$realImg = md5("$indexPath".".jpg");
		$picShort = explode("_",$indexPath); 
		
		$showIndex = floor($picShort[0]/5000);
		$data["srcPath"] = img_url("/show".$showIndex."/".$realImg.".jpg");
		$this->load->view('wall/headProfile',$data);
		$this->load->view('wall/pageProfile',$data);
		$this->load->view('wall/foot');	

		//var_dump($indexPath);			 
	}
}

?>
