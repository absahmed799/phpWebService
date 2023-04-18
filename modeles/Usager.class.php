<?php

class Usager extends Modele {	
	
		
	/**
	 * Retourne la liste des usager
	 * @access public
	 * @return Array
	 */
	public function getListe() 
	{
		$res = Array();
		if($mrResultat = $this->_db->query("select * from usager"))
		{
			$res = $mrResultat->fetch_all(MYSQLI_ASSOC);
		}
		return $res;
	}
	
	/**
	 * Ajoute un usager
	 * @access public
	 * @param String $courriel Courriel de l'usager
	 * @return int Identifiant de l'usager
	 */
	public function ajouterUsager($courriel) 
	{
		$id_usager = 0;
		$usager = $this->getUsagerParCourriel($courriel);

		if(!$usager)
		{
			$stmt = $this->_db->prepare("INSERT INTO usager (courriel) VALUES (?)");
            $stmt->bind_param("s", $courriel);
            $stmt->execute();
            $id_usager = ($stmt->insert_id ? $stmt->insert_id : 0);
		}
		else {
			$id_usager = $usager['id_usager']; 
		}
		
		return $id_usager;
	}
	
	
	
	/**
	 * Récupère un usager par id
	 * @access public
	 * @param int $id Identifiant de l'usager
	 * @return Array
	 */
	public function getUsagerParId($id) 
	{
		$usager = Array();
		$stmt = $this->_db->prepare("select * from usager where id_usager= ?");
        $stmt->bind_param("i", $id);
        if($stmt->execute())
        {
            if($mrResultat = $stmt->get_result())
            {
                $usager = $mrResultat->fetch_assoc();
            }
        }
        
		return $usager;
	}
	
	/**
	 * Récupère un usager par Courriel
	 * @access public
	 * @param String $courriel Courriel de l'usager
	 * @return Array
	 */
	public function getUsagerParCourriel($courriel) 
	{
		$usager = Array();
		$stmt = $this->_db->prepare("select * from usager where courriel= ?");
        $stmt->bind_param("s", $courriel);
        if($stmt->execute())
        {
            if($mrResultat = $stmt->get_result())
            {
                $usager = $mrResultat->fetch_assoc();
            }
        }

		return $usager;
	}
	
	
}
