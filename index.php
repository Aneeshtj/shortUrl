<?php
  include "config/connection.php";
  include'config/urlClass.php';
  $url = new UrlClass($mysqli);
  $allList = $url->allUrlList();
  $newUrlGet = "";
  if(isset($_GET)):
    foreach($_GET as $key=>$val):
      $uLink = $mysqli->real_escape_string($key);
      $newUrlGet = str_replace('/', '', $uLink);
    endforeach;
    $Geturl = $url->urlFetch($newUrlGet);
    if(!empty($Geturl)):

       header("Location:".$Geturl[0]['full_url']);

    endif;

  endif;
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>URL Short</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>

<div class="wrapper">
    <div id="sucuess" class="alert alert-success" style="display:none;"></div>
    <div class="alert alert-danger errormsg" role="alert"  style="display:none;"></div>
   <form action="#" autocomplete="off" class="saveUrl">
      <input type="text" spellcheck="false" name="full_url" placeholder="Enter the url" required>
      <i class="url-icon uil uil-link"></i>
      <button type="submit" class="saveUrl">Add</button>
      <div id="beforSubmit"></div>
    </form>  
   <?php if(!empty($allList)):?>         
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Short URL</th>
          <th>Original URL</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
       <?php foreach($allList as $allListVal):?> 
        <tr>
          <td>
            <a href="<?php echo $allListVal['shorten_url'] ?>" target="_blank">
                  <?php
                    if($domain.strlen($allListVal['shorten_url']) > 50){
                      echo $domain.substr($allListVal['shorten_url'], 0, 50) . '...';
                    }else{
                      echo $domain.$allListVal['shorten_url'];
                    }
                  ?>
                  </a>
          </td>
          <td>
             <?php
                    if(strlen($allListVal['full_url']) > 60){
                      echo substr($allListVal['full_url'], 0, 60) . '...';
                    }else{
                      echo $allListVal['full_url'];
                    }
                  ?>
          </td>
          
          <td><a href="javascript:void(0)" onclick="deletuRL('<?php echo$allListVal['id']; ?>')">Delete</a></td>
        </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  <?php endif;?>

</div>

</body>
</html>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $(document).on('submit', '.saveUrl', function(e){
            e.preventDefault();
            $.ajax({
                url: "url.php",
                method: "POST",
                data: $('.saveUrl').serialize(),
                dataType: 'JSON',
                beforeSend: function () {
                     $("#beforSubmit").fadeOut();
                    $('#beforSubmit').html('<img src="loader.gif" /> &nbsp; please wait ...');
                },
                 success: function (data) {
                   // alert(data);
                   if(data.sucess=='sucess'){
                    $('#sucuess').show().html(data.msg);

                   }else{
                    $('.errormsg').show().html(data.error);
                   }
                    
                  setTimeout(function () {
                        $('#sucuess').hide();
                        $('#errormsg').hide();
                     location.reload();
                     }, 3000);
                }
            });

        });

    });

    function deletuRL(urlId) {
      $(function () {
        if(confirm("Are you sure you want to delete this Article?"))
        {
            $.ajax({
                type: "POST",
                url: "url.php",
                data: 'urlId=' + urlId ,
                success: function (data) {
                  $('#sucuess').show().html(data);
                   setTimeout(function () {
                        $('#sucuess').hide();
                        location.reload();
                    }, 3000);
                }
            });
          }
        });
      }

</script>


<!-- <script src="script.js"></script> -->

