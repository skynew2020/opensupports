<?php
use Respect\Validation\Validator as DataValidator;
DataValidator::with('CustomValidations', true);

class EditCustomResponseController extends Controller {
    const PATH = '/edit-custom-response';
    const METHOD = 'POST';

    public function validations() {
        return [
            'permission' => 'staff_2',
            'requestData' => [
                'id' => [
                    'validation' => DataValidator::dataStoreId('customresponse'),
                    'error' => ERRORS::INVALID_NAME
                ]
            ]
        ];
    }

    public function handler() {
        $customResponse = CustomResponse::getDataStore(Controller::request('id'));

        if (Controller::request('content')) {
            $customResponse->content = Controller::request('content');
        }

        if (Controller::request('language')) {
            $customResponse->language = Controller::request('language');
        }

        if (Controller::request('name')) {
            $customResponse->name = Controller::request('name');
        }

        $customResponse->store();

        Log::createLog('EDIT_CUSTOM_RESPONSE', null);
        Response::respondSuccess();
    }
}