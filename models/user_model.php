<?php


class User_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function userList()
	{
		$sth = $this->db->prepare('Select ID, TITLE, FIRSTNAME, LASTNAME, EMAIL, ROLE from T_TUTOR');
                $sth->execute();
                return $sth->fetchAll();
		
	}
	
        public function create($data){
                $sth = $this->db->prepare('INSERT INTO T_TUTOR(`TITLE`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `PASSWORD`, `ROLE`, `FK_STATE`, `FK_DEPARTMENT`, `FK_ROLE`)VALUES (:TITLE, :FIRSTNAME, :LASTNAME, :EMAIL, :PASSWORD, :ROLE, :FK_STATE, :FK_DEPARTMENT, :FK_ROLE)');
                $sth->execute(array(
        ':TITLE' => $data['TITLE'],
        ':FIRSTNAME' =>  $data['FIRSTNAME'],
        ':LASTNAME' => $data['LASTNAME'],
        ':EMAIL' =>  $data['EMAIL'],
        ':PASSWORD' =>  $data['PASSWORD'],
        ':ROLE!' =>  $data['ROLE'],
        ':FK_STATE' =>   $data['FK_STATE'],
        ':FK_DEPARTMENT' =>  $data['FK_DEPARTMENT'],
        ':FK_ROLE' =>  $data['FK_ROLE']
                ));
        }
}
        