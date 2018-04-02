<?php if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


function fn_MostrarFotoPeliculaCSS($identificador) 
{
	if(is_file("images/movies/images/".$identificador)) {
        return "url('images/movies/images/".$identificador."') center / cover";
	}
	else {
        return "url('images/movies/images/1994.jpg') center / cover";
	}
}

function fn_MostrarFotoPelicula($identificador) 
{
	if(is_file("images/movies/images/".$identificador)) {
        return "images/movies/images/".$identificador;
	}
	else {
        return "images/movies/images/1994.jpg";
	}
}

function fn_MostrarNombreUsuario($identificador) 
{
    global $pdo;
    
    $query_user = "SELECT * FROM users WHERE id = '".$identificador."'";
    $users = $pdo->query($query_user);
    $user = $users->fetch();
    
    return $user['name'];
}

function fn_FotoUsuario($identificador) 
{
    global $pdo;
    
    $query_user = "SELECT * FROM users WHERE id = '".$identificador."'";
    $users = $pdo->query($query_user);
    $user = $users->fetch();
    if($user['url_pic']== null) {
        return 'user.jpg';
    } else {
        return 'users/'.$user['url_pic'];
    }
}

function fn_PuntuacionMediaPelicula($identificador) 
{
    global $pdo;
    
    $query_score = "SELECT AVG(score) FROM user_score WHERE id_movie =".$identificador;
    $score = $pdo->query($query_score);
    $media = $score->fetch();
    
    return $media[0];
    
}

function fn_PuntuacionPonderadaPelicula($identificador,$nPeliculas,$meanPeliculas) 
{
    global $pdo;
    
    $N = $nPeliculas/20; #N es un valor proporcional a los datos, si es el numero de peliculas no se ajusta a la realidad
    $R = $meanPeliculas;
    $ri = fn_PuntuacionMediaPelicula($identificador);
    
    $query_movies = "SELECT COUNT(*) FROM user_score WHERE id_movie =".$identificador;
    $movies = $pdo->query($query_movies);
    $ni = $movies->fetch();
    
    $ponderada = (($N*$R)+($ri*$ni[0]))/($N+$ni[0]);
    return $ponderada;
    
}

function fn_TotalPuntuaciones($identificador) 
{
    global $pdo;
    
    $query_rev = "SELECT COUNT(*) FROM user_score WHERE id_movie =".$identificador;
    $rev = $pdo->query($query_rev);
    $rev = $rev->fetch();
    
    return $rev[0];
    
}


function fn_FechaPelicula($identificador) 
{
    global $pdo;
    
    $query_date = "SELECT date FROM movie WHERE id =".$identificador;
    $date = $pdo->query($query_date);
    $date = $date->fetch();
    
    return substr($date[0],0,-6);
    
}


?>