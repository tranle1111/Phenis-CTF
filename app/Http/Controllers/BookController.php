<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Hiển thị danh sách sách
    public function index()
    {
        $books = Book::all(); // Lấy tất cả sách
        return view('books.index', compact('books'));
    }

    // Thêm sách mới
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y')),
        ]);

        // Tạo sách mới
        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'year' => $request->year
        ]);

        return redirect('/books')->with('success', 'Sách đã được thêm thành công!');
    }

    // Xóa sách
    public function destroy(Book $book)
    {
        $book->delete(); // Xóa sách
        return redirect('/books')->with('success', 'Sách đã được xóa!');
    }
}
