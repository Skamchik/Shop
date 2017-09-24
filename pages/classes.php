<?php 
	class ManagerDb{
		private $host;
		private $user;
		private $pass;
		private $dbname;

		function __construct($host, $user, $pass, $dbname){
			$this->host=$host;
			$this->user=$user;
			$this->pass=$pass;
			$this->dbname=$dbname;
		}
		function connect(){
			$dsn='mysql:host='.$this->host.';dbname='.$this->dbname.';charset=utf8;';
			$options=array(
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
					PDO::MYSQL_ATTR_INIT_COMMAND=>'set names utf8'

				); 
			$pdo=new PDO($dsn, $this->user, $this->pass, $options);
			return $pdo;
		}

		function Show(){
			echo "host:".$this->host." user:".$this->user." pass:".$this->pass." dbname:".$this->dbname."<br/>";
		}

	}

	class User{
		private $id, $login, $pass, $roleid, $discount, $total, $imagepath;
		function __construct($login, $pass, $imagepath='images/anonym.jpg', $id=0){
			$this->login=$login;
			$this->pass=$pass;
			$this->imagepath=$imagepath;
			$this->id=$id;
			$this->discount=0;
			$this->total=0;
			$this->roleid=1;
		}
		//этот метод будет заносить таблицу в базу данных
		function intoDb(){
			$db=new ManagerDb('localhost','root','654321','10474');
			$pdo=$db->connect();
			$ins='insert into Users (login,pass,imagepath,id,discount,total,roleid)values(?,?,?,?,?,?,?)';
			$ps=$pdo->prepare($ins);
			$ps->execute(array($this->login,$this->pass,$this->imagepath,$this->id,$this->discount,$this->total,$this->roleid));
		}
		static function fromDb($id){
			$db=new ManagerDb('localhost','root','654321','10474');
			$pdo=$db->connect();
			$sel='select * from Users where id = ?';
			$ps=$pdo->prepare($sel);
			$ps->execute(array($id));
			$row=$ps->fetch(PDO::FETCH_LAZY);
			$user=new User($row['login'],$row['pass'],$row['imagepath'],$row['id'],$row['discount'],$row['total'],$row['roleid']);
			return $user;
		}
	}
 ?>