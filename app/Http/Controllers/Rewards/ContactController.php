<?php

namespace App\Http\Controllers\Rewards;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class ContactController extends Controller
{
    public function index( $request, ContactRepository $contactRepo)
    {
        $result = $contactRepo->pager($contactRepo);

        if ($result instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($result->getMessage()));
        }

        return ApiResponse::success($result);
    }
    public function test(Request $request){

        // return "controler is here";
        print_r($request->unit_price);
        // try {  
               
        // } catch (\Exception $e) {
        //     return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        // }
        
        //  $result['test']="hello";
        // return  $response = \Response::json($result, 200);
        // return ApiResponse::success($result);
    }

    public function send(ContactRequest $request, ContactRepository $contactRepo)
    {
        try {
            $contact = $contactRepo->where('type', $request->input('type'))->first();

            if (! $request->has('no_reply')) {
                $replyNeeded = 'No';
            } else {
                $replyNeeded = intval($request->no_reply) ? 'No' : 'Yes';
            }

            $enquiryType = $this->getEnquiryType($request->type);

            $message  = "From {$request->name} <{$request->email}>\n\n";
            $message .= "Enquiry: {$enquiryType}\n\n";
            $message .= "Department: {$request->department}\n\n";
            $message .= "Designation: {$request->designation}\n\n";
            $message .= "Reply Needed: {$replyNeeded}\n\n";
            $message .= $request->message;

            Mail::raw($message, function ($message) use ($request, $contact) {
                if ($request->hasFile('attachment')) {
                    $file = $request->file('attachment');
                    $message = $message->attach($file->getRealPath(), [
                        'as' => $file->getClientOriginalName(),
                        'mime' => $file->getMimeType(),
                    ]);
                }

                $message->to([
                        $contact->email,
                        $request->input('email'),
                    ])
                    ->subject("Contact Us [{$contact->name}]")
                    ->replyTo($request->input('email'));
            });
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }
        
        return ApiResponse::success();
    }

    protected function getEnquiryType($type)
    {
        switch ($type) {
            case 1:
                $result = 'Technical Issue';
                break;
            case 2:
                $result = 'Redemption';
                break;
            case 4:
                $result = 'Tokens/Badges';
                break;
            case 6:
                $result = 'Others';
                break;
        }

        return $result;
    }
}
