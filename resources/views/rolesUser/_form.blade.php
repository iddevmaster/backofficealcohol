@csrf
@php
    $editing = isset($role);
    $selected = old(
        'permissions',
        $selected ?? ($editing ? $role->permissions->pluck('id')->toArray() : [])
    );
@endphp


<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <div>
    <label class="block text-sm mb-1">Name *</label>
    <input name="name" class="w-full rounded border-gray-300" required value="{{ old('name',$role->name ?? '') }}">
    @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>
  <div>
    <label class="block text-sm mb-1">Guard *</label>
    <select name="guard_name" class="w-full rounded border-gray-300" required>
      @foreach(($guards ?? ['web','api']) as $g)
      <option value="{{ $g }}" @selected(old('guard_name',$role->guard_name ?? 'web')===$g)>{{ $g }}</option>
      @endforeach
    </select>
  </div>
  <div>
    <label class="block text-sm mb-1">Org *</label>
    <input type="number" name="org_id" class="w-full rounded border-gray-300" required value="{{ old('org_id',$role->org_id ?? 1) }}">
  </div>
</div>
<div class="mt-4">
  <label class="block text-sm mb-2">Permissions</label>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 max-h-80 overflow-auto p-2 border rounded">
    @foreach($permissions as $p)
      <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="permissions[]" value="{{ $p->id }}" @checked(in_array($p->id,$selected))>
        <span>{{ $p->name }} <span class="text-slate-500 text-xs">({{ $p->guard_name }})</span></span>
      </label>
    @endforeach
  </div>
</div>



