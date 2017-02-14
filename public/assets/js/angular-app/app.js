var app = angular.module('LaraParser', ['ui.router', 'ui.bootstrap', 'ngAnimate']);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
  });

app.run(function ($rootScope, UserService, ConfigService) {
	$rootScope.UserService = UserService;
	$rootScope.ConfigService = ConfigService;
});

app.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
	
	$stateProvider
	    .state('movies', {
	        url: '/',
	        templateUrl: 'angular/pages/index.html',
	        controller: 'HomeCtrl',
	});

	$stateProvider
	    .state('movie', {
	        url: '/movie/:id',
	        resolve: {
	          movie: ['$stateParams', 'MovieService', function($stateParams, MovieService){
	            return MovieService.get($stateParams.id);
	          }]
	        },
	        controller: ['$scope', 'movie', function($scope, movie) {
     			$scope.movie = movie;
     	   }],
	        templateUrl: 'angular/pages/movies/show.html'
	});

	$stateProvider
	    .state('favorite', {
	        url: '/favorite',
	        templateUrl: 'angular/pages/index.html',
	        controller: 'FavoriteCtrl',
	});


	$stateProvider
	    .state('auth', {
	       url: '/auth',
	       templateUrl: 'angular/pages/auth.html'
	});	

    $stateProvider
        .state('register', {
           url: '/register',
           templateUrl: 'angular/pages/register.html'
    });	

	$urlRouterProvider.otherwise('/');

}]);