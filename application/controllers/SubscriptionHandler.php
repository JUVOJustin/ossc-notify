<?php

    class SubscriptionHandler extends CI_Controller {

        private $user_email, $user_id, $validated;

        public function __contruct() {
            parent::__construct();
            $this->load->model('SubscriptionHandler_Model');
        }

        public function index() {

            //Load Validation Library
            $this->load->library('form_validation');

            //Variable that is passed to View
            //Keys are variables that can be used in view
            $data = array(
                'valid' => False,
            );

            //Validate Mail
            $this->form_validation->set_rules('emailaddress', 'E-Mail', 'required|valid_email|is_unique[subscriptions.email]', 
                array(
                    'required' => 'Die %s muss eingetragen werden',
                    'valid_email' => 'Trage eine gültige %s ein',
                    'is_unique' => 'Du bist bereits im Verteiler',
                )
            );

            //Validate Honepot
            $this->form_validation->set_rules('privacy-cp', 'Datenschutz', 'callback_honeypot_check');

            //Set surrounding class
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

            //Validate Form
            if ($this->form_validation->run() == FALSE) {
                //Load normal View when validation was negative
                $this->load->view('subscription-handler', $data);
            } else {
                //Load view with success message and execute signup code
                $data = array('valid' => True);
                $this->newSubscribe();
                $this->load->view('subscription-handler', $data);
            }

            //Check if validation request
            if (isset($_GET['uid']) && isset($_GET['v'])) {
                $this->validateSubscription($_GET['uid']);
            }

        }

        public function honeypot_check($str) {
            if ($str == "true") {
                    $this->form_validation->set_message('honeypot_check', 'Wirklich niemand mag Spam...');
                    return FALSE;
            } else {
                    return TRUE;
            }
        }

        private function newSubscribe() {
            $this->load->model('SubscriptionHandler_Model');

            $this->user_email = $this->input->post('emailaddress');
            $this->user_id = mt_rand(000000, 999999);
            $this->validated = 0;

            //Generate random ID again if already used
            while (!$this->SubscriptionHandler_Model->check_id($this->user_id)) {
                $this->user_id = mt_rand(000000, 999999);
            }

            //Check if mail is already used
            if($this->SubscriptionHandler_Model->check_email($this->user_email)) { 
                //Add user to database
                $this->SubscriptionHandler_Model->add_subscriber($this->user_id, $this->user_email, $this->validated);

                $this->sendVerification();
            }
        }

        private function sendVerification() {

            $this->load->library('email');

            //E-Mail Config
            $this->email->from('noreply@juvo-design.de', 'Klausur Notifier');
            $this->email->to($this->user_email);

            $this->email->subject('Empfang Verifizieren');
            $this->email->message('<h2>Hallo,</h2>
            du hast dich in den Verteiler für Benachrichtigungen zu neuen Klausuren eingetragen.<br>
            Bitte bestätige deine Anmeldung hier: <b><a href="'. base_url() .'?uid='.$this->user_id.'&v=1></a></b>');

            $this->email->send();
            $this->email->print_debugger(array('headers'));
        }

        
        private function validateSubscription($uid) {

            $this->load->model('SubscriptionHandler_Model');

            //If User already exists and is not verified
            if ($this->SubscriptionHandler_Model->check_id($uid) && !$this->SubscriptionHandler_Model->check_verified($uid)) {
                //Verify User
                $this->SubscriptionHandler_Model->validateSubscription($uid);
            }
        }

    }