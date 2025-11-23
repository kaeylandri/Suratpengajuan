<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Kaprodi</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#8E44AD;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:20px;}
    .stat-card{background:white;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06);border-left:4px solid #3498db;transition:all 0.3s ease;cursor:pointer;position:relative;}
    .stat-card:hover{transform:translateY(-5px);box-shadow:0 8px 16px rgba(0,0,0,0.12)}
    .stat-card.active{box-shadow:0 0 0 3px rgba(142, 68, 173, 0.3);}
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
    .chart-container{position:relative;height:450px;padding:20px}
    .filter-container{display:flex;gap:15px;margin-bottom:20px;flex-wrap:wrap}
    .filter-btn{padding:10px 20px;border-radius:8px;border:2px solid #ddd;background:white;cursor:pointer;font-weight:600;transition:all 0.3s;font-size:14px}
    .filter-btn:hover{border-color:#8E44AD;color:#8E44AD;transform:translateY(-2px)}
    .filter-btn.active{background:#8E44AD;color:white;border-color:#8E44AD}
    .filter-select{padding:10px 15px;border-radius:8px;border:2px solid #ddd;font-weight:600;cursor:pointer;min-width:200px}
    
    /* Modal Styles */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:0;border-radius:15px;max-width:800px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{background:#8E44AD;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .modal-header h3{margin:0;font-size:18px;font-weight:600}
    .close-modal{background:none;border:0;color:white;font-size:24px;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .close-modal:hover{background:rgba(255,255,255,0.2)}
    
    /* Detail Content Styles */
    .detail-content{padding:25px;max-height:calc(85vh - 80px);overflow-y:auto}
    .detail-section{margin-bottom:25px;background:#f8f9fa;border-radius:12px;padding:20px;border:1px solid #e9ecef}
    .detail-section:last-child{margin-bottom:0}
    .detail-section-title{font-size:16px;font-weight:700;color:#8E44AD;margin-bottom:15px;padding-bottom:10px;border-bottom:2px solid #8E44AD;display:flex;align-items:center;gap:10px}
    .detail-section-title i{font-size:18px}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}
    .detail-row{display:flex;flex-direction:column;margin-bottom:12px}
    .detail-label{font-weight:600;color:#495057;font-size:13px;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.5px}
    .detail-value{color:#212529;font-size:14px;background:white;padding:10px 15px;border-radius:8px;border:1px solid #e9ecef;min-height:40px;display:flex;align-items:center}
    .detail-value-empty{color:#6c757d;font-style:italic}
    
    /* File Evidence Styles */
    .file-evidence{margin-top:10px}
    .file-item{display:flex;align-items:center;gap:12px;padding:12px 15px;background:white;border:1px solid #e9ecef;border-radius:8px;transition:all 0.2s}
    .file-item:hover{background:#f5eef8;border-color:#8E44AD}
    .file-icon{width:24px;height:24px;display:flex;align-items:center;justify-content:center;color:#8E44AD;font-size:16px}
    .file-info{flex:1}
    .file-name{font-weight:600;color:#212529;font-size:14px;word-break:break-word}
    .file-size{font-size:12px;color:#6c757d}
    .download-btn{background:#8E44AD;color:white;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;transition:background 0.2s;display:flex;align-items:center;gap:6px;text-decoration:none}
    .download-btn:hover{background:#7D3C98;color:white;text-decoration:none}
    
    /* Action Buttons in Modal */
    .modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px;padding-top:20px;border-top:1px solid #e9ecef}
    .modal-btn{padding:10px 20px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:14px;transition:all 0.2s;display:flex;align-items:center;gap:8px}
    .modal-btn-close{background:#6c757d;color:white}
    .modal-btn-close:hover{background:#5a6268;transform:translateY(-2px)}
    .modal-btn-approve{background:#27ae60;color:white}
    .modal-btn-approve:hover{background:#229954;transform:translateY(-2px)}
    .modal-btn-reject{background:#e74c3c;color:white}
    .modal-btn-reject:hover{background:#c0392b;transform:translateY(-2px)}
    
    /* Rejection Notes Styles */
    .rejection-notes{background:#fff5f5;border:1px solid #f8d7da;border-radius:8px;padding:20px;margin-top:15px}
    .rejection-notes .detail-label{color:#dc3545;font-weight:700}
    .rejection-notes .detail-value{background:#fff5f5;border-color:#f8d7da;color:#721c24;font-size:14px;line-height:1.5;min-height:auto;padding:12px}
    
    /* Approve Modal Styles */
    .approve-modal-content{background:white;padding:0;border-radius:15px;max-width:550px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    .approve-modal-body{padding:25px}
    .approve-modal-header{background:#8E44AD;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .approve-modal-header h3{margin:0;font-size:18px;font-weight:600}
    .approve-info-box{background:#f5eef8;border:1px solid #8E44AD;border-radius:8px;padding:15px;margin-bottom:20px}
    .approve-info-box strong{color:#8E44AD;display:block;margin-bottom:5px}
    .approve-info-box span{color:#2c3e50;font-weight:600}
    .form-group{margin-bottom:20px}
    .form-group label{display:block;margin-bottom:8px;font-weight:600;color:#2c3e50;font-size:14px}
    .form-control{width:100%;padding:12px 15px;border:2px solid #ddd;border-radius:8px;font-family:inherit;font-size:14px;transition:border-color 0.2s}
    .form-control:focus{outline:none;border-color:#3498db;box-shadow:0 0 0 3px rgba(52, 152, 219, 0.2)}
    .form-hint{color:#7f8c8d;font-size:12px;margin-top:5px;display:flex;align-items:center;gap:5px}
    .approve-modal-actions{display:flex;justify-content:flex-end;gap:12px;margin-top:25px;padding-top:20px;border-top:1px solid #e9ecef}
    .approve-btn{padding:10px 20px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:14px;transition:all 0.2s;display:flex;align-items:center;gap:8px}
    .approve-btn-cancel{background:#95a5a6;color:white}
    .approve-btn-cancel:hover{background:#7f8c8d;transform:translateY(-2px)}
    .approve-btn-submit{background:#27ae60;color:white}
    .approve-btn-submit:hover{background:#229954;transform:translateY(-2px)}
    
    /* Responsive */
    @media (max-width:768px){
        .detail-grid{grid-template-columns:1fr}
        .modal-content{width:95%;margin:10px}
        .detail-content{padding:15px}
        .modal-actions{flex-direction:column}
        .modal-btn{justify-content:center}
        .approve-modal-content{width:95%;margin:10px}
        .approve-modal-body{padding:15px}
        .approve-modal-actions{flex-direction:column}
        .approve-btn{justify-content:center}
    }
</style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-user-tie"></i> Dashboard Kaprodi</h2>
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
    $total_all = isset($total_surat) ? (int)$total_surat : 0;
    $approved_count = isset($approved_count) ? (int)$approved_count : 0;
    $rejected_count = isset($rejected_count) ? (int)$rejected_count : 0;
    $pending_count = isset($pending_count) ? (int)$pending_count : 0;
    ?>

   <!-- Statistik -->
<div class="stats-grid">
    <!-- Total Pengajuan -->
    <div class="stat-card" onclick="window.location.href='<?= base_url('surat/semua') ?>'">
        <h3><i class="fa-solid fa-folder"></i> Total Pengajuan</h3>
        <div class="number"><?= $total_all ?></div>
    </div>
    
    <!-- Disetujui -->
    <div class="stat-card" style="border-left-color:#27ae60;" onclick="window.location.href='<?= base_url('surat/disetujui') ?>'">
        <h3><i class="fa-solid fa-check-circle"></i> Disetujui</h3>
        <div class="number"><?= $approved_count ?></div>
    </div>
    
    <!-- Ditolak -->
    <div class="stat-card" style="border-left-color:#e74c3c;" onclick="window.location.href='<?= base_url('surat/ditolak') ?>'">
        <h3><i class="fa-solid fa-times-circle"></i> Ditolak</h3>
        <div class="number"><?= $rejected_count ?></div>
    </div>
    
    <!-- Menunggu Persetujuan -->
    <div class="stat-card" style="border-left-color:#f39c12;" onclick="window.location.href='<?= base_url('surat/pending') ?>'">
        <h3><i class="fa-solid fa-clock"></i> Menunggu Persetujuan</h3>
        <div class="number"><?= $pending_count ?></div>
    </div>
</div>

    <!-- Filter -->
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
                    <option value="<?= $y ?>" <?= ($selectedYear == $y ? 'selected' : '') ?>>Tahun <?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

    <!-- Grafik 3D -->
    <div class="card" style="background: linear-gradient(135deg, #ffffffff 0%, #f7f7f7ff 100%);">
        <div class="card-header" style="border-bottom-color: rgba(16, 11, 11, 0.1)">
            <strong style="color: #030707ff"><i class="fa-solid fa-chart-bar"></i> Grafik Pengajuan — Tahun <?= isset($tahun) ? $tahun : date('Y') ?></strong>
        </div>
        <div class="chart-container">
            <canvas id="grafikSurat"></canvas>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Surat</h3>
            <div>
                <span id="filterInfo" style="color:#7f8c8d;font-size:13px">Menampilkan: Semua Data (<?= $total_all ?> data)</span>
            </div>
        </div>
        
        <div style="overflow-x:auto">
            <table>
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
                    <?php if(isset($surat_list) && !empty($surat_list)): $no=1; foreach($surat_list as $s): 
                        $st_l = strtolower($s->status);

                        // Tentukan warna berdasarkan kata kunci
                        if (str_contains($st_l, 'setuju') || str_contains($st_l, 'disetujui')) {
                            $st_key = 'approved';
                            $badge = '<span class="badge badge-approved">'.ucwords($s->status).'</span>';

                        } elseif (str_contains($st_l, 'tolak') || str_contains($st_l, 'ditolak')) {
                            $st_key = 'rejected';
                            $badge = '<span class="badge badge-rejected">'.ucwords($s->status).'</span>';

                        } else {
                            // selain itu dianggap pending atau proses
                            $st_key = 'pending';
                            $badge = '<span class="badge badge-pending">'.ucwords($s->status).'</span>';
                        }

                        $tgl_pengajuan = isset($s->created_at) && $s->created_at ? date('d M Y', strtotime($s->created_at)) : '-';
                        $tgl_kegiatan = isset($s->tanggal_kegiatan) && $s->tanggal_kegiatan ? date('d M Y', strtotime($s->tanggal_kegiatan)) : '-';
                    ?>
                    <tr data-status="<?= $st_key ?>">
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($s->nama_kegiatan) ?></strong></td>
                        <td><?= htmlspecialchars($s->penyelenggara) ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s->jenis_pengajuan) ?></td>
                        <td><?= $badge ?></td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-detail" onclick="showDetail(<?= $s->id ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <?php if($s->status == 'pengajuan'): ?>
                                    <button class="btn btn-approve" onclick="approveSurat(<?= $s->id ?>)" title="Setujui">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    <button class="btn btn-reject" onclick="showRejectModal(<?= $s->id ?>)" title="Tolak">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
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
            <h3><i class="fa-solid fa-file-alt"></i> Detail Pengajuan Surat Tugas</h3>
            <button class="close-modal" onclick="closeModal('detailModal')">&times;</button>
        </div>
        <div class="detail-content" id="detailContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="modal" onclick="modalClickOutside(event,'approveModal')">
    <div class="approve-modal-content" onclick="event.stopPropagation()">
        <div class="approve-modal-header">
            <h3><i class="fa-solid fa-check-circle"></i> Setujui Pengajuan</h3>
            <button class="close-modal" onclick="closeModal('approveModal')">&times;</button>
        </div>
        <div class="approve-modal-body">
            <div class="approve-info-box">
                <strong><i class="fa-solid fa-info-circle"></i> Informasi:</strong>
                <span id="approveNamaKegiatan"></span>
            </div>
            
            <form id="approveForm" method="POST" action="">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                
                <div class="form-group">
                    <label for="nomorSurat">
                        <i class="fa-solid fa-file-alt"></i> Nomor Surat <span style="color:#e74c3c">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nomorSurat" 
                        name="nomor_surat" 
                        class="form-control" 
                        placeholder="Contoh: 001/SKT/FT/2025" 
                        required
                        autocomplete="off"
                    >
                    <div class="form-hint">
                        <i class="fa-solid fa-exclamation-circle"></i> Format: 001/SKT/FT/Tahun
                    </div>
                </div>

                <div class="approve-modal-actions">
                    <button type="button" class="approve-btn approve-btn-cancel" onclick="closeModal('approveModal')">
                        <i class="fa-solid fa-times"></i> Batal
                    </button>
                    <button type="submit" class="approve-btn approve-btn-submit">
                        <i class="fa-solid fa-check"></i> Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal" onclick="modalClickOutside(event,'rejectModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-ban"></i> Tolak Pengajuan</h3>
            <button class="close-modal" onclick="closeModal('rejectModal')">&times;</button>
        </div>
        <div style="padding:25px">
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
const suratList = <?= isset($surat_list) && !empty($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentRejectId = null;
let currentApproveId = null;
let currentFilter = 'all';

function updateTahun(year) {
    window.location.href = "<?= base_url('kaprodi?tahun=') ?>" + year;
}

function filterTable(status) {
    const rows = document.querySelectorAll('#tableBody tr:not(#emptyRow)');
    const filterInfo = document.getElementById('filterInfo');
    let visibleCount = 0;
    
    // Update active state of stat cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.classList.remove('active');
    });
    
    rows.forEach((row) => {
        const rowStatus = row.dataset.status;
        if (status === 'all' || rowStatus === status) {
            row.style.display = '';
            visibleCount++;
            row.querySelector('td:first-child').textContent = visibleCount;
        } else {
            row.style.display = 'none';
        }
    });
    
    const statusText = {
        'all': 'Semua Data', 
        'pending': 'Menunggu Persetujuan', 
        'approved': 'Disetujui', 
        'rejected': 'Ditolak'
    };
    
    filterInfo.textContent = `Menampilkan: ${statusText[status]} (${visibleCount} data)`;
    currentFilter = status;
    
    if (visibleCount === 0) {
        const tbody = document.getElementById('tableBody');
        if (!document.getElementById('emptyRowFiltered')) {
            const newRow = tbody.insertRow();
            newRow.id = 'emptyRowFiltered';
            newRow.innerHTML = `
                <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
                    <i class="fa-solid fa-search" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                    <strong>Tidak ada data ${statusText[status].toLowerCase()}</strong>
                </td>`;
        }
    } else {
        const filtered = document.getElementById('emptyRowFiltered');
        if (filtered) filtered.remove();
    }
}

function showDetail(id) {
    fetch(`<?= base_url('kaprodi/getDetailPengajuan/') ?>${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = data.data;
                
                const getVal = (k) => (item[k] !== undefined && item[k] !== null && item[k] !== '' ? item[k] : '-');
                
                // Helper functions
                const formatDate = (dateStr) => {
                    if (!dateStr || dateStr === '-' || dateStr === '0000-00-00') return '-';
                    const date = new Date(dateStr);
                    return date.toLocaleDateString('id-ID', { 
                        day: '2-digit', 
                        month: 'short', 
                        year: 'numeric' 
                    });
                };
                
                const escapeHtml = (unsafe) => {
                    if (unsafe === null || unsafe === undefined || unsafe === '') return '-';
                    return String(unsafe)
                       .replace(/&/g, "&amp;")
                       .replace(/</g, "&lt;")
                       .replace(/>/g, "&gt;")
                       .replace(/"/g, "&quot;")
                       .replace(/'/g, "&#039;");
                };
                
                // Format status dengan badge
                const status = getVal('status');
                let statusBadge = '';
                if (status.toLowerCase().includes('ditolak')) {
                    statusBadge = '<span class="badge badge-rejected" style="margin-left:10px">Ditolak</span>';
                } else if (status.toLowerCase().includes('disetujui')) {
                    statusBadge = '<span class="badge badge-approved" style="margin-left:10px">Disetujui</span>';
                } else {
                    statusBadge = '<span class="badge badge-pending" style="margin-left:10px">Menunggu</span>';
                }

                // Get nama dosen - cek berbagai kemungkinan field
                const namaDosen = getVal('nama_dosen') !== '-' ? getVal('nama_dosen') : 
                                 (getVal('dosen_nama') !== '-' ? getVal('dosen_nama') : 
                                 (getVal('user_name') !== '-' ? getVal('user_name') : '-'));

                // Get NIP - cek berbagai kemungkinan field
                const nip = getVal('nip') !== '-' ? getVal('nip') : 
                           (getVal('dosen_nip') !== '-' ? getVal('dosen_nip') : '-');

                // Parse eviden files - handle both single string and JSON array
                let evidenFiles = [];
                const evidenValue = getVal('eviden');
                
                if (evidenValue !== '-') {
                    try {
                        // Try to parse as JSON first (for multiple files)
                        if (evidenValue.startsWith('[') || evidenValue.startsWith('{')) {
                            const parsed = JSON.parse(evidenValue);
                            if (Array.isArray(parsed)) {
                                evidenFiles = parsed;
                            } else if (parsed.url) {
                                evidenFiles = [parsed.url];
                            }
                        } else {
                            // Single file path or URL
                            evidenFiles = [evidenValue];
                        }
                    } catch (e) {
                        // If not JSON, treat as single file path
                        evidenFiles = [evidenValue];
                    }
                }

                // Generate file evidence HTML
                let fileEvidenceHtml = '';
                if (evidenFiles.length > 0) {
                    fileEvidenceHtml = `
                    <div class="detail-section">
                        <div class="detail-section-title">
                            <i class="fa-solid fa-paperclip"></i> File Evidence
                        </div>
                        <div class="file-evidence">`;
                    
                    evidenFiles.forEach((file, index) => {
                        // Extract filename from URL or path
                        let fileName = file;
                        let fileUrl = file;
                        
                        // Check if it's a full URL (starts with http/https)
                        if (file.startsWith('http://') || file.startsWith('https://')) {
                            fileUrl = file;
                            fileName = file.split('/').pop();
                        } else {
                            // It's a relative path, prepend base_url
                            // Remove leading slash if exists
                            file = file.replace(/^\/+/, '');
                            fileUrl = '<?= base_url() ?>' + file;
                            fileName = file.split('/').pop();
                        }
                        
                        // Get file extension for icon
                        const ext = fileName.split('.').pop().toLowerCase();
                        let fileIcon = 'fa-file';
                        if (ext === 'pdf') fileIcon = 'fa-file-pdf';
                        else if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) fileIcon = 'fa-file-image';
                        else if (['doc', 'docx'].includes(ext)) fileIcon = 'fa-file-word';
                        else if (['xls', 'xlsx'].includes(ext)) fileIcon = 'fa-file-excel';
                        
                        fileEvidenceHtml += `
                            <div class="file-item">
                                <div class="file-icon">
                                    <i class="fa-solid ${fileIcon}"></i>
                                </div>
                                <div class="file-info">
                                    <div class="file-name">${escapeHtml(fileName)}</div>
                                </div>
                                <a href="${escapeHtml(fileUrl)}" target="_blank" class="download-btn">
                                    <i class="fa-solid fa-download"></i> Download
                                </a>
                            </div>`;
                    });
                    
                    fileEvidenceHtml += `
                        </div>
                    </div>`;
                }

                const content = `
                    <div class="detail-section">
                        <div class="detail-section-title">
                            <i class="fa-solid fa-info-circle"></i> Informasi Utama
                        </div>
                        <div class="detail-grid">
                            <div class="detail-row">
                                <div class="detail-label">NAMA KEGIATAN</div>
                                <div class="detail-value">${escapeHtml(getVal('nama_kegiatan'))}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">JENIS PENGAJUAN</div>
                                <div class="detail-value">${escapeHtml(getVal('jenis_pengajuan'))}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">STATUS PENGAJUAN</div>
                                <div class="detail-value" style="display:flex;align-items:center">
                                    ${escapeHtml(status)} ${statusBadge}
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">NOMOR SURAT</div>
                                <div class="detail-value">${escapeHtml(getVal('nomor_surat'))}</div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <div class="detail-section-title">
                            <i class="fa-solid fa-user-tie"></i> Informasi Dosen
                        </div>
                        <div class="detail-grid">
                            <div class="detail-row">
                                <div class="detail-label">NAMA DOSEN</div>
                                <div class="detail-value">${escapeHtml(namaDosen)}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">NIP</div>
                                <div class="detail-value">${escapeHtml(nip)}</div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <div class="detail-section-title">
                            <i class="fa-solid fa-calendar-alt"></i> Informasi Waktu & Tempat
                        </div>
                        <div class="detail-grid">
                            <div class="detail-row">
                                <div class="detail-label">TANGGAL PENGAJUAN</div>
                                <div class="detail-value">${formatDate(getVal('created_at'))}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">TANGGAL KEGIATAN</div>
                                <div class="detail-value">${formatDate(getVal('tanggal_kegiatan'))}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">PENYELENGGARA</div>
                                <div class="detail-value">${escapeHtml(getVal('penyelenggara'))}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">TEMPAT KEGIATAN</div>
                                <div class="detail-value">${escapeHtml(getVal('tempat_kegiatan'))}</div>
                            </div>
                        </div>
                    </div>

                    ${fileEvidenceHtml}

                    ${getVal('catatan_penolakan') && getVal('catatan_penolakan') !== '-' ? `
                    <div class="detail-section rejection-notes">
                        <div class="detail-section-title">
                            <i class="fa-solid fa-exclamation-triangle"></i> Alasan Penolakan
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Catatan Penolakan</div>
                            <div class="detail-value">${escapeHtml(getVal('catatan_penolakan'))}</div>
                        </div>
                    </div>
                    ` : ''}

                    <div class="modal-actions">
                        ${ (item.status && item.status.toLowerCase() === 'pengajuan') ? 
                            `<button class="modal-btn modal-btn-approve" onclick="showApproveModal(${item.id}, '${escapeHtml(item.nama_kegiatan)}'); closeModal('detailModal')">
                                <i class="fa-solid fa-check"></i> Setujui
                            </button>
                            <button class="modal-btn modal-btn-reject" onclick="showRejectModal(${item.id}); closeModal('detailModal')">
                                <i class="fa-solid fa-times"></i> Tolak
                            </button>` : '' }
                        <button class="modal-btn modal-btn-close" onclick="closeModal('detailModal')">
                            <i class="fa-solid fa-times"></i> Tutup
                        </button>
                    </div>
                `;
                
                document.getElementById('detailContent').innerHTML = content;
                document.getElementById('detailModal').classList.add('show');
            } else {
                alert('Gagal memuat detail pengajuan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat data');
        });
}

function showApproveModal(id, namaKegiatan) {
    currentApproveId = id;
    document.getElementById('approveNamaKegiatan').textContent = namaKegiatan;
    document.getElementById('nomorSurat').value = '';
    document.getElementById('approveForm').action = '<?= base_url("kaprodi/approve/") ?>' + id;
    document.getElementById('approveModal').classList.add('show');
    
    // Auto focus ke input nomor surat
    setTimeout(() => {
        document.getElementById('nomorSurat').focus();
    }, 300);
}

function showRejectModal(id) {
    currentRejectId = id;
    document.getElementById('rejectionNotes').value = '';
    document.getElementById('rejectModal').classList.add('show');
}

function approveSurat(id) {
    if (!confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')) return;
    window.location.href = '<?= base_url("kaprodi/approve/") ?>' + id;
}

function confirmReject() {
    const notes = document.getElementById('rejectionNotes').value.trim();
    if (!notes) { 
        alert('Alasan penolakan harus diisi'); 
        return; 
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("kaprodi/reject/") ?>' + currentRejectId;
    
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

// Initialize the table with all data
document.addEventListener('DOMContentLoaded', function() {
    filterTable('all');
});

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