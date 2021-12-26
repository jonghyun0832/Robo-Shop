<?php
  session_start();
  $is_login = FALSE;
  if(isset( $_SESSION['user_id']) ) {
    $is_login = TRUE;
    $is_admin = $_SESSION['is_admin'];
  }
  else{
    $is_admin = 0;
  }
?>