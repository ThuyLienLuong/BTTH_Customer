<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index()
    {
        $customers = Customer::select('id', 'email', 'account_type', 'status', 'last_login')
                             ->paginate(10);
        return view('customers.index', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:6',
            'status' => 'required|in:active,inactive',
            'account_type' => 'required|in:admin,user',
        ]);

        $customer = new Customer([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'status' => $request->get('status'),
            'account_type' => $request->get('account_type'),
            'last_login' => $request->get('last_login'),
        ]);

        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Customer created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'email|unique:customers,email,' . $id,
            'password' => 'min:6',
            'status' => 'in:active,inactive',
            'account_type' => 'in:admin,user',
        ]);

        $customer = Customer::findOrFail($id);

        if ($request->has('email')) {
            $customer->email = $request->get('email');
        }
        if ($request->has('password')) {
            $customer->password = Hash::make($request->get('password'));
        }
        if ($request->has('status')) {
            $customer->status = $request->get('status');
        }
        if ($request->has('account_type')) {
            $customer->account_type = $request->get('account_type');
        }
        if ($request->has('last_login')) {
            $customer->last_login = $request->get('last_login');
        }

        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }
    public function create()
{
    return view('customers.create');
}

public function edit($id)
{
    $customer = Customer::findOrFail($id);
    return view('customers.edit', compact('customer'));
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }
}