<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Models\Product;
use App\Models\UnitDefinition;
use App\Models\FinalStockTable;
use App\Models\ProductCategory;
use App\Models\SubCategoryOne;
use App\Models\SiteSettings;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $site_settings = SiteSettings::first();
        $subCategoryOne = SubCategoryOne::where('is_active', 1)->get();
        $UnitDefinition = UnitDefinition::all();

        return view('dashboard.product.product', compact(['subCategoryOne', 'UnitDefinition','site_settings']));
    }


    public function AllProducts()
    {
        $site_settings = SiteSettings::first();
        $Product = Product::leftJoin('sub_category_one', 'sub_category_one.sc_one_id', '=', 'products.sc_one_id')
            ->leftJoin('unit_definition', 'unit_definition.unit_id', '=', 'products.unit_type')
            ->select('products.*', 'sub_category_one.sc_one_name', 'unit_definition.unit_name', 'unit_definition.unit_id') //, 'final_stock_table.final_quantity')
            ->get();

        return view('dashboard.product.allProduct', compact(['Product','site_settings']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)

    {

        // Validate Inputs
        // dd($request->all());

        $request->validate([
            'sc_one_id' => 'required',
            'unit_type' => 'required',
            'product_name' => 'required',
            'status' => 'required',
        ]);
        $Product = new Product();

        if($request->product_bar_code){
            $request->validate([
                'product_bar_code' => 'unique:products,barcode'
            ]);
            $Product->barcode = $request->product_bar_code;
        }
        else{
            $Product->barcode = time() . mt_rand(100, 999);
        }

        $images = array();
        $imagepaths = array();

        if ($files = $request->file('images')) {
            foreach ($files as $file) {

                $imageName = date("dmy") . $file->getClientOriginalName();
                $path = url('/') . "/backend/images/product/" . $imageName;
                $file->move(public_path('backend/images/product/'), $imageName);
                $images[] = $imageName;
                $imagepaths[] = $path;
            }
            $new_image = implode(',', $images);
            $new_imagepaths = implode(',', $imagepaths);
            $Product->product_image = $new_image;
            $Product->image_path = $new_imagepaths;
        }



        $Product->sc_one_id = $request->sc_one_id;
        $Product->unit_type = $request->unit_type;
        $Product->product_name = $request->product_name;
        $Product->is_active = $request->status;
        $save = $Product->save();

        if ($save) {
            return redirect()->back()->with('success', 'Item Created Successfully');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $site_settings = SiteSettings::first();
        $id = Crypt::decryptString($id);
        $Products = Product::where('product_id', '=', $id)->get();
        $subCategoryOne = SubCategoryOne::all();
        $UnitDefinition = UnitDefinition::all();
        $final_quantity = FinalStockTable::where('product_id', '=', $id)->first();

        return view('dashboard.product.editProduct', compact(['final_quantity', 'Products', 'subCategoryOne', 'UnitDefinition','site_settings']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate Inputs

        $request->validate([
            'sc_one_id' => 'required',
            'unit_type' => 'required',
            'product_name' => 'required',
            'status' => 'required',
        ]);

        $Product = Product::find($request->id);

        $Product->sc_one_id = $request->sc_one_id;
        $Product->unit_type = $request->unit_type;
        $Product->product_name = $request->product_name;
        $Product->is_active = $request->status;

        if ($request->file('images')) {

            if ($Product->product_image) {

                $imgs = explode(',', $Product->product_image);
                foreach ($imgs as $img) {
                    $destination = 'backend/images/product/' . $img;
                    if (File::exists($destination)) {
                        File::delete($destination);
                    }
                }
            }

            $images = array();
            $imagepaths = array();
            if ($files = $request->file('images')) {
                foreach ($files as $file) {

                    $imageName = date("dmy") . $file->getClientOriginalName();
                    $path = url('/') . "/backend/images/product/" . $imageName;
                    $file->move(public_path('backend/images/product/'), $imageName);
                    $images[] = $imageName;
                    $imagepaths[] = $path;
                }
            }

            $new_image = implode(',', $images);
            $new_imagepaths = implode(',', $imagepaths);
            $Product->product_image = $new_image;
            $Product->image_path = $new_imagepaths;
        }

        $save = $Product->update();

        if ($save) {
            return redirect()->to('all-products')->with('success', 'Item Updated successfully');
        } else {
            return redirect()->back()->with('fail', 'Something went wrong, failed to register');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createBarcode($id)
    {
        $id = Crypt::decryptString($id);
        $Product = Product::where('product_id', '=', $id)->first();
        // dd($id);
        if ($Product->barcode == null) {
            $Product->barcode = sprintf("%04d", $Product->product_id);
            $Product->update();
            return redirect()->back()->with('success', 'Barcode Generated successfully');
        }

        return redirect()->back()->with('fail', 'Already Have a Barcode');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printBarcode($id)
    {
        $site_settings = SiteSettings::first();
        $id = Crypt::decryptString($id);
        $Product = Product::where('product_id', '=', $id)->first();
        $barcode = $Product->barcode;
        $final_quantity = FinalStockTable::where('product_id', '=', $id)->orderBy('stock_id', 'DESC')->first();

        // dd($final_quantity);

        if ($Product->barcode == null) {
            return redirect()->back()->with('fail', 'Barcode is Not Generated Yet');
        }

        if ($final_quantity == null) {
            return redirect()->back()->with('fail', 'Product is not purchased yet');
        }

        return view('sales.print.printBarcode', compact(['final_quantity', 'barcode', 'Product','site_settings']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
