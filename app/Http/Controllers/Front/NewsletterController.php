<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Add Newsletter subscriber
     */
    public function addSubscriberEmail(Request $request){
        if($request->ajax()){
            $data = $request->all();

            // check email already exists or not
            $subscriberCount = NewsletterSubscriber::where('email', $data['subscriber_email'])->count();

            if($subscriberCount > 0){
                return "exists";
            }else {
                // Add Newsletter Subscriber Email in Newsletter Subscriber Email
                $newsletter = new NewsletterSubscriber;
                $newsletter->email = $data['subscriber_email'];
                $newsletter->status = 1;
                $newsletter->save();
                return "inserted";
            }
        }
    }
}
