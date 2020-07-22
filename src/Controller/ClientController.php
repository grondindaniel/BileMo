<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;


class ClientController extends AbstractController
{

    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

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

    /**
     * @OA\Get(path="/api/v1/clients/{id}", @OA\Response(response="200", description="All clients"))
     * @Route("/api/v1/clients/{id}", name="api_clients_id", methods={"GET"})
     * @param ClientRepository $clientRepository
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param $id
     * @param CacheInterface $cache
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getClientsDetails(ClientRepository $clientRepository, Request $request, SerializerInterface $serializer, $id, CacheInterface $cache)
    {
        $user = $this->getUser();
        $user_id = $user->getId();
        $clients = $clientRepository->findBy(array('id'=>$id, 'user'=>$user_id));
        $result = $cache->get('resultat', function (ItemInterface $item) use ($clients){
            $item->expiresAfter(5);
            return $this->json($clients, 200,[],['circular_reference_limit' => 1,
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                },'ignored_attributes' => ['user']]);
        });
        return $result;

    }

    /**
     * @OA\Delete(path="/api/v1/delete_clients/{id}", @OA\Response(response="204", description="delete a client", @OA\JsonContent(type="string")))
     * @Route("/api/v1/delete_clients/{id}", name="api_delete_clients_id", methods = {"DELETE"})
     * @param EntityManagerInterface $manager
     * @param Client $client
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function remove(EntityManagerInterface $manager, Client $client)
    {
        $manager->remove($client);
        $manager->flush();
        return $this->json(['result' => 'client deleted with success']);
    }
}
