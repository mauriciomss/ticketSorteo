<?php 
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    try {
        $dbh = new PDO("sqlite:base.sqlite");
    } catch (PDOException $e) {
        print_r("Error grave");
        print "<p>Error: No puede conectarse con la base de datos.</p>\n";
        exit();
    }

    function shuffle_nums($min, $max, $count, $dbh)
    {
        $nums = range($min, $max);
        shuffle($nums);
        
        $response = array();
        for($i=0;$i<$count && $i<count($nums);$i++)
        {
            array_push($response, $nums[$i]);
        }
        
        $aleatorio = $response[0];

        $sql = "SELECT COUNT(*) count FROM tickets WHERE gano = 0 AND numero =" . $aleatorio;
        $stmt = $dbh->prepare( $sql );
        $stmt->execute();
        $count = $stmt->fetchColumn(); 

        if ( $count == 0) {
            return 0;
        } else {
            return $aleatorio;
        }
        
    }

    /*
    function numAleatorio($maximo)
    {
        //alimentamos el generador de aleatorios
        mt_srand (time());
        //generamos un número aleatorio
        $numero_aleatorio = mt_rand(1,$maximo);
        
        return $numero_aleatorio;
    }
    */


    if (isset($_POST['sortear']) && !empty($_POST['sortear']))
    {
        $sql= "SELECT MAX(numero) max FROM tickets WHERE gano = 0";
        $stmt = $dbh->prepare( $sql );
        $stmt->execute();
        $max = $stmt->fetchColumn(); 

        $numero_aleatorio = 0;

        for ($i = 1; $i <= $max; $i++) {
            //$numero_aleatorio = numAleatorio($max);
            $numero_aleatorio = shuffle_nums(1, $max, 1, $dbh);

            if ( $numero_aleatorio > 0 ) {
                //marco como ganado
                $query = "UPDATE tickets SET gano = 1 WHERE numero = ".$numero_aleatorio;
                $dbh->query($query);

                break;
            }
        }

        echo json_encode(array( "error" => false, "ganador" => $numero_aleatorio ));

        die();
    }

?>

<!DOCTYPE html >
<!--[if IE 8]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="es-AR" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"> <!--<![endif]-->
<head>

    <meta charset="utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Fundación Desarrollo Agropecuario (FUDA)">
    <meta name="keywords" content="FUDA, Fundación, Desarrollo, Agropecuario">

    <meta name="author" content="mauriciomss - https://mauriciomss.github.io/">

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#5BB12F">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#5BB12F">

    <title>Sorteo</title>

    <!-- =========================
    FAV AND TOUCH ICONS  
    ============================== -->
    <link rel="shortcut icon" href="images/favicon.png" />


    <!-- Bootstrap Core CSS -->
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome CSS -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    
    
    <!-- Animate CSS -->
    <link href="css/animate.css" rel="stylesheet" >
    
    <!-- Owl-Carousel -->
    <link rel="stylesheet" href="css/owl.carousel.css" >
    <link rel="stylesheet" href="css/owl.theme.css" >
    <link rel="stylesheet" href="css/owl.transitions.css" >

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    
    <!-- Colors CSS -->
    <link rel="stylesheet" type="text/css" href="css/color/green.css">
    
    <!-- Colors CSS -->
    <link rel="stylesheet" type="text/css" href="css/color/green.css" title="green">
    <link rel="stylesheet" type="text/css" href="css/color/light-red.css" title="light-red">
    <link rel="stylesheet" type="text/css" href="css/color/blue.css" title="blue">
    <link rel="stylesheet" type="text/css" href="css/color/light-blue.css" title="light-blue">
    <link rel="stylesheet" type="text/css" href="css/color/yellow.css" title="yellow">
    <link rel="stylesheet" type="text/css" href="css/color/light-green.css" title="light-green">
    
    <!-- Modernizer js -->
    <script src="js/modernizr.custom.js"></script>

    
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <style type="text/css">
        .my-fixed-item {
            position: fixed;
            right: 0;
            width: 40px;
            text-align: center;
            z-index: 999999;
            margin-top: 17%;
            margin-right: 4%;
        }     

        .my-fixed-item a {
            float: left;
            width: 100%;
            margin-bottom: 5px;
        }

        .btn {
            font-size: 50px;
        }
        .btn-primary {
            border-color: #00a9bc;
            background-color: #00a9bc;
        }

        .btn-primary[disabled] {
            border-color: #00a9bc;
            background-color: #00a9bc;
        }

        #main-slide .slider-content h1 {
            /*line-height: 200px;*/
            margin-top: 100px;
        }
    </style>
    
</head>

<body class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">
                    <p class="navbar-brand-logo-text">&nbsp;</p>
                </a>               
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    
    <!-- Start Home Page Slider -->
    <section id="page-top">
        <!-- Carousel -->
        <div id="main-slide" class="carousel slide" data-ride="carousel">

            <!-- Carousel inner -->
            <div class="carousel-inner">
                
                <div class="item active">
                    <img class="img-responsive" src="images/fondo-pantalla.jpg" alt="slider">
                    <div class="slider-content">
                        <div class="col-md-12 text-center">
                            <h1 class="animated3">
                                <span style="text-align: center;">
                                    <strong style="background-color: #fff;" id="ganador">#####</strong>
                                </span>
                            </h1>
                            <a href="#" id="sorteador" class="page-scroll btn btn-primary animated1" style="margin-top: 10px;padding: 10px;font-weight: bold;">
                                SORTEAR
                            </a>
                        </div>
                    </div>
                </div>
                <!--/ Carousel item end -->

            </div>
            <!-- Carousel inner end-->

        </div>
        <!-- /carousel -->
    </section>
    <!-- End Home Page Slider -->



    <div id="loader">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>

    

    <!-- jQuery Version 2.1.1 -->
    <script src="js/jquery-2.1.1.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="asset/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/count-to.js"></script>
    <script src="js/jquery.appear.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>
    <script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.fitvids.js"></script>
	<script src="js/styleswitcher.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/script.js"></script>

    <script type="text/javascript">
        $(function() {
            var v_window_height = $(window).height();
            //$("#main-slide .item").css("height", v_window_height);

        });

        $(document).ready(function() {

            $(document).on("click","#sorteador", function(event) {
                $( ".btn" ).attr('disabled', 'disabled');
                
                $.ajax({
                    type: "POST",
                    url: "index.php",
                    data: "sortear=si",
                    dataType : 'json',
                    beforeSend: function(){
                        $('#loader').show();
                    },                         
                    success: function(data) {
                        
                        if (data.ganador == 0) {
                            $("#ganador").html("No hay más números para sortear");
                        } else {
                            $("#ganador").html("Ganador: <br>"+data.ganador);
                        }
                        
                        $( ".btn" ).removeAttr('disabled');
                        $('#loader').hide();

                    }
                });

                return false;
            });

        });
    </script>
</body>

</html>
