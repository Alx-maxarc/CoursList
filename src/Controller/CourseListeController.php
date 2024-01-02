<?php

namespace App\Controller;

use App\Entity\Liste;
use App\Entity\User;
use App\Repository\ListeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CourseListeController extends AbstractController
{
    #[Route('/moncompte', name: 'app_course_liste')]
    public function index(): Response
    {
        return $this->render('course_liste/index.html.twig');
    }
    #[Route('/api/list', name: 'app_list', methods: ['GET'])]
    public function getList(ListeRepository $listesRepository, SerializerInterface $serializer, Security $security): JsonResponse
    {
        // Récupérer l'utilisateur actuellement authentifié (supposons que vous utilisez Symfony Security)
        $user = $security->getUser();

        if (!$user) {
            // L'utilisateur n'est pas authentifié, renvoyer une réponse non autorisée par exemple
            return new JsonResponse(['message' => 'Non autorisé'], JsonResponse::HTTP_UNAUTHORIZED);
        }
        $userListes = $listesRepository->findByUser($user);
        $jsonListe = $serializer->serialize($userListes, 'json', ['groups' => 'listes']);

        return new JsonResponse($jsonListe, Response::HTTP_OK, [], true);
    }

    #[Route('/api/list/{id}', name: 'deleteBook', methods: ['DELETE'])]
    public function deleteBook(Liste $list, EntityManagerInterface $em): JsonResponse 
    {
        $em->remove($list);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    #[Route('/addListCourse', name: 'add_list_course', methods:["POST"])]
    public function addListCourse(Request $request, User $user, EntityManagerInterface $entityManager, SerializerInterface $serializer, Security $security): JsonResponse
    {
        // Récupérer les données JSON de la requête
    $data = json_decode($request->getContent(), true);

    // Créer une nouvelle liste de course en désérialisant les données JSON
    $newListe = $serializer->deserialize(json_encode($data), Liste::class, 'json');

    $user = $security->getUser();
    // Associer la liste à l'utilisateur
    $newListe->addInvite($user);

    // Enregistrez la nouvelle liste en base de données
    $entityManager->persist($newListe);
    $entityManager->flush();

    // Réponse JSON
    return new JsonResponse(['message' => 'Liste de course créée avec succès'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/inviteUserToList', name: 'invite_user_to_list', methods: ['POST'])]
public function inviteUserToList(Request $request, ListeRepository $listeRepository,UserRepository $userRepository,EntityManagerInterface $entityManager): JsonResponse
{
    // Récupérer les données JSON de la requête
    $data = json_decode($request->getContent(), true);

    // Récupérer l'entité Liste à partir de l'ID fourni dans la requête
    $listId = $data['listId']; // Assurez-vous que le front-end envoie l'ID de la liste
    $liste = $listeRepository->find($listId);

        // Récupérer l'utilisateur à inviter à partir du nom d'utilisateur (email) fourni dans la requête
        $mailToInvite = $data['email'];
        $userToInvite = $userRepository->findOneBy(['email' => $mailToInvite]);

        if ($userToInvite) {
            // Inviter l'utilisateur à la liste
            $liste->addInvite($userToInvite);
            $entityManager->flush();

            return new JsonResponse(['message' => 'Utilisateur invité avec succès'], JsonResponse::HTTP_OK);
        } else {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }
    
}


}
