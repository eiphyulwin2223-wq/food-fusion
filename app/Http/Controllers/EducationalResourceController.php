<?php

namespace App\Http\Controllers;

use App\Models\EducationalResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EducationalResourceController extends Controller
{
    public function index()
    {
        $pdfs = EducationalResource::where('type', 'pdf')->orderBy('created_at', 'desc')->get();
        $infographics = EducationalResource::where('type', 'infographic')->orderBy('created_at', 'desc')->get();
        $videos = EducationalResource::where('type', 'video')->orderBy('created_at', 'desc')->get();

        return view('educational_resources', compact('pdfs', 'infographics', 'videos'));
    }

    public function store(Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:pdf,infographic,video',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,webp,mp4,webm',
        ]);

        $file = $request->file('file');
        $type = $request->type;

        if ($type === 'pdf' && $file->getSize() > 5 * 1024 * 1024) {
            return back()->withErrors(['file' => 'PDF file must be less than 5MB.']);
        }
        if (in_array($type, ['infographic', 'video']) && $file->getSize() > 10 * 1024 * 1024) {
            return back()->withErrors(['file' => 'File must be less than 10MB.']);
        }

        $extension = $file->getClientOriginalExtension();
        $filename = uniqid() . '.' . $extension;
        $directory = 'educational/' . $type . 's';
        
        $path = $file->storeAs($directory, $filename, 'public');

        EducationalResource::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $type,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()->route('educational_resources.index')->with('status', 'Resource uploaded successfully!');
    }

    public function destroy(EducationalResource $resource)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        Storage::disk('public')->delete($resource->file_path);
        $resource->delete();

        return redirect()->route('educational_resources.index')->with('status', 'Resource deleted successfully!');
    }
}
