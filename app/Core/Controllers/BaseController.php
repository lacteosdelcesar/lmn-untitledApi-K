<?php
/**
 * Created by tav0
 * Date: 9/04/16
 * Time: 08:48 PM
 */

namespace App\Core\Controllers;


use Bosnadev\Repositories\Eloquent\Repository;
use Dingo\Api\Routing\Helpers;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;
use Laravel\Lumen\Routing\Controller;

class BaseController extends Controller
{
    use Helpers;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * BaseController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->makeRequest();
        if($this->repository()) {
            $this->makeRepository();
        }
    }

    protected function repository()
    {
        return null;
    }

    /**
     * @return Repository
     * @throws RepositoryException
     */
    public function makeRepository()
    {
        $repository = $this->container->make($this->repository());

        if (!$repository instanceof Repository)
            throw new RepositoryException("Class {$this->repository()} must be an instance of ".Repository::class);

        return $this->repository = $repository;
    }

    /**
     * @return Request
     */
    public function makeRequest()
    {
        return $this->request = $this->container->make(Request::class);
    }

    /**
     * @param string $message
     * @return mixed
     */
    protected function errorBadRequest($message = '')
    {
        return $this->response->array($message)->setStatusCode(Response::HTTP_BAD_REQUEST);
    }

    protected function errorValidator(MessageBag $messageBag)
    {
        $arrMesages = [];
        foreach ($messageBag->toArray() as $messages) {
            foreach ($messages as $message) {
                $arrMesages[] = $message;
            }
        }
        return $this->errorBadRequest(['error' => $arrMesages]);
    }
}