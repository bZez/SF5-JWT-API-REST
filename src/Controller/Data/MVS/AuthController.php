<?php

namespace App\Controller\Data\MVS;

use App\Helper\Api;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

/**
 * Auths is to be used for authentication, credentials update or password recovery
 */
class AuthController extends AbstractController
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
            'organisation' => 'Sites',
            'controller' => 'MvsActionController',
            'action' => ''
        ];
    }

    /**
     * @param $login string Login
     * @param $pwd string Password
     * @return JsonResponse
     * @api /auths/login
     * @method POST
     * @example Authenticate MVS user
     */
    public function login()
    {
        $this->data['action'] = 'MemberLogin';
        if (!$this->request->isMethod('POST'))
            throw new MethodNotAllowedException(['POST'], "Unallowed method...");
        $login = $this->request->get('login');
        $pwd = $this->request->get('pwd');
        $this->data['login'] = $login;
        $this->data['pwd'] = $pwd;
        $result = $this->api->get($this->data);
        return $this->json($result);
    }

    /**
     * @param $old string Password(old)
     * @param $new string Password(new)
     * @param $login string Username
     * @return JsonResponse
     * @api /auths/update
     * @method PUT
     * @example Update user password with User's login & Old Password
     */
    public function update()
    {
        $this->data['action'] = 'MemberChangePassword';
        if (!$this->request->isMethod('PUT'))
            throw new MethodNotAllowedException(['PUT'], 'Unallowed method...');
        parse_str(file_get_contents("php://input"), $_PUT);

        $oldPass = $_PUT['old'];
        $user = $_PUT['login'];
        $newPass = $_PUT['new'];
        $this->data['oldPassword'] = $oldPass;
        $this->data['login'] = $user;
        $this->data['newPassword'] = $newPass;
        $result = $this->api->get($this->data);
        return $this->json($result);

    }

    /**
     * @param $insee string Insee
     * @param $inseeKey string Insee(Key)
     * @return JsonResponse
     * @api /auths/forgot
     * @method POST
     * @example Launch 'forgot password' procedure
     */
    public function forgot()
    {
        $this->data['action'] = 'MemberRecoveryPassword';
        if (!$this->request->isMethod('POST'))
            throw new MethodNotAllowedException(['POST'], 'Unallowed method...');
        $insee = $this->request->get('insee');
        $inseeKey = $this->request->get('inseeKey');
        $this->data['insee'] = $insee;
        $this->data['inseekey'] = $inseeKey;
        $result = $this->api->get($this->data);
        return $this->json($result);

    }
}
