<?php
require '/config.php';
$url=$_POST['url'];

mysqli_query($con,"insert into tbl_list_of_url(url)values('$url')");
$res=mysqli_query($con,"select max(id) from tbl_list_of_url");
$fetch=mysqli_fetch_array($res);
$id=$fetch[0];





$Base62Hash=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9'];
$hashCharSet = [];
$remainder = 0;
$dividend=$id;
while($dividend > 0)
  {
  	$remainder = floor($dividend%62);
  	$dividend = floor($dividend/62);
  	array_unshift($hashCharSet,$remainder);
  }
//print_r($hashCharSet);
$i=0;

$hashCount=count($hashCharSet);
$Base62String='';
while($i<$hashCount){
	$j=$hashCharSet[$i];
	$Base62String.= $Base62Hash[$j];
	$i++;
}

$shortUrl="http://localhost/tiny?cmd=".$Base62String;
mysqli_query($con,"update tbl_list_of_url set hash='$Base62String' where id=$id");
// header("location:http://localhost/tiny?shortUrl=$shortUrl");
echo $shortUrl;
?>

