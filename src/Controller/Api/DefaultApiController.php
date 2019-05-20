<?php

namespace App\Controller\Api;

use App\Repository\DefaultRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializerBuilder;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractApiController
 * @package App\Controller\Api
 */
abstract class DefaultApiController extends AbstractFOSRestController
{
    use LoggerAwareTrait;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var DefaultRepositoryInterface
     */
    protected $repository;

    /**
     * @var string
     */
    protected $formTypeClass;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * BaseApiController constructor.
     *
     * @param LoggerInterface        $logger
     * @param EntityManagerInterface $entityManager
     * @param string                 $entityClass
     * @param string                 $formTypeClass
     */
    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $entityManager,
        string $entityClass,
        string $formTypeClass)
    {
        $this->setLogger($logger);

        $this->entityManager = $entityManager;
        $this->repository    = $entityManager->getRepository($entityClass);
        $this->formTypeClass = $formTypeClass;
        $this->entityClass   = $entityClass;
    }

    /**
     * @param ParamFetcherInterface $paramFetcher
     * @param string       $id
     *
     * @return View
     */
    public function getAction(ParamFetcherInterface $paramFetcher, string $id): View
    {
        $params = array_merge(['id' => $id], $this->filterQueryParams($paramFetcher));

        return $this->view(
            $this->repository->findOneBy($params)
        );
    }

    /**
     * @return View
     */
    public function cgetAction(): View
    {
        return $this->view(
            $this->repository->findAll()
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request): Response
    {
        $form = $this->createForm($this->formTypeClass, new $this->entityClass());

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $this->handleView(
                $this->view($form)
            );
        }

        $entity = $form->getData();

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush($entity);
        } catch (ORMException $e) {
        }

        return $this->handleView(
            $this->view(
                [
                    'status' => 'ok',
                ],
                Response::HTTP_CREATED
            )
        );
    }

    /**
     * @param Request $request
     * @param string  $id
     *
     * @return View
     */
    public function putAction(Request $request, string $id): View
    {
        $entity = $this->repository->find($id);
        $form   = $this->createForm($this->formTypeClass, $entity);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $this->view($form);
        }

        try {
            $this->entityManager->flush($form->getData());
        } catch (OptimisticLockException|ORMException $e) {
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function cputAction(Request $request): View
    {
        $data         = $request->request->all();
        $filterParams = $data['filter_params'];
        $dataToUpdate = $data['data'];
        $errorForms   = [];

        foreach ($this->repository->findByWithJoins($filterParams) as $entity) {
            $form = $this->createForm($this->formTypeClass, $entity);

            $form->submit(array_merge($this->convertEntityToArray($entity), $dataToUpdate));

            if (!$form->isValid()) {
                $errorForms[] = $form;
            }
        }

        if ($errorForms) {
            return $this->view($errorForms);
        }

        try {
            $this->entityManager->flush();
        } catch (OptimisticLockException|ORMException $e) {
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return array
     */
    protected function filterQueryParams(ParamFetcherInterface $paramFetcher): array
    {
        $params = array_filter($paramFetcher->all(), static function ($elem) {
            return $elem !== null;
        });

        return $params;
    }

    /**
     * @param $entity
     *
     * @return mixed
     */
    protected function convertEntityToArray($entity)
    {
        $serializer = SerializerBuilder::create()->build();

        return json_decode($serializer->serialize($entity, 'json'), true);
    }
}

