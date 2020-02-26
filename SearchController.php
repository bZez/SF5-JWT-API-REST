<?php

namespace App\Controller\Data\VYV;

use App\Helper\Api;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

/**
 * Search helps you to find user from multiple criteria
 */
class SearchController extends AbstractController
{
    private $request;
    private $api;
    private $data;

    /**
     * CredentialController constructor.
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->request = Request::createFromGlobals();
        $this->api = $api;
        $this->data = [
            'organisation' => 'Vyv',
            'controller' => 'AssureController',
            'action' => ''
        ];
    }

    /**
     * @param $searchValue mixed User(details)
     * @return JsonResponse
     * @api /searchs/insured
     * @method POST
     * @example Get a list of insured from sending value (e.g Mobile, Name, City, etc...)
     */
    public function insured()
    {
        $this->data['action'] = 'list';
        if (!$this->request->isMethod('POST'))
            throw new MethodNotAllowedException(['POST'], 'Unallowed method...');
        $this->data['search'] = $_POST['searchValue'];
        $result = $this->api->get($this->data);
        return $this->json($result);
    }
}
