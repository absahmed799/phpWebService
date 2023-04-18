<?php

class Note extends Modele {	
	
		
	/**
	 * Retourne la note moyenne d'une biere
	 * @access public
	 * @param int $id_biere Identifiant de la bière
	 * @return float note
	 */
	public function getMoyenne($id_biere) 
	{
        $note = 0;
		$stmt = $this->_db->prepare("select id_biere, AVG(IFNULL(note, 0)) as moyenne from note where id_biere=?");
        $stmt->bind_param("i", $id_biere);
        
        if($stmt->execute())
        {
            $mrResultat = $stmt->get_result();
            $res = $mrResultat->fetch_assoc();
            $note = ($res['moyenne'] != null ?$res['moyenne'] : 0) ;
        }
		
		return $note;
	}
	
	
	/**
	 * Retourne le nombre de note d'une biere
	 * @access public
	 * @param int $id_biere Identifiant de la bière
	 * @return int
	 */
	public function getNombre($id_biere) 
	{
        $nombre = 0;
		$stmt = $this->_db->prepare("select id_biere, count(*) as nombre from note where id_biere=?");
        $stmt->bind_param("i", $id_biere);
        
        if($stmt->execute())
        {
            $mrResultat = $stmt->get_result();
            $res = $mrResultat->fetch_assoc();
            $nombre = ($res['nombre'] != null ?$res['nombre'] : 0) ;
        }
		
		return $nombre;
	}
	
	/**
	 * Ajoute une note sur une biere ou modifie la note si elle existe déjà
	 * @access public
	 * @param int $id_usager Identifiant de l'usager
	 * @param int $id_biere Identifiant de la bière
	 * @param int $note La note 
	 * @return Array
	 */
	public function ajouterNote($id_usager, $id_biere, $note) 
	{
		$id_note = 0;
		$ancienneNote = $this->getNoteParUsagerEtBiere($id_biere, $id_usager);
		if($ancienneNote)
		{
            $stmt = $this->_db->prepare("UPDATE note SET note=? where id_biere=? AND id_usager = ?");
		}
		else
		{
            $stmt = $this->_db->prepare("INSERT INTO note (note, id_biere, id_usager ) VALUES (?,?,?)");
		}
		
        $stmt->bind_param("dii", $note, $id_biere, $id_usager);
        
        if($stmt->execute())
        {
            if($ancienneNote)
            {
                $id_note = $ancienneNote['id_note'];
            }
            else
            {
                $id_note = ($stmt->insert_id ? $stmt->insert_id : 0);
            }
        }
        return $id_note;
	}
	
	/**
	 * Retourne la note attribuée par un usager sur une biere
	 * @access public
     * @param int $id_biere Identifiant de la bière
	 * @param int $id_usager Identifiant de l'usager
	 * @return int La note existante ou 0
	 */
	public function getNoteParUsagerEtBiere($id_biere, $id_usager) 
	{
		$note = Array();
		$stmt = $this->_db->prepare("select * from note where id_biere=? AND id_usager =?");
        $stmt->bind_param("ii", $id_biere, $id_usager);
        
        if($stmt->execute())
        {
            $mrResultat = $stmt->get_result();
            $note = $mrResultat->fetch_assoc();
        }
        
		return $note;
	}
	
}

