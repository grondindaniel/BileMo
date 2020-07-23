<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use JMS\Serializer\SerializationContext;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;

class GetClientsController extends AbstractController
{

    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
    /**
     * @OA\Get(path="/api/v1/clients", @OA\Response(response="200", description="All clients"))
     * @Route("/api/v1/clients", name="api_clients", methods={"GET"})
     */
    public function getClients(ClientRepository $clientRepository, Request $request, PaginatorInterface $paginator)
    {
        $user = $this->getUser();
        $id = $user->getId();
        $clients = $clientRepository->findBy(array('user'=>$id));
        $clients = $paginator->paginate($clients, $request->get('page', 1), 3);
        $json = $this->serializer->serialize($clients, 'json', SerializationContext::create()->setGroups(array('Default')));
        return new Response($json, 200, array('Content-Type' => 'application/json'));
    }
}
