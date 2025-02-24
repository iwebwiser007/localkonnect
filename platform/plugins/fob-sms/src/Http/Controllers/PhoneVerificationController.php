<?php

namespace FriendsOfBotble\Sms\Http\Controllers;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Http\Controllers\BaseController;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use Carbon\Carbon;
use FriendsOfBotble\Sms\Facades\Guard;
use FriendsOfBotble\Sms\Facades\Otp as OtpFacade;
use FriendsOfBotble\Sms\Forms\PhoneVerificationForm;
use FriendsOfBotble\Sms\Http\Requests\PhoneVerificationRequest;
use FriendsOfBotble\Sms\Actions\SendOtpAction;
use Session;


class PhoneVerificationController extends BaseController
{
    public function index(SendOtpAction $sendOtpAction)
    {
        SeoHelper::setTitle(__('Phone Number Verification'));

        $userdata   = auth(Guard::getGuard())->user();
        $form       = PhoneVerificationForm::create();
        $identifier = auth(Guard::getGuard())->user()->phone;
        $expiryTime = OtpFacade::getExpiryTime($identifier);

        

        if($userdata->phone_verified_at =="" || $userdata->phone_verified_at ==null){
            $sms_send = Session::get('sms_send');

            if($sms_send !="yes"){
                $sendOtpAction($identifier);
                Session::put('sms_send','yes');
            }

        }


        return Theme::scope(
            'otp.verify',
            compact('form', 'identifier', 'expiryTime'),
            'plugins/sms::phone-verification.verify'
        )->render();
    }

    public function store(PhoneVerificationRequest $request)
    {
        $user = $request->user(Guard::getGuard());

        if (! OtpFacade::verify($user->phone, $request->input('otp'))) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage(__('Your OTP is invalid or expired.'));
        }

        $user->phone_verified_at = Carbon::now();
        $user->save();

        return $this
            ->httpResponse()
            ->setNextUrl(BaseHelper::getHomepageUrl())
            ->setMessage(__('Your phone number has been verified successfully.'));
    }
}
