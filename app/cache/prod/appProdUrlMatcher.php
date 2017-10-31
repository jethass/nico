<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // home
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'home');
            }

            return array (  '_controller' => 'Nicorette\\FrontBundle\\Controller\\DefaultController::indexAction',  '_route' => 'home',);
        }

        // user_confirmation
        if ($pathinfo === '/user-confirmation') {
            return array (  '_controller' => 'Nicorette\\FrontBundle\\Controller\\DefaultController::userConfirmationAction',  '_route' => 'user_confirmation',);
        }

        // reset_password
        if ($pathinfo === '/reset-password') {
            return array (  '_controller' => 'Nicorette\\FrontBundle\\Controller\\DefaultController::resetPasswordAction',  '_route' => 'reset_password',);
        }

        // nicorette_central_default_index
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'nicorette_central_default_index')), array (  '_controller' => 'Nicorette\\CentralBundle\\Controller\\DefaultController::indexAction',));
        }

        // import
        if ($pathinfo === '/import') {
            return array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\DefaultController::indexAction',  '_route' => 'import',);
        }

        if (0 === strpos($pathinfo, '/api')) {
            // get_quiz_by_code
            if (0 === strpos($pathinfo, '/api/quiz') && preg_match('#^/api/quiz/(?P<code>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_get_quiz_by_code;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_quiz_by_code')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\QuizesController::getQuizeAction',  '_format' => 'json',));
            }
            not_get_quiz_by_code:

            if (0 === strpos($pathinfo, '/api/user')) {
                // user_auth
                if (0 === strpos($pathinfo, '/api/user/auth') && preg_match('#^/api/user/auth(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_user_auth;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_auth')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::authUserAction',  '_format' => 'json',));
                }
                not_user_auth:

                // user_synchronize
                if (0 === strpos($pathinfo, '/api/user/save') && preg_match('#^/api/user/save/(?P<uuid>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_user_synchronize;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_synchronize')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::saveUserAction',  '_format' => 'json',));
                }
                not_user_synchronize:

                // user_forgot_authCode
                if (0 === strpos($pathinfo, '/api/user/forgot/authCode') && preg_match('#^/api/user/forgot/authCode(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_user_forgot_authCode;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_forgot_authCode')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::getForgotAuthCodeAction',  '_format' => 'json',));
                }
                not_user_forgot_authCode:

                // user_profile
                if (0 === strpos($pathinfo, '/api/user/profile') && preg_match('#^/api/user/profile(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_user_profile;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_profile')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::getUserProfileAction',  '_format' => 'json',));
                }
                not_user_profile:

                // user_update_profile
                if (0 === strpos($pathinfo, '/api/user/updateprofile') && preg_match('#^/api/user/updateprofile(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_user_update_profile;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_update_profile')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::updateUserProfileAction',  '_format' => 'json',));
                }
                not_user_update_profile:

                // user_get_verification_code
                if (0 === strpos($pathinfo, '/api/user/verificationCode') && preg_match('#^/api/user/verificationCode/(?P<uuid>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_user_get_verification_code;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_get_verification_code')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::getverificationCodeAction',  '_format' => 'json',));
                }
                not_user_get_verification_code:

            }

            if (0 === strpos($pathinfo, '/api/cities/get')) {
                // cities_get_cities_name
                if (0 === strpos($pathinfo, '/api/cities/getCities') && preg_match('#^/api/cities/getCities/(?P<zip>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_cities_get_cities_name;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'cities_get_cities_name')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::getCitiesNamesAction',  '_format' => 'json',));
                }
                not_cities_get_cities_name:

                // cities_get_zip_codes
                if (0 === strpos($pathinfo, '/api/cities/getZipCodes') && preg_match('#^/api/cities/getZipCodes/(?P<city>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_cities_get_zip_codes;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'cities_get_zip_codes')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::getZipCodesAction',  '_format' => 'json',));
                }
                not_cities_get_zip_codes:

            }

            // set_answers_for_quiz
            if (0 === strpos($pathinfo, '/api/answers') && preg_match('#^/api/answers/(?P<code>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_set_answers_for_quiz;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'set_answers_for_quiz')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\AnswersController::postAnswersAction',  '_format' => 'json',));
            }
            not_set_answers_for_quiz:

            // save_answers_for_initquiz
            if (0 === strpos($pathinfo, '/api/initquiz/answers/save') && preg_match('#^/api/initquiz/answers/save(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_save_answers_for_initquiz;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'save_answers_for_initquiz')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\AnswersController::saveAnswersAction',  '_format' => 'json',));
            }
            not_save_answers_for_initquiz:

            // number_day_without_cigarette
            if (0 === strpos($pathinfo, '/api/withoutcigarette') && preg_match('#^/api/withoutcigarette/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_number_day_without_cigarette;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'number_day_without_cigarette')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\DashboardController::getNumberDayWithoutCigaretteAction',  '_format' => 'json',));
            }
            not_number_day_without_cigarette:

            // get_dashboarddashboard
            if (0 === strpos($pathinfo, '/api/dashboard') && preg_match('#^/api/dashboard(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_get_dashboarddashboard;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_dashboarddashboard')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\DashboardController::getDashboardAction',  '_format' => 'json',));
            }
            not_get_dashboarddashboard:

            // get_statisticstatistic
            if (0 === strpos($pathinfo, '/api/statistic') && preg_match('#^/api/statistic(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_get_statisticstatistic;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_statisticstatistic')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\DashboardController::getStatisticAction',  '_format' => 'json',));
            }
            not_get_statisticstatistic:

            // nelmio_api_doc_index
            if (rtrim($pathinfo, '/') === '/api/doc') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_nelmio_api_doc_index;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'nelmio_api_doc_index');
                }

                return array (  '_controller' => 'Nelmio\\ApiDocBundle\\Controller\\ApiDocController::indexAction',  '_route' => 'nelmio_api_doc_index',);
            }
            not_nelmio_api_doc_index:

            if (0 === strpos($pathinfo, '/api/contract')) {
                // set_last_smoked_cigarette_date
                if (0 === strpos($pathinfo, '/api/contract/lastOne') && preg_match('#^/api/contract/lastOne/(?P<engaged>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_set_last_smoked_cigarette_date;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'set_last_smoked_cigarette_date')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\ContractController::lastCigaretteAction',  '_format' => 'json',));
                }
                not_set_last_smoked_cigarette_date:

                // set_quit_date
                if (preg_match('#^/api/contract/(?P<angajed>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_set_quit_date;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'set_quit_date')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\ContractController::quitDateContractAction',  '_format' => 'json',));
                }
                not_set_quit_date:

            }

            // set_quit_program_nicorette
            if (0 === strpos($pathinfo, '/api/quit-program') && preg_match('#^/api/quit\\-program(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_set_quit_program_nicorette;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'set_quit_program_nicorette')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\ContractController::quitProgramAction',  '_format' => 'json',));
            }
            not_set_quit_program_nicorette:

            // user_get_contract_date
            if (0 === strpos($pathinfo, '/api/contract/info/date') && preg_match('#^/api/contract/info/date(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_user_get_contract_date;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_get_contract_date')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\ContractController::getverificationCodeAction',  '_format' => 'json',));
            }
            not_user_get_contract_date:

            // get_quiz_quit_program_
            if (0 === strpos($pathinfo, '/api/quit-nicorette-program') && preg_match('#^/api/quit\\-nicorette\\-program/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_get_quiz_quit_program_;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_quiz_quit_program_')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\ContractController::getQuitAction',  '_format' => 'json',));
            }
            not_get_quiz_quit_program_:

            if (0 === strpos($pathinfo, '/api/sponsoring')) {
                // add_new_sponsor
                if (0 === strpos($pathinfo, '/api/sponsoring/new') && preg_match('#^/api/sponsoring/new(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_add_new_sponsor;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'add_new_sponsor')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\SponsoringController::newAction',  '_format' => 'json',));
                }
                not_add_new_sponsor:

                // update_sponsor
                if (0 === strpos($pathinfo, '/api/sponsoring/update') && preg_match('#^/api/sponsoring/update/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_update_sponsor;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'update_sponsor')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\SponsoringController::updateAction',  '_format' => 'json',));
                }
                not_update_sponsor:

                // delete_sponsor
                if (0 === strpos($pathinfo, '/api/sponsoring/delete') && preg_match('#^/api/sponsoring/delete/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_delete_sponsor;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_sponsor')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\SponsoringController::deleteAction',  '_format' => 'json',));
                }
                not_delete_sponsor:

                // get_list_sponsor
                if (preg_match('#^/api/sponsoring/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_list_sponsor;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_list_sponsor')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\SponsoringController::indexAction',  '_format' => 'json',));
                }
                not_get_list_sponsor:

            }

            if (0 === strpos($pathinfo, '/api/alerts')) {
                // set_alerts_for_patient
                if (0 === strpos($pathinfo, '/api/alerts/save') && preg_match('#^/api/alerts/save/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_set_alerts_for_patient;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'set_alerts_for_patient')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\AlertsController::saveAlertsAction',  '_format' => 'json',));
                }
                not_set_alerts_for_patient:

                // update_alerts_for_patient
                if (0 === strpos($pathinfo, '/api/alerts/update') && preg_match('#^/api/alerts/update/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_update_alerts_for_patient;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'update_alerts_for_patient')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\AlertsController::updateAlertsAction',  '_format' => 'json',));
                }
                not_update_alerts_for_patient:

                // get_alerts_for_patient
                if (preg_match('#^/api/alerts/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_alerts_for_patient;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_alerts_for_patient')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\AlertsController::getAlertsAction',  '_format' => 'json',));
                }
                not_get_alerts_for_patient:

            }

            // set_judgment_for_application
            if (0 === strpos($pathinfo, '/api/judgment') && preg_match('#^/api/judgment/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_set_judgment_for_application;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'set_judgment_for_application')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\JudgmentController::saveJudgmentAction',  '_format' => 'json',));
            }
            not_set_judgment_for_application:

            // save_answers_for_extra_quiz
            if (0 === strpos($pathinfo, '/api/extra_quiz/answers/save') && preg_match('#^/api/extra_quiz/answers/save/(?P<code>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_save_answers_for_extra_quiz;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'save_answers_for_extra_quiz')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\UserActionController::saveExtraAnswerAction',  '_format' => 'json',));
            }
            not_save_answers_for_extra_quiz:

            // save_answers_for_diary_
            if (0 === strpos($pathinfo, '/api/diary/answers/save') && preg_match('#^/api/diary/answers/save/(?P<code>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_save_answers_for_diary_;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'save_answers_for_diary_')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\UserActionController::saveDiaryAnswersAction',  '_format' => 'json',));
            }
            not_save_answers_for_diary_:

            if (0 === strpos($pathinfo, '/api/p')) {
                // _save_my_plan_answers_
                if (0 === strpos($pathinfo, '/api/plan/answers/save') && preg_match('#^/api/plan/answers/save/(?P<code>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not__save_my_plan_answers_;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_save_my_plan_answers_')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\UserActionController::savePlanAnswerAction',  '_format' => 'json',));
                }
                not__save_my_plan_answers_:

                // add_extra_point_
                if (0 === strpos($pathinfo, '/api/patient/add-point') && preg_match('#^/api/patient/add\\-point(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_add_extra_point_;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'add_extra_point_')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\UserActionController::addExtraPointAction',  '_format' => 'json',));
                }
                not_add_extra_point_:

            }

            if (0 === strpos($pathinfo, '/api/diary')) {
                // access_control_to_diary
                if (0 === strpos($pathinfo, '/api/diary/access-control') && preg_match('#^/api/diary/access\\-control/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_access_control_to_diary;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'access_control_to_diary')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\DiaryController::accessControlAction',  '_format' => 'json',));
                }
                not_access_control_to_diary:

                // switch_me_to_diary
                if (0 === strpos($pathinfo, '/api/diary/switch') && preg_match('#^/api/diary/switch/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_switch_me_to_diary;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'switch_me_to_diary')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\DiaryController::diaryUrlSwitchAction',  '_format' => 'json',));
                }
                not_switch_me_to_diary:

                // get_my_diary_before_quit
                if (0 === strpos($pathinfo, '/api/diary/before') && preg_match('#^/api/diary/before/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_my_diary_before_quit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_my_diary_before_quit')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\DiaryController::getMyDiaryBeforeAction',  '_format' => 'json',));
                }
                not_get_my_diary_before_quit:

                if (0 === strpos($pathinfo, '/api/diary/after')) {
                    // get_my_diary_after_quit_first_question_
                    if (0 === strpos($pathinfo, '/api/diary/after/first') && preg_match('#^/api/diary/after/first/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_get_my_diary_after_quit_first_question_;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_my_diary_after_quit_first_question_')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\DiaryController::fQMyDiaryAfterAction',  '_format' => 'json',));
                    }
                    not_get_my_diary_after_quit_first_question_:

                    // get_my_diary_after_quit_second_question_
                    if (0 === strpos($pathinfo, '/api/diary/after/second') && preg_match('#^/api/diary/after/second/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_get_my_diary_after_quit_second_question_;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_my_diary_after_quit_second_question_')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\DiaryController::sQMyDiaryAfterAction',  '_format' => 'json',));
                    }
                    not_get_my_diary_after_quit_second_question_:

                }

            }

            if (0 === strpos($pathinfo, '/api/p')) {
                if (0 === strpos($pathinfo, '/api/panic')) {
                    // get_my_panic_button_want
                    if (0 === strpos($pathinfo, '/api/panic/want') && preg_match('#^/api/panic/want/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_get_my_panic_button_want;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_my_panic_button_want')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\ButtonPanicController::getPanicButtonWantAction',  '_format' => 'json',));
                    }
                    not_get_my_panic_button_want:

                    if (0 === strpos($pathinfo, '/api/panic/cracked')) {
                        // get_my_panic_button_cracked
                        if (0 === strpos($pathinfo, '/api/panic/cracked/first') && preg_match('#^/api/panic/cracked/first/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_get_my_panic_button_cracked;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_my_panic_button_cracked')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\ButtonPanicController::getPanicButtonCrackedAction',  '_format' => 'json',));
                        }
                        not_get_my_panic_button_cracked:

                        // get_my_panic_button_cracked_third_question
                        if (0 === strpos($pathinfo, '/api/panic/cracked/third') && preg_match('#^/api/panic/cracked/third/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_get_my_panic_button_cracked_third_question;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_my_panic_button_cracked_third_question')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\ButtonPanicController::sQMyDiaryAfterAction',  '_format' => 'json',));
                        }
                        not_get_my_panic_button_cracked_third_question:

                    }

                    // get_my_panic_button_not_cracked
                    if (0 === strpos($pathinfo, '/api/panic/not-cracked') && preg_match('#^/api/panic/not\\-cracked/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_get_my_panic_button_not_cracked;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_my_panic_button_not_cracked')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\ButtonPanicController::getPanicButtonNotCrackedAction',  '_format' => 'json',));
                    }
                    not_get_my_panic_button_not_cracked:

                }

                if (0 === strpos($pathinfo, '/api/plan')) {
                    // access_action_plan
                    if (0 === strpos($pathinfo, '/api/plan/access') && preg_match('#^/api/plan/access(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_access_action_plan;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'access_action_plan')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\MyPlanController::accessPlanAction',  '_format' => 'json',));
                    }
                    not_access_action_plan:

                    // get_my_current_action_plan
                    if (preg_match('#^/api/plan(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_get_my_current_action_plan;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_my_current_action_plan')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\MyPlanController::getCurrentPlanAction',  '_format' => 'json',));
                    }
                    not_get_my_current_action_plan:

                }

            }

            if (0 === strpos($pathinfo, '/api/economy')) {
                // save_my_economy
                if (0 === strpos($pathinfo, '/api/economy/save') && preg_match('#^/api/economy/save/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_save_my_economy;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'save_my_economy')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\EconomyController::saveMyEconomyAction',  '_format' => 'json',));
                }
                not_save_my_economy:

                // get_my_economy
                if (preg_match('#^/api/economy/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_my_economy;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_my_economy')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\EconomyController::getMyEconomyAction',  '_format' => 'json',));
                }
                not_get_my_economy:

            }

            // user_calendar
            if (0 === strpos($pathinfo, '/api/calendar') && preg_match('#^/api/calendar/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_user_calendar;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_calendar')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\CalendarController::indexAction',  '_format' => 'json',));
            }
            not_user_calendar:

            // indexuser_mypoints
            if (0 === strpos($pathinfo, '/api/mypoints') && preg_match('#^/api/mypoints/(?P<token>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_indexuser_mypoints;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'indexuser_mypoints')), array (  '_controller' => 'Nicorette\\ApiBundle\\Controller\\MyPointsController::indexAction',  '_format' => 'json',));
            }
            not_indexuser_mypoints:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
