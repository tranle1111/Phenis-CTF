<?php

use App\Models\Book;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\BookController; // Đảm bảo bạn đã import BookController

// Route gốc
Route::get('/', function () {
    return redirect('/books'); // Chuyển hướng trang chủ về /books
});

// Hiển thị danh sách sách
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Thêm sách
Route::post('/books', [BookController::class, 'store'])->name('books.store');

// Xóa sách
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
