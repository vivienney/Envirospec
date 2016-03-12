<?php


class SiteConfigExtension extends DataExtension {

	private static $allowed_actions = array (
 		'sendOneOffEmail'
 	);

 	private static $has_one = array(
		'Page1' => 'SiteTree',
		'Page2' => 'SiteTree',
		'Page3' => 'SiteTree',
		'Page4' => 'SiteTree'
	);


	private static $db = array(
		'ESSummary' => 'Text',
		'ContactAddress' => 'Text',
		'ContactEmail' => 'Varchar',
		'ContactFormEmail' => 'Varchar',
		'ContactPhone' => 'Varchar',
		'MonthReminderDate' => 'Date',
		'MonthReminderText' => 'HTMLText',
		'WeekReminderDate' => 'Date',
		'WeekReminderText' => 'HTMLText',
		'FinalReminderDate' => 'Date',
		'FinalReminderText' => 'HTMLText'
	);

	public function updateCMSFields(Fieldlist $fields){

		// ============================================================ 
		// Main
		// ============================================================ 
		$fields->addFieldsToTab('Root.Main', array(
			TextAreaField::create('ESSummary', 'Envirospec Summary'),
			TextAreaField::create('ContactAddress', 'Contact Address'),
			TextField::create('ContactEmail', 'Contact Email'),
			TextField::create('ContactFormEmail', 'Contact Form Email'),
			TextField::create('ContactPhone', 'Contact Phone')
		));


		// ============================================================ 
		// Emails
		// ============================================================ 
		$fields->addFieldsToTab('Root.Emails', array(
			LabelField::create('Label1', 'Automated Reminder Emails')->addExtraClass('customBold'),
			LabelField::create('Label2', 'Will be sent to all product suppliers to inform them that they need to review and sign off theit products.'),
			ToggleCompositeField::create('Month', 'One Month Reminder Email', array (

				DateField::create('MonthReminderDate', 'Date')->setConfig('showcalendar', true),
				HTMLEditorField::create('MonthReminderText', 'Email Message')
			))->setStartClosed(true),
			ToggleCompositeField::create('Week', 'Two Week Reminder Email', array (

				DateField::create('WeekReminderDate', 'Date')->setConfig('showcalendar', true),
				HTMLEditorField::create('WeekReminderText', 'Email Message')
			)),
			ToggleCompositeField::create('Final', 'Final Reminder Email', array (

				DateField::create('FinalReminderDate', 'Date')->setConfig('showcalendar', true),
				HTMLEditorField::create('FinalReminderText', 'Email Message')
			))
		));


		// ============================================================ 
		// Footer
		// ============================================================ 
		$fields->addFieldsToTab('Root.Footer', array(
			TreeDropdownField::create('Page1ID', 'Useful Page 1', 'SiteTree'),
			TreeDropdownField::create('Page2ID', 'Useful Page 2', 'SiteTree'),
			TreeDropdownField::create('Page3ID', 'Useful Page 3', 'SiteTree'),
			TreeDropdownField::create('Page4ID', 'Useful Page 4', 'SiteTree')
		));
	}


	// ========================================
 	// Send One Month Reminder
 	// ========================================
 	public function sendMonthReminder(){
 		$email = new Email();
 		$email
 		    ->setFrom('"Envirospec One Month Reminder" <envirospec@mail.co.nz>')
 		    ->setTo($this->SiteConfig()->ContactFormEmail)
 		    ->setSubject('Envirospec One Month Reminder')
 		    ->setTemplate('MonthReminder')
 		    ->populateTemplate(new ArrayData(array(
 		        'Name' => 'Bob Jones'
 		)));


 		$this->MonthReminderDate;
	
 		$email->send();
 
 		return 'Success';
 	}
}


