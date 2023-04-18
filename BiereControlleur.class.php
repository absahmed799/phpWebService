<?php
/**
 * Class BiereControleur
 * Controleur de la ressource Biere
 * 
 * @author Ahmed SAID
 * @version 1.1
 * @update 2023-04-17
 */

  
class BiereControlleur 
{
	private $retour = array('data'=>array());

	/**
	 * Méthode qui gère les action en GET
	 * @param Requete $requete
	 * @return Mixed Données retournées
	 */
	public function getAction(Requete $requete)
	{
		if(isset($requete->url_elements[0]) && is_numeric($requete->url_elements[0]))	// Normalement l'id de la biere 
		{
			$id_biere = (int)$requete->url_elements[0];
			
			if(isset($requete->url_elements[1])) 
			{
				switch($requete->url_elements[1]) 
				{
					case 'commentaire':
						$this->retour["data"] = $this->getCommentaire($id_biere);
						break;
					case 'note':
						$this->retour["data"] = $this->getNote($id_biere);
						break;
					default:
						$this->retour['erreur'] = $this->erreur(400);
						unset($this->retour['data']);
						break;
				}
			} 
			else // Retourne les infos d'une bière
			{
				$this->retour["data"] = $this->getBiere($id_biere);
			}
		} 
		else 
		{
			$this->retour["data"] = $this->getListeBiere();
			
		}

        return $this->retour;		
		
	}
	
	/**
	 * Méthode qui gère les action en POST
	 * @param Requete $requete
	 * @return Mixed Données retournées
	 */
	public function postAction(Requete $requete)	// Modification
	{
		if(!$this->valideAuthentification())
		{
			$this->retour['erreur'] = $this->erreur(401);
		}
		else {
			if(isset($requete->url_elements[0]) && is_numeric($requete->url_elements[0]))	// Normalement l'id de la biere 
			{
				$id_biere = (int)$requete->url_elements[0];
				
				$this->retour["data"] = $this->modifBiere($id_biere, $requete->parametres);
				
			}
			else{
				$this->retour['erreur'] = $this->erreur(400);
				unset($this->retour['data']);
			}
		}
		
		
		return $this->retour;
	}
	
	/**
	 * Méthode qui gère les action en PUT
	 * @param Requete $requete
	 * @return Mixed Données retournées
	 */
	public function putAction(Requete $requete)		//ajout ou modification
	{
	
		if(!$this->valideAuthentification())
		{
			$this->retour['erreur'] = $this->erreur(401);
		}
		else{
			if(isset($requete->url_elements[0]) && is_numeric($requete->url_elements[0]))	// Normalement l'id de la biere 
			{
				$id_biere = (int)$requete->url_elements[0];
				
				if(isset($requete->url_elements[1])) 
				{
					switch($requete->url_elements[1]) 
					{
						case 'commentaire':
							$this->retour["data"] = $this->ajouterUnCommentaire($id_biere, $requete->parametres);
							break;
						case 'note':
							$this->retour["data"] = $this->ajouterUneNote($id_biere, $requete->parametres);
							break;
						default:
							$this->retour['erreur'] = $this->erreur(400);
							unset($this->retour['data']);
							break;
					}
				} 
				else // Retourne les infos d'une bière
				{
					$this->retour['erreur'] = $this->erreur(400);
					unset($this->retour['data']);
				}
			} 
			else 
			{
				$this->retour["data"] = $this->ajouterUneBiere($requete->parametres);
				
			}
		}
		return $this->retour;
	}
	
	/**
	 * Méthode qui gère les action en DELETE
	 * @param Requete $oReq
	 * @return Mixed Données retournées
	 */
	public function deleteAction(Requete $requete)
	{
		if(!$this->valideAuthentification())
		{
			$this->retour['erreur'] = $this->erreur(401);
		}
		else{
			if(isset($requete->url_elements[0]) && is_numeric($requete->url_elements[0]))	// Normalement l'id de la biere 
			{
				$id_biere = (int)$requete->url_elements[0];
				
				$this->retour["data"] = $this->effacerBiere($id_biere);
				
			}
			else{
				$this->retour['erreur'] = $this->erreur(400);
				unset($this->retour['data']);
			}
		}
		

		return $this->retour;
		
	}
	
	
	
	/**
	 * Retourne les informations de la bière $id_biere
	 * @param int $id_biere Identifiant de la bière
	 * @return Array Les informations de la bière
	 * @access private
	 */	
	private function getBiere($id_biere)
	{
		$res = Array();

		$oBiere = new Biere();
		$res = $oBiere->getBiere($id_biere);
		return $res; 
	}
	
	/**
	 * Retourne les informations des bières de la db	 
	 * @return Array Les informations sur toutes les bières
	 * @access private
	 */	
	private function getListeBiere()
	{
		$res = Array();
		$oBiere = new Biere();
		$res = $oBiere->getListe();
		
		return $res; 
	}
	
	/**
	 * Retourne les commentaires de la bière $id_biere
	 * @param int $id_biere Identifiant de la bière
	 * @return Array Les commentaires de la bière
	 * @access private
	 */	
	private function getCommentaire($id_biere)
	{
		$res = Array();
		$oCommentaire = new Commentaire();
		$res = $oCommentaire->getListe($id_biere);
		$oUsager = new Usager();
		foreach($res as $cle => $valeur){
			$aUsager = $oUsager->getUsagerParId($valeur["id_usager"]);	
			$res[$cle]['courriel'] = $aUsager['courriel'];
			unset($res[$cle]["id_usager"]);
		}
		
		
		return $res; 
	}

	/**
	 * Retourne la note moyenne et le nombre de note de la bière $id_biere
	 * @param int $id_biere Identifiant de la bière
	 * @return Array La note de la bière
	 * @access private
	 */	
	private function getNote($id_biere)
	{
		
		$res = Array();
		$oNote = new Note();
		$res['nombre'] = $oNote->getNombre($id_biere);
		$res['note'] = $oNote->getMoyenne($id_biere);
		$res['id_biere'] = $id_biere;
		return $res; 
	}
	

	/**
	 * Modifie les informations de la bière $id_biere
	 * @param int $id_biere Identifiant de la bière
	 * @param Array Les informations de la bière
	 * @return int $id_biere Identifiant de la bière modifier
	 * @access private
	 */	
	private function modifBiere($id_biere, $data)
	{
		$res = Array();
		$oBiere = new Biere();
		
		$res = $oBiere->modifierBiere($id_biere, $data);
		return $res; 
	}
	
	/**
	 * Effacer la bière $id_biere
	 * @param int $id_biere Identifiant de la bière
	 * @return boolean Succès ou échec
	 * @access private
	 */	
	private function effacerBiere($id_biere)
	{
		$res = Array();
		$oBiere = new Biere();
		
		$res = $oBiere->effacerBiere($id_biere);
		return $res; 
	}

	/**
	 * Ajouter une bière 
	 * @param Array Les informations de la bière
	 * @return int $id_biere Identifiant de la nouvelle bière
	 * @access private
	 */	
	private function ajouterUneBiere($data)
	{
		$res = Array();
		$oBiere = new Biere();
		$res = $oBiere->ajouterBiere($data);
		return $res; 
	}

	/**
	 * Ajouter une bière 
	 * @param int $id_biere Identifiant de la bière
	 * @param Array Les informations sur la note
	 * @return int $id_biere Identifiant de la nouvelle bière
	 * @access private
	 */	
	private function ajouterUneNote($id_biere, $data)
	{
		$res = Array();

		if(isset($data['courriel']))
		{
			$oUsager = new Usager();
			$usager = $oUsager->getUsagerParCourriel($data['courriel']);
			if(!isset($usager))
			{
				$id_usager = $oUsager->ajouterUsager($data['courriel']);
			}
			else{
				$id_usager = (int)$usager['id_usager'];
			}

			$oNote = new Note();
			$res = $oNote->ajouterNote($id_usager, $id_biere, $data["note"]);
		}

		
		
		return $res; 
	}


	/**
	 * Ajouter une bière 
	 * @param int $id_biere Identifiant de la bière
	 * @param Array Les informations du commentaire
	 * @return int $id_biere Identifiant de la nouvelle bière
	 * @access private
	 */	
	private function ajouterUnCommentaire($id_biere, $data)
	{
		$res = Array();

		if(isset($data['courriel']))
		{
			$oUsager = new Usager();
			$usager = $oUsager->getUsagerParCourriel($data['courriel']);
			if(!isset($usager))
			{
				$id_usager = $oUsager->ajouterUsager($data['courriel']);
			}
			else{
				$id_usager = (int)$usager['id_usager'];
			}

			$oCommentaire = new Commentaire();
			$res = $oCommentaire->ajouterCommentaire($id_usager, $id_biere, $data["commentaire"]);
		}
		return $res; 
	}


	/**
	 * Valide les données d'authentification du service web
	 * @return Boolean Si l'authentification est valide ou non
	 * @access private
	 */	
	private function valideAuthentification()
    {
      	$access = false;
		$headers = apache_request_headers();
		
		if(isset($headers['Authorization']) || isset($headers['authorization']))	//Fetch avec Chrome envoie authorization et non Authorization ! 
		{
			if(isset($_SERVER['PHP_AUTH_PW']) && isset($_SERVER['PHP_AUTH_USER']))
			{
				if($_SERVER['PHP_AUTH_PW'] == 'biero' && $_SERVER['PHP_AUTH_USER'] == 'biero')
				{
					$access = true;
				}
			}
		}
      	return $access;
    }

	
	private function erreur($code, $data="")
	{
		//header('HTTP/1.1 400 Bad Request');
		http_response_code($code);

		return array("message"=>"Erreur de requete", "code"=>$code);
		
	}

}
