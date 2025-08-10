<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إرسال رسالة SMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 text-gray-900">

<div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">إرسال رسالة SMS</h2>

    @if(session('success'))
        <div class="p-3 mb-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-3 mb-3 bg-red-100 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('sms.send') }}">
        @csrf
        <div class="mb-4">
            <label class="block font-medium mb-1">رقم الهاتف</label>
            <input type="text" name="phoneNumber" class="w-full border p-2 rounded" placeholder="مثال: 218911081088">
            @error('phoneNumber') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">الرسالة</label>
            <textarea name="message" class="w-full border p-2 rounded" placeholder="اكتب رسالتك هنا..."></textarea>
            @error('message') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            إرسال
        </button>
    </form>
</div>

</body>
</html>
