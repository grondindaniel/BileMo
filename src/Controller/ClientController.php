<?php

namespace App\Controller;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class ClientController extends AbstractController
{
    

    /**
     * @OA\Post(path="/api/v1/register_clients", @OA\Response(response="201", description="client created", @OA\JsonContent(type="string")))
     * @Route("/api/v1/register_clients", name = "api_register_client", methods = {"POST"})
     * @param Request $request
     * @param EntityManagerInterface $om
     * @param SerializerInterface $serializer
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function register(Request $request, EntityManagerInterface $om, SerializerInterface $serializer, ValidatorInterface $validator)
    {

        try {
            $client = $request->getContent();
            $client = $serializer->deserialize($client, Client::class, 'json');
            $user = $this->getUser();
            $client-> setUser($user);

            $error = $validator->validate($client);

            if(count($error)>0){
                return $this->json($error, 400);
            }

            $om->persist($client);
            $om->flush();
            return $this->json($client, 200,[],['circular_reference_limit' => 1,
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                },'ignored_attributes' => ['user']]);
        }
        catch (NotEncodableValueException $e)
        {
            return $this->json(array('status'=>400, 'message'=>$e->getMessage()),400);
        }
    }

}
