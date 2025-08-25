<x-app-layout>
<h1 class="text-xl font-semibold mb-4">แก้ไขสาขา</h1>
<form action="{{ route('branches.update', $branch) }}" method="post" class="bg-white p-6 rounded-lg border max-w-3xl">
  @method('PUT')
  @include('branches._form')
</form>
</x-app-layout>
