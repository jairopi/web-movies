<?php require_once('Connections/conexionredsocial.php'); ?>
<?php 

#Obtener distintos generos
$query_genres = 'SELECT * FROM genre';
$genres = $pdo->query($query_genres);

$arr_genres;
$cont = 0;

while ($line_genres = $genres->fetch(PDO::FETCH_ASSOC)) {
    $arr_genres[$cont] = $line_genres["name"];
    $cont = $cont+1;
}

#Obtener datos de las peliculas
$query_movies = 'SELECT * FROM movie WHERE id='.$_GET["id"];
$movies = $pdo->query($query_movies);
$movie = $movies->fetch();

#Obtener datos de las peliculas
$query_moviesgenre = 'SELECT * FROM moviegenre WHERE movie_id='.$_GET["id"];
$moviesgenre = $pdo->query($query_moviesgenre);

#Obtener comentarios de las peliculas
$query_moviescomments = 'SELECT * FROM moviecomments WHERE movie_id='.$_GET["id"];
$moviescomments = $pdo->query($query_moviescomments);

#Necesario para calcular la puntuacion ponderada
$query_allmovies = "SELECT COUNT(*) FROM movie";
$allmovies = $pdo->query($query_allmovies);
$allmovie = $allmovies->fetch();
    
$query_scoremovies = "SELECT AVG(score) FROM user_score";
$scoremovies = $pdo->query($query_scoremovies);
$scoremovie = $scoremovies->fetch();

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
    <script src="mdl/material.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.blue-orange.min.css" />
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
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
                        <a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php">All Movies</a>
                        <a class="mdl-navigation__link mdl-typography--text-uppercase" href="register.php">Sign Up</a>
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
                
                <div class="android-section-title mdl-typography--display-1-color-contrast"><?php echo $movie["title"]; ?></div>
                <div class="content-grid mdl-grid">
                    <div class="mdl-cell mdl-cell--8-col">
                        
                        <style>
                            .mdl-card {
                                margin-bottom: 16px;
                                min-height: 0px;
                            }
                            .mdl-cell--8-col > .mdl-card {
                                background-size: cover;
                                width: auto;
                            } 
                            .material-icons.yellow700 { 
                                color:#fdd835; 
                            }
                        </style>
                        <!-- Card -->
                        <div class="mdl-card mdl-shadow--3dp">
                            <div class="mdl-card__title">
                                <h4 class="mdl-typography--headline">Movie</h4>
                            </div>
                            <div class="mdl-card__supporting-text">
                                <p>Original Title: <b><?php echo $movie["title"]; ?></b></p>
                                <p>Release Date: <b><?php echo $movie["date"]; ?></b></p>
                                <p>Genre:   
                                    <b><?php while ($line_moviegenre = $moviesgenre->fetch(PDO::FETCH_ASSOC)) {
                                                for ($i=0; $i < $cont; $i++) {
                                                    if($line_moviegenre[$i] == 1) { ?>
                                                        <button type="button" class="mdl-chip">
                                                            <span class="mdl-chip__text"> <?php echo $arr_genres[$i]; ?></span>
                                                        </button>
                                                   <?php }
                                                }
                                            }?>
                                    </b>
                                </p>
                                <br>
                                <p>Synopsis: <b><?php echo $movie["desc"]; ?></b></p>
                                
                            </div>
                        </div>
                        <!-- Card -->
                        
                        <!-- Card -->
                        <div class="mdl-card mdl-shadow--3dp">
                            <div class="mdl-card__title">
                                <h4 class="mdl-typography--headline">Critics</h4>
                            </div>
                            <?php if($moviescomments->rowCount() == 0) { ?>
                                <div class="mdl-card__actions mdl-card--border">
                                    <p>There are no comments for this movie. <a href="register.php">Sign up</a> or login to post a comment.<p>
                                </div>
                            <?php } ?>
                            <?php while ($line_moviecomments = $moviescomments->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="mdl-card__actions mdl-card--border">
                                    <button type="button" class="mdl-chip">
                                        <span class="mdl-chip__text"> <?php echo fn_MostrarNombreUsuario($line_moviecomments["user_id"]); ?> </span>
                                    </button>
                                    <p style="display:inline"> <?php echo $line_moviecomments["comment"]; ?> </p>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Card -->
                        

                    </div>
                    <div class="mdl-cell mdl-cell--4-col">
                        
                        <!-- Card -->
                        <div class="mdl-card mdl-shadow--3dp"  id="card_img">
                            <div class="mdl-card__media">
                                <img src="<?php echo fn_MostrarFotoPelicula($movie["url_pic"]); ?>" id="img_movie">
                            </div>
                            <div class="mdl-card__actions mdl-card--border">
                                <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="<?php echo $movie["url_imdb"]; ?>">
                                    IMDB
                                </a>
                            </div>
                        </div>
                        <!-- Card -->
                        
                        <!-- Card -->
                        <div class="mdl-card mdl-shadow--3dp" id="card_rat">
                            <div class="mdl-card__title">
                                <h4 class="mdl-typography--headline">Rating</h4>
                            </div>
                            <div class="mdl-card__supporting-text">
                                <p><?php echo fn_TotalPuntuaciones($movie['id']); ?> Scores</p> 
                                <p id="media">Mean score &nbsp&nbsp&nbsp&nbsp&nbsp 
                                <?php 
                                    $m = fn_PuntuacionMediaPelicula($movie['id']);
                                    $mr = round($m);
                                    $cont = $mr;
                                    while($mr > 0) {
                                        echo '<i class="material-icons yellow700">star</i>';
                                        $mr = $mr-1;
                                    } while($cont < 5) {
                                        echo '<i class="material-icons">star_border</i>';
                                        $cont = $cont +1;
                                    }
                                    
                                ?>
                                </p>
                                <div class="mdl-tooltip" data-mdl-for="media">
                                        <?php echo $m;?>
                                </div>
                                <p id="ponderada">Weighted score 
                                <?php
                                    $p = fn_PuntuacionPonderadaPelicula($movie['id'],$allmovie[0],$scoremovie[0]);
                                    $pr = round($p);
                                    $cont = $pr;
                                    while($pr > 0) {
                                        echo '<i class="material-icons yellow700">star</i>';
                                        $pr = $pr-1;
                                    } while($cont < 5) {
                                        echo '<i class="material-icons">star_border</i>';
                                        $cont = $cont +1;
                                    }
                                    
                                ?>
                                </p>
                                <div class="mdl-tooltip" data-mdl-for="ponderada">
                                        <?php echo $p;?>
                                </div>
                            </div>
                        </div>
                        <!-- Card -->
                        
                        
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
    
    <script> 
        $(document).ready(function(){
            var width = $('#img_movie').width();
            $('#card_img').width(width); 
            $('#card_rat').width(width);
        });
    </script>
</body>
</html>
