<!DOCTYPE html>
<html lang="en">
  <head>
    <title>{{config('app.name')}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <base href="/">
    <script>
      current_user = {!! $user !!};
    </script>
  </head>
  <body ng-app="LaraParser">
    <nav class="navbar navbar-dark bg-inverse">
      <div class="logo-block text-xs-center">
        <a  href="{{url('/')}}">{{config('app.name')}}</a>
      </div>

      <div class="nav-block">
        
        <ul class="nav navbar-nav col-md-3">

        </ul>

      </div>
   </nav>
    
    <div class="content">
        <div class="main-sidebar ng-cloak">
        	@if(Auth::check())
        	<div class="user-block">
				<img src="{{ Gravatar::src(\Auth::user()->email) }}">
        	</div>
        	@endif

        	<div class="sidebar-menu">
          @if(!Auth::check())
            <a href="/#!/auth" class="sidebar-menu-elem">
              <i class="fa fa-user"></i> Авторизация
            </a>

            <a href="/#!/register" class="sidebar-menu-elem">
              <i class="fa fa-user-plus"></i> Регистрация
            </a>
          @endif
        	
        		@if(Auth::check())
        		<div class="sidebar-menu-elem">
        			<i class="fa fa-user"></i> {{ Auth::user()->email }}
        		</div>
            
            <a class="sidebar-menu-elem" ui-sref="movies" ui-sref-active="active">
              <i class="fa fa-film" aria-hidden="true"></i> Все фильмы
            </a>

        		<a class="sidebar-menu-elem" ui-sref="favorite" ui-sref-active="active">
        			<i class="fa fa-heart"></i> Избранное
        		</a>
				
				<a class="sidebar-menu-elem" href="{{route('logout')}}">
        			<i class="fa fa-sign-out"></i> Выход
        		</a>
        		@endif
        	</div>
        </div>
        
@yield('content')
    </div>
      

<!--      <script defer src="/bower/jquery/dist/jquery.min.js"></script>
     <script defer src="/bower/tether/dist/js/tether.min.js"></script>
     <script defer src="/bower/bootstrap/dist/js/bootstrap.min.js"></script>
     <script defer src="/bower/bootstrap-validator/dist/validator.min.js"></script>
     
     <script defer src="/bower/angular/angular.min.js"></script>
     <script defer src="/bower/angular-ui-router/release/angular-ui-router.min.js"></script>
     <script defer src="/bower/angular-animate/angular-animate.min.js"></script>
     <script defer src="/bower/angular-bootstrap/ui-bootstrap.min.js"></script>
     <script defer src="/bower/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>

      <script defer src="/assets/js/angular-app/app.js"></script>
      <script defer src="/assets/js/angular-app/services/ConfigService.js"></script>
      <script defer src="/assets/js/angular-app/services/MovieService.js"></script>
      <script defer src="/assets/js/angular-app/services/UserService.js"></script>
      <script defer src="/assets/js/angular-app/directives/movie-info.js"></script>
      <script defer src="/assets/js/angular-app/directives/float-button.js"></script>
      <script defer src="/assets/js/angular-app/directives/movie-list.js"></script>
      <script defer src="/assets/js/angular-app/directives/favorite-button.js"></script>
      <script defer src="/assets/js/angular-app/ctrl/HomeCtrl.js"></script>
      <script defer src="/assets/js/angular-app/ctrl/FavoriteCtrl.js"></script> -->

     <script defer src="/assets/js/scripts.js?ver={{filemtime(public_path().'/assets/js/scripts.js')}}"></script>
     <link rel="stylesheet" href="/assets/css/style.css?ver={{filemtime(public_path().'/assets/css/style.css')}}" type='text/css' />
  </body>
</html>