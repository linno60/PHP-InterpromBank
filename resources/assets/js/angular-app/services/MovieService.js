app.service('MovieService', ['$http', '$q', 'ConfigService', function($http, $q, ConfigService){
	var MovieService = this;
	

	MovieService.all = function() {
	    var deferred = $q.defer();
	    
	    $http({
	        method: 'GET', 
	        url: ConfigService.get_url('/movies/')
	    })
	    .then(
	    	function(res) { deferred.resolve(res.data); },
		    function(res) { deferred.reject(res.data); }
	    );

	    return deferred.promise;
	}

	MovieService.get = function(id) {
	    var deferred = $q.defer();
	    
	    $http({
	        method: 'GET', 
	        url: ConfigService.get_url('/movies/'+id)
	    })
	    .then(
	    	function(res) { deferred.resolve(res.data); },
		    function(res) { deferred.reject(res.data); }
	    );

	    return deferred.promise;
	}

	MovieService.favorite = function() {
	    var deferred = $q.defer();
	    
	    $http({
	        method: 'GET', 
	        url: ConfigService.get_url('/favorite/')
	    })
	    .then(
	    	function(res) { deferred.resolve(res.data); },
		    function(res) { deferred.reject(res.data); }
	    );

	    return deferred.promise;
	}

	MovieService.add_movie = function(url) {
	    var deferred = $q.defer();
	    
	    $http({
	        method: 'POST', 
	        url: ConfigService.get_url('/movie/new_movie'),
	        data: {url: url}
	    })
	    .then(
	    	function(res) {	deferred.resolve(res.data); },
		    function(res) { deferred.reject(res.data); }
	    );

	    return deferred.promise;
	}

}]);

