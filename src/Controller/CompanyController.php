<?php

namespace Neitui\Controller;

use Silex\Application;
use Neitui\Common\RequestToolkit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CompanyController extends BaseController
{
    public function view(Application $app, Request $request)
    {
        $cid     = $request->query->get('cid', 0);
        $user    = $app['user'];
        $company = array();
        $owner   = false;
        if ($cid <= 0) {
            if (empty($user)) {
                return new RedirectResponse('/error/403');
            }
            $owner   = true;
            $company = $this->getUserService()->getCompanyByUserId($user['id']);
        } else {
            $company = $this->getUserService()->getCompany($cid);
        }

        return $app['twig']->render('frontend/company/view.html.twig', array(
            'company' => $company,
            'owner'   => $owner
        ));
    }

    public function edit(Application $app, Request $request)
    {
        $user = $app['user'];
        if ($request->isMethod('POST')) {
            $data = RequestToolkit::getPostData($request);
            $this->getUserService()->saveCompany($user['id'], $data);
            return new RedirectResponse('/company/edit');
        }
        $company = $this->getUserService()->getCompanyByUserId($user['id']);
        return $app['twig']->render('frontend/company/edit.html.twig', array(
            'company' => $company
        ));
    }

    protected function getUserService()
    {
        return $this->kernel->service('Neitui:UserService');
    }
}
