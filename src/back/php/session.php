<?php
  session_start();
  $is_login = FALSE;
  if(isset( $_SESSION['user_id']) ) {
    $is_login = TRUE;
  }
?>