<?php

namespace App\Controller;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class DeleteClientsController extends AbstractController
{
    /**
     * @OA\Delete(path="/api/v1/clients/{id}", @OA\Response(response="204", description="delete a client", @OA\JsonContent(type="string")))
     * @Route("/api/v1/clients/{id}", name="api_delete_clients_id", methods = {"DELETE"})
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
