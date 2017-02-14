app.service('UserService', ['$http', '$q', 'ConfigService', '$window',function($http, $q, ConfigService, $window){
	var UserService = this;
	UserService.user = $window.current_user;

	UserService.is_auth = function () {
		return !Object.keys(UserService.user).length == 0
	}

	UserService.toogle_favorite = function(movie_id) {
	    var deferred = $q.defer();
	    
	    $http({
	        method: 'POST', 
	        url: ConfigService.get_url('/favorite_update/'),
	        data: {movie_id: movie_id }
	    })
	    .then(
	    	function(res) { deferred.resolve(res.data); },
		    function(res) { deferred.reject(res.data); }
	    );

	    return deferred.promise;
	}


}]);

