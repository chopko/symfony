<?php declare(strict_types=1);

namespace App\CommandBus\Handler\Classroom;

use App\CommandBus\Command\Classroom\ClassroomRemoveCommand;
use App\Repository\ClassroomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ClassroomRemoveCommandHandler
 * @author st.chopko@gmail.com
 */
class ClassroomRemoveCommandHandler
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
     * ClassroomRemoveCommandHandler constructor.
     * @param EntityManagerInterface $em
     * @param ClassroomRepository $repository
     */
    public function __construct(EntityManagerInterface $em, ClassroomRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @param ClassroomRemoveCommand $command
     */
    public function __invoke(ClassroomRemoveCommand $command)
    {
        $classroom = $this->repository->find($command->id);

        if (null === $classroom) {
            throw new NotFoundHttpException("Classroom not found");
        }

        $this->em->remove($classroom);
        $this->em->flush();
    }
}