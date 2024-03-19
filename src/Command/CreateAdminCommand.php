<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Create a User with role ROLE_ADMIN and the credentials submitted.',
    hidden: false,
)]
class CreateAdminCommand extends Command
{

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface      $entityManager,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'Provide a mail for the Admin:', 'admin@admin.com')
            ->addArgument('password', InputArgument::OPTIONAL, 'Provide a password for the Admin:', 'admin');
    }

    /**
     * @throws ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->text('Create an user a User with ROLE_ADMIN and persist it');


        $email = $io->ask('L\'adresse e-mail de votre User :',
            'admin@admin.com',
            function (string $email): string {

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new \RuntimeException('L\'email n\'est pas valide.');

                } else if ($this->entityManager->getRepository(User::class)->findOneBy(['email' => $email])) {
                    throw new \RuntimeException('L\'email est deja utilisé.');
                }

                return $email;
            });

        $password = $io->askHidden('Le mot de passe ', function (?string $pass): string {

            if (strlen($pass) < 5) {
                throw new \RuntimeException('Le mot de passe doit contenir 5 caractères minimum.');
            }
            return $pass;
        });

        $user = new User();
        $user->setEmail($email);
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));
        $this->entityManager->persist($user);
        $this->entityManager->flush();


        $io->success('Success your new Admin is ready !');

        return Command::SUCCESS;
    }
}
