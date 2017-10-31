app.directive('wrapOwlcarousel', function () {  
    return {  
        restrict: 'E',  
        link: function (scope, element, attrs) {  
             var options = scope.$eval($(element).attr('data-options'));  
           
             $(element).owlCarousel(options);  
            
              $(".next").click(function(){
            	  $(element).trigger('owl.next');
              })
              $(".prev").click(function(){
            	  $(element).trigger('owl.prev');
              })
              $(".item img").click(function(){
            	  $(element).trigger('owl.next');
              })
             
              //$(element).jumpTo(5);
        }  
    };  
});  
