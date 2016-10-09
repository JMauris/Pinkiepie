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







}

?>
