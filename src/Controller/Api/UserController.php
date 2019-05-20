<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;

/**
 * Class UserController
 * @package App\Controller\Api
 */
class UserController extends DefaultApiController implements ClassResourceInterface
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     * @param string                $id
     *
     * @Rest\QueryParam(name="email", nullable=true)
     * @Rest\QueryParam(name="last_name", nullable=true)
     * @Rest\QueryParam(name="first_name", nullable=true)
     * @Rest\QueryParam(name="creation_date", nullable=true)
     * @Rest\QueryParam(name="state", nullable=true)
     *
     * @return View
     */
    public function getAction(ParamFetcherInterface $paramFetcher, string $id): View
    {
        return parent::getAction($paramFetcher, $id);
    }
}
