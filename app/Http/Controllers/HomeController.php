<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use App\Models\Packages;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\SiteSettings;
use App\Models\User;
use App\Models\PaymentType;
use App\Models\PaymentDetails;
use App\Models\PhotoGallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

use App\Notifications\SendEmailNotification;

use Notification;


class HomeController extends Controller
{
    public function display_homepage()
    {
        $site_settings = SiteSettings::first();
        $about_us = AboutUs::first();
        $data = Packages::all();
        $payment_type = PaymentType::all();

        return view('home.index',compact('data','site_settings','about_us','payment_type'));
    }
    public function view_details($id)
    {
        $data = Packages::find($id);
        $site_settings = SiteSettings::first();
        $payment_type = PaymentType::all();
        return view('home.view_details',compact('data','site_settings','payment_type'));
    }
    public function book_now(Request $request, $id)
    {
        // dd($request);

        // Find the package by ID
        $package = Packages::find($id);
        // Check if requested number of persons exceeds available capacity
        if ($request->total_persons > $package->available || $request->adult_persons + $request->children > $request->total_persons) {
            // toastr()->error('Sorry, the number of persons exceeds available capacity for this package.');
            return redirect()->back()->with('warning', 'Sorry, the number of persons exceeds available capacity for this package.');
        } else {
            // Check if the user already exists
            $user = User::where('email', $request->email)->first();
            $plainTextPassword = null; // Initialize $plainTextPassword variable

        if ($user) {
                // Use existing hashed password for existing users
                $hashedPassword = $user->password;
        } else {
                // Generate a random plain-text password for new users
                // $plainTextPassword = Str::random(10);
                $plainTextPassword = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
                $hashedPassword = Hash::make($plainTextPassword);

                // Create new user if not exists
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'password' => $hashedPassword,
                ]);
            }

            // Save booking details
            $email = $request->email;
            $booking = new Booking();
            $booking->customer_name = $request->name;
            $booking->email = $request->email;
            $booking->phone = $request->phone;
            $booking->address = $request->address;
            $booking->no_of_travellers = $request->total_persons;
            $booking->no_of_adult = $request->adult_persons;
            $booking->no_of_child = $request->children;
            $booking->allergy = $request->allergy;
            $booking->package_id = $id;
            $booking->status = 'in progress';
            $booking->package_price = $package->price_taka;
            $booking->total_payable = ($package->price_taka * $request->total_persons);
            $booking->discount = 0;
            $booking->final_payable = ($package->price_taka * $request->total_persons);
            $booking->paid_amount = 0;
            $booking->due = ($package->price_taka * $request->total_persons);
            $booking->is_paid = 0;
            $booking->save();

            $payment_details = new PaymentDetails;
            $payment_details->booking_id = $booking->id;
            $payment_details->date = date('Y-m-d');
            $payment_details->payment_type_id = $request->payment_type;
            $payment_details->reference = $request->reference;
            $payment_details->paid_amount = $request->paid_amount;
            $payment_details->is_verified = 0;
            $payment_slip_image = $request->payment_slip;
            if($payment_slip_image)
            {
                $payment_slip_name = time().'.'.$payment_slip_image->getClientOriginalExtension();
                $request->payment_slip->move('payment_slip_image',$payment_slip_name);
                $payment_details->payment_slip = $payment_slip_name;
            }
            $payment_details->save();

        // Prepare email details with plain-text password if it was generated
        if ($plainTextPassword) {
            $details = [
                'greetings' => 'Assalamualaikum Sir',
                'body' => 'You have booked for our tour package. To check your booking status, login to our system using your email: ' . $email . ' and password: ' . $plainTextPassword,
                'action_text' => 'Login',
                'action_url' => 'http://192.168.0.175/TourismManagementUpdated/public/my_bookings',
                'endline' => 'Thank you sir',
            ];

            // Send email notification with plain-text password
            $user->notify(new SendEmailNotification($details));
        } else {
            // Send email notification without plain-text password (existing user)
            $details = [
                'greetings' => 'Assalamualaikum Sir',
                'body' => 'You have booked for our tour package. To check your booking status, login to our system using your email: ' . $email . ' and your existing password.',
                'action_text' => 'Login',
                'action_url' => 'http://192.168.0.175/TourismManagementUpdated/public/my_bookings',
                'endline' => 'Thank you sir',
            ];

            $user->notify(new SendEmailNotification($details));
        }
        return redirect()->back()->with('success', 'Tour Package Booked successfully.');
    }

    }

    public function usersPayNow(Request $request)
    {

        // Validate the incoming request data
        $validatedData = $request->validate([
            'booking_id'   => 'required|integer|exists:bookings,id',
            'payment_type' => 'required|integer',
            'reference'    => 'nullable|string|max:255',
            'paid_amount'  => 'required|numeric|min:0',
        ]);

        // Assuming you have a Payment model for the payments table
        $payment = new PaymentDetails();
        $payment->booking_id = $validatedData['booking_id'];
        $payment->payment_type_id = $validatedData['payment_type'];
        $payment->reference = $validatedData['reference'];
        $payment->paid_amount = $validatedData['paid_amount'];
        $payment->is_verified = 0;
        $payment_slip_image = $request->payment_slip;
        if($payment_slip_image)
        {
            $payment_slip_name = time().'.'.$payment_slip_image->getClientOriginalExtension();
            $request->payment_slip->move('payment_slip_image',$payment_slip_name);
            $payment->payment_slip = $payment_slip_name;
        }

        // Save the payment to the database
        $payment->save();

        // Return a response, redirect or view
        return redirect()->back()->with('success', 'Payment added successfully.');
    }

    public function view_tour_packages()
    {
        $data = Packages::all();
        $site_settings = SiteSettings::first();
        $payment_type = PaymentType::all();

        return view('Home.view_tour_packages',compact('data','site_settings','payment_type'));
    }
    public function send_contact_message(Request $request)
    {
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        return redirect()->back()->with('success', 'Message Sent successfully.');

    }
    public function my_bookings()
    {
        $site_settings = SiteSettings::first();
        $payment_type = PaymentType::all();
        if (Auth::id()) {
            $user = Auth::user();
            $email = $user->email;
            $data = Booking::find($email);
            //$data = Booking::where('email', $email)->with('packages')->get();

            // Fetch bookings and order by bookings.created_at
            $data = Booking::where('email', $email)
            ->with('packages')
            ->orderBy('created_at', 'desc')
            ->get();
            return view('Home.my_bookings', compact('data','site_settings','payment_type'));
        }else
        {
             $data = collect(); // Provide an empty collection if no authenticated user
        }
        return view('Home.my_bookings', compact('site_settings','data'));
    }

    //to view all payments history of customer of mybookings (04-09-2024)
    public function view_all_payments_users()
    {
        $site_settings = SiteSettings::first();
        $email = Auth::user()->email;
        // $view_all_payments = DB::table('payment_details')
        // ->join('bookings', 'payment_details.booking_id', '=', 'bookings.id')
        // ->where('bookings.email', $email)
        // ->select('payment_details.*', 'bookings.email')
        // ->get();

        $view_all_payments = DB::table('payment_details')
            ->join('bookings', 'payment_details.booking_id', '=', 'bookings.id')
            ->join('packages', 'bookings.package_id', '=', 'packages.id')
            ->join('payment_type', 'payment_details.payment_type_id', '=', 'payment_type.id')
            ->where('bookings.email', $email)
            ->select('payment_details.*', 'bookings.email', 'payment_type.name as payment_type_name','packages.name as package_name')
            ->orderBy('payment_details.id', 'desc') // Order by id descending
            ->get();


        // $site_settings = SiteSettings::first();
        // //$booking = Booking::all();
        // $packages = Packages::all();
        // $payment_details = PaymentDetails::join('payment_type', 'payment_details.payment_type_id', '=', 'payment_type.id')
        // ->select('payment_details.*', 'payment_type.name as payment_type_name')
        // ->where('is_verified', '!=', 0)
        // ->orderBy('id', 'desc') // Sort by id in descending order
        // ->get();
       return view('home.view_all_payments',compact('view_all_payments','site_settings'));
    }
}
