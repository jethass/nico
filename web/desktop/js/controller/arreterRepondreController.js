app.controller('arreterRepondreCtrl', ['$scope', '$rootScope', '$location', 'authService', '$http', '$q', 'appSettings', '$window', function($scope, $rootScope, $location, authService, $http, $q, appSettings, $window) {        

	//for show loading
	$rootScope.loading=true;
	$scope.page="arreter-continuer";
        $scope.userName=authService.user.data.givenName;
        $scope.questions = null;
        $scope.answers = {};
        $scope.etape1=true;
        $scope.etape2=false;
        $scope.etape3=false;
        
        $scope.utile=0;
        $rootScope.finalutile = 0;
        
        $scope.contain = 5;
        $rootScope.finalcontain= 0;
        
        $scope.duration=5;
        $rootScope.finalduration = 0;
        
        $scope.frequency=5;
        $rootScope.finalfrequency = 0;
        
        $scope.personalization=5;
        $rootScope.finalpersonalization = 0;
        
        
        
                    
                    
        
         
        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * excution en chargement de la page
         */
        angular.element(document).ready(function() {
             $scope.ArreterRepondreWs().then(
                    function(res) {// success 
                            console.log(res);
                            $scope.questions = res.quiz.questions;
                            $scope.code = res.quiz.code; 
                            $rootScope.loading = false;
                        },
                        function() { // fail 
                            $scope.redirectToHome();
                        }
                );

        });
        
        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * ArreterRepondre call WS
         */
        $scope.ArreterRepondreWs = function() {
            var deferred = $q.defer();
            var token=$window.localStorage.getItem('janrainCaptureToken');
            $http.get(appSettings.baseUrl + '/quit-nicorette-program/'+token)
                    .success(function(res) {
                        if (res.success == false) {
                            $scope.redirectToHome();
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
        * function validation si objet est vide
        */
        function isEmpty(value){
            return Boolean(value && typeof value == 'object') && !Object.keys(value).length;
        
        }
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * function count length array
        */
        var getArrayLength = function(my_object) {
            var len = 0;
            for (key in my_object) {
                len++;
            }
            return len;
        }
        
        
        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * function for insert reponses choice for question radio2
         */
        $scope.setYesOrNoValueR2 = function(choice, question_id) {
            var tab = [];
            tab[0] = choice;
            $scope.answers[question_id] = tab;
        };


        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * function for insert reponses choice for question radio3
         */
        $scope.setYesOrNoValueR3 = function(choice, question_id) {
            var tab = [];
            tab[0] = choice;
            $scope.answers[question_id] = tab;
        };
        
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * récupère checked reponse pour la question 4
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
                if(choiceId=='146'){
                   $("#ck147").removeAttr('checked');
                   $("#ck148").removeAttr('checked');
                   $("#ck149").removeAttr('checked');
                   tab[0] = choice;
                   $scope.answers[question_id] = tab;
                }
                if(choiceId=='147'){
                   $("#ck146").removeAttr('checked'); 
                   $("#ck148").removeAttr('checked');
                   $("#ck149").removeAttr('checked');
                   tab[0] = choice;
                   $scope.answers[question_id] = tab;
                }
                if(choiceId=='148'){
                   $("#ck146").removeAttr('checked'); 
                   $("#ck147").removeAttr('checked');
                   $("#ck149").removeAttr('checked');
                   tab[0] = choice;
                   $scope.answers[question_id] = tab;
                }
                 if(choiceId=='149'){
                   $("#ck146").removeAttr('checked');
                   $("#ck147").removeAttr('checked');
                   $("#ck148").removeAttr('checked');
                   tab[0] = choice;
                   $scope.answers[question_id] = tab;
                }
       }
      
        
       /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * return message a affiché aprés les réponse choisie
       */ 
       $scope.getMessageNotification=function(choicesIds){
            var txt="";
            if( ($.inArray(137,choicesIds)!= -1) && ($.inArray(144,choicesIds)!= -1) ){ //condition c5 && c14
               txt="Vous avez probablement besoin de passer à la dose supérieure de votre substitut niconitique, ou envisager un autre substitut. Normalement, la thérapie du remplacement nicotinique devrait réduire votre irritabilité. Vous devrier également intensifier votre activité physique, car cela  peut avoir une influence positive sur votre humeur durant votre sevrage. (et après!)" ;
            }
            else if($.inArray( 148,choicesIds)!= -1){ //condition c16
                txt="Vous avez probablement besoin d'un substitut plus fortement dosé ou pris plus régulièrement. Normalement, la thérapie du remplacement nicotinique devrait réduire votre irritabilité. Vous devrier également intensifier votre activité physique, car cela  peut avoir une influence positive sur votre humeur durant votre sevrage. (et après!) Relisez votre plan d'action pour connaître le substitut nicotinique le plus adapté à vos besoins." ;
            }
            else if($.inArray( 149,choicesIds)!= -1){ //condition c17
                txt="Vous devriez sérieusement penser à utiliser un substitut nicotinique. Les experts et les anciens fumeurs affirment que les substituts nicotiniques peuvent être extrêmement efficace. En effet, les personnes qui utilisent un substitut nicotinique rencontre plus de succès dans leur sevrage. Nicorette vous propose différents substituts qui vous aideront. Relisez votre plan d'action, pour connaître le substitut le plus adapté à vos besoins." ;
            }
            else if($.inArray( 140,choicesIds)!= -1){ //condition c8
                txt="En moyenne, les personnes qui suivent un programme d'arrêt prennent 2 kilos durant le sevrage, mais la plupart perde ce poids en quelques mois." ;
            }
            else{
               txt=""; 
            }
            return txt;
       }
        
        
       /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * function validation/submit  reponses
       */
        $scope.submitReponses = function() {
           
                $scope.questionError = [];
                $scope.questions.forEach(function(question, index) {
                    if (!$scope.answers[question.id] || isEmpty($scope.answers[question.id])) {
                       if(question.id==33){
                        $scope.questionError[question.id] = "Merci de renseigner au moins une réponse.";
                       }
                       if(question.id==34){
                        $scope.questionError[question.id] = "Merci de sélectioner une réponse.";
                       }
                       if(question.id==35){
                        $scope.questionError[question.id] = "Merci de sélectioner une réponse.";
                       }
                       if(question.id==36){
                        $scope.questionError[question.id] = "Merci de renseigner une réponse.";
                       }
                    }
                });


                if (getArrayLength($scope.questionError) == 0) {
                        var key;
                        var questionAnswers = [];
                        var choicesIds=[];
                        for (key in $scope.answers) {
                            for (i = 0; i < $scope.answers[key].length; i++) {
                                questionAnswers.push({'QuestionId': key, 'ChoiceId': $scope.answers[key][i].id});
                                choicesIds.push($scope.answers[key][i].id);
                            }
                        };

                        //WS post
                                var params = {
                                    method: 'POST',
                                    token: $window.localStorage.getItem('janrainCaptureToken'),
                                    answers: questionAnswers
                                };

                        $http.post(appSettings.baseUrl + '/extra_quiz/answers/save/' + $scope.code + '', params)
                                .success(function(res) {
                                    console.log(res);
                                    //test sur la réponse pour redirection
                                    if( $.inArray( 138,choicesIds) == -1){
                                      $scope.etape1=false;
                                      $scope.etape2=true;
                                      $scope.etape3=false;
                                      $scope.messageNotif=$scope.getMessageNotification(choicesIds);
                                    }else{
                                      $scope.etape1=false;
                                      $scope.etape2=false;
                                      $scope.etape3=true;
                                    }
                                })
                                .error(function(res) {
                                    $scope.redirectToHome();
                        });

                  }
        }
        
        
        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * post WS pour abondonner le programme sans suppression de compte 
         */
        $scope.AbonndonerSansSup=function() {
            var params = {
                quit: 1,
                token: $window.localStorage.getItem('janrainCaptureToken'),
                deleteAccount:false
            };
            $http.post(appSettings.baseUrl + '/quit-program', params)
                                .success(function(res) {
                                    console.log(res);
                                    $scope.redirectToDashbord();
                                })
                                .error(function(res) {
                                    $scope.redirectToHome();
            });                        
        }
        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * post WS pour abondonner le programme avec suppression de compte 
         */
        $scope.AbonndonerAvecSup=function() {
            var params = {
                quit: 1,
                token: $window.localStorage.getItem('janrainCaptureToken'),
                deleteAccount:true
            };
            $http.post(appSettings.baseUrl + '/quit-program', params)
                                .success(function(res) {
                                    console.log(res);
                                    $scope.redirectToDashbord();
                                })
                                .error(function(res) {
                                    $scope.redirectToHome();
            }); 
        }
        
        
        
        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * post WS pour abondonner le programme sans suppression de compte avec post des valeur sliders
         */
        $scope.AbonndonerSansSupWithSlideVals=function() {
                var token=$window.localStorage.getItem('janrainCaptureToken');
                var datauser = JSON.parse($window.localStorage.getItem('janrainCaptureProfileData'));
                var params = {
                    uuid:datauser.uuid,
                    token:token,
                    contain:$rootScope.finalcontain,
                    duration:$rootScope.finalduration,
                    frequency:$rootScope.finalfrequency,
                    personalization:$rootScope.finalpersonalization,
                    useful:$rootScope.finalutile,
                    quit:1,
                    deleteAccount:false
                };
                //console.log(params);
                $http.post(appSettings.baseUrl + '/judgment/'+token, params)
                                    .success(function(res) {
                                        console.log(res);
                                        $scope.redirectToDashbord();
                                    })
                                    .error(function(res) {
                                        $scope.redirectToHome();
                }); 
        }
        
        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * post WS pour abondonner le programme avec suppression de compte avec post des valeur sliders
         */
        $scope.AbonndonerAvecSupWithSlideVals=function() {
                var token=$window.localStorage.getItem('janrainCaptureToken');
                var datauser = JSON.parse($window.localStorage.getItem('janrainCaptureProfileData'));
                var params = {
                    uuid:datauser.uuid,
                    token:token,
                    contain:$rootScope.finalcontain,
                    duration:$rootScope.finalduration,
                    frequency:$rootScope.finalfrequency,
                    personalization:$rootScope.finalpersonalization,
                    useful:$rootScope.finalutile,
                    quit:1,
                    deleteAccount:true
                };
                $http.post(appSettings.baseUrl + '/judgment/'+token, params)
                                    .success(function(res) {
                                        console.log(res);
                                        $scope.redirectToDashbord();
                                    })
                                    .error(function(res) {
                                        $scope.redirectToHome();
                }); 
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
        * redirect to dashboard
        */
        $scope.redirectToDashbord = function() {
            $location.path('/dashboard');
        }
	
}])
