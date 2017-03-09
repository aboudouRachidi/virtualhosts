<?php
class AuthHelper{
	
	/**
	 * Retourne vrai si l'utilisateur est authentifié
	 * @return boolean
	 */
	public static function isAuth(){
	
		if (isset($_SESSION['auth'])) return true;
		return false;
	}
	
	
	/**
	 * Retourne l'utilisateur actuellement connecté
	 * ou NULL si personne ne l'est
	 * @return User
	 */
	public static function getUser(){
		
		return $_SESSION['auth'];
	}
	
	public static function isAdmin(){
	
		if(AuthHelper::getUser()->getIdrole() == 1) return true;
		
		return false;
	}
}