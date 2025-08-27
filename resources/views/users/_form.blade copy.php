@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

  <div>
    <label class="block text-sm font-medium mb-1">ชื่อผู้ใช้ (username)</label>
    <input type="text" name="username"
           value="{{ old('username', $user->username ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('username') border-red-500 @enderror">
    @error('username') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">คำนำหน้า (prefix)</label>
    <input type="text" name="prefix"
           value="{{ old('prefix', $user->prefix ?? '') }}"
           placeholder="เช่น Mr., Ms., คุณ"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('prefix') border-red-500 @enderror">
    @error('prefix') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">ชื่อ (first_name)</label>
    <input type="text" name="first_name"
           value="{{ old('first_name', $user->first_name ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('first_name') border-red-500 @enderror">
    @error('first_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">นามสกุล (last_name)</label>
    <input type="text" name="last_name"
           value="{{ old('last_name', $user->last_name ?? '') }}"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('last_name') border-red-500 @enderror">
    @error('last_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>

  

</div>

<div x-data="userOrgBrnDpm()" x-init="init()">
  <!-- 1) ORG -->
  <label class="block text-sm font-medium mb-1">องค์กร (org) *</label>
  <select name="org_id" x-model="org" @change="onOrgChange()" class="w-full rounded border-gray-300" required>
    <option value="">-- เลือกองค์กร --</option>
    @foreach(($orgs ?? []) as $o)
      <option value="{{ $o->id }}">{{ $o->name }} ({{ $o->id }})</option>
    @endforeach
  </select>
  @error('org_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror

  <div class="mt-4 space-y-4">
    <!-- 2) BRANCH (disable จนกว่าเลือก org) -->
    <div>
      <label class="block text-sm font-medium mb-1">สาขา (branch)</label>
      <select name="brn_id" x-model="brn" @change="onBrnChange()"
              class="w-full rounded border-gray-300" :disabled="!org">
        <option value="">-- เลือกสาขา --</option>
        <template x-for="b in brnList" :key="b.id">
          <option :value="b.id" x-text="`${b.name} (${b.id})`"></option>
        </template>
      </select>
      @error('brn_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <!-- 3) DEPARTMENT (disable จนกว่าเลือก branch) -->
    <div>
      <label class="block text-sm font-medium mb-1">แผนก (department)</label>
      <select name="dpm_id" x-model="dpm" class="w-full rounded border-gray-300" :disabled="!brn">
        <option value="">-- เลือกแผนก --</option>
        <template x-for="d in dpmList" :key="d.id">
          <option :value="d.id" x-text="`${d.name} (${d.id})`"></option>
        </template>
      </select>
      @error('dpm_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <!-- ROLE: โชว์ได้ตลอด (หรือจะซ่อนจนกว่าเลือก org ก็ได้) -->
    <div>
      <label class="block text-sm font-medium mb-1">สิทธิ์ (role) *</label>
      <select name="role_id" class="w-full rounded border-gray-300" required :disabled="!org">
        <option value="">-- เลือกสิทธิ์ --</option>
        @foreach(($roles ?? []) as $r)
          <option value="{{ $r->id }}" @selected(old('role_id', $user->role_id ?? '')==$r->id)>{{ $r->name }} ({{ $r->id }})</option>
        @endforeach
      </select>
      @error('role_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>


      <div class="md:col-span-1">
    <label class="block text-sm font-medium mb-1">
      รหัสผ่าน ({{ request()->routeIs('users.create') ? 'จำเป็น' : 'ไม่กรอก = ไม่เปลี่ยน' }})
    </label>
    <input type="password" name="password"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 @enderror">
    @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
  </div>
  <div class="md:col-span-1">
    <label class="block text-sm font-medium mb-1">ยืนยันรหัสผ่าน</label>
    <input type="password" name="password_confirmation"
           class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
  </div>
  </div>

  <!-- Alpine helper -->
  <script>
  function userOrgBrnDpm() {
    return {
      org: @json(old('org_id', $user->org_id ?? '')),
      brn: @json(old('brn_id', $user->brn_id ?? '')),
      dpm: @json(old('dpm_id', $user->dpm_id ?? '')),
      brnList: [], dpmList: [],
      async init() {
        if (this.org) {
          
          await this.loadBranches(true);
          if (this.brn) await this.loadDepartments(true);
        }
      },
      async onOrgChange() {
        this.brn = ''; this.dpm = '';
        this.dpmList = [];
        await this.loadBranches(false);
      },
      async onBrnChange() {
        this.dpm = '';
        console.log(this.brn)
        await this.loadDepartments(false);
      },
      async loadBranches(preserve=false) {
        this.brnList = [];
         
        if (!this.org) return;
        const res = await fetch(`{{ route('api.org.branches', '_ORG_') }}`.replace('_ORG_', this.org));
        
        this.brnList = await res.json();
       
        if (!preserve) this.brn = '';
        if (this.brn && !this.brnList.find(x=>x.id===this.brn)) this.brn = '';
      },
      async loadDepartments(preserve=false) {
        this.dpmList = [];
       
        if (!this.brn) return;
        const res = await fetch(`{{ route('api.branch.departments', '_BRN_') }}`.replace('_BRN_', this.brn));
        this.dpmList = await res.json();
        console.log(this.dpmList);
        if (!preserve) this.dpm = '';
        if (this.dpm && !this.dpmList.find(x=>x.id===this.dpm)) this.dpm = '';
      }
    }
  }
  </script>
</div>