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
        $job     = $this->getJobService()->getJob($id);
        $company = $this->getJobService()->getCompany($job['company_id']);
        return $app['twig']->render('frontend/job/view.html.twig', array(
            'job'     => $job,
            'company' => $company,
            'user'    => $app['user']
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
            return new RedirectResponse('/job/edit/'.$id);
        }

        return $app['twig']->render('frontend/job/edit.html.twig', array(
            'job'     => $job,
            'company' => $company
        ));
    }

    protected function getJobService()
    {
        return $this->kernel->service('Neitui:JobService');
    }
}
