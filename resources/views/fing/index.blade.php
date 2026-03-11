<x-app-layout>

<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
 <style>
  :root {
    --bg: #0a0e1a;
    --surface: #111827;
    --surface2: #1a2235;
    --border: #1e2d45;
    --accent: #00d4ff;
    --accent2: #0066ff;
    --success: #00e676;
    --warn: #ffab00;
    --danger: #ff5252;
    --text: #fafafa;
    --text-dim: #64748b;
    --glow: rgba(17, 23, 24, 0.15);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    background: var(--bg);
    color: var(--text);
    font-family: 'Sarabun', sans-serif;
    min-height: 100vh;
    overflow-x: hidden;
  }

  /* Grid background */
  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image:
      linear-gradient(rgba(0,212,255,0.03) 1px, transparent 1px),
      linear-gradient(90deg, rgba(0,212,255,0.03) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
    z-index: 0;
  }



  /* ─── SIDEBAR ─── */
  
 

  .nav-section {
    margin-bottom: 24px;
  }

  .nav-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;
    color: var(--text-dim);
    padding: 0 8px;
    margin-bottom: 8px;
    text-transform: uppercase;
  }

  .nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 14px;
    color: var(--text-dim);
    border: 1px solid transparent;
    margin-bottom: 2px;
  }

  .nav-item:hover {
    background: var(--surface2);
    color: var(--text);
  }

  .nav-item.active {
    background: rgba(0,212,255,0.08);
    border-color: rgba(0,212,255,0.2);
    color: var(--accent);
  }

  .nav-item .icon { font-size: 16px; width: 20px; text-align: center; }

  /* ─── MAIN ─── */
  .main {
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }

  .topbar {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 16px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .page-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text);
  }

  .breadcrumb {
    font-size: 12px;
    color: var(--text-dim);
    margin-top: 2px;
  }

  .breadcrumb span { color: var(--accent); }

  .topbar-actions {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .badge {
    background: rgba(0,212,255,0.1);
    border: 1px solid rgba(0,212,255,0.3);
    color: var(--accent);
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-family: 'Space Mono', monospace;
  }



  /* ─── USER LIST PANEL ─── */
  .panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
  }

  .panel-head {
    padding: 18px 20px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .panel-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
  }

  .panel-meta {
    font-size: 12px;
    color: var(--text-dim);
  }

  /* Search bar */
  .search-wrap {
    padding: 14px 16px;
    border-bottom: 1px solid var(--border);
  }

  .search-input {
    width: 100%;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 8px 12px 8px 36px;
    color: var(--text);
    font-size: 13px;
    font-family: 'Sarabun', sans-serif;
    outline: none;
    transition: border-color 0.2s;
    position: relative;
  }

  .search-input:focus { border-color: var(--accent); }

  .search-wrap-inner {
    position: relative;
  }

  .search-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-dim);
    font-size: 14px;
  }

  /* User rows */
  .user-list { padding: 8px; }

  .user-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
    border: 1px solid transparent;
    margin-bottom: 4px;
  }

  .user-row:hover { background: var(--surface2); }

  .user-row.selected {
    background: rgba(0,212,255,0.07);
    border-color: rgba(0,212,255,0.25);
  }

  .avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--accent2), #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
    position: relative;
  }

  .avatar.green { background: linear-gradient(135deg, #059669, #00e676); }
  .avatar.orange { background: linear-gradient(135deg, #d97706, #ffab00); }
  .avatar.pink { background: linear-gradient(135deg, #db2777, #f472b6); }
  .avatar.purple { background: linear-gradient(135deg, #7c3aed, #a78bfa); }

  .user-info { flex: 1 }
  .user-name { font-size: 14px; font-weight: 500; color: var(--text); }
  .user-dept { font-size: 11px; color: var(--text-dim); margin-top: 1px; }

  .fp-count {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-family: 'Space Mono', monospace;
  }

  .fp-dots {
    display: flex;
    gap: 2px;
  }

  .fp-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--border);
  }

  .fp-dot.filled { background: var(--accent); box-shadow: 0 0 4px var(--accent); }

  /* ─── DETAIL PANEL ─── */
  .detail-panel {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  /* User card */
  .user-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 20px;
    position: relative;
    overflow: hidden;
  }

  .user-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--accent), var(--accent2));
  }

  .card-user-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 16px;
  }

  .card-avatar {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--accent2), #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    box-shadow: 0 0 20px rgba(0,102,255,0.3);
  }

  .card-name { font-size: 16px; font-weight: 600; }
  .card-id { font-size: 11px; color: var(--text-dim); margin-top: 2px; font-family: 'Space Mono', monospace; }

  .card-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }

  .stat-box {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 10px 12px;
  }

  .stat-label { font-size: 10px; color: var(--text-dim); text-transform: uppercase; letter-spacing: 1px; }
  .stat-val { font-size: 18px; font-weight: 700; color: var(--accent); font-family: 'Space Mono', monospace; margin-top: 2px; }

  /* Fingerprint grid */
  .fp-panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
  }

  .fp-grid {
    padding: 16px;
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 10px;
  }

  .fp-slot {
    aspect-ratio: 1;
    border-radius: 10px;
    border: 1px solid var(--border);
    background: var(--bg);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.25s;
    position: relative;
    overflow: hidden;
    gap: 4px;
  }

  .fp-slot:hover {
    border-color: rgba(0,212,255,0.4);
    background: rgba(0,212,255,0.04);
    transform: translateY(-1px);
  }

  .fp-slot.enrolled {
    border-color: rgba(0,230,118,0.4);
    background: rgba(0,230,118,0.05);
  }

  .fp-slot.enrolled:hover {
    border-color: rgba(255,82,82,0.4);
    background: rgba(255,82,82,0.05);
  }

  .fp-slot.scanning {
    border-color: var(--accent);
    background: rgba(0,212,255,0.08);
    animation: scanPulse 1.2s ease-in-out infinite;
  }

  @keyframes scanPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(0,212,255,0.4); }
    50% { box-shadow: 0 0 0 6px rgba(0,212,255,0); }
  }

  .fp-icon {
    font-size: 22px;
    line-height: 1;
  }

  .fp-label {
    font-size: 9px;
    color: var(--text-dim);
    text-align: center;
    line-height: 1.3;
    padding: 0 4px;
  }

  .fp-slot.enrolled .fp-label { color: var(--success); }

  .fp-status-dot {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--border);
  }

  .fp-slot.enrolled .fp-status-dot {
    background: var(--success);
    box-shadow: 0 0 6px var(--success);
  }

  /* Scan visualization */
  .scan-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    backdrop-filter: blur(6px);
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .scan-modal {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 36px 40px;
    width: 360px;
    text-align: center;
    position: relative;
  }

  .scan-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 6px;
  }

  .scan-sub {
    font-size: 13px;
    color: var(--text-dim);
    margin-bottom: 28px;
  }

  /* Fingerprint SVG scanner */
  .fp-scanner {
    width: 140px;
    height: 140px;
    margin: 0 auto 24px;
    position: relative;
  }

  .fp-scanner-ring {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    border: 2px solid var(--border);
    position: absolute;
    animation: ringPulse 2s ease-in-out infinite;
  }

  .fp-scanner-ring:nth-child(2) { animation-delay: 0.4s; transform: scale(0.85); }
  .fp-scanner-ring:nth-child(3) { animation-delay: 0.8s; transform: scale(0.7); }

  @keyframes ringPulse {
    0%, 100% { border-color: rgba(0,212,255,0.1); }
    50% { border-color: rgba(0,212,255,0.5); }
  }

  .fp-center {
    position: absolute;
    inset: 20px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(0,212,255,0.08), transparent);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .fp-big-icon {
    font-size: 52px;
    animation: iconPulse 1.5s ease-in-out infinite;
  }

  @keyframes iconPulse {
    0%, 100% { transform: scale(1); opacity: 0.7; }
    50% { transform: scale(1.1); opacity: 1; }
  }

  /* Scan line */
  .scan-line {
    position: absolute;
    left: 20px; right: 20px;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--accent), transparent);
    top: 20px;
    animation: scanLine 1.8s linear infinite;
    box-shadow: 0 0 8px var(--accent);
  }

  @keyframes scanLine {
    0% { top: 20px; opacity: 0; }
    10% { opacity: 1; }
    90% { opacity: 1; }
    100% { top: 120px; opacity: 0; }
  }

  .scan-progress {
    margin-bottom: 20px;
  }

  .progress-bar {
    height: 4px;
    background: var(--border);
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 8px;
  }

  .progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--accent2), var(--accent));
    border-radius: 2px;
    transition: width 0.3s ease;
    box-shadow: 0 0 8px var(--accent);
  }

  .progress-text {
    font-size: 12px;
    color: var(--text-dim);
    font-family: 'Space Mono', monospace;
  }

  .scan-actions {
    display: flex;
    gap: 10px;
  }

  /* Buttons */
  .btn {
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    font-family: 'Sarabun', sans-serif;
    cursor: pointer;
    transition: all 0.2s;
    border: 1px solid transparent;
  }

  .btn-primary {
    background: linear-gradient(135deg, var(--accent2), var(--accent));
    color: #fff;
    box-shadow: 0 0 16px rgba(0,102,255,0.3);
  }

  .btn-primary:hover {
    box-shadow: 0 0 24px rgba(0,102,255,0.5);
    transform: translateY(-1px);
  }

  .btn-ghost {
    background: transparent;
    border-color: var(--border);
    color: var(--text-dim);
  }

  .btn-ghost:hover {
    background: var(--surface2);
    color: var(--text);
  }

  .btn-danger {
    background: rgba(255,82,82,0.1);
    border-color: rgba(255,82,82,0.3);
    color: var(--danger);
  }

  .btn-danger:hover {
    background: rgba(255,82,82,0.2);
  }

  .btn-success {
    background: linear-gradient(135deg, #059669, #00e676);
    color: #fff;
  }

  .btn-full { width: 100%; justify-content: center; display: flex; align-items: center; gap: 6px; }

  /* Status chip */
  .chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
  }

  .chip-success { background: rgba(0,230,118,0.1); border: 1px solid rgba(0,230,118,0.3); color: var(--success); }
  .chip-warn { background: rgba(255,171,0,0.1); border: 1px solid rgba(255,171,0,0.3); color: var(--warn); }
  .chip-info { background: rgba(0,212,255,0.1); border: 1px solid rgba(0,212,255,0.3); color: var(--accent); }

  /* Finger name labels below grid */
  .finger-names {
    padding: 0 16px 16px;
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 10px;
  }

  .finger-name-label {
    font-size: 9px;
    color: var(--text-dim);
    text-align: center;
    line-height: 1.3;
  }

  /* Log timeline */
  .log-panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
  }

  .log-list {
    padding: 8px 16px 16px;
  }

  .log-item {
    display: flex;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    align-items: flex-start;
  }

  .log-item:last-child { border-bottom: none; }

  .log-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-top: 4px;
    flex-shrink: 0;
  }

  .log-content { flex: 1 }
  .log-msg { font-size: 12px; color: var(--text); }
  .log-time { font-size: 10px; color: var(--text-dim); margin-top: 2px; font-family: 'Space Mono', monospace; }

  /* Empty state */
  .empty-state {
    padding: 48px 24px;
    text-align: center;
    color: var(--text-dim);
  }

  .empty-icon { font-size: 40px; margin-bottom: 12px; opacity: 0.4; }
  .empty-text { font-size: 13px; }

  /* Tooltip on enrolled finger hover */
  .fp-slot .fp-tooltip {
    position: absolute;
    bottom: -28px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(255,82,82,0.9);
    color: #fff;
    font-size: 9px;
    padding: 3px 7px;
    border-radius: 4px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s;
    z-index: 10;
  }

  .fp-slot.enrolled:hover .fp-tooltip { opacity: 1; }

  /* confirm delete modal */
  .confirm-modal {
    background: var(--surface);
    border: 1px solid rgba(255,82,82,0.3);
    border-radius: 16px;
    padding: 28px;
    width: 320px;
    text-align: center;
  }

  .confirm-icon { font-size: 36px; margin-bottom: 12px; }
  .confirm-title { font-size: 16px; font-weight: 600; margin-bottom: 8px; }
  .confirm-msg { font-size: 13px; color: var(--text-dim); margin-bottom: 24px; }

  /* scrollbar */
  ::-webkit-scrollbar { width: 4px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

  /* Ripple on success */
  @keyframes successRipple {
    0% { transform: scale(0.8); opacity: 1; }
    100% { transform: scale(1.5); opacity: 0; }
  }

  .success-ripple {
    animation: successRipple 0.6s ease-out;
  }
</style>
<h1 class="text-2xl font-semibold mb-4">พนักงาน</h1>


<div class="layout" x-data="fpModule()">



  <!-- MAIN -->

 
    <div class="content">


    <div class="grid grid-cols-12 gap-4">
  <div class="col-span-6">
     <div>
        <div class="panel">
          <div class="panel-head">
            <div class="panel-title">รายชื่อผู้ใช้งาน</div>
            <div class="panel-meta" x-text="users.filter(u=>u.enrolled>0).length + '/' + users.length + ' ลงทะเบียนแล้ว'"></div>
          </div>
          <div class="search-wrap">
            <div class="search-wrap-inner">
              <span class="search-icon">🔍</span>
              <input class="search-input" type="text" placeholder="ค้นหาชื่อหรือรหัส..." x-model="searchQ">
            </div>
          </div>
          <div class="user-list">
            <template x-for="u in filteredUsers" :key="u.emp_id">
              <div class="user-row" :class="{selected: selectedUser && selectedUser.id===u.emp_id}" @click="selectUser(u)">
                <div class="avatar" :class="u.color" x-text="u.first_name[0]"></div>
                <div class="user-info">
                  <div class="user-name" x-text="u.name"></div> 
                  <div class="user-dept" x-text="u.first_name + ' · ' + u.emp_id"></div>
                </div>
                <div class="fp-count">
                  <div class="fp-dots">
                    <template x-for="i in 10" :key="i">
                      
                      <div class="fp-dot" :class="{filled: u.fingers.filter(f=>f.enrolled).length >= i}"></div>
                    </template>
                  </div>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
  </div>
  <div class="col-span-6">  <div class="detail-panel">

        <!-- No selection -->
        <template x-if="!selectedUser">
          <div class="panel">
            <div class="empty-state">
              <div class="empty-icon">👆</div>
              <div class="empty-text">เลือกผู้ใช้เพื่อจัดการลายนิ้วมือ</div>
            </div>
          </div>
        </template>

        <!-- User detail -->
        <template x-if="selectedUser">
          <div>
            <!-- User card -->
            <div class="user-card">
              <div class="card-user-header">
                <div class="card-avatar" :class="selectedUser.color" x-text="selectedUser.first_name[0]"></div>
                <div>
                  <div class="card-name" x-text="selectedUser.first_name"></div>
                  <div class="card-id" x-text="selectedUser.emp_id"></div>
                  <div style="margin-top:6px">
                    <span class="chip" :class="selectedUser.fingers.filter(f=>f.enrolled).length>0 ? 'chip-success' : 'chip-warn'">
                      <span x-text="selectedUser.fingers.filter(f=>f.enrolled).length>0 ? '✓ ลงทะเบียนแล้ว' : '⚠ ยังไม่ลงทะเบียน'"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="card-stats">
                <div class="stat-box">
                  <div class="stat-label">นิ้วที่ลงทะเบียน</div>
                  <div class="stat-val" x-text="selectedUser.fingers.filter(f=>f.enrolled).length + '/10'"></div>
                </div>
                <div class="stat-box">
                  <div class="stat-label">แก้ไขล่าสุด</div>
                  <div class="stat-val" style="font-size:12px; color: var(--text-dim);" x-text="selectedUser.lastUpdate"></div>
                </div>
              </div>
            </div>

            <!-- Fingerprint grid -->
            <div class="fp-panel">
              <div class="panel-head">
                <div class="panel-title">🖐️ ลายนิ้วมือ 10 นิ้ว</div>
                <span class="chip chip-info" x-text="selectedUser.fingers.filter(f=>f.enrolled).length + ' นิ้ว'"></span>
              </div>

              <!-- Hand row: LEFT 5 + RIGHT 5 -->
              <div style="padding: 14px 16px 0; display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                <div style="font-size:11px; color: var(--text-dim); text-align:center; padding-bottom:4px; border-bottom: 1px solid var(--border);">✋ มือซ้าย</div>
                <div style="font-size:11px; color: var(--text-dim); text-align:center; padding-bottom:4px; border-bottom: 1px solid var(--border);">🤚 มือขวา</div>
              </div>

              <div class="fp-grid">
                <template x-for="(finger, idx) in selectedUser.fingers" :key="idx">
                  <div class="fp-slot"
                    :class="{enrolled: finger.enrolled, scanning: scanningIdx===idx}"
                    @click="handleFingerClick(idx)">
                    <div class="fp-status-dot"></div>
                    <div class="fp-icon" x-text="finger.enrolled ? '🔵' : '⬜'"></div>
                    <div class="fp-label" x-text="finger.shortName"></div>
                    <div class="fp-tooltip">ลบออก</div>
                  </div>
                </template>
              </div>

              <div class="finger-names">
                <template x-for="(finger, idx) in selectedUser.fingers" :key="idx">
                  <div class="finger-name-label" x-text="finger.name"></div>
                </template>
              </div>

              <div style="padding: 0 16px 16px; display: flex; gap: 8px;">
                <button class="btn btn-primary btn-full" style="flex:2" @click="enrollAll()">
                  + บันทึกทุกนิ้ว
                </button>
                <button class="btn btn-danger" style="flex:1" @click="confirmClearAll=true">
                  🗑 ลบทั้งหมด
                </button>
              </div>
            </div>

            <!-- Log -->
            <!-- <div class="log-panel">
              <div class="panel-head">
                <div class="panel-title">📝 ประวัติการบันทึก</div>
              </div>
              <div class="log-list">
                <template x-for="(log, i) in selectedUser.logs" :key="i">
                  <div class="log-item">
                    <div class="log-dot" :style="'background:' + log.color"></div>
                    <div class="log-content">
                      <div class="log-msg" x-text="log.msg"></div>
                      <div class="log-time" x-text="log.time"></div>
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div> -->
        </template>

      </div></div>
</div>
 
    </div>


  <!-- ─── SCAN MODAL ─── -->
  <div class="scan-modal-overlay" x-show="scanning" x-transition.opacity>
    <div class="scan-modal">
      <div class="scan-title" x-text="'สแกนนิ้ว: ' + (selectedUser && selectedUser.fingers[scanningIdx] ? selectedUser.fingers[scanningIdx].name : '')"></div>
      <div class="scan-sub">วางนิ้วบนเครื่องสแกนลายนิ้วมือ</div>

      <div class="fp-scanner">
        <div class="fp-scanner-ring"></div>
        <div class="fp-scanner-ring"></div>
        <div class="fp-scanner-ring"></div>
        <div class="fp-center">
          <div class="fp-big-icon">👆</div>
          <div class="scan-line"></div>
        </div>
      </div>

      <div class="scan-progress">
        <div class="progress-bar">
          <div class="progress-fill" :style="'width:' + scanProgress + '%'"></div>
        </div>
        <div class="progress-text" x-text="scanMsg"></div>
      </div>

      <!-- <div class="scan-actions">
        <button class="btn btn-ghost" style="flex:1" @click="cancelScan()">ยกเลิก</button>
      </div> -->
    </div>
  </div>

  <!-- ─── CONFIRM DELETE ─── -->
  <div class="scan-modal-overlay" x-show="confirmClearAll" x-transition.opacity>
    <div class="confirm-modal">
      <div class="confirm-icon">⚠️</div>
      <div class="confirm-title">ยืนยันการลบ</div>
      <div class="confirm-msg" x-text="'ต้องการลบลายนิ้วมือทั้งหมดของ ' + (selectedUser ? selectedUser.name : '') + ' ใช่หรือไม่?'"></div>
      <div style="display:flex; gap:10px;">
        <button class="btn btn-ghost" style="flex:1" @click="confirmClearAll=false">ยกเลิก</button>
        <button class="btn btn-danger" style="flex:1" @click="clearAllFingers()">ลบทั้งหมด</button>
      </div>
    </div>
  </div>

  <!-- ─── CONFIRM DELETE SINGLE ─── -->
  <div class="scan-modal-overlay" x-show="confirmDeleteIdx!==null" x-transition.opacity>
    <div class="confirm-modal">
      <div class="confirm-icon">🗑️</div>
      <div class="confirm-title">ลบลายนิ้วมือ</div>
      <div class="confirm-msg" x-text="'ลบข้อมูล: ' + (selectedUser && confirmDeleteIdx!==null ? selectedUser.fingers[confirmDeleteIdx].name : '') + '?'"></div>
      <div style="display:flex; gap:10px;">
        <button class="btn btn-ghost" style="flex:1" @click="confirmDeleteIdx=null">ยกเลิก</button>
        <button class="btn btn-danger" style="flex:1" @click="deleteSingleFinger()">ลบ</button>
      </div>
    </div>
  </div>

</div>


</x-app-layout>

<script>


 import { FingerprintReader, SampleFormat } from "@digitalpersona/devices";

 function fpModule() {


const reader = new FingerprintReader();

// 1. ตรวจสอบการเชื่อมต่ออุปกรณ์
reader.on("DeviceConnected", (event) => {
    console.log("Scanner Ready!");
});

// 2. ดักจับตอนวางลายนิ้วมือ
reader.on("SamplesAcquired", (event) => {
    // ข้อมูลลายนิ้วมือจะอยู่ในรูปแบบ Base64 หรือ Raw Data
    const base64Data = event.samples[0]; 
    sendToServer(base64Data); // ส่งไปบันทึกในฐานข้อมูล Laravel ของคุณ
});

// เริ่มต้นทำงาน
reader.startCapture();

  const fingerNames = [
    { name: 'นิ้วก้อย ซ้าย', shortName: 'ก้อย ซ้าย' },
    { name: 'นิ้วนาง ซ้าย', shortName: 'นาง ซ้าย' },
    { name: 'นิ้วกลาง ซ้าย', shortName: 'กลาง ซ้าย' },
    { name: 'นิ้วชี้ ซ้าย', shortName: 'ชี้ ซ้าย' },
    { name: 'นิ้วหัวแม่มือ ซ้าย', shortName: 'หัวแม่ ซ้าย' },
    { name: 'นิ้วหัวแม่มือ ขวา', shortName: 'หัวแม่ ขวา' },
    { name: 'นิ้วชี้ ขวา', shortName: 'ชี้ ขวา' },
    { name: 'นิ้วกลาง ขวา', shortName: 'กลาง ขวา' },
    { name: 'นิ้วนาง ขวา', shortName: 'นาง ขวา' },
    { name: 'นิ้วก้อย ขวา', shortName: 'ก้อย ขวา' },
  ];


   

  function makeFingers(enrolledSet = []) {
    console.log(enrolledSet)
    return fingerNames.map((f, i) => ({
      ...f,
      enrolled: enrolledSet.includes(i),
      templateId: enrolledSet.includes(i) ? 'FP-' + Math.random().toString(36).slice(2,8).toUpperCase() : null
    }));
  }

  const now = () => {
    const d = new Date();
    return d.toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
  };

  const today = () => new Date().toLocaleDateString('th-TH', { day:'2-digit', month:'short', year:'numeric' });

  return {
    searchQ: '',
    selectedUser: null,
    scanning: false,
    scanningIdx: null,
    scanProgress: 0,
    scanMsg: 'กำลังรอสแกน...',
    scanTimer: null,
    confirmClearAll: false,
    confirmDeleteIdx: null,
    enrollAllQueue: [],

    users: [
      { id:1, first_name:'สมชาย ใจดี', empId:'EMP-001', dept:'ฝ่ายบุคคล', color:'', enrolled:3, lastUpdate:'01 มี.ค. 2568', fingers: makeFingers([2,5,7]), logs:[
        { msg:'บันทึกนิ้วชี้ขวา สำเร็จ', time:'01 มี.ค. 2568 · 09:12', color:'#00e676' },
        { msg:'บันทึกนิ้วกลางขวา สำเร็จ', time:'01 มี.ค. 2568 · 09:10', color:'#00e676' },
        { msg:'บันทึกนิ้วกลางซ้าย สำเร็จ', time:'28 ก.พ. 2568 · 14:05', color:'#00e676' },
      ]}
    ],

    // async init() {
    //     this.isLoading = true;
    //     try {
    //         const response = await fetch('/api/filteremploy'); // ยิงไปที่ Route ของ Laravel
    //         const data = await response.json();
    //         const us = data.data.data
    //         // นำข้อมูลที่ได้มา map เข้ากับโครงสร้าง fingers ที่เรามี
    //         this.users = us.map(user => ({
    //             ...user,
    //             // สมมติว่า Laravel ส่งข้อมูลนิ้วที่เคยลงทะเบียนมาในรูปแบบ Array [0, 2, 5]
    //             fingers: this.makeFingers(user.enrolled_indices || []), 
    //             logs: user.logs || []
    //         }));
    //     } catch (error) {
    //         console.error("โหลดข้อมูลพนักงานไม่สำเร็จ:", error);
    //     } finally {
    //         this.isLoading = false;
    //     }
    // },

    async init() {
   await this.fetchUsers();
    },

    get filteredUsers() {
      const q = this.searchQ.toLowerCase();
      
      return this.users.filter(u => u.first_name.includes(this.searchQ) || u.emp_id.toLowerCase().includes(q));
    },

    async fetchUsers() {
try {
            // ส่ง searchQ ไปที่ API ด้วย (ถ้า Laravel รองรับ query string ?search=...)
            const response = await fetch(`/api/filteremploy`);
            const result = await response.json();
            

            this.users = result.data.data
         

                        this.users = result.data.data.map(user => ({
                ...user,
                // สมมติว่า Laravel ส่งข้อมูลนิ้วที่เคยลงทะเบียนมาในรูปแบบ Array [0, 2, 5]
                fingers: makeFingers(user.fingers),
                logs: user.logs || []
            }));
        } catch (error) {
            console.error("Fetch error:", error);
        } finally {
            this.isLoading = false;
        }
},

    selectUser(u) {
      this.selectedUser = u;
    },

    handleFingerClick(idx) {
  
      if (this.scanning) return;
      const finger = this.selectedUser.fingers[idx];
      if (finger.enrolled) {
        this.confirmDeleteIdx = idx;
      } else {
        this.startScan(idx);
      }
    },

    startScan(idx) {
     console.log(this.selectedUser.id);
      this.scanning = true;
      this.scanningIdx = idx;
      this.scanProgress = 0;
      this.scanMsg = 'กำลังรอสแกน... วางนิ้วบนเครื่อง';

      let prog = 0;
      const msgs = ['อ่านลายนิ้วมือ...', 'วิเคราะห์ข้อมูล...', 'ตรวจสอบคุณภาพ...', 'บันทึกลงฐานข้อมูล...'];
      let phase = 0;

      
      this.scanTimer = setInterval(() => {
        prog += Math.random() * 18 + 6;
        if (prog > 100) prog = 100;
        this.scanProgress = Math.round(prog);
        if (prog < 30) { this.scanMsg = msgs[0]; }
        else if (prog < 60) { this.scanMsg = msgs[1]; }
        else if (prog < 85) { this.scanMsg = msgs[2]; }
        else { this.scanMsg = msgs[3]; }

        if (prog >= 100) {
          clearInterval(this.scanTimer);
          setTimeout(() => {


            try {
        this.scanMsg = 'กำลังส่งข้อมูลไปยังเซิร์ฟเวอร์...'; // เปลี่ยนข้อความรอระหว่างยิง API

        const response = fetch('/api/savefinger', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                // อย่าลืม CSRF Token ถ้าไม่ได้ใช้ JWT
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content 
            },
            body: JSON.stringify({
                id: this.selectedUser.id, // ส่ง ID ของ User ที่เลือกอยู่
                finger_index: idx,             // ส่งตำแหน่งนิ้ว (0-9)
                // fingerprint_data: "..."      // ถ้ามี Data จากเครื่องสแกนจริงให้ส่งไปด้วย
            })
        });

    


    } catch (error) {
  
    } finally {
       this.completeScan(idx);
    }

          }, 400);
        }
      }, 200);
    },




    completeScan(idx) {
      this.scanning = false;
      this.scanningIdx = null;
      const finger = this.selectedUser.fingers[idx];
      finger.enrolled = true;
      finger.templateId = 'FP-' + Math.random().toString(36).slice(2,8).toUpperCase();
      this.selectedUser.enrolled = this.selectedUser.fingers.filter(f => f.enrolled).length;
      this.selectedUser.lastUpdate = today();
      this.selectedUser.logs.unshift({
        msg: 'บันทึก' + finger.name + ' สำเร็จ · ' + finger.templateId,
        time: today() + ' · ' + now(),
        color: '#00e676'
      });

      // Continue queue if enrollAll
      if (this.enrollAllQueue.length > 0) {
        const next = this.enrollAllQueue.shift();
        setTimeout(() => this.startScan(next), 300);
      }
    },

    cancelScan() {
      clearInterval(this.scanTimer);
      this.scanning = false;
      this.scanningIdx = null;
      this.enrollAllQueue = [];
    },

    enrollAll() {
      const unenrolled = this.selectedUser.fingers
        .map((f, i) => f.enrolled ? null : i)
        .filter(i => i !== null);
      if (unenrolled.length === 0) return;
      this.enrollAllQueue = unenrolled.slice(1);
      this.startScan(unenrolled[0]);
    },

    deleteSingleFinger() {
      const idx = this.confirmDeleteIdx;
      const finger = this.selectedUser.fingers[idx];
      finger.enrolled = false;
      finger.templateId = null;
      this.selectedUser.enrolled = this.selectedUser.fingers.filter(f => f.enrolled).length;
      this.selectedUser.lastUpdate = today();
      this.selectedUser.logs.unshift({
        msg: 'ลบ' + finger.name,
        time: today() + ' · ' + now(),
        color: '#ff5252'
      });
      this.confirmDeleteIdx = null;
    },

    clearAllFingers() {
      this.selectedUser.fingers.forEach(f => { f.enrolled = false; f.templateId = null; });
      this.selectedUser.enrolled = 0;
      this.selectedUser.lastUpdate = today();
      this.selectedUser.logs.unshift({
        msg: 'ลบลายนิ้วมือทั้งหมด',
        time: today() + ' · ' + now(),
        color: '#ff5252'
      });
      this.confirmClearAll = false;
    }
  }


}
</script>