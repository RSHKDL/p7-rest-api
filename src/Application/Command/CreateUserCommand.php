<?php

namespace App\Application\Command;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CreateUserCommand
 * @author ereshkidal
 */
class CreateUserCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:user:create';

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * CreateUserCommand constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository $repository
     * @param null|string $name
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        UserRepository $repository,
        ?string $name = null
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->repository = $repository;
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user.')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * TODO: improve validation on username, email and password
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Bilemo user creator');
        $io->text('You are about to create a new user.');

        $username = $io->ask('Enter the username');
        $email = $io->ask('Enter the email', null, function ($email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException('✘ Invalid email');
            }
            return $email;
        });
        $plainPassword = $io->askHidden('Enter the password');
        $confirmPassword = $io->askHidden('Confirm the password');

        if ($plainPassword !== $confirmPassword) {
            $io->error('✘ The passwords don\'t match');
            return;
        }

        $role = $io->choice(
            'Select the role',
            ['ROLE_USER', 'ROLE_ADMIN'],
            'ROLE_USER'
        );

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $plainPassword));
        $user->setRoles([$role]);

        $io->text('The user credentials will be:');
        $io->listing([
            'username:' => $username,
            'email:' => $email,
            'password:' => '****',
            'role:' => $role
        ]);

        if (!$io->confirm('Confirm?', false)) {
            $io->warning('✘ User creation aborted');
            return;
        }

        $this->repository->save($user);
        $io->success('✔ User successfully created');
    }
}
