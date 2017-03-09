<?php
class AppHelper {
	
	public static function getNbUsers(){
		return count(User::find());
	}
	
	public static function getNbHosts(){
		return count(Host::find());
	}
	
	public static function getNbVhosts(){
		return count(Virtualhost::find());
	}
	
	public static function getNbServers(){
		return count(Server::find());
	}
}