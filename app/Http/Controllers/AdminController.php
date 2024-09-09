<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\AboutUs;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Packages;
use App\Models\Contact;
use App\Models\User;
use App\Models\SiteSettings;
use App\Models\Category;
use App\Models\Products;
use App\Models\PaymentType;
use App\Models\UnitType;
use App\Models\PaymentDetails;
use App\Models\PhotoGallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Notification;


use App\Notifications\SendEmailNotification;


class AdminController extends Controller
{
    public function index()
    {
        $site_settings = SiteSettings::first();
        $no_of_users = Booking::distinct()->count('email');
        $no_of_orders = Booking::count();
        $no_of_bookings = Booking::where('status', 'approved')->count();
        $no_of_packages = Packages::count();
        // $user = Auth::user(); // or auth()->user();

        return view('admin.index',compact('no_of_users','no_of_orders','no_of_bookings','no_of_packages','site_settings'));
    }
    public function add_packages()
    {
        $site_settings = SiteSettings::first();
        return view('admin.add_packages',compact('site_settings'));
    }
    public function submit_packages(Request $request)
    {
        $data = new Packages;
        $data->name = $request->name;
        $data->location = $request->location;
        $data->price_dollar = $request->price_dollar;
        $data->price_taka = $request->price_taka;
        $data->description = $request->description;
        // $data->duration = $request->duration;
        $data->startdate = $request->startdate;
        $data->enddate = $request->enddate;
        $data->capacity = $request->capacity;
        $data->available = $request->capacity;
        $data->special_instruction = $request->special_instruction;
        $image = $request->image;
        if($image)
        {
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('tour_image',$imagename);
            $data->image = $imagename;
        }
        $data->save();
        //toastr()->timeOut(5000)->closeButton()->addSuccess('Tour Package Added Successfully');
        return redirect()->back()->with('success', 'Package Added successfully.');
    }
    public function view_packages()
    {
        $site_settings = SiteSettings::first();
        $data = Packages::all();
                // Update package availability
       // $data->Packages->refreshAvailability();
        return view('admin.view_packages',compact('data','site_settings'));
    }
    public function delete_packages($id)
    {
        $data = Packages::find($id);
        $data->delete();
        return redirect()->back()->with('warning', 'Package Added successfully.');;
    }
    public function edit_packages($id)
    {
        $site_settings = SiteSettings::first();
        $data = Packages::find($id);
        return view('admin.update_packages',compact('data','site_settings'));
    }
    public function update_packages(Request $request,$id)
    {
        $data = Packages::find($id);
        $data->name = $request->name;
        $data->location = $request->location;
        $data->price_dollar = $request->pricedollar;
        $data->price_taka = $request->pricetaka;
        $data->description = $request->description;
        $data->startdate = $request->startdate;
        $data->enddate = $request->enddate;
        // $data->duration = $request->duration;
        $data->capacity = $request->capacity;
        $data->special_instruction = $request->special_instruction;
        $image = $request->image;
        if($image)
        {
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('tour_image',$imagename);
            $data->image = $imagename;
        }
        $data->save();
        return redirect('/view_packages')->with('success', 'Package Updated successfully.');;

    }
    public function view_booking()
    {
        $site_settings = SiteSettings::first();
        //$booking = Booking::all();
        $payment_type = PaymentType::all();
        $packages = Packages::all();
        $booking = Booking::orderBy('created_at', 'desc')->get();
        return view('admin.view_booking',compact('booking','site_settings','packages','payment_type'));
    }
    public function approve_booking($id)
    {
        $data = Booking::find($id);
        $user = $data->user; // Assuming you have a `user()` relationship defined in Booking model
        $user = User::where('email', $data->email)->first();
        $email = $user->email;

        $data->status = 'Approved';
        $data->save();
        // Update package availability
        $data->Packages->refreshAvailability();
        $details = [
            'greetings' => 'Assalamualaikum Sir',
            'body' => 'You have booking is Approved for our tour package. To check your booking status, login to our system using your email: ' . $email . ' and your existing password.',
            'action_text' => 'My Bookings',
            'action_url' => 'http://192.168.0.175/TourismManagementUpdated/public/my_bookings',
            'endline' => 'Thank you sir',
        ];
         // Send email notification using the SendEmailNotification class
         $user->notify(new SendEmailNotification($details));
        return redirect()->back()->with('success', 'Booking Approved successfully.');;
    }
    public function reject_booking($id)
    {
        $data = Booking::find($id);
        $user = $data->user; // Assuming you have a `user()` relationship defined in Booking model
        $user = User::where('email', $data->email)->first();
        $email = $user->email;
        $data->status = 'Rejected';
        $data->save();
        $data->Packages->refreshAvailability();

        $details = [
            'greetings' => 'Assalamualaikum Sir',
            'body' => 'You have booking is canceled for our tour package. To check your booking status, login to our system using your email: ' . $email . ' and your existing password.',
            'action_text' => 'My Bookings',
            'action_url' => 'http://192.168.0.175/TourismManagementUpdated/public/my_bookings',
            'endline' => 'Thank you sir',
        ];
         // Send email notification using the SendEmailNotification class
         $user->notify(new SendEmailNotification($details));
       // Send email notification using the SendEmailNotification class
    //Mail::to($data)->send(new SendEmailNotification($details));
      // $data->notify(new SendEmailNotification($details));
      // Mail::to($email)->send(new SendEmailNotification($details));
        return redirect()->back()->with('warning', 'Booking Rejected successfully.');;
    }
    public function addPayment(Request $request)
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
        $payment_slip_image = $request->payment_slip;
        if($payment_slip_image)
        {
            $payment_slip_name = time().'.'.$payment_slip_image->getClientOriginalExtension();
            $request->payment_slip->move('payment_slip_image',$payment_slip_name);
            $payment->payment_slip = $payment_slip_name;
        }



        // Save the payment to the database

        $payment-> is_verified = 1;
        $payment->approved_by = Auth::user()->id;
        $payment->save();

        $booking = Booking::find($payment->booking_id);
        $booking -> paid_amount = $booking -> paid_amount + $payment -> paid_amount;
        $booking -> due = $booking -> due - $payment -> paid_amount;

        if( $booking -> due - $payment -> paid_amount <= 0){
            $booking -> is_paid = 1 ;
        }

        $booking -> update();

        // Return a response, redirect or view
        return redirect()->back()->with('success', 'Payment added successfully.');
    }

    public function remove_booking($id)
    {
        $data = Booking::find($id);
        $data->delete();
        return redirect()->back()->with('warning', 'Booking Removed successfully.');;
    }
    public function all_payment_report()
    {
        $site_settings = SiteSettings::first();
        //$booking = Booking::all();
        $packages = Packages::all();
        $payment_details = PaymentDetails::join('payment_type', 'payment_details.payment_type_id', '=', 'payment_type.id')
        ->select('payment_details.*', 'payment_type.name as payment_type_name')
        ->where('is_verified', '!=', 0)
        ->orderBy('id', 'desc') // Sort by id in descending order
        ->get();

        return view('Admin.all_payments_report',compact('payment_details','site_settings'));
    }
    public function search_booking(Request $request)
    {
        $payment_type = PaymentType::all();
        $packages = Packages::all();
        $site_settings = SiteSettings::first();
        $search_data = $request->search;
        $booking = Booking::where('customer_name', 'LIKE', '%' . $search_data . '%')
        ->orWhere('email', 'LIKE', '%' . $search_data . '%')
        ->orWhere('address', 'LIKE', '%' . $search_data . '%')
        ->orWhere('phone', 'LIKE', '%' . $search_data . '%')
        ->orWhere('status', 'LIKE', '%' . $search_data . '%')
        // ->orWhere('address', 'LIKE', $search_data)
        ->orWhereHas('Packages', function ($query) use ($search_data) {
            $query->where('name', 'LIKE', '%' . $search_data . '%');
        })
        ->orWhereHas('Packages', function ($query) use ($search_data) {
            $query->where('price_dollar', '=', $search_data); // Exact match search on price
        })
        ->get();
        return view('admin.view_booking',compact('booking','site_settings','packages','payment_type'));
    }
    public function payment_details()
    {
        $site_settings = SiteSettings::first();
        //$booking = Booking::all();
        $packages = Packages::all();
        $payment_details = PaymentDetails::join('payment_type', 'payment_details.payment_type_id', '=', 'payment_type.id')
        ->select('payment_details.*', 'payment_type.name as payment_type_name')
        ->where('is_verified', 0)
        ->orderBy('id', 'desc') // Sort by id in descending order
        ->get();

        return view('admin.payment_details',compact('payment_details','site_settings'));

    }
    public function approve_payment($id)
    {
        $payment_detail = PaymentDetails::find($id);
        $payment_detail->is_verified = 1;
        $payment_detail->approved_by = Auth::user()->id;
        $payment_detail->update();

        $booking = Booking::find($payment_detail->booking_id);
        $booking -> paid_amount = $booking -> paid_amount + $payment_detail-> paid_amount;
        $booking -> due = $booking -> due - $payment_detail-> paid_amount;

        if( $booking -> due - $payment_detail-> paid_amount <= 0){
            $booking -> is_paid = 1 ;
        }

        $booking -> update ();



        return redirect()->back();

    }
    public function reject_payment($id)
    {
        $payment_detail = PaymentDetails::find($id);
        $payment_detail->is_verified = 2;
        $payment_detail->approved_by = Auth::user()->id;
        $payment_detail->update();
        return redirect()->back();

    }
    //for finding approved/rejected bookings
    public function approved_rejected_booking(Request $request)
    {
        $payment_type = PaymentType::all();
        $packages = Packages::all();
        $site_settings = SiteSettings::first();
        $search_data = $request->search;
        $booking = Booking::where('status', '=', $search_data) // Filter by status
            ->orderBy('created_at', 'desc') // Order by creation date (newest first)
            ->get();
        return view('admin.view_booking',compact('booking','site_settings','packages','payment_type'));

    }
    //view all customers
    public function view_all_customer()
    {
        $payment_type = PaymentType::all();
        $packages = Packages::all();
        $site_settings = SiteSettings::first();
        $customers = Booking::whereIn('id', function($query) {
            $query->select(DB::raw('MIN(id)')) // Get the first occurrence (minimum id) for each email
                  ->from('bookings')
                  ->groupBy('email');
        })->get();

        return view('admin.view_all_customers',compact('customers','packages','site_settings','payment_type'));
    }
    public function view_customer_bookings($email)
    {
        $payment_type = PaymentType::all();
        $packages = Packages::all();
        $site_settings = SiteSettings::first();
        // $view_customer_bookings = Booking::find($email);
        $view_customer_bookings = Booking::leftJoin('users', 'bookings.email', '=', 'users.email')
        ->leftJoin('packages', 'bookings.package_id', '=', 'packages.id')
        ->where('bookings.email', $email)
        ->select('bookings.*', 'users.name', 'packages.name as package_name') // Select columns from both tables
        ->orderBy('id','desc')
        ->paginate(15);
         // Join bookings with users and packages table
        // $view_customer_bookings = Booking::leftJoin('users', 'bookings.email', '=', 'users.email')
        // ->leftJoin('packages', 'bookings.package_id', '=', 'packages.id') // Join with packages table
        // ->where('bookings.email', $email)
        // ->select('bookings.*', 'users.name as user_name', 'packages.name as package_name') // Select columns from both tables
        // ->get();

        return view('admin.view_customer_bookings',compact('site_settings','view_customer_bookings','packages','payment_type'));
    }
    public function submit_selected_packages(Request $request)
    {
        $payment_type = PaymentType::all();
        $packages = Packages::all();
        $site_settings = SiteSettings::first();
        $search_data = $request->search;
        $booking = Booking::whereHas('Packages', function($query) use ($search_data) {
            $query->where('name','=', $search_data);
        })
        ->get();
        return view('admin.view_booking',compact('booking','site_settings','packages','payment_type'));
    }
    public function search_packages(Request $request)
    {
        $site_settings = SiteSettings::first();
        $search_data = $request->search;
        $data = Packages::where('name', 'LIKE', '%' . $search_data . '%')
        ->orWhere('location', 'LIKE', '%' . $search_data . '%')
        ->orWhere('price_dollar', '=', $search_data)
        ->get();
        return view('Admin.view_packages',compact('data','site_settings'));

    }
    public function view_message()
    {
        $site_settings = SiteSettings::first();
        $contact = Contact::all();
        return view('Admin.view_messages',compact('contact','site_settings'));
    }
    public function remove_message($id)
    {
        $data = Contact::find($id);
        $data->delete();
        return redirect()->back()->with('warning', 'Message Removed successfully.');;

    }
    public function reply_email($id)
    {
        $site_settings = SiteSettings::first();
        $data = Contact::find($id);
        return view('Admin.send_mail',compact('data','site_settings'));
    }
    public function reply_message(Request $request, $id)
    {
        $data = Contact::find($id);
        $details =[
            'greetings' => $request->greetings,
            'body' => $request->mail_body,
            'action_text' => $request->action_text,
            'action_url' => $request->action_url,
            'endline' => $request->endline,

        ];
        Notification::send($data, new SendEmailNotification($details));
        return redirect('/view_message')->with('success', 'Email Sent successfully.');;
    }
    public function search_contact(Request $request)
    {
        $site_settings = SiteSettings::first();
        $search_data = $request->search;
       // $contact = Contact::all();
        $contact = Contact::where('name', 'LIKE', '%' . $search_data . '%')
        ->orWhere('phone', 'LIKE', '%' . $search_data . '%')
        ->orWhere('email', 'LIKE', '%' . $search_data . '%')
        ->orWhere('subject', 'LIKE', '%' . $search_data . '%')
        ->orWhere('message', 'LIKE', '%' . $search_data . '%')
        ->get();
        return view('Admin.view_messages',compact('contact','site_settings'));
    }
    public function add_users()
    {
        $site_settings = SiteSettings::first();
        return view('Admin.add_users',compact('site_settings'));
    }
    public function submit_users(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->password = Hash::make($request->input('password'));
        $user->usertype = $request->input('usertype');
        $user->save();
        return redirect()->back()->with('success', 'User Added successfully.');;
    }
    public function view_users()
    {
        $site_settings = SiteSettings::first();
        $user_data = User::all();
        return view('Admin.view_users',compact('user_data','site_settings'));
    }
    public function remove_users($id)
    {
        $data = User::find($id);
        $data->delete();
        return redirect()->back()->with('warning', 'User Removed successfully.');;
    }
    public function edit_users($id)
    {
        $site_settings = SiteSettings::first();
        $data = User::find($id);
        return view('Admin.update_users',compact('data','site_settings'));
    }
    public function update_users(Request $request, $id)
    {
        $data = User::find($id);
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->usertype= $request->usertype;
        $data->save();
        return redirect('/view_users')->with('success', 'Users Info Updated successfully.');;
    }
    public function site_settings()
    {
        $site_settings = SiteSettings::first();
        return view('Admin.site_settings',compact('site_settings'));
    }
    public function update_site_settings(Request $request, $id)
    {
        $data = SiteSettings::find($id);
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->facebook = $request->facebook;
        $data->twitter = $request->twitter;
        $data->linkedin = $request->linkedin;
        $data->youtube = $request->youtube;
        $data->instagram = $request->instagram;
        $data->copyright = $request->copyright;
        $data->copyright_links = $request->copyright_links;
        $ui_logo = $request->website_logo;
        if($ui_logo)
        {
            $ui_logo_name = time().'.'.$ui_logo->getClientOriginalExtension();
            $request->website_logo->move('tour_image',$ui_logo_name);
            $data->ui_logo = $ui_logo_name;
        }
        $admin_logo = $request->admin_logo;
        if($admin_logo)
        {
            $admin_logo_name = time().'.'.$admin_logo->getClientOriginalExtension();
            $request->admin_logo->move('tour_image',$admin_logo_name);
            $data->admin_logo = $admin_logo_name;
        }
        $data->ui_site_name = $request->website_name;
        $data->admin_site_name = $request->admin_site_name;
        $data->footer_ui_name = $request->website_footer_name;
        $data->ui_footer_note = $request->ui_footer_note;
        $data->contact_google_map = $request->contact_google_map;
        $data->contact_open_close = $request->contact_open_close;
        $data->slider_keyword1 = $request->slider_keyword1;
        $data->slider_keyword2 = $request->slider_keyword2;
        $data->slider_keyword3 = $request->slider_keyword3;
        $image_slider1 = $request->slider_image1;
        if($image_slider1)
        {
            $image_slider1_name = time().'.'.$image_slider1->getClientOriginalExtension();
            $request->slider_image1->move('tour_image',$image_slider1_name);
            $data->slider_image1 =  $image_slider1_name;
        }

        $image_slider2 = $request->slider_image2;
        if($image_slider2)
        {
            $image_slider2_name = time().'.'.$image_slider2->getClientOriginalExtension();
            $request->slider_image2->move('tour_image',$image_slider2_name);
            $data->slider_image2 =  $image_slider2_name;
        }

        $image_slider3 = $request->slider_image3;
        if($image_slider3)
        {
            $image_slider3_name = time().'.'.$image_slider3->getClientOriginalExtension();
            $request->slider_image3->move('tour_image',$image_slider3_name);
            $data->slider_image3 =  $image_slider3_name;
        }
        $data->save();
        return redirect()->back()->with('success', 'Site Settings Updated successfully.');;

    }
    public function add_category()
    {
        $site_settings = SiteSettings::first();
        return view('Admin.add_category',compact('site_settings'));
    }
    public function submit_category(Request $request)
    {
        $category = new Category();
        $category->category_name = $request->category;
        $category->save();
        return redirect()->back()->with('success', 'Category added successfully.');
    }
    public function view_category()
    {
        $site_settings = SiteSettings::first();
        $data = Category::all();
        return view('Admin.view_category',compact('data','site_settings'));
    }
    public function add_product()
    {
        $site_settings = SiteSettings::first();
        $units = UnitType::all();
        $category = Category::all();
        return view('Admin.add_product',compact('category','site_settings','units'));
    }
    public function submit_product(Request $request)
    {
        $product =new Products();
        $product->product_name = $request->product_name;
        $product->product_details = $request->product_details;
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;
        $product->save();
        return redirect()->back()->with('success', 'Product added successfully.');
    }
    public function view_product()
    {
    //     $site_settings = SiteSettings::first();
    //    // $products = Category::with('products')->get();
    //     $categories = Category::with(['products.unit_type'])->get();
    //    // $categories = Category::all();
    //    // $products = Products::orderBy('created_at', 'desc')->get();
    //     return view('Admin.view_products',compact('site_settings','categories'));
    $site_settings = SiteSettings::first();
    $products = Products::with(['category', 'unitType'])->orderBy('created_at', 'desc')->get();
    return view('Admin.view_products', compact('site_settings', 'products'));

    }
    public function delete_category($id)
    {
        $data = Category::find($id);
        $data->delete();
        return redirect()->back()->with('warning', 'Category deleted successfully.');
    }
    public function delete_product($id)
    {
        $data = Products::find($id);
        $data->delete();
        return redirect()->back()->with('warning', 'Product deleted successfully.');
    }
    public function edit_category($id)
    {
        $site_settings = SiteSettings::first();
        $data = Category::find($id);
        return view('Admin.update_category',compact('data','site_settings'));
    }

    public function update_category(Request $request, $id)
    {
        $data = Category::find($id);
        $data->category_name = $request->category_name;
        $data->save();
        return redirect('/view_category')->with('success', 'Category Updated successfully.');
    }
    public function edit_product($id)
    {
        $site_settings = SiteSettings::first();
        // $data = Products::find($id);
        $categories = Category::all();
        $products = Products::with(['category', 'unitType'])->find($id);
        $units = UnitType::all(); // Fetch all units for the dropdown

        return view('admin.update_products',compact('site_settings','products','units','categories'));
    }
    public function update_product(Request $request, $id)
    {
        $data = Products::find($id);
        $data->product_name = $request->product_name;
        $data->product_details = $request->product_details;
        $data->category_id = $request->category_id;
        $data->unit_id = $request->unit_id;
        $data->save();
        return redirect('/view_product')->with('success', 'Product Updated successfully.');
    }
    public function search_products(Request $request)
    {
        $search_data = $request->search;
        $site_settings = SiteSettings::first();
        $categories = Category::all();
        $products = Products::where('product_name','LIKE','%'.$search_data.'%')
        ->orWhere('product_details','LIKE','%'.$search_data.'%')
        ->orWhere('quantity','=',$search_data)
        ->orWhereHas('categories', function ($query) use ($search_data) {
            $query->where('category_name', 'LIKE', '%' . $search_data . '%');
        })
        ->get();
        return view('admin.view_products',compact('site_settings','products','categories'));
    }
    public function search_category(Request $request)
    {
        $search_data = $request->search;
        $site_settings = SiteSettings::first();
        $data = Category::where('category_name','LIKE','%'.$search_data.'%')
        ->get();
        return view('Admin.view_category',compact('site_settings','data'));
    }

    // public function purchase_form()
    // {
    //     $site_settings = SiteSettings::first();
    //     $products = null;
    //     $categories = Category::all();
    //     return view('Admin.purchase_form_trial',compact('site_settings','products','categories'));
    // }
    // public function fetch_products($id)
    // {
    //     $site_settings = SiteSettings::first();
    //     $categories = Category::all();
    //     $products = Products::where('category_id',$id)->get();

    //     return view('Admin.purchase_form_trial',compact('site_settings','products','categories'));
    // }

    public function purchase_form()
    {
        $site_settings = SiteSettings::first();
        $categories = Category::all();
        return view('Admin.purchase_form',compact('site_settings','categories'));
    }
    public function fetch_purchase_form(Request $request)
    {
        $categoryId = $request->input('category_id');

        $products = Products::where('category_id', $categoryId)->get();

        return response()->json(['products' => $products]);
    }
    public function add_unit()
    {
        $site_settings = SiteSettings::first();
        $units = UnitType::all();
        return view('Admin.add_unit',compact('units','site_settings'));
    }
    public function submit_unit(Request $request)
    {
        // $site_settings = SiteSettings::first();
       $unit_name = $request->unit_name;
       // Check if the unit already exists
        $unitExists = UnitType::where('unit_name', $unit_name)->exists();

       if($unitExists)
       {
            return redirect()->back()->with('warning', 'Unit Already Exists.');
       }
       else
       {
            $data = new UnitType();
            $data->unit_name = $request->unit_name;
            $data->save();
            return redirect()->back()->with('success', 'Unit Added successfully.');
       }

        //return view('Admin.add_unit',compact('units','site_settings'))->with('success', 'Unit Added successfully.');
    }
    public function delete_unit($id)
    {
        $data = UnitType::find($id);
        $data->delete();
        return redirect()->back()->with('Warning', 'Unit Deleted successfully.');
    }
    public function edit_unit($id)
    {
        $site_settings = SiteSettings::first();
        $units = UnitType::find($id);
        return view('Admin.update_unit',compact('site_settings','units'));
    }
    public function update_unit(Request $request, $id)
    {
        $data = UnitType::find($id);
        $data->unit_name = $request->unit_name;
        $data->save();
        return redirect('add_unit')->with('success', 'Unit Updated successfully.');
    }

    //Newly updated for photo gallery(04-09-2024)
    public function add_photo_gallery()
    {
        $site_settings = SiteSettings::first();
        return view('admin.add_photo_gallery',compact('site_settings'));
    }
    public function submit_photo_gallery(Request $request)
    {
        $photo_gallery = new PhotoGallery();

        $image = $request->gallery_photo;
        if($image)
        {
            $gallery_photo_name = time().'.'.$image->getClientOriginalExtension();
            $request->gallery_photo->move('photo_gallery',$gallery_photo_name);
            $photo_gallery->photo =  $gallery_photo_name;
        }
        $photo_gallery->save();
        return redirect('add_photo_gallery')->with('success', 'Photo Added successfully.');
    }

}
