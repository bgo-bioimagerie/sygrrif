<?php
require_once 'Framework/Model.php';
require_once 'Modules/biblio/Model/Author.php';
require_once 'Modules/biblio/Model/AuthorPubli.php';
require_once 'Modules/biblio/Model/Conference.php';
require_once 'Modules/biblio/Model/EntriesArticle.php';
require_once 'Modules/biblio/Model/EntriesBook.php';
require_once 'Modules/biblio/Model/EntriesConference.php';
require_once 'Modules/biblio/Model/EntriesInBook.php';
require_once 'Modules/biblio/Model/EntriesMisc.php';
require_once 'Modules/biblio/Model/Journal.php';
require_once 'Modules/biblio/Model/Publication.php';

/**
 * Class defining methods to install and initialize the sygrrif database
 *
 * @author Sylvain Prigent
 */
class BiblioInstall extends Model {
	
	/**
	 * Create the biblio database
	 *
	 */
	public function createDatabase() {
		$authorModel = new Author ();
		$authorModel->createTable ();
		
		$model = new AuthorPubli ();
		$model->createTable ();
		
		$model = new Conference ();
		$model->createTable ();
		
		$model = new EntriesArticle ();
		$model->createTable ();
		
		$model = new EntriesBook ();
		$model->createTable ();
		
		$model = new EntriesConference ();
		$model->createTable ();
		
		$model = new EntriesInBook ();
		$model->createTable ();
		
		$model = new EntriesMisc ();
		$model->createTable ();
		
		$model = new Journal ();
		$model->createTable ();
		
		$model = new Publication ();
		$model->createTable ();
	}
}

?>