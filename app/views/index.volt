<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Phalcon PHP Framework</title>
{{stylesheet_link("https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.9/semantic.min.css")}}
{{stylesheet_link("https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.1/themes/prism-okaidia.min.css")}}
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
{{stylesheet_link("public/css/styles.css")}}
{{javascript_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js")}}

</head>
<body>
	<header class="ui fixed inverted menu bs-docs-nav" id="top"
		role="banner">
		<div class="ui container">
			<div class="ui menu secondary">
				<div class="header item">
					<i class="cloud big icon"></i>
					Virtualhosts
				</div>
				{% if this.session.has("auth") %}
				
				 <!-- <a href="{{url.get()}}" class="item">Accueil</a> -->
				<a href={{ url("Accueil/logout") }} class="item">Déconnexion</a>
				
				{% else %}
				
				<a href={{ url("Accueil/signIn") }} class="item">Connexion</a>
				<a href={{ url("Accueil/signUp") }} class="item">Inscription</a>
				
                <div class="w3-container item">
                  <div class="w3-dropdown-hover">
                    <button class="w3-button">Connexion en tant que
                    <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                    </button>
                    <div class="w3-dropdown-content w3-border dropdown-connect">
                     <a href={{ url("Accueil/asAdmin") }} class="item">Administrateur</a>
                     <a href={{ url("Accueil/asUser") }} class="item">Utilisateur</a>
                    </div>
                  </div>
                </div>
				{% endif %}
			</div>
		</div>
	</header>
	<div class="pagehead">
		<div id="secondary-container" class="ui container">
			{{ q["secondary"] }}
		</div>
	</div>

	<div id="main-container" class="ui container">
		<div id="tools-container">
			{{ q["tools"] }}
		</div>
		{% include 'partials/flash.volt' %}
		<div id="content-container" class="ui segment">{{ content() }}</div>
	</div>

	<footer>
		<div class="ui container">Mentions légales :
			<ul>
				<li><a href="https://phalconphp.com/fr/">© 2016 phalcon 3.0</a></li>
				<li><a href="http://phpmv-ui.kobject.net/">© 2016 phpMv-UI 2.0</a></li>
			</ul>
		</div>
	</footer>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<!-- Latest compiled and minified JavaScript -->
	{{javascript_include("https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.1/prism.min.js")}}
	{{javascript_include("https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.1/components/prism-apacheconf.min.js")}}
	{{javascript_include("https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.js")}}
	{% if script_foot is defined %}
	{{ script_foot }}
	{% endif %}
</body>
</html>
