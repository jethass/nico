app.controller('boutonPaniqueZutCtrl', ['$scope', '$rootScope', '$location', 'authService','$http', '$q', 'appSettings', '$window','$timeout', function($scope, $rootScope, $location, authService,$http,$q, appSettings, $window,$timeout) {

	//for show loading
	$rootScope.loading=true;
	$scope.page="bouton-panique-zut";
	$scope.userName=authService.user.data.givenName;
        
        $scope.questionsFirst=null;
        $scope.questionsThird=null;
        
        $scope.answersFirst={};
        $scope.answersThird={};
       
        $scope.ShowOneTowQuestion=true;
        $scope.ShowThirdQuestion=false;
        $scope.answers = {};
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * excution en chargement de la page
        */
        angular.element(document).ready(function() {
                $scope.crackedFirstWs().then(
                            function(res) {// success 
                                console.log(res);
                                $scope.questionsFirst=res.quiz.questions;
                                $scope.codeFirst=res.quiz.code;
                                $rootScope.loading=false;
                            },
                            function() {// fail 
                               $scope.redirectToHome();
                            }
                );

        });
        

        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * WS cracked : GET
        */
        $scope.crackedFirstWs = function() {
            var deferred = $q.defer();
            var token = $window.localStorage.getItem('janrainCaptureToken');
            $http.get(appSettings.baseUrl + '/panic/cracked/first/' + token + '?token=' + token + '')
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
        * WS cracked : GET
        */
        $scope.crackedThirdWs = function() {
            var deferred = $q.defer();
            var token = $window.localStorage.getItem('janrainCaptureToken');
            $http.get(appSettings.baseUrl + '/panic/cracked/third/' + token + '?token=' + token + '')
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
        * function validation/submit  (question 1/2) reponses
        */
        $scope.submitOneTowReponses=function(){
              $scope.questionError=[];

             $scope.questionsFirst.forEach(function(question,index){
                       if(!$scope.answersFirst[question.id] || isEmpty($scope.answersFirst[question.id])){
                           $scope.questionError[question.id]="Merci de répondre à cette question.";
                       }
              });
              
              if (getArrayLength($scope.questionError) == 0) {
                     var key;
                     var questionAnswers=[];
                     for(key in $scope.answersFirst){
                        for(i=0;i<$scope.answersFirst[key].length;i++){   
                            questionAnswers.push({'QuestionId':key,'ChoiceId':$scope.answersFirst[key][i].id});
                        }
                     };
                     
                    var token = $window.localStorage.getItem('janrainCaptureToken');
                                        
                    var params = {
                      method: 'POST',
                      token: token,
                      answers: questionAnswers
                    };
                    
                    //console.log(params);
                    $http.post(appSettings.baseUrl + '/extra_quiz/answers/save/'+$scope.codeFirst+'',params)
                    .success(function(res) {
                               console.log(res); 
                                $timeout(function() {
                                       $scope.crackedThirdWs().then(
                                                    function(result) {// success 
                                                        console.log(result);
                                                        $scope.questionsThird=result.quiz.questions;
                                                        $scope.codeThird=result.quiz.code;
                                                        $scope.ThirdQuestion_idAnswer=result.lastAnswers.idAnswer;
                                                        $scope.check_choice=result.lastAnswers.idChoice;
                                                    },
                                                    function() {// fail 
                                                       $scope.redirectToHome();
                                                    }
                                        );
                                        $scope.$apply(function() {
                                               $scope.ShowOneTowQuestion=false;
                                               $scope.ShowThirdQuestion=true;
                                         });
                                }, 100);
                    })
                    .error(function(res) {
                            $scope.redirectToHome();
                    });
                  
              }
            
        }
        
        
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * function validation/submit  (question 3) reponses
        */
        $scope.submitThirdReponses=function(){
                        var token = $window.localStorage.getItem('janrainCaptureToken');
                        
                        var key;
                        var choicesIds=[];
                        for (key in $scope.answers) {
                                for (i = 0; i < $scope.answers[key].length; i++) {
                                    choicesIds.push($scope.answers[key][i].id);
                                 }
                        };
                         //if tout le temps cliqué
                       // if ($("#r-183").is(':checked')) {
                       if( $.inArray(183,choicesIds) != -1){
                              var idAnswer = $scope.ThirdQuestion_idAnswer;
                              var idChoice = 183;//$("#r-183").val();
                               if(idAnswer!=false){
                                   var tabParams =prepareData(idAnswer,idChoice,token,'PUT');
                               }else{
                                   var tabParams =prepareData(idAnswer,idChoice,token,'POST');
                               }
                              $timeout(function() {
		   		    WsPost($scope.codeThird,tabParams,"modalLisezAstuces");
		   	      }, 200);
                       }

                        //if parfois cliqué
                        //if ($("#r-184").is(':checked')) {
                        if( $.inArray(184,choicesIds) != -1){
                              var idAnswer = $scope.ThirdQuestion_idAnswer;
                               var idChoice =184; //$("#r-184").val();
                               if(idAnswer!=false){
                                   var tabParams =prepareData(idAnswer,idChoice,token,'PUT');
                               }else{
                                   var tabParams =prepareData(idAnswer,idChoice,token,'POST');
                               }
                              $timeout(function() {
		   		    WsPost($scope.codeThird,tabParams,"modalparfois");
		   	      }, 200);
                        }
                        //if non cliqué
                        //if ($("#r-185").is(':checked')) {
                        if( $.inArray(185,choicesIds) != -1){     
                               var idAnswer = $scope.ThirdQuestion_idAnswer;
                               var idChoice =185; //$("#r-185").val();
                               if(idAnswer!=false){
                                   var tabParams =prepareData(idAnswer,idChoice,token,'PUT');
                               }else{
                                   var tabParams =prepareData(idAnswer,idChoice,token,'POST');
                               }
                              $timeout(function() {
		   		    WsPost($scope.codeThird,tabParams,"modalNon");
		   	      }, 200);
                        }
        }
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * prepare data for ws
        */
        function prepareData(id_answer,choice,tokeen,method){
                           var answers = [
                                {"idAnswer": id_answer, "idChoice": choice},
                            ];
                            var params = {
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
        function WsPost(code,arrayParams,modalId){
                 //$http.post(appSettings.baseUrl + '/extra_quiz/answers/save/'+code+'',arrayParams)
                 $http.post(appSettings.baseUrl + '/diary/answers/save/' +code+'',arrayParams)
                      .success(function(res) {
                                  console.log(res);
                                  $("#"+modalId).modal();
                      })
                      .error(function(res) {
                                  $scope.redirectToHome();
                  });
        }
        
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * vérifie si le choice est egale au choice retourné, si oui return true pour le checker.
        */
        $scope.checkRadio=function(choice_id){
                if(choice_id == $scope.check_choice){
                        return true;
                }else{
                       return false;
                }
	   
        };
        
        
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
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * redirect to dashboard
        */
        $scope.redirectToDashbord = function() {
            $location.path('/dashboard');
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
        * redirect to panic
        */
        $scope.redirectToPanic = function() {
            $location.path('/bouton-panique-zut');
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
	
}])