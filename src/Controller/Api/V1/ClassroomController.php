<?php declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\CommandBus\Command\Classroom\ClassroomCreateCommand;
use App\CommandBus\Command\Classroom\ClassroomRemoveCommand;
use App\CommandBus\Command\Classroom\ClassroomUpdateCommand;
use App\Repository\ClassroomRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use Ramsey\Uuid\Uuid;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClassroomController
 * @author st.chopko@gmail.com
 *
 * @Route(name="api_v1_classrooms_", path="/api/v1/classrooms")
 */
class ClassroomController extends AbstractController
{
    /**
     * Get classroom list
     * @Route(name="list", path="", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Get classroom list",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=App\Entity\Classroom::class, groups={"classrooms"}))
     *     )
     * )
     * @param ClassroomRepository $repository
     * @return JsonResponse
     */
    public function list(ClassroomRepository $repository): JsonResponse
    {
        return $this->json(
            $repository->findAll(),
            Response::HTTP_OK,
            [],
            ['groups' => ['classrooms']]
        );
    }

    /**
     * Get classroom by id
     * @Route(name="view", path="/{id}", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Get classroom by id",
     *     @Model(type=App\Entity\Classroom::class, groups={"classroom"})
     * )
     * @param ClassroomRepository $repository
     * @param string $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function view(string $id, ClassroomRepository $repository): JsonResponse
    {
        if (!Uuid::isValid($id)) {
            throw new NotFoundHttpException("Classroom not found");
        }

        $classroom = $repository->find($id);
        if (null === $classroom) {
            throw new NotFoundHttpException("Classroom not found");
        }

        return $this->json($classroom, Response::HTTP_OK,
            [],
            ['groups' => ['classrooms']]);
    }

    /**
     * Create classroom
     * @Route(name="create", path="", methods={"POST"})
     * @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          @Model(type=App\CommandBus\Command\Classroom\ClassroomCreateCommand::class, groups={"classroom.create"})
     * ),
     * @SWG\Response(
     *     response=201,
     *     description="Create classroom",
     *     @Model(type=App\Entity\Classroom::class, groups={"classroom"})
     * )
     * @param ClassroomRepository $repository
     * @param ClassroomCreateCommand $command
     * @param CommandBus $commandBus
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(ClassroomRepository $repository, ClassroomCreateCommand $command, CommandBus $commandBus): JsonResponse
    {
        $command->id = Uuid::uuid4()->toString();
        $commandBus->handle($command);

        return $this->json($repository->find($command->id), Response::HTTP_CREATED,
            [],
            ['groups' => ['classroom']]);
    }

    /**
     * Update classroom by id
     * @Route(name="update", path="/{id}", methods={"PUT"})
     * @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          @Model(type=App\CommandBus\Command\Classroom\ClassroomUpdateCommand::class, groups={"classroom.update"})
     * ),
     * @SWG\Response(
     *     response=201,
     *     description="Update classroom by id",
     *     @Model(type=App\Entity\Classroom::class, groups={"classroom"})
     * )
     * @param string $id
     * @param ClassroomRepository $repository
     * @param ClassroomUpdateCommand $command
     * @param CommandBus $commandBus
     * @return JsonResponse
     */
    public function update(string $id, ClassroomRepository $repository, ClassroomUpdateCommand $command, CommandBus $commandBus): JsonResponse
    {
        if (!Uuid::isValid($id)) {
            throw new NotFoundHttpException("Classroom not found");
        }

        $command->id = $id;
        $commandBus->handle($command);

        return $this->json($repository->find($command->id), Response::HTTP_CREATED,
            [],
            ['groups' => ['classroom']]);
    }

    /**
     * Remove classroom by id
     * @Route(name="delete", path="/{id}", methods={"DELETE"})
     * @SWG\Response(
     *     response=204,
     *     description="Remove classroom by id",
     * )
     * @param string $id
     * @param CommandBus $commandBus
     * @return JsonResponse
     */
    public function remove(string $id, CommandBus $commandBus): JsonResponse
    {
        if (!Uuid::isValid($id)) {
            throw new NotFoundHttpException("Classroom not found");
        }
        $command = new ClassroomRemoveCommand();
        $command->id = $id;
        $commandBus->handle($command);

        return $this->json(null, Response::HTTP_NO_CONTENT,
            [],
            ['groups' => ['classroom']]);
    }
}
