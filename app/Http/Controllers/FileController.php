<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        try {
            // Get the Bearer token from the Authorization header
            $token = $request->bearerToken();

            // Get the secret key from .env
            $secretKey = env('API_SECRET_KEY');

            // Verify the token
            if (!$token || $token !== $secretKey) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 401);
            }

            // Validate the request
            $request->validate([
                'file' => 'required|file|mimes:nc|max:10240', // Max 10MB, .nc files
            ]);

            // Get the file from the request
            $file = $request->file('file');

            // Generate a unique filename
            $fileName = $file->getClientOriginalName();

            // Get the storage path from .env
            $storagePath = env('FILE_STORAGE_PATH', '/srv/data');

            // Store the file
            $path = $file->move($storagePath, $fileName);

            // Return a response
            return response()->json([
                'message' => 'File uploaded successfully',
                'path' => $path->getPathname(),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'File upload failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
