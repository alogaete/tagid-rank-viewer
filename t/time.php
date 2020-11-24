<?

header('Content-type: application/x-javascript');
  echo json_encode(strtotime($_GET["time"])); exit();