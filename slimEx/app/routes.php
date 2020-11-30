<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

include_once __DIR__ . '/../src/db.php';

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    ///////////////////////////////////////////////////////////////////////////////////////
    ////////////// Added GET and POST reqeusts ///////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////

    //GET request for beer type information
    $app->get('/{beerType}', function (Request $request, Response $response) {
        //Get beerType from request
        $beerType = $request->getAttribute('beerType');
        //Pass beerType to sql statment to be queried on DB
        $sql = "SELECT beer_type,description FROM beersDescript WHERE beer_type='$beerType'";

        try {
            //Get DB object
            $db = new db();
            //Connect to DB
            $db = $db->connect();
            $stmt = $db->query($sql);
            $beerInfo = $stmt->fetchAll(PDO::FETCH_OBJ);
            //Close connection after fetching data
            $db = null;

        } catch(PDOException $ex) {
            echo '{"error":{"text": '.$ex->getMessage().'}}';
        }
        
        //Pass response back to page to be printed
        $response->getBody()->write(json_encode($beerInfo));
        return $response;
    });

    //GET request for specific IPA beer names
    $app->get('/IPA/{beerName}', function (Request $request, Response $response) {
        //Get beerName from request
        $beerName = $request->getAttribute('beerName');
        //Pass beerName to sql statment to be queried on DB
        $sql = "SELECT name,type,brand FROM beers WHERE name='$beerName'";

        try {
            //Get DB object
            $db = new db();
            //Connect to DB
            $db = $db->connect();
            $stmt = $db->query($sql);
            $beerInfo = $stmt->fetchAll(PDO::FETCH_OBJ);
            //Close connection after fetching data
            $db = null;

        } catch(PDOException $ex) {
            echo '{"error":{"text": '.$ex->getMessage().'}}';
        }
        
        //Pass response back to page to be printed
        $response->getBody()->write(json_encode($beerInfo));
        return $response;
    });

    //GET request for specific Stout beer names
    $app->get('/Stout/{beerName}', function (Request $request, Response $response) {
        //Get beerName from request
        $beerName = $request->getAttribute('beerName');
        //Pass beerName to sql statment to be queried on DB
        $sql = "SELECT name,type,brand FROM beers WHERE name='$beerName'";

        try {
            //Get DB object
            $db = new db();
            //Connect to DB
            $db = $db->connect();
            $stmt = $db->query($sql);
            $beerInfo = $stmt->fetchAll(PDO::FETCH_OBJ);
            //Close connection after fetching data
            $db = null;

        } catch(PDOException $ex) {
            echo '{"error":{"text": '.$ex->getMessage().'}}';
        }
        
        //Pass response back to page to be printed
        $response->getBody()->write(json_encode($beerInfo));
        return $response;
    });

    //GET request for specific Porter beer names
    $app->get('/Porter/{beerName}', function (Request $request, Response $response) {
        //Get beerName from request
        $beerName = $request->getAttribute('beerName');
        //Pass beerName to sql statment to be queried on DB
        $sql = "SELECT name,type,brand FROM beers WHERE name='$beerName'";

        try {
            //Get DB object
            $db = new db();
            //Connect to DB
            $db = $db->connect();
            $stmt = $db->query($sql);
            $beerInfo = $stmt->fetchAll(PDO::FETCH_OBJ);
            //Close connection after fetching data
            $db = null;

        } catch(PDOException $ex) {
            echo '{"error":{"text": '.$ex->getMessage().'}}';
        }
        
        //Pass response back to page to be printed
        $response->getBody()->write(json_encode($beerInfo));
        return $response;
    });

    //GET request for specific Sour beer names
    $app->get('/Sour/{beerName}', function (Request $request, Response $response) {
        //Get beerName from request
        $beerName = $request->getAttribute('beerName');
        //Pass beerName to sql statment to be queried on DB
        $sql = "SELECT name,type,brand FROM beers WHERE name='$beerName'";

        try {
            //Get DB object
            $db = new db();
            //Connect to DB
            $db = $db->connect();
            $stmt = $db->query($sql);
            $beerInfo = $stmt->fetchAll(PDO::FETCH_OBJ);
            //Close connection after fetching data
            $db = null;

        } catch(PDOException $ex) {
            echo '{"error":{"text": '.$ex->getMessage().'}}';
        }
        
        //Pass response back to page to be printed
        $response->getBody()->write(json_encode($beerInfo));
        return $response;
    });

    ///////////////////////////////////////////////
    //    POST request to add beer information  ///
    ///////////////////////////////////////////////
    $app->post('/brewery', function (Request $request, Response $response) {
        //Get parameters for POST request
        $getAllParams = $request->getParsedBody();
        $name = $getAllParams["name"];
        $type = $getAllParams["type"];
        $brand = $getAllParams["brand"];
 

        //insert statment to put paramaters into DB
        $sql = "INSERT INTO beers (name, type, brand) VALUES (:name,:type,:brand)";

        try {
            //Get DB object
            $db = new db();
            //Connect to DB
            $db = $db->connect();
            //Prepare sql statment and bind paramters
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':type',$type);
            $stmt->bindParam(':brand',$brand);
            $stmt->execute();

            

            //Close connection after adding data
            $db = null;

        } catch(PDOException $ex) {
            echo '{"error":{"text": '.$ex->getMessage().'}}';
        }
        
        

        //Prepare sql statemetn to retrieve new data
        $sql = "SELECT name,type,brand FROM beers WHERE name='$name'";
        //returnt the new values from DB
        try {
            $db = new db();
            $db = $db->connect();
            $stmt = $db->query($sql);
            $newBeer = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;

        } catch (PDOException $ex) {
            echo '{"error":{"text": '.$ex->getMessage().'}}'; 
        }
        
        //Pass response back to page to be printed
        $response->getBody()->write(json_encode($newBeer));
        return $response;

    });


};
