<?php declare(strict_types=1);

namespace App\CommandBus\Handler\Classroom;

use App\CommandBus\Command\Classroom\ClassroomUpdateCommand;
use App\Repository\ClassroomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ClassroomUpdateCommandHandler
 * @author st.chopko@gmail.com
 */
class ClassroomUpdateCommandHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ClassroomRepository
     */
    private $repository;

    /**
     * ClassroomUpdateCommandHandler constructor.
     * @param EntityManagerInterface $em
     * @param ClassroomRepository $repository
     */
    public function __construct(EntityManagerInterface $em, ClassroomRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @param ClassroomUpdateCommand $command
     */
    public function __invoke(ClassroomUpdateCommand $command)
    {
        $classroom = $this->repository->find($command->id);

        if (null === $classroom) {
            throw new NotFoundHttpException("Classroom not found");
        }

        if (null !== $command->name) {
            $classroom->setName($command->name);
        }

        if (null !== $command->isActive) {
            $classroom->setIsActive($command->isActive);
        }

        $this->em->persist($classroom);
        $this->em->flush();
    }
}