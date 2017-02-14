app.controller('HomeCtrl', ['$scope', '$http', 'MovieService', 'UserService', function($scope, $http, MovieService, UserService) {
	$scope.movies = {};
	
	MovieService.all().then(function (res) {
		$scope.movies = res;
	});

}]);