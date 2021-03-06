<?php


class SiteConfigExtension extends DataExtension {

    private static $db = array(
        'ESSummary'        => 'Text',
        'ContactAddress'   => 'Text',
        'ContactEmail'     => 'Varchar',
        'ContactPhone'     => 'Varchar',
        'SystemEmail'      => 'Varchar(200)',
        'CCEmail'          => 'Varchar(200)',
        'WarningEmail'     => 'HTMLText',
        'ExpiryEmail'      => 'HTMLText',
        'FinalEmail'       => 'HTMLText',
        'DeclarationEmail' => 'HTMLText',
        'DeclarationText'  => 'Text',
        'MembersIntro' => 'HTMLText',
    );

    private static $has_one = array(
        'Page1'                            => 'SiteTree',
        'Page2'                            => 'SiteTree',
        'Page3'                            => 'SiteTree',
        'Page4'                            => 'SiteTree',
        'GreenBuildingRatingCompatibility' => 'Image',
        'IndoorAirQualityCertification'    => 'Image',
        'EnergyEfficiencyRating'           => 'Image',
        'LifecycleBasedEcolabel'           => 'Image',
        'EnvironmentalManagementSystem'    => 'Image',
        'QualityManagementSystems'         => 'Image',
        'FullBuildingProductAppraisal'     => 'Image',
        'ProductTechnicalPerformance'      => 'Image',
        'CarbonOffset'                     => 'Image',
        'ResponsibleSourcing'              => 'Image'
    );

    public function updateCMSFields(Fieldlist $fields) {


        $fields->addFieldsToTab('Root.Main', array(

            // Envirospec Contact Info
            // ----------------------------------------
            HeaderField::create('InfoHeading', 'Envirospec Contact Information', '2'),
            TextAreaField::create('ESSummary', 'Envirospec Summary'),
            TextAreaField::create('ContactAddress', 'Contact Address'),
            TextField::create('ContactEmail', 'Contact Email'),
            TextField::create('ContactPhone', 'Contact Phone'),

            // Envirospec Admin Email Addresses
            // ----------------------------------------
            HeaderField::create('AdminEmailHeading', 'Admin Email Addresses', '2'),
            TextField::create('SystemEmail', 'System Email Address'),
            TextField::create('CCEmail', 'System Email CC Address (Optional)'),

            // Footer Links
            // ----------------------------------------
            HeaderField::create('FooterHeading', 'Footer Links', '2'),
            LabelField::create('FooterLabel', 'Links to these pages are displayed in the footer'),
            TreeDropdownField::create('Page1ID', 'Useful Page 1', 'SiteTree'),
            TreeDropdownField::create('Page2ID', 'Useful Page 2', 'SiteTree'),
            TreeDropdownField::create('Page3ID', 'Useful Page 3', 'SiteTree'),
            TreeDropdownField::create('Page4ID', 'Useful Page 4', 'SiteTree'),

            // Members Area
            // ----------------------------------------
            HeaderField::create('MembersHeading', 'Members Area', '2'),
            HtmlEditorField::create('MembersIntro', 'Members Area Intro Text'),
        ));

        // Footer Links
        // ----------------------------------------
        $fields->addFieldsToTab('Root.CertificateLogos', array(
            HeaderField::create('Logos', 'Certificate Logos', '2'),
            LabelField::create('LogoLabel', 'The logos that are displayed on certificates depending on type.'),
            $logo1 = UploadField::create('GreenBuildingRatingCompatibility'),
            $logo2 = UploadField::create('IndoorAirQualityCertification'),
            $logo3 = UploadField::create('EnergyEfficiencyRating'),
            $logo4 = UploadField::create('LifecycleBasedEcolabel'),
            $logo5 = UploadField::create('EnvironmentalManagementSystem'),
            $logo6 = UploadField::create('QualityManagementSystems'),
            $logo7 = UploadField::create('FullBuildingProductAppraisal'),
            $logo8 = UploadField::create('ProductTechnicalPerformance'),
            $logo9 = UploadField::create('CarbonOffset'),
            $logo10 = UploadField::create('ResponsibleSourcing')
        ));

        $fields->addFieldsToTab('Root.ExpirySystem', array(
            HTMLEditorField::create('WarningEmail', 'Warning Email Body'),
            HTMLEditorField::create('FinalEmail', 'Final Warning Email Body'),
            HTMLEditorField::create('ExpiryEmail', 'Expiry Email Body')
        ));

        $fields->addFieldsToTab('Root.Declarations', array(
            HTMLEditorField::create('DeclarationEmail', 'Declaration Email.')
                ->setDescription('This is the content for the email which gets sent to Manufacturers and Suppliers'),
            TextareaField::create('DeclarationText', 'Declaration Text.')
                ->setDescription('This is the text that goes into the Members Area above the checkbox'),
            HeaderField::create('DecHeader', 'Send Declaration Emails', 4),
            LiteralField::create('RunText','<p>Clicking the link below will run the declaration system which will: 1) Send an email to each Manufacturer and Supplier, and 2) Create a declaration record for each Manufacturer and Supplier.</p>'),
            LiteralField::create('RunLink','<a href="dev/tasks/DeclarationTask" target="_blank">Run Declaration System Now</a>'),
        ));

        $logo1->setFolderName('certificates');
        $logo2->setFolderName('certificates');
        $logo3->setFolderName('certificates');
        $logo4->setFolderName('certificates');
        $logo5->setFolderName('certificates');
        $logo6->setFolderName('certificates');
        $logo7->setFolderName('certificates');
        $logo8->setFolderName('certificates');
        $logo9->setFolderName('certificates');
        $logo10->setFolderName('certificates');

        return $fields;

    }


}


