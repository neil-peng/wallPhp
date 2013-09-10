<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//zh-CN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN">

<head>
<title>Test pages</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="<?css_url("/wall/home.css")?>" type="text/css" rel="stylesheet" media="screen,projection" />
<script src="<?js_url("jquery-1.9.1.js");?>" type="text/javascript" charset="utf-8" a></script>
<script>
	   
//加载2*6图片
    function sendPlusFavo(pid,wght)
    {
     
      wSelect =  document.getElementById(pid);  
      $wICon = $(wSelect).prevAll(".voteIcon");

      $.post("http://10.48.56.21:8669/wallpaper/processFavo",{pictureId:pid,weight:wght,oper:1},
          function(data){
        
           //wSelect =  document.getElementById(pid);
           var t = wSelect.innerHTML;
           wSelect.innerHTML=parseInt(t)+1;
          },"text"
      );
    }

    function sendMinsFavo(pid,wght)
    {
      $.post("http://10.48.56.21:8669/wallpaper/processFavo",{pictureId:pid,weight:wght,oper:-1},
          function(data){
           wSelect =  document.getElementById(pid);
           var t = wSelect.innerHTML;
           wSelect.innerHTML=parseInt(t)-1;
          },"text"
      );
    }
    
    function adjustLayout(){
      $("#cpWall").css({"padding-left":function(){var $w1 = $(window).width();var pad = 0.45 - 470/$w1;  pad = pad*100; var str = Math.round(pad).toString()+"%" ; return str }});
    }

    $().ready(function()
    {
      $(window).load(function(){
          $("#cpWall").css({"padding-left":function(){var $w1 = $(window).width();var pad = 0.45 - 470/$w1;  pad = pad*100; var str = Math.round(pad).toString()+"%" ; return str }});
      }
        );

    });



    $().ready(function()
    {
       var $root = $("#cpWall");       
      <?php foreach ($srcUrl as $echoUrl):?>
       var $pdiv=$("<div class='picDiv'></div>");
       var pSrc = "<?=$echoUrl[0]?>";
       var pid = "<?=$echoUrl[1]?>";
       var weight = "<?=$echoUrl[2]?>";
       var argv = pid;
       $pdiv.append($("<img class='picItem'  src="+pSrc+"></img>"));
       $pdiv.append($("<ul id='eachVoteNav'> <li class='vote voteU'> <a onclick=\"sendPlusFavo("+argv+")\"> </a></li><li class='vote voteD'><a onclick=\"sendMinsFavo("+argv+")\"></a></li><li class='voteIcon voteIconAct'><a></a></li><li class='voteRes' id="+pid+">"+weight+"</li></ul>")); 
      $root.append($pdiv);
      <?php endforeach;?>

    });

//加载页尾分页栏
    $().ready(function()
    {
      var $root = $("#pageIndexNav"); 
      var $curIndex = <?echo $curIndex?>;
      if($curIndex>5)
        var sIndex=$curIndex-5;
      else
        var sIndex=1;
      var eIndex = sIndex + 10;
      //only for tmp test
      var ssIndex = sIndex + 100;
      var eeIndex = ssIndex + 3;
      //
      var hrefUrl = "http://10.48.56.21:8669/wallpaper/showPage/";
      for (var i = sIndex; i <= eIndex; i++) {
        if(i!=$curIndex)
          var liItem = "<li ><a href='"+hrefUrl+i+"'>"+i+"</a></li>";
        else
          var liItem = "<li ><a id='pageCurrent' href='"+hrefUrl+i+"'>"+i+"</a></li>"
        //alert(liItem);
        var $pdiv= $(liItem);
        $root.append($pdiv);
      }
      //var liItem = "<li ><a href='"+hrefUrl+i+"'>"+i+"</a></li>";
      var $varMiddle = $("<li class='pageIndexMiddle'>...</li>");
      $root.append($varMiddle);
      //add last some pages
      for (var i = ssIndex; i <= eeIndex; i++) {
        var liItem = "<li ><a href='"+hrefUrl+i+"'>"+i+"</a></li>";
        //alert(liItem);
        var $pdiv= $(liItem);
        $root.append($pdiv);
      }
    });

//add pic to show real ones
    $().ready(function()
    {   
      $(".picItem").click(function(){
        var imgSrc = $(this).attr("src");
        //http://10.48.56.21:8669/relData/baseImg//index0/404_1920_1080.jpg
        indexPath = imgSrc.match(/http:\/\/(.*\/.*\/(.*).jpg$)/)[2]
        window.location.href='http://10.48.56.21:8669/wallpaper/profile/'+indexPath;
      });


      $(".vote").mousedown(function() {
          $wICon = $(this).nextAll(".voteIcon");
         // alert($wICon);
          $wICon.css({"-webkit-transform":"scale(1.5)","-webkit-transition-property":"transform","-webkit-transition-duration":"0.2s"});
      });

      $(".vote").mouseup(function() {
            $wICon = $(this).nextAll(".voteIcon");
          $wICon.css({"-webkit-transform":"scale(1)","-webkit-transition-property":"transform","-webkit-transition-duration":"0.2s"});
      });

      

    });




</script>

</head>