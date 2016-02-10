<?php

class Home extends Page{

	private static $db = array (
		'Subheading' => 'Varchar(100)'
	);

	
	private static $has_one = array (
		'Photo' => 'Image'
	);

	public function getCMSFields() {

		$fields = parent::getCMSFields();
		$fields->addFieldsToTab('Root.Main', array (
			TextField::create('Subheading')
		), 'Content');

		$fields->addFieldToTab('Root.Attachments', $photo = UploadField::create('Photo'));

		return $fields;
	}

}

class Home_Controller extends Page_Controller{


}