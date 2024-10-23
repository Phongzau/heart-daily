@extends('layouts.client')

@section('css-chat')
    <style>
        /* Form */
        #chat3 .form-control {
            border-color: transparent;
        }

        #chat3 .form-control:focus {
            border-color: transparent;
            box-shadow: inset 0 0 0 1px transparent;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 10px;
            display: flex;
            align-items: center;
        }

        /* Textarea */
        .textarea-custom {
            border-radius: 20px;
            border: 1px solid #ced4da;
            background-color: #e9ecef;
            padding: 10px;
            resize: none;
            outline: none;
            transition: border-color 0.3s;
            flex-grow: 1;
            margin: 0 10px;
            max-height: 100px;
            line-height: 1.5;
        }

        .textarea-custom:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Nút gửi */
        .send-button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }

        .send-button:hover {
            background-color: #0056b3;
        }

        /* Biểu tượng đính kèm */
        .label-file-icon {
            font-size: 1.5rem;
            margin-right: 10px;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        /* Danh sách người dùng */
        .user-list-container {
            max-height: 500px;
            overflow-y: auto;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .user-list-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .user-list-item:hover {
            background-color: #e9ecef;
            cursor: pointer;
        }

        .user-list-container a {
            text-decoration: none;
        }

        /* Hình đại diện */
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            position: relative;
        }

        .user-avatar img {
            width: 100%;
            height: auto;
            border-radius: 50%;
        }

        .user-avatar .badge-dot {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #28a745;
            border: 2px solid white;
        }

        /* Thông tin người dùng */
        .user-info {
            flex-grow: 1;
        }

        .user-info p {
            margin: 0;
        }

        .user-name {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .user-status,
        .user-time {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .badge {
            font-size: 0.9rem;
        }

        /* Tiêu đề */
        h5.font-weight-bold.text-center.text-lg {
            font-size: 2rem;
        }

        /* Tùy chỉnh thanh cuộn */
        #chat-container {
            position: relative;
            height: 400px;
            overflow-y: auto;
        }

        /* Kích thước thanh cuộn */
        #chat-container::-webkit-scrollbar {
            width: 10px;
        }

        /* Đường ray thanh cuộn */
        #chat-container::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 5px;
        }

        /* Phần thanh cuộn mà người dùng kéo */
        #chat-container::-webkit-scrollbar-thumb {
            background: #c0c0c0;
            border-radius: 5px;
        }

        /* Màu khi di chuột qua thanh cuộn */
        #chat-container::-webkit-scrollbar-thumb:hover {
            background: #a0a0a0;
        }
    </style>
@endsection

@section('section')
    @livewire('chat-component', ['user_id' => $id])
@endsection
@section('js-chat')
    <script>
        function handleKeyDown(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                event.target.closest('form').dispatchEvent(new Event('submit'));
            }
        }
        document.addEventListener("DOMContentLoaded", function() {
            const chatContainer = document.getElementById("chat-container");

            function scrollToBottom() {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
            scrollToBottom();
            Livewire.on('messageSent', () => {
                scrollToBottom();
            });
        });
    </script>
@endsection
