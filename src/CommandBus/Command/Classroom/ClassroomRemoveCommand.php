<?php declare(strict_types=1);

namespace App\CommandBus\Command\Classroom;

use App\CommandBus\Command\DTOInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ClassroomRemoveCommand
 * @author st.chopko@gmail.com
 */
class ClassroomRemoveCommand implements DTOInterface
{
    /**
     * @Assert\Uuid()
     * @var string
     */
    public $id;
}
