<?php declare(strict_types=1);

namespace App\CommandBus\Command\Classroom;

use App\CommandBus\Command\DTOInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

/**
 * Class ClassroomUpdateCommand
 * @author st.chopko@gmail.com
 */
class ClassroomUpdateCommand implements DTOInterface
{
    /**
     * @Assert\Uuid()
     * @var string
     */
    public $id;
    /**
     * @Assert\Type(
     *     type="string",
     * )
     * @Assert\Length(min="2", max="255")
     * @Groups({"classroom.update"})
     * @var string
     */
    public $name;
    /**
     * @Assert\Type(
     *     type="boolean"
     * )
     * @Groups({"classroom.update"})
     * @SWG\Property(property="is_active")
     * @var boolean
     */
    public $isActive;
}
