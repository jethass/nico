app.controller('contratCtrl',['$scope','$rootScope','$location','$routeParams','$http','$q','appSettings','$window', 'authService',function($scope,$rootScope,$location,$routeParams,$http,$q,appSettings,$window, authService){

	//for show loading
	//$rootScope.loading=true;
	$scope.page="contrat";
	$scope.numcontrat=$routeParams.type;
	$scope.felicitation=false;
	$scope.checkEngaged=false;
	
	
	var DateNow=new Date();
	//date +91
	var maxdate = new Date(DateNow);
	maxdate.setDate(DateNow.getDate()+91);
	
	angular.element(document).ready(function () {

		if($scope.numcontrat==1){
			    var date_max = new Date(maxdate.getFullYear(),maxdate.getMonth(),maxdate.getDate());			
				var date_auto_inserted=$('#date-arret').data("DateTimePicker").getDate().format('YYYY/MM/DD');
				
			    
			    $('#date-arret').on("dp.change",function (e) {
			    	var date_auto_changed=$('#date-arret').data("DateTimePicker").getDate().format('YYYY/MM/DD');
					var tab= date_auto_changed.split("/");
			        var date_in_picker = new Date(tab[0],(tab[1])-1,tab[2]);
					
			    	if(date_auto_changed != date_auto_inserted){
				          if(date_in_picker > date_max ){
				        	  //console.log("plus que 3 mois");
				        	  $("#modal1").trigger("click");
				        	  $scope.felicitation=false;
				        	  
				          }else if(date_in_picker < date_max){
				        	  //console.log("moins que 3 mois");
				        	  $('#date-arret').data("DateTimePicker").disable();
				        	  $scope.felicitation=true;
				        	  $scope.$apply();
				        	 
				        	 
				          }else{
				        	  //console.log("egale 3 mois");
				        	  $('#date-arret').data("DateTimePicker").disable();
				        	  $scope.felicitation=true;
				        	  $scope.$apply();				        	  		        	  
				          }  
				         
			    	}
			    	
		        });
			   
	    }   
	});
	
	$scope.arreteNow=function(){
		$('#date-arret').data("DateTimePicker").setDate(DateNow.getDate()+"/"+(DateNow.getMonth()+1)+"/"+DateNow.getFullYear());
		$('#date-arret').data("DateTimePicker").disable();
                
                $('.date-arret-m').data("DateTimePicker").setDate(DateNow.getDate()+"/"+(DateNow.getMonth()+1)+"/"+DateNow.getFullYear());
		$('.date-arret-m').data("DateTimePicker").disable();
                
		$scope.felicitation=true;
		
	}
	 
	$scope.submitData = function (){
		   if( $("#condition-contrat1").is(':checked') ){
			   
				   $scope.checkEngaged=false;
				   var date=$('#date-arret').data("DateTimePicker").getDate().format('YYYY-MM-DD');
		           console.log(appSettings.baseUrl+'/contract/1?quitDate='+date+'&token='+ $window.localStorage.getItem('janrainCaptureToken') +'&angajed=1');
					 
                     $http.post(appSettings.baseUrl+'/contract/1?quitDate='+date+'&token='+ $window.localStorage.getItem('janrainCaptureToken') +'&angajed=1')
					 .success(function(res){
							 if(res.success){
								 $("#modal3").trigger("click");
							 }else{
								 alert("veuillez vous reconnecter!") 
							 }
					 })
					 .error(function(res){
						 alert("veuillez vous reconnecter!");
					 });

		   }else{
			      $scope.checkEngaged=true;
		   }
     }
	
	$scope.submitDataLastCigarette= function (){
		   if( $("#condition-contrat2").is(':checked') ){
			   
			  
			   var date=$('#date-arret-last-cigarette').data("DateTimePicker").getDate().format('YYYY-MM-DD');
	           console.log(appSettings.baseUrl+'/contract/lastOne/1?lastSmokedon='+date+'&token='+$window.localStorage.getItem('janrainCaptureToken')+'&angajed=1');
	           
                 $http.post(appSettings.baseUrl+'/contract/lastOne/1?lastSmokedon='+date+'&token='+$window.localStorage.getItem('janrainCaptureToken')+'&angajed=1')
				 .success(function(res){
						 if(res.success){
							 $("#modal5").trigger("click");
						 }else{
							 alert("veuillez vous reconnecter!") 
						 }
				 })
				 .error(function(res){
					 alert("veuillez vous reconnecter!");
				 });

	     }else{
	    	 $("#modal4").trigger("click");
	     }
   }
	
	$scope.redirectToPlan=function(){
		$location.path('/plan-action');
	}
	
	$scope.fixLater = function(){
        authService.fixLater()
        .then(
            function(res){
            	$location.path('/dashboard');
            }
        );
	}
	
}])








