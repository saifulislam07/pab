@extends('layouts.admin')

@section('title', 'Registration Invoice: ' . $registration->formatted_id)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3 shadow-sm rounded">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-certificate text-primary"></i> {{ config('app.name', 'PAB') }}
                            <small class="float-right">Date: {{ $registration->created_at->format('d/m/Y') }}</small>
                        </h4>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info mt-4">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong>{{ config('app.name', 'PAB') }}</strong><br>
                            Program Management Team<br>
                            Email: {{ config('mail.from.address', 'admin@pab.com') }}
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                            <strong>{{ $registration->getField('name') ?: ($registration->user->name ?? 'N/A') }}</strong><br>
                            Phone: {{ $registration->getField('mobile') ?: ($registration->user->phone ?? 'N/A') }}<br>
                            Email: {{ $registration->user->email ?? 'N/A' }}
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <b>Invoice #{{ $registration->formatted_id }}</b><br>
                        <br>
                        <b>Program:</b> {{ $registration->program->title }}<br>
                        <b>Registration Date:</b> {{ $registration->created_at->format('M d, Y') }}<br>
                        <b>Status:</b> 
                        <span class="badge badge-{{ $registration->status == 'accept' ? 'success' : ($registration->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row mt-4">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped border">
                            <thead>
                                <tr class="bg-light">
                                    <th>Field Name</th>
                                    <th>Submitted Information</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registration->registration_data as $key => $value)
                                    @php 
                                        $label = ucfirst(str_replace('_', ' ', $key));
                                        $isPhoto = str_contains(strtolower($key), 'photo') || str_contains(strtolower($key), 'image');
                                    @endphp
                                    <tr>
                                        <td width="30%" class="font-weight-bold">{{ $label }}</td>
                                        <td>
                                            @if($isPhoto && $value && is_string($value))
                                                <div class="mb-2">
                                                    <img src="{{ asset('programe/' . $value) }}" class="img-thumbnail" style="max-width: 250px;">
                                                </div>
                                                <a href="{{ asset('programe/' . $value) }}" target="_blank" class="btn btn-xs btn-default">
                                                    <i class="fas fa-external-link-alt"></i> View Original
                                                </a>
                                            @else
                                                {{ is_array($value) ? json_encode($value) : $value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row mt-4">
                    <!-- info column -->
                    <div class="col-6">
                        <p class="text-muted well well-sm shadow-none mt-3">
                            This is an automatically generated receipt for your registration in the program: {{ $registration->program->title }}.
                        </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <p class="lead">Registration Summary</p>

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Registration Fee:</th>
                                    <td>{{ $registration->getField('amount') ?: number_format($registration->program->registration_fee, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Transaction ID:</th>
                                    <td>{{ $registration->getField('trans_id') ?: $registration->transaction_id ?: 'N/A' }}</td>
                                </tr>
                                <tr class="bg-light">
                                    <th>Total Paid:</th>
                                    <td class="font-weight-bold text-success text-xl">
                                        {{ $registration->getField('amount') ?: number_format($registration->program->registration_fee, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print mt-5">
                    <div class="col-12">
                        <a href="javascript:window.print();" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                        
                        @if($registration->status == 'pending')
                            <form action="{{ route('admin.programs.registrations.status', $registration->id) }}" method="POST" class="d-inline float-right ml-2">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="accept">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Approve Registration
                                </button>
                            </form>
                            <form action="{{ route('admin.programs.registrations.status', $registration->id) }}" method="POST" class="d-inline float-right">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="reject">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-ban"></i> Reject
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('admin.programs.registrations', $registration->program_id) }}" class="btn btn-secondary float-right mr-2">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.invoice -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

<style>
@media print {
    .main-footer, .no-print {
        display: none !important;
    }
    .content-wrapper {
        margin-left: 0 !important;
    }
    .invoice {
        border: 0 !important;
        box-shadow: none !important;
    }
}
</style>
@endsection
