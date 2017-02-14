app.directive('favoriteButton', ['UserService', function(UserService) {
	return {
		restrict: 'E', 
		scope: {movie: '=movie'}, 
		templateUrl: '/angular/directive/favorite-button.html',
		link: function(scope, elem, attrs) {
		  scope.is_auth = UserService.is_auth();	
		  elem.bind('click', function() {
		  	UserService.toogle_favorite(scope.movie.id).then(function (res) {
		  		scope.movie.is_favorite = res.is_favorite;
		  	})
		  });
		}

	};
}

]);