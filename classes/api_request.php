<?php
class EditseeAPI_Request {
  public static function get_request_method() {
    return $_SERVER['REQUEST_METHOD'];
  }

  public static function get_request_data() {
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    $data = array();

    switch ($method) {
      case 'get':
        $data = $_GET;
      break;
      case 'post':
        $data = $_POST;
      break;
      case 'put':
      case 'patch':
      case 'delete':
        $data = json_decode(file_get_contents("php://input"), true);
      break;
    }
    return $data;
  }
}
?>
