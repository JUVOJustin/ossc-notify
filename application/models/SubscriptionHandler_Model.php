<?php

class SubscriptionHandler_Model extends CI_Model {

        public function check_id($id) {
                //$query = $this->db->simple_query('Select id from subscriptions where id = '.$id);
                $query = $this->db->get_where('subscriptions', array('id' => $id) );
                if ($query->num_rows > 0){
                        return FALSE;
                } else {
                        return TRUE;
                }
        }

        public function check_email($email) {
                //$query = $this->db->simple_query('Select email from subscriptions where email = '.$email);
                $query = $this->db->get_where('subscriptions', array('email' => $email) );
                if ($query->num_rows > 0){
                        return FALSE;
                } else {
                        return TRUE;
                }
        }

        public function add_subscriber($id, $email, $verified) {
                $data = array(
                        'id' => $id,
                        'email' => $email,
                        'verified' => $verified
                );
                
                $this->db->insert('subscriptions', $data);
        }

}