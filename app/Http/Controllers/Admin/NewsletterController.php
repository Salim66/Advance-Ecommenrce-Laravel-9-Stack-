<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SubscriberExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class NewsletterController extends Controller
{
    /**
     * Newsletter Subscriber
     */
    public function newsletterSubscribers(){
        $newsletter_subscribers = NewsletterSubscriber::get();
        return view('admin.subscribers.subscribers', compact('newsletter_subscribers'));
    }


    /**
     * Update Subscriber status
     */
    public function updateSubscriberStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == 'Active'){
                $status = 0;
            }else {
                $status = 1;
            }
            NewsletterSubscriber::where('id', $data['subscriber_id'])->update(['status' => $status]);
            return response()->json([
                'status' => $status,
                'subscriber_id' => $data['subscriber_id']
            ]);
        }
    }


    /**
     * Subscriber Delete
     */
    public function deleteSubscriber($id){
        $subscriber_data = NewsletterSubscriber::findOrFail($id);

        $subscriber_data->delete();

        Session::put('success_message', 'Subscriber Deleted Successfully ):');
        return redirect()->back();
    }

    /**
     * Subscriber Email Export
     */
    public function exportSubscriberEmail(){
        return Excel::download(new SubscriberExport, 'subscriber.xlsx');
    }
}
