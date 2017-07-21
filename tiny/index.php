<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Url Shorten</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
         $(".shortenbtn").on('click',function(){
          url=$("#url").val();
          $.ajax({
            'type':'post',
            'data':{'url':url},
            'url':'http://localhost/tiny/url_shortner.php',
            success:function(data){
              console.log(data);
              document.getElementById('final_url').innerHTML="Your new URL is:"+data;
            },
            error:function(){
              console.log("error");
            }
          });
         });
        //  url=$("#url").val();
        //  alert(url);
        // });

      });
    </script>
  </head>
  <body>
  <?php
    require '/config.php';
    if(isset($_GET['cmd'])&&!empty($_GET['cmd'])){
      $hash=$_GET['cmd'];
    
      $res=mysqli_query($con,"select url from tbl_list_of_url where hash='$hash'");
      while($fetch=mysqli_fetch_array($res)){
        $url=$fetch['url'];
      }
    header("location:$url");
  }else{


?>
    <div class="content">
      <div class="container">
        <div class="row">
          
          <h2 class="title text-center">URL Shortener and Link Management Platform</h2>
          <div class="shortenurl  text-center">
            <p class="sub-p">Simplify your link using URL Shortner</p>
            <form class="shortenurl_form" action="#" method="post">
              <input required="" value="" placeholder="Insert your URL here..."  id="url" name="url" type="url">
              <input class="shortenbtn"  name="email" value="Shorten" type="button">
            </form>
            <br/>
            <div id="final_url">



  </div>
          </div>
        </div>
      </div>
          
      
    </div>
    
   
    <script src="js/bootstrap.min.js"></script>
    <?php } ?>
  </body>
</html>