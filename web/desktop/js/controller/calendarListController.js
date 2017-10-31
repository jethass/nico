app.controller('calendarListCtrl', ['headerService','$scope', '$rootScope', '$location', 'authService', '$timeout', '$window', '$http', '$q', 'appSettings', function(headerService,$scope, $rootScope, $location, authService, $timeout, $window, $http, $q, appSettings) {

        //for show loading
        //$rootScope.loading=true;
        $scope.page = "calendrier";
        $scope.userName = authService.user.data.givenName;
        var date = new Date();
        year = date.getFullYear();
        $scope.year = year;
        $scope.eventsInline = [];
        $scope.infosHeader = [];
        $scope.user_month = date.getMonth()+1;
        $scope.user_year = date.getFullYear();
        $scope.tabMonthYear = new Array();
        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * excution en chargement de la page
         */
        angular.element(document).ready(function() {
           $scope.getEventsWs().then(
                    function(res) { // success 
                        //console.log(res);
                        $scope.eventsInline = res.data;
                        $scope.user_month = res.month;
                        $scope.user_year = res.year;
                        //$rootScope.loading = false;
                        
                        $scope.$watch("eventsInline", function() {
                            if ($scope.eventsInline.length) {
                                   //console.log($scope.eventsInline);
                            	
                            	$("#year-mobile").text($scope.user_year);
                            	if( Number($scope.user_month) > 1 ){
                            		var tmpM = 12 - Number($scope.user_month) + 2;
                            		$("#year-mobile-"+tmpM+"-m").text(Number($scope.user_year) + 1);
                            		$("#year-mobile-"+tmpM+"-m").show();
                            		$("<div style='clear: both;'></div>").insertAfter($("#year-mobile-"+tmpM+"-m"));
                            		$("<div style='clear: both;'></div>").insertBefore($("#year-mobile-"+tmpM+"-m"));
                            	}
                            	for(var i = 1; i <= 12; i++){
                            		var tmp_m = Number($scope.user_month) + i - 1;
                            		var cur_month = tmp_m > 12 ? (tmp_m - 12) : tmp_m;
                            		var cur_year = tmp_m > 12 ? (Number($scope.user_year) + 1) : Number($scope.user_year);
                            		$scope.tabMonthYear.push(cur_month+"-"+cur_year);
                            		
							    
                            		$("#mois-"+i).eventCalendar({
                                        jsonData: $scope.eventsInline,
                                        monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"],
                                        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                                        dayNamesShort: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                                        jsonDateFormat: 'timestamp', // you can use also "human" 'YYYY-MM-DD HH:MM:SS'
                                        showDescription: false,
                                        txt_loading: "chargement...",
                                        dateToShow: "" + cur_year + "-"+(cur_month<10?"0":"")+cur_month+"-01",
                                        eventsLimit: 365
                                    });
                                    $("#mois-"+i+"-m").eventCalendar({
                                        jsonData: $scope.eventsInline,
                                        monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"],
                                        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                                        dayNamesShort: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                                        jsonDateFormat: 'timestamp', // you can use also "human" 'YYYY-MM-DD HH:MM:SS'
                                        showDescription: false,
                                        txt_loading: "chargement...",
                                        dateToShow: "" + cur_year + "-"+(cur_month<10?"0":"")+cur_month+"-01",
                                        showDayNameInCalendar: false,
                                        eventsLimit: 365
                                    });
                                    $("#mois-"+i+" .eventsCalendar-day:not(.empty) a").click(function(){
                                    	if($(this).parent().hasClass("dayWithEvents")){
                                    		window.location.replace($(this).parent().parent().parent().find(".eventsCalendar-currentTitle .monthTitle").attr("href")); //+"?day="+$(this).text()
                                    	}
                                    });
                                    $("#mois-"+i+"-m .eventsCalendar-day:not(.empty) a").click(function(){
                                    	if($(this).parent().hasClass("dayWithEvents")){
                                    		window.location.replace($(this).parent().parent().parent().find(".eventsCalendar-currentTitle .monthTitle").attr("href")); //+"?day="+$(this).text()
                                    	}
                                    });
                            	}

                                $timeout(function() {
                                	for(var j = 1; j <= 12; j++){
                                		var tmp_m = Number($scope.user_month) + j - 1;
                                		var cur_month = tmp_m > 12 ? (tmp_m - 12) : tmp_m;
                                		var cur_year = tmp_m > 12 ? (Number($scope.user_year) + 1) : Number($scope.user_year);
                                		$("#mois-"+j+" a.monthTitle").attr("href", "/#!/calendrier/"+(cur_month<10?"0":"")+cur_month+"-"+cur_year);
                                        $("#mois-"+j+" a.monthTitle").click(function() {
                                            window.location.replace($(this).attr("href"));
                                        });

                                        $("#mois-"+j+"-m a.monthTitle").attr("href", "/#!/calendrier/"+(cur_month<10?"0":"")+cur_month+"-"+cur_year);
                                        $("#mois-"+j+"-m a.monthTitle").click(function() {
                                            window.location.replace($(this).attr("href"));
                                        });
                                        
                                        var tabm = $("#mois-"+j+"-m a.monthTitle").html().split(" ");
                                        $("#mois-"+j+"-m a.monthTitle").html(tabm[0]);
                                	}
                                }, 100);
                            }
                        });
                    },
                    function() { // fail 
                        $scope.redirectToHome();
                    }
            );
            
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

            $("#calendrier-desktop a.btn.prev").click(function(){
            	//alert("rr");
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
                            deferred.resolve(res);
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