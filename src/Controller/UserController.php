<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class UserController extends AbstractController
{
    /**
     * @Route ("/register", name = "api_register", methods = {"POST"})
     */
    public function register(UserPasswordEncoderInterface $passwordEncoder, Request $request, EntityManagerInterface $om)
    {
        try {
            $user = new User();
            $username = $request->get("username");
            $password = $request->get("password");
            $encodedPassword = $passwordEncoder->encodePassword($user, $password);
            $user-> setUsername($username);
            $user-> setPassword ($encodedPassword);

            $om->persist($user);
            $om->flush();
            return $this->json([
                'username' => $username,
                'password' => $password
            ]);
        }catch (NotEncodableValueException $e){
            return $this->json(array('status'=>400, 'message'=>$e->getMessage(),400));
        }
    }


    /**
     * @OA\Post(path="/login", @OA\Response(response="200", description="Successful authentication", @OA\JsonContent(type="string")))
     * @Route("/login", name="api_login", methods={"POST"})
     */
    public function login()
    {
        return $this->json(['result' => 'ok']);
    }
}
