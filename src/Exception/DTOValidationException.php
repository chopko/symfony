<?php declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class DTOValidationException
 *
 * @author st.chopko@gmail.com
 * @package App\Exception
 * Cosmonova | Research & Development
 */
class DTOValidationException extends Exception
{
    /**
     * EntityValidationException constructor.
     *
     * @param string|ConstraintViolationListInterface $message
     * @param int                                     $code
     * @param \Throwable|null                         $previous
     */
    public function __construct($message, int $code = 0, \Throwable $previous = null)
    {
        if ($message instanceof ConstraintViolationListInterface) {
            $msg = $message->get(0)->getMessage();
        } else {
            $msg = $message;
        }

        parent::__construct($msg, $code, $previous);
    }
}
