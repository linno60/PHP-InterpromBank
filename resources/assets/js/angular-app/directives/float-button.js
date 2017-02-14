app.directive('floatButton', ['MovieService', function(MovieService) {
	return {
		restrict: 'E', 
		templateUrl: '/angular/directive/float-button.html',
		link: function(scope, elem, attrs) {
			scope.error = '';
			
			scope.addMovie = function () {
				scope.is_show = true;
				scope.is_load = true;
				
				MovieService.add_movie(scope.movie_url).then(
					function (res) {
						scope.is_load = false;

						if(res.success) { scope.movie = res.movie; } 
						else { scope.error = res.error; }
					}
				);
			}
		  elem.find('.float-button').bind('click', function() {
		  	angular.element('#newMovie').modal('toggle');
		  });
		}

	};
}

]);