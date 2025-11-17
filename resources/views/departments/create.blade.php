<x-app-layout>
<h1 class="text-xl font-semibold mb-4">เพิ่มฝ่าย</h1>
<form action="{{ route('departments.store') }}" method="post" class="max-w-xl bg-white p-6 rounded-lg border">
  @include('departments._form')

  <div class="flex items-center gap-3">
  <button type="submit"
          class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
    บันทึก
  </button>
  <a href="{{ route('departments.index') }}"
     class="inline-flex items-center rounded-md border px-4 py-2 hover:bg-gray-50">
    ยกเลิก
  </a>
</div>
</form>
</x-app-layout>
