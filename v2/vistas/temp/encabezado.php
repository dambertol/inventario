<!DOCTYPE html>
<html>
    <head>
        <title> - LUM -   <?php echo $titulo; ?></title>
        <meta charset="utf-8">
        
        <?php if(!isset($bootStrap)){?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <?php } ?>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"/>

        <link rel="stylesheet" href="v2/src/css/styles.css?t=<?=date("His")?>">
        <link rel="stylesheet" href="v2/src/css/box.css?t=<?=date("His")?>">
        <link rel="stylesheet" href="v2/src/css/login.css?t=<?=date("His")?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo isset($extras)?$extras:"";?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    </head>

<body>
    <!-- <script
    src="https://code.jquery.com/jquery-3.7.0.js"
    integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
    crossorigin="anonymous"></script> -->


    <div class="icon-adm"></div>

    <div class="custom-nav">
        <div class="custom-nav-right">
            <div class="custom-a-right">
                <a href="<?php echo DIR; ?>/botonera"> Inicio </a>
                <?php if($titulo=="Registro" || $titulo=="Inicio"){
                    echo '<a href="'.DIR.'/inicio">Iniciar sesion </a>';
                }else{
                    //echo'<a href="'.DIR.'/salir"> Salir </a>';
                } ?>
            </div>
            <div class="custom-dropdown">
                <button class="custom-user-icon"> 
                    <b><?=$_SESSION['user_current']?></b> <img src="<?php echo DIR; ?>/v2/src/user-icon.png" alt="Usuario" width="30">
                </button>
                <div class="custom-dropdown-content">
                    <a href="<?php echo DIR; ?>/contrasena"> Mi Perfil </a>
                    <a href="<?php echo DIR; ?>/salir"> Desconectar </a>
                </div>
            </div>
        </div>
    </div>


    <?php if(!empty($message)) echo "<p>". $message. "</p>"; ?>
    <?php if(!empty($_SESSION['message'])){
        echo "<script> alert('". $_SESSION['message']. "')</script>";
        unset($_SESSION['message']);} ?>
