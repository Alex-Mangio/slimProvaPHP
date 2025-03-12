<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  public function index(Request $request, Response $response, $args):response{
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function getAlunni(Request $request, Response $response, $args):response{
    $id = $args["id"];
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni a WHERE $id = a.id");
    $results = $result->fetch_all(MYSQLI_ASSOC);
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function createAlunno(Request $request, Response $response, $args):response{
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $body = json_decode($request->getBody()->getContents(),true);
    $nome = $body["nome"];
    $cognome = $body["cognome"];
    $raw_query = "INSERT INTO alunni(nome, cognome) VALUES('$nome','$cognome')";
    $result = $mysqli_connection->query($raw_query);
    if($result && $mysqli_connection->affected_rows > 0){
      $response->getBody()->write(json_encode(array("message" => "Success")));
    } else {
      $response->getBody()->write(json_encode(array("message" => $mysqli_connection->error)));
      return $response->withHeader("Content-type", "application/json")->withStatus(404);
    }
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function updateAlunno(Request $request, Response $response, $args):response{
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $id = $args["id"];
    $body = json_decode($request->getBody()->getContents(),true);
    $nome = $body["nome"];
    $cognome = $body["cognome"];
    $raw_query = "UPDATE alunni SET nome = $nome, cognome = $cognome WHERE $id = id";
    $result = $mysqli_connection->query($raw_query);
    if($result && $mysqli_connection->affected_rows > 0){
      $response->getBody()->write(json_encode(array("message" => "Success")));
    } else {
      $response->getBody()->write(json_encode(array("message" => $mysqli_connection->error)));
      return $response->withHeader("Content-type", "application/json")->withStatus(404);
    }
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function deleteAlunno(Request $request, Response $response, $args):response{
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $id = $args["id"];
    $raw_query = "DELETE FROM alunni WHERE $id = id";
    $result = $mysqli_connection->query($raw_query);
    $results = $result->fetch_all(MYSQLI_ASSOC);
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }
}
