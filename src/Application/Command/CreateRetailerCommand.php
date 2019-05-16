<?php

namespace App\Application\Command;

use App\Domain\Entity\Retailer;
use App\Domain\Repository\RetailerRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CreateRetailerCommand
 * @author ereshkidal
 */
class CreateRetailerCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:retailer:create';

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var RetailerRepository
     */
    private $repository;

    /**
     * CreateRetailerCommand constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param RetailerRepository $repository
     * @param null|string $name
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        RetailerRepository $repository,
        ?string $name = null
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->repository = $repository;
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Creates a new retailer.')
            ->setHelp('This command allows you to create a retailer (user).')
        ;
    }

    /**
     * @todo improve validation on email and password
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Bilemo retailer creator');
        $io->text('You are about to create a new retailer.');

        $email = $io->ask('Enter the email', null, static function ($email) {
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

        $retailerName = $io->ask('Enter your company name');
        $businessIdentifierCode = $io->ask('Enter your business identifier code');

        $role = $io->choice(
            'Select the role',
            ['ROLE_USER', 'ROLE_ADMIN'],
            'ROLE_USER'
        );

        $retailer = new Retailer();
        $retailer->setEmail($email);
        $retailer->setRetailerName($retailerName);
        $retailer->setBusinessIdentifierCode($businessIdentifierCode);
        $retailer->setPassword($this->passwordEncoder->encodePassword($retailer, $plainPassword));
        $retailer->setRoles([$role]);

        $io->text('The user credentials will be:');
        $io->listing([
            'email:' => $email,
            'password:' => '****',
            'role:' => $role,
            'company name' => $retailerName,
            'bic' => $businessIdentifierCode
        ]);

        if (!$io->confirm('Confirm?', false)) {
            $io->warning('✘ Retailer creation aborted');
            return;
        }

        $this->repository->save($retailer);
        $io->success('✔ Retailer successfully created');
    }
}
