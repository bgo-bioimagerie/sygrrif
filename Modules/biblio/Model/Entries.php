<?php

require_once 'Framework/Model.php';

/**
 * Class defining the publication model
 *
 * @author Sylvain Prigent
 */
abstract class Entries extends Model {

	
	/**
	 * Create the publication table
	 *
	 * @return PDOStatement
	 */
	public abstract function createTable();	
	public abstract function defaultEntry();
	public abstract function getDescription($id_publi);
	public abstract function editEntry($pubicationInfos);
	

}