<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\ProgramRegistration;
use App\Models\AccountCategory;
use App\Models\Transaction;

echo "Starting Financial Sync...\n";

$feeCategory = AccountCategory::where('name', 'Program Registration Fee')->first();
if (!$feeCategory) {
    die("Category 'Program Registration Fee' not found. Please run seeders first.\n");
}

$acceptedRegs = ProgramRegistration::where('status', 'accept')->get();
echo "Found " . $acceptedRegs->count() . " accepted registrations.\n";

$syncedCount = 0;
foreach ($acceptedRegs as $reg) {
    Transaction::updateOrCreate(
        [
            'reference_id'   => $reg->id,
            'reference_type' => 'program_registration',
        ],
        [
            'account_category_id' => $feeCategory->id,
            'amount'              => $reg->program->registration_fee ?? 0,
            'type'                => 'income',
            'date'                => $reg->created_at,
            'description'         => "Registration Fee for " . $reg->program->title . " - ID: " . $reg->formatted_id,
        ]
    );
    $syncedCount++;
    echo "Synced ID: " . $reg->id . " - Amount: " . ($reg->program->registration_fee ?? 0) . "\n";
}

echo "Sync Completed! $syncedCount records updated.\n";
