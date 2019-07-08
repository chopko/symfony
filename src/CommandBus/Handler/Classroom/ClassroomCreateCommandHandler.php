<?php declare(strict_types=1);

namespace App\CommandBus\Handler\Classroom;

use App\CommandBus\Command\Classroom\ClassroomCreateCommand;
use App\Entity\Classroom;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ClassroomCreateCommandHandler
 * @author st.chopko@gmail.com
 */
class ClassroomCreateCommandHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ClassroomCreateCommandHandler constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param ClassroomCreateCommand $command
     * @throws \Exception
     */
    public function __invoke(ClassroomCreateCommand $command)
    {
        $classroom = new Classroom();
        $classroom->setId($command->id);
        $classroom->setName($command->name);
        $classroom->setIsActive($command->isActive);
        $classroom->setCreatedAt(new \DateTimeImmutable("now"));

        $this->em->persist($classroom);
        $this->em->flush();
    }
}
