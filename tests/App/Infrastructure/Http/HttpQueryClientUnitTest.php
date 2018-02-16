<?php
//
//declare(strict_types=1);
//
//namespace Tests\App\Infrastructure\Http;
//
//use App\Infrastructure\Http\HttpQueryClient;
//use PHPUnit\Framework\TestCase;
//use Psr\Http\Message\ResponseInterface;
//
///**
// * @see HttpQueryClient
// */
//class HttpQueryClientUnitTest extends TestCase
//{
//    /**
//     * @var HttpQueryClient
//     */
//    private $client;
//
//    /**
//     * @var MockHttpClient
//     */
//    private $httpClient;
//
//    /**
//     * @var MockLogger
//     */
//    private $logger;
//
//    /**
//     * @test
//     */
//    public function it_can_query()
//    {
//        $this->assertInstanceOf(ResponseInterface::class, $this->client->query('/any_uri'));
//    }
//
////    /**
////     * @test
////     */
////    public function it_can_not_get_from_invalid_request()
////    {
////        $this->expectException(HttpQueryRequestIsNotValid::class);
////        $this->expectExceptionMessage('Http Query Request not valid caused by "Mock Request Exception Error".');
////
////        $this->httpClient::reset();
////        $this->httpClient::willRaisedRequestException();
////
////        $this->client->get('/any_uri');
////
////        $this->assertCount(1, $this->logger->errors());
////    }
////
////    /**
////     * @test
////     */
////    public function it_log_error_when_get_an_invalid_request()
////    {
////        try {
////            $this->client->get('/any_uri');
////        } catch (\Throwable $exception) {
////            $this->assertCount(1, $this->logger->errors());
////            $this->assertEquals('External API call fail', array_values($this->logger->errors())[0]);
////        }
////    }
////
////    /**
////     * @test
////     */
////    public function it_can_not_get_from_invalid_response()
////    {
////        $this->expectException(HttpQueryResponseIsNotValid::class);
////        $this->expectExceptionMessage('Http Query Response not valid caused by "Status code 500 invalid.".');
////
////        $this->httpClient::reset();
////        $this->httpClient::willRespondNotOkStatusResponse();
////
////        $this->client->get('/any_uri');
////    }
//
//    /**
//     * {@inheritdoc}
//     */
//    protected function setUp()
//    {
//        parent::setUp();
//
//        $this->client     = new HttpQueryClient();
//        $this->logger     = new MockLogger();
//
//        $this->client->setLogger($this->logger);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    protected function tearDown()
//    {
//        $this->client     = null;
//        $this->httpClient = null;
//        $this->logger     = null;
//
//        parent::tearDown();
//    }
//}
