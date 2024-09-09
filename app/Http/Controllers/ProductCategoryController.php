<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\SiteSettings;

class ProductCategoryController extends Controller
{
    public function addProductCat()
    {
        $site_settings = SiteSettings::first();
        return view('dashboard.product.addProductCat',compact('site_settings'));
    }
      public function createCategory(Request $request)
        {

            //Validate Inputs
              $request->validate([
                  'cat_name'=>'required',
                //   'sample_image'=>'required|image',
                  'status'=>'required',
              ]);


              $category = new ProductCategory();
              $category->category_name = $request->cat_name;
              if($request->sample_image)
              {
                $imageName = date('YmdHi').$request->sample_image->getClientOriginalName();
                $request->sample_image->move(public_path('backend/images/CategoryWise/'), $imageName);
                $category->sample_image = $imageName;
              }
              $category->is_active = $request->status;
              $save = $category->save();

              if( $save ){
                  return redirect()->to('all-product-cat')->with('success','Category Created successfully');
              }else{
                  return redirect()->back()->with('fail','Something went wrong, failed to register');
              }
        }

      public function AllProductCategory()
        {
            $site_settings = SiteSettings::first();
            $Productcat = ProductCategory::all();
            return view('dashboard.product.allProductCat',compact(['Productcat','site_settings']));
        }

     public function edit($id)
        {
            $site_settings = SiteSettings::first();
            $id=Crypt::decryptString($id);
            $Productcat = ProductCategory::where('category_id','=',$id)->get();

            return view('dashboard.product.editProductCat',compact(['Productcat','site_settings']));
        }
     public function update(Request $request)
     {
          //Validate Inputs
          $request->validate([
              'cat_name'=>'required',
            //   'sample_image'=>'required|image',
              'status'=>'required',
          ]);


          $category = ProductCategory::find($request->id);

          $category->category_name = $request->cat_name;
          if($request->sample_image)
          {
            $imageName = date('YmdHi').$request->sample_image->getClientOriginalName();
            $request->sample_image->move(public_path('backend/images/CategoryWise/'), $imageName);
            $category->sample_image = $imageName;
          }
          $category->is_active = $request->status;
          $save = $category->save();

          if( $save ){
              return redirect()->to('all-product-cat')->with('success','Category Updated successfully');
          }else{
              return redirect()->back()->with('fail','Something went wrong, failed to register');
          }
     }

}
