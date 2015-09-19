<?php

require_once 'Framework/Model.php';
require_once 'Modules/sygrrif/Model/SyPricing.php';
require_once 'Modules/sygrrif/Model/SyUnitPricing.php';
require_once 'Modules/sygrrif/Model/SyResourceType.php';
require_once 'Modules/sygrrif/Model/SyResourcePricing.php';
require_once 'Modules/sygrrif/Model/SyVisa.php';
require_once 'Modules/sygrrif/Model/SyResource.php';
require_once 'Modules/sygrrif/Model/SyResourceCalendar.php';
require_once 'Modules/sygrrif/Model/SyAuthorization.php';
require_once 'Modules/sygrrif/Model/SyResourcesCategory.php';
require_once 'Modules/sygrrif/Model/SyArea.php';
require_once 'Modules/sygrrif/Model/SyCalendarEntry.php';
require_once 'Modules/sygrrif/Model/SyColorCode.php';
require_once 'Modules/sygrrif/Model/SyBookingSettings.php';
require_once 'Modules/sygrrif/Model/SyCalendarSeries.php';
require_once 'Modules/sygrrif/Model/SyBill.php';
require_once 'Modules/sygrrif/Model/SyCalSupplementary.php';
require_once 'Modules/sygrrif/Model/SyBookingTableCSS.php';

/**
 * Class defining methods to install and initialize the sygrrif database
 *
 * @author Sylvain Prigent
 */
class SyInstall extends Model {

	/**
	 * Create the sygrrif database
	 *
	 * @return boolean True if the base is created successfully
	 */
	public function createDatabase(){
		
		
		$pricingModel = new SyPricing();
		$pricingModel->createTable();
		
		$unitpricingModel = new SyUnitPricing();
		$unitpricingModel->createTable();
		
		$SyResourceModel = new SyResource();
		$SyResourceModel->createTable();
		
		$syResourceCalendar = new SyResourceCalendar();
		$syResourceCalendar->createTable();
		
		$syResourcesCategoryModel = new SyResourcesCategory();
		$syResourcesCategoryModel->createTable();
		
		$SyResourceTypeGRRModel = new SyResourceType();
		$SyResourceTypeGRRModel->createTable();
		$SyResourceTypeGRRModel->createDefaultTypes();
		
		$SyResourcePricingModel = new SyResourcePricing();
		$SyResourcePricingModel->createTable();
		
		$SyVisaModel = new SyVisa();
		$SyVisaModel->createTable();
		$SyVisaModel->createDefaultVisa();
		
		$SyAuthorization = new SyAuthorization();
		$SyAuthorization->createTable();
		
		$SyArea = new SyArea();
		$SyArea->createTable();
		
		$syCalendarEntry = new SyCalendarEntry();
		$syCalendarEntry->createTable();
		
		$syCalendarSeries = new SyCalendarSeries();
		$syCalendarSeries->createTable();
		
		$model = new SyCalSupplementary();
		$model->createTable();
		
		
		$syColorCode = new SyColorCode();
		$syColorCode->createTable();
		
		$syColorCode->createDefaultColorCode();
		
		$modelConfig = new CoreConfig();
		$modelConfig->setParam("sygrrif_installed", "yes");
		
		$modelBookingSettings = new SyBookingSettings();
		$modelBookingSettings->createTable();
		$modelBookingSettings->defaultEntries();
		
		$modelBill = new SyBill();
		$modelBill->createTable();
		
		$modelAreaCss = new SyBookingTableCSS();
		$modelAreaCss->createTable();
		
	}
}
	
?>