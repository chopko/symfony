<?php declare(strict_types=1);

namespace App\CommandBus\Command\Classroom;

use App\CommandBus\Command\DTOInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

/**
 * Class ClassroomCreateCommand
 * @author st.chopko@gmail.com
 */
class ClassroomCreateCommand implements DTOInterface
{
    /**
     * @Assert\Uuid()
     * @var string
     */
    public $id;
    /**
     * @Assert\Type(
     *     type="string"
     * )
     * @Assert\NotBlank(message="The name should not be blank.")
     * @Groups({"classroom.create"})
     * @Assert\Length(min="2", max="255")
     * @var string
     */
    public $name;
    /**
     * @Assert\Type(
     *     type="boolean"
     * )
     * @Assert\NotNull(message="The is_active should not be blank.")
     * @Groups({"classroom.create"})
     * @SWG\Property(property="is_active")
     * @var boolean
     */
    public $isActive;
}
