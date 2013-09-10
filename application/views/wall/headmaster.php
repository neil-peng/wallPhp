<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//zh-CN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN">

<head>
<title>Test pages</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="<?css_url("/wall/homemaster.css")?>" type="text/css" rel="stylesheet" media="screen,projection" />
<script src="<?js_url("jquery-1.9.1.js");?>" type="text/javascript" charset="utf-8" a></script>
<script>
	   
//加载2*6图片
    function sendPlusFavo(pid,wght)
    {
      $.post("http://10.48.56.21:8669/wallpapermaster/processFavo",{pictureId:pid,weight:wght,oper:1},
          function(data){
           $wSelect =  document.getElementById(pid);
           var t = $wSelect.innerHTML;
           $wSelect.innerHTML=parseInt(t)+1;
          },"text"
      );
    }

   function sendType(pid,type)
    {
      $.post("http://10.48.56.21:8669/wallpapermaster/processType",{pictureId:pid,pictureType:type},
          function(data){
          //pid
          var jsPid =  document.getElementById(pid);
          $(jsPid).prevAll("#addType").children("#typeNameSpan").text(data);
          
          },"text"
      );
    }


    function sendMinsFavo(pid,wght)
    {
      $.post("http://10.48.56.21:8669/wallpapermaster/processFavo",{pictureId:pid,weight:wght,oper:-1},
          function(data){
           $wSelect =  document.getElementById(pid);
           var t = $wSelect.innerHTML;
           $wSelect.innerHTML=parseInt(t)-1;
          },"text"
      );
    }



    $().ready(function()
    {
       var $root = $("#cpWall");       
      <?php foreach ($srcUrl as $echoUrl):?>
       var $pdiv=$("<div id='picDiv'></div>");
       var pSrc = "<?=$echoUrl[0]?>";
       var pid = "<?=$echoUrl[1]?>";
       var weight = "<?=$echoUrl[2]?>";
       var argv = pid;
       var typeId = "<?=$echoUrl[3]?>";
       if(typeId==-1)
          var typeName = "addType";
       else 
          var typeName = typeId;
       $pdiv.append($("<img class='picItem'  src="+pSrc+"></img>"));
   //    $pdiv.append($("<span display='none'>"+pid+"</span>");
       $pdiv.append($("<ul id='eachVoteNav'> <li id='addType'> <span id='typeNameSpan'>"+typeName+"</span><ul id='typeUl'><li class='typeC'>|自然|</li><li class='typeC'>|动物|</li><li class='typeC'>|艺术|</li> <li class='typeC'>|人物|</li> <li class='typeC'>|幻想|</li> <li class='typeC'>|现代|</li> <li class='typeC'>|电影|</li> <li class='typeC'>|音乐|</li></ul> <span id='pidSpan' >"+pid+"</span> </li> <li class='vote voteU'> <a onclick=\"sendPlusFavo("+argv+")\"> </a></li><li class='vote voteD'><a onclick=\"sendMinsFavo("+argv+")\"></a></li><li class='voteIcon'><a></a></li><li class='voteRes' id="+pid+">"+weight+"</li></ul>")); 
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
      var hrefUrl = "http://10.48.56.21:8669/wallpapermaster/showPage/";
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

      //给add type绑定时间
      $(function(){
          $(".typeC").bind("click",function(){
           // alert("click");
            var pid = $(this).parent("#typeUl").nextAll("#pidSpan")[0].innerHTML;
            var typeName = $(this)[0].innerHTML;  
            sendType(pid,typeName);
          })

      })

    });


</script>

</head>