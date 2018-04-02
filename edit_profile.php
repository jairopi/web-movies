<?php require_once('Connections/conexionredsocial.php'); ?>
<?php 

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['user'])) { ?>

<?php 
    
    
    
    
if(isset($_POST['register'])) {
    if(empty($_POST['username']) || empty($_POST['name']) || empty($_POST['email'])) {
        echo 'No dejes caracteres en blanco';
    } else {
        try {


            $query_register = "UPDATE users SET name ='".$_POST['name']."', username='".$_POST['username']."', email='".$_POST['email']."', url_pic='".$_POST['photo_text']."', age=".$_POST['age']." WHERE id =".$_SESSION['user'];
            $pdo->query($query_register);


        } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        }
    }
} 
    
    
    
    
#Obtener usuario
$query_user = "SELECT * FROM users WHERE id = '".$_SESSION['user']."'";
$user = $pdo->query($query_user);
$user = $user->fetch();

?>

<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class=""><!-- InstanceBegin template="/Templates/register.dwt" codeOutsideHTMLIsLocked="false" -->
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Introducing Movies">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    
    <!-- Titulo -->
    <title>Movies</title>

    <!-- Archivos necesarios para Material Design -->   
    <link rel="stylesheet" href="css/material.min.css">
    <script src="mdl/material.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.cyan-green.min.css" />
    <script src="js/dialog-polyfill.js"></script>
    <link rel="stylesheet" href="css/dialog-polyfill.css">
    
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/user_styles.css">

    <!-- 
    To learn more about the conditional comments around the html tags at the top of the file:
    paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/

    Do the following if you're using your customized build of modernizr (http://www.modernizr.com/):
    * insert the link to your js here
    * remove the link below to the html5shiv
    * add the "no-js" class to the html tags at the top
    * you can also remove the link to respond.min.js if you included the MQ Polyfill in your modernizr build 
    -->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- InstanceBeginEditable name="head" -->
    <!-- InstanceEndEditable -->

</head>
    
<body>
    
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
        <header class=" android-header mdl-layout__header mdl-color-text--grey-600">
            <div class="mdl-layout__header-row">
            
                <span class="android-title mdl-layout-title">
                        <img class="android-logo-image" src="images/logo4.png">
                </span>
                <div class="mdl-layout-spacer"></div>

            </div>
        </header>
        <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
          
            <header class="demo-drawer-header">
                <img src="images/<?php echo fn_FotoUsuario($_SESSION['user']);?>" class="demo-avatar">
                <span><?php echo $user['name']; ?></span>
                <div class="demo-avatar-dropdown">

                    <span><?php echo $user['email']; ?></span>
                    <div class="mdl-layout-spacer"></div>
                    
                </div>
            </header>

            <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
                <a class="mdl-navigation__link" href="user_home.php">
                    <i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Movies
                </a>
                <a class="mdl-navigation__link" href="user_profile.php#recomended">
                    <i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">whatshot</i>Recommended
                </a>
                <a class="mdl-navigation__link" href="user_profile.php">
                    <i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person</i>User
                </a>
                <a class="mdl-navigation__link" href="edit_profile.php">
                    <i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">edit</i>Edit Profile
                </a>
                <a class="mdl-navigation__link" href="logout.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">close</i>Logout</a>
                <div class="mdl-layout-spacer"></div>
                <a class="mdl-navigation__link" href="">
                    <i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help_outline</i><span class="visuallyhidden">Help</span>
                </a>
            </nav>
            
        </div>
        
        <main class="mdl-layout__content mdl-color--grey-100">
            <div class="mdl-grid android-more-section">
                
                
                <!-- Content goes here -->
                
                <div class="content-grid mdl-grid" style="width:100%">
                    <style>
                        .mdl-card {
                            margin-bottom: 16px;
                            min-height: 0px;
                            width: 100%;
                        }
                        .mdl-card__actions > .info_input {
                            width: 20%;
                            display: inline-block;
                        }
                        .mdl-card__actions > .input_self {
                            width: 80%;
                            display: inline;
                        }

                    </style>
                    <div class="mdl-cell mdl-cell--1-col">
                        
                    </div>
                    <div class="mdl-cell mdl-cell--7-col">
                        
                        
                        <style>
                            .mdl-card {
                                margin-bottom: 16px;
                                min-height: 0px;
                            }
                            .mdl-cell--6-col > .mdl-card {
                                background-size: cover;
                                width: auto;
                            }
                            
                            
                            .mdl-button--file input {
                              cursor: pointer;
                              height: 100%;
                              right: 0;
                              opacity: 0;
                              position: absolute;
                              top: 0;
                              width: 300px;
                              z-index: 4;
                            }

                            .mdl-textfield--file .mdl-textfield__input {
                              box-sizing: border-box;
                              width: calc(100% - 32px);
                            }
                            .mdl-textfield--file .mdl-button--file {
                              right: 0;
                            }
                        </style>
                        <!-- Card -->
                        <div class="mdl-card mdl-shadow--3dp">
                            <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
                                <h4 class="mdl-typography--headline">Personal Information</h4>
                            </div>
                            <div class="mdl-card__supporting-text">
                                <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" id="register-form">
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" name="name" type="text" id="name" value="<?php echo $user['name'];?>">
                                        <label class="mdl-textfield__label" for="name">Name</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" name="username" type="text" id="username" value="<?php echo $user['username'];?>">
                                        <label class="mdl-textfield__label" for="username">Username</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" name="age" type="text" id="age" value="<?php echo $user['age'];?>">
                                        <label class="mdl-textfield__label" for="age">Age</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" name="email" type="email" id="email" value="<?php echo $user['email'];?>">
                                        <label class="mdl-textfield__label" for="email">Email</label>
                                    </div>
                                </form>
                                
                            </div>
                            <div class="mdl-card__actions mdl-card--border">
				                <button type="submit" name="register" value="Submit" form="register-form" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">Submit</button>
			                </div>
                        </div>
                        
                        
                        
                        
                    </div>
                    <div class="mdl-cell mdl-cell--4-col">
                        
                    </div>
                </div>
                
                
            <!-- Content goes here -->
            
            </div>
        </main>
        
      
    </div>
    
</body>
</html>

<?php } else {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
    exit;
} ?>