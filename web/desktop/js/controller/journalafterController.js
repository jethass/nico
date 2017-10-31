app.controller('journalafterCtrl', ['headerService','$scope', '$rootScope', '$location', 'authService', '$http', '$q', 'appSettings', '$window', '$timeout', function(headerService, $scope, $rootScope, $location, authService, $http, $q, appSettings, $window, $timeout) {

        //for show loading
        $rootScope.loading = true;

        //init params
        $scope.page = "mon-journal";
        $scope.userName = authService.user.data.givenName;
        $scope.isRenseigned = false;
        $scope.averageDifficulty = 0;
        $scope.lastDifficulty = 0;
        $scope.countInsertedAnswers = 0;
        $scope.dayObjective = 0;
        $scope.questions = [];
        $scope.questionsSecond = [];
        $scope.infosHeader = [];

        $scope.firstQuestion_idAnswer = 0;
        $scope.firstQuestion_idChoice = 0;
        $scope.firstQuestion_value = 0;

        $scope.secondQuestion_idAnswer = 0;
        $scope.secondQuestion_idChoice = 0;

        $scope.code = "";
        $scope.codeSecond = "";
        $scope.difficulte = 0;
        $rootScope.finaldifficulte = 0;

        $scope.valeursSlider = [];
        $scope.answers = {};

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
            $scope.afterFirstJournalWs().then(
                    function(res) {
                        // success 
                        console.log(res);
                        $scope.isRenseigned = res.isInsertedToday;
                        $scope.averageDifficulty = res.averageDifficulty;
                        $scope.countInsertedAnswers = res.countInsertedAnswers;
                        $scope.lastDifficulty = res.lastDifficulty;
                        $scope.questions = res.quiz.questions;
                        $scope.code = res.quiz.code;
                        $scope.dayObjective = res.dayObjective;
                        $scope.valeursSlider = res.quiz.questions[0].choices;

                        if ($scope.isRenseigned) {
                            $("#modalrenseigned").modal();
                            $scope.firstQuestion_idAnswer = res.lastAnswers.idAnswer;
                            $scope.firstQuestion_idChoice = res.lastAnswers.idChoice;
                            $scope.firstQuestion_value = res.lastAnswers.value;
                            if($scope.firstQuestion_value=="J'ai fumé"){
                                $scope.difficulte = 11;
                            }else{
                                $scope.difficulte = $scope.firstQuestion_value;
                            }
                        } else {
                            $scope.difficulte = 5;
                        }
                        $rootScope.loading = false;
                    },
                    function() {// fail 
                        $scope.redirectToHome();
                    }
            );

            $scope.afterSecondJournalWs().then(
                    function(result) {
                        // success 
                        console.log(result);
                        $scope.questionsSecond = result.quiz.questions;
                        $scope.codeSecond = result.quiz.code;
                        $scope.secondQuestion_idAnswer = result.lastAnswers.idAnswer;
                        $scope.secondQuestion_idChoice = result.lastAnswers.idChoice;
                        $scope.check_choice = result.lastAnswers.idChoice;
                        $rootScope.loading = false;
                    },
                    function() {
                        // fail 
                        $scope.redirectToHome();
                    }
            );
        });


        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * mon journal afterFirst call WS
         */
        $scope.afterFirstJournalWs = function() {
            var deferred = $q.defer();
            var token = $window.localStorage.getItem('janrainCaptureToken');
            $http.get(appSettings.baseUrl + '/diary/after/first/' + token + '?token=' + token + '')
                    .success(function(res) {
                        if (res.success == false) {
                            var url = res.redirectUrl[0];
                            if (url == 'before') {
                                $scope.redirectToJournalBefore();
                            } else if (url == 'after') {
                                $scope.redirectToJournalAfter();
                            }
                        } else {
                            deferred.resolve(res.data);
                        }
                    })
                    .error(function(res) {
                        deferred.reject(res);
                    });
            return deferred.promise;
        };

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * mon journal afterSecond call WS
         */
        $scope.afterSecondJournalWs = function() {
            var deferred = $q.defer();
            var token = $window.localStorage.getItem('janrainCaptureToken');
            $http.get(appSettings.baseUrl + '/diary/after/second/' + token + '?token=' + token + '')
                    .success(function(res) {
                        if (res.success == false) {
                            var url = res.redirectUrl[0];
                            if (url == 'before') {
                                $scope.redirectToJournalBefore();
                            } else if (url == 'after') {
                                $scope.redirectToJournalAfter();
                            }
                        } else {
                            deferred.resolve(res.data);
                        }
                    })
                    .error(function(res) {
                        deferred.reject(res);
                    });
            return deferred.promise;
        };



        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * submit form
         */
        $scope.submitReponseOne = function() {
                var token = $window.localStorage.getItem('janrainCaptureToken');
                var valeur = $rootScope.finaldifficulte;
                               
                if (valeur != 0) {
                         var valToPost = switchValToPost(valeur);
                } else {
                    if($scope.firstQuestion_value=="J'ai fumé"){
                         var valToPost =switchValToPost(11);
                    }else{
                         var valToPost = switchValToPost($scope.firstQuestion_value);
                     }
                }
            
                //condition d'affichage de question2
                if ((valeur > $scope.lastDifficulty) || (($scope.countInsertedAnswers >= 7) && (valeur > $scope.averageDifficulty))) {
                    if(valeur==11){
                            if (!$scope.isRenseigned) {
                                var idAnswer_one = false;
                                var idChoice_one = valToPost;
                                var tabParams = prepareData(idAnswer_one, idChoice_one, $scope.code, token, 'POST');
                            } else {
                                var idAnswer_one = $scope.firstQuestion_idAnswer;
                                var idChoice_one = valToPost;
                                var tabParams = prepareData(idAnswer_one, idChoice_one, $scope.code, token, 'PUT');
                            }
                            $http.post(appSettings.baseUrl + '/diary/answers/save/' + $scope.code + '', tabParams)
                            .success(function(res) {
                                    $scope.redirectToPanic();
                            })
                            .error(function(res) {
                                    $scope.redirectToHome();
                            });
                    }else{
                        $(".question-2").show();
                    }
                } else { //submit question1 sans passer au question 2
                        if (!$scope.isRenseigned) {
                            var idAnswer_one = false;
                            var idChoice_one = valToPost;
                            var tabParams = prepareData(idAnswer_one, idChoice_one, $scope.code, token, 'POST');
                        } else {
                            var idAnswer_one = $scope.firstQuestion_idAnswer;
                            var idChoice_one = valToPost;
                            var tabParams = prepareData(idAnswer_one, idChoice_one, $scope.code, token, 'PUT');
                        }
                        WsPost($scope.code, tabParams,"modalBravo");
                }
        }

        $scope.submitReponseTow = function() {
            var token = $window.localStorage.getItem('janrainCaptureToken');
            var valeur = $rootScope.finaldifficulte;
                if (valeur != 0) {
                   var valToPost = switchValToPost(valeur);
                } else {
                   var valToPost = switchValToPost($scope.firstQuestion_value);
                }
              
            var key;
            var choicesIds=[];
            for (key in $scope.answers) {
                    for (i = 0; i < $scope.answers[key].length; i++) {
                        choicesIds.push($scope.answers[key][i].id);
                     }
            };
            //if tout le temps cliqué
            //if ($("#radioafter183").is(':checked')) {
            if( $.inArray(183,choicesIds) != -1){
                //submit reponse question1
                if (!$scope.isRenseigned) {
                    var idAnswer_one = false;
                    var idChoice_one = valToPost;
                    var tabParams1 = prepareData(idAnswer_one, idChoice_one, $scope.code, token, 'POST');
                } else {
                    var idAnswer_one = $scope.firstQuestion_idAnswer;
                    var idChoice_one = valToPost;
                    var tabParams1 = prepareData(idAnswer_one, idChoice_one, $scope.code, token, 'PUT');
                }
                $timeout(function() {
                    WsPost($scope.code, tabParams1, "modalLisezAstuces");
                }, 100);

                //submit reponse question2
                var idAnswer_tow = $scope.secondQuestion_idAnswer;
                var idChoice_tow =183; //$("#radioafter183").val();
                if (idAnswer_tow != false) {
                    var tabParams2 = prepareData(idAnswer_tow, idChoice_tow, $scope.codeSecond, token, 'PUT');
                } else {
                    var tabParams2 = prepareData(idAnswer_tow, idChoice_tow, $scope.codeSecond, token, 'POST');
                }
                $timeout(function() {
                    WsPostNoModal($scope.codeSecond, tabParams2);
                }, 200);

            }

            //if parfois cliqué
            //if ($("#radioafter184").is(':checked')) {
            if( $.inArray(184,choicesIds) != -1){
                    //submit reponse question1
                    if (!$scope.isRenseigned) {
                        var idAnswer_one = false;
                        var idChoice_one = valToPost;
                        var tabParams1 = prepareData(idAnswer_one, idChoice_one, $scope.code, token, 'POST');
                    } else {
                        var idAnswer_one = $scope.firstQuestion_idAnswer;
                        var idChoice_one = valToPost;
                        var tabParams1 = prepareData(idAnswer_one, idChoice_one, $scope.code, token, 'PUT');
                    }
                    $timeout(function() {
                        WsPost($scope.code, tabParams1, "modalparfois");
                    }, 100);

                    //submit reponse question2
                    var idAnswer_tow = $scope.secondQuestion_idAnswer;
                    var idChoice_tow = 184; //$("#radioafter184").val();
                    if (idAnswer_tow != false) {
                        var tabParams2 = prepareData(idAnswer_tow, idChoice_tow, $scope.codeSecond, token, 'PUT');
                    } else {
                        var tabParams2 = prepareData(idAnswer_tow, idChoice_tow, $scope.codeSecond, token, 'POST');
                    }
                    $timeout(function() {
                        WsPostNoModal($scope.codeSecond, tabParams2);
                    }, 200);


                }
                //if non cliqué
                //if ($("#radioafter185").is(':checked')) {
                if( $.inArray(185,choicesIds) != -1){    
                    //submit reponse question1
                    if (!$scope.isRenseigned) {
                        var idAnswer_one = false;
                        var idChoice_one = valToPost;
                        var tabParams1 = prepareData(idAnswer_one, idChoice_one, $scope.code, token, 'POST');
                    } else {
                        var idAnswer_one = $scope.firstQuestion_idAnswer;
                        var idChoice_one = valToPost;
                        var tabParams1 = prepareData(idAnswer_one, idChoice_one, $scope.code, token, 'PUT');
                    }
                    $timeout(function() {
                        WsPost($scope.code, tabParams1, "modalNon");
                    }, 100);

                    //submit reponse question2
                    var idAnswer_tow = $scope.secondQuestion_idAnswer;
                    var idChoice_tow =185; //$("#radioafter185").val();
                    if (idAnswer_tow != false) {
                        var tabParams2 = prepareData(idAnswer_tow, idChoice_tow, $scope.codeSecond, token, 'PUT');
                    } else {
                        var tabParams2 = prepareData(idAnswer_tow, idChoice_tow, $scope.codeSecond, token, 'POST');
                    }
                    $timeout(function() {
                        WsPostNoModal($scope.codeSecond, tabParams2);
                    }, 200);

                  }
        }

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * prepare data for ws
         */
        function prepareData(id_answer, choice, code, tokeen, method) {
            var answers = [
                {"idAnswer": id_answer, "idChoice": choice},
            ];
            var params = {
                code: code,
                method: method,
                token: tokeen,
                answers: answers
            };
            return params;
        }

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * ws post reponse
         */
        function WsPost(code, arrayParams, modalId) {
            $http.post(appSettings.baseUrl + '/diary/answers/save/' + code + '', arrayParams)
                    .success(function(res) {
                        console.log(res);
                        $("#" + modalId).modal();
                    })
                    .error(function(res) {
                        $scope.redirectToHome();
                    });
        }
        function WsPostNoModal(code, arrayParams) {
            $http.post(appSettings.baseUrl + '/diary/answers/save/' + code + '', arrayParams)
                    .success(function(res) {
                        console.log(res);
                    })
                    .error(function(res) {
                        $scope.redirectToHome();
                    });
        }
        
        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * vérifie si le choice est egale au choice retourné, si oui return true pour le checker.
         */
        $scope.checkRadio = function(choice_id) {
            if (choice_id == $scope.check_choice) {
                return true;
            } else {
                return false;
            }

        };

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * faire corespondance valeur slider avec tableau valeurId slider
         */
        function switchValToPost(valeur) {
            var index = valeur - 1;
            return $scope.valeursSlider[index].id;
        }

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * redirect to dashboard
         */
        $scope.redirectToDashbord = function() {
            $location.path('/dashboard');
        }

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * redirect to astuces
         */
        $scope.redirectToPanic = function() {
            $location.path('/panique-cracked');
        }

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * redirect to astuces
         */
        $scope.redirectToAstuces = function() {
            $location.path('/menu-astuces');
        }

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * redirect to profile
         */
        $scope.redirectToProfil = function() {
            $location.path('/mon-profil');
        }

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * redirect to produits nicorette
         */
        $scope.redirectToProduits = function() {
            $location.path('/produits-nicorette');
        }

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * redirect to Journal Before
         */
        $scope.redirectToJournalBefore = function() {
            $location.path('/mon-journal-before');
        }

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * redirect to Journal after
         */
        $scope.redirectToJournalAfter = function() {
            $location.path('/mon-journal-after');
        }


        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * redirect to home
         */
        $scope.redirectToHome = function() {
            $location.path('/');
        }
        
         /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * récupère checked reponse pour la question 2
        */
                
        $scope.setReponseCheck=function(choice,question_id){
                $("#chek-q3 .custom-checkbox").removeClass('green-bg');
                $('#chek-q3 .custom-checkbox  span.txt-checkbox').removeClass('green');
                $('#chek-q3 .custom-checkbox  label.label-check').removeClass('green');
                var choiceId=choice.id;
                $("#ck-"+choiceId).addClass("green-bg");
                $("#ck-"+choiceId+' span.txt-checkbox').addClass("green");
                $("#ck-"+choiceId+' label.label-check').removeClass('green');
                var tab = [];
                if(choiceId=='183'){
                   $("#ck184").removeAttr('checked');
                   $("#ck185").removeAttr('checked');
                   tab[0] = choice;
                   $scope.answers[question_id] = tab;
                }
                if(choiceId=='184'){
                   $("#ck183").removeAttr('checked'); 
                   $("#ck185").removeAttr('checked');
                   tab[0] = choice;
                   $scope.answers[question_id] = tab;
                }
                if(choiceId=='185'){
                   $("#ck183").removeAttr('checked'); 
                   $("#ck184").removeAttr('checked');
                   tab[0] = choice;
                   $scope.answers[question_id] = tab;
                }
       }
    }])








