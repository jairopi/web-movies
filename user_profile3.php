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
$query_rec = "SELECT m.* FROM movie AS m INNER JOIN (SELECT movie_id FROM recs WHERE user_id = '".$_SESSION['user']."' ORDER BY time DESC  LIMIT 8 OFFSET 0) as r ON m.id = r.movie_id";
$rec = $pdo->query($query_rec);

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

                <div class="android-search-box mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right mdl-textfield--full-width">
                    <label class="mdl-button mdl-js-button mdl-button--icon" for="search-field">
                        <i class="material-icons">search</i>
                    </label>
                    <div class="mdl-textfield__expandable-holder">
                        <input class="mdl-textfield__input" type="text" id="search-field">
                    </div>
                </div>

            </div>
        </header>
        <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
          
            <header class="demo-drawer-header">
                <img src="images/user.jpg" class="demo-avatar">
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
                    <img src="images/user.jpg" class="demo-avatar">
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
                        <span class="mdl-chip__text">Trabajo<?php echo $user['ocupation']; ?></span>
                        <button type="button" class="mdl-chip__action"><i class="material-icons">card_travel</i></button>
                    </span>
                    <span class="mdl-chip mdl-chip--deletable">
                        <span class="mdl-chip__text">Edad<?php echo $user['age']; ?></span>
                        <button type="button" class="mdl-chip__action"><i class="material-icons">cake</i></button>
                    </span>
                    <span class="mdl-chip mdl-chip--deletable">
                        <span class="mdl-chip__text">Sexo<?php echo $user['sex']; ?></span>
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
                    </style>
                <div class="android-section-title mdl-typography--display-1-color-contrast" style="width:100%">
                    <a name="recomended"></a>
                    Recomended Movies
                </div>
                <div class="android-card-container mdl-grid">
                    <?php while ($line_movies = $rec->fetch(PDO::FETCH_ASSOC)) { ?>
                    
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
                        .material-icons.green100 { color:#e8f5e9; }
.material-icons.green200 { color:#c8e6c9; }
.material-icons.green300 { color:#a5d6a7; }
.material-icons.green400 { color:#81c784; }
.material-icons.green500 { color:#66bb6a; }
.material-icons.green600 { color:#4caf50; }
.material-icons.green700 { color:#43a047; }
.material-icons.green800 { color:#388e3c; }
.material-icons.green900 { color:#2e7d32; }
.material-icons.green-A100 { color:#1b5e20; }
.material-icons.green-A200 { color:#b9f6ca; }
.material-icons.green-A400 { color:#69f0ae; }
.material-icons.green-A700 { color:#00e676; }
.material-icons.green1400 { color:#00c853; }
.material-icons.light_green100 { color:#f1f8e9; }
.material-icons.light_green200 { color:#dcedc8; }
.material-icons.light_green300 { color:#c5e1a5; }
.material-icons.light_green400 { color:#aed581; }
.material-icons.light_green500 { color:#9ccc65; }
.material-icons.light_green600 { color:#8bc34a; }
.material-icons.light_green700 { color:#7cb342; }
.material-icons.light_green800 { color:#689f38; }
.material-icons.light_green900 { color:#558b2f; }
.material-icons.light_green-A100 { color:#33691e; }
.material-icons.light_green-A200 { color:#ccff90; }
.material-icons.light_green-A400 { color:#b2ff59; }
.material-icons.light_green-A700 { color:#76ff03; }
.material-icons.light_green1400 { color:#64dd17; }
.material-icons.lime100 { color:#f9fbe7; }
.material-icons.lime200 { color:#f0f4c3; }
.material-icons.lime300 { color:#e6ee9c; }
.material-icons.lime400 { color:#dce775; }
.material-icons.lime500 { color:#d4e157; }
.material-icons.lime600 { color:#cddc39; }
.material-icons.lime700 { color:#c0ca33; }
.material-icons.lime800 { color:#afb42b; }
.material-icons.lime900 { color:#9e9d24; }
.material-icons.lime-A100 { color:#827717; }
.material-icons.lime-A200 { color:#f4ff81; }
.material-icons.lime-A400 { color:#eeff41; }
.material-icons.lime-A700 { color:#c6ff00; }
.material-icons.lime1400 { color:#aeea00; }
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