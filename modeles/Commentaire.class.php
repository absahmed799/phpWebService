<?php

class Commentaire extends Modele {	
	
		
	/**
	 * Retourne les commentaires sur une biere
	 * @access public
	 * @param int $id_biere Identifiant de la bière
	 * @return Array
	 */
	public function getListe($id_biere) 
	{
        $res = Array();
        $stmt = $this->_db->prepare("select * from commentaire where id_biere= ?");
        $stmt->bind_param("i", $id_biere);
        if($stmt->execute())
        {
            $mrResultat = $stmt->get_result();
            $res = $mrResultat->fetch_all(MYSQLI_ASSOC);
        }
        return $res;
	}
	
	/**
	 * Ajoute un commentaire sur une biere
	 * @access public
	 * @param int $id_usager Identifiant de l'usager 
	 * @param int $id_biere Identifiant de la bière
	 * @param String $commentaire Le commentaire
	 * @return int Identifiant du commentaire 
	 */
	public function ajouterCommentaire($id_usager, $id_biere, $commentaire) 
	{
		$res = false;

        $stmt = $this->_db->prepare("INSERT INTO commentaire (commentaire, id_biere, id_usager ) VALUES (?,?,?)");
        $stmt->bind_param("sii", $commentaire, $id_biere, $id_usager);
        $stmt->execute();
        if($stmt->insert_id){
            $res = true;
        }
				
		return ( $res ? $stmt->insert_id : 0);
		
	}
	
}


