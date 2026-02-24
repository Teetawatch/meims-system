<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryFilter = $request->input('categoryFilter');

        $documents = Document::query()
            ->with('course')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->when($categoryFilter, function ($query) use ($categoryFilter) {
                $query->where('category', $categoryFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        $courses = Course::where('is_active', true)->orderBy('course_name_th')->get();

        return view('documents.index', compact('documents', 'courses', 'search', 'categoryFilter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'course_id' => 'nullable|exists:courses,id',
            'is_active' => 'boolean',
            'file' => 'required|file|max:20480',
        ]);

        $fileFile = $request->file('file');
        $filePath = $fileFile->store('documents', 'public');
        $fileType = strtoupper($fileFile->getClientOriginalExtension());
        $size = $fileFile->getSize();

        if ($size >= 1048576) {
            $fileSize = number_format($size / 1048576, 2) . ' MB';
        } else {
            $fileSize = number_format($size / 1024, 2) . ' KB';
        }

        Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'course_id' => $request->course_id,
            'is_active' => $request->has('is_active'),
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
        ]);

        return redirect()->route('documents.index')->with('success', 'เพิ่มเอกสารเรียบร้อยแล้ว');
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'course_id' => 'nullable|exists:courses,id',
            'is_active' => 'boolean',
            'file' => 'nullable|file|max:20480',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'course_id' => $request->course_id,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('file')) {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $fileFile = $request->file('file');
            $data['file_path'] = $fileFile->store('documents', 'public');
            $data['file_type'] = strtoupper($fileFile->getClientOriginalExtension());
            $size = $fileFile->getSize();

            if ($size >= 1048576) {
                $data['file_size'] = number_format($size / 1048576, 2) . ' MB';
            } else {
                $data['file_size'] = number_format($size / 1024, 2) . ' KB';
            }
        }

        $document->update($data);

        return redirect()->route('documents.index')->with('success', 'อัปเดตเอกสารเรียบร้อยแล้ว');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'ลบเอกสารเรียบร้อยแล้ว');
    }
}
