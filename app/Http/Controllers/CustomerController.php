<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Services\CustomerService;

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data['title'] = 'Customers';

        $rows = 40;

        if ($request->qry == "") {
            $this->data['entities'] = User::where('role', 'customer')->orderBy('created_at', 'DESC')->paginate($rows);
        } else {
            $this->data['entities'] = User::where('role', 'customer')->orWhere('mobile_number', 'LIKE', '%' . $request->qry . '%')
                ->orWhere('email', 'LIKE', '%' . $request->qry . '%')
                ->orWhere('first_name', 'LIKE', '%' . $request->qry . '%')
                ->orWhere('last_name', 'LIKE', '%' . $request->qry . '%')
                ->orderBy('created_at', 'DESC')
                ->paginate($rows)
                ->appends($request->only('qry'));
        }

        return view('customers', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {}

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $customer)
    {
        $this->data['title'] = 'Customer';

        $this->data['customer'] = $customer;
        $this->data['countries'] = Country::all();

        return view('customers_show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function updateStatus(Request $request, User $customer)
    {
        if ($request->has('activateBtn')) {

            $customer->update([
                'status' => CustomerService::ACTIVE,
                'approved_by' => $request->user()->id
            ]);

            if ($customer->email_verified_at == null) {
                $customer->update([
                    'email_verified_at' => date('Y-m-d')
                ]);
            }

            return redirect()->route('customers.show', [
                'customer' => $customer->id
            ])->with('success', 'Account activated successfully.!');
        }

        if ($request->has('suspendBtn')) {
            $customer->update([
                'status' => CustomerService::SUSPENDED
            ]);

            return redirect()->route('customers.show', [
                'customer' => $customer->id
            ])->with('success', 'Account suspended successfully.!');
        }
    }

    public function saveProfile(Request $request, User $customer)
    {
        $this->validate($request, [
            'inputCountry' => 'required',
            'inputState' => 'required',
            'inputCity' => 'required',
            'inputGender' => 'required'
        ]);

        $customer->update([
            'first_name' => $request->inputFirstName,
            'last_name' => $request->inputLastName,
            'gender' => $request->inputGender,
            'date_of_birth' => $request->inputDateOfBirth,
            'address' => $request->inputAddress,
            'country_id' => $request->inputCountry,
            'state_id' => $request->inputState,
            'city_id' => $request->inputCity
        ]);

        return redirect()->route('customers.show', [
            'customer' => $customer->id
        ])->with('success', 'Profile updated successfully');
    }

    public function changePassword(Request $request, User $customer)
    {
        $this->validate($request, [
            'newPassword' => [
                'required',
                'confirmed'
            ]
        ]);

        $customer->update([
            'password' => Hash::make($request->newPassword)
        ]);

        return redirect()->route('customers.show', [
            'customer' => $customer->id
        ])->with('success', 'Password updated successfully');
    }

    public function changePhoto(Request $request, User $customer)
    {
        $this->validate($request, [
            'photo_file' => 'mimes:jpeg,bmp,png|max:20480'
        ]);

        if ($request->hasFile('photo_file')) {
            if ($request->file('photo_file')->isValid()) {
                $result = $this->doUpload($request->file('photo_file'), "account/photograph", md5($customer->id));
                if (! $result) {
                    return redirect()->route('profile')->with('error', 'Photo upload not successful');
                }
            }
        }

        return redirect()->route('customers.show', [
            'customer' => $customer->id
        ])->with('success', 'Photo updated successfully');
    }

    private function doUpload($file, $destination, $filename)
    {
        try {
            $path = $file->storeAs($destination, $filename);
        } catch (\Aws\S3\Exception\S3Exception $ex) {
            return false;
        }
        return true;
    }
}
