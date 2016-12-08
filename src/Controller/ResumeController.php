<?php

namespace Neitui\Controller;

use Silex\Application;
use Neitui\Common\RequestToolkit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ResumeController extends BaseController
{
    public function index(Application $app, Request $request)
    {
        $userId = $app['user']['id'];
        $basic  = $this->getUserService()->getUser($userId);
        $edu    = $this->getUserService()->getEducation($userId);
        $exp    = $this->getUserService()->getCompanies($userId);
        $resume = $this->getResumeService()->getResumeByUserId($userId);

        return $app['twig']->render('frontend/resume/view.html.twig', array(
            'basic'  => $basic,
            'edus'   => array($edu),
            'exps'   => $exp,
            'resume' => $resume
        ));
    }

    public function editBasic(Application $app, Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = RequestToolkit::getPostData($request);
            $this->getUserService()->updateUser($app['user']['id'], $data);
            return new RedirectResponse('/resume/index');
        }

        $basic = $this->getUserService()->getUser($app['user']['id']);
        return $app['twig']->render('frontend/resume/edit-basic.html.twig', array(
            'basic' => $basic
        ));
    }

    public function editEdu(Application $app, Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = RequestToolkit::getPostData($request);
            $this->getUserService()->saveEdu($app['user']['id'], $data);
            return new RedirectResponse('/resume/index');
        }

        $edu = $this->getUserService()->getEducation($app['user']['id']);
        return $app['twig']->render('frontend/resume/edit-edu.html.twig', array(
            'edu' => $edu
        ));
    }

    public function editExp(Application $app, Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = RequestToolkit::getPostData($request);
            $this->getUserService()->saveExp($app['user']['id'], $data);
            return new RedirectResponse('/resume/index');
        }

        $exp = $this->getUserService()->getCompanies($app['user']['id']);
        return $app['twig']->render('frontend/resume/edit-exp.html.twig', array(
            'exp' => empty($exp) ? array() : $exp[0]
        ));
    }

    public function editIntent(Application $app, Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = RequestToolkit::getPostData($request);
            $this->getResumeService()->saveResume($app['user']['id'], $data);
            return new RedirectResponse('/resume/index');
        }

        $resume = $this->getResumeService()->getResumeByUserId($app['user']['id']);
        return $app['twig']->render('frontend/resume/edit-intent.html.twig', array(
            'resume' => $resume
        ));
    }

    public function preview(Application $app, Request $request)
    {
        // $userId = $app['user']['id'];
        $userId = 46;
        $basic  = $this->getUserService()->getUser($userId);
        $edu    = $this->getUserService()->getEducation($userId);
        $exp    = $this->getUserService()->getCompanies($userId);
        $resume = $this->getResumeService()->getResumeByUserId($userId);
        return $app['twig']->render('frontend/resume/preview.html.twig', array(
            'basic'  => $basic,
            'edus'   => $edu,
            'exps'   => empty($exp) ? array() : $exp[0],
            'resume' => $resume
        ));
    }

    protected function getResumeService()
    {
        return $this->kernel->service('Neitui:ResumeService');
    }

    protected function getUserService()
    {
        return $this->kernel->service('Neitui:UserService');
    }
}
