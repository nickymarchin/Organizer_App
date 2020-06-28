<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//load model
		$this->load->model('Email_model');
		$this->load->model('Test_model');
		$this->load->helper('url');
	}

	public function index()
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		redirect('list');
	}

	public function sendEmailToAll()
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		//sends email to all for testing the controller
		$subject = $this->input->post('email_subject', TRUE);
		$body = $this->input->post('content_email', TRUE);

		$mail = $this->config_email_sender();
		$emails = $this->Test_model->getAllEmails();

		try {

			$mail->setFrom('timeaway@itrservices.eu', $this->session->userdata('username'));

			foreach ($emails as $email) {
				$mail->addAddress($email['email']);
			}

			$mail->isHTML(true);
			$mail->Subject = $subject;

			$mail->Body = $body;

			$mail->send();

			$this->session->set_flashdata('emailsToAll', 'Emails sent to all users');

			foreach ($emails as $email) {

				$recipientId = $this->Email_model->getIdByEmail($email['email']);

				$data[] = array(
					'subject' => $subject,
					'content' => strip_tags($body),
					'sender_id' => $this->session->userdata('user_id'),
					'recipient_id' => $recipientId[0]['id']
				);
			}

			$this->Email_model->setBatchImport($data);
			$this->Email_model->importData();

			redirect('test/getUsersList');

		} catch (Exception $exception) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
	}

	public function send_emails_to_all($department_id)
	{

		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		//sends email to all for testing the controller
		$subject = $this->input->post('email_subject', TRUE);
		$body = $this->input->post('content_email', TRUE);

		$mail = $this->config_email_sender();
		$emails = $this->Test_model->get_all_emails($department_id);

		try {

			$mail->setFrom('timeaway@itrservices.eu', $this->session->userdata('username'));

			foreach ($emails as $email) {
				$mail->addAddress($email['email']);
			}

			$mail->isHTML(true);
			$mail->Subject = $subject;

			$mail->Body = $body;

			$mail->send();

			$this->session->set_flashdata('emailsToAllDepartment', 'Emails sent to all from department');

			foreach ($emails as $email) {

				$recipientId = $this->Email_model->getIdByEmail($email['email']);

				$data[] = array(
					'subject' => $subject,
					'content' => strip_tags($body),
					'sender_id' => $this->session->userdata('user_id'),
					'recipient_id' => $recipientId[0]['id']
				);
			}

			$this->Email_model->setBatchImport($data);
			$this->Email_model->importData();

			redirect('departments/get_department_members/' . $department_id);

		} catch (Exception $exception) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}

	}

	public function sendEmailToChecked()
	{

		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$subject = $this->input->post('email_subject', TRUE);
		$body = $this->input->post('content_email', TRUE);
		$recipients = explode(',', $this->input->post('users_emails', TRUE));

		$mail = $this->config_email_sender();

		try {

			$mail->setFrom('timeaway@itrservices.eu', $this->session->userdata('username'));

			foreach ($recipients as $email) {
				$mail->addAddress($email);
			}

			$mail->isHTML(true);
			$mail->Subject = $subject;

			$mail->Body = $body;

			$mail->send();

			$this->session->set_flashdata('emailsToAll', 'Emails sent successfully!');

			foreach ($recipients as $email) {

				$recipientId = $this->Email_model->getIdByEmail($email);

				$data[] = array(
					'subject' => $subject,
					'content' => strip_tags($body),
					'sender_id' => $this->session->userdata('user_id'),
					'recipient_id' => $recipientId[0]['id']
				);
			}

			$this->Email_model->setBatchImport($data);
			$this->Email_model->importData();

			redirect('test/getUsersList');

		} catch (Exception $exception) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
	}

	/**
	 *
	 */
	public function singleUserMail()
	{
		//check login
		if (!$this->session->userdata('logged_in')) {
			redirect('users/login');
		}

		$recipient = $this->input->post('user_email', TRUE);
		$subject = $this->input->post('email_subject', TRUE);
		$body = $this->input->post('content_email', TRUE);

		$mail = $this->config_email_sender();

		try {

			$mail->setFrom('niki.marchin@gmail.com', $this->session->userdata('username'));

			$mail->addAddress($recipient);

			$mail->isHTML(true);
			$mail->Subject = $subject;

			$mail->Body = $body;

			$mail->send();

			//email successfully sent notification
			$this->session->set_flashdata('emailSuccess', 'Успешно изпратен имейл!');

			//save email record to db
			$recipientId = $this->Email_model->getIdByEmail($recipient);

			$data[] = array(
				'subject' => $subject,
				'content' => strip_tags($body),
				'sender_id' => $this->session->userdata('user_id'),
				'recipient_id' => $recipientId[0]['id']
			);

			$this->Email_model->setBatchImport($data);
			$this->Email_model->importData();

			redirect('test/getUsersList');

		} catch (\Exception $exception) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
	}

	private function config_email_sender()
	{

		/* Exception class. */
		require_once('assets/vendor/PHPMailer/src/Exception.php');

		/* The main PHPMailer class. */
		require_once('assets/vendor/PHPMailer/src/PHPMailer.php');

		/* SMTP class, needed if you want to use SMTP. */
		require_once('assets/vendor/PHPMailer/src/SMTP.php');

		$mail = new PHPMailer(true); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->CharSet = 'UTF-8';

		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		$mail->Username = "niki.marchin@gmail.com";
		$mail->Password = "Ferrari10*";

		return $mail;

	}

}
