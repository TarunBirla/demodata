<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookIssue;

class LibraryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $schoolId = $user->school_id ?? 1;

        $books = Book::where('school_id', $schoolId)->latest()->get();
        $issues = BookIssue::with(['book', 'user'])->where('school_id', $schoolId)->latest()->get();

        return view('admin.library.index', compact('books', 'issues'));
    }

    public function storeBook(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:100',
            'category' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1',
            'shelf_location' => 'nullable|string|max:100',
        ]);

        Book::create(array_merge($validated, [
            'school_id' => $schoolId,
            'available_quantity' => $validated['quantity'],
        ]));

        return back()->with('success', 'Book added to Library Catalog successfully!');
    }

    public function issueBook(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
        ]);

        $book = Book::findOrFail($validated['book_id']);
        if ($book->available_quantity <= 0) {
            return back()->with('error', 'Book is currently out of stock.');
        }

        BookIssue::create(array_merge($validated, [
            'school_id' => $schoolId,
            'status' => 'issued',
        ]));

        $book->decrement('available_quantity');

        return back()->with('success', 'Book issued successfully!');
    }
}
