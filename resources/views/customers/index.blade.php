@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Customers</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('customers.create') }}" class="btn btn-primary">Add New Customer</a>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>UserID</th>
                <th>Email</th>
                <th>Account Type</th>
                <th>Status</th>
                <th>Login Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $index => $customer)
            <tr>
                <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $index + 1 }}</td>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->account_type }}</td>
                <td>{{ $customer->status }}</td>
                <td>{{ $customer->last_login }}</td>
                <td>
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end"> 
    {{ $customers->links() }}
</div>
@endsection