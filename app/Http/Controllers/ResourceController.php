<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    public function index()
    {
        $pdfs = Resource::where('type', 'pdf')->orderBy('created_at', 'desc')->get();
        $videos = Resource::where('type', 'video')->orderBy('created_at', 'desc')->get();

        return view('resources', compact('pdfs', 'videos'));
    }

    public function store(Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:pdf,video',
            'file' => 'required|file|mimes:pdf,mp4,webm',
        ]);

        $file = $request->file('file');
        $type = $request->type;

        if ($type === 'pdf' && $file->getSize() > 5 * 1024 * 1024) {
            return back()->withErrors(['file' => 'PDF file must be less than 5MB.']);
        }
        if ($type === 'video' && $file->getSize() > 10 * 1024 * 1024) {
            return back()->withErrors(['file' => 'Video file must be less than 10MB.']);
        }

        $extension = $file->getClientOriginalExtension();
        $filename = uniqid() . '.' . $extension;
        $directory = $type . 's';
        
        $path = $file->storeAs($directory, $filename, 'public');

        Resource::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $type,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()->route('resources.index')->with('status', 'Resource uploaded successfully!');
    }

    public function destroy(Resource $resource)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        Storage::disk('public')->delete($resource->file_path);
        $resource->delete();

        return redirect()->route('resources.index')->with('status', 'Resource deleted successfully!');
    }
}
