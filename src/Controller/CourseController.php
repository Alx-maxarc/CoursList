<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Liste;
use App\Repository\CourseRepository;
use App\Repository\ListeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CourseController extends AbstractController
{
    #[Route('/api/course/{id}', name: 'app_course', methods: ['GET'])]
    public function getCourse( $id,CourseRepository $courseRepository, ListeRepository $listeRepository, SerializerInterface $serializer, Security $security): JsonResponse
    {
        $user = $security->getUser();

        if (!$user) {
            // L'utilisateur n'est pas authentifié, renvoyer une réponse non autorisée par exemple
            return new JsonResponse(['message' => 'Non autorisé'], JsonResponse::HTTP_UNAUTHORIZED);
        }

            $userListes = $listeRepository->findByUser($user);
            $liste = $listeRepository->find($id);
            
            if ($liste && in_array($liste, $userListes)) {
                $course = $courseRepository->findByListe($liste);
                $jsonCourse = $serializer->serialize($course, 'json',  ['groups' => 'courses']);
                return new JsonResponse($jsonCourse, Response::HTTP_OK, [], true);
            }
            return new JsonResponse(['message' => 'Utilisateur non autorisé'], Response::HTTP_NOT_FOUND);
       }

       #[Route('/api/course/{id}', name: 'deleteCourse', methods: ['DELETE'])]
    public function deleteCourse(Course $course, EntityManagerInterface $em): JsonResponse 
    {
        $em->remove($course);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


       #[Route('/liste/{id}/addCourse', name: 'add_course', methods: ["POST"])]
       public function addCourse(int $id, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, Security $security, ListeRepository $listeRepository): JsonResponse
       {
           // Récupérer les données JSON de la requête
           $data = json_decode($request->getContent(), true);
       
           // Créer une nouvelle liste de course en désérialisant les données JSON
           $newCourse = $serializer->deserialize(json_encode($data), Course::class, 'json');
       
           // Récupérer la liste à partir de l'ID
           $liste = $listeRepository->find($id);
       
           if (!$liste) {
               // Gérer le cas où la liste n'est pas trouvée (par exemple, renvoyer une réponse d'erreur)
               return new JsonResponse(['message' => 'Liste non trouvée'], JsonResponse::HTTP_NOT_FOUND);
           }
       
           // Associer la course à la liste
           $newCourse->setListe($liste);
       
           // Enregistrez la nouvelle course en base de données
           $entityManager->persist($newCourse);
           $entityManager->flush();
       
           // Réponse JSON
           return new JsonResponse(['message' => 'Course ajoutée à la liste avec succès'], JsonResponse::HTTP_CREATED);
       }
       
    
}