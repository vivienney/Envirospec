<?php

class MailController extends Controller {

    public $config;
    public $systemEmail;
    public $CCEmail;


    /**
     * Sets up php mail object
     *
     * @return PHPMailer
     */
    public function setup() {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'caigertom@gmail.com';
        $mail->Password = 'quetza1!';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->From = 'admin@envirospec.com';
        $mail->FromName = "Envirospec Admin";

        $this->config = SiteConfig::current_site_config();
        $this->systemEmail = $this->config->SystemEmail;
        $this->CCEmail = $this->config->CCEmail;

        $mail->isHTML(true);

        return $mail;
    }


    /**
     * Sends main contact form email
     *
     * @param $data
     * @return bool
     */
    Public Function ContactFormEmail($data) {
        $mail = $this->setup();

        $mail->addAddress($this->systemEmail);
        $mail->addReplyTo($this->systemEmail);
        $mail->addCC($this->CCEmail);

        $mail->Subject = 'Envirospec Contact Form';

        $arraydata = new ArrayData(array(
            'Name'    => $data['Name'],
            'Email'   => $data['Email'],
            'Phone'   => $data['Phone'],
            'Message' => $data['Message']
        ));
        $body = $arraydata->renderWith('ContactFormEmail');

        $mail->MsgHTML($body);

        if ( ! $mail->send()) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * Sends enquiry to manufacturers and suppliers
     *
     * @param $data
     * @param $member
     * @return bool
     */
    Public Function ProductFormEmail($data, $member) {
        $mail = $this->setup();

        $mail->addAddress($member->Email);
        $mail->addReplyTo($this->systemEmail);
        $mail->addCC($this->CCEmail);

        $mail->Subject = 'Envirospec Product Enquiry';

        $arraydata = new ArrayData(array(
            'Name'    => $data['Name'],
            'Email'   => $data['Email'],
            'Message' => $data['Message']
        ));

        $body = $arraydata->renderWith('ProductFormEmail');

        $mail->MsgHTML($body);

        if ( ! $mail->send()) {
            return false;
        } else {
            return true;
        }
    }


    /**
     *  Sends Expiry System Emails
     *
     * @param $certificate
     * @param $member
     * @param $type
     * @return bool
     */
    public function ExpiryEmail($certificate, $member, $type) {

        $mail = $this->setup();

        $mail->addAddress($member->Email);
        $mail->addReplyTo($this->systemEmail);
        $mail->addCC($this->CCEmail);

        $mail->Subject = 'Envirospec Document Expiry System';

        if ($type == 'month warning') {
            $message = $this->config->WarningEmail;
        } else if ($type == 'expired') {
            $message = $this->config->FinalEmail;
        } else {
            $message = $this->config->ExpiryEmail;
        }

        $data = new ArrayData(array(
            'Certificate' => $certificate,
            'Member'      => $member,
            'Date'        => date("Y-m-d"),
            'Message'     => $message
        ));

        $body = $data->renderWith('ExpiryEmail');

        $mail->MsgHTML($body);

        if ( ! $mail->send()) {
            return false;
        } else {
            return true;
        }
    }


    /**
     *  Sends Certificate Upload Email
     *
     * @param $certificate
     * @param $member
     * @return bool
     */
    public function CertificateUploadEmail($certificate, $member) {

        $mail = $this->setup();

        $mail->addAddress($this->systemEmail);
        $mail->addReplyTo($this->systemEmail);
        $mail->addCC($this->CCEmail);

        $mail->Subject = 'Envirospec Certificate Upload';

        $arraydata = new ArrayData(array(
            'FirstName'   => $member->FirstName,
            'Certificate' => $certificate
        ));

        $body = $arraydata->renderWith('CertificateUpload');

        $mail->MsgHTML($body);

        if ( ! $mail->send()) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * Sends Declaration Email To All Members
     *
     * @param $member
     * @return bool
     */
    public function DeclarationEmails($member) {

        $mail = $this->setup();

        $mail->addAddress($member->Email);
        $mail->addReplyTo($this->systemEmail);
        $mail->addCC($this->CCEmail);

        $mail->Subject = 'Envirospec Declaration Email';

        $data = new ArrayData(array(
            'Member'  => $member,
            'Message' => $this->config->DeclarationEmail
        ));

        $body = $data->renderWith('DeclarationEmail');

        $mail->MsgHTML($body);

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

}