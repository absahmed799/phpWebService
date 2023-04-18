<?php

class Biere extends Modele {	
	
		
	/**
	 * Retourne la liste des bieres
	 * @access public
	 * @return Array
	 */
	public function getListe() 
	{
		$res = Array();
		$query = "select  t1.id_biere,  description, nom, brasserie, image, date_ajout, date_modif, AVG(IFNULL(note, 0)) as note_moyenne, count(id_note) as note_nombre from biere t1 
left join note t2 ON t1.id_biere = t2.id_biere GROUP by t1.id_biere";
		if($mrResultat = $this->_db->query($query))
		{
			$res = $mrResultat->fetch_all(MYSQLI_ASSOC);
		}
		return $res;
	}
	
	/**
	 * Ajoute une biere
	 * @param Array $data Les données d'une bière 
	 * @access public
	 * @return int id de la biere
	 */
	public function ajouterBiere($data) 
	{	
		$res = false;
        if(extract($data) > 0)
		{
			//$image = $image || "";	
            $stmt = $this->_db->prepare("INSERT INTO biere (nom, brasserie, description, image,actif) VALUES (?,?,?,?,1)");
            $stmt->bind_param("ssss", $nom, $brasserie, $description, $image);
            $stmt->execute();
            if($stmt->insert_id)
            {
                $res = true;
            }
			
		}
				
		return ( $res ? $stmt->insert_id : 0);
	}
	
	/**
	 * Effacer une biere
	 * @access public
	 * @param Array $id_biere Identifiant de la bière  
	 * @return Boolean
	 */
	public function effacerBiere($id_biere) 
	{
		$res = false;
        $stmt = $this->_db->prepare("DELETE from biere where id_biere = ?");
        $stmt->bind_param("i", $id_biere);
        $stmt->execute();
        if($stmt->affected_rows == 1)
        {
            $res = true;
        }

        return $res;
	}
	
	/**
	 * Récupère  une biere
	 * @access public
	 * @param int $id Identifiant de la bière
	 * @return Array
	 */
	public function getBiere($id_biere) 
	{
		$res = Array();
		$stmt = $this->_db->prepare("select * from biere where id_biere= ?");
        $stmt->bind_param("i", $id_biere);
        if($stmt->execute())
        {
            if($mrResultat = $stmt->get_result())
            {
                $res = $mrResultat->fetch_assoc();
            }
        }
		
		return $res;
	}
	
	/**
	 * Modifier une biere
	 * @access public
	 * @param int $id Identifiant de la bière
	 * @param Array $param Paramètres et valeur à modifier 
	 * @return int id de la bière ou 0 en cas d'échec
     * @see https://phpdelusions.net/pdo_examples/dynamical_update
	 */
	public function modifierBiere($id, $param)	
	{
		$permis = ["nom","brasserie","description", "image"];
        $chaineBind = "";
        $aSet = Array();
        $aValeur = Array();
		$res = false;
		foreach ($param as $cle => $valeur) 
        {   
            if(in_array($cle, $permis))         // Si la clé est permise
            {        
                $aSet[] = ($cle . "= ?");
                $aValeur[] = $valeur;
                $chaineBind .= "s";

            }
		}
		if(count($aSet) > 0)
		{
			$chaineBind .= "i";
            $aValeur[] = $id;

            $query = "Update biere SET ";
			$query .= join(", ", $aSet);
			$query .= (", date_modif = now() WHERE id_biere = ?"); 
            //echo $query;
            $stmt = $this->_db->prepare($query);
            $stmt->bind_param($chaineBind, ...$aValeur);
            
            $stmt->execute();
            
            if($stmt->affected_rows == 1){
                $res = true;
            }
      	}
		//echo $query;
		return ($res ? $id : false);
	}
}


