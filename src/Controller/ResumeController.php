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
        $exp    = $this->getUserService()->getExperiences($userId);
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

        $exp = $this->getUserService()->getExperiences($app['user']['id']);
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
        $exp    = $this->getUserService()->getExperiences($userId);
        $resume = $this->getResumeService()->getResumeByUserId($userId);
        return $app['twig']->render('frontend/resume/preview.html.twig', array(
            'basic'  => $basic,
            'edus'   => $edu,
            'exps'   => empty($exp) ? array() : $exp[0],
            'resume' => $resume
        ));
    }

    public function delivery(Application $app, Request $request, $jobId)
    {
        //获取当前用户的简历，投递给指定的job
        $user = $app['user'];
        try {
            $this->getResumeService()->deliveryResume($jobId, $user['id']);
            return $this->jsonSuccess();
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function resumes(Application $app, Request $request)
    {
        $company = $this->getUserService()->getCompanyByUserId($app['user']['id']);
        // var_dump($company);exit();
        $resumes = $this->getResumeService()->findDeliveredResumes($company['id']);

        return $app['twig']->render('frontend/resume/resumes.html.twig', array(
            'resumes' => $resumes
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
