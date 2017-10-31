app.controller('boutonPaniqueCrackCtrl', ['$scope', '$rootScope', '$location', 'authService', '$http', '$q', 'appSettings', '$window', function($scope, $rootScope, $location, authService, $http, $q, appSettings, $window) {
        //for show loading
        $rootScope.loading = true;
        $scope.page = "bouton-panique-crack";
        $scope.userName = authService.user.data.givenName;
        $scope.questions = null;
        $scope.answers = {};

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * excution en chargement de la page
         */
        angular.element(document).ready(function() {
            $scope.NotCrackedWs().then(
                    function(res) {// success 
                        console.log(res);
                        $scope.questions = res.quiz.questions;
                        $scope.code = res.quiz.code;
                        $rootScope.loading = false;
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
        $scope.NotCrackedWs = function() {
            var deferred = $q.defer();
            var token = $window.localStorage.getItem('janrainCaptureToken');
            $http.get(appSettings.baseUrl + '/panic/not-cracked/' + token + '?token=' + token + '')
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
         * function for insert reponses choice for question radio3
         */
        $scope.setYesOrNoValueR3 = function(choice, question_id) {
            var tab = [];
            tab[0] = choice;
            $scope.answers[question_id] = tab;
        };

        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * function for insert reponses choice for question radio4
         */
        $scope.setYesOrNoValueR4 = function(choice, question_id) {
            var tab = [];
            tab[0] = choice;
            $scope.answers[question_id] = tab;
        };


        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * function validation si objet est vide
         */
        function isEmpty(value) {
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
         * function validation/submit  reponses
         */
        $scope.submitReponses = function() {
            $scope.questionError = [];
            $scope.questions.forEach(function(question, index) {
                if (!$scope.answers[question.id] || isEmpty($scope.answers[question.id])) {
                    $scope.questionError[question.id] = "Merci de répondre à cette question.";
                }
            });


            if (getArrayLength($scope.questionError) == 0) {
                var key;
                var questionAnswers = [];
                for (key in $scope.answers) {
                    for (i = 0; i < $scope.answers[key].length; i++) {
                        questionAnswers.push({'QuestionId': key, 'ChoiceId': $scope.answers[key][i].id});
                    }
                };

                var token = $window.localStorage.getItem('janrainCaptureToken');

                var params = {
                    method: 'POST',
                    token: token,
                    answers: questionAnswers
                };

                $http.post(appSettings.baseUrl + '/extra_quiz/answers/save/' + $scope.code + '', params)
                        .success(function(res) {
                            console.log(res);
                            $scope.redirectToDashbord();
                        })
                        .error(function(res) {
                            $scope.redirectToHome();
                        });
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

    }])