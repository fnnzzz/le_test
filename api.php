<?php 


class LE_Test {

   public function __construct($user, $password, $database, $host = 'localhost') {
         $this->user = $user;
         $this->password = $password;
         $this->database = $database;
         $this->host = $host;
   }

   protected function connect() {
      return new mysqli($this->host, $this->user, $this->password, $this->database);
   }

   public function checkApiKey($api_k) {
      $db = $this->connect();
      $stmt = $db->prepare('SELECT * FROM api_keys WHERE api_key=?');
      $stmt->bind_param("s", $api_k);
      $stmt->execute();
      $result = $stmt->get_result();
      
      if ( $result->num_rows == 1 ) {
         return true;
      }
      else {
         return false;
      }
   }


   public function validationName($name) {

      if ( !preg_match("/^[a-zA-Z ]*$/", $name) ) {
        return 1;
      }
      else if ( strlen($name) == 0 ) {
        return 0;  
      }
      else if (strlen($name) > 250) {
         return -1;  
      }
      else {
         return -2;
      }

   }

   public function validationEmail($email) {
      
      if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        return false;
      }
      else {
         return true;
      }

   }

   public function addUser($name, $email) {
      $db = $this->connect();
      $stmt = $db->prepare("INSERT INTO userlist (name, email, order_num) VALUES (?, ?, ?)");

      // generate unique random order_num
      $rnd_order_num = $this->randomOrderNum();

      // if table is empty set first element default 1
      if(!$rnd_order_num) {
         $rnd_order_num[0]->rnd_order = 1;
      }

      $stmt->bind_param("ssd", $name, $email, $rnd_order_num[0]->rnd_order);
      $stmt->execute();

      if ( $stmt->affected_rows ) {
            return $db->insert_id;
      }
      else {
         return false;
      }
   }

   public function InsertedValues($id) {
      $db = $this->connect();
      $stmt = $db->prepare('SELECT * FROM userlist WHERE id=?');
      $stmt->bind_param("s", $id);
      $stmt->execute();
      $result = $stmt->get_result();

      while ($row = $result->fetch_object()) {
         $results[] = $row;
      }

      return $results;
   }


   public function randomOrderNum() {
      $db = $this->connect();


      $stmt = $db->prepare('SELECT FLOOR(1 + RAND() * 10000) AS rnd_order
                           FROM userlist
                           WHERE "rnd_order" NOT IN (SELECT order_num FROM userlist)
                           LIMIT 1');
      $stmt->execute();
      $result = $stmt->get_result();

      while ($row = $result->fetch_object()) {
         $results[] = $row;
      }

      return $results;

   }

   public function deleteItem($order_id) {

      $db = $this->connect();
      $stmt = $db->prepare("DELETE FROM userlist WHERE order_num = ?");
      
      $stmt->bind_param('s', $order_id);
      $stmt->execute();
      
      if ( $stmt->affected_rows ) {
         return true;
      }
   }


}


error_reporting(E_ERROR);


$api_key = $_GET['api_key'];;
$name = $_POST['name'];
$email = $_POST['email'];

$is_delete = $_GET['delete'];
$delete_id = $_POST['order'];

$api = new LE_Test('root', '', 'le_test');

$check_api = $api->checkApiKey($api_key);
$check_name = $api->validationName($name);
$check_email = $api->validationEmail($email);




//0 check if it's delete-request
if( $is_delete && $check_api ) {
   $delete_status = $api->deleteItem($delete_id);

   if($delete_status) {
      echo json_encode(array('deleting' => 'true'));
   }
   else {
      header('HTTP/1.1 500 Internal Server Error');
      header('Content-Type: application/json; charset=UTF-8');
      die(json_encode(array('message' => 'deleting database error')));
   }
}

else {
   // if api, name and email is valid - adding user
   if( $check_api && $check_name && $check_email) {
      $add_user = $api->addUser($name, $email);

      // if add_user no errors occurred - 
      // select last_insert values and return json-response
      if( $add_user ) {
         $last_insert = $api->InsertedValues($add_user);
         if( $last_insert[0]->id ) {

            // json-message response with all values
            echo json_encode(array('id' => $last_insert[0]->id, 'name' => $last_insert[0]->name, 'email' => $last_insert[0]->email, 'order' => $last_insert[0]->order_num));
         }
         else {
            // if existing error on select insert_id generating error and return her
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'database error')));
         }
      }

   }

   // if name/email/api is invalid = generating error-message
   else {
      if( $check_name == 0) {
         $error = 'name is empty';
      }

      if( $check_name == -1) {
         $error = 'name is too long';
      }

      if( $check_name == -2) {
         $error = 'name is invalid';
      }

      if( !$check_email ) {
         $error = 'email is invalid';
      }

      if( !$check_api ) {
         $error = 'api key is invalid';
      }

      // and return json-message with [html code 500 error]
      header('HTTP/1.1 500 Internal Server Error');
      header('Content-Type: application/json; charset=UTF-8');
      die(json_encode(array('message' => $error)));

   }


}

?>