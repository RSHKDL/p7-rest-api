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
            if (!preg_match(
                '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD',
                $email
            )) {
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
