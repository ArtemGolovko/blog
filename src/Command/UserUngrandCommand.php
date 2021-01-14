<?php


namespace App\Command;


use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserUngrandCommand extends Command
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->userService = new UserService($em);
    }

    protected function configure()
    {
        $this
            ->setName('user:ungrand')
            ->setDescription('Remove roles to user')
            ->addArgument('email', InputArgument::REQUIRED)
            ->addArgument('roles', InputArgument::REQUIRED|InputArgument::IS_ARRAY)
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $roles = $input->getArgument('roles');
        $result = $this->userService->ungrand(['email' => $email], $roles);
        if ($result) {
            $io->success('OK');
            return 1;
        }

        $io->error("User with email '$email' isn't exists");

        return 0;
    }
}