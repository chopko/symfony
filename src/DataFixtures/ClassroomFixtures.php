<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Classroom;
use Ramsey\Uuid\Uuid;

class ClassroomFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i <=10; $i++){
            $classroom = new Classroom();
            $classroom->setId(Uuid::uuid4()->toString());
            $classroom->setName("testClassroom".$i);
            $classroom->setIsActive(true);
            $classroom->setCreatedAt(new \DateTimeImmutable("NOW"));
            $manager->persist($classroom);
        }

        $manager->flush();
    }
}
