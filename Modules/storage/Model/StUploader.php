<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Unit model
 *
 * @author Sylvain Prigent
 */
class StUploader extends Model {

	
public function createTable(){
			
		$sql = "CREATE TABLE IF NOT EXISTS `st_ftp` (
		`id` int(1) NOT NULL AUTO_INCREMENT,
		`host` varchar(150) NOT NULL DEFAULT '',
		`port` int(11) NOT NULL,
		`login` varchar(30) NOT NULL DEFAULT '',
		`pwd` varchar(30) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
		);";
		
		$pdo = $this->runRequest($sql);
		
		$sql = "insert into st_ftp(id, host, port, login, pwd)"
				. " values(?, ?, ?, ?, ?)";
		$user = $this->runRequest($sql, array(1, "", "", "", ""));
	}
	
	public function getFtpSettings(){
		
		try{
			$sql = "select * from st_ftp where id=1";
			$req = $this->runRequest($sql);
			if ($req->rowCount() == 1){
				$tmp = $req->fetch();
				return $tmp;  // get the first line of the result
			}
			else{
				throw new Exception("Cannot find the ftp settings");
			}
		}
		catch(Exception $e){
			$ftp = array();
			$ftp["host"] = "";
			$ftp["port"] = 21;
			$ftp["login"] = "";
			$ftp["pwd"] = "";
			return $ftp;
		}
	}
	
	public function setFtpSettings($host, $port, $login, $pwd){
		$sql = "update st_ftp set host=?, port=?, login=?, pwd=? where id=1";
		$unit = $this->runRequest($sql, array($host, $port, $login, $pwd));
	}
	
	public function getFtpLogin(){
		$sql = "select login from st_ftp where id=1";
		$req = $this->runRequest($sql);
		if ($req->rowCount() == 1){
			$tmp = $req->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			throw new Exception("Cannot find the ftp settings");
		}
		
		//return "mric";
	}
	
	public function getFtpPwd(){
		$sql = "select pwd from st_ftp where id=1";
		$req = $this->runRequest($sql);
		if ($req->rowCount() == 1){
			$tmp = $req->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			throw new Exception("Cannot find the ftp settings");
		}
		//return "*mric*";
	}
	
	public function getHost(){
		$sql = "select host from st_ftp where id=1";
		$req = $this->runRequest($sql);
		if ($req->rowCount() == 1){
			$tmp = $req->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			throw new Exception("Cannot find the ftp settings");
		}
		//return "localhost";
	}
	
	public function getPort(){
		$sql = "select port from st_ftp where id=1";
		$req = $this->runRequest($sql);
		if ($req->rowCount() == 1){
			$tmp = $req->fetch();
			return $tmp[0];  // get the first line of the result
		}
		else{
			throw new Exception("Cannot find the ftp settings");
		}
		//return 21;
	}

	
	/**
	 * get directory files
	 * 
	 * @param string $dir directory to explore
	 * @return multitype: array
	 */
	public function getFiles($dir){
		
		$ftp = ftp_connect($this->getHost(), $this->getPort());
		ftp_login($ftp, $this->getFtpLogin(), $this->getFtpPwd());
		
		//echo "connected <br/>";
		
		$filesdir = ftp_nlist($ftp, "./".$dir);
		
		$files = array();
		$i = 0;
		foreach($filesdir as $file){
			if ($file != "." && $file != ".."){
				$files[$i]["name"] = $file;
				$files[$i]["size"] = $this->formatFileSize(ftp_size($ftp, $file));
				$i++;
			}
		}
		
		return $files;
		
		foreach($liste_fichiers as $fichier)
		{
			echo '<a href="?filename=' .$fichier. '">' .$fichier. '</a><br/>';
		}
		
		ftp_close($ftp);
	}
	
	public function getUsage($userlogin){
		
		$ftp = ftp_connect($this->getHost(), $this->getPort());
		ftp_login($ftp, $this->getFtpLogin(), $this->getFtpPwd());
		
		$filesdir = ftp_nlist($ftp, "./".$userlogin);
		
		$files = array();
		$usage = 0;
		foreach($filesdir as $file){
			if ($file != "." && $file != ".."){
				$usage += ftp_size($ftp, $file);
			}
		}
		return $usage;
		
	}
	
	public function downloadFile($localURL, $file){
		
		
		//echo "download file = " . $file . "<br/>";
		$ftp = ftp_connect($this->getHost(), $this->getPort());
		ftp_login($ftp, $this->getFtpLogin(), $this->getFtpPwd());
		//ob_start();
		$result = ftp_get($ftp, $localURL, $file, FTP_BINARY);
		//$data = ob_get_contents();
		//ob_end_clean();
		ftp_close($ftp);
		//echo "download file = " . $file . " done <br/>";
	}
	
	public function uploadFile($file, $adressServer){
	
		
		$ftp = ftp_connect($this->getHost(), $this->getPort());
		ftp_login($ftp, $this->getFtpLogin(), $this->getFtpPwd());
		
		ftp_put($ftp, $adressServer, $file, FTP_BINARY);
		
		ftp_close($ftp);
		
	}
	
	public function formatFileSize($size){
		if ($size < 1000){
			return number_format($size, 2, ',', '') . " octets";
		}
		else if ($size >= 1000 && $size < 1000000 ){
			return number_format($size/1000, 2, ',', '') . " Ko";
		}
		else if ($size >= 1000000 && $size < 1000000000 ){
			return number_format($size/1000000, 2, ',', '') . " Mo";
		}
		else if ($size >= 1000000000 && $size < 1000000000000 ){
			return number_format($size/1000000000, 2, ',', '') . " Go";
		}
	}
	
	public function deleteFile($file){

		$ftp = ftp_connect($this->getHost(), $this->getPort());
		ftp_login($ftp, $this->getFtpLogin(), $this->getFtpPwd());
		
		ftp_delete ( $ftp , $file );
		
		ftp_close($ftp);
	}

	public function initializeDirectory($userlogin){
		
		$ftp = ftp_connect($this->getHost(), $this->getPort());
		ftp_login($ftp, $this->getFtpLogin(), $this->getFtpPwd());
		
		if (!ftp_chdir($ftp, $userlogin)){
			ftp_mkdir($ftp, $userlogin);
		}

	}
}

