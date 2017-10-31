app.directive('ngComment',function(){
       return {
             scope:{
                 comment: '='
                 //commenta:'@comment',
                 //select: '&select'
             },
             restrict:'E',
             templateUrl:'/mobile/partials/_comment.html'
       }
   }
);

app.directive('endRepeatSwipe', function ($timeout) {
			return {
                                scope:{},
				restrict: 'A',
				link: function (scope, element, attr) {
					if (scope.$last === true) {
						$timeout(function () {
							scope.$emit('ngRepeatSwipeFinished');
                                                       
						},500);
					}
				}
			}
});

/*
app.directive('time',function(dateFilter,$interval){
       return {
             scope:{
             },
             link: function(scope,element,attrs){
                 scope.time=dateFilter(new Date(),'hh:mm:ss');
                 element.on('$destroy',function(){
                     $interval.cancel(interval);
                 })
                 interval=$interval(function(){
                     scope.time=dateFilter(new Date(),'hh:mm:ss');
                 },1000);
             },
             restrict:'E',
             template:'{{time}}'
       }
   }
);


app.directive('datepicker',function(){
       return {
             restrict:'C',
             scope:{
                 options:'=datepickerOptions'
             },
             link: function(scope,element,attrs){
                 $(element).pickadate(scope.options);
             }
       }
   }
);

app.directive('ngTest',function(){
       return {
             template:'<div>\n\
                              Salut<strong>{{username}}</strong>\n\
                              <div ng-transclude></div>\n\
                      </div>',
             restrict:'A',
             transclude: true,
             scope:{
                 username: '='
             }
       }
   }
);

*/

app.directive('ngTabs', function() {
	return {
		restrict: 'E', 
		transclude: true,
		templateUrl: '/mobile/partials/directive/tabs.html',
		scope: {

		},
		controller: function($scope) {
			
			$scope.tabs = [];

			$scope.select = function(tab) {
				
				angular.forEach($scope.tabs, function(t) {
					t.selected = false;
				});

				tab.selected = true;
			};

			this.add = function(tab) {
				if($scope.tabs.length == 0) {
					$scope.select(tab);
				}
				$scope.tabs.push(tab);
			}
		}
	}
});

app.directive('ngTab', function() {
	return {
		restrict: 'E', 
		transclude: true,
		scope: {
			title: '@'
		},
		templateUrl: '/mobile/partials/directive/tab.html',
		require: '^ngTabs',
		link: function(scope, element, attrs, tabsCtrl) {
			scope.selected = false;
			tabsCtrl.add(scope);
		}
	}
});