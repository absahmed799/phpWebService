<?php

class Requete 
{
    public $url_elements;
    public $ressource;
    public $verbe;
    public $parametres;
	private $_db;
	
    public function __construct() {
        $this->_db = MonSQL::getInstance();
        
		$this->verbe = $_SERVER['REQUEST_METHOD'];
		
        $_GET['url'] = (isset($_GET['url']) ? $_GET['url'] : "");
		$_GET['url'] = trim($_GET['url'], '\/');
        $this->url_elements = explode('/', $_GET['url']);
        $this->traitementParametre();
        
        $this->ressource = $this->url_elements[0];
        array_splice($this->url_elements,0,1);
	}

	/**
	 * Décode les paramètres de la requête
	 * @access private
	 */
	public function traitementParametre() {
        $parametres = array();

        // first of all, pull the GET vars
        if (isset($_SERVER['QUERY_STRING'])) {
            parse_str($_SERVER['QUERY_STRING'], $parametres);
        }

       	unset($parametres['url']);
        $body = file_get_contents("php://input");
		$content_type = false;
        if(isset($_SERVER['CONTENT_TYPE'])) {
            $content_type = $_SERVER['CONTENT_TYPE'];
        }
				
        $body_params = json_decode($body);
		
        if($body_params) {
            foreach($body_params as $nom => $valeur) {
				$parametres[$nom] = $this->aseptiserParametre($valeur);
            }
        }
        
        $this->parametres = $parametres;
	}
	
	/**
	 * Permet de nettoyer les valeurs passées en paramètre
	 * @param String $valeur Valeur à filtrer
	 * @return String La valeur filtrer.
	 * @access private
	 */
	private function aseptiserParametre($valeur)
	{
        if(is_string($valeur)){
            //$valeur = $this->_db->real_escape_string($valeur);
            $valeur = htmlspecialchars($valeur);
        }
		return $valeur;
	} 	
}
?>