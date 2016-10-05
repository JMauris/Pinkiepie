<?php
class myProgramController extends Controller{


  /**
   * Method that controls the page 'myProgram.php'
   */
  function myProgram(){

    //The page cannot be displayed if no user connected
    if(!$this->getActiveUser()){
      $this->redirect('login', 'login');
      exit;
    }
  }







}

?>
