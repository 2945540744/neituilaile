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
        $jobList = $this->getJobService()->findJobs($app['user']['id']);
        return $app['twig']->render('frontend/job/jobs.html.twig', array(
            'jobList' => $jobList
        ));
    }

    public function view(Application $app, Request $request, $id = 0)
    {
        $isManager = $request->query->get('admin', 0);
        $job       = $this->getJobService()->getJob($id);
        $owner     = $this->getUserService()->getUser($job['creator']);
        $company   = $this->getJobService()->getCompany($job['company_id']);
        $user      = $app['user'];
        if (empty($user)) {
            return new RedirectResponse('/login');
        }
        $isDelivered = false;
        $isFavorited = false;
        if ($user['id'] != $job['creator']) {
            $record      = $this->getResumeService()->getDeliveryRecord($job['id'], $user['id']);
            $isDelivered = !empty($record);
            $isFavorited = $this->getJobService()->isFavorited($job['id'], $user['id']);
        }
        return $app['twig']->render('frontend/job/view.html.twig', array(
            'job'         => $job,
            'owner'       => $owner,
            'company'     => $company,
            'user'        => $app['user'],
            'isManager'   => $isManager,
            'isDelivered' => $isDelivered,
            'isFavorited' => $isFavorited
        ));
    }

    public function add(Application $app, Request $request)
    {
        $company = $this->getUserService()->getCompanyByUserId($app['user']['id']);
        if ($request->isMethod('POST')) {
            $data = RequestToolkit::getPostData($request);
            $this->getJobService()->createJob($data, $app['user']['id']);
            return new RedirectResponse('/job/index');
        }
        return $app['twig']->render('frontend/job/add.html.twig', array(
            'company' => $company
        ));
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

    public function open(Application $app, Request $request, $id)
    {
        try {
            $this->getJobService()->openJob($id, $app['user']['id']);
            return $this->jsonSuccess();
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function favorites(Application $app, Request $request)
    {
        $jobs = $this->getJobService()->getFavorites($app['user']['id']);
        return $app['twig']->render('frontend/job/favorites.html.twig', array(
            'jobs' => $jobs
        ));
    }

    public function favorite(Application $app, Request $request, $jobId, $favorite)
    {
        try {
            if ($favorite == 1) {
                $this->getJobService()->addFavorite($jobId, $app['user']['id']);
            } else {
                $this->getJobService()->removeFavorite($jobId, $app['user']['id']);
            }
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
