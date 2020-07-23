<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use OpenApi\Annotations as OA;

class GetClientsDetailsController extends AbstractController
{
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
}
