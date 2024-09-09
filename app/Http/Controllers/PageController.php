<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Packages;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\SiteSettings;
use App\Models\Service;
use App\Models\PhotoGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

class PageController extends Controller
{
    public function our_services()
    {
        $site_settings = SiteSettings::first();
        $data = Service::all();
        return view('Home.our_services',compact('site_settings','data'));
    }
    public function service_details($id)
    {
        $site_settings = SiteSettings::first();
        $services = Service::find($id);
        return view('Home.service_details',compact('site_settings','services'));
    }
    public function about_us()
    {
        $site_settings = SiteSettings::first();
        $about_us = AboutUs::first();
        return view('Home.about_us',compact('about_us','site_settings'));
    }
    public function contact_us()
    {
        $site_settings = SiteSettings::first();
        return view('Home.contact_us',compact('site_settings'));
    }
    public function update_about_us()
    {
        $site_settings = SiteSettings::first();
        $data = AboutUs::first();
        return view('Admin.update_about_us',compact('site_settings','data'));
    }
    public function submit_about_us(Request $request)
    {
        $data = AboutUs::first();
        $data->keysentence = $request->keysentence;
        $data->description = $request->description;

        //$img = $data->mainimage;
        //$image_path = public_path('tour_image/'.$data->mainimage);

        $mainimage = $request->mainimage;
        if($mainimage)
        {
            $mainimagename = time().'.'.$mainimage->getClientOriginalExtension();
            $request->mainimage->move('tour_image',$mainimagename);
            $data->mainimage = $mainimagename;
        }

        $otherimage1 = $request->otherimage1;
        if($otherimage1)
        {
            $otherimage1name = time().'.'.$otherimage1->getClientOriginalExtension();
            $request->otherimage1->move('tour_image',$otherimage1name);
            $data->otherimage1 = $otherimage1name;
        }

        $otherimage2 = $request->otherimage2;
        if($otherimage2)
        {
            $otherimage2name = time().'.'.$otherimage2->getClientOriginalExtension();
            $request->otherimage2->move('tour_image',$otherimage2name);
            $data->otherimage2 = $otherimage2name;
        }

        $data->save();
        return redirect()->back()->with('success', 'About Us Page Updated successfully.');

    }
    public function add_our_services()
    {
        $site_settings = SiteSettings::first();
        $data = Service::all();
        return view('Admin.add_our_services',compact('site_settings','data'));
    }
    public function submit_our_services(Request $request)
    {
        $data = new Service();
        $data->name = $request->name;
        $data->description = $request->description;
        $image = $request->image;
        if($image)
        {
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('tour_image',$imagename);
            $data->image = $imagename;
        }
        $data->save();
        return redirect()->back()->with('success', 'Services Information Added successfully.');
    }
    public function delete_service($id)
    {
        $data = Service::find($id);
        $data->delete();
        return redirect()->back()->with('warning', 'Services Information Updated successfully.');
    }
    public function edit_service($id)
    {
        $site_settings = SiteSettings::first();
        $data = Service::find($id);
        return view('Admin.update_our_services',compact('data','site_settings'));
    }
    public function update_our_services(Request $request, $id)
    {
        $data = Service::find($id);
        $data->name = $request->name;
        $data->description = $request->description;
        $image = $request->image;
        if($image)
        {
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('tour_image',$imagename);
            $data->image = $imagename;
        }
        $data->save();
        return redirect('/add_our_services')->with('success', 'Services Updated successfully.');;
    }
    //newly added photo gallery
    public function photo_gallery()
    {
        $site_settings = SiteSettings::first();
        $photo_gallery = PhotoGallery::all();
        return view('home.photo_gallery',compact('site_settings','photo_gallery'));
    }
}
