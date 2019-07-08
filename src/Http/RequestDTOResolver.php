<?php declare(strict_types=1);

namespace App\Http;

use App\CommandBus\Command\DTOInterface;
use App\Exception\DTOValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RequestDTOResolver
 *
 * @author st.chopko@gmail.com
 * @package App\ArgumentResolver
 * Cosmonova | Research & Development
 */
class RequestDTOResolver implements ArgumentValueResolverInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * RequestDTOResolver constructor.
     *
     * @param ValidatorInterface  $validator
     * @param SerializerInterface $serializer
     */
    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * @param Request          $request
     * @param ArgumentMetadata $argument
     *
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (\in_array($argument->getType(), ['int', 'string', null])) {
            return false;
        }

        $reflection = new \ReflectionClass($argument->getType());

        if ($reflection->implementsInterface(DTOInterface::class)) {
            return true;
        }

        return false;
    }

    /**
     * @param Request          $request
     * @param ArgumentMetadata $argument
     *
     * @return \Generator
     * @throws DTOValidationException
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $class = $argument->getType();

        $dto = $this->serializer->deserialize($request->getContent(), $class, 'json');

        $errors = $this->validator->validate($dto);

        if (\count($errors) > 0) {
            throw new DTOValidationException($errors);
        }

        yield $dto;
    }
}