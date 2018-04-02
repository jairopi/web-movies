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
    <link rel="stylesheet" href="mdl/material.min.css">
    <script src="mdl/material.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    
    <link rel="stylesheet" href="mdl-template-android-dot-com/styles.css">

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
                    <img class="android-logo-image" src="mdl-template-android-dot-com/images/android-logo.png">
                </span>

                <!-- Add spacer, to align navigation to the right in desktop -->
                <div class="android-header-spacer mdl-layout-spacer"></div>

                <!-- Buscador -->  
                <div class="android-search-box mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right mdl-textfield--full-width">
                    <label class="mdl-button mdl-js-button mdl-button--icon" for="search-field">
                        <i class="material-icons">search</i>
                    </label>
                    <div class="mdl-textfield__expandable-holder">
                        <input class="mdl-textfield__input" type="text" id="search-field">
                    </div>
                </div>

                <!-- Opciones de la barra del navegador -->
                <div class="android-navigation-container">
                    <nav class="android-navigation mdl-navigation">
                        <a class="mdl-navigation__link mdl-typography--text-uppercase" href="">Phones</a>
                        <a class="mdl-navigation__link mdl-typography--text-uppercase" href="">Tablets</a>
                        <a class="mdl-navigation__link mdl-typography--text-uppercase" href="">Wear</a>
                        <a class="mdl-navigation__link mdl-typography--text-uppercase" href="">TV</a>
                        <a class="mdl-navigation__link mdl-typography--text-uppercase" href="">Auto</a>
                        <a class="mdl-navigation__link mdl-typography--text-uppercase" href="">One</a>
                        <a class="mdl-navigation__link mdl-typography--text-uppercase" href="">Play</a>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Acaba la barra navegacion -->
        
        <!-- Contenido de la pagina -->
        <div class="android-content mdl-layout__content">
            <a name="top"></a>
            <div class="android-be-together-section mdl-typography--text-center">
                <div class="logo-font android-slogan">be together. not the same.</div>
                <div class="logo-font android-sub-slogan">welcome to android... be yourself. do your thing. see what's going on.</div>
                <div class="logo-font android-create-character">
                    <a href=""><img src="images/andy.png"> create your android character</a>
                </div>
                <a href="#screens">
                    <button class="android-fab mdl-button mdl-button--colored mdl-js-button mdl-button--fab mdl-js-ripple-effect">
                        <i class="material-icons">expand_more</i>
                    </button>
                </a>
            </div>
            
            <div class="android-more-section">
                <div class="android-section-title mdl-typography--display-1-color-contrast">More from Android</div>
                <div class="android-card-container mdl-grid">
                    <div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-card mdl-shadow--3dp">
                        <div class="mdl-card__media">
                            <img src="images/more-from-1.png">
                        </div>
                        <div class="mdl-card__title">
                            <h4 class="mdl-card__title-text">Get going on Android</h4>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <span class="mdl-typography--font-light mdl-typography--subhead">Four tips to make your switch to Android quick and easy</span>
                        </div>
                        <div class="mdl-card__actions">
                            <a class="android-link mdl-button mdl-js-button mdl-typography--text-uppercase" href="">
                                Make the switch
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </div>
                    </div>

                    <div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-card mdl-shadow--3dp">
                        <div class="mdl-card__media">
                            <img src="images/more-from-4.png">
                        </div>
                        <div class="mdl-card__title">
                            <h4 class="mdl-card__title-text">Create your own Android character</h4>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <span class="mdl-typography--font-light mdl-typography--subhead">Turn the little green Android mascot into you, your friends, anyone!</span>
                        </div>
                        <div class="mdl-card__actions">
                            <a class="android-link mdl-button mdl-js-button mdl-typography--text-uppercase" href="">
                                androidify.com
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </div>
                    </div>

                    <div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-card mdl-shadow--3dp">
                        <div class="mdl-card__media">
                            <img src="images/more-from-2.png">
                        </div>
                        <div class="mdl-card__title">
                            <h4 class="mdl-card__title-text">Get a clean customisable home screen</h4>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <span class="mdl-typography--font-light mdl-typography--subhead">A clean, simple, customisable home screen that comes with the power of Google Now: Traffic alerts, weather and much more, just a swipe away.</span>
                        </div>
                        <div class="mdl-card__actions">
                            <a class="android-link mdl-button mdl-js-button mdl-typography--text-uppercase" href="">
                               Download now
                               <i class="material-icons">chevron_right</i>
                            </a>
                        </div>
                    </div>

                    <div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-card mdl-shadow--3dp">
                        <div class="mdl-card__media">
                            <img src="images/more-from-3.png">
                        </div>
                        <div class="mdl-card__title">
                            <h4 class="mdl-card__title-text">Millions to choose from</h4>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <span class="mdl-typography--font-light mdl-typography--subhead">Hail a taxi, find a recipe, run through a temple – Google Play has all the apps and games that let you make your Android device uniquely yours.</span>
                        </div>
                        <div class="mdl-card__actions">
                            <a class="android-link mdl-button mdl-js-button mdl-typography--text-uppercase" href="">
                                Find apps
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </div>
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
                    <p class="mdl-typography--font-light">Satellite imagery: © 2014 Astrium, DigitalGlobe</p>
                    <p class="mdl-typography--font-light">Some features and devices may not be available in all areas</p>
                </div>

                <div class="mdl-mega-footer--bottom-section">
                    <a class="android-link mdl-typography--font-light" href="">Blog</a>
                    <a class="android-link mdl-typography--font-light" href="">Privacy Policy</a>
                </div>
            </footer>
        </div>
        <!--Acaba el footer -->
    </div>
    
</body>
</html>
