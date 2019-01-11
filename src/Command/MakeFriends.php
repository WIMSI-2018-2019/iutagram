<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeFriends extends Command
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setName('user:make-friends')
            ->setDescription('Make random follows between users');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var User[] $users */
        $users = $this->userRepository->findAll();

        foreach ($users as $user) {
            $user->setFollows(
                array_map(
                    function (int $index) use ($users) { return $users[$index]; },
                    (array) array_rand(
                        array_filter(
                            $users,
                            function(User $filtered) use ($user) { return $filtered->getId() !== $user->getId(); }
                        ),
                        mt_rand(1, count($users) - 1)
                    )
                )
            );
        }

        $this->entityManager->flush();
    }
}
