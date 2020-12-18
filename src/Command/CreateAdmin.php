<?php


namespace App\Command;


use App\Entity\User;
use App\Services\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdmin extends Command
{
    public static $defaultName = 'app:create-admin';

    /**
     * @var UserService $userService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();

        $this->setDescription('Create a new admin')->setHelp('This command allows your to create new admin');

        $this->addArgument('username', InputArgument::REQUIRED, 'The username of the admin');

        $this->addArgument('password', InputArgument::REQUIRED, 'Password');

        $this->addArgument('firstname', InputArgument::REQUIRED, 'The firstname of the admin');

        $this->addArgument('lastname', InputArgument::REQUIRED, 'The lastname of the admin');

        $this->addArgument('dateOfBirth', InputArgument::REQUIRED, 'The date of the birth of the admin');

        $this->addArgument('email', InputArgument::REQUIRED, 'The email of the admin');

        $this->addArgument('contact', InputArgument::REQUIRED, 'The contact of the admin');

        $this->addArgument('apiToken', InputArgument::REQUIRED, 'The apiToken of the admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['Admin creator', '==============']);
        $output->writeln('Admin username: ' . $input->getArgument('username'));
        $output->writeln('Admin password: ' . $input->getArgument('password'));

        $user = new User();
        $user->setUsername($input->getArgument('username'));
        $user->setPassword($input->getArgument('password'));
        $user->setFirstName($input->getArgument('firstname'));
        $user->setLastName($input->getArgument('lastname'));
        $user->setEmail($input->getArgument('email'));
        $user->setContact($input->getArgument('contact'));
        $user->setApiToken($input->getArgument('apiToken'));
        $user->setDateOfBirth(new \DateTime($input->getArgument('dateOfBirth')));
        $user->setRoles(["ROLE_ADMIN"]);

        $this->userService->createUser($user);

        $output->writeln('Admin created');

        parent::execute($input, $output);
        return Command::SUCCESS;
    }

}