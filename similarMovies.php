<?php require_once('Connections/conexionredsocial.php'); ?>
<?php 

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['user'])) { 
    
    $idmovie = $_REQUEST["id1"];
    $iduser = $_REQUEST["id2"];
    
    #Obtener peliculas recomendadas
    $query_date = "SELECT time FROM similarmovies WHERE user_id = ".$iduser." AND movie_id = ".$idmovie." ORDER BY time DESC LIMIT 1 OFFSET 0";
    $date = $pdo->query($query_date);
    
    $date = $date->fetch();
    $datedb = strtotime($date[0]);
    
    ## Si la ultima recomendacion se hizo antes de 5 min no se vuelve a ejecutar el algoritmo
    if(time() > $datedb+300) {
        
        ####################################################################
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_connect($socket,'127.0.0.1',1111);
        
        ## Funcion matlab similarMovies(idusuario,idpelicula) ##
        $ruta="/home/alumnos/ai2/matlab\r\n";
        $fun="similarMovies(".$iduser.",".$idmovie.")\r\n";
        #$fun=$id+'\r\n\r\n';

        $info = $ruta.$fun.chr(0);
        #$info = $fun;

        $sent = socket_write($socket, $info, strlen($info));

        ## Envia correctamente el id de usuario e id de pelicula y lo procesa el script de Matlab


        socket_close($socket);
        ####################################################################

        sleep(60);
        
    }
    

    //get the q parameter from URL
    //Funciona bien:  SELECT title FROM movie WHERE title LIKE "Toy Story%" 
    //"SELECT title FROM movie WHERE title LIKE '".$q."%'"
    //Obtener datos de las peliculas
    #Obtener peliculas recomendadas
    $query_rec = "SELECT m.* FROM movie AS m INNER JOIN (SELECT rec_movie FROM similarmovies WHERE user_id = ".$iduser." AND movie_id = ".$idmovie." ORDER BY time DESC  LIMIT 4 OFFSET 0) as r ON m.id = r.rec_movie";
    $rec = $pdo->query($query_rec);


     while ($line_movies = $rec->fetch(PDO::FETCH_ASSOC)) { ?>

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
            .material-icons.yellow700 { 
                    color:#fdd835; 
            }
            .material-icons.light_green-A400 { 
                color:#b2ff59; 
            }
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

    <?php } 

} else {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
    exit;
} ?>


