@php
  $editing = isset($employee);
  $oldOrg = old('org_id', $employee->org_id ?? '');
  $oldBrn = old('brn_id', $employee->brn_id ?? '');
  $oldDpm = old('dpm_id', $employee->dpm_id ?? '');
  $oldPre = old('dpm_id', $employee->prefix_id ?? '');
  
@endphp

<div x-data="{
      org: '{{ $oldOrg }}',
      brn: '{{ $oldBrn }}',
      dpm: '{{ $oldDpm }}',
      prefix: '{{ $oldPre }}',
      branches: @js($branches),        // [{id,name,org_id}]
      departments: @js($departments),  // [{id,name,brn_id}]
      brnList(){ return this.branches.filter(b=> String(b.org_id)===String(this.org)); },
      dpmList(){ return this.departments.filter(d=> String(d.brn_id)===String(this.brn)); },
      resetBrn(){ this.brn=''; this.resetDpm(); },
      resetDpm(){ this.dpm=''; }
  }" class="grid grid-cols-1 md:grid-cols-3 gap-4">

  <div class="md:col-span-1">
    <label class="block text-sm font-medium mb-1">EMP ID *</label>
    <input name="emp_id" required class="w-full rounded border-gray-300"
           value="{{ old('emp_id', $employee->emp_id ?? '') }}">
    @error('emp_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>




        <div>
      <label class="block text-sm font-medium mb-1">คำนำหน้า (prefix)</label>
      <select name="prefix_id" x-model="prefixs"
              class="w-full rounded border-gray-300">
        <option value="" disabled>-- เลือก --</option>
            @foreach(($prefixs ?? []) as $t)
      <option value="{{ $t->id }}" @selected(old('prefix_id', $user->prefix_id ?? '') == $t->id)>{{ $t->name }} ({{ $t->id }})</option>
    @endforeach
      </select>
      @error('prefix') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

  <div>
    <label class="block text-sm font-medium mb-1">ชื่อ *</label>
    <input name="first_name" required class="w-full rounded border-gray-300"
           value="{{ old('first_name', $employee->first_name ?? '') }}">
    @error('first_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>


  

  <div>
    <label class="block text-sm font-medium mb-1">สกุล *</label>
    <input name="last_name" required class="w-full rounded border-gray-300"
           value="{{ old('last_name', $employee->last_name ?? '') }}">
    @error('last_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">โทรศัพท์</label>
    <input name="phone" class="w-full rounded border-gray-300"
           value="{{ old('phone', $employee->phone ?? '') }}">
    @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">รูปภาพ</label>
    <input type="file" name="image" accept="image/*" class="w-full rounded border-gray-300">
    @error('image')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
    @if($editing && $employee->image_url)
      <img src="{{ $employee->image_url }}" class="mt-2 h-16 w-16 rounded object-cover" alt="">
    @endif
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">องค์กร (Org) *</label>
    <select name="org_id" x-model="org" @change="resetBrn()"
            class="w-full rounded border-gray-300" required>
      <option value="">-- เลือก --</option>
      @foreach($organizations as $o)
        <option value="{{ $o->id }}">{{ $o->name }}</option>
      @endforeach
    </select>
    @error('org_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">สาขา (Branch)</label>
    <select name="brn_id" x-model="brn" @change="resetDpm()"
            class="w-full rounded border-gray-300"
            :disabled="!org">
      <option value="">-- เลือก --</option>
      <template x-for="b in brnList()" :key="b.id">
        <option :value="b.id" x-text="`${b.name} (${b.id})`"></option>
      </template>
    </select>
    @error('brn_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">แผนก (Department)</label>
    <select name="dpm_id" x-model="dpm" class="w-full rounded border-gray-300"
            :disabled="!brn">
      <option value="">-- เลือก --</option>
      <template x-for="d in dpmList()" :key="d.id">
        <option :value="d.id" x-text="`${d.name} (${d.id})`"></option>
      </template>
    </select>
    @error('dpm_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
  </div>

  <div class="flex items-center gap-6 md:col-span-3">
    <label class="inline-flex items-center gap-2">
      <input type="hidden" name="fingerprint_registered" value="0">
      <input type="checkbox" name="fingerprint_registered" value="1"
             @checked(old('fingerprint_registered', $employee->fingerprint_registered ?? false))>
      <span>ลงทะเบียนลายนิ้วมือแล้ว</span>
    </label>

    <label class="inline-flex items-center gap-2">
      <input type="hidden" name="status" value="0">
      <input type="checkbox" name="status" value="1"
             @checked(old('status', $employee->status ?? true))>
      <span>ใช้งาน (Active)</span>
    </label>
  </div>
</div>