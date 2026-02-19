@extends('layouts.admin')

@section('title', 'SMTP Settings')
@section('page_title', 'SMTP Settings')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.settings.smtp.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-3 text-primary"><i class="fas fa-envelope mr-1"></i> Mail Configuration</h4>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mail Mailer</label>
                                <select name="mail_mailer" class="form-control" required>
                                    <option value="smtp" {{ old('mail_mailer', $setting->mail_mailer ?? '') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                    <option value="mailgun" {{ old('mail_mailer', $setting->mail_mailer ?? '') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                    <option value="sendmail" {{ old('mail_mailer', $setting->mail_mailer ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Mail Host</label>
                                <input type="text" name="mail_host" class="form-control" placeholder="e.g., smtp.gmail.com" value="{{ old('mail_host', $setting->mail_host ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label>Mail Port</label>
                                <input type="text" name="mail_port" class="form-control" placeholder="e.g., 587" value="{{ old('mail_port', $setting->mail_port ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mail Username</label>
                                <input type="text" name="mail_username" class="form-control" placeholder="SMTP Username" value="{{ old('mail_username', $setting->mail_username ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label>Mail Password</label>
                                <div class="input-group">
                                    <input type="password" name="mail_password" id="mail_password" class="form-control" placeholder="SMTP Password" value="{{ old('mail_password', $setting->mail_password ?? '') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('mail_password')">
                                            <i class="fas fa-eye" id="toggle_mail_password"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Mail Encryption</label>
                                <select name="mail_encryption" class="form-control">
                                    <option value="" {{ old('mail_encryption', $setting->mail_encryption ?? '') == '' ? 'selected' : '' }}>None</option>
                                    <option value="tls" {{ old('mail_encryption', $setting->mail_encryption ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ old('mail_encryption', $setting->mail_encryption ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mail From Address</label>
                                <input type="email" name="mail_from_address" class="form-control" placeholder="noreply@example.com" value="{{ old('mail_from_address', $setting->mail_from_address ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label>Mail From Name</label>
                                <input type="text" name="mail_from_name" class="form-control" placeholder="Site Name" value="{{ old('mail_from_name', $setting->mail_from_name ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Update SMTP Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById('toggle_' + inputId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
@endsection
