app.directive('movieInfo', function() {
	return {
		restrict: 'E',
		scope: {movie: '=movie'}, 
		templateUrl: '/angular/directive/movie-info.html' };
});