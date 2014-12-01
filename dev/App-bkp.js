//http://tableless.com.br/diretivas-angularjs-abas/
	var App=angular.module('App',['App.constants', 'App.controllers','mgcrea.ngStrap']);
	angular.module('App.controllers', ['App.constants']);
	//angular.module('App.constants', []).constant('_token', angular.element('meta[name=_token]')[0].content);
	angular.module('App.constants', []).constant('_token', 'Teste');

//angular.module("App", ["ngResource","ngRoute","ngSanitize"]).run;

App.run(function($http, $location, AuthenticationService) {
  $http.get("http://stivyw.no-ip.org:120/auth").then(function(response) {
    angular.module("app").constant("CSRF_TOKEN", response.data.csrf_token);
    angular.bootstrap(document, ['app']);
  });
});


	App.service('Data', function () {

		return {
			tabPrefix: 'tab_',
			tabIndex:0,
			tabs:[],
			conf:{},
			instance: function(){
				return Data;
			},
			newTab: function(u, t){
				this.tabIndex = this.tabs.push({title:t||'...',i: this.tabs.length, url: u}) - 1;
			},
			closeTab: function(i){
				var l = this.tabs.length-1, c = this.tabIndex;
				//return console.log(i);
				this.tabs.splice(i, 1);
				var n=0;
				for (var n = this.tabs.length - 1; n >= 0; n--) {
					this.tabs[n].i=n;
				};
				if(c > i || c==l){
					this.tabIndex--;	
				}
			}
		};
	});
//	App.config(function($httpProvider, _token) {
//	  $httpProvider.defaults.headers.common = {'X-CSRF-Token': _token, 'Content-Type': 'application/json'};
//	});


	//App.controller('Form', function($scope){$scope.SelfTab = 3;});
	App.controller('Tabs', ['$scope', 'Data', function($scope, Data){
		$scope.Data = Data;
		
		Data.tabs.push({title:'Home', url: 'views/home.html', i:'home', fix:true});
		Data.tabIndex = Data.tabs[0].i;
		//this.$setActive(0);
	}]);

	App.controller('TopBar', ['$scope', '$http', 'Data', function($scope, $http, Data){

		$http.post('/Test/public/auth',{username:'stivyw', password:'admin'}).success(function(data, status){
			console.log(data);
		});

		$scope.Data=Data;
		$http.get('conf.json').
		 success(function(data, status) {
			$scope.status = status;
			Data.conf = data;
		 }).
		 error(function(data, status) {
		 	alert('erro ao carregar script');
			$scope.status = status;
		 }
		);
		//alert(Data.menus.menu1[0].dpdown);
	}]);

/**/
