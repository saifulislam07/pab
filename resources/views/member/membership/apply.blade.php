@extends('layouts.admin')

@section('title', 'Apply for Membership')
@section('page_title', 'Apply for Membership')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Select Your Plan</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info"></i> Notice!</h5>
                    Lifetime membership is valid for 10 years as per our policy.
                </div>

                <form action="{{ route('member.membership.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label>Membership Type</label>
                        <select name="membership_type" class="form-control" required>
                            <option value="yearly">Yearly Membership</option>
                            <option value="lifetime">Lifetime Membership (10 Years)</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Payment Method</label>
                                <select name="payment_method" class="form-control" required>
                                    <option value="bKash">bKash</option>
                                    <option value="Rocket">Rocket</option>
                                    <option value="Nagad">Nagad</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Transaction ID</label>
                                <input type="text" name="transaction_id" class="form-control" placeholder="Enter ID" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Amount Paid (TK)</label>
                                <input type="number" step="0.01" name="membership_amount" class="form-control" placeholder="0.00" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Payment Proof (Screenshot/Receipt)</label>
                        <div class="custom-file">
                            <input type="file" name="payment_proof" class="custom-file-input" id="payment_proof" required>
                            <label class="custom-file-label" for="payment_proof">Choose image</label>
                        </div>
                        <small class="text-muted">Maximum size 2MB (JPG, PNG, GIF)</small>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
