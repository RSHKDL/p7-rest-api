<?php

namespace App\Domain\DataFixtures;

use App\Domain\Entity\Manufacturer;
use App\Domain\Entity\Phone;
use App\Domain\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class AppFixtures
 *
 * @author ereshkidal
 */
class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $users = $this->loadDataFixtures('users');
        foreach ($users as $username => $user) {
            $userEntity = new User();
            $userEntity->setUsername($user['username']);
            $userEntity->setEmail($user['email']);
            $userEntity->setPassword($this->passwordEncoder->encodePassword($userEntity, '1234'));
            $userEntity->setRoles($user['roles']);
            $manager->persist($userEntity);
            $this->addReference($username, $userEntity);
        }

        $manufacturers = $this->loadDataFixtures('manufacturers');
        foreach ($manufacturers as $name => $manufacturer) {
            $manufacturerEntity = new Manufacturer(
                $manufacturer['name']
            );
            $manager->persist($manufacturerEntity);
            $this->addReference($name, $manufacturerEntity);
        }

        $prices = [299,399,499,799,999];
        $manufacturers = ['manufacturer_0','manufacturer_1','manufacturer_2'];

        $phones = $this->loadDataFixtures('phones');
        foreach ($phones as $model => $phone) {
            $randManufacturerKey = array_rand($manufacturers, 1);
            $randPriceKey = array_rand($prices, 1);
            /** @var Manufacturer $manufacturer */
            $manufacturer = $this->getReference($manufacturers[$randManufacturerKey]);
            $phoneEntity = new Phone();
            $phoneEntity->setManufacturer($manufacturer);
            $phoneEntity->setModel($phone['model']);
            $phoneEntity->setDescription('This is a fake description from a fixture.');
            $phoneEntity->setPrice($prices[$randPriceKey]);
            $phoneEntity->setStock(rand(1, 20));
            $manager->persist($phoneEntity);
        }
        $manager->flush();
    }

    /**
     * @param $entityName
     * @return array
     */
    private function loadDataFixtures($entityName): array
    {
        return Yaml::parse(file_get_contents(__DIR__.'/Fixtures/'. $entityName .'.yaml', true));
    }
}
