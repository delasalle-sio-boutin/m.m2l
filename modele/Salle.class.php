<?php
// Projet Réservations M2L - version web mobile
// fichier : modele/Salle.class.php
// Rôle : la classe Salle représente les utilisateurs de l'application
// Création : 20/09/2016 par Killian BOUTIN
// Mise à jour : 20/09/2016 par Killian BOUTIN

class Salle
{
	// ------------------------------------------------------------------------------------------------------
	// ---------------------------------- Membres privés de la classe ---------------------------------------
	// ------------------------------------------------------------------------------------------------------

	private $id;				// identifiant de la salle (numéro automatique dans la BDD)
	private $room_name;			// nom de la salle
	private $capacity;			// capacité de la salle
	private $area_name;			// nom de la zone

	// ------------------------------------------------------------------------------------------------------
	// ----------------------------------------- Constructeur -----------------------------------------------
	// ------------------------------------------------------------------------------------------------------

	public function Salle($unId, $unRoomName, $unCapacity, $unAreaName) {
		$this->id = $unId;
		$this->room_name = $unRoomName;
		$this->capacity = $unCapacity;
		$this->area_name = $unAreaName;
	}

	// ------------------------------------------------------------------------------------------------------
	// ---------------------------------------- Getters et Setters ------------------------------------------
	// ------------------------------------------------------------------------------------------------------

	public function getId()	{return $this->id;}
	public function setId($unId) {$this->id = $unId;}

	public function getRoom_Name()	{return $this->room_name;}
	public function setRoom_Name($unRoomName) {$this->room_name = $unRoomName;}

	public function getCapacity()	{return $this->capacity;}
	public function setCapacity($unCapacity) {$this->capacity = $unCapacity;}

	public function getAreaName()	{return $this->area_name;}
	public function setAreaName($unAreaName) {$this->area_name = $unAreaName;}


	// ------------------------------------------------------------------------------------------------------
	// -------------------------------------- Méthodes d'instances ------------------------------------------
	// ------------------------------------------------------------------------------------------------------

	

	public function toString() {
		$msg = 'Utilisateur : <br>';
		$msg .= 'id : ' . $this->getId() . '<br>';
		$msg .= 'room_name : ' . $this->getRoom_Name() . '<br>';
		$msg .= 'capacity : ' . $this->getCapacity() . '<br>';
		$msg .= 'area_name : ' . $this->getAreaName() . '<br>';
		$msg .= '<br>';

		return $msg;
	}

} // fin de la classe Salle

// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces après la balise de fin de script !!!!!!!!!!!!