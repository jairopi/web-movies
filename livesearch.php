<?php require_once('Connections/conexionredsocial.php'); ?>
<?php
//get the q parameter from URL
$q=$_REQUEST["q"];

//Funciona bien:  SELECT title FROM movie WHERE title LIKE "Toy Story%" 
//"SELECT title FROM movie WHERE title LIKE '".$q."%'"

//Obtener datos de las peliculas
$query_movies = "SELECT * FROM movie WHERE title LIKE '".$q."%'";
$movies = $pdo->query($query_movies);

$n = $movies->rowCount();
if($n > 5) {
    $max = 5;
} else {
    $max = $n;
}

for($i = 0; $i < $max; $i++) {
    $line_movies = $movies->fetch(PDO::FETCH_ASSOC);
    echo '<a href="user_movie.php?id='.$line_movies['id'].'"><li class="mdl-menu__item">'.$line_movies['title'].'</li></a>';
}
?>