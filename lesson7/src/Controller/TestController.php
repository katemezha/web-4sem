<?php

  declare(strict_types=1);

namespace App\Controller;

use App\Utils\AuthService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

  /**
   * @Route("/test")
   */
  class TestController{

    /**
     * @Route(path="/", methods={"GET"})
     */
    public function index(Request $request, AuthService $authService)
    {
        $authMetaData = $request->headers->get('Authorization', '');

        if($authMetaData !=='' && $authService->checkCredentials($authMetaData)) {
            return new Response(
                json_encode([ 
                    'message'=>'Ok, method logic result is here',
                ]),
                Response::HTTP_OK,
                [
                    'Content-type'=>'application/json'
                ]
            );
        }

        return new Response(
            json_encode([
                'message'=>'Not Authorized',
            ]),
            Response::HTTP_UNAUTHORIZED,
            [
                'www-Authenticate' => 'Basic realm="Access to the staging site", charset="UTF-8"',
                'Content-type'=>'application/json'
            ]
        );
    }

  /**
     * @Route(path="/users", methods={"GET"})
     */
    public function users() 
    {
      return new Response(
        json_encode(
          [
            new class('Polina', 20){

              public $name;
              public $age;

              public function __construct($name, $age)
              {
                $this->name = $name;
                $this->age = $age;
              }

            },

            new class('Ivan', 18){

              public $name;
              public $age;

              public function __construct($name, $age)
              {
                $this->name = $name;
                $this->age = $age;
              }

            }

          ]
          ),
          Response::HTTP_OK,
          [
            'Content-type' => "application/json"
          ]
      );
    }
  }
  

?>