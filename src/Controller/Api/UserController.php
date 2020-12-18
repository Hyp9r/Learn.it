<?php


namespace App\Controller\Api;

use App\Services\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;

/**
 * Class UserController
 * @package App\Controller\Api
 * @Route("/api/user", name="api_users")
 */
class UserController
{

    /**
     * @var UserService $userService
     */
    protected $userService;

    /**
     * @var SerializerInterface $serializer
     */
    private $serializer;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @Route("/{id}", name="api_user")
     * @param int $id
     * @return JsonResponse
     */
    public function getUser(int $id): JsonResponse
    {
        $user = $this->userService->getUser($id);
        $response = $this->serializer->serialize($user, 'json');
        return new JsonResponse($response, 200, [], true);
    }

    /**
     * @Route ("s", name="api_all_users")
     * @return JsonResponse
     */
    public function getAllUsers(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        $response = $this->serializer->serialize($users, 'json');
        return new JsonResponse($response, 200, [], true);
    }
}