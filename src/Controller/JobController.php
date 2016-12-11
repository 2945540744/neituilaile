<?php

namespace Neitui\Controller;

use Silex\Application;
use Neitui\Common\RequestToolkit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class JobController extends BaseController
{
    public function index(Application $app)
    {
        $jobList = $this->getJobService()->findJobList($app['user']['id']);
        return $app['twig']->render('frontend/job/jobs.html.twig', array(
            'jobList' => $jobList
        ));
    }

    public function view(Application $app, $id = 0)
    {
        $job         = $this->getJobService()->getJob($id);
        $owner       = $this->getUserService()->getUser($job['creator']);
        $company     = $this->getJobService()->getCompany($job['company_id']);
        $user        = $app['user'];
        $isDelivered = false;
        if ($user['id'] != $job['creator']) {
            $record      = $this->getResumeService()->getDeliveryRecord($job['id'], $user['id']);
            $isDelivered = !empty($record);
        }
        return $app['twig']->render('frontend/job/view.html.twig', array(
            'job'         => $job,
            'owner'       => $owner,
            'company'     => $company,
            'user'        => $app['user'],
            'isDelivered' => $isDelivered
        ));
    }

    public function add(Application $app, Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = RequestToolkit::getPostData($request);
            $this->getJobService()->createJob($data, $app['user']['id']);
            return new RedirectResponse('/job/index');
        }
        return $app['twig']->render('frontend/job/add.html.twig', array());
    }

    public function edit(Application $app, Request $request, $id)
    {
        $job     = $this->getJobService()->getJob($id);
        $company = $this->getJobService()->getCompany($job['company_id']);
        if ($request->isMethod('POST')) {
            $data       = $request->request->all();
            $data['id'] = $id;
            $this->getJobService()->updateJob($data, $app['user']['id']);
            return new RedirectResponse('/job/view/'.$id);
        }

        return $app['twig']->render('frontend/job/edit.html.twig', array(
            'job'     => $job,
            'company' => $company
        ));
    }

    public function close(Application $app, Request $request, $id)
    {
        try {
            $this->getJobService()->closeJob($id, $app['user']['id']);
            return $this->jsonSuccess();
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    protected function getJobService()
    {
        return $this->kernel->service('Neitui:JobService');
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
