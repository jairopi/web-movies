<?php require_once('Connections/conexionredsocial.php'); ?>
<?php 

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['user'])) { ?>

<?php 
    
#Obtener usuario
$query_user = "SELECT * FROM users WHERE id = '".$_SESSION['user']."'";
$user = $pdo->query($query_user);
$user = $user->fetch();
    
#Obtener peliculas recomendadas
#$query_rec = "SELECT m.* FROM movie AS m INNER JOIN (SELECT movie_id FROM recs WHERE user_id = '".$_SESSION['user']."' ORDER BY time DESC  LIMIT 8 OFFSET 0) as r ON m.id = r.movie_id";
#$rec = $pdo->query($query_rec);

#Con subconsultas no funciona -> SELECT * FROM movie WHERE id IN (SELECT movie_id FROM recs WHERE user_id = 1 ORDER BY time DESC  LIMIT 8 OFFSET 0)
    
    
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
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    
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
    <script>
        
        function showResult(id) {
            
            var xmlhttp=new XMLHttpRequest();

            xmlhttp.onreadystatechange=function() {
                if (this.readyState==4 && this.status==200) {
                    document.getElementById("recommended").innerHTML=this.responseText;
                    document.getElementById("loading").style.visibility = 'hidden';
                }
            }
            xmlhttp.open("GET","recommendedAjax.php?id="+id, true);
            xmlhttp.send();
        }

    </script>

</head>
    
<body onload="showResult(<?php echo $_SESSION['user'];?>)">
    
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
            <a name="init"></a>
            <div class="mdl-grid android-more-section">
            
                
            <!-- Content goes here -->
                <style>
                    .header {
                        width: 100%;
                        text-align: center;
                    }
                    .header > img {
                        width: 150px;
                        height: 150px;
                        border-radius: 50%;
                    }
                    .user_text {
                        width: 100%;
                        text-align: center;
                        font-size: 24px;
                        margin-top: 24px;
                    }
                    #username {
                        font-size: 16px;
                        color: #767777;
                    }
                    .user_info {
                        width: 100%;
                        margin-bottom: 24px;
                        text-align: center;
                    }
                    
                </style>
                
                <div class="header">
                    <img src="images/<?php echo fn_FotoUsuario($_SESSION['user']);?>" class="demo-avatar">
                </div>
                <div class="user_text">
                    <span><?php echo $user['name']; ?></span>
                    <br>
                    <span id="username"><?php echo $user['username']; ?></span>
                </div>
                <div class="android-section-title mdl-typography--display-1-color-contrast" style="width:100%">
                    Account
                </div>
                <div class="user_info">
                    
                    <span class="mdl-chip mdl-chip--deletable">
                        <span class="mdl-chip__text"><?php echo $user['ocupation']; ?></span>
                        <button type="button" class="mdl-chip__action"><i class="material-icons">card_travel</i></button>
                    </span>
                    <span class="mdl-chip mdl-chip--deletable">
                        <span class="mdl-chip__text"><?php echo $user['age']; ?> years</span>
                        <button type="button" class="mdl-chip__action"><i class="material-icons">cake</i></button>
                    </span>
                    <span class="mdl-chip mdl-chip--deletable">
                        <span class="mdl-chip__text"><?php echo $user['sex']; ?></span>
                        <button type="button" class="mdl-chip__action"><i class="material-icons">person</i></button>
                    </span>
                    
                </div>
                
                <style>
                        .card {
                            color: #fff;
                            text-decoration-line: none;
                        }
                        #demo-card-image<?php echo $line_movies["id"];  ?> {
                            width: 248px;
                            height: 248px;
                            background: <?php echo fn_MostrarFotoPeliculaCSS($line_movies["url_pic"]);  ?>;
                            margin:4px;
                            z-index: 1;
                        }
                        #demo-card-image<?php echo $line_movies["id"];  ?> .hidden-descr {
                            top: 0;
                            background-color:rgba(0,0,0,0.7);
                            width: 100%;
                            height: 196px;
                            text-align: center;
                            z-index: 10;
                            opacity: 0;
                            -webkit-transition: all 0.5s ease;
                            -moz-transition: all 0.5s ease;
                            -o-transition: all 0.5s ease;
                            transition: all 0.5s ease;
                        }
                        #demo-card-image<?php echo $line_movies["id"];  ?> .hidden-descr:hover {
                            opacity:1;
                        }
                        #demo-card-image<?php echo $line_movies["id"];  ?> .hidden-descr p{
                            padding: 16px;
                            text-align: justify;
                            color: #fff;
                            text-decoration-line: none;
                            line-height: 20px;
                            font-size: 12px;
                        }
                        #demo-card-image<?php echo $line_movies["id"];  ?> .hidden-descr p:visited{
                            text-decoration-line: none;
                        }
                        #cam {
                            margin-top: 16px;
                            margin-left: 16px;
                            float: left;
                            width: 50&;
                        }
                        #star {
                            margin-top: 16px;
                            margin-right: 16px;
                            float: right;
                            width: 50%;
                            text-align: right;
                        }
                        #des {
                            clear: both;
                        }
                    #loading {
                        margin-left: calc(50% - 16px);
                    }
                    #recommended {
                        width: 100%;
                    }
                    </style>
                    
                <div class="android-section-title mdl-typography--display-1-color-contrast" style="width:100%">
                    <a name="recomended"></a>
                    Recomended Movies
                </div>
            
                <div id="recommended" class="android-card-container mdl-grid">
                    
                    <!-- Aqui van las peliculas recomendadas que se obtienen con una consulta mediante ajax-->
                    
                </div>
                <div id="loading" class="mdl-spinner mdl-js-spinner is-active"></div>
                
                
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