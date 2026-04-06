<?php

require __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$reg = \App\Models\ProgramRegistration::latest()->first();
if ($reg) {
    echo "Keys in registration_data:\n";
    print_r(array_keys($reg->registration_data));
    echo "\nFull Data:\n";
    print_r($reg->registration_data);
} else {
    echo "No registrations found.";
}
