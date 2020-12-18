<?php


namespace App\Controller\Api;


use App\Entity\User;
use App\Services\UserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @var UserService $userService
     */
    protected $userService;

    /**
     * RegistrationController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route ("/register", name="api_register", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function register(Request $request): Response
    {
        $user = new User();
        $user->setUsername($request->get('username'));
        $user->setPassword($request->get('password'));
        $user->setFirstName($request->get('firstname'));
        $user->setLastName($request->get('lastname'));
        $user->setDateOfBirth(new \DateTime($request->get('dateOfBirth')));
        $user->setEmail($request->get('email'));
        $user->setContact($request->get('contact'));
        $user->setApiToken('dd123');

        if ($user !== null) {
            $this->userService->createUser($user);
            return new Response('Success');
        } else {
            throw new BadRequestException();
        }
    }

}