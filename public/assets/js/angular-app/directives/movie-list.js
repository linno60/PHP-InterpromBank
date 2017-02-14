app.directive('movieList', ['$timeout', function($timeout) {
	return {
		restrict: 'EA',
		scope: {movies: '=', perPage: '=?', currentPage: '=?', showPaginate: '=?'}, 
		templateUrl: '/angular/directive/movie-list.html',
		link: function($scope, $elem, $attrs) {
			if(angular.isUndefined($scope.currentPage)) { $scope.currentPage = 1; } 
			if(angular.isUndefined($scope.perPage)) { $scope.perPage = 10; } 
			if(angular.isUndefined($scope.showPaginate)) { $scope.showPaginate = true; } 

			$scope.page_changed = function(page) {
			  $scope.currentPage = page;
			};

			$scope.per_page = $scope.perPage;
			$scope.show_paginate = $scope.showPaginate;

			$scope.$watch("currentPage", function() {
				var begin = (($scope.currentPage - 1) * $scope.per_page),
				    end = begin + $scope.per_page;
				    $scope.filtered_movies = $scope.movies.slice(begin, end);
			});

		}, 

	}
}]);