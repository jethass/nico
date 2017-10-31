//date picker avec date d'aujourd'hui+30j
app.directive("dateTimePickerPlusMois", ["$rootScope", "$timeout", function($rootScope, $timeout) {
        return {
            restrict: "A",
            scope: true,
            link: function(scope, element, attrs) {
                var myDate = new Date();
                //date +30
                var cibledate = new Date(myDate);
                cibledate.setDate(myDate.getDate() + 30);

                $(element).datetimepicker({
                    pickTime: false,
                    defaultDate: cibledate,
                    minDate: myDate,
                    language: 'fr'
                });


            }

        }
    }]);

//date picker avec date d'aujourd'hui
app.directive("dateTimePickerNow", ["$rootScope", "$timeout", function($rootScope, $timeout) {
        return {
            restrict: "A",
            scope: true,
            link: function(scope, element, attrs) {
                var myDate = new Date();
                //var myDatemin = new Date(2015,0,01);
                var cibledate = new Date(myDate);
                cibledate.setDate(myDate.getDate() - 90);

                $(element).datetimepicker({
                    pickTime: false,
                    defaultDate: myDate,
                    maxDate: myDate,
                    minDate: cibledate,
                    language: 'fr'
                });


            }

        }
    }]);

//date picker sans date
app.directive("dateTimePicker", ["$rootScope", "$timeout", function($rootScope, $timeout) {
        return {
            restrict: "A",
            scope: true,
            link: function(scope, element, attrs) {

                $(element).datetimepicker({
                    pickTime: false,
                    language: 'fr'

                });

            }
        }
    }]);