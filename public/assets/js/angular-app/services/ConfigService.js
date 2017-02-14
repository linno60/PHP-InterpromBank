app.service('ConfigService', ['$location', function($location){
	var ConfigService = this;
	ConfigService.api_endpoin = '/api/v1';

	ConfigService.error = {code: 0, text: 'No Errors'};

	ConfigService.get_url = function (url) {
		return ConfigService.api_endpoin+url
	}

}]);