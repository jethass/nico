<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Psr\Log\LoggerInterface;

/**
 * appProdUrlGenerator
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlGenerator extends Symfony\Component\Routing\Generator\UrlGenerator
{
    private static $declaredRoutes = array(
        'home' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Nicorette\\FrontBundle\\Controller\\DefaultController::indexAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'user_confirmation' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Nicorette\\FrontBundle\\Controller\\DefaultController::userConfirmationAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/user-confirmation',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'reset_password' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Nicorette\\FrontBundle\\Controller\\DefaultController::resetPasswordAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/reset-password',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'nicorette_central_default_index' => array (  0 =>   array (    0 => 'name',  ),  1 =>   array (    '_controller' => 'Nicorette\\CentralBundle\\Controller\\DefaultController::indexAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'name',    ),    1 =>     array (      0 => 'text',      1 => '/hello',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'import' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\DefaultController::indexAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/import',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_quiz_by_code' => array (  0 =>   array (    0 => 'code',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\QuizesController::getQuizeAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'code',    ),    2 =>     array (      0 => 'text',      1 => '/api/quiz',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'user_auth' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::authUserAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/user/auth',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'user_synchronize' => array (  0 =>   array (    0 => 'uuid',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::saveUserAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'uuid',    ),    2 =>     array (      0 => 'text',      1 => '/api/user/save',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'user_forgot_authCode' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::getForgotAuthCodeAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/user/forgot/authCode',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'user_profile' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::getUserProfileAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/user/profile',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'user_update_profile' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::updateUserProfileAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/user/updateprofile',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'user_get_verification_code' => array (  0 =>   array (    0 => 'uuid',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::getverificationCodeAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'uuid',    ),    2 =>     array (      0 => 'text',      1 => '/api/user/verificationCode',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'cities_get_cities_name' => array (  0 =>   array (    0 => 'zip',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::getCitiesNamesAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'zip',    ),    2 =>     array (      0 => 'text',      1 => '/api/cities/getCities',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'cities_get_zip_codes' => array (  0 =>   array (    0 => 'city',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\UsersController::getZipCodesAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'city',    ),    2 =>     array (      0 => 'text',      1 => '/api/cities/getZipCodes',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'set_answers_for_quiz' => array (  0 =>   array (    0 => 'code',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\AnswersController::postAnswersAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'code',    ),    2 =>     array (      0 => 'text',      1 => '/api/answers',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'save_answers_for_initquiz' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\AnswersController::saveAnswersAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/initquiz/answers/save',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'number_day_without_cigarette' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\DashboardController::getNumberDayWithoutCigaretteAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/withoutcigarette',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_dashboarddashboard' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\DashboardController::getDashboardAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/dashboard',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_statisticstatistic' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\DashboardController::getStatisticAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/statistic',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'nelmio_api_doc_index' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Nelmio\\ApiDocBundle\\Controller\\ApiDocController::indexAction',  ),  2 =>   array (    '_method' => 'GET',  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/doc/',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'set_last_smoked_cigarette_date' => array (  0 =>   array (    0 => 'engaged',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\ContractController::lastCigaretteAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'engaged',    ),    2 =>     array (      0 => 'text',      1 => '/api/contract/lastOne',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'set_quit_date' => array (  0 =>   array (    0 => 'angajed',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\ContractController::quitDateContractAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'angajed',    ),    2 =>     array (      0 => 'text',      1 => '/api/contract',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'set_quit_program_nicorette' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\ContractController::quitProgramAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/quit-program',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'user_get_contract_date' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\ContractController::getverificationCodeAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/contract/info/date',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_quiz_quit_program_' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\ContractController::getQuitAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/quit-nicorette-program',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'add_new_sponsor' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\SponsoringController::newAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/sponsoring/new',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'update_sponsor' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\SponsoringController::updateAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'PUT',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/sponsoring/update',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'delete_sponsor' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\SponsoringController::deleteAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'DELETE',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/sponsoring/delete',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_list_sponsor' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\SponsoringController::indexAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/sponsoring',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'set_alerts_for_patient' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\AlertsController::saveAlertsAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/alerts/save',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'update_alerts_for_patient' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\AlertsController::updateAlertsAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'PUT',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/alerts/update',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_alerts_for_patient' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\AlertsController::getAlertsAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/alerts',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'set_judgment_for_application' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\JudgmentController::saveJudgmentAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/judgment',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'save_answers_for_extra_quiz' => array (  0 =>   array (    0 => 'code',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\UserActionController::saveExtraAnswerAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'code',    ),    2 =>     array (      0 => 'text',      1 => '/api/extra_quiz/answers/save',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'save_answers_for_diary_' => array (  0 =>   array (    0 => 'code',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\UserActionController::saveDiaryAnswersAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'code',    ),    2 =>     array (      0 => 'text',      1 => '/api/diary/answers/save',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        '_save_my_plan_answers_' => array (  0 =>   array (    0 => 'code',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\UserActionController::savePlanAnswerAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'code',    ),    2 =>     array (      0 => 'text',      1 => '/api/plan/answers/save',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'add_extra_point_' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\UserActionController::addExtraPointAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/patient/add-point',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'access_control_to_diary' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\DiaryController::accessControlAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/diary/access-control',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'switch_me_to_diary' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\DiaryController::diaryUrlSwitchAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/diary/switch',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_my_diary_before_quit' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\DiaryController::getMyDiaryBeforeAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/diary/before',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_my_diary_after_quit_first_question_' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\DiaryController::fQMyDiaryAfterAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/diary/after/first',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_my_diary_after_quit_second_question_' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\DiaryController::sQMyDiaryAfterAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/diary/after/second',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_my_panic_button_want' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\ButtonPanicController::getPanicButtonWantAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/panic/want',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_my_panic_button_cracked' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\ButtonPanicController::getPanicButtonCrackedAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/panic/cracked/first',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_my_panic_button_cracked_third_question' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\ButtonPanicController::sQMyDiaryAfterAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/panic/cracked/third',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_my_panic_button_not_cracked' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\ButtonPanicController::getPanicButtonNotCrackedAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/panic/not-cracked',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'access_action_plan' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\MyPlanController::accessPlanAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/plan/access',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_my_current_action_plan' => array (  0 =>   array (    0 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\MyPlanController::getCurrentPlanAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'text',      1 => '/api/plan',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'save_my_economy' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\EconomyController::saveMyEconomyAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'POST',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/economy/save',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_my_economy' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\EconomyController::getMyEconomyAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/economy',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'user_calendar' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\CalendarController::indexAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/calendar',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'indexuser_mypoints' => array (  0 =>   array (    0 => 'token',    1 => '_format',  ),  1 =>   array (    '_controller' => 'Nicorette\\ApiBundle\\Controller\\MyPointsController::indexAction',    '_format' => 'json',  ),  2 =>   array (    '_method' => 'GET',    '_format' => 'xml|json|html',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '.',      2 => 'xml|json|html',      3 => '_format',    ),    1 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/\\.]++',      3 => 'token',    ),    2 =>     array (      0 => 'text',      1 => '/api/mypoints',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
    );

    /**
     * Constructor.
     */
    public function __construct(RequestContext $context, LoggerInterface $logger = null)
    {
        $this->context = $context;
        $this->logger = $logger;
    }

    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        if (!isset(self::$declaredRoutes[$name])) {
            throw new RouteNotFoundException(sprintf('Unable to generate a URL for the named route "%s" as such route does not exist.', $name));
        }

        list($variables, $defaults, $requirements, $tokens, $hostTokens, $requiredSchemes) = self::$declaredRoutes[$name];

        return $this->doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, $requiredSchemes);
    }
}
