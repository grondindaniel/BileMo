<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;

class ClientController extends AbstractController
{
    /**
     * @OA\Post(path="/api/v1/register_client", @OA\Response(response="201", description="client created", @OA\JsonContent(type="string")))
     * @Route("/api/v1/register_client", name = "api_register_client", methods = {"POST"})
     */
    public function register(Request $request, EntityManagerInterface $om, SerializerInterface $serializer)
    {

        $client = $request->getContent();
        $client = $serializer->deserialize($client, Client::class, 'json');
        $user = $this->getUser();
        $client-> setUser($user);
        $om->persist($client);
        $om->flush();
        return $this->json($client, 200,[],['circular_reference_limit' => 1,
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },'ignored_attributes' => ['user']]);
    }

    /**
     * @OA\Get(path="/api/v1/clients", @OA\Response(response="200", description="All clients"))
     * @Route("/api/v1/clients", name="api_clients", methods={"GET"})
     */
    public function getClients(ClientRepository $clientRepository, Request $request, SerializerInterface $serializer)
    {
        $user = $this->getUser();
        $id = $user->getId();
        $clients = $clientRepository->findClientsList($id);
        return $this->json($clients, 200,[],['circular_reference_limit' => 1,
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },'ignored_attributes' => ['user']]);
    }

    /**
     * @OA\Get(path="/api/v1/clients/{id}", @OA\Response(response="200", description="All clients"))
     * @Route("/api/v1/clients/{id}", name="api_clients_id", methods={"GET"})
     */
    public function getClientsDetails(ClientRepository $clientRepository, Request $request, SerializerInterface $serializer, $id)
    {
        $user = $this->getUser();
        $user_id = $user->getId();
        $clients = $clientRepository->findBy(array('id'=>$id, 'user'=>$user_id));
        return $this->json($clients, 200,[],['circular_reference_limit' => 1,
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },'ignored_attributes' => ['user']]);
    }

    /**
     * @OA\Delete(path="/api/v1/delete_clients/{id}", @OA\Response(response="204", description="delete a client", @OA\JsonContent(type="string")))
     * @Route("/api/v1/delete_clients/{id}", name="api_delete_clients_id", methods = {"DELETE"})
     */
    public function remove(EntityManagerInterface $manager, Client $client)
    {
        $manager->remove($client);
        $manager->flush();
        return $this->json(['result' => 'client deleted with success']);
    }
}
