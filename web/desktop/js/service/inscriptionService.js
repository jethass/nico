app.factory('inscriptionService', ['$http', 'appSettings', '$q', '$window', function ($http, appSettings, $q, $window) {


        /* get Verification Code code from janrain*/
        var getVerifCodeAndSendMail = function (uuid, email, status) {
            var deferred = $q.defer();

            $http.get(appSettings.baseUrl + "/user/verificationCode/" + uuid + "?email=" + email + "&status=" + status)
                    .success(function (res) {
                        deferred.resolve(res);
                    })

                    .error(function (res) {
                        deferred.reject(res);
                    });

            return deferred.promise;
        }

        /* get CitiesNames */
        var getCitiesNames = function (zip) {
            var deferred = $q.defer();

            $http.get(appSettings.baseUrl + "/cities/getCities/" + zip)
                    .success(function (res) {
                        deferred.resolve(res);
                    })

                    .error(function (res) {
                        deferred.reject(res);
                    });

            return deferred.promise;
        }

        /* get Zip Codes */
        var getZipCodes = function (city) {
            var deferred = $q.defer();

            $http.get(appSettings.baseUrl + "/cities/getZipCodes/" + city)
                    .success(function (res) {
                        deferred.resolve(res);
                    })

                    .error(function (res) {
                        deferred.reject(res);
                    });

            return deferred.promise;
        }

        return {
            getVerifCodeAndSendMail: getVerifCodeAndSendMail,
            getCitiesNames: getCitiesNames,
            getZipCodes: getZipCodes,
        }




    }])
