<?php require_once('Connections/conexionredsocial.php'); ?>
<?php 

if(!isset($_SESSION)) {
    session_start();
}

$uploadOk = 1;
$img_e = 0;

if(isset($_SESSION['user'])) {
    header("Location: user_home.php");
}else {
    if(isset($_POST['register'])) {
        if(empty($_POST['username']) || empty($_POST['name']) || empty($_POST['email']) || empty($_POST['passwd'])) {
            echo 'No dejes caracteres en blanco';
        } else {
            try {
                
                $pic = null;
                if (!empty($_FILES['photo'])) {
                    $val = 1;
                    $target_dir = 'images/users/';
                    $filename = basename( $_FILES['photo']['name']);
                    $target_file = $target_dir . $filename;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                    
                    // Check if file already exists
                    //if (file_exists($target_file)) {
                    //    echo "Sorry, file already exists.";
                    //    $uploadOk = 0;
                    //}
                    
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        $filename = $_POST['name'].".".$imageFileType;
                        $target_file = $target_dir . $filename;
                    }
                    
                    $pic = $filename;
                    
                    // Allow certain file formats
                    if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' ) {
                        echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                            $img_e = 1;
                        } else {
                            $img_e = 0;
                        }
                    }
 
                }
                
                $age = null;
                if(!empty($_POST['age'])) {
                    $age = $_POST['age'];
                }
                   
                $ocupation = null;
                if(!empty($_POST['professsion'])) {
                    $ocupation = $_POST['professsion'];
                }
                   
                $sex = null;
                if(!empty($_POST['options'])) {
                    $sex = $_POST['options'];
                }
                
                $query_register = "INSERT INTO users (name, username, passwd, email, url_pic, sex, age, ocupation) VALUES ('".$_POST['name']."', '".$_POST['username']."', '".sha1($_POST['passwd'])."', '".$_POST['email']."', '".$pic."', '".$sex."', ".$age.", '".$ocupation."')";
                
                
                if ($pdo->query($query_register) == 1) {
                    $query_login = "SELECT * FROM users WHERE email = '".$_POST['email']."' AND passwd = '".sha1($_POST['passwd'])."'";
                    $login = $pdo->query($query_login);
                    if($login = $login->fetch(PDO::FETCH_ASSOC)){
                        $_SESSION['user'] = $login['id'];
                        header("Location: user_home.php");
                    }
                } else {
                    echo $query_register;
                    //header("Location: register.php?e=1");
                }
            } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            }
        }
    } 
}

#Obtener distintos generos
$query_genres = 'SELECT * FROM genre';
$genres = $pdo->query($query_genres);

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
    <title><?php echo $movie["title"]; ?></title>

    <!-- Archivos necesarios para Material Design -->   
    <link rel="stylesheet" href="css/material.min.css">
    <link rel="stylesheet" href="css/register.css">
    <script src="mdl/material.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.blue-orange.min.css" />
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/mdl-selectfield.js"></script>
    <script src="js/dialog-polyfill.js"></script>
    <link rel="stylesheet" href="css/dialog-polyfill.css">
    <link rel="stylesheet" href="css/mdl-selectfield.css">
    
    <link rel="stylesheet" href="css/styles.css">
    
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
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        
        <!-- Barra navegacion -->
        <div class="android-header mdl-layout__header mdl-layout__header--waterfall">
            <div class="mdl-layout__header-row">

                <!-- Logo -->
                <span class="android-title mdl-layout-title">
                    <img class="android-logo-image" src="images/logo4.png">
                </span>

                <!-- Add spacer, to align navigation to the right in desktop -->
                <div class="android-header-spacer mdl-layout-spacer"></div>
                

                <!-- Opciones de la barra del navegador -->
                <div class="android-navigation-container">
                    <nav class="android-navigation mdl-navigation">
                        <a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php">All Movies</a>
                    </nav>
                </div>
                
                <span class="android-mobile-title mdl-layout-title">
                    <img class="android-logo-image" src="images/logo4.png">
                </span>
            </div>
        </div>
        <!-- Acaba la barra navegacion -->
        
        <!-- Contenido de la pagina -->
        <div class="android-content mdl-layout__content">
            <a name="top"></a>
            
            <div class="android-more-section">
                
                <div class="android-section-title mdl-typography--display-1-color-contrast">Create a new account</div>
                <div class="content-grid mdl-grid">
                    
                    
                    <div class="mdl-cell mdl-cell--6-col">
                        
                        <!-- Card -->
                        <div class="mdl-card mdl-shadow--3dp">
                            <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
                                <h4 class="mdl-typography--headline">Sign Up</h4>
                            </div>
                            <div class="mdl-card__supporting-text">
                                <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" id="register-form">
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" name="name" type="text" id="name">
                                        <label class="mdl-textfield__label" for="name">Name</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" name="username" type="text" id="username">
                                        <label class="mdl-textfield__label" for="username">Username</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" name="age" type="text" id="age">
                                        <label class="mdl-textfield__label" for="age">Age</label>
                                    </div>
                                    <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
                                        <select class="mdl-selectfield__select" id="professsion" name="professsion">
                                            <option value=""></option>
                                            <option value="administrator">administrator</option>
                                            <option value="artist">artist</option>
                                            <option value="doctor">doctor</option>
                                            <option value="educator">educator</option>
                                            <option value="engineer">engineer</option>
                                            <option value="entertainment">entertainment</option>
                                            <option value="executive">executive</option>
                                            <option value="healthcare">healthcare</option>
                                            <option value="homemaker">homemaker</option>
                                            <option value="lawyer">lawyer</option>
                                            <option value="librarian">librarian</option>
                                            <option value="marketing">marketing</option>
                                            <option value="none">none</option>
                                            <option value="other">other</option>
                                            <option value="programmer">programmer</option>
                                            <option value="retired">retired</option>
                                            <option value="salesman">salesman</option>
                                            <option value="scientist">scientist</option>
                                            <option value="student">student</option>
                                            <option value="technician">technician</option>
                                            <option value="writer">writer</option>
                                        </select>
                                        <div class="mdl-selectfield__icon"><i class="material-icons">arrow_drop_down</i></div>
                                        <label class="mdl-selectfield__label" for="professsion">Profession</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" name="email" type="email" id="email">
                                        <label class="mdl-textfield__label" for="email">Email</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" name="passwd" type="password" id="passwd">
                                        <label class="mdl-textfield__label" for="passwd">Password</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--file">
                                        <input class="mdl-textfield__input" placeholder="Photo" type="text" name="photo_text" id="uploadFile" readonly/>
                                        <div class="mdl-button mdl-button--primary mdl-button--icon mdl-button--file">
                                            <i class="material-icons">attach_file</i><input type="file" name="photo" id="uploadBtn" accept=".jpg,.png,.jpeg">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
                                            <input type="radio" id="option-1" class="mdl-radio__button" name="options" value="M">
                                            <span class="mdl-radio__label">Male</span>
                                        </label>
                                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
                                            <input type="radio" id="option-2" class="mdl-radio__button" name="options" value="F">
                                            <span class="mdl-radio__label">Female</span>
                                        </label>
                                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-3">
                                            <input type="radio" id="option-3" class="mdl-radio__button" name="options" value="N/A" checked>
                                            <span class="mdl-radio__label">N/A</span>
                                        </label>
                                    </div>
                                </form>
                                
                            </div>
                            <div class="mdl-card__actions mdl-card--border">
				                <button type="submit" name="register" value="Submit" form="register-form" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">Submit</button>
			                </div>
                        </div>
                        
                        

                    </div>
                    <div class="mdl-cell mdl-cell--3-col">
                    <!-- Espacio -->   
                    </div>
                </div>
            </div>
            
            <!-- Acaba el contenido de la pagina -->
            
            
            <!-- Footer -->
            
            <footer class="android-footer mdl-mega-footer">
                <div class="mdl-mega-footer--top-section">
                    <div class="mdl-mega-footer--left-section">
                        <button class="mdl-mega-footer--social-btn"></button>
                        &nbsp;
                        <button class="mdl-mega-footer--social-btn"></button>
                        &nbsp;
                        <button class="mdl-mega-footer--social-btn"></button>
                    </div>
                    <div class="mdl-mega-footer--right-section">
                        <a class="mdl-typography--font-light" href="#top">
                            Back to Top
                            <i class="material-icons">expand_less</i>
                        </a>
                    </div>
                </div>

                <div class="mdl-mega-footer--middle-section">
                    <p class="mdl-typography--font-light">Sergio López &amp; Jairo Peña: © 2016</p>
                </div>

                <div class="mdl-mega-footer--bottom-section">
                    <a class="android-link mdl-typography--font-light" href="">Privacy Policy</a>
                </div>
            </footer>
        </div>
        <!--Acaba el footer -->
    </div>
    
</body>
    <script>
        document.getElementById("uploadBtn").onchange = function () {
            document.getElementById("uploadFile").value = this.files[0].name;
        };
    </script>
</html>
