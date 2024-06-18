<?php
namespace App\Helpers;

use App\Mail\MemberApproved;
use App\Models\Municipal;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailHelper { 
    public static function mailMembership(User $approved_user, User $approver){

        $municipal = app(Municipal::class)->getRow($approved_user->municipal_id);

        $mail = Mail::to($approved_user->email);

        if(!empty($municipal) && !empty($municipal['municipal_email'])){
            $mail = $mail->cc($municipal['municipal_email']);
        }

        return $mail->queue(new MemberApproved(
            $approved_user, 
            $approver,
            url("valid_id/{$approved_user->id}/id")
        ));
    }
}