<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::paginate(15);
        return CustomerResource::collection($customers);
    }
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        return response()->json($customer, 201);
    }
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return response()->json($customer);
    }
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
    public function trashed()
    {
        $trashed = Customer::onlyTrashed()->paginate(15);
        return CustomerResource::collection($trashed);
    }
    public function restore($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->restore();

        return response()->json($customer);
    }
    public function forceDelete($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->forceDelete();
        return response()->json(null, 204);
    }
}
