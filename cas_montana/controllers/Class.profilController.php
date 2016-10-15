<?php
class profilController extends Controller{


  /**
   * Method that controls the page 'myProgram.php'
   */
  function profil(){
    //The page cannot be displayed if no user connected
    if(!$this->getActiveUser()){
      $this->redirect('login', 'login');
      exit;
    }

    //Get message from connection process
    $this->vars['msg'] = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
  }


  function save()

  { //update
    $user = $_SESSION['personne'];

    $adress=$_POST['adress'];
    $npa = $_POST['npa'];
    $locality = $_POST['localite'];
    $phone = $_POST['phone'];
    $mobile = $_POST['mobile'];




      $user->setAdresse($adress);
      $user->setNpa($npa);
      $user->setLocalite($locality);
      $user->setPhone($phone);
      $user->setPortable($mobile);


      $user->update($user->getId());
    

	     $this->redirect('profil', 'profil');

  }







}

?>
