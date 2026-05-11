<x-app-layout>
  @php
    $employees->getCollection()->loadMissing('fingerprints');
    $usersForJs = $employees->getCollection()->map(fn($e) => [
      'id' => $e->id,
      'emp_id' => $e->emp_id,
      'first_name' => $e->full_name,
      'name' => $e->full_name,
      'color' => '',
      'enrolled' => $e->fingerprints->count(),
      'fingers' => $e->fingerprints->map(fn($f) => ['id' => $f->id, 'finger_no' => $f->finger_no, 'note' => $f->note])->toArray(),
      'image_url' => $e->image_url,
      'logs' => [],
      'lastUpdate' => '',
    ])->values();
  @endphp

  <h1 class="text-2xl font-semibold mb-4">จัดการลายนิ้วมือ</h1>

  @hasanyrole('super-admin|admin')
  {{-- Filter bar --}}
  <form method="get" class="mb-4">
    <div class="flex flex-wrap gap-2">
      <select name="org_id" class="rounded border-gray-300">
        <option value="">-- ทุกองค์กร --</option>
        @foreach($organizations as $o)
          <option value="{{ $o->id }}" @selected(request('org_id') == $o->id)>{{ $o->name }}</option>
        @endforeach
      </select>
      <input type="text" name="q" placeholder="ค้นหา emp_id / ชื่อ / โทร" value="{{ $q }}"
        class="flex-1 rounded border-gray-300 px-2">
      <button class="rounded bg-slate-900 text-white px-3">ค้นหา</button>
    </div>
  </form>
  @endhasanyrole

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-4" x-data="fpModule()">

    {{-- ─── LEFT: Employee List ─── --}}
    <div class="lg:col-span-5">
      <div class="overflow-hidden rounded-lg border bg-white">

        {{-- Panel header --}}
        <div class="flex items-center justify-between border-b px-4 py-3">
          <span class="font-semibold text-sm">รายชื่อพนักงาน</span>
          <span class="text-xs text-slate-500"
            x-text="users.filter(u => u.enrolled > 0).length + '/' + users.length + ' ลงทะเบียนแล้ว'"></span>
        </div>

        {{-- Search --}}
        <div class="p-3 border-b">
          <input type="text" class="w-full rounded border-gray-300 text-sm px-3 py-1.5"
            placeholder="ค้นหาชื่อหรือรหัส..." x-model="searchQ">
        </div>

        {{-- List --}}
        <div class="divide-y max-h-[70vh] overflow-y-auto">
          <template x-for="u in filteredUsers" :key="u.emp_id">
            <div class="flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-slate-50 transition"
              :class="{ 'bg-blue-50 border-l-4 border-blue-500': selectedUser && selectedUser.id === u.id }"
              @click="selectUser(u)">

              {{-- Avatar --}}
              <div class="flex-shrink-0">
                <template x-if="u.image_url">
                  <img :src="u.image_url" class="h-9 w-9 rounded-full object-cover border border-gray-100 shadow-sm"
                    alt="">
                </template>
                <template x-if="!u.image_url">
                  <div class="h-9 w-9 rounded-full flex items-center justify-center text-white font-bold text-sm"
                    :class="{
                      'bg-blue-500':   u.color === '',
                      'bg-emerald-500': u.color === 'green',
                      'bg-amber-500':  u.color === 'orange',
                      'bg-pink-500':   u.color === 'pink',
                      'bg-purple-500': u.color === 'purple'
                    }" x-text="u.first_name[0]"></div>
                </template>
              </div>

              {{-- Info --}}
              <div class="flex-1 min-w-0">
                <div class="text-sm font-medium truncate" x-text="u.name"></div>
                <div class="text-xs text-slate-500 truncate" x-text="u.emp_id"></div>
              </div>

              <div class="flex gap-0.5 flex-shrink-0">
                <template x-for="i in 3" :key="i">
                  <div class="h-1.5 w-1.5 rounded-full"
                    :class="u.fingers.filter(f => f.enrolled).length >= i ? 'bg-blue-500' : 'bg-gray-200'"></div>
                </template>
              </div>
            </div>
          </template>

          {{-- Empty list --}}
          <div x-show="filteredUsers.length === 0" class="px-4 py-10 text-center text-sm text-slate-400">
            ไม่พบข้อมูล
          </div>
        </div>

      </div>
    </div>

    {{-- ─── RIGHT: Detail Panel ─── --}}
    <div class="lg:col-span-7">

      {{-- No selection --}}
      <template x-if="!selectedUser">
        <div class="rounded-lg border bg-white p-12 text-center text-slate-400">
          <div class="text-4xl mb-3">👆</div>
          <div class="text-sm">เลือกพนักงานเพื่อจัดการลายนิ้วมือ</div>
        </div>
      </template>

      {{-- User detail --}}
      <template x-if="selectedUser">
        <div class="space-y-4">

          {{-- Employee Card --}}
          <div class="rounded-lg border bg-white p-4">
            <div class="flex items-center gap-4">
              <div class="flex-shrink-0">
                <template x-if="selectedUser.image_url">
                  <img :src="selectedUser.image_url"
                    class="h-12 w-12 rounded-xl object-cover border border-gray-100 shadow-sm" alt="">
                </template>
                <template x-if="!selectedUser.image_url">
                  <div class="h-12 w-12 rounded-xl flex items-center justify-center text-white font-bold text-lg"
                    :class="{
                      'bg-blue-500':   selectedUser.color === '',
                      'bg-emerald-500': selectedUser.color === 'green',
                      'bg-amber-500':  selectedUser.color === 'orange',
                      'bg-pink-500':   selectedUser.color === 'pink',
                      'bg-purple-500': selectedUser.color === 'purple'
                    }" x-text="selectedUser.first_name[0]"></div>
                </template>
              </div>
              <div class="flex-1">
                <div class="font-semibold" x-text="selectedUser.first_name"></div>
                <div class="text-xs text-slate-500 font-mono" x-text="selectedUser.emp_id"></div>
                <div class="mt-1">
                  <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-semibold" :class="selectedUser.fingers.filter(f => f.enrolled).length > 0
                               ? 'bg-emerald-100 text-emerald-700'
                               : 'bg-amber-100 text-amber-700'" x-text="selectedUser.fingers.filter(f => f.enrolled).length > 0
                               ? '✓ ลงทะเบียนแล้ว'
                               : '⚠ ยังไม่ลงทะเบียน'">
                  </span>
                </div>
              </div>
              <div class="text-right">
                <div class="text-2xl font-bold text-blue-600 font-mono"
                  x-text="selectedUser.fingers.filter(f => f.enrolled).length + '/3'"></div>
                <div class="text-xs text-slate-500">นิ้วที่ลงทะเบียน</div>
              </div>
            </div>
          </div>

          {{-- Fingerprint Grid --}}
          <div class="rounded-lg border bg-white overflow-hidden">
            <div class="flex items-center justify-between border-b px-4 py-3">
              <span class="font-semibold text-sm">🖐️ ลายนิ้วมือ 3 นิ้ว</span>
              <span class="rounded-full bg-blue-100 text-blue-700 text-xs px-2 py-0.5 font-semibold"
                x-text="selectedUser.fingers.filter(f => f.enrolled).length + ' นิ้ว'"></span>
            </div>

            {{-- Finger slots --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 p-4">
              <template x-for="(finger, idx) in selectedUser.fingers" :key="idx">
                <div class="relative flex flex-col rounded-xl border p-3 transition-all duration-200 bg-white" :class="{
                     'border-emerald-200 bg-emerald-50/30': finger.enrolled,
                     'border-gray-200 hover:border-blue-300': !finger.enrolled && scanningIdx !== idx,
                     'border-blue-400 bg-blue-50 ring-2 ring-blue-100': scanningIdx === idx
                   }">

                  {{-- Header: Status & Icon --}}
                  <div class="flex items-center gap-3 mb-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full shrink-0"
                      :class="finger.enrolled ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-400'">
                      <span class="text-lg" x-text="finger.enrolled ? '✔️' : '👆'"></span>
                    </div>
                    <div class="min-w-0 flex-1">
                      <div class="text-sm font-semibold text-gray-700 truncate" x-text="finger.shortName"></div>
                      <div class="text-[11px] font-medium"
                        :class="finger.enrolled ? 'text-emerald-600' : 'text-gray-400'"
                        x-text="finger.enrolled ? 'สแกนแล้ว' : 'ยังไม่สแกน'"></div>
                    </div>
                  </div>

                  {{-- Details (Label) --}}
                  <div class="mb-3 flex-1 px-1">
                    <div class="text-xs text-gray-500 mb-0.5">ป้ายกำกับ (Label):</div>
                    <div class="text-sm font-medium text-gray-800 truncate"
                      x-text="finger.enrolled ? (finger.name || 'ไม่มีป้ายกำกับ') : '-'"></div>
                  </div>

                  {{-- Actions --}}
                  <div class="mt-auto">
                    <template x-if="finger.enrolled">
                      <button
                        class="w-full flex justify-center items-center gap-1.5 rounded-lg bg-white hover:bg-red-50 text-red-600 border border-red-200 text-sm px-3 py-2 transition shadow-sm"
                        @click.stop="confirmDelete(idx)">
                        🗑 ลบลายนิ้วมือ
                      </button>
                    </template>
                    <template x-if="!finger.enrolled">
                      <button
                        class="w-full flex justify-center items-center gap-1.5 rounded-lg bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-700 border border-blue-200 text-sm px-3 py-2 transition shadow-sm"
                        @click.stop="handleFingerClick(idx)">
                        + เพิ่มลายนิ้วมือ
                      </button>
                    </template>
                  </div>

                </div>
              </template>
            </div>

            {{-- Actions --}}
            <!-- <div class="flex gap-2 px-4 pb-4">
              <button class="flex-1 rounded bg-blue-600 text-white text-sm px-4 py-2 hover:bg-blue-700 transition"
                @click="enrollAll()">
                + บันทึกทุกนิ้ว
              </button>
              <button class="rounded border border-red-300 text-red-600 text-sm px-4 py-2 hover:bg-red-50 transition"
                @click="confirmClearAll = true">
                🗑 ลบทั้งหมด
              </button>
            </div> -->
          </div>

        </div>
      </template>
    </div>

    {{-- ─── SCAN MODAL ─── --}}
    <template x-teleport="body">
      <div id="modal-container">
        {{-- ─── SCAN MODAL ─── --}}
        <div x-show="scanning" x-transition.opacity
          class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 backdrop-blur-sm">
          <div class="bg-white rounded-2xl shadow-2xl w-80 p-8 text-center">
            <div class="text-lg font-semibold mb-1"
              x-text="'สแกนนิ้ว: ' + (selectedUser && selectedUser.fingers[scanningIdx] ? selectedUser.fingers[scanningIdx].name : '')">
            </div>
            <div class="text-sm text-slate-500 mb-4">วางนิ้วบนเครื่องสแกนลายนิ้วมือ</div>

            {{-- Label Input --}}
            <div class="mb-6 text-left">
              <label class="block text-sm font-medium text-gray-700 mb-1">ป้ายกำกับลายนิ้วมือ</label>
              <input type="text" x-model="fingerLabel" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm"
                placeholder="เช่น นิ้วโป้งขวา">
            </div>

            {{-- Scanner animation --}}
            <div class="relative w-28 h-28 mx-auto mb-6">
              <div class="absolute inset-0 rounded-full border-2 border-blue-200"
                :class="isScanningActive ? 'animate-ping' : ''"></div>
              <div class="absolute inset-3 rounded-full border-2 border-blue-300"
                :class="isScanningActive ? 'animate-ping' : ''" style="animation-delay:0.3s"></div>
              <div class="absolute inset-6 rounded-full border-2 border-blue-400"
                :class="isScanningActive ? 'animate-ping' : ''" style="animation-delay:0.6s"></div>
              <div class="absolute inset-0 flex items-center justify-center text-5xl">👆</div>
            </div>

            {{-- Progress --}}
            <div class="mb-4">
              <div class="h-1.5 rounded-full bg-gray-200 mb-2 overflow-hidden">
                <div class="h-full rounded-full bg-blue-500 transition-all duration-300"
                  :style="'width:' + scanProgress + '%'"></div>
              </div>
              <div class="text-xs font-mono"
                :class="scanError ? 'text-red-600 font-bold' : (scanCompleted ? 'text-emerald-600 font-bold' : 'text-slate-500')"
                x-text="scanMsg"></div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-4 flex flex-col gap-2">
              <button x-show="!scanCompleted && !isScanningActive"
                class="w-full rounded-lg bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 text-sm font-medium transition-colors shadow-sm"
                @click="startScan()">เริ่มสแกนลายนิ้วมือ</button>

              <button x-show="isScanningActive"
                class="w-full rounded-lg bg-amber-500 hover:bg-amber-600 text-white px-4 py-2.5 text-sm font-medium transition-colors shadow-sm"
                @click="isScanningActive = false; scanMsg = 'ยกเลิกการสแกนแล้ว'; scanProgress = 0;">หยุดสแกน</button>

              <button x-show="scanCompleted"
                class="w-full rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 text-sm font-medium transition-colors shadow-sm"
                @click="saveFingerprint()">บันทึกข้อมูล</button>

              <button
                class="rounded-lg bg-red-100 hover:bg-gray-200 text-gray-700 px-8 py-2.5 text-sm font-medium transition-colors shadow-sm"
                @click="cancelScan()">ปิดหน้าต่าง</button>
            </div>
          </div>
        </div>

        {{-- ─── CONFIRM CLEAR ALL ─── --}}
        <div x-show="confirmClearAll" x-transition.opacity
          class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 backdrop-blur-sm">
          <div class="bg-white rounded-2xl shadow-2xl w-72 p-6 text-center border border-red-200">
            <div class="text-3xl mb-3">⚠️</div>
            <div class="font-semibold mb-2">ยืนยันการลบ</div>
            <div class="text-sm text-slate-500 mb-5"
              x-text="'ต้องการลบลายนิ้วมือทั้งหมดของ ' + (selectedUser ? selectedUser.name : '') + ' ใช่หรือไม่?'">
            </div>
            <div class="flex gap-2">
              <button class="flex-1 rounded border border-gray-300 px-4 py-2 text-sm hover:bg-gray-50"
                @click="confirmClearAll = false">ยกเลิก</button>
              <button class="flex-1 rounded bg-red-600 text-white px-4 py-2 text-sm hover:bg-red-700"
                @click="clearAllFingers()">ลบทั้งหมด</button>
            </div>
          </div>
        </div>

        {{-- ─── CONFIRM DELETE SINGLE ─── --}}
        <div x-show="confirmDeleteIdx !== null" x-transition.opacity
          class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 backdrop-blur-sm">
          <div class="bg-white rounded-2xl shadow-2xl w-72 p-6 text-center border border-red-200">
            <div class="text-3xl mb-3">🗑️</div>
            <div class="font-semibold mb-2">ลบลายนิ้วมือ</div>
            <div class="text-sm text-slate-500 mb-5"
              x-text="'ลบข้อมูล: ' + (selectedUser && confirmDeleteIdx !== null ? selectedUser.fingers[confirmDeleteIdx].name : '') + '?'">
            </div>
            <div class="flex gap-2">
              <button class="flex-1 rounded border border-gray-300 px-4 py-2 text-sm hover:bg-gray-50"
                @click="confirmDeleteIdx = null">ยกเลิก</button>
              <button class="flex-1 rounded bg-red-600 text-white px-4 py-2 text-sm hover:bg-red-700"
                @click="deleteSingleFinger()">ลบ</button>
            </div>
          </div>
        </div>
      </div>
    </template>

  </div>

  <script>
    const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

    function fpModule() {

      const fingerNames = [
        { name: 'ลายนิ้วมือที่ 1', shortName: 'นิ้วที่ 1' },
        { name: 'ลายนิ้วมือที่ 2', shortName: 'นิ้วที่ 2' },
        { name: 'ลายนิ้วมือที่ 3', shortName: 'นิ้วที่ 3' },
      ];

      function makeFingers(enrolledFingers = []) {
        return fingerNames.map((f, i) => {
          const enrolled = enrolledFingers.find(fp => fp.finger_no === i);
          return {
            ...f,
            enrolled: !!enrolled,
            fingerId: enrolled ? enrolled.id : null,
            name: enrolled && enrolled.note ? enrolled.note : f.name,
            templateId: enrolled ? 'FP-' + Math.random().toString(36).slice(2, 8).toUpperCase() : null
          };
        });
      }

      const now = () => {
        const d = new Date();
        return d.toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
      };

      const today = () => new Date().toLocaleDateString('th-TH', {
        day: '2-digit', month: 'short', year: 'numeric'
      });

      return {
        searchQ: '',
        selectedUser: null,
        scanning: false,
        scanningIdx: null,
        scanProgress: 0,
        scanMsg: 'พร้อมสำหรับการสแกน',
        scanTimer: null,
        confirmClearAll: false,
        confirmDeleteIdx: null,
        enrollAllQueue: [],

        fingerLabel: '',
        scannedFingerCode: null,
        isScanningActive: false,
        scanCompleted: false,
        scanError: false,

        users: @js($usersForJs),

        init() {
          // Users are already loaded from the server.
          // Fingers are built by makeFingers() in fetchUsers() if needed.
          this.users = this.users.map(u => ({
            ...u,
            fingers: makeFingers(u.fingers),
          }));
        },

        get filteredUsers() {
          const q = this.searchQ.toLowerCase();
          return this.users.filter(u => u.first_name.includes(this.searchQ) || u.emp_id.toLowerCase().includes(q));
        },

        async fetchUsers() {
          try {
            const response = await fetch(`/api/filteremploy`);
            if (!response.ok) throw new Error('ไม่สามารถโหลดข้อมูลพนักงานได้');

            const result = await response.json();
            if (!result.success) throw new Error(result.message || 'เกิดข้อผิดพลาดในการดึงข้อมูล');

            this.users = result.data.data.map(user => ({
              ...user,
              fingers: makeFingers(user.fingers),
              logs: user.logs || []
            }));
          } catch (error) {
            console.error("Fetch error:", error);
            if (window.Swal) Swal.fire({ icon: 'error', title: 'Error', text: error.message });
          } finally {
            this.isLoading = false;
          }
        },

        selectUser(u) {
          this.selectedUser = u;
        },

        async handleFingerClick(idx) {
          if (this.scanning) return;
          const finger = this.selectedUser.fingers[idx];
          if (finger.enrolled) {
            this.confirmDelete(idx);
          } else {
            this.scanning = true;
            this.scanningIdx = idx;
            this.scanProgress = 0;
            this.scanMsg = 'พร้อมสำหรับการสแกน';
            this.fingerLabel = finger.name;
            this.scannedFingerCode = null;
            this.isScanningActive = false;
            this.scanCompleted = false;
            this.scanError = false;

            // Start scan automatically
            this.startScan();
          }
        },

        confirmDelete(idx) {
          this.confirmDeleteIdx = idx;
        },

        async startScan() {
          this.isScanningActive = true;
          this.scanProgress = 0;
          this.scanMsg = 'กำลังรอสแกน... วางนิ้วบนเครื่อง';
          this.scannedFingerCode = null;
          this.scanCompleted = false;
          this.scanError = false;

          try {
            if (!this.scanning || !this.isScanningActive) return;
            const response = await fetch('http://localhost:18081/read');
            if (!this.scanning || !this.isScanningActive) return;
            let data = await response.json();

            if (!data || (Array.isArray(data) && data.length === 0) || !data.FingerCode) {
              this.scanMsg = 'กำลังรอสแกน... วางนิ้วบนเครื่อง';
              await delay(2000);
              if (!this.scanning || !this.isScanningActive) return;
              return this.startScan();
            } else {
              this.scanMsg = 'วิเคราะห์ข้อมูล...';
              this.scanProgress = 33;
              await delay(1000);
              this.scanMsg = 'ตรวจสอบคุณภาพ...';
              this.scanProgress = 66;
              await delay(1000);
              this.scanMsg = 'สแกนสำเร็จ พร้อมบันทึกข้อมูล';
              this.scanProgress = 100;
              this.isScanningActive = false;
              this.scannedFingerCode = data.FingerCode;
              this.scanCompleted = true;
            }
          } catch (error) {
            if (!this.scanning || !this.isScanningActive) return;
            console.error("เกิดข้อผิดพลาด:", error);
            this.scanError = true;
            this.scanMsg = 'การเชื่อมต่อผิดพลาด กำลังลองใหม่...';
            await delay(3000);
            if (!this.scanning || !this.isScanningActive) return;
            return this.startScan();
          }
        },

        async saveFingerprint() {
          if (!this.scannedFingerCode) return;
          const idx = this.scanningIdx;
          this.scanMsg = 'กำลังส่งข้อมูลไปยังเซิร์ฟเวอร์...';
          this.scanError = false;

          try {
            const response = await fetch('/api/savefinger', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
              },
              body: JSON.stringify({
                id: this.selectedUser.id,
                finger_index: idx,
                fingerprint_code: this.scannedFingerCode,
                finger_label: this.fingerLabel,
              })
            });

            const responseJson = await response.json();
            if (!response.ok) throw new Error('ข้อมูลไม่ถูกต้อง');

            if (responseJson.success) {
              const finger = this.selectedUser.fingers[idx];
              finger.name = this.fingerLabel || finger.name;
              if (responseJson.data && responseJson.data.id) {
                finger.fingerId = responseJson.data.id;
              }
              this.completeScan(idx);
              if (window.Swal) {
                Swal.fire({
                  icon: 'success',
                  title: 'สำเร็จ',
                  text: 'บันทึกลายลายนิ้วมือเรียบร้อยแล้ว',
                  timer: 1500,
                  showConfirmButton: false
                });
              }
            } else {
              throw new Error(responseJson.message || 'บันทึกไม่สำเร็จ');
            }
          } catch (error) {
            console.error("เกิดข้อผิดพลาด:", error);
            this.scanError = true;
            this.scanMsg = 'เกิดข้อผิดพลาด: ' + error.message;
            if (window.Swal) Swal.fire({ icon: 'error', title: 'บันทึกไม่สำเร็จ', text: error.message });
          }
        },

        completeScan(idx) {
          this.scanning = false;
          this.scanningIdx = null;
          const finger = this.selectedUser.fingers[idx];
          finger.enrolled = true;
          finger.templateId = 'FP-' + Math.random().toString(36).slice(2, 8).toUpperCase();
          this.selectedUser.enrolled = this.selectedUser.fingers.filter(f => f.enrolled).length;
          this.selectedUser.lastUpdate = today();
          this.selectedUser.logs.unshift({
            msg: 'บันทึก' + finger.name + ' สำเร็จ · ' + finger.templateId,
            time: today() + ' · ' + now(),
            color: '#00e676'
          });

          if (this.enrollAllQueue.length > 0) {
            const next = this.enrollAllQueue.shift();
            setTimeout(() => this.handleFingerClick(next), 300);
          }
        },

        cancelScan() {
          clearInterval(this.scanTimer);
          this.scanning = false;
          this.scanningIdx = null;
          this.isScanningActive = false;
          this.scanCompleted = false;
          this.enrollAllQueue = [];
        },

        enrollAll() {
          const unenrolled = this.selectedUser.fingers
            .map((f, i) => f.enrolled ? null : i)
            .filter(i => i !== null);
          if (unenrolled.length === 0) return;
          this.enrollAllQueue = unenrolled.slice(1);
          this.handleFingerClick(unenrolled[0]);
        },

        async deleteSingleFinger() {
          if (this.confirmDeleteIdx === null) return;
          const idx = this.confirmDeleteIdx;
          const finger = this.selectedUser.fingers[idx];

          try {
            const response = await fetch('/api/delallone', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
              },
              body: JSON.stringify({ id: finger.fingerId })
            });

            if (!response.ok) throw new Error('ไม่สามารถลบข้อมูลได้');
            const result = await response.json();

            if (result.success) {
              finger.enrolled = false;
              finger.templateId = null;
              this.selectedUser.enrolled = this.selectedUser.fingers.filter(f => f.enrolled).length;
              this.selectedUser.lastUpdate = today();
              this.selectedUser.logs.unshift({
                msg: 'ลบ' + finger.name,
                time: today() + ' · ' + now(),
                color: '#ff5252'
              });
              if (window.Swal) Swal.fire({ icon: 'success', title: 'ลบสำเร็จ', timer: 1000, showConfirmButton: false });
            } else {
              throw new Error(result.message || 'ลบไม่สำเร็จ');
            }
          } catch (error) {
            console.error("Delete error:", error);
            if (window.Swal) Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: error.message });
          } finally {
            this.confirmDeleteIdx = null;
          }
        },

        async clearAllFingers() {
          try {
            const response = await fetch('/api/delall', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
              },
              body: JSON.stringify({ id: this.selectedUser.id })
            });

            if (!response.ok) throw new Error('ไม่สามารถลบข้อมูลทั้งหมดได้');
            const result = await response.json();

            if (result.success) {
              this.selectedUser.fingers.forEach(f => {
                f.enrolled = false;
                f.templateId = null;
              });
              this.selectedUser.enrolled = 0;
              this.selectedUser.lastUpdate = today();
              this.selectedUser.logs.unshift({
                msg: 'ลบลายนิ้วมือทั้งหมด',
                time: today() + ' · ' + now(),
                color: '#ff5252'
              });
              if (window.Swal) Swal.fire({ icon: 'success', title: 'ลบทั้งหมดสำเร็จ', timer: 1500, showConfirmButton: false });
            } else {
              throw new Error(result.message || 'ลบทั้งหมดไม่สำเร็จ');
            }
          } catch (error) {
            console.error("Clear all error:", error);
            if (window.Swal) Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: error.message });
          } finally {
            this.confirmClearAll = false;
          }
        }
      }
    }
  </script>

</x-app-layout>