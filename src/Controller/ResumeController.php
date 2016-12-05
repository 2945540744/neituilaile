<?php

namespace Neitui\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Neitui\Exception\InvalidArgumentException;

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
            'edus'   => $edu,
            'exps'   => $exp,
            'resume' => $resume
        ));
    }

    public function editBasic(Application $app, Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = RequestToolkit::getPostData($request);
            $this->getUserService()->updateUser($data['id'], $data);
            return new RedirectResponse('/resume/edit/basic');
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
            $this->getUserService()->saveEdu($data['id'], $data);
            return new RedirectResponse('/resume/edit/edu');
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
            $this->getUserService()->saveExp($data['id'], $data);
            return new RedirectResponse('/resume/edit/exp');
        }

        $exp = $this->getUserService()->getCompanies($app['user']['id']);
        return $app['twig']->render('frontend/resume/edit-exp.html.twig', array(
            'exp' => $exp
        ));
    }

    public function editIntent(Application $app, Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = RequestToolkit::getPostData($request);
            $this->getUserService()->saveExp($data['id'], $data);
            return new RedirectResponse('/resume/edit/exp');
        }

        $exp = $this->getUserService()->getCompanies($app['user']['id']);
        return $app['twig']->render('frontend/resume/edit-exp.html.twig', array(
            'exp' => $exp
        ));
    }

    public function info(Application $app, Request $request, $type = '', $id = 0)
    {
        $user_id = (int) $app['user']->id;
        if ($request->isMethod('POST')) {
            $redirect = '';
            $render   = '';
            $data     = $request->request->all();
            switch ($type) {
                case 'exp':
                    if ($id) {
                        $this->getUserService()->updateCompany($id, $data);
                    } else {
                        $this->getUserService()->createCompany($user_id, $data);
                    }
                    break;
                case 'edu':
                    if ($id) {
                        $this->getUserService()->updateEducation($id, $data);
                    } else {
                        $this->getUserService()->createEducation($user_id, $data);
                    }
                    break;
                case 'basic':
                default:
                    if ($id) {
                        $this->getResumeService()->updateResume($id, $data, $user_id);
                    } else {
                        $this->getResumeService()->createResume($user_id, $data);
                    }
                    break;
            }
            return new RedirectResponse('/resume/info/'.$type.'/'.$id);
        } else {
            switch ($type) {
                case 'exp':
                    $info = $this->getUserService()->getCompanyById($id, $user_id);
                    break;
                case 'edu':
                    $info = $this->getUserService()->getEducationById($id, $user_id);
                    break;
                case 'basic':
                default:
                    $info = $this->getResumeService()->getResumeInfo($user_id);
                    break;
            }
            return $app['twig']->render('frontend/resume/'.$type.'.html.twig', $info);
        }
    }

    public function edit(Application $app, Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $this->trySaveResumePart($data);
            // return xxx;
        }

        $part = $request->query->get('part', 'basic');

        return $app['twig']->render('frontend/resume/edit-'.$part.'.html.twig', array(
            // params: ..user,basic
        ));
    }

    public function preview(Application $app, Request $request)
    {
        return $app['twig']->render('frontend/resume/preview.html.twig', array(
            // params: resume info
        ));
    }

    public function delete(Application $app, Request $request)
    {
        $part = $request->request->get('part');
        $id   = $request->request->get('id');
        $this->tryDeleteResumePart($id, $part);
        return $app['twig']->render('frontend/resume/edit-'.$part.'.html.twig', array(
            // params: ..user,basic
        ));
    }

    public function trySaveResumePart($data)
    {
        //TODO 查询用户已有简历，没有就先新建一份；
        $part = empty($data['part']) ? '' : $data['part'];
        switch ($part) {
            case 'basic':
                //
                break;
            case 'edu':
                //
                break;
            case 'exp':
                //
                break;
            case 'intent':
                //
                break;
            default:
                throw new InvalidArgumentException('参数非法');
        }
    }

    public function tryDeleteResumePart($id, $part)
    {
        //TODO 判断该id是否属于当前用户；
        $userId = $app['user']['id'];

        if (!in_array($part, array('basic', 'edu', 'exp', 'intent'))) {
            throw new InvalidArgumentException('参数非法');
        }
        //TODO delete resume info by part.
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
