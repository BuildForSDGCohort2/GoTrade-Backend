<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;

class DefaultController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $this->data['title'] = 'Dashboard';
        $this->data['customers'] = User::where('role', 'customer')->get()->count();
        $this->data['traders'] = User::where('role', 'trader')->get()->count();
        $this->data['products'] = Product::all()->count();
        $this->data['orders'] = 0;
        return view('dashboard', $this->data);
    }

    public function profile(Request $request)
    {
        $this->data['title'] = 'Profile';
        return view('profile', $this->data);
    }
}
