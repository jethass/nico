app.controller('mesParrainsCtrl', ['headerService','$scope', '$rootScope', '$location', '$http', '$q', 'appSettings', '$window', 'authService', '$timeout', function(headerService,$scope, $rootScope, $location, $http, $q, appSettings, $window, authService, $timeout) {

        //for show loading
        $rootScope.loading = true;
        $scope.postLoding = false;
        $scope.page = "mes-parrains";
        $scope.userName = authService.user.data.givenName;
        $scope.infosHeader = [];
        
        $scope.sponsor = {};
        $scope.sponsors = [];
        $scope.nbr_parrains = 0;

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
            if ($scope.sponsors.length == 0) {
                $scope.getSponsors().then(
                        function(res) {
                            $scope.sponsors = res;
                            $scope.nbr_parrains = $scope.sponsors.length;
                            $rootScope.loading = false;
                        },
                        function(res) {
                            alert("Une erreur s'est produite lors de connexion au web service!")
                        }
                );
            }
        });
        
        $scope.scrolToTop=function(){
            $("html, body").delay(50).animate({scrollTop: $('#formAddSp').offset().top-200 }, 150);
        }

        /* récuperer sponsors
         * $http get
         * author hassine.lataoui@proxym-it.com
         */
        $scope.getSponsors = function() {
            var deferred = $q.defer();

            var token = $window.localStorage.getItem('janrainCaptureToken');
            $http.get(appSettings.baseUrl + '/sponsoring/' + token + '?uuid=' + authService.user.data.uuid + '&token=' + token + '')
                    .success(function(res) {
                        deferred.resolve(res.data.contacts);
                    })
                    .error(function(res) {
                        deferred.reject(res);
                    });

            return deferred.promise;
        };


        /* ajout sponsor
         * $http post
         * author hassine.lataoui@proxym-it.com
         */
        $scope.newSponsor = function() {
            $scope.ErrorTel=null;
            $scope.ErrorEmail=null;
            $scope.EmailVide=null;
            var TEL_REGEXP = /^0[6-7]([-. ]?[0-9]{2}){4}$/;
            var EMAIL_REGEXP = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            
            var is_tel=TEL_REGEXP.test($scope.sponsor.tel);
            var is_mail=EMAIL_REGEXP.test($scope.sponsor.email);
          
            if(is_tel){$scope.ErrorTel=false; }else{ $scope.ErrorTel=true;}
            if(is_mail){$scope.ErrorEmail=false; }else{ $scope.ErrorEmail=true;}
            if($scope.sponsor.email!= undefined){$scope.EmailVide=false;}else{$scope.EmailVide=true;}

            $scope.sponsorSavedSucess = false;
            $scope.sponsorUpdatedSucess = false;
            $scope.sponsorSavedError = false;

            if ($scope.sponsor && ( $scope.sponsor.tel != undefined && is_tel && is_mail && $scope.sponsor.id != undefined) ) {
                    $scope.postLoding = true;
                    console.log("update");
                    var token = $window.localStorage.getItem('janrainCaptureToken');
                    var params = {
                        uuid: authService.user.data.uuid,
                        token: $window.localStorage.getItem('janrainCaptureToken'),
                        contact_id: $scope.sponsor.id,
                        name: $scope.sponsor.nom,
                        email: $scope.sponsor.email,
                        phone: $scope.sponsor.tel
                    };

                    $http.put(appSettings.baseUrl + '/sponsoring/update/' + token + '', params)
                            .success(function(res) {
                                $scope.sponsorUpdatedSucess = true;
                                $timeout(function() {
                                    $scope.getSponsors().then(
                                            function(res) {
                                                $scope.sponsors = res;
                                                $scope.nbr_parrains = $scope.sponsors.length;
                                                $scope.postLoding = false;
                                            },
                                            function(res) {
                                                console.log(res);
                                            }
                                    );
                                }, 100);
                                $scope.sponsor = {};
                            })
                            .error(function(res) {
                                $scope.sponsorSavedError = true;
                            });

                } else if ($scope.sponsor && ($scope.sponsor.tel != undefined && is_tel && is_mail && $scope.sponsor.id == undefined) ) {
                    
                    if ($scope.nbr_parrains >= 3) {
                          alert("Vous pouvez pas ajouté des parrins!");
                    }else{
                                 $scope.postLoding = true;
                                 console.log("sauvegarde");
                                 var params = {
                                     uuid: authService.user.data.uuid,
                                     token: $window.localStorage.getItem('janrainCaptureToken'),
                                     name: $scope.sponsor.nom,
                                     email: $scope.sponsor.email,
                                     phone: $scope.sponsor.tel
                                 };
                                 $http.post(appSettings.baseUrl + '/sponsoring/new', params)
                                         .success(function(res) {
                                             $scope.sponsorSavedSucess = true;
                                             $timeout(function() {
                                                 $scope.getSponsors().then(
                                                         function(res) {
                                                             $scope.sponsors = res;
                                                             $scope.nbr_parrains = $scope.sponsors.length;
                                                             $scope.postLoding = false;
                                                         },
                                                         function() {
                                                             console.log(res);
                                                         }
                                                 );
                                             }, 100);
                                             $scope.sponsor = {};
                                         })
                                         .error(function(res) {
                                             $scope.sponsorSavedError = true;
                                         });

                    }         
                            
                } else {
                    return;
                }

            

        };


        /* supprimer sponsor
         * $http delete
         * author hassine.lataoui@proxym-it.com
         */
        $scope.deleteSponsor = function(id) {
            var token = $window.localStorage.getItem('janrainCaptureToken');
            var params = {
                uuid: authService.user.data.uuid,
                contact_id: id,
                token: $window.localStorage.getItem('janrainCaptureToken')
            };
            var config = {
                params: params
            };

            if (confirm("Êtes-vous sûr de vouloir supprimer définitivement ce contact?") == true) {
                $http.delete(appSettings.baseUrl + '/sponsoring/delete/' + token + '', config)
                        .success(function(res) {
                            $timeout(function() {
                                $scope.getSponsors().then(
                                        function(res) {
                                            $scope.sponsors = res;
                                            $scope.nbr_parrains = $scope.sponsors.length;
                                        },
                                        function() {
                                            console.log(res);
                                        }
                                );
                            }, 100);
                        })
                        .error(function(res) {
                            alert("Une erreur s'est produite lors de connexion au web service!")
                        });
            } else {

            }
        };


        $scope.editSponsor = function(id) {
            $scope.editcontact = {};
            $scope.getSponsors().then(
                    function(res) {
                        for (key in res) {
                            if (res[key].id == id) {
                                $scope.editcontact = res[key];
                            }
                        }
                        $timeout(function() {
                            $scope.sponsor.id = $scope.editcontact.id;
                            $scope.sponsor.nom = $scope.editcontact.name;
                            $scope.sponsor.email = $scope.editcontact.email;
                            $scope.sponsor.tel = $scope.editcontact.phone;
                        }, 100);

                    },
                    function() {
                        console.log(res);
                    }
            );
        };
        
        
        //ajout des point WS
        $scope.ajoutPoint=function(type_point){
            var params = {
                type: type_point,
                token: $window.localStorage.getItem('janrainCaptureToken')
            };
            $http.post(appSettings.baseUrl + '/patient/add-extra-point',params)
                        .success(function(res) {
                            console.log(res);
                        })
                        .error(function(res) {
                            console.log(res);
                        });
        }


    }])




