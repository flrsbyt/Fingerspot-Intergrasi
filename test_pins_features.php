<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\FingerspotService;
use App\Models\Pin;
use App\Models\Userinfo;

echo "=== TESTING PINS FEATURES ===\n\n";

// 1. Test Get All PIN dari database
echo "1. Testing Get All PIN dari database...\n";
$pins = Pin::all();
echo "Total PIN di database: " . $pins->count() . "\n";
foreach ($pins as $pin) {
    echo "  - PIN: {$pin->pin}, Device: {$pin->device_name}, Active: " . ($pin->is_active ? 'Yes' : 'No') . "\n";
}
echo "\n";

// 2. Test Check Connection untuk setiap PIN
echo "2. Testing Check Connection untuk setiap PIN...\n";
$fingerspot = new FingerspotService();
foreach ($pins as $pin) {
    echo "Testing PIN: {$pin->pin}...\n";
    $result = $fingerspot->checkConnection($pin->pin);
    echo "  Online: " . ($result['online'] ? 'Yes' : 'No') . "\n";
    echo "  Status Code: " . ($result['status_code'] ?? 'N/A') . "\n";
    if (isset($result['data'])) {
        echo "  Data: " . json_encode($result['data']) . "\n";
    }
    echo "\n";
}

// 3. Test Get All PIN dari mesin untuk setiap active device
echo "3. Testing Get All PIN dari mesin untuk setiap active device...\n";
$activePins = Pin::where('is_active', true)->get();
foreach ($activePins as $pin) {
    echo "Testing Get All PIN dari mesin: {$pin->pin}...\n";
    $result = $fingerspot->getAllPin($pin->pin);
    echo "  Success: " . ($result['success'] ? 'Yes' : 'No') . "\n";
    echo "  Full Response: " . json_encode($result, JSON_PRETTY_PRINT) . "\n";
    if ($result['success'] && isset($result['data']['data'])) {
        $pinData = $result['data']['data'];
        echo "  Total PIN dari mesin: " . count($pinData) . "\n";
        if (is_array($pinData) && count($pinData) > 0) {
            echo "  Sample PINs: ";
            $samples = array_slice($pinData, 0, 5);
            foreach ($samples as $sample) {
                $pinValue = is_array($sample) ? ($sample['pin'] ?? $sample['PIN'] ?? null) : $sample;
                echo $pinValue . ", ";
            }
            echo "\n";
        }
    } else {
        echo "  Error: " . ($result['message'] ?? 'Unknown error') . "\n";
    }
    echo "\n";
}

// 3.5 Test Get Userinfo dari mesin untuk setiap active device
echo "3.5 Testing Get Userinfo dari mesin untuk setiap active device...\n";
foreach ($activePins as $pin) {
    echo "Testing Get Userinfo dari mesin: {$pin->pin}...\n";
    $result = $fingerspot->getUserinfo($pin->pin, ['pin' => 'all']);
    echo "  Success: " . ($result['success'] ? 'Yes' : 'No') . "\n";
    echo "  Full Response: " . json_encode($result, JSON_PRETTY_PRINT) . "\n";
    if ($result['success'] && isset($result['data']['data'])) {
        $userinfoData = $result['data']['data'];
        echo "  Total Userinfo dari mesin: " . count($userinfoData) . "\n";
        if (is_array($userinfoData) && count($userinfoData) > 0) {
            echo "  Sample Userinfos: ";
            $samples = array_slice($userinfoData, 0, 3);
            foreach ($samples as $sample) {
                echo json_encode($sample) . ", ";
            }
            echo "\n";
        }
    } else {
        echo "  Error: " . ($result['message'] ?? 'Unknown error') . "\n";
    }
    echo "\n";
}

// 4. Test Userinfo database
echo "4. Testing Userinfo database...\n";
$userinfos = Userinfo::all();
echo "Total Userinfo di database: " . $userinfos->count() . "\n";
if ($userinfos->count() > 0) {
    echo "Sample Userinfos:\n";
    foreach ($userinfos->take(5) as $userinfo) {
        echo "  - PIN: {$userinfo->pin}, Name: {$userinfo->name}, Dept: " . ($userinfo->department ?? 'N/A') . "\n";
    }
} else {
    echo "  Tidak ada data Userinfo di database lokal.\n";
    echo "  Gunakan Get Userinfo untuk mengambil data user dari mesin.\n";
}
echo "\n";

echo "=== TESTING SELESAI ===\n";
