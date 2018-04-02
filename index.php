<?php require_once('Connections/conexionredsocial.php'); ?>
<?php 

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['user'])) {
    header("Location: user_home.php");
}else {
    if(isset($_POST['login'])) {
        if(empty($_POST['email']) || empty($_POST['passwd'])) {
            echo 'No dejes caracteres en blanco';
        } else {
            $query_login = "SELECT * FROM users WHERE (email = '".$_POST['email']."' OR name ='".$_POST['email']."' ) AND passwd = '".sha1($_POST['passwd'])."'";
            $login = $pdo->query($query_login);
            if($login = $login->fetch(PDO::FETCH_ASSOC)){
                $_SESSION['user'] = $login['id'];
                header("Location: user_home.php");
            } else{
                echo 'Datos incorrectos';
            }
        }
    } 
}

#Obtener distintos generos
$query_genres = 'SELECT * FROM genre';
$genres = $pdo->query($query_genres);


######### Paginacion #########

//Cantidad de resultados por página
$cantidad_resultados_por_pagina = 16;

//Obtener toda la base de datos
$query_allmovies = 'SELECT * FROM movie';
$allmovies = $pdo->query($query_allmovies);

$nmovies = $allmovies->rowCount();
$pages = ceil($nmovies/$cantidad_resultados_por_pagina);

//Comprueba si está seteado el GET de HTTP
if (isset($_GET["pagina"])) {

	//Si el GET de HTTP SÍ es una string / cadena, procede
	if (is_string($_GET["pagina"])) {

		//Si la string es numérica, define la variable 'pagina'
		 if (is_numeric($_GET["pagina"])) {

			 //Si la petición desde la paginación es la página uno
			 //en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
			 if ($_GET["pagina"] == 1) {
				 header("Location: index.php");
				 die();
			 } else if($_GET["pagina"] > $pages) {
                 header("Location: index.php");
				 die();
             } else { //Si la petición desde la paginación no es para ir a la pagina 1, va a la que sea
				 $pagina = $_GET["pagina"];
			};

		 } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
			 header("Location: index.php");
			 die();
		 };
	};

} else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
	$pagina = 1;
};


if (isset($_GET["order"])) {
    if ($_GET["order"] == 1) {
        $order_sentence = ' ORDER BY title ASC';
    }else if ($_GET["order"] == 2) {
        $order_sentence = ' ORDER BY title DESC';
    }else if ($_GET["order"] == 3) {
        $order_sentence = ' ORDER BY date ASC';
    }else if ($_GET["order"] == 4) {
        $order_sentence = ' ORDER BY date DESC';
    }
    
}else {
    $order_sentence = '';
}


//Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
$empezar_desde = (($pagina-1) * $cantidad_resultados_por_pagina);

#Obtener datos de las peliculas
$query_movies = 'SELECT * FROM movie'.$order_sentence.' LIMIT '.$cantidad_resultados_por_pagina.' OFFSET '.$empezar_desde;
$movies = $pdo->query($query_movies);

#################Necesario para calcular la puntuacion ponderada
$query_allmovies = "SELECT COUNT(*) FROM movie";
$allmovies = $pdo->query($query_allmovies);
$allmovie = $allmovies->fetch();
    
$query_scoremovies = "SELECT AVG(score) FROM user_score";
$scoremovies = $pdo->query($query_scoremovies);
$scoremovie = $scoremovies->fetch();
#################

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
                        <a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php#movies">All Movies</a>
                        <a class="mdl-navigation__link mdl-typography--text-uppercase show-modal" type="button">Login</a>
                        <a class="mdl-navigation__link mdl-typography--text-uppercase" href="register.php">Sign Up</a>
                    </nav>
                </div>
                
                <span class="android-mobile-title mdl-layout-title">
                    <img class="android-logo-image" src="images/logo4.png">
                </span>
                <button class="android-more-button mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect" id="more-button">
                    <i class="material-icons">import_export</i>
                </button>
                <ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right mdl-js-ripple-effect" for="more-button">
                    <?php if(isset($_GET['pagina'])) {$cpagina = '&pagina='.$_GET['pagina'];} else {$cpagina='';} ?>
                    <li class="mdl-menu__item"><a href="<?php echo $_SERVER['PHP_SELF'].'?0'.$cpagina?>">None</a></li>
                    <li class="mdl-menu__item"><a href="<?php echo $_SERVER['PHP_SELF'].'?order=1'.$cpagina?>">Name ASC</a></li>
                    <li class="mdl-menu__item"><a href="<?php echo $_SERVER['PHP_SELF'].'?order=2'.$cpagina?>">Name DESC</a></li>
                    <li class="mdl-menu__item"><a href="<?php echo $_SERVER['PHP_SELF'].'?order=3'.$cpagina?>">Date ASC</a></li>
                    <li class="mdl-menu__item"><a href="<?php echo $_SERVER['PHP_SELF'].'?order=4'.$cpagina?>">Date DESC</a></li>
                </ul>
            </div>
        </div>
        <!-- Acaba la barra navegacion -->
        
        <!-- Contenido de la pagina -->
        <div class="android-content mdl-layout__content">
            <a name="top"></a>
            <div class="android-be-together-section mdl-typography--text-center">
                <!-- Background image -->
            </div>
            
            <div class="android-more-section">
                <a name="movies"></a>
                <div class="android-section-title mdl-typography--display-1-color-contrast">
                    Movies
                </div>
                <div class="android-card-container mdl-grid">
                    
                    <?php while ($line_movies = $movies->fetch(PDO::FETCH_ASSOC)) { ?>
                    
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
                        .material-icons.yellow700 { color:#fdd835; }
                        .material-icons.light_green-A400 { color:#b2ff59; }
                        
                    </style>
                    <a href="movie.php?id=<?php echo $line_movies["id"];  ?>" class="card">
                        <div class="demo-card-image mdl-card mdl-shadow--2dp" id="demo-card-image<?php echo $line_movies["id"];  ?>">
                            <div class="hidden-descr">
                                <div id="cam"><i class="material-icons light_green-A400">movie</i> <?php echo fn_FechaPelicula($line_movies["id"]); ?></div>
                                <div id="star"><i class="material-icons yellow700">star</i> <?php echo round(fn_PuntuacionMediaPelicula($line_movies["id"])); ?></div>
                                <div id="des"><p > <?php echo $line_movies["desc"];  ?></p></div>
                            </div>
                            <div class="mdl-card__title mdl-card--expand"></div>
                            <div class="mdl-card__actions">
                                <span class="demo-card-image__filename"><?php echo $line_movies["title"];  ?></span>
                            </div>
                        </div>
                    </a>
                    <?php } ?>
  
                </div>
                <button class="mdl-button android-fab mdl-js-button mdl-button--fab mdl-button--colored mdl-js-ripple-effect" style="bottom: -106px;">
                    <i class="material-icons">chevron_right</i>
                </button>
                
            </div>
            <div style="background-color:#00bcd4; color:#fff;">
                <div class="android-more-section">
                    <div class="mdl-typography--display-2 mdl-typography--font-thin"></div>
                    <div style="text-align: center;">
                        <?php if(isset($_GET['order'])) {$corder = '&order='.$_GET['order'];} else {$corder='';} ?>
                        <?php if($pagina == 1) { ?>
                            
                            <a href="">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect" disabled>
                                    <i class="material-icons">first_page</i>
                                </button>
                            </a>
                            <a href="#">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect" disabled>
                                    <i class="material-icons">chevron_left</i>
                                </button>
                            </a>
                            <a href="#">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised">
                                    1
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina+1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    2
                                </button>
                            </a>                   
                            <a href="index.php?pagina=<?php echo $pagina+2; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    3
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina+3; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    4
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina+4; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    5
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina+1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_right</i>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pages; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">clast_page</i>
                                </button>
                            </a>
                        
                        <?php } else if($pagina == 2) { ?>
                        
                            <a href="index.php">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">first_page</i>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina-1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_left</i>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina-1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    1
                                </button>
                            </a>     
                            <a href="">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised">
                                    2
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina+1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    3
                                </button>
                            </a>                   
                            <a href="index.php?pagina=<?php echo $pagina+2; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    4
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina+3; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    5
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina+1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_right</i>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pages; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">clast_page</i>
                                </button>
                            </a>
                        
                        <?php } else if($pagina == $pages) { ?>
                        
                            <a href="index.php">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">first_page</i>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina-1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_left</i>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pages-4; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages-4; ?>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pages-3; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages-3; ?>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pages-2; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages-2; ?>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pages-1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages-1; ?>
                                </button>
                            </a>
                            <a href="#">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised">
                                    <?php echo $pages; ?>
                                </button>
                            </a>
                            <a href="#">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect" disabled>
                                    <i class="material-icons">chevron_right</i>
                                </button>
                            </a>
                            <a href="#">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect" disabled>
                                    <i class="material-icons">clast_page</i>
                                </button>
                            </a>
                        
                        <?php } else if($pagina == $pages -1) { ?>
                        
                            <a href="index.php">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">first_page</i>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina-1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_left</i>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pages-4; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages-4; ?>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pages-3; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages-3; ?>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pages-2; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages-2; ?>
                                </button>
                            </a>
                            <a href="#">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect  mdl-button--raised">
                                    <?php echo $pages-1; ?>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pages; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages; ?>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pages; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_right</i>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pages; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">clast_page</i>
                                </button>
                            </a>
                        
                        <?php } else { ?>
                        
                            <a href="index.php">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">first_page</i>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina-1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_left</i>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina-2; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pagina-2; ?>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina-1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pagina-1; ?>
                                </button>
                            </a>
                            <a href="#">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised">
                                    <?php echo $pagina; ?>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina+1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pagina+1; ?>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina+2; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pagina+2; ?>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pagina+1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_right</i>
                                </button>
                            </a>
                            <a href="index.php?pagina=<?php echo $pages; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">clast_page</i>
                                </button>
                            </a>
                        
                        <?php } ?>
                    
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

    <dialog class="mdl-dialog">
        <h4 class="mdl-dialog__title">Login</h4>
        <div class="mdl-dialog__content">
            <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" id="login-form">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="email" type="text" id="email">
                    <label class="mdl-textfield__label" for="email">Email o nombre</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" name="passwd" type="password" id="passwd">
                    <label class="mdl-textfield__label" for="passwd">Password</label>
                </div>
            </form>
        </div>
        <div class="mdl-dialog__actions">
            <button type="submit" name="login" value="Submit" form="login-form" class="mdl-button mdl-button--primary">Login</button>
            <button type="button" class="mdl-button mdl-button--primary close">Cancel</button>
        </div>
    </dialog>
    <script>
        var dialog = document.querySelector('dialog');
        var showModalButton = document.querySelector('.show-modal');
        if (! dialog.showModal) {
            dialogPolyfill.registerDialog(dialog);
        }
        showModalButton.addEventListener('click', function() {
            dialog.showModal();
        });
        dialog.querySelector('.close').addEventListener('click', function() {
            dialog.close();
        });
    </script>
    
</body>
</html>
