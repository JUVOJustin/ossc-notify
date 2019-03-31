<?php

class SubscriptionHandler_Model extends CI_Model {

        public function check_id($id) {
                //$query = $this->db->simple_query('Select id from subscriptions where id = '.$id);
                $query = $this->db->get_where('subscriptions', array('id' => $id) );
                if ($query->result_id->num_rows > 0){
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        public function check_email($email) {
                //$query = $this->db->simple_query('Select email from subscriptions where email = '.$email);
                $query = $this->db->get_where('subscriptions', array('email' => $email) );
                if ($query->result_id->num_rows > 0){
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        public function check_verified($id) {
                $query = $this->db->get_where('subscriptions', array('id' => $id, 'verified' => 1) );

                if ($query->result_id->num_rows > 0){
                        return TRUE;
                } else {
                        return FALSE;
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

        public function validateSubscription($id) {
                $this->db->set('verified', 1);
                $this->db->where('id', $id);
                $this->db->update('subscriptions');
        }

}