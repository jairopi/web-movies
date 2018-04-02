<?php require_once('Connections/conexionredsocial.php'); ?>
<?php 

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['user'])) { ?>

<?php 

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
			 //en lugar de ir a 'user_movies.php?pagina=1' se iría directamente a 'user_movies.php'
			 if ($_GET["pagina"] == 1) {
                 echo "<script language=Javascript> location.href=\"./user_home.php\"; </script>";
				 die();
			 } else if($_GET["pagina"] > $pages) {
                 echo "<script language=Javascript> location.href=\"./user_home.php\"; </script>";
                 echo 'hola';
				 die();
             } else { //Si la petición desde la paginación no es para ir a la pagina 1, va a la que sea
				 $pagina = $_GET["pagina"];
			};

		 } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
			 echo "<script language=Javascript> location.href=\"./user_home.php\"; </script>";
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

#Obtener usuario
$query_user = "SELECT * FROM users WHERE id = '".$_SESSION['user']."'";
$user = $pdo->query($query_user);
$user = $user->fetch();

#Obtener distintos generos
$query_genres = 'SELECT * FROM genre';
$genres = $pdo->query($query_genres);    
    
############## Necesario para calcular la puntuacion ponderada
$query_allmovies = "SELECT COUNT(*) FROM movie";
$allmovies = $pdo->query($query_allmovies);
$allmovie = $allmovies->fetch();
    
$query_scoremovies = "SELECT AVG(score) FROM user_score";
$scoremovies = $pdo->query($query_scoremovies);
$scoremovie = $scoremovies->fetch();
##############

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
                
                <!-- Prueba de serch -->
                
                <script>
                    function showResult(str) {
                        
                      if (str.length==0) { 
                        document.getElementById("livesearch").innerHTML="";
                        document.getElementById("livesearch").style.border="0px";
                        return;
                      }
                      var xmlhttp=new XMLHttpRequest();
                  
                      xmlhttp.onreadystatechange=function() {
                        if (this.readyState==4 && this.status==200) {
                          document.getElementById("livesearch").innerHTML=this.responseText;
                          componentHandler.upgradeDom('MaterialMenu', 'mdl-menu');
                        }
                      }
                      xmlhttp.open("GET","livesearch.php?q="+str, true);
                      xmlhttp.send();
                    }
                </script>
                <style>
                    .mdl-menu li {
                        color: black;
                    }
                    .mdl-menu ul {
                        background-color: white;
                    }
                
                </style>
                <div class="android-search-box mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right mdl-textfield--full-width" id="search">
                    <label class="mdl-button mdl-js-button mdl-button--icon" for="search-field">
                        <i class="material-icons">search</i>
                    </label>
                    <div class="mdl-textfield__expandable-holder">
                        <input class="mdl-textfield__input" type="text" id="search-field" onkeyup="showResult(this.value)">                   
                    </div>
                </div>
                
                <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" id="livesearch" for="search">
                <!-- Resultados buscador -->       
                </ul>
                
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
                <a name="movies"></a>
                <div class="android-section-title mdl-typography--display-1-color-contrast" style="width:100%;">
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
                    <a href="user_movie.php?id=<?php echo $line_movies["id"];  ?>" class="card">
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
            </div>
            
            
            <div style="background-color:#00bcd4; color:#fff;">
                <div class="android-more-section">
                    <div class="mdl-typography--display-2 mdl-typography--font-thin"></div>
                    <div style="text-align: center;">
                        <?php if(isset($_GET['order'])) {$corder = '&order='.$_GET['order'];} else {$corder='';} ?>
                        <?php if($pagina == 1) { ?>
                            
                            <a href="#">
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
                            <a href="user_home.php?pagina=<?php echo $pagina+1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    2
                                </button>
                            </a>                   
                            <a href="user_home.php?pagina=<?php echo $pagina+2; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    3
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina+3; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    4
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina+4; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    5
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina+1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_right</i>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pages; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">clast_page</i>
                                </button>
                            </a>
                        
                        <?php } else if($pagina == 2) { ?>
                        
                            <a href="user_home.php">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">first_page</i>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina-1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_left</i>
                                </button>
                            </a>
                            <a href="user_home.php">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    1
                                </button>
                            </a>     
                            <a href="#">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised">
                                    2
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina+1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    3
                                </button>
                            </a>                   
                            <a href="user_home.php?pagina=<?php echo $pagina+2; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    4
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina+3; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    5
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina+1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_right</i>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pages; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">clast_page</i>
                                </button>
                            </a>
                        
                        <?php } else if($pagina == $pages) { ?>
                        
                            <a href="user_home.php">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">first_page</i>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina-1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_left</i>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pages-4; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages-4; ?>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pages-3; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages-3; ?>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pages-2; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages-2; ?>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pages-1; ?><?php echo $corder;?>">
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
                        
                            <a href="user_home.php">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">first_page</i>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina-1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_left</i>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pages-4; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages-4; ?>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pages-3; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages-3; ?>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pages-2; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages-2; ?>
                                </button>
                            </a>
                            <a href="#">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect  mdl-button--raised">
                                    <?php echo $pages-1; ?>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pages; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pages; ?>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pages; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_right</i>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pages; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">clast_page</i>
                                </button>
                            </a>
                        
                        <?php } else { ?>
                        
                            <a href="user_home.php">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">first_page</i>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina-1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_left</i>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina-2; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pagina-2; ?>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina-1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pagina-1; ?>
                                </button>
                            </a>
                            <a href="#">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised">
                                    <?php echo $pagina; ?>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina+1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pagina+1; ?>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina+2; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <?php echo $pagina+2; ?>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pagina+1; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">chevron_right</i>
                                </button>
                            </a>
                            <a href="user_home.php?pagina=<?php echo $pages; ?><?php echo $corder;?>">
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                                    <i class="material-icons">clast_page</i>
                                </button>
                            </a>
                        
                        <?php } ?>
                    
                    </div>
                </div>
            </div>
            
            
        </main>
        
    </div>
</body>
</html>

<?php } else {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
    exit;
} ?>