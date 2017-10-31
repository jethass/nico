<?php

/* NicoretteFrontBundle:Default:desktop.html.twig */
class __TwigTemplate_d833f7f917acaecd2d2a81bbb5852e28ced04b70bc77ec1d7acc27da36d3bc05 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html> 
<head>
\t<meta charset=\"utf-8\">
\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
\t<title>Nicorette</title>
\t<meta name=\"description\" content=\"\">
\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta name=\"fragment\" content=\"!\" />
    <base href=\"/\">  
\t<!-- Bootstrap core CSS -->
\t <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
\t<link rel=\"apple-touch-icon\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("apple.png"), "html", null, true);
        echo "\" />
\t<link href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/bootstrap.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t<link href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/bootstrap-reset.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t<link href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/bootstrap-datetimepicker.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
       
\t<!--external css-->
\t<link href=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/assets/font-awesome/css/font-awesome.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" />
              
\t<!-- Custom styles for this template -->
\t<link href=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/normalize.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t<link href=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/eventCalendar.css"), "html", null, true);
        echo "\"  rel=\"stylesheet\">
\t<link href=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/eventCalendar_theme_responsive.css"), "html", null, true);
        echo "\"  rel=\"stylesheet\">
\t<link href=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/style.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t<link href=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/style-responsive.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" />
\t<link href=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/idangerous.swiper.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" />\t
\t<link href=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/custom.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" />
\t<link href=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/custom-responsive.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" />
\t<link href=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/css.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" />
\t<link href=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/jquery.cookiebar.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" />
\t<link href=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/jquery-ui-1.10.1.custom.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" />
\t
\t<link href=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/owl.carousel.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t<link href=\"";
        // line 35
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/ion.rangeSlider.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
\t<link href=\"";
        // line 36
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/ion.rangeSlider.skinNice.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <link href=\"";
        // line 37
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/css/owl.theme.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">

\t<script type=\"text/javascript\">
\t\t\tvar css_link = \"desktop/css/janrain.css\";
\t\t\tlocalStorage.setItem('device', '";
        // line 41
        echo twig_escape_filter($this->env, (isset($context["device"]) ? $context["device"] : null), "html", null, true);
        echo "');
\t</script>
    
    <script src=\"";
        // line 44
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("common/js/plugins/angular.min.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 45
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("common/js/plugins/angular-route.min.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 46
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("common/js/plugins/angular-resource.min.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 47
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("common/js/plugins/jquery-1.10.2.min.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/vendor/bootstrap.min.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 49
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/vendor/idangerous.swiper.min.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 50
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/vendor/bootstrap-checkbox.js"), "html", null, true);
        echo "\"></script>
\t
      
    <script src=\"";
        // line 53
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/vendor/moment.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 54
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/vendor/bootstrap-datetimepicker.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 55
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/vendor/jquery.eventCalendar.min.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/vendor/jquery.knob.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 57
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/vendor/janrain-init.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 58
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/vendor/angular-check-list.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 59
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/vendor/jquery.cookiebar.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 60
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/vendor/jquery-ui-1.10.1.custom.min.js"), "html", null, true);
        echo "\"></script>
\t
\t<script src=\"";
        // line 62
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/vendor/owl.carousel.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 63
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/vendor/ion.rangeSlider.js"), "html", null, true);
        echo "\"></script>
\t
\t
    <script src=\"";
        // line 66
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/app.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 67
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/service/authService.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 68
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/service/httpInterceptorService.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 69
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/service/quizService.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 70
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/service/forgetPasswordService.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 71
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/service/inscriptionService.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 72
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/service/planService.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 73
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/service/headerService.js"), "html", null, true);
        echo "\"></script>
\t
\t<script src=\"";
        // line 75
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/loginController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 76
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/dashboardController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 77
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/quizController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 78
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/journalafterController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 79
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/journalbeforeController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 80
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/pointsController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 81
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/infosLegalesController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 82
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/inscriptionController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 83
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/menuAstucesController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 84
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/menuStatistiquesController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 85
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/mesParrainsController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 86
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/produitsNicoretteController.js"), "html", null, true);
        echo "\"></script>\t
\t<script src=\"";
        // line 87
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/profileController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 88
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/contratController.js"), "html", null, true);
        echo "\"></script>\t
\t<script src=\"";
        // line 89
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/planActionController.js"), "html", null, true);
        echo "\"></script>\t
\t<script src=\"";
        // line 90
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/bontonPaniqueController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 91
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/bontonPaniqueMobileController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 92
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/bontonPaniqueHelpController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 93
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/bontonPaniqueCrackController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 94
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/bontonPaniqueZutController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 95
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/mesAlertesController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 96
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/finProgrammeController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 97
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/produitComprimeeSucerController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 98
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/produitComprimeeController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 99
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/produitGommesController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 100
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/produitInhaleurController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 101
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/produitSprayController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 102
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/produitPatchController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 103
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/calendarController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 104
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/calendarListController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 105
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/mecanismePointsController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 106
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/introductionController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 107
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/contratDateFixeController.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 108
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/forgetPasswordController.js"), "html", null, true);
        echo "\"></script>
        
\t<script src=\"";
        // line 110
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/arreterController.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 111
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/arreterContinuerController.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 112
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/arreterFelicitationController.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 113
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/controller/arreterRepondreController.js"), "html", null, true);
        echo "\"></script>
        
\t
\t<script src=\"";
        // line 116
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/checkbox.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 117
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/radiobox.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 118
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/swiper.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 119
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/li_radio_box.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 120
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/accordion.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 121
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/knob.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 122
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/menu_dashboard.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 123
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/datetimepicker.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 124
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/validators.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 125
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/owlcarousel.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 126
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/slider.js"), "html", null, true);
        echo "\"></script>\t
\t<script src=\"";
        // line 127
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/gradiant.js"), "html", null, true);
        echo "\"></script>\t\t
\t<script src=\"";
        // line 128
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/packetgradiant.js"), "html", null, true);
        echo "\"></script>\t\t
\t<script src=\"";
        // line 129
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("desktop/js/directive/checkboxplan.js"), "html", null, true);
        echo "\"></script>\t\t
\t
</head>

<body ng-app=\"nicoretteApp\" class=\"relative\">

<div ng-show=\"loading\">
  <div class=\"loaderAjax\"></div>
</div>

<div ng-view></div>

</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "NicoretteFrontBundle:Default:desktop.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  443 => 129,  439 => 128,  435 => 127,  431 => 126,  427 => 125,  423 => 124,  419 => 123,  415 => 122,  411 => 121,  407 => 120,  403 => 119,  399 => 118,  395 => 117,  391 => 116,  385 => 113,  381 => 112,  377 => 111,  373 => 110,  368 => 108,  364 => 107,  360 => 106,  356 => 105,  352 => 104,  348 => 103,  344 => 102,  340 => 101,  336 => 100,  332 => 99,  328 => 98,  324 => 97,  320 => 96,  316 => 95,  312 => 94,  308 => 93,  304 => 92,  300 => 91,  296 => 90,  292 => 89,  288 => 88,  284 => 87,  280 => 86,  276 => 85,  272 => 84,  268 => 83,  264 => 82,  260 => 81,  256 => 80,  252 => 79,  248 => 78,  244 => 77,  240 => 76,  236 => 75,  231 => 73,  227 => 72,  223 => 71,  219 => 70,  215 => 69,  211 => 68,  207 => 67,  203 => 66,  197 => 63,  193 => 62,  188 => 60,  184 => 59,  180 => 58,  176 => 57,  172 => 56,  168 => 55,  164 => 54,  160 => 53,  154 => 50,  150 => 49,  146 => 48,  142 => 47,  138 => 46,  134 => 45,  130 => 44,  124 => 41,  117 => 37,  113 => 36,  109 => 35,  105 => 34,  100 => 32,  96 => 31,  92 => 30,  88 => 29,  84 => 28,  80 => 27,  76 => 26,  72 => 25,  68 => 24,  64 => 23,  60 => 22,  54 => 19,  48 => 16,  44 => 15,  40 => 14,  36 => 13,  32 => 12,  19 => 1,);
    }
}
