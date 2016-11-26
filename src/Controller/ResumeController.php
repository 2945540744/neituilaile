<?php

namespace Neitui\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Neitui\Exception\InvalidArgumentException;

class ResumeController extends BaseController
{
    public function index(Application $app, Request $request)
    {
        $info = $this->getResumeService()->getResume($app['user']->id);

        $params['company_list']   = $info['company_list']; //工作经历
        $params['education_list'] = $info['education_list']; //教育经历
        $params['basic_info']     = $info['basic_info']; //基本信息
        return $this->render('frontend/resume/view.html.twig', $params);
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
            return $this->render('frontend/resume/'.$type.'.html.twig', $info);
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

        return $this->render('frontend/resume/edit-'.$part.'.html.twig', array(
            // params: ..user,basic
        ));
    }

    public function preview(Application $app, Request $request)
    {
        return $this->render('frontend/resume/preview.html.twig', array(
            // params: resume info
        ));
    }

    public function delete(Application $app, Request $request)
    {
        $part = $request->request->get('part');
        $id   = $request->request->get('id');
        $this->tryDeleteResumePart($id, $part);
        return $this->render('frontend/resume/edit-'.$part.'.html.twig', array(
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
