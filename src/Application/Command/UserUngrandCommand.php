<?php


namespace App\Application\Command;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserUngrandCommand extends Command
{
    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->userManager = new UserManager($em);
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
        $email = $input->getArgument('email');
        $roles = $input->getArgument('roles');
        $this->userManager->ungrand($email, $roles);
        $output->writeln('OK');

        return 1;
    }
}