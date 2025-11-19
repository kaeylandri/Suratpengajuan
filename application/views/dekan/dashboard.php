<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Dekan</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#FB8C00;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:20px;}
    .stat-card{background:white;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06);border-left:4px solid #3498db;transition:all 0.3s ease;cursor:pointer}
    .stat-card:hover{transform:translateY(-5px);box-shadow:0 8px 16px rgba(0,0,0,0.12)}
    .stat-card h3{color:#7f8c8d;font-size:13px;margin-bottom:8px;text-transform:uppercase}
    .stat-card .number{font-size:28px;font-weight:700;color:#2c3e50}
    .card{background:white;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);margin-bottom:20px}
    .card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #eee}
    table{width:100%;border-collapse:collapse}
    thead{background:#f4f6f7}
    th,td{padding:12px;border-bottom:1px solid #ecf0f1;text-align:left;font-size:14px}
    tbody tr:hover{background:#fbfcfd}
    .badge{display:inline-block;padding:6px 10px;border-radius:999px;font-weight:600;font-size:12px}
    .badge-pending{background:#fff3cd;color:#856404}
    .badge-approved{background:#d4edda;color:#155724}
    .badge-rejected{background:#f8d7da;color:#721c24}
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-approve{background:#27ae60;color:#fff}
    .btn-approve:hover{background:#229954}
    .btn-reject{background:#e74c3c;color:#fff}
    .btn-reject:hover{background:#c0392b}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    .empty-state{text-align:center;padding:40px;color:#7f8c8d}
    .chart-container{position:relative;height:450px;padding:20px}
    .filter-container{display:flex;gap:15px;margin-bottom:20px;flex-wrap:wrap}
    .filter-btn{padding:10px 20px;border-radius:8px;border:2px solid #ddd;background:white;cursor:pointer;font-weight:600;transition:all 0.3s;font-size:14px}
    .filter-btn:hover{border-color:#3498db;color:#3498db;transform:translateY(-2px)}
    .filter-btn.active{background:#3498db;color:white;border-color:#3498db}
    .filter-select{padding:10px 15px;border-radius:8px;border:2px solid #ddd;font-weight:600;cursor:pointer;min-width:200px}
    
    /* Modal */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:20px;border-radius:10px;max-width:800px;width:95%;max-height:85vh;overflow:auto;animation:slideIn 0.3s ease}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #eee;padding-bottom:10px;margin-bottom:10px}
    .detail-row{display:grid;grid-template-columns:200px 1fr;padding:8px 0;border-bottom:1px solid #f4f6f7}
    .detail-label{font-weight:700;color:#7f8c8d}
    .detail-value{color:#2c3e50}
</style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-university"></i> Dashboard Dekan</h2>
    <div></div>
</div>

<div class="container">
    <?php if($this->session->flashdata('success')): ?>
    <div class="card" style="border-left:4px solid #27ae60;margin-bottom:18px">
        <div style="color:#155724;font-weight:700"><?php echo $this->session->flashdata('success'); ?></div>
    </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="card" style="border-left:4px solid #e74c3c;margin-bottom:18px">
        <div style="color:#721c24;font-weight:700"><?php echo $this->session->flashdata('error'); ?></div>
    </div>
    <?php endif; ?>

    <?php
    // Hitung statistik dari database
    $total_all = isset($total_surat) ? (int)$total_surat : 0;
    $approved_count = isset($approved_count) ? (int)$approved_count : 0;
    $rejected_count = isset($rejected_count) ? (int)$rejected_count : 0;
    $pending_count = isset($pending_count) ? (int)$pending_count : 0;
    ?>

    <!-- Statistik ringkas -->
    <div class="stats-grid">
        <div class="stat-card" style="border-left-color:#3498db;" onclick="filterTable('all')">
            <h3><i class="fa-solid fa-folder"></i> Total Pengajuan</h3>
            <div class="number" id="totalAll"><?= $total_all ?></div>
        </div>
        
        <div class="stat-card" style="border-left-color:#27ae60;" onclick="filterTable('approved')">
            <h3><i class="fa-solid fa-check-circle"></i> Disetujui</h3>
            <div class="number" id="approvedCount"><?= $approved_count ?></div>
        </div>
        
        <div class="stat-card" style="border-left-color:#e74c3c;" onclick="filterTable('rejected')">
            <h3><i class="fa-solid fa-times-circle"></i> Ditolak</h3>
            <div class="number" id="rejectedCount"><?= $rejected_count ?></div>
        </div>
        
        <div class="stat-card" style="border-left-color:#f39c12;" onclick="filterTable('pending')">
            <h3><i class="fa-solid fa-clock"></i> Menunggu Persetujuan</h3>
            <div class="number" id="pendingCount"><?= $pending_count ?></div>
        </div>
    </div>

    <!-- Filter Tahun & Status -->
    <div class="filter-container">
        <div>
            <label style="display:block;margin-bottom:5px;font-weight:600;color:#7f8c8d">
                <i class="fa-solid fa-calendar"></i> Filter Tahun
            </label>
            <select class="filter-select" id="tahunSelect" onchange="updateTahun(this.value)">
                <?php 
                    $currentYear = date('Y');
                    $selectedYear = isset($tahun) ? $tahun : $currentYear;
                    for ($y = $currentYear; $y >= $currentYear - 5; $y--): 
                ?>
                    <option value="<?= $y ?>" <?= ($selectedYear == $y ? 'selected' : '') ?>>
                        Tahun <?= $y ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

    </div>

   <!-- Grafik 3D -->
    <div class="card" style="background: linear-gradient(135deg, #ffffffff 0%, #ffffffff 100%);">
        <div class="card-header" style="border-bottom-color: rgba(0, 0, 0, 0.1)">
            <strong style="color: #000000ff"><i class="fa-solid fa-chart-bar"></i> Grafik Pengajuan — Tahun <?= isset($tahun) ? $tahun : date('Y') ?></strong>
        </div>
        <div class="chart-container">
            <canvas id="grafikSurat"></canvas>
        </div>
    </div>

    <!-- Tabel Pengajuan -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Surat</h3>
            <div>
                <span id="filterInfo" style="color:#7f8c8d;font-size:13px">Menampilkan: Semua Data</span>
            </div>
        </div>
        
        <div style="overflow-x:auto">
            <table id="suratTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Penyelenggara</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if (isset($surat_list) && is_array($surat_list) && count($surat_list) > 0): ?>
                        <?php $i = 1; foreach ($surat_list as $item): 
                            // Normalisasi status
                            $st_raw = isset($item['status']) ? trim($item['status']) : '';
                            $st_l = strtolower($st_raw);
                            
                            // Mapping status ke kategori
                            if ($st_l === 'disetujui sekretariat') {
                                $st_key = 'pending';
                                $badge = '<span class="badge badge-pending">Menunggu Persetujuan</span>';
                            } elseif ($st_l === 'disetujui dekan') {
                                $st_key = 'approved';
                                $badge = '<span class="badge badge-approved">Disetujui Dekan</span>';
                            } elseif (in_array($st_l, ['ditolak kk', 'ditolak sekretariat', 'ditolak dekan'])) {
                                $st_key = 'rejected';
                                $badge = '<span class="badge badge-rejected">'.ucwords($st_raw).'</span>';
                            } else {
                                $st_key = 'pending';
                                $badge = '<span class="badge badge-pending">'.ucwords($st_raw).'</span>';
                            }
                            
                            // Format tanggal
                            $tgl_pengajuan = isset($item['tanggal_pengajuan']) && $item['tanggal_pengajuan'] ? date('d M Y', strtotime($item['tanggal_pengajuan'])) : '-';
                            $tgl_kegiatan = isset($item['tanggal_kegiatan']) && $item['tanggal_kegiatan'] ? date('d M Y', strtotime($item['tanggal_kegiatan'])) : '-';
                        ?>
                        <tr data-status="<?= $st_key ?>">
                            <td><?= $i ?></td>
                            <td><strong><?= htmlspecialchars($item['nama_kegiatan'] ?? '-') ?></strong></td>
                            <td><?= htmlspecialchars($item['penyelenggara'] ?? '-') ?></td>
                            <td><?= $tgl_pengajuan ?></td>
                            <td><?= $tgl_kegiatan ?></td>
                            <td><?= htmlspecialchars($item['jenis_pengajuan'] ?? '-') ?></td>
                            <td><?= $badge ?></td>
                            <td>
                                <div style="display:flex;gap:6px">
                                    <button class="btn btn-detail" onclick="showDetail(<?= (int)$item['id'] ?>)" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <?php if ($st_l === 'disetujui sekretariat'): ?>
                                        <button class="btn btn-approve" onclick="approveSurat(<?= (int)$item['id'] ?>)" title="Setujui">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                        <button class="btn btn-reject" onclick="showRejectModal(<?= (int)$item['id'] ?>)" title="Tolak">
                                            <i class="fa-solid fa-times"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; endforeach; ?>
                    <?php else: ?>
                        <tr id="emptyRow">
                            <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
                                <i class="fa-solid fa-inbox" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                                <strong>Belum ada pengajuan</strong>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal" onclick="modalClickOutside(event,'detailModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-alt"></i> Detail Pengajuan</h3>
            <button onclick="closeModal('detailModal')" style="background:none;border:0;font-size:20px;cursor:pointer">&times;</button>
        </div>
        <div id="detailContent"></div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal" onclick="modalClickOutside(event,'rejectModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-ban"></i> Tolak Pengajuan</h3>
            <button onclick="closeModal('rejectModal')" style="background:none;border:0;font-size:20px;cursor:pointer">&times;</button>
        </div>
        <div>
            <p style="margin-bottom:10px;color:#7f8c8d">Berikan alasan penolakan:</p>
            <textarea id="rejectionNotes" rows="5" placeholder="Masukkan alasan penolakan..." style="width:100%;padding:12px;border:2px solid #ddd;border-radius:8px;font-family:inherit;resize:vertical"></textarea>
            <div style="text-align:right;margin-top:12px">
                <button class="btn btn-reject" onclick="confirmReject()">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Penolakan
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Data dari controller
const suratList = <?= isset($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentRejectId = null;

// Update tahun filter
function updateTahun(year) {
    window.location.href = "<?= base_url('dekan?tahun=') ?>" + year;
}

// Filter tabel
function filterTable(status) {
    const rows = document.querySelectorAll('#tableBody tr:not(#emptyRow)');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const filterInfo = document.getElementById('filterInfo');
    
    let visibleCount = 0;
    
    // Update active button
    filterBtns.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.filter === status) {
            btn.classList.add('active');
        }
    });
    
    // Filter rows
    rows.forEach((row, index) => {
        const rowStatus = row.dataset.status;
        if (status === 'all' || rowStatus === status) {
            row.style.display = '';
            visibleCount++;
            // Update nomor urut
            row.querySelector('td:first-child').textContent = visibleCount;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update info
    const statusText = {
        'all': 'Semua Data',
        'pending': 'Menunggu Persetujuan',
        'approved': 'Disetujui',
        'rejected': 'Ditolak'
    };
    filterInfo.textContent = `Menampilkan: ${statusText[status]} (${visibleCount} data)`;
    
    // Show empty state if no results
    const emptyRow = document.getElementById('emptyRow');
    if (visibleCount === 0 && !emptyRow) {
        const tbody = document.getElementById('tableBody');
        const newRow = tbody.insertRow();
        newRow.id = 'emptyRowFiltered';
        newRow.innerHTML = `<td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
            <i class="fa-solid fa-search" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
            <strong>Tidak ada data untuk filter ini</strong>
        </td>`;
    } else if (visibleCount > 0) {
        const filtered = document.getElementById('emptyRowFiltered');
        if (filtered) filtered.remove();
    }
}

// Detail functions
function findSuratById(id) {
    return suratList.find(s => Number(s.id) === Number(id));
}

function showDetail(id) {
    const item = findSuratById(id);
    if (!item) { alert('Data tidak ditemukan'); return; }

    const getVal = (k) => (item[k] !== undefined && item[k] !== null ? item[k] : '-');

    const content = `
        <div>
            <div class="detail-row"><div class="detail-label">Nama Kegiatan:</div><div class="detail-value">${escapeHtml(getVal('nama_kegiatan'))}</div></div>
            <div class="detail-row"><div class="detail-label">Nama Dosen:</div><div class="detail-value">${escapeHtml(getVal('nama_dosen'))}</div></div>
            <div class="detail-row"><div class="detail-label">NIP:</div><div class="detail-value">${escapeHtml(getVal('nip'))}</div></div>
            <div class="detail-row"><div class="detail-label">Tanggal Pengajuan:</div><div class="detail-value">${formatDate(getVal('tanggal_pengajuan'))}</div></div>
            <div class="detail-row"><div class="detail-label">Tanggal Kegiatan:</div><div class="detail-value">${formatDate(getVal('tanggal_kegiatan'))}</div></div>
            <div class="detail-row"><div class="detail-label">Jenis Pengajuan:</div><div class="detail-value">${escapeHtml(getVal('jenis_pengajuan'))}</div></div>
            <div class="detail-row"><div class="detail-label">Penyelenggara:</div><div class="detail-value">${escapeHtml(getVal('penyelenggara'))}</div></div>
            <div class="detail-row"><div class="detail-label">Lingkup:</div><div class="detail-value">${escapeHtml(getVal('lingkup_penugasan'))}</div></div>
            <div class="detail-row"><div class="detail-label">File Eviden:</div><div class="detail-value">${getVal('eviden') ? '<a href="<?= base_url('uploads/') ?>'+escapeHtml(getVal('eviden'))+'" target="_blank" style="color:#3498db"><i class="fa-solid fa-paperclip"></i> '+escapeHtml(getVal('eviden'))+'</a>' : '-'}</div></div>
            ${getVal('catatan_penolakan') && getVal('catatan_penolakan') !== '-' ? '<div class="detail-row"><div class="detail-label">Catatan Penolakan:</div><div class="detail-value" style="color:#e74c3c">'+escapeHtml(getVal('catatan_penolakan'))+'</div></div>' : ''}
            <div style="text-align:right;margin-top:20px;padding-top:15px;border-top:1px solid #eee">
                ${ (item.status && item.status.toLowerCase() === 'disetujui sekretariat') ? 
                    `<button class="btn btn-approve" onclick="approveSurat(${item.id}); closeModal('detailModal')" style="margin-right:8px">
                        <i class="fa-solid fa-check"></i> Setujui
                    </button>
                    <button class="btn btn-reject" onclick="showRejectModal(${item.id}); closeModal('detailModal')">
                        <i class="fa-solid fa-times"></i> Tolak
                    </button>` : '' }
            </div>
        </div>
    `;
    document.getElementById('detailContent').innerHTML = content;
    document.getElementById('detailModal').classList.add('show');
}

function approveSurat(id) {
    if (!confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')) return;
    window.location.href = '<?= base_url("dekan/approve/") ?>' + id;
}

function showRejectModal(id) {
    currentRejectId = id;
    document.getElementById('rejectionNotes').value = '';
    document.getElementById('rejectModal').classList.add('show');
}

function confirmReject() {
    const notes = document.getElementById('rejectionNotes').value.trim();
    if (!notes) { 
        alert('Alasan penolakan harus diisi'); 
        return; 
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("dekan/reject/") ?>' + currentRejectId;

    const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
    const inpCsrf = document.createElement('input'); 
    inpCsrf.type='hidden'; 
    inpCsrf.name=csrfName; 
    inpCsrf.value=csrfHash; 
    form.appendChild(inpCsrf);
    
    const inpNotes = document.createElement('input'); 
    inpNotes.type='hidden'; 
    inpNotes.name='rejection_notes'; 
    inpNotes.value=notes; 
    form.appendChild(inpNotes);
    
    document.body.appendChild(form);
    form.submit();
}

function closeModal(id) {
    document.getElementById(id).classList.remove('show');
}

function modalClickOutside(evt, id) {
    if (evt.target && evt.target.id === id) closeModal(id);
}

function formatDate(d) {
    if (!d || d === '-') return '-';
    const t = new Date(d);
    if (isNaN(t)) return d;
    return t.toLocaleDateString('id-ID', { day:'2-digit', month: 'short', year:'numeric' });
}

function escapeHtml(unsafe) {
    if (unsafe === null || unsafe === undefined) return '-';
    return String(unsafe)
       .replace(/&/g, "&amp;")
       .replace(/</g, "&lt;")
       .replace(/>/g, "&gt;")
       .replace(/"/g, "&quot;")
       .replace(/'/g, "&#039;");
}


// Grafik 3D
const ctx = document.getElementById('grafikSurat').getContext('2d');
const fusionStyle3DPlugin = {
    id: 'fusionStyle3d',
    beforeDatasetsDraw: (chart) => {
        const ctx = chart.ctx;
        chart.data.datasets.forEach((dataset, datasetIndex) => {
            const meta = chart.getDatasetMeta(datasetIndex);
            if (!meta.hidden) {
                meta.data.forEach((bar) => {
                    const x = bar.x, y = bar.y, base = bar.base, width = bar.width, height = base - y;
                    if (height <= 1) return;
                    const offsetX = 15, offsetY = -15;
                    ctx.save();
                    const rightGradient = ctx.createLinearGradient(x + width/2, y, x + width/2 + offsetX, y + offsetY);
                    let darkColor = datasetIndex === 0 ? 'rgba(0, 177, 253, 0.6)' : (datasetIndex === 1 ? 'rgba(0, 177, 253, 0.6)' : 'rgba(192, 57, 43, 0.6)');
                    rightGradient.addColorStop(0, darkColor);
                    rightGradient.addColorStop(1, 'rgba(0, 0, 0, 0.2)');
                    ctx.fillStyle = rightGradient;
                    ctx.beginPath();
                    ctx.moveTo(x + width/2, y);
                    ctx.lineTo(x + width/2 + offsetX, y + offsetY);
                    ctx.lineTo(x + width/2 + offsetX, base + offsetY);
                    ctx.lineTo(x + width/2, base);
                    ctx.closePath();
                    ctx.fill();
                    const topGradient = ctx.createLinearGradient(x - width/2, y, x + width/2 + offsetX, y + offsetY);
                    let lightColor = datasetIndex === 0 ? 'rgba(162, 217, 206, 0.9)' : (datasetIndex === 1 ? 'rgba(200, 247, 197, 0.9)' : 'rgba(245, 183, 177, 0.9)');
                    topGradient.addColorStop(0, lightColor);
                    topGradient.addColorStop(1, 'rgba(255, 255, 255, 0.2)');
                    ctx.fillStyle = topGradient;
                    ctx.beginPath();
                    ctx.moveTo(x - width/2, y);
                    ctx.lineTo(x + width/2, y);
                    ctx.lineTo(x + width/2 + offsetX, y + offsetY);
                    ctx.lineTo(x - width/2 + offsetX, y + offsetY);
                    ctx.closePath();
                    ctx.fill();
                    ctx.restore();
                });
            }
        });
    }
};

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
            {label: "Total", data: <?= json_encode(isset($chart_total) ? $chart_total : array_fill(0,12,0)) ?>, backgroundColor: 'rgba(0, 177, 253, 0.6)', borderColor: 'rgba(4, 146, 207, 0.6)', borderWidth: 2, borderRadius: 6},
            {label: "Disetujui", data: <?= json_encode(isset($chart_approved) ? $chart_approved : array_fill(0,12,0)) ?>, backgroundColor: 'rgba(46, 204, 113, 0.85)', borderColor: 'rgba(46, 204, 113, 1)', borderWidth: 2, borderRadius: 6},
            {label: "Ditolak", data: <?= json_encode(isset($chart_rejected) ? $chart_rejected : array_fill(0,12,0)) ?>, backgroundColor: 'rgba(231, 76, 60, 0.85)', borderColor: 'rgba(231, 76, 60, 1)', borderWidth: 2, borderRadius: 6}
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {legend: {position: 'top', labels: {padding: 20, font: {size: 14, weight: '700'}, color: '#000000ff'}}, tooltip: {backgroundColor: 'rgba(44, 62, 80, 0.95)', padding: 16}},
        scales: {x: {grid: {display: false}, ticks: {color: '#000000ff'}}, y: {beginAtZero: true, grid: {color: 'rgba(12, 7, 7, 0.08)'}, ticks: {color: '#95a5a6'}}},
        animation: {duration: 1800, easing: 'easeInOutQuart'}
    },
    plugins: [fusionStyle3DPlugin]
});
</script>
</body>
</html>