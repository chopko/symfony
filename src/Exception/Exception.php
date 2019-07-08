<?php declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class Exception
 *
 * @author st.chopko@gmail.com
 * @package App\Exception
 * Cosmonova | Research & Development
 */
class Exception extends \Exception implements HttpExceptionInterface
{
    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return 400;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return [];
    }
}
