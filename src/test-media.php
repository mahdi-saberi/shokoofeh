<?php

require_once 'vendor/autoload.php';

use App\Models\ProductMedia;
use Illuminate\Support\Facades\Storage;

echo "Testing ProductMedia functionality...\n";

// Get video media
$media = ProductMedia::where('file_type', 'video')->first();

if ($media) {
    echo "Found video media:\n";
    echo "ID: " . $media->id . "\n";
    echo "File path: " . $media->file_path . "\n";
    echo "File type: " . $media->file_type . "\n";
    echo "MIME type: " . $media->mime_type . "\n";
    echo "Original name: " . $media->original_name . "\n";
    echo "File URL: " . $media->file_url . "\n";
    
    // Check if file exists in storage
    if (Storage::disk('public')->exists($media->file_path)) {
        echo "File exists in storage: YES\n";
        echo "File size: " . Storage::disk('public')->size($media->file_path) . " bytes\n";
    } else {
        echo "File exists in storage: NO\n";
    }
} else {
    echo "No video media found\n";
} 