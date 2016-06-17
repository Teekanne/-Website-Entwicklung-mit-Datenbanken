<?php

class Dashboard_Model extends Model {

	function __construct() {
		parent::__construct();
	}
	
	function xhrInsert() 
	{
		$text = $_POST['text'];
		//$Sth=statement
		$sth = $this->db->prepare('INSERT INTO Test (text) VALUES (:text)');
		$sth->execute(array(':text' => $text));
		
		$data = array('text' => $text, 'id' => $this->db->lastInsertId());
		echo json_encode($data);
	}
	
	function xhrGetListings()
	{
		$sth = $this->db->prepare('SELECT * FROM Test');
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		$sth->execute();
		$data = $sth->fetchAll();
		echo json_encode($data);
	}
	
	function xhrDeleteListing()
	{
		$id = $_POST['id'];
		$sth = $this->db->prepare('DELETE FROM Test WHERE id = "'.$id.'"');
		$sth->execute();
	}

}