<?php

namespace App\Controller;

use App\DTO\UserLoginReturnDataDTO;
use App\Entity\User;
use GuzzleHttp\Client;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends AbstractController
{
    private $manager;
    private $user;


    public function __construct(EntityManagerInterface $manager, UserRepository $user)
    {
        $this->manager = $manager;

        $this->user = $user;
    }

    function generateAuthToken()
    {
        // Generate a random string for the token
        $token = bin2hex(random_bytes(32));

        return $token;
    }

    //Création d'un utilisateur
    #[Route('/userCreate', name: 'user_create', methods: 'POST')]
    public function userCreate(Request $request,JWTTokenManagerInterface $jwtManager): JsonResponse
    {

        $data = json_decode($request->getContent(), true);


        $email = $data['email'];
        $username = $data['username'];
        $password = $data['password'];


        //Vérifier si l'email existe déjà

        $email_exist = $this->user->findOneByEmail($email);

        if ($email_exist) {
            return new JsonResponse
            (
                [
                    'status' => false,
                    'message' => 'Email existe déjà, veuillez le changer'
                ]

            );
        }

        $username_exist = $this->user->findOneByUsername($username);

        if ($username_exist) {
            return new JsonResponse
            (
                [
                    'status' => false,
                    'message' => 'Nom utlilisateur existe déjà, veuillez le changer'
                ]
            );
        } else {
            $user = new User();





            $user->setEmail($email)
                ->setUsername($username)
                ->setPassword(sha1($password))
                ->setRoles(['ROLE_USER'])
                ->setMailConfirmed("false");
            $token = $jwtManager->create($user);

            $this->manager->persist($user);
            $this->manager->flush();




            $userData = array("email" => $email,
                "username" => $username,
                "mailConfirmed" => "false"
            );
            $returnData = new UserLoginReturnDataDTO($token, $userData);


            return ($this->json($returnData));

//

        }
    }





    //Liste des utilisateurs
    #[Route('/getAllUsers', name: 'get_allusers', methods: 'GET')]
    public function getAllUsers(): JsonResponse
    {
        $users = $this->user->findAll();

        return $this->json($users, 200);
    }

    #[Route('/delete/{id}', name: 'delete_create', methods: 'DELETE')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json('No user found for id' . $id, 404);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->json('Deleted a user successfully with id ' . $id);
    }

    //find  des users par username
    #[Route('/findByUsername/{username}', name: 'findByusern', methods: ['GET'])]
    public function findUser2(string $username, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(['username' => $username]);

        if (!$user) {
            return $this->json(['error' => sprintf('User with username "%s" not found.', $username)], 404);
        }
        return $this->json([
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),


        ]);
    }

    //find  des users par email
    #[Route('/findByEmail/{email}', name: 'getuser_email', methods: ['GET'])]
    public function findUser(string $email, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return $this->json(['error' => sprintf('User with username "%s" not found.', $email)], 404);
        }
        return $this->json([
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),

            'notfication' => $user->isNotfication(),


        ]);
    }


    //find  des users par id
    #[Route('/findById/{id}', name: 'getuser_id', methods: ['GET'])]
    public function findUserById(int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        if (!$user) {
            return new JsonResponse(['error' => sprintf('User with id "%s" not found.', $id)], 404);
        }

        return new JsonResponse([
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'password' => $user->getPassword(),

            'notfication' => $user->isNotfication(),


        ]);
    }

    //update des users profile
    #[Route('/updateUser/{email}', name: 'user_update', methods: ['PUT', 'PATCH'])]
    public function update(Request $request, ManagerRegistry $doctrine, string $email, UserPasswordHasherInterface $encoder): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user) {
            return $this->json(['message' => 'User not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }

        if (isset($data['username'])) {
            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['username' => $data['username']]);
            if ($existingUser && $existingUser !== $user) {
                return $this->json(['message' => 'Le nom utilisateur que vous avez choisi est déjà pris. Veuillez en choisir un autre.'], 400);
            }
            $user->setUsername($data['username']);
        }


        if (isset($data['password'])) {
            $password = $data['password'];
            if (strlen($password) <= 8) {
                return $this->json(['message' => 'Le mot de passe doit comporter plus de 8 caractères'], 400);
            }
            $user->setPassword($encoder->hashPassword($user, $password));
        }

        $entityManager->flush();

        return $this->json(['message' => 'User updated with success', 'data' => [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),

            'password' => $user->getpassword(),
            'roles' => $user->getRoles(),
            'notfication' => $user->isNotfication(),

        ]]);
    }


    //update les roles comme admin
    #[Route('/updateRole/{id}', name: 'Roles-update', methods: ['PUT', 'PATCH'])]
    public function updateRoles(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $id]);

        if (!$user) {
            return $this->json(['message' => 'User not found'], 404);
        }

        $user->setRoles(['ADMIN']);
        $entityManager->flush();

        return $this->json([
            'message' => 'User updated with success',
            'data' => [
                'roles' => $user->getRoles(),
            ]
        ]);
    }

    //annuler le role admin
    #[Route('/removeRole/{id}', name: 'Roles-remove', methods: ['PUT', 'PATCH'])]
    public function removeRole(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $id]);

        if (!$user) {
            return $this->json(['message' => 'User not found'], 404);
        }

        $roles = $user->getRoles();
        if (in_array('ADMIN', $roles)) {
            $key = array_search('ROLE_ADMIN', $roles);
            unset($roles[$key]);
        }

        // Filter the roles to only include 'ROLE_USER'
        $roles = ['ROLE_USER'];

        $user->setRoles($roles);
        $entityManager->flush();

        return $this->json([
            'message' => 'User updated with success',
            'data' => [
                'roles' => $user->getRoles(true),
            ]
        ]);
    }


    #[Route('/checkpassword/{email}', name: 'checkpwd', methods: 'POST')]
    public function checkpassword(Request $request, string $email, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return $this->json(['error' => sprintf('User with email "%s" not found.', $email)], 404);
        }

        $data = json_decode($request->getContent(), true);
        $password = $data['password'];

        $hashedPassword = $user->getPassword();
        if (sha1($password) !== $hashedPassword) {
            return $this->json(['status' => false, 'message' => 'Incorrect password'], 401);
        }

        return $this->json(['status' => true,
            'message' => 'Password is correct']);
    }


    #[Route("toggle-versioning/{email}", name: "user_toggle_versioning", methods: ["PUT"])]
    public function toggleVersioning(string $email, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Find the user you want to update
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Toggle the versioning status
        $user->setMailConfirmed(!$user->ismMailConfirmed());

        $entityManager->flush();

        return new Response('Versioning status updated successfully', Response::HTTP_OK);
    }

}