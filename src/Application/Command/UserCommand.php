<?php

declare(strict_types=1);

namespace App\Application\Command;

use MyBuilder\Bundle\CronosBundle\Annotation\Cron;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @Cron(minute="/2", noLogs=true)
 */
class UserCommand extends Command
{
//    /**
//     * @var UserManager
//     */
//    private $userManager;
//
//    public function __construct(UserManager $userManager)
//    {
//        parent::__construct();
//        $this->userManager = $userManager;
//    }

    protected function configure()
    {
        $this
            ->setName('user:create')
            ->setDescription('Create a test user.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
//        $this->userManager->recordEvent(
//            'User',
//            'Событие произошло'
//        );
    }
}