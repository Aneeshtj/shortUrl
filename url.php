 <?php 
  include "config/connection.php";
  include'config/urlClass.php';
  $url = new UrlClass($mysqli);

   if (isset($_POST["full_url"])) {
        $data=array();
        $shorten_url = substr(md5(microtime()), rand(0, 26), 5);
        $data['full_url']= $mysqli->real_escape_string($_POST['full_url']);
        $data['shorten_url']= $shorten_url;
        if(!empty($mysqli->real_escape_string($_POST['full_url'])) && filter_var($mysqli->real_escape_string($_POST['full_url']), FILTER_VALIDATE_URL)){
            $success = $url->addUrl($data);
            $arr = array ( 'sucess'=>'sucess','msg'=>'Data successfully submited!');
            echo json_encode( $arr );
           
        }else{
              

            $arr = array ( 'error'=>$mysqli->real_escape_string($_POST['full_url']).' - This is not a valid URL!');
            echo json_encode( $arr );
            

        }

         die;   
      }
        


 if (isset($_POST["urlId"])) { 

    $url->deleteUrl($_POST["urlId"]);
     echo"Data successfully deleted!";
      die;
 }

   