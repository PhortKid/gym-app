<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use App\Services\SmsService;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Mail\SendQrCodeToCustomer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\IncomeCategory;
use App\Models\Income;



class CustomerManagementController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

  

        public function customers()
    {
        $customers = Customer::with(['assigned_trainer', 'membership_type'])
            ->withSum('payments', 'amount')
            ->get()
            ->map(function ($customer) {
                $customer->paid_amount = $customer->payments_sum_amount ?? 0;
                unset($customer->payments_sum_amount);
                return $customer;
            });

        return response()->json($customers);
    }

            public function invoice()
        {
            $customers = Customer::with(['assigned_trainer', 'membership_type'])
                ->withSum('payments', 'amount')
                ->get()
                ->filter(function ($customer) {
                    return $customer->amount > ($customer->payments_sum_amount ?? 0);
                })
                ->map(function ($customer) {
                    $customer->paid_amount = $customer->payments_sum_amount ?? 0;
                    unset($customer->payments_sum_amount);
                    return $customer;
                })
                ->values();

            return response()->json($customers);
        }


    public function paid_customer()
    {
        $customers = Customer::with(['assigned_trainer', 'membership_type'])
            ->withSum('payments', 'amount')
            ->get()
            ->filter(function ($customer) {
                return $customer->amount == $customer->payments_sum_amount;
            })
            ->map(function ($customer) {
                $customer->paid_amount = $customer->payments_sum_amount ?? 0;
                unset($customer->payments_sum_amount);
                return $customer;
            })
            ->values();
    
        return response()->json($customers);
    }

      /*  $customers = Customer::with(['assigned_trainer', 'membership_type'])
        ->withSum('payments', 'amount')
        ->having('amount', '=', DB::raw('payments_sum_amount'))
        ->get();
    
    
        return response()->json($customers);
    }*/

    public function add(Request $request){
       
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'address' => 'required|max:255',
            'phone_number' => 'required|max:13',
            'email' => 'required|max:35',
            'next_of_kin_name' => 'required|string|max:50',
            'next_of_kin_relation' => 'required|string|max:50',
            'next_of_kin_phone' => 'required|max:13',
            'start_date' => 'nullable',
            'payment_plan' => 'nullable',
            'payment_status' => 'required',
            'health_notes' => 'nullable',
            'preferred_workout_time' => 'nullable',
            'health_notes' => 'nullable',
            
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $customer =    Customer::create(
            [
            'full_name'=>$request->full_name,
            'gender'=>$request->gender,
            'phone_number'=>$request->phone_number,
            'email'=>$request->email,
            'nationality'=>$request->nationality,
            'start_date'=>$request->start_date,
            'expiry_date'=>$request->expiry_date,
            'next_of_kin_name'=>$request->next_of_kin_name,
            'next_of_kin_relation'=>$request->next_of_kin_relation,
            'next_of_kin_phone'=>$request->next_of_kin_phone,
            'payment_plan'=>$request->payment_plan,
            'address'=>$request->address,
            'health_notes' => $request->health_notes,
            'membership_type_id' => $request->membership_type_id,
            'assigned_trainer_id' => $request->assigned_trainer_id,
            'profile_photo' => $request->profile_photo,
            'preferred_workout_time' => $request->preferred_workout_time,
            'amount' => $request->amount,
            'payed_amount' => $request->payed_amount,
            'payment_status'=>$request->payment_status,
        ]);

       
            $payment = Payment::create(
                [
                'member_id'=>$customer->id,
                'payment_date'=>Carbon::now(),
                'amount'=>$customer->amount,
                'payment_method'=>$request->payment_method,
            ]);

            $membershipCategory = IncomeCategory::firstOrCreate(['name' => 'Membership Revenue']);
            Income::create([
                'amount' => $request->payed_amount,
                'description' => 'Membeship Revenue',
                'date' => $request->start_date,
                'category_id' => $membershipCategory->id, 
                'payment_type' => $request->payment_method,
            ]);
        
       

        /*
        $qrCodeImage = QrCode::format('svg')->size(300)->generate($customer->id);
        $qrCodePath = public_path("qrcodes/customer_{$customer->id}.svg");
        file_put_contents($qrCodePath, $qrCodeImage);*/
        /*
        try{
            Mail::to($customer->email)->send(new SendQrCodeToCustomer($customer, $qrCodePath));
        }catch(Exception){
             
        }
        */
/*
        try{
            $customer->phone_number = preg_replace('/\D/', '', $customer->phone_number);
            if (preg_match('/^0[67]\d{8}$/', $customer->phone_number)) {
 
                $customer->phone_number='255' . substr($customer->phone_number, 1);
            }


            $recipient =[ltrim($customer->phone_number, '+')]; 
        
            $message = "Dear " . $request->full_name . ",
Thank you for choosing Amazing Gym Fitness.Pay TZS'.$request->amount.' via M-Pesa:101010, Download Attendance QR:". url('myqrcode/' . $customer->id)." . 
TUNAJALI AFYA YAKO.";
            

            $result = $this->smsService->sendSms($message, $recipient);
        }catch(Exception){
            //return response()->json(['errors'=>'Message Not Sent']);
        }
        */

        return response()->json(['status'=>'sucess','message'=>'Customer Added']);
        
        
    }


            public function delete(Request $request, $id)
        {
            // Find Customer
            $customer = Customer::find($id);

            if (!$customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }

            // Update fields
        
            $customer->delete();

            return response()->json(['message' => 'Customer successfully']);
        }

}
