<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use OpenApi\Annotations as OA;

class UserLoginController extends AbstractController
{
    /**
     * @OA\Post(path="/login", @OA\Response(response="200", description="Successful authentication", @OA\JsonContent(type="string")))
     * @Route("/login", name="api_login", methods={"POST"})
     */
    public function login()
    {
        try {
            return $this->json(['result' => 'ok']);
        }
        catch (NotEncodableValueException $e){
            return $this->json(array("status"=>400,'message'=>$e->getMessage()));
        }
    }
}
