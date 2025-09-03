<x-app-layout>
<h1 class="text-xl font-semibold mb-4">เพิ่มแผนก</h1>
<form action="{{ route('users.store') }}" method="post" class="bg-white p-6 rounded-lg border max-w-3xl mx-auto">
  @include('usersUser._form', ['user' => new \App\Models\User()])
  <div class="mt-6 flex gap-2">
    <button class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">บันทึก</button>
    <a href="{{ route('users.index') }}" class="rounded-md border px-4 py-2 hover:bg-gray-50">ยกเลิก</a>
  </div>
</form>
</x-app-layout>
