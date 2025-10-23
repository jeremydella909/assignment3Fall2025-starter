<?php
    require_once 'Contact.php';

    class ContactDAO {


        public function getConnection(){
            $mysqli = new mysqli("127.0.0.1", "cs2033user", "cs2033pass", "cs2033");
            if ($mysqli->connect_errno) {
                $mysqli=null;
            }
            return $mysqli;
        }

        public function addContact($contact){
            $connection=$this->getConnection();
            $stmt = $connection->prepare("INSERT INTO contacts (username, email) VALUES (?, ?)");
            $stmt->bind_param("ss", $contact->username, $contact->email);
            $stmt->execute();
            $stmt->close();
            $connection->close();
        }

        public function getContacts(){
            $connection=$this->getConnection();
            $stmt = $connection->prepare("SELECT * FROM contacts;"); 
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()){
                $contact = new Contact();
                $contact->load($row);
                $contacts[]=$contact;
            }    
            $stmt->close();
            $connection->close();
            return $contacts;
        }

        public function delContact($contactID){
            $connection=$this->getConnection();
            $stmt = $connection->prepare("DELETE FROM contacts WHERE contactID = ?");
            $stmt->bind_param("i", $contactID);
            $stmt->execute();
            $stmt->close();
            $connection->close();
        }

        public function updateContact($contactID, $username, $email){
            $connection=$this->getConnection();
            $stmt = $connection->prepare("UPDATE contacts SET username=?, email=? WHERE contactID=?");
            $stmt->bind_param("ssi", $username, $email, $contactID);
            $stmt->execute();
            $stmt->close();
            $connection->close();
        }




    }
?>
