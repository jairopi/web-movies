<?php require_once('Connections/conexionredsocial.php'); ?>
<?php 

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['user'])) { ?>

<?php
    
#Puntuar peliculas
if(isset($_POST['rate'])) {
    if(empty($_POST['puntuation'])) {
        echo "Selecciona un valor";
    } else {
        try {
            $query_rate = "SELECT * FROM user_score WHERE id_user = '".$_SESSION['user']."' AND id_movie = '".$_GET["id"]."'";
            $getscore = $pdo->query($query_rate);
            $scoreline = $getscore->fetch();
            if(empty($scoreline[0])) {
                $query_rate = "INSERT INTO user_score (id_user, id_movie, score) VALUES ('".$_SESSION['user']."', '".$_GET["id"]."', '".$_POST['puntuation']."')";
                $pdo->query($query_rate);
            } else {
                $query_rate = "UPDATE user_score SET score = '".$_POST['puntuation']."' WHERE id_user = '".$_SESSION['user']."' AND id_movie = '".$_GET["id"]."'";
                $pdo->query($query_rate);
            }
 
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
    
#Comentar peliculas
if(isset($_POST['comment'])) {
    if(empty($_POST['critic'])) {
        echo "Escribe una critica antes";
    } else {
        try {
            $query_critic = "INSERT INTO moviecomments (user_id, movie_id, comment) VALUES ('".$_SESSION['user']."', '".$_GET["id"]."', '".$_POST['critic']."')";
            $pdo->query($query_critic);
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
    
#Obtener puntuacion
$query_score = "SELECT score FROM user_score WHERE id_user = '".$_SESSION['user']."' AND id_movie = '".$_GET["id"]."' ORDER BY time DESC LIMIT 0,1";
$score = $pdo->query($query_score);
$score = $score->fetch();
    
#Obtener usuario
$query_user = "SELECT * FROM users WHERE id = '".$_SESSION['user']."'";
$user = $pdo->query($query_user);
$user = $user->fetch();

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
    <title>Movies</title>

    <!-- Archivos necesarios para Material Design -->   
    <link rel="stylesheet" href="css/material.min.css">
    <script src="mdl/material.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.cyan-green.min.css" />
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/mdl-selectfield.js"></script>
    <script src="js/dialog-polyfill.js"></script>
    <link rel="stylesheet" href="css/dialog-polyfill.css">
    <link rel="stylesheet" href="css/mdl-selectfield.css">
    
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
        
        function showResult(id1,id2) {
            
            var xmlhttp=new XMLHttpRequest();

            xmlhttp.onreadystatechange=function() {
                if (this.readyState==4 && this.status==200) {
                    document.getElementById("recommended").innerHTML=this.responseText;
                    document.getElementById("loading").style.visibility = 'hidden';
                }
            }
            xmlhttp.open("GET","similarMovies.php?id1="+id1+"&id2="+id2, true);
            xmlhttp.send();
        }

    </script>

</head>
    
<body onload="showResult(<?php echo $_GET["id"];?>,<?php echo $_SESSION['user'];?>)">
    
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
                            .mdl-selectfield {
                                width: 100px;
                            }
                            .material-icons.yellow700 { 
                                color:#fdd835; 
                            }
                            .mdl-textfield {
                                width: 100%;
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
                                    <b>
                                    <?php while ($line_moviegenre = $moviesgenre->fetch(PDO::FETCH_ASSOC)) {
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
                            <?php while ($line_moviecomments = $moviescomments->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="mdl-card__actions mdl-card--border">
                                    <button type="button" class="mdl-chip">
                                        <span class="mdl-chip__text"> <?php echo fn_MostrarNombreUsuario($line_moviecomments["user_id"]); ?> </span>
                                    </button>
                                    <p style="display:inline"> <?php echo $line_moviecomments["comment"]; ?> </p>
                                </div>
                            <?php }?>
                            <div class="mdl-card__actions mdl-card--border">
                                <form action="<?=$_SERVER['PHP_SELF'].'?id='.$_GET["id"];?>" method="post" id="critics-form">
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <textarea class="mdl-textfield__input" type="text" name="critic" id="critic" ></textarea>
                                        <label class="mdl-textfield__label" for="critic">Post your critic</label> 
                                    </div> 
                                    <button type="submit" name="comment" value="Submit" form="critics-form" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">Comment Now!</button>  
                                </form>
                            </div>
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
                        <style>
                            
                        </style>
                        <div class="mdl-card mdl-shadow--3dp" id="card_rat">
                            <div class="mdl-card__title">
                                <h4 class="mdl-typography--headline">Rating</h4>
                            </div>
                            <div class="mdl-card__supporting-text">
                                <form action="<?=$_SERVER['PHP_SELF'].'?id='.$_GET["id"];?>" method="post" id="rate-form">
                                    <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
                                        <select class="mdl-selectfield__select" id="puntuation" name="puntuation">
                                            <option value=""></option>
                                            <option <?php if($score['score']==1) {echo 'selected="selected"';}?> value="1">1</option>
                                            <option <?php if($score['score']==2) {echo 'selected="selected"';}?> value="2">2</option>
                                            <option <?php if($score['score']==3) {echo 'selected="selected"';}?> value="3">3</option>
                                            <option <?php if($score['score']==4) {echo 'selected="selected"';}?> value="4">4</option>
                                            <option <?php if($score['score']==5) {echo 'selected="selected"';}?> value="5">5</option>
                                        </select>
                                        <div class="mdl-selectfield__icon"><i class="material-icons">arrow_drop_down</i></div>
                                        <label class="mdl-selectfield__label" for="puntuation">Score</label>
                                    </div>
                                    <button type="submit" name="rate" value="Submit" form="rate-form" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">Rate Now!</button>
                                </form>
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
                
                <!-- peliculas similares -->
                <div class="android-section-title mdl-typography--display-1-color-contrast" style="width:100%">
                    <a name="recomended"></a>
                    Movies Related To This Movie
                </div>
            
                <div id="recommended" class="android-card-container mdl-grid">
                    
                    <!-- Aqui van las peliculas recomendadas que se obtienen con una consulta mediante ajax-->
                    
                </div>
                <div id="loading" class="mdl-spinner mdl-js-spinner is-active"></div>
                <!-- peliculas similares -->
                
                
            </div>
            
        
        </main>
        
      
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

<?php } else {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
    exit;
} ?>