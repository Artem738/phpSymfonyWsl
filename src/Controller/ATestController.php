<?php
// src/Controller/TestController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ATestController
{
    /**
     * @Route("/test", name="test_route")
     */
    public function test(): Response
    {
        return new Response(
            '<html><body><h1>Тестова сторінка з окремим контроллером </h1></body></html>'
        );
    }
}