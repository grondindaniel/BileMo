<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class EditClientController extends AbstractController
{
    /**
     * @Route("/api/v1/edit/{id}", name = "api_edit_client", methods = {"PUT"})
     * @param Request $request
     * @param EntityManagerInterface $om
     * @param SerializerInterface $serializer
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function edit(Client $client,Request $request, EntityManagerInterface $om, SerializerInterface $serializer, $id, ClientRepository $clientRepository,EntityManagerInterface $manager
    )
    {
        $clientUpdate = $manager->getRepository(Client::class)->find($client->getId());

        $data = json_decode($request->getContent());

        foreach($data as $key => $value){
            if($key && !empty($value)){
                $name = ucfirst($key);
                $setter = 'set'.$name;
                $clientUpdate->$setter($value);
            }
        }

        $manager->flush();

        return $this->json(['result' => 'Données mise à jour avec succès']);
    }
}

