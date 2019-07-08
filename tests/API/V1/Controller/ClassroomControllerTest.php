<?php declare(strict_types=1);

namespace App\Tests\API\V1\Controller;

use App\Entity\Classroom;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ClassroomControllerTest
 * @author st.chopko@gmail.com
 */
class ClassroomControllerTest extends WebTestCase
{
    private const URI = '/api/v1/classrooms';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testCreate()
    {
        $uri = self::URI;

        $bodyData = [
            'name' => 'testName',
            'is_active' => true,
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($bodyData)
        );

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }

    public function testUpdate()
    {
        $classroom = $this->entityManager
            ->getRepository(Classroom::class)
            ->findOneBy([])
        ;

        $uri = self::URI . '/' . $classroom->getId();

        $bodyData = [
            'name' => 'testNameUpdate',
            'is_active' => false,
        ];

        $client = static::createClient();

        $client->request(
            'PUT',
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($bodyData)
        );

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }

    public function testList()
    {
        $uri = self::URI;
        $client = static::createClient();

        $client->request(
            'GET',
            $uri
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testShow()
    {
        $classroom = $this->entityManager
            ->getRepository(Classroom::class)
            ->findOneBy([])
        ;

        $uri = self::URI . '/' . $classroom->getId();

        $client = static::createClient();

        $client->request(
            'GET',
            $uri
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testDelete()
    {
        $classroom = $this->entityManager
            ->getRepository(Classroom::class)
            ->findOneBy([])
        ;

        $uri = self::URI . '/' . $classroom->getId();

        $client = static::createClient();

        $client->request(
            'DELETE',
            $uri
        );

        $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}