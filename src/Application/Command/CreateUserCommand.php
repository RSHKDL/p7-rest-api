<?php

namespace App\Application\Command;

use App\Domain\Entity\Manager;
use App\Domain\Entity\Retailer;
use App\Domain\Repository\ManagerRepository;
use App\Domain\Repository\RetailerRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @todo Various improvement needed (e.g. secure password, more roles, etc.)
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
     * @var RetailerRepository
     */
    private $retailerRepository;

    /**
     * @var ManagerRepository
     */
    private $managerRepository;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * CreateUserCommand constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param RetailerRepository $retailerRepository
     * @param ManagerRepository $managerRepository
     * @param ValidatorInterface $validator
     * @param null|string $name
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        RetailerRepository $retailerRepository,
        ManagerRepository $managerRepository,
        ValidatorInterface $validator,
        ?string $name = null
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->retailerRepository = $retailerRepository;
        $this->managerRepository = $managerRepository;
        $this->validator = $validator;
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user (retailer or manager).')
        ;
    }

    /**
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
        $io->title('Bilemo user creator');
        $io->text('You are about to create a new user.');

        $type = $io->choice(
            'Create a retailer or a manager',
            ['retailer', 'manager'],
            'retailer'
        );

        if ($type === 'manager') {
            $manager = new Manager();
            $manager->setEmail('admin@bilemo.fr');
            $manager->setPassword($this->passwordEncoder->encodePassword($manager, '1234'));
            $manager->setRoles(['ROLE_ADMIN']);

            $this->managerRepository->saveOrUpdate($manager);
            $io->success('✔ Manager successfully created');

            return;
        }

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

        $retailerName = $io->ask('Enter your company name', 'My Mobile Company');
        $businessIdentifierCode = $io->ask('Enter your business identifier code', '123456789');

        $role = $io->choice(
            'Select the role',
            ['ROLE_USER'],
            'ROLE_USER'
        );

        $retailer = new Retailer();
        $retailer->setEmail($email);
        $retailer->setRetailerName($retailerName);
        $retailer->setBusinessIdentifierCode($businessIdentifierCode);
        $retailer->setPassword($this->passwordEncoder->encodePassword($retailer, $plainPassword));
        $retailer->setRoles([$role]);

        $errors = $this->validateRetailer($retailer);
        if ($errors) {
            $io->error($errors);

            return;
        }

        $io->text(sprintf('The user credentials for %s will be:', $retailerName));
        $io->table(
            ['bic', 'email', 'password'],
            [
                [$businessIdentifierCode, $email, '****']
            ]
        );

        if (!$io->confirm('Confirm?', false)) {
            $io->warning('✘ Retailer creation aborted');

            return;
        }

        $this->retailerRepository->saveOrUpdate($retailer);
        $io->success('✔ Retailer successfully created');
    }

    /**
     * @param Retailer $retailer
     * @return string|null
     */
    private function validateRetailer(Retailer $retailer): ?string
    {
        $errors = $this->validator->validate($retailer, null, ['createRetailer']);

        if (count($errors) > 0) {
            return (string) $errors;
        }

        return null;
    }
}
