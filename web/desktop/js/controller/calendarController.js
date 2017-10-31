app.controller('calendarCtrl', ['headerService', '$scope', '$rootScope', '$location', 'authService', '$timeout', '$window', '$http', '$q', 'appSettings','$routeParams', function(headerService, $scope, $rootScope, $location, authService, $timeout, $window, $http, $q, appSettings,$routeParams) {

        //for show loading
        //$rootScope.loading=true;
        $scope.page = "calendrier";
        $scope.userName = authService.user.data.givenName;

        var date = new Date();
        var tabMY = $routeParams.mois.split('-');
        var yearCliked = tabMY.length > 1 ? tabMY[1] : date.getFullYear();
        var monthCliked = tabMY[0];
        var dayCliked = $routeParams.day;
        $scope.eventsInline = [];
        $scope.infosHeader = [];

        $scope.yearCliked = yearCliked;
        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * excution en chargement de la page
         */
        angular.element(document).ready(function() {
        	if($scope.infosHeader.length==0){
	       		headerService.initHeader()
	       		.then(function(res){
	       		    	          //console.log(res);
	       		            	  $scope.infosHeader = res;
	       		            	  //$rootScope.loading = false;
	       		      },function(res){
	       		    	         $scope.infosHeader = [];
	       		            	 alert("Une erreur s'est produite lors de connexion au web service!")
	       		      }
	       	     );		 
	       	}
            $scope.getEventsWs().then(
                    function(res) { // success 
                        //console.log(res);
                        $scope.eventsInline = res;
                        //$rootScope.loading = false;
                    },
                    function() { // fail 
                        $scope.redirectToHome();
                    }
            );

            $scope.$watch("eventsInline", function() {
                if ($scope.eventsInline.length) {                   
                    $("#eventCalendarHumanDate").eventCalendar({
                        jsonData: $scope.eventsInline,
                        monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"],
                        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                        dayNamesShort: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                        txt_noEvents: "Pas des événements trouvés",
                        txt_SpecificEvents_prev: "",
                        txt_SpecificEvents_after: "evenements:",
                        txt_next: "suivant",
                        txt_prev: "Précedent",
                        txt_NextEvents: "évenements :",
                        txt_GoToEventUrl: "url evénement",
                        dateFormat: "dddd D MMMM",
                        jsonDateFormat: 'timestamp', // you can use also "human" 'YYYY-MM-DD HH:MM:SS'
                        showDescription: true,
                        txt_loading: "chargement...",
                        eventsLimit: 60,
                        dateToShow: "" + yearCliked + "-" + monthCliked + "-01",
                        openEventInNewWindow: true
                    });

                    $timeout(function() {
                        /*var tab = $("a.monthTitle").html().split(" ");
                        $("a.monthTitle").html(tab[0]);
                        $("#greenYear").html('<i></i>' + tab[1]);*/
                    }, 50);
                    //alert("#eventCalendarHumanDate #dayList_"+dayCliked);
                    //$("#eventCalendarHumanDate #dayList_"+dayCliked).click();
                }
            });
        });

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * redirect to home
         */
        $scope.redirectToHome = function() {
            $location.path('/');
        }
        
        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * function de récupération des évenements from WS
         */
        $scope.getEventsWs = function() {
            var deferred = $q.defer();
            var token = $window.localStorage.getItem('janrainCaptureToken');
            $http.get(appSettings.baseUrl + '/calendar/' + token + '')
                    .success(function(res) {
                        if (res.success == 1) {
                            deferred.resolve(res.data);
                        } else {
                            $scope.redirectToHome();
                        }
                    })
                    .error(function(res) {
                        deferred.reject(res);
                    });
            return deferred.promise;
        };
    }])