<?php

namespace App\Domain\DataFixtures;

use App\Domain\Entity\Manufacturer;
use App\Domain\Entity\Phone;
use App\Domain\Entity\Tablet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

/**
 * Class AppFixtures
 *
 * @author ereshkidal
 */
final class AppFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager):void
    {
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
            $phoneEntity->setStock(random_int(1, 20));
            $manager->persist($phoneEntity);
        }
        $tablets = $this->loadDataFixtures('tablets');
        foreach ($tablets as $model => $tablet) {
            $randManufacturerKey = array_rand($manufacturers, 1);
            $randPriceKey = array_rand($prices, 1);
            /** @var Manufacturer $manufacturer */
            $manufacturer = $this->getReference($manufacturers[$randManufacturerKey]);
            $tabletEntity = new Tablet();
            $tabletEntity->setManufacturer($manufacturer);
            $tabletEntity->setModel($tablet['model']);
            $tabletEntity->setDescription('This is a fake description from a fixture.');
            $tabletEntity->setPrice($prices[$randPriceKey]);
            $tabletEntity->setStock(random_int(1, 20));
            $manager->persist($tabletEntity);
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
