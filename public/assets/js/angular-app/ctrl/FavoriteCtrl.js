app.controller('FavoriteCtrl', ['$scope', '$http', 'MovieService', 'UserService', function($scope, $http, MovieService, UserService) {
	$scope.movies = {};

	MovieService.favorite().then(function (res) {
		$scope.movies = res;
	});

}]);