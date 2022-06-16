<?php 
namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\Message;
use App\Models\ratingfoodtableModel;
use App\Models\ratingVegfoodtableModel;
use App\Models\cookstableModle;
use App\Models\foodsserchModel;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Files\UploadedFile;
class Epicureser1 extends BaseController
{
  function Epicureser1(){
    parent::Controller();
    $this->load->library('email');
   }

	public function index()
	{
      
      echo "Hello Nadeem";
      
      //Seeder used to add dummy values on database 
      //$seeder = \Config\Database::seeder();
      //$seeder->call('epicuredataseed');
	}


  public function getsplashvidurl(){
  
  $request = \Config\Services::request();
    //$message = new \CodeIgniter\HTTP\Message();
    $key = $request->getHeader('key');
    $mykey = $key->getValue('Key');
    if( $mykey == license)
    {
     $resultarrays=['splashed' => "www.youtube.com/watch?v=35bbyAJodEQ"];
      //echo json_encode($resultarrays);    
     return $this->response->setJSON($resultarrays);
    }
   
  }





 public function sendVerificationEmail($username,$password){
$email = \Config\Services::email();
$db = \Config\Database::connect();
 $config['protocol']    = 'mail';
 $config['SMTPHost']    = 'localhost';
 $config['SMTPPort']    = '25';
 $config['SMTPTimeout'] = '7';
 $config['SMTPUser']    = 'epicure@greatlionsglobal.com';
 $config['SMTPPass']    = '//qmastfu';
 $config['charset']  = 'utf-8';
 $config['newline']    = "\r\n";
 $config['mailType'] = 'html';  
 $config['SMTPCrypto'] = null; 
 $config['validate'] = false;
  $email->initialize($config);
 // $email->SMTPSecure = ""; 
 try{
  $otp = rand(1000000,9999999);
 
$sql = "INSERT INTO confirmationtable (id, pass, emailid, passcode,currentdate) VALUES (NULL, '$password', '$username', '$otp','".date("Y-m-d H:i:s")."')";
if($db->query($sql)){
 $email->setFrom('epicure@greatlionsglobal.com', 'EpicureApp');
 $email->setTo($username); 
 $email->setSubject('Epicure App Authentication Mail');
 $email->setMessage('<html>
 <head>
 <title>EpicureApp email</title>
 </head>
 <body>
 <h1>Welcome To Epicure App </h1>
 <h4> The OTP Number To Complete Your Login </h4>
 <h4>Copy and paste otp code in the confirmation page</h4>
 <h3><b>'.$otp.'</b></h3>

 </body>
 </html>');  
 
 $email->send();
 }
}
 catch(Exception $e){
   echo $e;
 }
 //echo $email->print_debugger();

   }









    //--------------------------------------------------------------------


   public function login(){
    $request = \Config\Services::request();
    //$message = new \CodeIgniter\HTTP\Message();
    
    $key = $request->getHeader('key');
    $mykey = $key->getValue('Key');
    if( $mykey == license)
    {
      $db = \Config\Database::connect();
      $used = $request->getJson(true);
      $username = $request->getVar('username');
      $password =  $request->getVar('password');
      //$jsonArray = json_decode(file_get_contents('php://input'),true);
      $sql = "SELECT * FROM epicureuser WHERE emailid = '$username' and pass = '$password'";
      $query = $db->query($sql);
      if (sizeof($query->getResult()) > 0){
        foreach($query->getResult() as $row){
          $resultarray = array('datavalues'=>$row);
          $resultarray['status'] = true;
      // echo json_encode($resultarray);
       return $this->response->setJSON($resultarray);
        }
    }else{
      $resultarray = array('datavalues'=>null);
      $resultarray['status'] = false;
      return $this->response->setJSON($resultarray);
      //echo json_encode($resultarray);
    }
  }
  else{
      echo "shows error not matching";
    }
   }


//--------------------------------------------------------------------
//function to signup

public function signup(){
  $request = \Config\Services::request();
  //$message = new \CodeIgniter\HTTP\Message();
  
  $key = $request->getHeader('key');
  $mykey = $key->getValue('Key');
  if( $mykey == license)
  { $db = \Config\Database::connect();
    
    $username = $request->getVar('username');
    $password = $request->getVar('password');
    
    //$jsonArray = json_decode(file_get_contents('php://input'),true);
    $sql = "SELECT * FROM epicureuser WHERE emailid = '$username'";
    $query = $db->query($sql);
      if (sizeof($query->getResult()) > 0){
        $resultarray['status'] = false;
        return $this->response->setJson($resultarray);
        
      }
      else{

        $this->sendVerificationEmail($username,$password);
        $resultarray['status'] = true;
        return $this->response->setJson($resultarray);
      }
     
  }
  else{
    $resultarray['status'] = false;
    return $this->response->setJson($resultarray);
  }
}

//--------------------------------------------------------------------
public function createthisweekstopcooks(){
  
  $db = \Config\Database::connect();
  $request = \Config\Services::request();
  $key = $request->getHeader('key');
  $mykey = $key->getValue('Key');
  if($mykey == license){
  $sql = "SELECT * FROM cookstable ORDER BY rating DESC LIMIT 5";
  

  $query = $db->query($sql);
  if (sizeof($query->getResult()) > 0){
    $addedarray = array();  
    $i = 1;
    foreach($query->getResult() as $row){
        $encodedData = file_get_contents((string)$row->profilepic);
        
      $imagefile = base64_encode ($encodedData);
     // $url_param = rtrim($imagefile, '=');
      $row->profilepic = $imagefile;
      // $addedarrays = array($i => $row);
      // $i++;
      array_push($addedarray,$row);
      
    
      }
      $resultarray = array('datavalues'=>$addedarray);
      $resultarray['status'] = true;
      return $this->response->setJSON($resultarray);
  }else{
    $resultarray = array('datavalues'=>null);
    $resultarray['status'] = false;
    return $this->response->setJSON($resultarray);
  
  }
  }
}
//--------------------------------------------------------------------








//function to send verification link
public function confirmotp(){

  $db = \Config\Database::connect();
  $request = \Config\Services::request();
  $key = $request->getHeader('key');
  $mykey = $key->getValue('Key');
  if( $mykey == license)
  {  
    $username = $request->getVar('username');
    $password = $request->getVar('password');
    $otp = $request->getVar('otp');
    $sql = "SELECT * FROM confirmationtable WHERE emailid = '$username' and pass = '$password' and passcode = '$otp'";
    $query = $db->query($sql);
    if (sizeof($query->getResult()) > 0){
      
      
      foreach($query->getResult() as $row){
        $date1=strtotime($row->currentdate);
        $date2=strtotime(date("Y-m-d H:i:s"));
      
        $diff = abs($date2 - $date1); 
  
       
          if ($diff < 600){
            
            $sql = "DELETE  FROM confirmationtable WHERE emailid = '$username' and pass = '$password' and passcode = '$otp'";
          if($db->query($sql)){
            $resultarray['status'] = true;
            return $this->response->setJson($resultarray);  
        }
        else{
          $sql = "DELETE  FROM confirmationtable WHERE emailid = '$username' and pass = '$password' and passcode = '$otp'";
          if($db->query($sql)){
            $resultarray['status'] = false;
            return $this->response->setJson($resultarray);
  }
         
        }
      }
          else{
            $sql = "DELETE  FROM confirmationtable WHERE emailid = '$username' and pass = '$password' and passcode = '$otp'";
            if($db->query($sql)){
              $resultarray['status'] = false;
              return $this->response->setJson($resultarray);
    }

          }

    
      }
      
    }
    else{
      $resultarray['status'] = false;
      return $this->response->setJson($resultarray);
    }
}
else{

  $resultarray['status'] = false;
  return $this->response->setJson($resultarray);


}
}

 //--------------------------------------------------------------------
 
 
public function addusercomp(){
      
  $db = \Config\Database::connect();
      // $sql = "SELECT * FROM topratingfood";
      $response =  \Config\Services::response();
      
      $request = \Config\Services::request();
      $key = $request->getHeader('key');
      $mykey = $key->getValue('Key');
if($mykey == license){
  $emailid = $request->getVar('emailid');
  $password = $request->getVar('password');
  $username = $request->getVar('username');
  $name = $request->getVar('name');
  $phonenumber = $request->getVar('phonenumber');
  $address = $request->getVar('address');
  $aboutyou = $request->getVar('aboutyou');
  $profilepic = $this->request->getVar('profilepic');
  
  $encodedData = str_replace(' ','+',$profilepic);
  $imagefile = base64_decode ( $encodedData,true);
  
  $file = '../profilepics/'.$emailid;
  file_put_contents($file,$imagefile);

  $sql = "INSERT INTO epicureuser (id,emailid,pass,username,profilepic,locations,favoritefoods,favoritecooks,rating,yname,aboutyou,joineddate) VALUES (NULL , '$emailid','$password','$username','$file','$address',NULL, NULL,NULL,'$name','$aboutyou','".date("Y-m-d H:i:s")."')";
  if( $db->query($sql)){   
  $resultarray['status'] = true;
  return $this->response->setJson($resultarray);
}
else{
  $resultarray['status'] = false;
  return $this->response->setJson($resultarray);
}
}
else{
  $resultarray['status'] = false;
  return $this->response->setJson($resultarray);

}
}












    //--------------------------------------------------------------------
    public function gettopratingfoods(){
      $pager = \Config\Services::pager();
      $db = \Config\Database::connect();
          $response =  \Config\Services::response(); 
          $request = \Config\Services::request();
          $key = $request->getHeader('key');
          $mykey = $key->getValue('Key');
    if($mykey == license){
     
       
      $pagenumber = $request->getVar('pagenumber');
     
    $sql = "SELECT * FROM ratingfoodtable ORDER BY rating DESC";
    $query = $db->query($sql);
    if (sizeof($query->getResult()) > 0){
      $sizearray = ceil(sizeof($query->getResult())/5);
      $addedarray = array(); 
      
      $model = new ratingfoodtableModel();
      $users = $model->orderBy('rating', 'DESC')->paginate(5,'users',$pagenumber);
     
    
    
      
        
        $resultarray['datavalues'] = $users;
        $resultarray['status'] = true;
        $resultarray['totalpages'] = $sizearray;
        $resultarray['total'] = sizeof($query->getResult());
        $resultarray['perpage'] = 5;
        if($pagenumber+1 <= $sizearray){
        $resultarray['nextpage']= $pagenumber+1;
      }else{
        $resultarray['nextpage']= null;
      }
      if($pagenumber-1 > 0 ){
        $resultarray['previouspage'] = $pagenumber-1;
      }else{
        $resultarray['previouspage'] = null;
      }
       return $this->response->setJSON($resultarray);
    }else{
      $resultarray = array('datavalues'=>null);
      $resultarray['status'] = false;
      // return $this->response->setJSON($resultarray);
    
    }

  }

    }

  //--------------------------------------------------------------------

  public function gettopratingVegfoods(){
      
        $db = \Config\Database::connect();
        $response =  \Config\Services::response();
        $request = \Config\Services::request();
        $key = $request->getHeader('key');
        $mykey = $key->getValue('Key');
  if($mykey == license){
    $pagenumber = $request->getVar('pagenumber');
  $sql = "SELECT * FROM ratingVegfoodtable ORDER BY rating DESC";
  $query = $db->query($sql);
  if (sizeof($query->getResult()) > 0){
    $sizearray = ceil(sizeof($query->getResult())/5);
    $addedarray = array(); 
    
    $model = new ratingVegfoodtableModel();
    $users = $model->orderBy('rating', 'DESC')->paginate(5,'users',$pagenumber);
   
  
    $resultarray['datavalues'] = $users;
      $resultarray['status'] = true;
        $resultarray['totalpages'] = $sizearray;
        $resultarray['total'] = sizeof($query->getResult());
        $resultarray['perpage'] = 5;
        if($pagenumber+1 <= $sizearray){
        $resultarray['nextpage']= $pagenumber+1;
      }else{
        $resultarray['nextpage']= null;
      }
      if($pagenumber-1 > 0 ){
        $resultarray['previouspage'] = $pagenumber-1;
      }else{
        $resultarray['previouspage'] = null;
      }
      return $this->response->setJSON($resultarray);
  }else{
    $resultarray = array('datavalues'=>null);
    $resultarray['status'] = false;
    return $this->response->setJSON($resultarray);
  }
}
  }
   //--------------------------------------------------------------------
public function getfooddetails(){

  $db = \Config\Database::connect();
  $response =  \Config\Services::response();
  $request = \Config\Services::request();
  $key = $request->getHeader('key');
  $mykey = $key->getValue('Key');
  $addedarray = array();  
if($mykey == license){ 
  $userid = $request->getVar('userid');
  $foodid = $request->getVar('foodid');
   


  $sql = "SELECT * FROM foodstable WHERE userid = '$userid' and foodid = '$foodid' ";
  $resulted = $db->query($sql);
  if (sizeof($resulted->getResult()) > 0){
    
    foreach($resulted->getResult() as $row){
          
      array_push($addedarray,$row);


    }

    $resultarray = array('datavalues'=>$addedarray);
    $resultarray['status'] = true;
    return $this->response->setJSON($resultarray);


  }else{

    $resultarray = array('datavalues'=>null);
    $resultarray['status'] = false;
    return $this->response->setJSON($resultarray);


  }

}

}
 //--------------------------------------------------------------------
   public function gettopratingcooks(){
    $db = \Config\Database::connect();
    $sql = "SELECT * FROM topratingcooks";
    $response =  \Config\Services::response();
    $request = \Config\Services::request();
    $key = $request->getHeader('key');
    $mykey = $key->getValue('Key');
if($mykey == license){ 
  $query = $db->query($sql);
  $data = $query->getResult();
  return $response->setJSON($data);
}
    }
   //--------------------------------------------------------------------
public function getcooksdetails(){

  $db = \Config\Database::connect();
  $response =  \Config\Services::response();
  $request = \Config\Services::request();
  $key = $request->getHeader('key');
  $mykey = $key->getValue('Key');
  $addedarray = array();  
if($mykey == license){ 
  $userid = $request->getVar('userid');

  $sql = "SELECT * FROM epicureuser WHERE  username = '$userid' ";
  if (sizeof($resulted->getResult()) > 0){
    
    foreach($resulted->getResult() as $row){
          
      array_push($addedarray,$row);


    }

    $resultarray = array('datavalues'=>$addedarray);
    $resultarray['status'] = true;
    return $this->response->setJSON($resultarray);


  }else{

    $resultarray = array('datavalues'=>null);
    $resultarray['status'] = false;
    return $this->response->setJSON($resultarray);


  }




}




}
 //--------------------------------------------------------------------
   public function getserchedcookstoprating(){
       
    $db = \Config\Database::connect();

    
    $response =  \Config\Services::response();
    $request = \Config\Services::request();
    $key = $request->getHeader('key');
    $mykey = $key->getValue('Key');
if($mykey == license){ 
  $pagenumber = $request->getVar('pagenumber');
  $username = $request->getVar('username');
  $sql = "SELECT * FROM cookstable WHERE username LIKE '$username%'";
  $query = $db->query($sql);
  $data = $query->getResult();
  if (sizeof($query->getResult()) > 0){
    $sizearray = ceil(sizeof($query->getResult())/5);
    $addedarray = array(); 
    $model = new cookstableModle();
    $users = $model->like('username',$username)->paginate(5,'users',$pagenumber);
   
  
    $resultarray['datavalues'] = $users;
      $resultarray['status'] = true;
        $resultarray['totalpages'] = $sizearray;
        $resultarray['total'] = sizeof($query->getResult());
        $resultarray['perpage'] = 5;
        if($pagenumber+1 <= $sizearray){
        $resultarray['nextpage']= $pagenumber+1;
      }else{
        $resultarray['nextpage']= null;
      }
      if($pagenumber-1 > 0 ){
        $resultarray['previouspage'] = $pagenumber-1;
      }else{
        $resultarray['previouspage'] = null;
      }
      return $this->response->setJSON($resultarray);
  }else{
    $resultarray = array('datavalues'=>null);
    $resultarray['status'] = false;
    return $this->response->setJSON($resultarray);
  }
  return $response->setJSON($data);

}
    }
   //--------------------------------------------------------------------




   public function getserchedfoodstoprating(){
       
    $db = \Config\Database::connect();

    
    $response =  \Config\Services::response();
    $request = \Config\Services::request();
  
    $key = $request->getHeader('key');
    $mykey = $key->getValue('Key');
if($mykey == license){ 
  $pagenumber = $request->getVar('pagenumber');
  $foodstitle = $request->getVar('foodstitle');
  $sql = "SELECT * FROM foodstable WHERE title LIKE '$foodstitle%'";
  
  $query = $db->query($sql);

  $data =  $query->getResult();
  if (sizeof($query->getResult()) > 0){
    $sizearray = ceil(sizeof($query->getResult())/5);
    $addedarray = array(); 
    $model = new foodsserchModel();
    $users = $model->like('title',$foodstitle)->paginate(5,'users',$pagenumber);
    $resultarray['datavalues'] = $users;
    $resultarray['status'] = true;
      $resultarray['totalpages'] = $sizearray;
      $resultarray['total'] = sizeof($query->getResult());
      $resultarray['perpage'] = 5;
      if($pagenumber+1 <= $sizearray){
      $resultarray['nextpage']= $pagenumber+1;
    }else{
      $resultarray['nextpage']= null;
    }
    if($pagenumber-1 > 0 ){
      $resultarray['previouspage'] = $pagenumber-1;
    }else{
      $resultarray['previouspage'] = null;
    }
    return $this->response->setJSON($resultarray);
}
else
{
  $resultarray = array('datavalues'=>null);
  $resultarray['status'] = false;
  return $this->response->setJSON($resultarray);
}

}
else{
  $resultarray = array('datavalues'=>null);
  $resultarray['status'] = false;
  return $this->response->setJSON($resultarray);

}
   
}
   //--------------------------------------------------------------------






   

   public function adduserrecipe(){
       
    $request = \Config\Services::request();
  $response =  \Config\Services::response();
  $db = \Config\Database::connect();
  $key = $request->getHeader('key');
  $mykey = $key->getValue('Key');
  if( $mykey == license)
  { 
    $username = $request->getVar('username');
    $foodtitle = $request->getVar('foodtitle');
    $category = $request->getVar('category');
    $image = $request->getVar('image');
    $ingredients = $request->getVar('ingredients');
    $description = $request->getVar('description');
    
    $encodedData = str_replace(' ','+',$image);
    $imagefile = base64_decode ( $encodedData,true);
    $foodid =    $username . $foodtitle; 
    $file = '../foodimages/'.$username.$foodtitle;
    file_put_contents($file,$imagefile);
    $sql = "INSERT INTO foodstable (title,imageurl,ingredients,descrip,rating,totalrating,TypeVegorNon,userid,foodid) VALUES ( '$foodtitle', '$file','$ingredients','$description',NULL,NULL, '$category','$username','$foodid')";
    $sqlnonveg = "INSERT INTO ratingfoodtable (userid,foodtitle,foodpic) VALUES ( '$username', '$foodtitle','$file')";
    $sqlveg = "INSERT INTO ratingVegfoodtable (userid,foodtitle,foodpic) VALUES ( '$username', '$foodtitle','$file')";
            
    if($category == "Vegetarian"){
      if($db->query($sql) && $db->query($sqlveg)){
        
        $resultarray['status'] = true;
        return $this->response->setJson($resultarray);
      }
       
else{
 
    $resultarray['status'] = false;
    return $this->response->setJson($resultarray);
  } 

    }
  else if($category == "Non-Vegetarian"){
    if($db->query($sql) && $db->query($sqlnonveg)){
    
      $resultarray['status'] = true;
      return $this->response->setJson($resultarray);
    }
     
else{
 
  $resultarray['status'] = false;
  return $this->response->setJson($resultarray);
} 

  }
  else{

    $resultarray['status'] = false;
    return $this->response->setJson($resultarray);
  } 
     
  }
  else{

    $resultarray['status'] = false;
    return $this->response->setJson($resultarray);
  } 

    }
   //--------------------------------------------------------------------



   public function getmyrecipes(){
       
    $request = \Config\Services::request();
    $response =  \Config\Services::response();
    $db = \Config\Database::connect();
    $key = $request->getHeader('key');
    $mykey = $key->getValue('Key');
 
    if( $mykey == license)
    { 
      $username = $request->getVar('username');
      $pagenumber = $request->getVar('pagenumber');
      $sql = "SELECT * FROM ratingfoodtable WHERE  userid = '$username' ";
      $sql2 = "SELECT * FROM ratingVegfoodtable WHERE  userid = '$username' ";
      if (sizeof($db->query($sql)->getResult()) > 0 and sizeof($db->query($sql2)->getResult()) > 0){
        $sizearray = ceil(sizeof($db->query($sql)->getResult())/5 + sizeof($db->query($sql2)->getResult())/5 );
        $addedarray = array(); 
        $model = new ratingfoodtableModel();
        $model2 = new ratingVegfoodtableModel();
        $users = $model->where('userid',$username)->paginate(5,'users',$pagenumber);
        $users2 = $model2->where('userid',$username)->paginate(5,'users',$pagenumber);
        $bigerarray = array_merge($users2 , $users);
        $resultarray['datavalues'] = $bigerarray;
        $resultarray['status'] = true;
          $resultarray['totalpages'] = $sizearray;
        
          $resultarray['total'] = $sizearray;
          $resultarray['perpage'] = 5;
          if($pagenumber+1 <= $sizearray){
          $resultarray['nextpage']= $pagenumber+1;
        }else{
          $resultarray['nextpage']= null;
        }
        if($pagenumber-1 > 0 ){
          $resultarray['previouspage'] = $pagenumber-1;
        }else{
          $resultarray['previouspage'] = null;
        }
        return $this->response->setJSON($resultarray);

      }









    }
    
    else{

      $resultarray['status'] = false;
      return $this->response->setJson($resultarray);
    } 


    }
   //--------------------------------------------------------------------


   public function geturfavoritecooks(){
       
    //with description details and rating 

    }
   //--------------------------------------------------------------------

   public function geturprofile(){
       
    //with description details and rating 

    }
   //--------------------------------------------------------------------


}
