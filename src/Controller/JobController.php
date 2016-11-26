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
        $conditions = array(
            'owner_company_id' => $app['user']['id']
        );
        $job_info_list           = $this->getJobService()->getJobList($conditions);
        $params                  = [];
        $params['job_info_list'] = $job_info_list;
        return $app['twig']->render('frontend/job/jobs.html.twig', $params);
    }

    public function view(Application $app, $id = 0)
    {
        $info                   = $this->getJobService()->viewJob($id);
        $params['job_info']     = $info['job_info'];
        $params['company_info'] = $info['company_info'];
        $params['author_info']  = $info['author_info'];
        return $app['twig']->render('frontend/job/view.html.twig', $params);
    }

    public function add(Application $app, Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = RequestToolkit::getPostData($request);

            $this->getJobService()->addJob($data, $app['user']['id']);
            return new RedirectResponse('/job/index');
        }
        $params = array();
        return $app['twig']->render('frontend/job/add.html.twig', $params);
    }

    public function edit(Application $app, $id = 0)
    {
        $info = $this->getJobService()->viewJob($id);
        if ($info['job_info']['owner_company_id'] && $app['user']['company_id'] == $info['job_info']['owner_company_id']) {
            if ($request->isMethod('POST')) {
                $data = $request->request->all();
                $this->getJobService()->editJob($id, $data, $app['user']['id']);
                return new RedirectResponse('/job/edit/'.$id);
            }
            $params['job_info']     = $info['job_info'];
            $params['company_info'] = $info['company_info'];
            $params['author_info']  = $info['author_info'];
            return $app['twig']->render('frontend/job/edit.html.twig', $params);
        } else {
            // return new RedirectResponse('/job/view/'.$id);
        }
        $params['job_info']     = $info['job_info'];
        $params['company_info'] = $info['company_info'];
        $params['author_info']  = $info['author_info'];
        return $app['twig']->render('frontend/job/edit.html.twig', $params);
    }

    protected function getJobService()
    {
        return $this->kernel->service('Neitui:JobService');
    }
}
