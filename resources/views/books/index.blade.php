<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Sách</title>
    <!-- Thêm FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Toàn bộ body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Tiêu đề */
        h1, h2 {
            text-align: center;
            color: #333;
        }

        /* Form thêm sách */
        .form-container {
            background-color: #fff;
            padding: 20px;
            margin: 20px auto;
            width: 60%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            padding-right:0.1%;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        /* Bảng sách */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: center;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        /* Responsive */
        @media screen and (max-width: 768px) {
            .form-container {
                width: 90%;
            }

            table {
                width: 95%;
            }
        }

        /*delete*/
        .confirm-delete {
            display: none;
            margin-top: 10px;
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .confirm-delete button {
            margin-top: 10px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #f44336;
            color: white;
            cursor: pointer;
        }

        .confirm-delete button:hover {
            background-color: #e53935;
        }

        .cancel-btn {
            background-color: #9e9e9e;
        }

        .cancel-btn:hover {
            background-color: #757575;
        }

        /* Nút xóa */
        .delete-btn {
            padding: 8px 12px;
            background-color: rgba(185, 185, 185, 0.5);
            color:rgba(244, 67, 54, 0.81); /* Màu đỏ cho chữ */
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
            border: none; /* Xóa viền */
        }

        .delete-btn:hover {
            background-color: #f44336;
            color: white;
        }

        /*timeout delete*/
        .alert-message {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 999;
            text-align: center;
        }

    </style>
</head>
<body>
    <h1>Danh sách Sách</h1>

    <!-- Form Thêm Sách -->
    <div class="form-container">
        <h2>Thêm Sách Mới</h2>
        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            <label for="title">Tiêu đề:</label>
            <input type="text" name="title" required>

            <label for="author">Tác giả:</label>
            <input type="text" name="author" required>

            <label for="publisher">Nhà xuất bản:</label>
            <input type="text" name="publisher">

            <label for="year">Năm xuất bản:</label>
            <input type="number" name="year">

            <button type="submit">Thêm Sách</button>
        </form>
    </div>

    <!-- Hiển thị danh sách sách -->
    <table>
        <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Tác giả</th>
                <th>Nhà xuất bản</th>
                <th>Năm xuất bản</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->publisher }}</td>
                    <td>{{ $book->year }}</td>
                    <td>
                        <!-- Thùng rác FontAwesome -->
                        <button class="delete-btn" onclick="confirmDelete({{ $book->id }})">
                            <i class="fas fa-trash"></i>
                        </button>

                        <!-- Form xác nhận xóa -->
                        <div id="confirm-delete-{{ $book->id }}" class="confirm-delete">
                            <p>Bạn có chắc chắn muốn xóa sách này?</p>
                            <form id="delete-form-{{ $book->id }}" action="{{ route('books.destroy', $book->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deleteBook(event, {{ $book->id }})">Xác nhận</button>
                                <button type="button" class="cancel-btn" onclick="cancelDelete({{ $book->id }})">Hủy</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div id="alert-message" class="alert-message">Đã xóa thành công!</div>

    <script>
        // Hiển thị form xác nhận khi nhấn vào thùng rác
        function confirmDelete(bookId) {
            document.getElementById('confirm-delete-' + bookId).style.display = 'block';
        }

        // Ẩn form xác nhận khi nhấn hủy
        function cancelDelete(bookId) {
            document.getElementById('confirm-delete-' + bookId).style.display = 'none';
        }

        // Xử lý khi xác nhận xóa
        function deleteBook(event, bookId) {
            // Ngừng gửi form ngay lập tức
            event.preventDefault();

            // Hiển thị thông báo đã xóa thành công
            var alertMessage = document.getElementById('alert-message');
            alertMessage.style.display = 'block';

            // Đợi 0.5s trước khi ẩn form xác nhận
            setTimeout(function() {
                document.getElementById('confirm-delete-' + bookId).style.display = 'none';
            });

            // Ẩn thông báo sau 1.5s
            setTimeout(function() {
                alertMessage.style.display = 'none';
            }, 2000);

            // Tiến hành gửi form xóa sách sau khi hoàn tất
            setTimeout(function() {
                document.getElementById('delete-form-' + bookId).submit();
            }, 500);
        }
    </script>
</body>
</html>
