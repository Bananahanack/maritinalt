<?php
/** @var $this JDocumentHTML */
defined( '_JEXEC' ) or die( 'Restricted access' );
$this->_generator = '';
//JHtml::_( 'jquery.framework', false, null, false );
//$this->addStyleSheet( $this->baseurl . '/templates/' . $this->template . '/css/template_css.css?v1=1' );
//$this->addScript( JUri::base() . 'templates/' . $this->template . '/scripts/scripts.js?v1=1' );

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Add Stylesheets
JHtml::_('stylesheet', 'normalize.min.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'style.min.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'maritinaForm.css', array('version' => 'auto', 'relative' => true));

unset( $this->_links[array_search( array( 'relation' => 'canonical', 'relType' => 'rel', 'attribs' => array() ), $this->_links )] );
$baseUrl = JUri::base();
$isHomePage = $baseUrl === JUri::current();
?>
<!DOCTYPE html>
<html>
<head>
	<jdoc:include type="head" />

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Maritina</title>

    <meta name="description"  content="Around the world, sea containers forwording since 1995"/>
    <meta name="keywords" content="" />
    <meta name="author"  content=""/>
    <meta name="MobileOptimized" content="320" />

    <link rel="canonical" href="">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Maritina">
    <meta property="og:description" content="Around the world, sea containers forwording since 1995">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="Maritina">
    <meta property="og:image" content="images/favicon.png">
    <meta name="twitter:description" content="Around the world, sea containers forwording since 1995">
    <meta name="twitter:title" content="Maritina">
    <meta name="twitter:image" content="images/favicon.png">

    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="icon" href="images/favicon.png" sizes="32x32">
    <link rel="icon" href="images/favicon.png" sizes="150x150">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>
<body>
<div class="page">

    <div class="page">
        <div class="main">
            <div class="mw">

                <div class="header">
                    <div class="left_side">
                        <div class="logo">
                            <img src="images/logo.png" alt="Logo">
                        </div>
                    </div>

                    <div class="center">
                        <div class="slogan">
                            <h2 class="h2">
                                “Around the world, sea containers forwording since 1995”
                            </h2>
                        </div>
                    </div>
                    <div class="right_side">
                        <div class="img">
                            <img src="images/25.png" alt="25">
                        </div>
                    </div>
                </div>

                <div class="main_cont">
                    <div class="contact">
                        <div class="flag_country">
                            <img src="images/lit_flag-04.png" alt="latvia">
                        </div>

                        <h3 class="h3">
                            KLAIPEDA, LITHUANIA
                        </h3>
                        <ul>
                            <li>MARITINA UAB</li>
                            <li>Tilzes 24z-1, Klaipeda LT91126</li>
                            <li>ph.:    +370-46310002</li>
                            <li>e-mail: eduard@maritina.lt</li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>

                    <div class="contact">
                        <div class="flag_country">
                            <img src="images/lat_flag-03.png" alt="litva">
                        </div>
                        <h3 class="h3"> RIGA, LATVIA </h3>
                        <ul>
                            <li>MARITINA LATVIJA SIA</li>
                            <li>Ed. Smiļģa iela 2a, Rīga, LV-1048</li>
                            <li>ph.:    +371-67617465</li>
                            <li>e-mail: riga@maritina.lt</li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>

                    <div class="contact">
                        <div class="flag_country">
                            <img src="images/bel_flag-02.png" alt="BELARUS">
                        </div>
                        <h3 class="h3">
                            BELARUS, MINSK
                        </h3>
                        <ul>
                            <li>UAB Maritina representative  at Belarus</li>
                            <li>License №8077 /28.09.2017</li>
                            <li>22012 Minsk, Gorodezkaya str. 15 – 2</li>
                            <li>Phone: +375 152 410089</li>
                            <li>E-mail: by@maritina.lt</li>
                        </ul>
                    </div>

                </div>
            </div>


    </div>
</div>

    <div>
        <jdoc:include type="message" />
        <jdoc:include type="component" />
    </div>>

<!--		<jdoc:include type="modules" name="header" />-->

<!--<div class="footer relative">-->
<!--	<jdoc:include type="modules" name="footer" />-->
<!--</div>-->
</body>
</html>
