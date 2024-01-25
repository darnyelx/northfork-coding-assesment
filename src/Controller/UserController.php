<?php

namespace App\Controller;

use App\Command\CreateUserCommand;
use App\Command\DeleteUserCommand;
use App\Command\UpdateUserCommand;
use App\Query\GetUserListQuery;
use App\Query\GetUserQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model as NelmioModel;
use Swagger\Annotations as SWG;
use App\Entity\User;

#[Route('/api/users')]
class UserController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    #[SWG\Get(
        description: "Get the list of users",
        responses: [
            '200' => [
                'description' => 'Successful response',
                'content' => ['application/json' => [
                    'schema' => ['type' => 'array', 'items' => ['type' => 'object']],
                ]],
            ],
        ],
        tags: ['Users'],
    )]
    public function getUsers(MessageBusInterface $messageBus): JsonResponse
    {
        $query = new GetUserListQuery();
        $users = $messageBus->dispatch($query);

        return $this->json($users);
    }

    #[Route('/{id}', methods: ['GET'])]
    // #[SWG\Get(
    //     description: "Get a single user by ID",
    //     responses: [
    //         '200' => [
    //             'description' => 'Successful response',
    //             'content' => ['application/json' => [
    //                 'schema' => ['type' => 'object'],
    //             ]],
    //         ],
    //         '404' => [
    //             'description' => 'User not found',
    //             'content' => ['application/json' => []],
    //         ],
    //     ],
    //     tags: ['Users'],
    // )]
    public function getSingleUser(int $id, MessageBusInterface $messageBus): JsonResponse
    {
        $query = new GetUserQuery($id);
        $user = $messageBus->dispatch($query);

        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        return $this->json($user);
    }

    #[Route('', methods: ['POST'])]
    // #[SWG\Post(
    //     description: "Create a new user",
    //     request: @SWG\Request(
    //         description: "User data",
    //         required: true,
    //         content: @SWG\Content(
    //             mediaType: "application/json",
    //             schema: new NelmioModel (type:User::class)
    //         )
    //     ),
    //     responses: [
    //         '201' => [
    //             'description' => 'User created successfully',
    //             'content' => ['application/json' => []],
    //         ],
    //     ],
    //     tags: ['Users']
    // )]
    
    public function createUser(Request $request, MessageBusInterface $messageBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new CreateUserCommand($data['username'], $data['email'], $data['name']);
        $messageBus->dispatch($command);

        return $this->json(['message' => 'User created successfully'], 201);
    }

    // #[Route('/{id}', methods: ['PUT'])]
    // #[SWG\Put(
    //     description: "Update a user by ID",
    //     request: @SWG\Request(
    //         description: "User data",
    //         required: true,
    //         content: @SWG\Content(
    //             mediaType: "application/json",
    //             schema: new NelmioModel(type:User::class, groups:["update"])
    //         )
    //     ),
    //     responses: [
    //         '200' => [
    //             'description' => 'User updated successfully',
    //             'content' => ['application/json' => []],
    //         ],
    //     ],
    //     tags: ['Users'],
    // )]
    // public function updateUser(int $id, Request $request, MessageBusInterface $messageBus): JsonResponse
    // {
    //     $data = json_decode($request->getContent(), true);

    //     $command = new UpdateUserCommand($id, $data['username']);
    //     $messageBus->dispatch($command);

    //     return $this->json(['message' => 'User updated successfully']);
    // }

    #[Route('/{id}', methods: ['DELETE'])]
    #[SWG\Delete(
        description: "Delete a user by ID",
        responses: [
            '200' => [
                'description' => 'User deleted successfully',
                'content' => ['application/json' => []],
            ],
        ],
        tags: ['Users'],
    )]
    public function deleteUser(int $id, MessageBusInterface $messageBus): JsonResponse
    {
        $command = new DeleteUserCommand($id);
        $messageBus->dispatch($command);

        return $this->json(['message' => 'User deleted successfully']);
    }
}
