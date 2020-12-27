<?php

declare(strict_types=1);

namespace App\Application\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class UserGrandCommand extends Command
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
            ->setName('user:grand')
            ->setDescription('Grand roles to user')
            ->addArgument('email', InputArgument::REQUIRED)
            ->addArgument('roles', InputArgument::REQUIRED|InputArgument::IS_ARRAY)
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $roles = $input->getArgument('roles');
        $this->userManager->grand($email, $roles);
        $output->writeln('OK');

        return 1;
    }
}