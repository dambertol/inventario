<?php
isset($_SESSION)?"":session_start();
session_unset();
  session_destroy();
  header("Location: ".DIR."/inicio");
   // echo "<script> window.location.href = '".DIRECCION."/inicio';</script>";
    return;
?>